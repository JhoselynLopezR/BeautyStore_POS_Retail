<?php
include("config/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = $_POST['correo'];

    $sql = "SELECT * FROM empleados WHERE correo = '$correo'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {

        $datos = $resultado->fetch_assoc();

        $token = bin2hex(random_bytes(16));

        $fecha_expiracion = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $guardar = "INSERT INTO recuperacion_contrasena
        (id_empleado, token, fecha_expiracion)
        VALUES
        ({$datos['id_empleado']}, '$token', '$fecha_expiracion')";

        $conexion->query($guardar);

        $mensaje = "
        Token generado correctamente.<br><br>
        <strong>Token:</strong> $token
        ";

    } else {

        $mensaje = "Correo no encontrado.";

    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4" style="width: 400px;">

        <h3 class="text-center mb-4">
            Recuperar contraseña
        </h3>

        <?php if($mensaje != "") { ?>
            <div class="alert alert-info">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>

                <input type="email"
                       name="correo"
                       class="form-control"
                       required>
            </div>

            <button type="submit" class="btn btn-dark w-100">
                Recuperar contraseña
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