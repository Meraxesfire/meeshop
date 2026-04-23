<?php
require_once __DIR__ . '/../includes/conexion.php';
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuracion</title>
    <link rel="stylesheet" href="../css/styles.css">
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
            <div class="contenedor-formulario">
                <h2>Registrar Nueva Empleada</h2>
                <form action="/meeshop/pantallas/nueva_empleada.php" method="POST">
                    <label class="labelFormulario">Nombre Completo:</label>
                    <input class="inputNuevaEmpleada" type="text" name="nombre" required placeholder="Ej: Lucia Gomez">
                    <label class="labelFormulario">Nombre de Usuario:</label>
                    <input class="inputNuevaEmpleada" type="text" name="usuario_nuevo" required
                        placeholder="Ej: LuciaG">
                    <label class="labelFormulario">Contraseña:</label>
                    <input class="inputNuevaEmpleada" type="password" name="pass_nueva" required>

                    <button type="submit" class="btn-guardar">Dar de Alta</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>