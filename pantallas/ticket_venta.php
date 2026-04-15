<?php
require_once __DIR__ . '/../includes/conexion.php';
session_start();


// ticket_venta.php
$idVenta = $_GET['idVenta'] ?? 0;

// Consultar datos de la venta y la empleada de forma segura con prepare y bind_param
$stmtVenta = $conn->prepare("SELECT ventas.*, empleadas.nombre
                            FROM ventas
                            JOIN empleadas ON ventas.id_empleada = empleadas.id
                            WHERE ventas.id=?");

$stmtVenta->bind_param("i", $idVenta);
$stmtVenta->execute();
$venta = $stmtVenta->get_result()->fetch_assoc();

if (!$venta) { //CONTROL
    die("Error: No se encontró la venta.");
}



// Consultar productos de la venta de forma segura con prepare y bind_param
$stmtProd = $conn->prepare("SELECT detalle_ventas.*, productos.nombre
                            FROM detalle_ventas
                            JOIN productos ON detalle_ventas.id_producto = productos.id
                            WHERE detalle_ventas.id_venta= ?");
$stmtProd->bind_param("i", $idVenta);
$stmtProd->execute();
$productos = $stmtProd->get_result();

//Consulta para sacar el nombre de la empresa que se está metiendo en el login
$idEmpresa = $_SESSION['empleada']['id_empresa'] ?? 1;

$stmtEmpresa = $conn->prepare("SELECT * FROM empresa WHERE id = ?");
$stmtEmpresa->bind_param("i", $idEmpresa);
$stmtEmpresa->execute();
$empresa = $stmtEmpresa->get_result()->fetch_assoc();


?>


<!DOCTYPE html>
<html>

<head>
    <!--pongo los estilos aqui porque al ser una ventana nueva no hereda los estilos de la pagina principal y además son minimos-->
    <title>Ticket de Venta #
        <?php echo $idVenta; ?>
    </title>
    <style>
        body {
            font-family: monospace;
            margin: 20px;
        }

        .ticket {
            max-width: 300px;
            margin: auto;
        }

        hr {
            border-top: 1px dashed #000;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <h2 class="center"><?php echo htmlspecialchars($empresa['nombre']); ?></h2>
        <p><b>Ticket N°:</b> <?php echo $idVenta; ?></p>
        <p><b>Fecha:</b> <?php echo $venta['fecha']; ?></p>
        <p><b>Atendido por:</b> <?php echo $venta['nombre']; ?></p>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Prod.</th>
                    <th>Cant.</th>
                    <th>Sub.</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($p = $productos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td><?php echo $p['cantidad']; ?></td>
                        <td>$<?php echo number_format($p['subtotal'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <hr>
        <p class="total">TOTAL: $<?php echo number_format($venta['total'], 2); ?></p>
        <p class="center">¡Gracias por su compra!</p>
    </div>
</body>

</html>