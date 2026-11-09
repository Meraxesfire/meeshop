<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = getenv('MYSQLHOST') ?: 'localhost';
$usuario = getenv('MYSQLUSER') ?: 'root';
$contraseña = getenv('MYSQLPASSWORD') ?: '';
$base_datos = getenv('MYSQLDATABASE') ?: 'meeshop_test';
$puerto = (int) (getenv('MYSQLPORT') ?: 3306);
$demoSoloLectura = filter_var(getenv('MEESHOP_DEMO_READ_ONLY') ?: 'false', FILTER_VALIDATE_BOOLEAN);

try {
    $conn = new mysqli($host, $usuario, $contraseña, $base_datos, $puerto);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('Meeshop database connection failed: ' . $e->getMessage());
    http_response_code(503);
    exit('No se pudo conectar con la base de datos.');
}

function meeshop_require_write_access(): void
{
    if (!filter_var(getenv('MEESHOP_DEMO_READ_ONLY') ?: 'false', FILTER_VALIDATE_BOOLEAN)) {
        return;
    }

    http_response_code(403);
    if (str_contains($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'error' => 'La demo es de solo lectura.']);
    } else {
        header('Content-Type: text/plain; charset=utf-8');
        echo 'La demo es de solo lectura.';
    }
    exit;
}

//Esto de arriba es para que cualquier página PHP que necesite usar la base de datos, pueda hacerlo escribiendo: require_once "includes/conexion.php";
//y hacer consultas con: $sql = "SELECT * FROM productos";
//$resultado = $conn->query($sql);
?>
