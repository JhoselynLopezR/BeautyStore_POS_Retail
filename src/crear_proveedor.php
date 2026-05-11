<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

if(isset($_POST['guardar'])){

    $empresa = $_POST['nombre_empresa'];

    $nit = $_POST['nit'];

    $telefono = $_POST['telefono'];

    $correo = $_POST['correo'];

    $sql = "INSERT INTO proveedores
            (nombre_empresa, nit, telefono, correo)
            VALUES
            ('$empresa','$nit','$telefono','$correo')";

    if($conexion->query($sql)){

        header("Location: proveedores.php?mensaje=creado");
        exit();

    }else{

        echo "Error al registrar proveedor";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Nuevo Proveedor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4 mx-auto"
         style="max-width: 500px;">

        <h2 class="text-center mb-4">

            Nuevo Proveedor

        </h2>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nombre de la Empresa
                </label>

                <input type="text"
                       name="nombre_empresa"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    NIT
                </label>

                <input type="text"
                       name="nit"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Teléfono
                </label>

                <input type="text"
                       name="telefono"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Correo
                </label>

                <input type="email"
                       name="correo"
                       class="form-control">

            </div>

            <button type="submit"
                    name="guardar"
                    class="btn btn-dark w-100">

                Guardar Proveedor

            </button>

        </form>

        <div class="text-center mt-3">

            <a href="proveedores.php">

                Volver

            </a>

        </div>

    </div>

</div>

</body>
</html>