<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT pagos_proveedores.*,
               proveedores.nombre_empresa

        FROM pagos_proveedores

        INNER JOIN cuentas_por_pagar
        ON pagos_proveedores.id_cpp = cuentas_por_pagar.id_cpp

        INNER JOIN compras
        ON cuentas_por_pagar.id_compra = compras.id_compra

        INNER JOIN proveedores
        ON compras.id_proveedor = proveedores.id_proveedor

        ORDER BY pagos_proveedores.id_pago DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pagos Proveedores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Pagos a Proveedores</h2>

            <div>

                <a href="registrar_pago.php"
                   class="btn btn-success me-2">

                   Registrar Pago

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
                    <th>Monto</th>
                    <th>Método Pago</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th width="130">Acciones</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['id_pago']; ?>

                    </td>

                    <td>

                        <?php echo $fila['nombre_empresa']; ?>

                    </td>

                    <td>

                        Q<?php echo $fila['monto']; ?>

                    </td>

                    <td>

                        <?php echo ucfirst($fila['metodo_pago']); ?>

                    </td>

                    <td>

                        <?php echo $fila['descripcion']; ?>

                    </td>

                    <td>

                        <?php echo $fila['fecha']; ?>

                    </td>

                    <td>

                        <a href="comprobante_pago_proveedores.php?id=<?php echo $fila['id_pago']; ?>"
                           class="btn btn-success btn-sm">

                           Comprobante

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