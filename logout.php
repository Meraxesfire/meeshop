<?php
//este codigo interactúa con el botón logout del dashboard.php

session_start();
session_unset(); // Elimina las variables de sesión
session_destroy(); // Destruye la sesión
header("Location:/meeshop/index.php"); // Redirige al login
exit();
?>