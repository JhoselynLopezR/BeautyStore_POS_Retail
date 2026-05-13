<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT devoluciones_compras.*,
               proveedores.nombre_empresa

        FROM devoluciones_compras

        INNER JOIN compras
        ON devoluciones_compras.id_compra = compras.id_compra

        INNER JOIN proveedores
        ON compras.id_proveedor = proveedores.id_proveedor

        ORDER BY devoluciones_compras.id_dev_compra DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Devoluciones Compras</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Devoluciones de Compras</h2>

            <div>

                <a href="registrar_devolucion_compra.php"
                   class="btn btn-success me-2">

                   Nueva Devolución

                </a>

                <a href="dashboard.php"
                   class="btn btn-dark">

                   Volver

                </a>

            </div>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                    <th>Motivo</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['id_dev_compra']; ?>

                    </td>

                    <td>

                        <?php echo $fila['nombre_empresa']; ?>

                    </td>

                    <td>

                        <?php echo $fila['fecha']; ?>

                    </td>

                    <td>

                        <?php echo $fila['motivo']; ?>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>