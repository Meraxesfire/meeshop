<?php
require_once __DIR__ . "/../includes/conexion.php";
//p y v son como alias para los elementos.
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
        JOIN empleadas e ON v.id_empleada = e.id
        WHERE 1=1";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['fechaInicio'])) {
        $fechaInicio = $conn->real_escape_string($_POST['fechaInicio']);
        $sql .= " AND DATE(v.fecha) >= '$fechaInicio'";
    }
    if (!empty($_POST['fechaFin'])) {
        $fechaFin = $conn->real_escape_string($_POST['fechaFin']);
        $sql .= " AND DATE(v.fecha) <= '$fechaFin'";
    }
    if (!empty($_POST['ean'])) {
        $ean = $conn->real_escape_string($_POST['ean']);
        $sql .= " AND p.EAN = '$ean'";
    }
}

//Ejecución de la consulta concatenada:
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_venta'] . "</td>";
        echo "<td>" . $row['fecha'] . "</td>";
        echo "<td>" . $row['producto'] . "</td>";
        echo "<td>" . $row['empleada'] . "</td>";
        echo "<td>" . $row['total'] . "</td>";
        echo "</tr>";
    }
}

?>