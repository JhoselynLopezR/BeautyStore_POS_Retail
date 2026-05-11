<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM empleados WHERE id_empleado = '$id'";

$resultado = $conexion->query($sql);

$usuario = $resultado->fetch_assoc();

$roles = $conexion->query("SELECT * FROM roles");

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Usuario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Editar Usuario</h2>

            <a href="usuarios.php" class="btn btn-dark">
                Volver
            </a>

        </div>

        <form action="actualizar_usuario.php" method="POST">

            <input type="hidden"
                   name="id_empleado"
                   value="<?php echo $usuario['id_empleado']; ?>">

            <div class="mb-3">

                <label class="form-label">
                    Nombre Completo
                </label>

                <input type="text"
                       name="nombre_completo"
                       class="form-control"
                       value="<?php echo $usuario['nombre_completo']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Usuario
                </label>

                <input type="text"
                       name="usuario"
                       class="form-control"
                       value="<?php echo $usuario['usuario']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Correo
                </label>

                <input type="email"
                       name="correo"
                       class="form-control"
                       value="<?php echo $usuario['correo']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Rol
                </label>

                <select name="id_rol" class="form-select">

                    <?php while($rol = $roles->fetch_assoc()) { ?>

                        <option value="<?php echo $rol['id_rol']; ?>"

                            <?php 
                            if($rol['id_rol'] == $usuario['id_rol']) 
                            echo 'selected'; 
                            ?>>

                            <?php echo $rol['nombre_rol']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Estado
                </label>

                <select name="estado" class="form-select">

                    <option value="activo"
                        <?php if($usuario['estado'] == 'activo') echo 'selected'; ?>>
                        Activo
                    </option>

                    <option value="bloqueado"
                        <?php if($usuario['estado'] == 'bloqueado') echo 'selected'; ?>>
                        Bloqueado
                    </option>

                </select>

            </div>

            <button type="submit" class="btn btn-primary">
                Actualizar Usuario
            </button>

        </form>

    </div>

</div>

</body>
</html>