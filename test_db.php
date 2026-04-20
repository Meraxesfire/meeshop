<?php
require 'c:/xampp/htdocs/meeshop/includes/conexion.php';
$tables = ['ventas', 'detalle_ventas', 'productos', 'empleadas'];
foreach ($tables as $t) {
    echo "\nTable: $t\n";
    $res = $conn->query("DESCRIBE $t");
    if($res) {
        while($row = $res->fetch_assoc()) {
            echo $row['Field'] . ' - ' . $row['Type'] . "\n";
        }
    }
}
