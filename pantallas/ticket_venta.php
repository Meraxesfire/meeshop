<?php

// ticket_venta.php
$idVenta = $_GET['idVenta'] ?? 0;

// Consultar datos de la venta
$sql = "SELECT v.*, e.nombre_empleado 
        FROM ventas v 
        JOIN empleados e ON v.id_empleada = e.id 
        WHERE v.id_venta = $idVenta";
$resultado = $conn->query($sql);
$venta = $resultado->fetch_assoc();

// Consultar productos de la venta
$sqlDetalle = "SELECT dv.*, p.nombre 
               FROM detalle_ventas dv
               JOIN productos p ON dv.id_producto = p.id
               WHERE dv.id_venta = $idVenta";
$productos = $conn->query($sqlDetalle);
?>

<!DOCTYPE html>
<html>

<head>
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
        <h2>TIENDA S.A.</h2>
        <p>Ticket N°:
            <?php echo $idVenta; ?>
        </p>
        <p>Fecha:
            <?php echo $venta['fecha']; ?>
        </p>
        <p>Empleado:
            <?php echo $venta['nombre_empleado']; ?>
        </p>
        <hr>
        <table>
            <tr>
                <th>Producto</th>
                <th>Cant</th>
                <th>Subtotal</th>
            </tr>
            <?php while ($producto = $productos->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php echo $producto['nombre']; ?>
                        </td>
                        <td>
                            <?php echo $producto['Cantidad']; ?>
                        </td>
                        <td>$
                            <?php echo number_format($producto['Subtotal'], 2); ?>
                        </td>
                    </tr>
            <?php endwhile; ?>
        </table>
        <hr>
        <h3>TOTAL: $
            <?php echo number_format($venta['total'], 2); ?>
        </h3>
        <p>¡Gracias por su compra!</p>
    </div>
    <script>window.print();</script> <!-- Imprime automáticamente -->
</body>

</html>