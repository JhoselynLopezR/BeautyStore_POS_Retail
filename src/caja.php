<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT caja.*,
               empleados.nombre_completo

        FROM caja

        INNER JOIN empleados
        ON caja.id_empleado = empleados.id_empleado

        ORDER BY caja.fecha DESC";

$resultado = $conexion->query($sql);

$sql_ingresos = "SELECT SUM(monto) AS total_ingresos
                 FROM caja
                 WHERE tipo_movimiento = 'ingreso'";

$resultado_ingresos = $conexion->query($sql_ingresos);

$ingresos = $resultado_ingresos->fetch_assoc();

$sql_egresos = "SELECT SUM(monto) AS total_egresos
                FROM caja
                WHERE tipo_movimiento = 'egreso'";

$resultado_egresos = $conexion->query($sql_egresos);

$egresos = $resultado_egresos->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Caja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Movimientos de Caja
            </h2>

            <a href="dashboard.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <div class="row mb-4">

            <div class="col-md-6">

                <div class="card border-0 shadow-sm rounded-4 p-3">

                    <h5 class="text-muted">
                        Total Ingresos
                    </h5>

                    <h2 class="fw-bold text-success">

                        Q<?php echo number_format($ingresos['total_ingresos'] ?? 0,2); ?>

                    </h2>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card border-0 shadow-sm rounded-4 p-3">

                    <h5 class="text-muted">
                        Total Egresos
                    </h5>

                    <h2 class="fw-bold text-danger">

                        Q<?php echo number_format($egresos['total_egresos'] ?? 0,2); ?>

                    </h2>

                </div>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Empleado</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Medio Pago</th>
                        <th>Descripción</th>
                        <th>Fecha</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($fila = $resultado->fetch_assoc()) { ?>

                    <tr>

                        <td>

                            <?php echo $fila['id_movimiento']; ?>

                        </td>

                        <td>

                            <?php echo $fila['nombre_completo']; ?>

                        </td>

                        <td>

                            <?php echo ucfirst($fila['tipo_movimiento']); ?>

                        </td>

                        <td>

                            Q<?php echo $fila['monto']; ?>

                        </td>

                        <td>

                            <?php echo ucfirst($fila['medio_pago']); ?>

                        </td>

                        <td>

                            <?php echo $fila['descripcion']; ?>

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