<?php
//conexion con la bbdd
require_once __DIR__ . '/../includes/conexion.php';
$sql = "SELECT 
            v.id AS id_venta,
            v.fecha,
            p.nombre AS producto,
            p.iva,
            e.nombre AS empleada,
            v.total
        FROM ventas v
        JOIN detalle_ventas dv ON v.id = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id
        JOIN empleadas e ON v.id_empleada = e.id";
$resultado = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>informes</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/tui1luo.css">
</head>

<body>
    <h1 class="titulo">Informes de venta</h1>
    <div id="espacioInformes">
        <h2 class="tituloFiltro">Filtros</h2>
        <form method="post" class="formularioInformes"> <!-- TODO: CAMBIAR EL ACTION -->
            <div class="contenedorFiltrosInformes">
                <div class="filtro_fecha">
                    <label for="fechaInicio">Fecha Inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="caja_busqueda_informes">
                    <label for="fechaFin">Fecha Fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="caja_busqueda_informes">
                </div>
                <div class="filtro_ean">
                    <label for="ean">EAN:</label>
                    <input type="number" id="ean" name="ean" class="caja_busqueda_informes">
                </div>
                <button style="margin-bottom:40px;" class="botonLupa" id="botonLupaInformes" data-tooltip="Buscar"
                    type="submit">
                    <i class="fa-solid fa-magnifying-glass iconoLupa"></i>
                </button>

            </div>
        </form>
        <table class="tablaInformesFiltrados">
            <thead>
                <tr>
                    <th class="titulosTablaInformes">ID de venta</th>
                    <th class="titulosTablaInformes">Fecha</th>
                    <th class="titulosTablaInformes">Productos</th>
                    <th class="titulosTablaInformes">Empleada</th>
                    <th class="titulosTablaInformes">Total</th>

                </tr>
            </thead>
            <tbody class="cuerpoTablaInformes">
                <?php
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_venta'] . "</td>";
                    echo "<td>" . $row['fecha'] . "</td>";
                    echo "<td>" . $row['producto'] . "</td>";
                    echo "<td>" . $row['empleada'] . "</td>";
                    echo "<td>" . $row['total'] . "</td>";

                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>