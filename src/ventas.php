<<?php

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

        ORDER BY id_factura DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'creado'){ ?>

    <div class="position-fixed top-0 start-50 translate-middle-x p-3"
         style="z-index: 9999">

        <div class="alert alert-success shadow"
             id="alerta-exito">

            Venta registrada correctamente.

        </div>

    </div>

<?php } ?>

<div class="container mt-5">

    <div class="card shadow p-4">

<script>

setTimeout(() => {

    const alerta = document.getElementById('alerta-exito');

    if(alerta){
        alerta.style.display = 'none';
    }

}, 3000);

</script>

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Gestión de Ventas</h2>

            <div>

                <a href="crear_venta.php"
                   class="btn btn-success me-2">

                   Nueva Venta

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
                    <th>Total</th>
                    <th>Método Pago</th>
                    <th>Fecha</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['id_factura']; ?>

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

                    <td>

                        <a href="detalle_venta.php?id=<?php echo $fila['id_factura']; ?>"
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