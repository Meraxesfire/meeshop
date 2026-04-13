<?php
require_once __DIR__ . '/../includes/conexion.php';
session_start();

//en este archivo declaro la conexion con la bbdd para sacar datos de la tabla empleada y para meter datos en las tablas ventas y detalles_ventas.
//lo hago en un php a parte por seguridad para evitar debilidades del manejo de front con la bbdd

//Extraer el valor de la id_empleada: este valor vive en la variable superGlobal $_SESSION
$id_empleada = $_SESSION['empleada']['id']; //este dato será el que extraigo para la empleada, el primer parametro indica la key, el lugar donde esta el dato que buscamos, el segundo parametro indica el parametro que buscamos.

//El valor de fecha no lo envío a base de datos porque en la tabla ventas, el atributo fecha tiene puesta un default current_ttimestamp() que automaticamente introduce la hora

//El valor de total se calcula AQUI, este archivo recibe una lista de ID de productos y las cantidades.
//hace un bucle que itera sobre productos y saca el pvp de cada producto que este en la lista de productos que estenm en cada tr del espacio de carrito.
//para multiplicarlo por la cantidad  y guardamos todo en la variable $total_real, que es la que se inserta en la tabla ventas.

//----RECIBIR EL JSON DE VENTA.JS----
$input = json_decode(file_get_contents('php://input'), true);//aquí vienen los datos del JS (venta.js)
$productos = $input['productos'];
$id_empleada = $_SESSION['empleada']['id'] ?? 1; //si no existe la id_empleada, se le asigna 1


//EMPEZAR TRANSACCION DE INFO. Se hace transaction para que sea segura (si falla una insercion, se cancelan todas)
$conn->begin_transaction();

//CALCULO DE TOTALES y preparar la cabecera
try {
    //totales:
    $totalFinal = 0;
    foreach ($productos as $producto) {
        $idItem = $producto['id'];
        $res = $conn->query("SELECT precio, iva FROM productos WHERE id= $idItem");
        $p = $res->fetch_assoc();//esto es un array con los datos de cada producto (precio e iva)
        $ivaVal = $p['iva'] ?? 0;
        $pvp = $p['precio'] * (1 + ($ivaVal / 100));
        $totalCalculado += ($pvp * $producto['cantidad']);
    }

    //CREAR CABECERA (Inserción en tabla VENTAS)
    //No envia ni ID es autoincrement ni fecha la fecha es default
    $sqlVenta = "INSERT INTO ventas (id_empleada, total) VALUES (?,?)"; //sentencia de consulta sql para meter daos en bdd
    $stmt = $conn->prepare($sqlVenta); //Estp prepara la consulta para evitar inyecciones sql.
    $stmt->bind_param("id", $id_empleada, $totalCalculado);
    $stmt->execute(); //ejecuta consulta

    //OBTENGO ID DEL REGISTRO INSERTADO EN VENTAS
    $idVentaGenerada = $conn->insert_id;

    //AHORA SE INSERTA EN LA TABLA DETALLE VENTAS:
    $sqlDetalle = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, subtotal) VALUES (?, ?, ?, ?)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    //Foreach para iterar en los detalles de la venta realizada.
    foreach ($productos as $producto) {
        $idVentaDetalle = $producto['id'];
        $cantidadDetalle = $producto['cantidad'];
        $id_producto = $producto['id'];
        $pvpDetalle = $p['precio'] * (1 + ($p['iva'] / 100)); //$p es una variable temporalque toma los datos del producto
        $subtotalDetalle = $cantidadDetalle * $pvpDetalle;

        $stmtDetalle->bind_param("iiid", $idVentaGenerada, $id_producto, $cantidadDetalle, $subtotalDetalle);
        $stmtDetalle->execute();

        //RESTO PRODUCTOS DEL STOCK - SENTENCIA PARA MODIFICAR STOCK EN BBDD
        $sqlStock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
        $stmtStock = $conn->prepare($sqlStock);
        $stmtStock->bind_param("ii", $cantidadDetalle, $id_producto);
        $stmtStock->execute();

    }

    $conn->commit();//aqui se guarda todo lo realizado en la transaccion
    echo json_encode(["success" => true, "id_venta" => $idVentaGenerada]);


} catch (Exception $e) {
    $conn->rollback(); //si algo falla hace rollback a la transacción y no envia NADA.
    echo json_encode(["success" => false, "error" => $e->getMessage()]);//json_encode, traduce el 
    //texto plano del json que viene y lo transforma en un array asociativo para que php 
    //lo pueda entender.
}


?>