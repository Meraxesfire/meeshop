<?php
require_once __DIR__ . '/../includes/conexion.php';
$basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
$soloLectura = $demoSoloLectura ? ' disabled' : ''; 
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
    <h1 class="titulo">Configuracion</h1>
    <div class="espacioConfiguracion">
        <div class="sectorConfiguracion">
            <?php if ($demoSoloLectura): ?>
                <p class="aviso-demo">La gestión de empleadas está desactivada en esta demo. Los campos se muestran solo a modo de ejemplo.</p>
            <?php endif; ?>
            <div class="contenedor-formulario">
                <h2>Registrar Nueva Empleada</h2>
                <form id="formNuevaEmpleada" action="<?php echo htmlspecialchars($basePath . '/pantallas/nueva_empleada.php', ENT_QUOTES, 'UTF-8'); ?>" method="POST" autocomplete="off">
                    <label class="labelFormulario">Nombre Completo:</label>
                    <input class="inputNuevaEmpleada" type="text" name="nombre" required placeholder="Ej: Lucia Gomez" autocomplete="name"<?php echo $soloLectura; ?>>
                    <label class="labelFormulario">Nombre de Usuario:</label>
                    <input class="inputNuevaEmpleada" type="text" name="usuario_nuevo" required placeholder="Ej: LuciaG" autocomplete="off"<?php echo $soloLectura; ?>>
                    <br>
                    <label class="labelFormulario">Contraseña:</label>
                    <input class="inputNuevaEmpleada" type="password" name="pass_nueva" required autocomplete="new-password"<?php echo $soloLectura; ?>>

                    <button type="submit" class="btn-guardar"<?php echo $soloLectura; ?>>Dar de Alta</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>