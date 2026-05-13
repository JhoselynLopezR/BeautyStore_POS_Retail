<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql_factura = "SELECT facturas.*,
                       clientes.nombre

                FROM facturas

                INNER JOIN clientes
                ON facturas.id_cliente = clientes.id_cliente

                WHERE facturas.id_factura = '$id'";

$resultado_factura = $conexion->query($sql_factura);

$factura = $resultado_factura->fetch_assoc();

$sql_detalle = "SELECT detalle_facturas.*,
                       productos.nombre AS producto

                FROM detalle_facturas

                INNER JOIN productos
                ON detalle_facturas.id_producto = productos.id_producto

                WHERE detalle_facturas.id_factura = '$id'";

$resultado_detalle = $conexion->query($sql_detalle);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detalle Venta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Detalle Venta
            </h2>

            <a href="ventas.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <div class="row mb-4">

            <div class="col-md-4">

                <strong>Factura:</strong>
                #<?php echo $factura['id_factura']; ?>

            </div>

            <div class="col-md-4">

                <strong>Cliente:</strong>
                <?php echo $factura['nombre']; ?>

            </div>

            <div class="col-md-4">

                <strong>Total:</strong>
                Q<?php echo $factura['total']; ?>

            </div>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado_detalle->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['producto']; ?>

                    </td>

                    <td>

                        <?php echo $fila['cantidad']; ?>

                    </td>

                    <td>

                        Q<?php echo $fila['precio_unitario']; ?>

                    </td>

                    <td>

                        Q<?php echo $fila['subtotal']; ?>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>