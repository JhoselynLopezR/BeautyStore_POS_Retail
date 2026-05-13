<?php

include("config/conexion.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];

    $password = hash('sha256', $_POST['password']);

    $sql = "SELECT * FROM empleados 
            WHERE usuario = '$usuario' 
            AND password = '$password'
            AND estado = 'activo'";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {

        $datos = $resultado->fetch_assoc();

        // Reiniciar intentos fallidos
        $reset = "UPDATE empleados 
                  SET intentos_fallidos = 0 
                  WHERE id_empleado = {$datos['id_empleado']}";

        $conexion->query($reset);

        // SESIONES
        $_SESSION['usuario'] = $datos['usuario'];

        $_SESSION['nombre'] = $datos['nombre_completo'];

        $_SESSION['id_empleado'] = $datos['id_empleado'];

        header("Location: dashboard.php");

        exit();

    } else {

        // Buscar usuario aunque contraseña sea incorrecta
        $buscarUsuario = "SELECT * FROM empleados 
                          WHERE usuario = '$usuario'";

        $resultadoUsuario = $conexion->query($buscarUsuario);

        if ($resultadoUsuario->num_rows > 0) {

            $usuarioDatos = $resultadoUsuario->fetch_assoc();

            $intentos = $usuarioDatos['intentos_fallidos'] + 1;

            if ($intentos >= 3) {

                $bloquear = "UPDATE empleados 
                             SET intentos_fallidos = $intentos,
                                 estado = 'bloqueado',
                                 fecha_bloqueo = NOW()
                             WHERE id_empleado = {$usuarioDatos['id_empleado']}";

                $conexion->query($bloquear);

                $error = "Usuario bloqueado por demasiados intentos fallidos.";

            } else {

                $actualizar = "UPDATE empleados 
                               SET intentos_fallidos = $intentos
                               WHERE id_empleado = {$usuarioDatos['id_empleado']}";

                $conexion->query($actualizar);

                $error = "Usuario o contraseña incorrectos.";

            }

        } else {

            $error = "Usuario o contraseña incorrectos.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - BeautyStore POS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4"
         style="width: 400px;">

        <h2 class="text-center mb-4">

            Iniciar Sesión

        </h2>

        <?php if(isset($error)) { ?>

            <div class="alert alert-danger">

                <?php echo $error; ?>

            </div>

        <?php } ?>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">

                    Usuario

                </label>

                <input type="text" 
                       name="usuario"
                       class="form-control" 
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Contraseña

                </label>

                <input type="password" 
                       name="password"
                       class="form-control" 
                       required>

            </div>

            <button type="submit"
                    class="btn btn-dark w-100">

                Ingresar

            </button>

        </form>

    </div>

</div>

</body>
</html>