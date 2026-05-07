<?php
include("config/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BeautyStore POS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4" style="width: 400px;">

        <h2 class="text-center mb-4">Iniciar Sesión</h2>

        <form>

            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" class="form-control" placeholder="Ingrese su usuario">
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" placeholder="Ingrese su contraseña">
            </div>

            <button type="submit" class="btn btn-dark w-100">
                Ingresar
            </button>

        </form>

    </div>

</div>

</body>
</html>