<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT * FROM clientes
        ORDER BY id_cliente ASC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Clientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'creado'){ ?>

    <div class="position-fixed top-0 start-50 translate-middle-x p-3"
         style="z-index: 9999">

        <div class="alert alert-success shadow"
             id="alerta-exito">

            Cliente registrado correctamente.

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

            <h2>Gestión de Clientes</h2>

            <div>

                <a href="crear_cliente.php"
                   class="btn btn-success me-2">

                   Nuevo Cliente

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
                    <th>Nombre</th>
                    <th>NIT</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th style="width:170px;">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>

                        <?php echo $fila['id_cliente']; ?>

                    </td>

                    <td>

                        <?php echo $fila['nombre']; ?>

                    </td>

                    <td>

                        <?php echo $fila['nit']; ?>

                    </td>

                    <td>

                        <?php echo $fila['telefono']; ?>

                    </td>

                    <td>

                        <?php echo $fila['correo']; ?>

                    </td>

                    <td>

                        <a href="editar_cliente.php?id=<?php echo $fila['id_cliente']; ?>"
                           class="btn btn-warning btn-sm me-1 px-3">

                           Editar

                        </a>

                        <a href="eliminar_cliente.php?id=<?php echo $fila['id_cliente']; ?>"
                            class="btn btn-danger btn-sm"

                            onclick="return confirm('¿Está seguro que desea eliminar este cliente?')">

                           Eliminar

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