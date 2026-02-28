<?php

//conexion a la bbdd
require_once __DIR__ . '/../includes/conexion.php'; //uso la conexion a la bbdd ya picada en conexion.php

$id =$_POST ['id'] ?? 0; 
$columna = $_POST['columna'] ?? '';
$valor = $_POST['valor'] ?? '';

//whitelist de columnas permitidas por seguridad

$columnasPermitidas = ['nombre', 'categoria', 'precio','iva'];

if (in_array($columna, $columnasPermitidas) && $id > 0) {
    $sql = "UPDATE productos SET $columna = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $valor, $id);

        if ($stmt->execute()) {
            echo "Guardado correctamente";
        } else {
            http_response_code(500);
            echo "Error al guardar";
        }
        $stmt->close();
    } else {
        http_response_code(500);
        echo "Error en la consulta";
    }
} else {
    http_response_code(400);
    echo "Columna no permitida o ID inválido";
}
$conn->close();


/*------------------ESTO de abajo ES INUTIL (CREO)

$sql = "UPDATE productos SET $columna = ? WHERE id = ?";
$stmt = $conn ->prepare($sql);
$stmt->bind_param("si", $valor, $id);
$stmt ->execute();

echo "Guardado correctamente";*/

?>