<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$compras = $conexion->query("SELECT compras.id_compra,
                                    proveedores.nombre_empresa

                             FROM compras

                             INNER JOIN proveedores
                             ON compras.id_proveedor = proveedores.id_proveedor

                             ORDER BY compras.id_compra DESC");

$productos = $conexion->query("SELECT * FROM productos");

if(isset($_POST['guardar'])){

    $id_compra = $_POST['id_compra'];

    $id_producto = $_POST['id_producto'];

    $cantidad = $_POST['cantidad'];

    $motivo = $_POST['motivo'];

    $monto = $_POST['monto'];

    $sql_devolucion = "INSERT INTO devoluciones_compras
                       (id_compra,
                        motivo)

                       VALUES

                       ('$id_compra',
                        '$motivo')";

    if($conexion->query($sql_devolucion)){

        $id_dev_compra = $conexion->insert_id;

        $sql_detalle = "INSERT INTO detalle_dev_compras
                        (id_dev_compra,
                         id_producto,
                         cantidad,
                         monto)

                        VALUES

                        ('$id_dev_compra',
                         '$id_producto',
                         '$cantidad',
                         '$monto')";

        $conexion->query($sql_detalle);

        $sql_stock = "UPDATE productos
                      SET stock_actual = stock_actual - '$cantidad'
                      WHERE id_producto = '$id_producto'";

        $conexion->query($sql_stock);

        $sql_kardex = "INSERT INTO kardex
                       (id_producto,
                        tipo_movimiento,
                        cantidad,
                        stock_resultante,
                        descripcion)

                       VALUES

                       ('$id_producto',
                        'DEV_COMPRA',
                        '$cantidad',
                        (SELECT stock_actual
                         FROM productos
                         WHERE id_producto = '$id_producto'),
                        'Salida por devolución compra DEV-COM-$id_dev_compra')";

        $conexion->query($sql_kardex);

        header("Location: devoluciones_compras.php");

    }else{

        echo "Error al registrar devolución";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registrar Devolución</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Registrar Devolución Compra
            </h2>

            <a href="devoluciones_compras.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Compra
                </label>

                <select name="id_compra"
                        class="form-select"
                        required>

                    <option value="" disabled selected>
                        Seleccionar compra
                    </option>

                    <?php while($compra = $compras->fetch_assoc()) { ?>

                        <option value="<?php echo $compra['id_compra']; ?>">

                            Compra #<?php echo $compra['id_compra']; ?>
                            -
                            <?php echo $compra['nombre_empresa']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Producto
                </label>

                <select name="id_producto"
                        class="form-select"
                        required>

                    <option value="" disabled selected>
                        Seleccionar producto
                    </option>

                    <?php while($producto = $productos->fetch_assoc()) { ?>

                        <option value="<?php echo $producto['id_producto']; ?>">

                            <?php echo $producto['nombre']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Cantidad
                    </label>

                    <input type="number"
                           name="cantidad"
                           class="form-control"
                           min="1"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Monto
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            Q
                        </span>

                        <input type="number"
                               step="0.01"
                               name="monto"
                               class="form-control"
                               required>

                    </div>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Motivo
                </label>

                <textarea name="motivo"
                          class="form-control"
                          rows="3"
                          required></textarea>

            </div>

            <button type="submit"
                    name="guardar"
                    class="btn btn-success px-4">

                Registrar Devolución

            </button>

        </form>

    </div>

</div>

</body>
</html>