<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h1 class="mb-3">
            Bienvenida <?php echo $_SESSION['nombre']; ?>
        </h1>

        <p>
            Has iniciado sesión correctamente en BeautyStore POS Retail.
        </p>

        <a href="logout.php" class="btn btn-danger">
            Cerrar Sesión
        </a>

    </div>

</div>

</body>
</html>