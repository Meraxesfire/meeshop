<?php
require_once __DIR__ . '/../includes/conexion.php';

session_start();

//en este archivo declaro la conexion con la bbdd para sacar datos de la tabla empleada y para meter datos en las tablas ventas y detalles_ventas.
//lo hago en un php a parte por seguridad para evitar debilidades del manejo de front con la bbdd

//El valor de FECHA no lo envío a base de datos porque en la tabla ventas, el atributo fecha tiene puesta un default current_ttimestamp() que automaticamente introduce la hora

//El valor de TOTAL se calcula AQUI, este archivo recibe una lista de ID de productos y las cantidades.
//hace un bucle que itera sobre productos y saca el pvp de cada producto que este en la lista de productos que estenm en cada tr del espacio de carrito.
//para multiplicarlo por la cantidad  y guardamos todo en la variable $total_real, que es la que se inserta en la tabla ventas.

//----RECIBIR EL JSON DE VENTA.JS----
$input = json_decode(file_get_contents('php://input'), true);//aquí vienen los datos del JS (venta.js)
$productos = $input['productos'];
//Extraer el valor de la id_empleada: este valor vive en la variable superGlobal $_SESSION
$id_empleada = $_SESSION['empleada']['id'] ?? 1; //si no existe la id_empleada, se le asigna 1


//EMPEZAR TRANSACCION DE INFO. Se hace transaction para que sea segura (si falla una insercion, se cancelan todas)
$conn->begin_transaction();

//CALCULO DE TOTALES y preparar la cabecera
try {
    $totalCalculado = 0;
    $sqlVenta = "INSERT INTO ventas (id_empleada, total) VALUES (?, ?)";
    $stmt = $conn->prepare($sqlVenta);
    $stmt->bind_param("id", $id_empleada, $totalCalculado);
    $stmt->execute();

    $idVentaGenerada = $conn->insert_id;
    file_put_contents(__DIR__ . '/debug_venta.txt', "\nID venta generada: " . $idVentaGenerada, FILE_APPEND);

    $sqlDetalle = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, subtotal) VALUES (?, ?, ?, ?)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    foreach ($productos as $producto) {
        $id_producto = $producto['id'];
        $cantidadDetalle = $producto['cantidad'];
        file_put_contents(__DIR__ . '/debug_venta.txt', "\nProcesando producto id: " . $id_producto, FILE_APPEND);

        $res = $conn->query("SELECT precio, iva FROM productos WHERE id = $id_producto");
        $p = $res->fetch_assoc();
        file_put_contents(__DIR__ . '/debug_venta.txt', "\nDatos producto: " . print_r($p, true), FILE_APPEND);

        $ivaVal = $p['iva'] ?? 0;
        $pvpDetalle = $p['precio'] * (1 + ($ivaVal / 100));
        $subtotalDetalle = $cantidadDetalle * $pvpDetalle;
        $totalCalculado += $subtotalDetalle;

        $stmtDetalle->bind_param("iiid", $idVentaGenerada, $id_producto, $cantidadDetalle, $subtotalDetalle);
        $stmtDetalle->execute();
        file_put_contents(__DIR__ . '/debug_venta.txt', "\nDetalle insertado", FILE_APPEND);

        $sqlStock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
        $stmtStock = $conn->prepare($sqlStock);
        $stmtStock->bind_param("ii", $cantidadDetalle, $id_producto);
        $stmtStock->execute();
        file_put_contents(__DIR__ . '/debug_venta.txt', "\nStock actualizado", FILE_APPEND);
    }

    $sqlUpdateTotal = "UPDATE ventas SET total = ? WHERE id = ?";
    $stmtTotal = $conn->prepare($sqlUpdateTotal);
    $stmtTotal->bind_param("di", $totalCalculado, $idVentaGenerada);
    $stmtTotal->execute();
    file_put_contents(__DIR__ . '/debug_venta.txt', "\nTotal actualizado: " . $totalCalculado, FILE_APPEND);

    $conn->commit();
    file_put_contents(__DIR__ . '/debug_venta.txt', "\nCOMMIT realizado", FILE_APPEND);
    echo json_encode(["success" => true, "id_venta" => $idVentaGenerada]);

} catch (Exception $e) {
    $conn->rollback();
    file_put_contents(__DIR__ . '/debug_venta.txt', "\nERROR: " . $e->getMessage(), FILE_APPEND);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}


?>