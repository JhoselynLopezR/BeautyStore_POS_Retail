<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql_devolucion = "SELECT devoluciones_compras.*,
                          proveedores.nombre_empresa

                   FROM devoluciones_compras

                   INNER JOIN compras
                   ON devoluciones_compras.id_compra = compras.id_compra

                   INNER JOIN proveedores
                   ON compras.id_proveedor = proveedores.id_proveedor

                   WHERE devoluciones_compras.id_dev_compra = '$id'";

$resultado_devolucion = $conexion->query($sql_devolucion);

$devolucion = $resultado_devolucion->fetch_assoc();

$sql_detalle = "SELECT detalle_dev_compras.*,
                       productos.nombre AS producto

                FROM detalle_dev_compras

                INNER JOIN productos
                ON detalle_dev_compras.id_producto = productos.id_producto

                WHERE detalle_dev_compras.id_dev_compra = '$id'";

$resultado_detalle = $conexion->query($sql_detalle);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detalle Devolución Compra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Detalle Devolución Compra
            </h2>

            <a href="devoluciones_compras.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <div class="row mb-4">

            <div class="col-md-4">

                <strong>Devolución:</strong>
                #<?php echo $devolucion['id_dev_compra']; ?>

            </div>

            <div class="col-md-4">

                <strong>Proveedor:</strong>
                <?php echo $devolucion['nombre_empresa']; ?>

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