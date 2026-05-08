<?php

date_default_timezone_set('America/Guatemala');

include("config/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $token = $_POST['token'];
    $nueva_password = $_POST['password'];

    $password_hash = hash('sha256', $nueva_password);

    $sql = "SELECT * FROM recuperacion_contrasena
            WHERE token = '$token'
            AND usado = 0
            AND fecha_expiracion >= NOW()";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {

        $datos = $resultado->fetch_assoc();

        $id_empleado = $datos['id_empleado'];

        // Actualizar contraseña
        $updatePassword = "UPDATE empleados
                           SET password = '$password_hash',
                               intentos_fallidos = 0,
                               estado = 'activo',
                               fecha_bloqueo = NULL
                           WHERE id_empleado = $id_empleado";

        $conexion->query($updatePassword);

        // Marcar token como usado
        $usarToken = "UPDATE recuperacion_contrasena
                      SET usado = 1
                      WHERE id_recuperacion = {$datos['id_recuperacion']}";

        $conexion->query($usarToken);

        $mensaje = "Contraseña actualizada correctamente.";

    } else {

        $mensaje = "Token inválido o expirado.";

    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4" style="width: 400px;">

        <h3 class="text-center mb-4">
            Cambiar contraseña
        </h3>

        <?php if($mensaje != "") { ?>
            <div class="alert alert-info">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Token</label>

                <input type="text"
                       name="token"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nueva contraseña</label>

                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <button type="submit" class="btn btn-dark w-100">
                Cambiar contraseña
            </button>

        </form>

        <div class="text-center mt-3">
            <a href="index.php">
                Volver al login
            </a>
        </div>

    </div>

</div>

</body>
</html>