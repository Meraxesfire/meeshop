 <?php
session_start();
if (isset($_SESSION['empleada'])) {
    header("Location: dashboard.php");
    exit();
}

// Evita que el navegador guarde en caché la página
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<?php
$conexion = new mysqli("localhost", "root", "", "meeshop");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$resultado = $conexion->query("SELECT nombre FROM empresa WHERE id = 1");
$empresa = $resultado->fetch_assoc();
?>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    exit();
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Login-Empresa</title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="https://use.typekit.net/tui1luo.css">
    </head>
    <body class="body_index">

            <img class="logo_login" src="images/logo_cropped_final.png">
            <p class="mensaje_empresa">Hola de nuevo, <?php echo htmlspecialchars($empresa['nombre']); ?></p>
            <form class="formulario" action="login.php" method="POST"> <!--cuando se pulsa el submit envía los datos al archivo /login.php-->
                <input class="entrada" type="text" name="usuario" placeholder=" usuario" required><br>
                <input class="entrada" type="password" name="contraseña" placeholder=" contraseña" required><br>
                <button class="submit" type="submit" onclick="document.getElementById('usuario').innerHTML = '';document.getElementById('contraseña').innerHTML = '';">Login</button>
            </form>

    </body>
    
</html> 