<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$mensaje = "";

// CONSULTAR ROLES
$roles = "SELECT * FROM roles";
$resultadoRoles = $conexion->query($roles);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $id_rol = $_POST['id_rol'];

    // ENCRIPTAR PASSWORD
    $password_hash = hash('sha256', $password);

    $sql = "INSERT INTO empleados
    (id_rol, nombre_completo, usuario, correo, password)
    VALUES
    ($id_rol, '$nombre', '$usuario', '$correo', '$password_hash')";

    if ($conexion->query($sql)) {

        $mensaje = "Usuario registrado correctamente.";

    } else {

        $mensaje = "Error al registrar usuario.";

    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">

        <h2 class="text-center mb-4">
            Crear Usuario
        </h2>

        <?php if($mensaje != "") { ?>
            <div class="alert alert-info">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nombre completo</label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Usuario</label>

                <input type="text"
                       name="usuario"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo</label>

                <input type="email"
                       name="correo"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>

                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>

                <select name="id_rol"
                        class="form-select"
                        required>

                    <option value="">
                        Seleccione un rol
                    </option>

                    <?php while($rol = $resultadoRoles->fetch_assoc()) { ?>

                        <option value="<?php echo $rol['id_rol']; ?>">
                            <?php echo $rol['nombre_rol']; ?>
                        </option>

                    <?php } ?>

                </select>
            </div>

            <button type="submit"
                    class="btn btn-dark w-100">

                Registrar Usuario

            </button>

        </form>

        <div class="text-center mt-3">

            <a href="usuarios.php">
                Volver
            </a>

        </div>

    </div>

</div>

</body>
</html>