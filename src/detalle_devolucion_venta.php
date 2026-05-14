<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql_devolucion = "SELECT devoluciones_ventas.*,
                          clientes.nombre

                   FROM devoluciones_ventas

                   INNER JOIN facturas
                   ON devoluciones_ventas.id_factura = facturas.id_factura

                   INNER JOIN clientes
                   ON facturas.id_cliente = clientes.id_cliente

                   WHERE devoluciones_ventas.id_dev_venta = '$id'";

$resultado_devolucion = $conexion->query($sql_devolucion);

$devolucion = $resultado_devolucion->fetch_assoc();

$sql_detalle = "SELECT detalle_dev_ventas.*,
                       productos.nombre AS producto

                FROM detalle_dev_ventas

                INNER JOIN productos
                ON detalle_dev_ventas.id_producto = productos.id_producto

                WHERE detalle_dev_ventas.id_dev_venta = '$id'";

$resultado_detalle = $conexion->query($sql_detalle);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detalle Devolución Venta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Detalle Devolución Venta
            </h2>

            <a href="devoluciones_ventas.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <div class="row mb-4">

            <div class="col-md-4">

                <strong>Devolución:</strong>
                #<?php echo $devolucion['id_dev_venta']; ?>

            </div>

            <div class="col-md-4">

                <strong>Cliente:</strong>
                <?php echo $devolucion['nombre']; ?>

            </div>

            <div class="col-md-4">

                <strong>Fecha:</strong>
                <?php echo $devolucion['fecha']; ?>

            </div>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Monto</th>

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

                        Q<?php echo $fila['monto']; ?>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>