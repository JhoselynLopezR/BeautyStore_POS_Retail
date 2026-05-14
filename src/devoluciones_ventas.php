<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT devoluciones_ventas.*,
               clientes.nombre

        FROM devoluciones_ventas

        INNER JOIN facturas
        ON devoluciones_ventas.id_factura = facturas.id_factura

        INNER JOIN clientes
        ON facturas.id_cliente = clientes.id_cliente

        ORDER BY devoluciones_ventas.id_dev_venta DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Devoluciones Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Devoluciones de Ventas</h2>

            <div>

                <a href="registrar_devolucion_venta.php"
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
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Motivo</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['id_dev_venta']; ?>

                    </td>

                    <td>

                        <?php echo $fila['nombre']; ?>

                    </td>

                    <td>

                        <?php echo $fila['fecha']; ?>

                    </td>

                    <td>

                        <?php echo $fila['motivo']; ?>

                    </td>

                    <td>

                   <a href="detalle_devolucion_venta.php?id=<?php echo $fila['id_dev_venta']; ?>"
                      class="btn btn-primary btn-sm">

                      Ver detalle

                    </a>

                 </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>