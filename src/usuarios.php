<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT empleados.*, roles.nombre_rol
        FROM empleados
        INNER JOIN roles
        ON empleados.id_rol = roles.id_rol";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Gestión de Usuarios</h2>

            <a href="dashboard.php" class="btn btn-dark">
                Volver
            </a>

        </div>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td><?php echo $fila['id_empleado']; ?></td>

                    <td><?php echo $fila['nombre_completo']; ?></td>

                    <td><?php echo $fila['usuario']; ?></td>

                    <td><?php echo $fila['correo']; ?></td>

                    <td><?php echo $fila['nombre_rol']; ?></td>

                    <td><?php echo $fila['estado']; ?></td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>