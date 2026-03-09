<?php
//conexion con la bdd
require_once __DIR__.'/../includes/conexion.php';
$sql_inicial = "SELECT * FROM productos";
$resultado = $conn->query($sql_inicial); 
?>
<?php
session_start();
//Si no hay sesión activa, redirige al login:
if (!isset($_SESSION['empleada'])){
    header("location:index.php");
    exit();
}

$empleada=$_SESSION['empleada'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de venta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/tui1luo.css">
</head>
<body>
    <div>
        <h1 class="titulo">Punto de venta</h1>
    </div>
    <div class= "contenido_venta">   
        <div class="espacio1">
            <div class="busquedaProductos">
                <p class="tituloBuscar">Buscar producto</p>
                <div class="contenedorInputLupa">
                    <input class="caja_busqueda"name="busqueda" placeholder="Nombre del producto"></input>
                    <button class="botonLupa" data-tooltip="Buscar"><i class="fa-solid fa-magnifying-glass iconoLupa"></i></button>
                </div>
            </div>
            <div class="menuProductos">
                <p class="tituloproductos">Productos</p>
                <div class="burbujas_productos">
                    <button class="categoria catinicial">Ropa</button>
                    <button class="categoria">Accesorios</button>
                    <button class="categoria">Joyería</button>
                    <button class="categoria catfinal">Zapatos</button>
                </div>
            </div>
<div class="zonaProductosFiltrados">
<table>
    <thead>
        <tr>  
            <th class="tituloAlmacenVentas">EAN</th>
            <th class="tituloAlmacenVentas">Productos</th>
            <th class="tituloAlmacenVentas">Categoría</th>
            <th class="tituloAlmacenVentas">PVO</th>
            <th class="tituloAlmacenVentas">Stock</th>
            <th class="tituloAlmacenVentas">IVA</th>
            <th class="tituloAlmacenVentas">PVP</th>
        </tr>
    </thead>
    <tbody>
        <?php //En este script se inserta dinámicamente los elementos del alamacen en la tabla
            while($row = $resultado->fetch_assoc()): 
                    $pvo=isset($row['precio']) ? floatval($row['precio']) :0;
                    $ivaPorcentaje=isset($row['iva']) ? floatval($row['iva']) : 0;
                    $pvp = $pvo*(1+ ($ivaPorcentaje/100));         //este pequeño fragmento calcula el iva para el pvp final
                    ?>
                    <tr class="filaVentas">
                        <td class="datoEditableVentas">
                            <span class="texto-editable-ventas"><?php echo isset($row['EAN']) ? htmlspecialchars($row['EAN']) : '-'; ?></span>
                        </td>
                        <td class="datoEditableVentas"data-id="<?php echo $row['id']; ?>" data-columna="nombre">
                            <span class="texto-editable-ventas"><?php echo htmlspecialchars($row['nombre']); ?></span>
                        </td>
                        <td class="datoEditableVentas" data-id="<?php echo $row['id']; ?>" data-columna="categoria">
                            <span class="texto-editable-ventas"><?php echo htmlspecialchars($row['categoria']); ?></span>
                        </td>  
                        <td class="datoEditableVentas" data-id="<?php echo $row['id']; ?>" data-columna="precio">
                            <span class="texto-editable-ventas"><?php echo number_format($pvo, 2, '.', ''); ?></span>
                        </td>
                        <td class="datoEditableVentas"><?php echo $row['stock']; ?></td> 
                        <td class="datoEditableVentas"><?php echo $row['iva']; ?>%</td>
                        <td class="datoEditableVentas">
                            <?php echo number_format($pvp, 2, ',', '.') . ' €'; ?>
                        </td>
                        <td style="padding: 5px; width: 80px;">
                            <div style="display: flex; align-items: center; height: 25px; border: 1px solid #e2e8f0; border-radius: 4px; overflow: hidden; background: white;">
                                <!-- Botón Menos -->
                                <button onclick="this.nextElementSibling.stepDown()" 
                                style="width: 25px; height: 100%; border: none; color:white; background:rgba(219, 145, 0, 0.7); color: white; cursor: pointer; display: flex; align-items: center; justify-content:center; font-weight: bold; font-size: 14px; padding: 0;">
                                −
                                </button>
                                <!-- Input Numero -->
                                <input type="number" value="1" min="0" 
                                style="width: 30px; height: 100%; border: none; text-align: center; font-size: 12px; color: #334155; outline: none; -moz-appearance: textfield; -webkit-appearance: none; margin: 0;">
                                <!-- Botón Más -->
                                <button onclick="this.previousElementSibling.stepUp()" 
                                style="width: 25px; height: 100%; border: none; color:white; background:rgba(219, 145, 0, 0.7); color: white; cursor: pointer; display: flex; align-items: center; justify-content:center; font-weight: bold; font-size: 14px; padding: 0;">
                                +
                                </button>
                            </div>

                            <style>
                                /* Esto quita las flechitas del navegador incluso si Tailwind falla */
                                input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
                                input[type=number] {-moz-appearance: textfield;}
                            </style>
                            </td>
                    </tr>
                        <?php endwhile; ?>
    </tbody>
</table>

<!--Aquí se agregan de forma dinámica todos los elementos de la tabla Productos filtrados segun su columna categoría: -->
</div>
        </div>
        <div class ="espacio2">
            <p>Venta</p>
        </div>
    </div>


</body>
</html>

