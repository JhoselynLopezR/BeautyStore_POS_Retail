<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql_compra = "SELECT compras.*,
                      proveedores.nombre_empresa

               FROM compras

               INNER JOIN proveedores
               ON compras.id_proveedor = proveedores.id_proveedor

               WHERE compras.id_compra = '$id'";

$resultado_compra = $conexion->query($sql_compra);

$compra = $resultado_compra->fetch_assoc();

$sql_detalle = "SELECT detalle_compras.*,
                       productos.nombre AS producto

                FROM detalle_compras

                INNER JOIN productos
                ON detalle_compras.id_producto = productos.id_producto

                WHERE detalle_compras.id_compra = '$id'";

$resultado_detalle = $conexion->query($sql_detalle);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detalle Compra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Detalle Compra
            </h2>

            <a href="compras.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <div class="row mb-4">

            <div class="col-md-4">

                <strong>Compra:</strong>
                #<?php echo $compra['id_compra']; ?>

            </div>

            <div class="col-md-4">

                <strong>Proveedor:</strong>
                <?php echo $compra['nombre_empresa']; ?>

            </div>

            <div class="col-md-4">

                <strong>Total:</strong>
                Q<?php echo $compra['total']; ?>

            </div>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
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

                        Q<?php echo $fila['costo_unitario']; ?>

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