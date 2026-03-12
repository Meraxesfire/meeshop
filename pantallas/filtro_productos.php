<?php
//conectamos con archivo que conecta a la bdd
require_once __DIR__. '/../includes/conexion.php';
//CONSULTA DE PRODUCTOS Y FILTRO POR NOMBRE, EAN Y CATEGORIA-----------------------------------------------------

// 1) CONSULTA SQL GENERAL: esta sirve para TODO: con o sin filtro
$sql = "SELECT * FROM productos WHERE 1=1";//1 siempre es igual a 1, esta condición siempre es verdadera. Prmite añadir más condiciones con AND de forma dinámica sin preocuparnos de si es la primera condición o no.

// 2) Si hay algo por POST, lo añadimos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {//Server es un array que contiene info del servidor y la petición. REquest method busca segun el methodo de envio 
    // Filtro por EAN o Nombre (asumiendo que quieres buscar en ambos)------
    if(!empty($_POST['busquedaInput'])) {
        $busqueda = $conn->real_escape_string($_POST['busquedaInput']); //real_escape_string Limpia el texto que escribió el usuario (como comillas o caracteres raros) para evitar que un hacker inyecte código malicioso en tu base de datos (SQL Injection) 
                                                                                //$conn es el objeto que viene de conexion.php
                                                                                //$_POST['input']:PKP lee lo escrito por el usuario en el input
        $sql .= " AND (ean LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%')";   //.= concatena condiciones gracias al 1=1 de la consulta sql original
    }                                                                           //LIKE: sql para busquedas parciales.%x% son comodines es decir busca resultados que CONTENGAN en cualquier parte la palabra entre %
    // Filtro por Categoría------------------------------------------------
    if (!empty($_POST['busquedaSelect'])) {
        $cat = $conn->real_escape_string($_POST['busquedaSelect']);
        $sql .= " AND categoria = '$cat'";
    }
}
// 3) UNA SOLA EJECUCIÓN.
$resultado = $conn->query($sql);//query()envía la frease sql final a la bdd para ejecutarla
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