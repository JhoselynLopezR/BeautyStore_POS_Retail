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
        ON empleados.id_rol = roles.id_rol
        ORDER BY empleados.id_empleado ASC";

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

<?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'creado'){ ?>

    <div class="position-fixed top-0 start-50 translate-middle-x p-3"
     style="z-index: 9999">

    <div class="alert alert-success shadow"
         id="alerta-exito">

        Usuario registrado correctamente.

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

            <h2>Gestión de Usuarios</h2>

            <div>

                <a href="crear_usuario.php" class="btn btn-success me-2">
                    Nuevo Usuario
                </a>

                <a href="dashboard.php" class="btn btn-dark">
                    Volver
                </a>

            </div>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th style="width: 170px;">Acciones</th>

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

                    <td>

                        <?php if($fila['estado'] == 'activo'){ ?>

                            <span class="badge bg-success">
                                Activo
                            </span>

                        <?php } else { ?>

                            <span class="badge bg-danger">
                                Bloqueado
                            </span>

                        <?php } ?>

                    </td>

                    <td>

                        <a href="editar_usuario.php?id=<?php echo $fila['id_empleado']; ?>" 
                           class="btn btn-warning btn-sm me-1 px-3">

                           Editar

                        </a>

                        <?php if($fila['id_empleado'] != 1){ ?>

                            <a href="eliminar_usuario.php?id=<?php echo $fila['id_empleado']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Desea eliminar este usuario?')">

                               Eliminar

                            </a>

                        <?php } else { ?>

                            <span class="text-muted small">
                                Protegido
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