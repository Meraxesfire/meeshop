<?php
require_once __DIR__ . '/../includes/conexion.php';
session_start();

$user = $_POST['usuario_nuevo'] ?? '';
$pass = $_POST['pass_nueva'] ?? '';

if (empty($user) || empty($pass)) {
    die("Error: Rellena todos los campos.");
}

// VALIDACIÓN: necesito que la combinación de datos no exista ya, para evitar duplicados.
$stmt = $conn->prepare("SELECT id FROM empleadas WHERE usuario = ? AND contraseña = ?");
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    // Si encuentra registros, es que ya existe
    echo "<script>alert('Error: Esta empleada ya existe en el sistema.'); window.history.back();</script>";
} else {
    // Si no existe, la inserta
    $nombre_empleada = $_POST['nombre'] ?? '';
    $id_empresa = $_SESSION['empleada']['id_empresa'] ?? 1; // Mantenemos la empresa de la sesión actual

    $insert = $conn->prepare("INSERT INTO empleadas (nombre, usuario, contraseña, id_empresa) VALUES (?, ?, ?, ?)");
    $insert->bind_param("sssi", $nombre_empleada, $user, $pass, $id_empresa);

    if ($insert->execute()) {
        // Ahora se redirige a la pantalla que quiera, para así confirmar y volver a empezar.
        header("Location: /meeshop/dashboard.php");
    } else {
        echo "Error al insertar: " . $conn->error;
    }
}
?>