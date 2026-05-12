<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT cuentas_por_pagar.*,
               proveedores.nombre_empresa

        FROM cuentas_por_pagar

        INNER JOIN compras
        ON cuentas_por_pagar.id_compra = compras.id_compra

        INNER JOIN proveedores
        ON compras.id_proveedor = proveedores.id_proveedor

        ORDER BY cuentas_por_pagar.id_cpp DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cuentas por Pagar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Cuentas por Pagar</h2>

            <a href="dashboard.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>Saldo</th>
                    <th>Fecha Vencimiento</th>
                    <th>Estado</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['id_cpp']; ?>

                    </td>

                    <td>

                        <?php echo $fila['nombre_empresa']; ?>

                    </td>

                    <td>

                        Q<?php echo $fila['saldo_total']; ?>

                    </td>

                    <td>

                        <?php echo $fila['fecha_vencimiento']; ?>

                    </td>

                    <td>

                        <?php if($fila['estado'] == 'pendiente'){ ?>

                            <span class="badge bg-warning text-dark">

                                Pendiente

                            </span>

                        <?php } elseif($fila['estado'] == 'pagado'){ ?>

                            <span class="badge bg-success">

                                Pagado

                            </span>

                        <?php } else { ?>

                            <span class="badge bg-primary">

                                Parcial

                            </span>

                        <?php } ?>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>