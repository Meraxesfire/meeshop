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
            <form id="formDeFiltroVenta">
                <div class="busquedaProductos">
                    <p class="tituloBuscar">Buscar producto</p>
                    <div class="contenedorInputLupa">
                        <input class="caja_busqueda"name="busquedaInput" placeholder="Nombre del producto"></input>
                        <button class="botonLupa" id="botonLupa" data-tooltip="Buscar" type="submit"><i class="fa-solid fa-magnifying-glass iconoLupa"></i></button>
                    </div>
                    <div class="sectorFiltroVentas">
                        <select class="select_busqueda" id="buscarCategoria" name="busquedaSelect">
                        <option value="" disabled selected hidden>Elige una categoría de filtro</option> <!--"disabled selected hidden" hace que aparezca como un placeholder-->
                        <option value="ropa">Ropa</option>
                        <option value="accesorios">Accesorios</option>
                        <option value="joyeria">Joyería</option>
                        <option value="zapatos">Zapatos</option>
                        </select>
                        <button class="botonLupa" id="botonLupa" data-tooltip="Buscar" type="submit"><i class="fa-solid fa-magnifying-glass iconoLupa"></i></button>
                    </div>
                </div>
                <div class="menuProductos">
                    <p class="tituloproductos">Productos</p>
                    
                </div>
                
            </form>


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
                <tbody id="cuerpoTablaVenta">
                    <?php //En este fragmento se inserta dinámicamente los elementos del alamacen en la tabla
                        while($row = $resultado->fetch_assoc()): 
                                $pvo=isset($row['precio']) ? floatval($row['precio']) :0;
                                $ivaPorcentaje=isset($row['iva']) ? floatval($row['iva']) : 0;
                                $pvp = $pvo*(1+ ($ivaPorcentaje/100));         //este pequeño fragmento calcula el iva para el pvp final
                                ?>
                                <tr class="filaVentas">
                                    <td class="datoEditableVentas">
                                        <span class="textoVentas"><?php echo isset($row['EAN']) ? htmlspecialchars($row['EAN']) : '-'; ?></span>
                                    </td>
                                    <td class="datoEditableVentas">
                                        <span class="textoVentas"><?php echo htmlspecialchars($row['nombre']); ?></span>
                                    </td>
                                    <td class="datoEditableVentas">
                                        <span class="textoVentas"><?php echo htmlspecialchars($row['categoria']); ?></span>
                                    </td>  
                                    <td class="datoEditableVentas" >
                                        <span class="textoVentas"><?php echo number_format($pvo, 2, '.', ''); ?></span>
                                    </td>
                                    <td class="datoEditableVentas"><?php echo $row['stock']; ?></td> 
                                    <td class="datoEditableVentas"><?php echo $row['iva']; ?>%</td>
                                    <td class="datoEditableVentas">
                                        <?php echo number_format($pvp, 2, ',', '.') . ' €'; ?>
                                    </td>
                                    <td style="padding: 5px; width: 80px;">
                                        <button id="botonSumar" class="botonAnadirProducto" style="background-color:rgba(219,145,0,0.7); border:none; color:white; padding:10px 15px; border-radius: 15px; font-size:23px;">+</button>
                                    </td>
                                </tr>
                                    <?php endwhile; ?>               
                </tbody>
            </table>
            <!--Aquí se agregan de forma dinámica todos los elementos de la tabla Productos filtrados segun su columna categoría: -->
        </div>
    </div>
        <div class ="espacio2"> 
            <p class="tituloVenta">Venta</p>
            <div class="zonaVenta">
                <table class="espacioVenta">
                    <thead>
                        <th class="tituloAlmacenVentas">Cantidad</th>
                        <th class="tituloAlmacenVentas">EAN</th>
                        <th class="tituloAlmacenVentas">Productos</th>
                        <th class="tituloAlmacenVentas">Categoría</th>
                        <th class="tituloAlmacenVentas">PVO</th>
                        <th class="tituloAlmacenVentas">IVA</th>
                        <th class="tituloAlmacenVentas">PVP</th>
                    </thead>
                    <tbody id="cuerpoEspacioVenta">
                        <tr>
                            <td> 
                            </td>
                            <td>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    <script src="javascript/venta.js"></script>
</body>
    </html>