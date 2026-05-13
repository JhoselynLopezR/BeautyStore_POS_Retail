<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT kardex.*,
               productos.nombre

        FROM kardex

        INNER JOIN productos
        ON kardex.id_producto = productos.id_producto

        ORDER BY kardex.id_kardex DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Kardex</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Kardex Inventario</h2>

            <a href="dashboard.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Producto</th>
                    <th>Movimiento</th>
                    <th>Cantidad</th>
                    <th>Stock Resultante</th>
                    <th>Fecha</th>
                    <th>Descripción</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['id_kardex']; ?>

                    </td>

                    <td>

                        <?php echo $fila['nombre']; ?>

                    </td>

                    <td>

                        <?php if($fila['tipo_movimiento'] == 'COMPRA'){ ?>

                            <span class="badge bg-success">

                                COMPRA

                            </span>

                        <?php } else { ?>

                            <span class="badge bg-danger">

                                <?php echo $fila['tipo_movimiento']; ?>

                            </span>

                        <?php } ?>

                    </td>

                    <td>

                        <?php echo $fila['cantidad']; ?>

                    </td>

                    <td>

                        <?php echo $fila['stock_resultante']; ?>

                    </td>

                    <td>

                        <?php echo $fila['fecha']; ?>

                    </td>

                    <td>

                        <?php echo $fila['descripcion']; ?>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>