<?php
$host = "localhost";
$usuario = "root";
$contraseña="";
$base_datos ="meeshop";

$conn = new mysqli($host,$usuario,$contraseña,$base_datos);

//Verificar la conexion
if($conn->connect_error){
        die("Conexión fallida: ". $conn->connect_error);
}


//Esto de arriba es para que cualquier página PHP que necesite usar la base de datos, pueda hacerlo escribiendo: require_once "includes/conexion.php";
//y hacer consultas con: $sql = "SELECT * FROM productos";
//$resultado = $conn->query($sql);

?>
