<?php
require_once __DIR__ . '/../includes/conexion.php';
$basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuracion</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($basePath . '/css/styles.css', ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/tui1luo.css">
</head>

<body>
    <?php
    include '../includes/conexion.php';
    ?>
    <h1 class="titulo">Configuracion</h1>
    <div class="espacioConfiguracion">
        <div class="sectorConfiguracion">
            <?php if ($demoSoloLectura): ?>
                <p class="aviso-demo">La gestión de empleadas está desactivada en esta demo.</p>
            <?php else: ?>
            <div class="contenedor-formulario">
                <h2>Registrar Nueva Empleada</h2>
                <form id="formNuevaEmpleada" action="<?php echo htmlspecialchars($basePath . '/pantallas/nueva_empleada.php', ENT_QUOTES, 'UTF-8'); ?>" method="POST" autocomplete="off">
                    <label class="labelFormulario">Nombre Completo:</label>
                    <input class="inputNuevaEmpleada" type="text" name="nombre" required placeholder="Ej: Lucia Gomez" autocomplete="name">
                    <label class="labelFormulario">Nombre de Usuario:</label>
                    <input class="inputNuevaEmpleada" type="text" name="usuario_nuevo" required placeholder="Ej: LuciaG" autocomplete="off">
                    <br>
                    <label class="labelFormulario">Contraseña:</label>
                    <input class="inputNuevaEmpleada" type="password" name="pass_nueva" required autocomplete="new-password">

                    <button type="submit" class="btn-guardar">Dar de Alta</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>