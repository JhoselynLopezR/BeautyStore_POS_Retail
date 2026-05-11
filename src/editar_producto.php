<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM productos
        WHERE id_producto = '$id'";

$resultado = $conexion->query($sql);

$producto = $resultado->fetch_assoc();

$categorias = $conexion->query("SELECT * FROM categorias");

$proveedores = $conexion->query("SELECT * FROM proveedores");

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Editar Producto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Editar Producto
            </h2>

            <a href="productos.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form action="actualizar_producto.php"
              method="POST">

            <input type="hidden"
                   name="id_producto"
                   value="<?php echo $producto['id_producto']; ?>">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Categoría
                    </label>

                    <select name="id_categoria"
                            class="form-select"
                            required>

                        <?php while($categoria = $categorias->fetch_assoc()) { ?>

                            <option value="<?php echo $categoria['id_categoria']; ?>"

                            <?php
                            if($categoria['id_categoria'] == $producto['id_categoria']){
                                echo "selected";
                            }
                            ?>>

                            <?php echo $categoria['nombre_categoria']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Proveedor
                    </label>

                    <select name="id_proveedor"
                            class="form-select"
                            required>

                        <?php while($proveedor = $proveedores->fetch_assoc()) { ?>

                            <option value="<?php echo $proveedor['id_proveedor']; ?>"

                            <?php
                            if($proveedor['id_proveedor'] == $producto['id_proveedor']){
                                echo "selected";
                            }
                            ?>>

                            <?php echo $proveedor['nombre_empresa']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Nombre Producto
                </label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       value="<?php echo $producto['nombre']; ?>"
                       required>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Marca
                    </label>

                    <input type="text"
                           name="marca"
                           class="form-control"
                           value="<?php echo $producto['marca']; ?>">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Tono
                    </label>

                    <input type="text"
                           name="tono"
                           class="form-control"
                           value="<?php echo $producto['tono']; ?>">

                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Fecha vencimiento
                    </label>

                    <input type="date"
                           name="fecha_vencimiento"
                           class="form-control"
                           value="<?php echo $producto['fecha_vencimiento']; ?>">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Precio costo
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            Q
                        </span>

                        <input type="number"
                               step="0.01"
                               name="precio_costo"
                               class="form-control"
                               value="<?php echo $producto['precio_costo']; ?>"
                               required>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Precio venta
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            Q
                        </span>

                        <input type="number"
                               step="0.01"
                               name="precio_venta"
                               class="form-control"
                               value="<?php echo $producto['precio_venta']; ?>"
                               required>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Stock actual
                    </label>

                    <input type="number"
                           name="stock_actual"
                           class="form-control"
                           value="<?php echo $producto['stock_actual']; ?>"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Stock mínimo
                    </label>

                    <input type="number"
                           name="stock_minimo"
                           class="form-control"
                           value="<?php echo $producto['stock_minimo']; ?>">

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary px-4">

                Actualizar Producto

            </button>

        </form>

    </div>

</div>

</body>
</html>