<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT facturas.*,
               clientes.nombre

        FROM facturas

        INNER JOIN clientes
        ON facturas.id_cliente = clientes.id_cliente

        ORDER BY facturas.fecha DESC";

$resultado = $conexion->query($sql);

$sql_total = "SELECT SUM(total) AS total_ventas
              FROM facturas";

$resultado_total = $conexion->query($sql_total);

$total = $resultado_total->fetch_assoc();

?>

<!DOCTYPE html>
<html lang='es'>

<head>

    <meta charset='UTF-8'>

    <meta name='viewport'
          content='width=device-width, initial-scale=1.0'>

    <title>Reporte Ventas</title>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'
          rel='stylesheet'>

</head>

<body class='bg-light'>

<div class='container py-5'>

    <div class='card shadow border-0 rounded-4 p-4'>

        <div class='d-flex justify-content-between align-items-center mb-4'>

            <h2 class='fw-bold'>
                Reporte Básico de Ventas
            </h2>

            <a href='dashboard.php'
               class='btn btn-dark'>

               Volver

            </a>

        </div>

        <div class='row mb-4'>

            <div class='col-md-4'>

                <div class='card shadow-sm border-0 rounded-4 p-3'>

                    <h5 class='text-muted'>
                        Total Ventas
                    </h5>

                    <h2 class='fw-bold text-success'>

                        Q<?php echo number_format($total['total_ventas'],2); ?>

                    </h2>

                </div>

            </div>

        </div>

        <div class='table-responsive'>

            <table class='table table-bordered table-hover align-middle'>

                <thead class='table-dark'>

                    <tr>

                        <th>Factura</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Método Pago</th>
                        <th>Fecha</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($fila = $resultado->fetch_assoc()) { ?>

                    <tr>

                        <td>

                            <?php echo $fila['numero_factura']; ?>

                        </td>

                        <td>

                            <?php echo $fila['nombre']; ?>

                        </td>

                        <td>

                            Q<?php echo $fila['total']; ?>

                        </td>

                        <td>

                            <?php echo ucfirst($fila['metodo_pago']); ?>

                        </td>

                        <td>

                            <?php echo $fila['fecha']; ?>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>