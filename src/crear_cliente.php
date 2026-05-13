<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];

    $nit = $_POST['nit'];

    $telefono = $_POST['telefono'];

    $correo = $_POST['correo'];

    $sql = "INSERT INTO clientes
            (nombre,
             nit,
             telefono,
             correo)

            VALUES

            ('$nombre',
             '$nit',
             '$telefono',
             '$correo')";

    if($conexion->query($sql)){

        header("Location: clientes.php?mensaje=creado");

    }else{

        echo "Error al registrar cliente";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Nuevo Cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Nuevo Cliente
            </h2>

            <a href="clientes.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nombre Completo
                </label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       required>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        NIT
                    </label>

                    <input type="text"
                           name="nit"
                           class="form-control"
                           value="C/F">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Teléfono
                    </label>

                    <input type="text"
                           name="telefono"
                           class="form-control">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Correo
                    </label>

                    <input type="email"
                           name="correo"
                           class="form-control">

                </div>

            </div>

            <button type="submit"
                    name="guardar"
                    class="btn btn-success px-4">

                Guardar Cliente

            </button>

        </form>

    </div>

</div>

</body>
</html>