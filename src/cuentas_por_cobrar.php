<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT cuentas_por_cobrar.*,
               facturas.id_factura,
               clientes.nombre

        FROM cuentas_por_cobrar

        INNER JOIN facturas
        ON cuentas_por_cobrar.id_factura = facturas.id_factura

        INNER JOIN clientes
        ON facturas.id_cliente = clientes.id_cliente

        ORDER BY cuentas_por_cobrar.id_cpc DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cuentas por Cobrar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Cuentas por Cobrar</h2>

            <div>

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
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Saldo</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['id_cpc']; ?>

                    </td>

                    <td>

                        FACT-<?php echo $fila['id_factura']; ?>

                    </td>

                    <td>

                        <?php echo $fila['nombre']; ?>

                    </td>

                    <td>

                        Q<?php echo $fila['saldo_total']; ?>

                    </td>

                    <td>

                        <?php echo $fila['fecha_vencimiento']; ?>

                    </td>

                    <td>

                        <?php echo ucfirst($fila['estado']); ?>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>