<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql_pago = "SELECT pagos_clientes.*,
                    clientes.nombre

             FROM pagos_clientes

             INNER JOIN cuentas_por_cobrar
             ON pagos_clientes.id_cpc = cuentas_por_cobrar.id_cpc

             INNER JOIN facturas
             ON cuentas_por_cobrar.id_factura = facturas.id_factura

             INNER JOIN clientes
             ON facturas.id_cliente = clientes.id_cliente

             WHERE pagos_clientes.id_pago = '$id'";

$resultado_pago = $conexion->query($sql_pago);

$pago = $resultado_pago->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Comprobante Pago Cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-5">

        <div class="text-center mb-4">

            <h1 class="fw-bold">
                COMPROBANTE DE PAGO
            </h1>

            <p class="text-muted">
                Sistema POS Retail
            </p>

        </div>

        <div class="row mb-4">

            <div class="col-md-6">

                <h5>

                    <strong>Cliente:</strong>

                    <?php echo $pago['nombre']; ?>

                </h5>

                <h5>

                    <strong>Recibo No.:</strong>

                    <?php echo $pago['id_pago']; ?>

                </h5>

            </div>

            <div class="col-md-6 text-md-end">

                <h5>

                    <strong>Fecha:</strong>

                    <?php echo $pago['fecha']; ?>

                </h5>

                <h5>

                    <strong>Método Pago:</strong>

                    <?php echo ucfirst($pago['metodo_pago']); ?>

                </h5>

            </div>

        </div>

        <table class="table table-bordered align-middle">

            <tbody>

                <tr>

                    <th width="250">
                        Monto Pagado
                    </th>

                    <td>

                        Q<?php echo $pago['monto']; ?>

                    </td>

                </tr>

                <tr>

                    <th>
                        Descripción
                    </th>

                    <td>

                        <?php echo $pago['descripcion']; ?>

                    </td>

                </tr>

            </tbody>

        </table>

        <div class="d-flex justify-content-between mt-5">

            <a href="pagos_clientes.php"
               class="btn btn-dark">

               Volver

            </a>

            <button onclick="window.print()"
                    class="btn btn-success">

                Imprimir

            </button>

        </div>

    </div>

</div>

</body>
</html>