<?php 

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED); // Desactiva NOTICE, WARNING y DEPRECATED
require_once __DIR__ . '/../includes/conexion.php';
//LOGICA DE FILTRADO de elementos en la tabla -----------------------------------------------------------------------------
//primero: buscar si hay algun en el input y el select de filtrado



//AQUI SE CAPTURAN LOS DATOS (VALORES) DEL FORMULARIO DEL ALMACEN: Crea la logica para meter los productos en la bdd a traves del formulario de esta misma pagina almacen.php
if ($_SERVER['REQUEST_METHOD']==='POST' && !empty($_POST)) {
        $ean = $_POST['ean'] ??''; // Verifica que existe antes de acceder
        $nombre = $_POST['nombre'] ?? '';
        $categoria =$_POST['categoria'] ?? '';
        $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
        $stock_nuevo = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
        $iva = isset($_POST['iva']) ? floatval($_POST['iva']) : 21;
        //las variables de arriba recogen los datos del formulario de agregar producto

        //ahora la consulta para insertar el nuevo producto en la base de datos
        $sql=" INSERT INTO productos (ean, nombre, categoria, precio, stock, iva) VALUES (?,?,?,?,?,?) 
            ON DUPLICATE KEY UPDATE
            stock = stock + VALUES (stock)";
        
        $stmt = $conn->prepare($sql);//no usamos $conn->query($sql) porque es inseguro ya que alguien podría inyectar código malicioso simplemente escribiendo en el formulario una sentencia como DROP TABLE productos;
            if ($stmt) {
                $stmt->bind_param("sssdid", $ean, $nombre, $categoria, $precio, $stock_nuevo, $iva);//con bind_param evitamos inyecciones SQL porquen estipulamos los tipos de datos que vamos a recibir en cada campo: s=string, d=double, i=integer. tambien vincula las variables a los marcadores de posición ? del prepare.
                if ($stmt->execute()) { 
                    $stmt->close();
                // IMPORTANTE: Si es una petición AJAX, detenemos la ejecución aquí para que no intente redirigir.

                if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    exit('success');
                }
            } 
        }
}



//consultar productos:

$sql="SELECT * FROM productos";
$resultado = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>almacen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/tui1luo.css">
</head>
<body>
    <div>
        <h1 class="titulo">Almacen</h1>
    </div>
    <div>
        <div class="espacio3">
            <label for="buscarProducto" class="tituloBuscar">Buscar producto</label>
            <div id="cajaBusqueda">
                <input class="caja_busqueda" id="buscarProducto" name="busqueda" placeholder="Nombre del producto"></input>
                <button class="botonLupa" data-tooltip="Buscar"><i class="fa-solid fa-magnifying-glass iconoLupa"></i></button>
            </div>
            <div class="tabla_almacen_overflow">
                <table class="tabla_almacen">
                    <thead class="cabeceraTabla">
                        <tr id="primeraFilaTabla">
                            <th class="tituloAlmacen">EAN</th>
                            <th class="tituloAlmacen">Productos</th>
                            <th class="tituloAlmacen">Categoría</th>
                            <th class="tituloAlmacen">PVO</th>
                            <th class="tituloAlmacen">Stock</th>
                            <th class="tituloAlmacen">IVA</th>
                            <th class="tituloAlmacen">PVP</th>
                        </tr>
                    </thead>
                    <tbody class="cuerpoTabla">
    <!--A CONTINUACION INSERCION DE DATOS DE BBDD en filas dentro del cuerpo de la tabla, les doy estilo inline para asegurar el ajuste -->
                    <?php
                    while($row = $resultado->fetch_assoc()): //<----------este pequeño fragmento calcula el iva para el pvp final
                    $pvo=isset($row['precio']) ? floatval($row['precio']) :0;
                    $ivaPorcentaje=isset($row['iva']) ? floatval($row['iva']) : 0;
                    $pvp = $pvo*(1+ ($ivaPorcentaje/100));
                    ?>
                    <tr>
                        <td style="text-align:center;font-size:15px">
                            <?php echo isset($row['EAN']) ? htmlspecialchars($row['EAN']) : '-'; ?>
                        </td>
                        
                        <td class="datoEditable" data-id="<?php echo $row['id']; ?>" data-columna="nombre">
                            <button class="botonEditar"><i class="fa-solid fa-pen-to-square"></i></button>
                            <span class="texto-editable"><?php echo htmlspecialchars($row['nombre']); ?></span>
                        </td>
                        
                        <td class="datoEditable" data-id="<?php echo $row['id']; ?>" data-columna="categoria">
                            <button class="botonEditar"><i class="fa-solid fa-pen-to-square"></i></button>
                            <span class="texto-editable"><?php echo htmlspecialchars($row['categoria']); ?></span>
                        </td>
                        
                        <td class="datoEditable" data-id="<?php echo $row['id']; ?>" data-columna="precio">
                            <button class="botonEditar"><i class="fa-solid fa-pen-to-square"></i></button>
                            <span class="texto-editable"><?php echo number_format($pvo, 2, '.', ''); ?></span>
                        </td>
                        
                        <td><?php echo $row['stock']; ?></td> 
                        
                        <td><?php echo $row['iva']; ?>%</td>
                        
                        <td>
                            <?php echo number_format($pvp, 2, ',', '.') . ' €'; ?>
                        </td>
                    </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>   
        </div>
        <div class="espacio4" style="padding-right:25px;">
            <h2 class="tituloAgregar">Agregar nuevo producto</h2>
            <form class="formAgregarProducto parent" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"><!--Envío la información con POST que es el indicado para escritura en la bbdd -->
                <input class="entradaAgregar child" type="text" name="ean" placeholder=" EAN" required>
                <input class="entradaAgregar child" type="text" name="nombre" placeholder=" Nombre del producto">
                <input class="entradaAgregar child" type="number" step="0.01" name="precio" placeholder=" Precio">
                <input class="entradaAgregar child" type="number" name="iva" placeholder="IVA en %" required>
                <input class="entradaAgregar child" type="number" name="stock" placeholder="Cantidad" required>
                <select class="entradaAgregar child" type="text" name="categoria" placeholder=" Categoria">
                    <option value="ropa">Ropa</option>
                    <option value="accesorios">Accesorios</option>
                    <option value="joyeria">Joyería</option>
                    <option value="zapatos">Zapatos</option>
                </select><br>
                <button class="submitAgregar child" type="submit">Agregar producto</button>
            </form>
        </div>
    </div>
</body>
</html>