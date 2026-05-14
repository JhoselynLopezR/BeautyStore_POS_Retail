<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$facturas = $conexion->query("SELECT facturas.id_factura,
                                     clientes.nombre

                              FROM facturas

                              INNER JOIN clientes
                              ON facturas.id_cliente = clientes.id_cliente

                              ORDER BY facturas.id_factura DESC");

$productos = $conexion->query("SELECT * FROM productos");

if(isset($_POST['guardar'])){

    $id_factura = $_POST['id_factura'];

    $motivo = $_POST['motivo'];

    $productos_post = $_POST['id_producto'];

    $cantidades = $_POST['cantidad'];

    $montos = $_POST['monto'];

    $sql_dev = "INSERT INTO devoluciones_ventas
                (id_factura,
                 motivo)

                VALUES

                ('$id_factura',
                 '$motivo')";

    if($conexion->query($sql_dev)){

        $id_dev_venta = $conexion->insert_id;

        for($i = 0; $i < count($productos_post); $i++){

            $id_producto = $productos_post[$i];

            $cantidad = $cantidades[$i];

            $monto = $montos[$i];

            $sql_detalle = "INSERT INTO detalle_dev_ventas
                            (id_dev_venta,
                             id_producto,
                             cantidad,
                             monto)

                            VALUES

                            ('$id_dev_venta',
                             '$id_producto',
                             '$cantidad',
                             '$monto')";

            $conexion->query($sql_detalle);

            $sql_stock = "UPDATE productos
                          SET stock_actual = stock_actual + $cantidad
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
                            'DEV_VENTA',
                            '$cantidad',
                            (SELECT stock_actual
                             FROM productos
                             WHERE id_producto = '$id_producto'),
                            'Entrada por devolución venta FAC-$id_factura')";

            $conexion->query($sql_kardex);

        }

        header("Location: devoluciones_ventas.php");

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

    <title>Registrar Devolución Venta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Registrar Devolución Venta
            </h2>

            <a href="devoluciones_ventas.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Factura
                </label>

                <select name="id_factura"
                        class="form-select"
                        required>

                    <option value="" disabled selected>
                        Seleccionar factura
                    </option>

                    <?php while($factura = $facturas->fetch_assoc()) { ?>

                        <option value="<?php echo $factura['id_factura']; ?>">

                            FACT-<?php echo $factura['id_factura']; ?>

                            | Cliente:
                            <?php echo $factura['nombre']; ?>

                        </option>

                    <?php } ?>

                </select>

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

            <div class="table-responsive">

                <table class="table table-bordered align-middle"
                       id="tabla-productos">

                    <thead class="table-dark">

                        <tr>

                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Monto</th>
                            <th>Acción</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>

                                <select class="form-select"
                                        name="id_producto[]"
                                        required>

                                    <option selected disabled>
                                        Seleccionar producto
                                    </option>

                                    <?php while($producto = $productos->fetch_assoc()) { ?>

                                        <option value="<?php echo $producto['id_producto']; ?>">

                                            <?php echo $producto['nombre']; ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </td>

                            <td>

                                <input type="number"
                                       class="form-control"
                                       name="cantidad[]"
                                       min="1"
                                       required>

                            </td>

                            <td>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Q
                                    </span>

                                    <input type="number"
                                           class="form-control"
                                           name="monto[]"
                                           step="0.01"
                                           required>

                                </div>

                            </td>

                            <td class="text-center">

                                <button type="button"
                                        class="btn btn-danger btn-sm eliminar-fila">

                                    X

                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                <button type="button"
                        class="btn btn-primary"
                        id="agregar-fila">

                    + Agregar Producto

                </button>

            </div>

            <button type="submit"
                    name="guardar"
                    class="btn btn-success mt-4">

                Registrar Devolución

            </button>

        </form>

    </div>

</div>

<script>

const tabla = document.querySelector('#tabla-productos tbody');

document.getElementById('agregar-fila').addEventListener('click', () => {

    const fila = `
    
    <tr>

        <td>

            <select class="form-select"
                    name="id_producto[]"
                    required>

                <option selected disabled>
                    Seleccionar producto
                </option>

                <?php

                $productos2 = $conexion->query("SELECT * FROM productos");

                while($producto2 = $productos2->fetch_assoc()) {

                ?>

                    <option value="<?php echo $producto2['id_producto']; ?>">

                        <?php echo $producto2['nombre']; ?>

                    </option>

                <?php } ?>

            </select>

        </td>

        <td>

            <input type="number"
                   class="form-control"
                   name="cantidad[]"
                   min="1"
                   required>

        </td>

        <td>

            <div class="input-group">

                <span class="input-group-text">
                    Q
                </span>

                <input type="number"
                       class="form-control"
                       name="monto[]"
                       step="0.01"
                       required>

            </div>

        </td>

        <td class="text-center">

            <button type="button"
                    class="btn btn-danger btn-sm eliminar-fila">

                X

            </button>

        </td>

    </tr>
    
    `;

    tabla.insertAdjacentHTML('beforeend', fila);

});

document.addEventListener('click', function(e){

    if(e.target.classList.contains('eliminar-fila')){

        e.target.closest('tr').remove();

    }

});

</script>

</body>
</html>