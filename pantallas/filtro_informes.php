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
        $sql .= " AND v.fecha >= DATE_FORMAT('$fechaInicio', '%Y-%m-%d')";
    }
    if (!empty($_POST['fechaFin'])) {
        $fechaFin = $conn->real_escape_string($_POST['fechaFin']);
        // Agregar 1 día para incluir todo el día final
        $sql .= " AND v.fecha < DATE_ADD(DATE('$fechaFin'), INTERVAL 1 DAY)";
    }
    if (!empty($_POST['ean'])) {
        $ean = $conn->real_escape_string($_POST['ean']);
        $sql .= " AND p.EAN = '$ean'";
    }
}

//Ejecución de la consulta concatenada:
$resultado = $conn->query($sql);

// Verificar si hay errores en la consulta
if (!$resultado) {
    echo "Error en la consulta: " . $conn->error;
    exit;
}

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