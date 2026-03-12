<?php
require_once __DIR__.'/../includes/conexion.php'; //conecta con la bbdd

$sql= "SELECT * FROM productos WHERE 1=1";//consulta sql general (1=1 permitira concatenar consultas)

if($_SERVER['REQUEST_METHOD']=== 'POST'){//SERVER= array con info del server y la petición /(REQUEST_METHOD)
    //filtro por EAN + filtro por nombre
    if(!empty($_POST['busquedaInput'])){
        $busqueda = $conn->real_escape_string($_POST['busquedaInput']);
        $sql.=" AND (ean LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%')";
    }
    //filtro por categoria
    if(!empty($_POST['busquedaSelect'])){
        $cat=$conn->real_escape_string($_POST['busquedaSelect']);
        $sql.=" AND categoria = '$cat'";
    }
}

//Ejecución de la consulta:
$resultado=$conn->query($sql);
    if($resultado -> num_rows>0){
            while ($row = $resultado->fetch_assoc()){ //pintar la tabla
            $pvo=isset($row['precio']) ? floatval($row['precio']) :0; //con esto de nuevo calculamos de forma dinamica el iva en la ultima celda
            $ivaPorcentaje=isset($row['iva']) ? floatval($row['iva']) : 0;
            $pvp = $pvo*(1+ ($ivaPorcentaje/100));

            echo '<tr class="filaVentas">';
            echo '<td class="datoEditableVentas">'.$row['EAN'].'</td>';
            echo '<td class="datoEditableVentas">'.$row['nombre'].'</td>';
            echo '<td class="datoEditableVentas">'.$row['categoria'].'</td>';
            echo '<td class="datoEditableVentas">'.$row['precio'].'</td>';
            echo '<td class="datoEditableVentas">'.$row['stock'].'</td>';
            echo '<td class="datoEditableVentas"'.$row['iva'].'</td>';
            echo '<td class="datoEditableVentas">'.number_format($pvp, 2, ',', '.') . ' €'.'</td>';
            echo "<td><button style='background-color:rgba(219,145,0,0.7); border:none; color:white; padding:10px 15px; border-radius: 15px; font-size:23px;'>+</button></td>";
            echo '</tr>';

            //ME FALTA METER LA LOGICA DEL BOTON DE AÑADIR CANTIDAD AL ENTORNO DE VENTA (POR CREAR)
            }

    }


?>