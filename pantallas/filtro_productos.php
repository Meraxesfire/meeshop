<?php
//conectamos con archivo que conecta a la bdd
require_once __DIR__. '/../includes/conexion.php';
//CONSULTA DE PRODUCTOS Y FILTRO POR NOMBRE, EAN Y CATEGORIA----------
// 1. Empezamos con la base (esta sirve para TODO: con o sin filtro)
$sql = "SELECT * FROM productos WHERE 1=1";

// 2. Si hay algo por GET (búsqueda), añadimos las piezas al puzzle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtro por EAN o Nombre (asumiendo que quieres buscar en ambos)
    if (!empty($_POST['busquedaInput'])) {
        $busqueda = $conn->real_escape_string($_POST['busquedaInput']);//real_escape_string hace que 
        $sql .= " AND (ean LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%')";
    }
    // Filtro por Categoría
    if (!empty($_POST['busquedaSelect'])) {
        $cat = $conn->real_escape_string($_POST['busquedaSelect']);
        $sql .= " AND categoria = '$cat'";
    }
}
// 3. UNA SOLA EJECUCIÓN.
$resultado = $conn->query($sql);
    if($resultado -> num_rows>0){
               
        while($row =  $resultado->fetch_assoc()){

            $pvo=isset($row['precio']) ? floatval($row['precio']) :0; //con esto de nuevo calculamos de forma dinamica el iva en la ultima celda
            $ivaPorcentaje=isset($row['iva']) ? floatval($row['iva']) : 0;
            $pvp = $pvo*(1+ ($ivaPorcentaje/100));
            //pintamos la tabla editada con los datos traidos en el .text que viene del servidor y que va al js de dashboard.php
            echo "<tr>";
            echo "<td>".$row['EAN']."</td>";
            echo "<td>".$row['nombre']."</td>";
            echo "<td>".$row['categoria']."</td>";
            echo "<td>".$row['precio']."</td>";
            echo "<td>".$row['stock']."</td>";
            echo "<td>".$row['iva']."</td>";
            echo "<td>".number_format($pvp, 2, ',', '.') . ' €'."</td>";
            echo "<tr>";
        }
    }
?>