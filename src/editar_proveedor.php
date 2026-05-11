<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM proveedores
        WHERE id_proveedor = '$id'";

$resultado = $conexion->query($sql);

$proveedor = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Editar Proveedor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Editar Proveedor
            </h2>

            <a href="proveedores.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form action="actualizar_proveedor.php"
              method="POST">

            <input type="hidden"
                   name="id_proveedor"
                   value="<?php echo $proveedor['id_proveedor']; ?>">

            <div class="mb-3">

                <label class="form-label">
                    Nombre de la Empresa
                </label>

                <input type="text"
                       name="nombre_empresa"
                       class="form-control"
                       value="<?php echo $proveedor['nombre_empresa']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    NIT
                </label>

                <input type="text"
                       name="nit"
                       class="form-control"
                       value="<?php echo $proveedor['nit']; ?>">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Teléfono
                </label>

                <input type="text"
                       name="telefono"
                       class="form-control"
                       value="<?php echo $proveedor['telefono']; ?>">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Correo
                </label>

                <input type="email"
                       name="correo"
                       class="form-control"
                       value="<?php echo $proveedor['correo']; ?>">

            </div>

            <button type="submit"
                    class="btn btn-primary px-4">

                Actualizar Proveedor

            </button>

        </form>

    </div>

</div>

</body>
</html>