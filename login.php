<?php
//este codigo procesa los datos del formulario redirigidos desde index.php


session_start();
require_once 'includes/conexion.php';//incluye el archivo donde está la conexion a la base de datos (conexion.php):


//recogida de datos del formulario con metodo POST:
$usuario= $_POST['usuario']??'';
$contrasena =$_POST['contraseña'];


//consulta para buscar a empleada por nombre. ? sustiye el valor de $usuario usando bind_param():
$sql="SELECT * FROM empleadas WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt ->bind_param("s", $usuario); // "s" indica que el valor que se va a pasar es un string
$stmt -> execute();
$resultado = $stmt->get_result();

//verificar si hay empleada coincidente:
if ($resultado->num_rows === 1){
    $empleada = $resultado ->fetch_assoc();
        if($contrasena  ===$empleada['contraseña']){ /*Compara la contraseña que escribió el usuario con la guardada en la base de datos.
                                                    IMPORTANTE: Esto funciona si las contraseñas están guardadas en texto plano, pero lo recomendable es 
                                                     encriptarlas con password_hash() y password_verify() (podemos hacer eso más adelante ).*/
            $_SESSION['empleada']=$empleada;
            header("Location: dashboard.php");
            exit();

        }
            else{
                echo "contraseña incorrecta";
            }
} 
    else { 
        echo "usuario no encontrado";
    }

?>