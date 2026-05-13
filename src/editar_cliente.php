<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM clientes
        WHERE id_cliente = '$id'";

$resultado = $conexion->query($sql);

$cliente = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Editar Cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Editar Cliente
            </h2>

            <a href="clientes.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form method="POST"
              action="actualizar_cliente.php">

            <input type="hidden"
                   name="id_cliente"
                   value="<?php echo $cliente['id_cliente']; ?>">

            <div class="mb-3">

                <label class="form-label">
                    Nombre Completo
                </label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       value="<?php echo $cliente['nombre']; ?>"
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
                           value="<?php echo $cliente['nit']; ?>">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Teléfono
                    </label>

                    <input type="text"
                           name="telefono"
                           class="form-control"
                           value="<?php echo $cliente['telefono']; ?>">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Correo
                    </label>

                    <input type="email"
                           name="correo"
                           class="form-control"
                           value="<?php echo $cliente['correo']; ?>">

                </div>

            </div>

            <button type="submit"
                    class="btn btn-warning px-4">

                Actualizar Cliente

            </button>

        </form>

    </div>

</div>

</body>
</html>