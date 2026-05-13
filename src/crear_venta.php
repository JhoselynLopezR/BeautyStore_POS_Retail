<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$clientes = $conexion->query("SELECT * FROM clientes");

$productos = $conexion->query("SELECT * FROM productos");

if(isset($_POST['id_cliente'])){

    $id_cliente = $_POST['id_cliente'];

    $productos_post = $_POST['id_producto'];

    $cantidades = $_POST['cantidad'];

    $precios = $_POST['precio'];

    $subtotales = $_POST['subtotal'];

    $metodo_pago = $_POST['metodo_pago'];

    $total = 0;

    foreach($subtotales as $subtotal){

        $valor = str_replace('Q', '', $subtotal);

        $total += floatval($valor);

    }

    $id_empleado = $_SESSION['id_empleado'];

    $numero_factura = "FAC-" . time();

    $sql_factura = "INSERT INTO facturas
                    (id_cliente,
                     id_empleado,
                     numero_factura,
                     total,
                     metodo_pago)

                    VALUES

                    ('$id_cliente',
                     '$id_empleado',
                     '$numero_factura',
                     '$total',
                     '$metodo_pago')";

    if($conexion->query($sql_factura)){

        $id_factura = $conexion->insert_id;

        for($i = 0; $i < count($productos_post); $i++){

            $id_producto = $productos_post[$i];

            $cantidad = $cantidades[$i];

            $precio = $precios[$i];

            $subtotal = str_replace('Q', '', $subtotales[$i]);

            $consulta_stock = $conexion->query("SELECT stock_actual
                                                FROM productos
                                                WHERE id_producto = '$id_producto'");

            $datos_stock = $consulta_stock->fetch_assoc();

            $stock_actual = $datos_stock['stock_actual'];

            if($cantidad > $stock_actual){

                $conexion->query("DELETE FROM detalle_facturas
                                  WHERE id_factura = '$id_factura'");

                $conexion->query("DELETE FROM facturas
                                  WHERE id_factura = '$id_factura'");

                echo "

                <script>

                    alert('Stock insuficiente para realizar la venta');

                    window.location='crear_venta.php';

                </script>

                ";

                exit();

            }

            $sql_detalle = "INSERT INTO detalle_facturas
                            (id_factura,
                             id_producto,
                             cantidad,
                             precio_unitario,
                             subtotal)

                            VALUES

                            ('$id_factura',
                             '$id_producto',
                             '$cantidad',
                             '$precio',
                             '$subtotal')";

            $conexion->query($sql_detalle);

            $sql_stock = "UPDATE productos
                          SET stock_actual = stock_actual - $cantidad
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
                            'VENTA',
                            '$cantidad',
                            (SELECT stock_actual
                             FROM productos
                             WHERE id_producto = '$id_producto'),
                            'Salida por venta $numero_factura')";

            $conexion->query($sql_kardex);

        }

        if($metodo_pago == 'credito'){

            $fecha_vencimiento = date('Y-m-d', strtotime('+30 days'));

            $sql_cxc = "INSERT INTO cuentas_por_cobrar
                        (id_factura,
                         saldo_total,
                         fecha_vencimiento,
                         estado)

                         VALUES

                         ('$id_factura',
                          '$total',
                          '$fecha_vencimiento',
                          'pendiente')";

            $conexion->query($sql_cxc);

        }

        header("Location: ventas.php?mensaje=creado");

    }else{

        echo "Error al registrar venta";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Nueva Venta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Nueva Venta
            </h2>

            <a href="ventas.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form method="POST">

            <div class="mb-4">

                <label class="form-label">
                    Cliente
                </label>

                <select class="form-select"
                        name="id_cliente"
                        required>

                    <option selected disabled>
                        Seleccionar cliente
                    </option>

                    <?php while($cliente = $clientes->fetch_assoc()) { ?>

                        <option value="<?php echo $cliente['id_cliente']; ?>">

                            <?php echo $cliente['nombre']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered align-middle"
                       id="tabla-productos">

                    <thead class="table-dark">

                        <tr>

                            <th>Producto</th>
                            <th width="120">Cantidad</th>
                            <th width="150">Precio</th>
                            <th width="150">Subtotal</th>
                            <th width="100">Acción</th>

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
                                       class="form-control cantidad"
                                       name="cantidad[]"
                                       min="1">

                            </td>

                            <td>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Q
                                    </span>

                                    <input type="number"
                                           class="form-control precio"
                                           name="precio[]"
                                           step="0.01">

                                </div>

                            </td>

                            <td>

                                <input type="text"
                                       class="form-control subtotal"
                                       name="subtotal[]"
                                       readonly>

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

            <div class="d-flex justify-content-end mt-5">

                <div class="border rounded-4 shadow-sm p-4 bg-white"
                     style="min-width: 320px;">

                    <div class="text-end mb-4">

                        <h4 class="fw-bold">

                            Total:
                            <span class="text-success">
                                Q0.00
                            </span>

                        </h4>

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Método pago
                        </label>

                        <select class="form-select"
                                name="metodo_pago"
                                required>

                            <option value="" disabled selected>
                                Seleccionar método
                            </option>

                            <option value="efectivo">
                                Efectivo
                            </option>

                            <option value="transferencia">
                                Transferencia
                            </option>

                            <option value="credito">
                                Crédito
                            </option>

                        </select>

                    </div>

                    <button type="submit"
                            class="btn btn-success w-100">

                        Registrar Venta

                    </button>

                </div>

            </div>

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
                   class="form-control cantidad"
                   name="cantidad[]"
                   min="1">

        </td>

        <td>

            <div class="input-group">

                <span class="input-group-text">
                    Q
                </span>

                <input type="number"
                       class="form-control precio"
                       name="precio[]"
                       step="0.01">

            </div>

        </td>

        <td>

            <input type="text"
                   class="form-control subtotal"
                   name="subtotal[]"
                   readonly>

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

document.addEventListener('input', function(e){

    const fila = e.target.closest('tr');

    if(!fila) return;

    const cantidad = fila.querySelector('.cantidad');

    const precio = fila.querySelector('.precio');

    const subtotal = fila.querySelector('.subtotal');

    const totalTexto = document.querySelector('.text-success');

    let cantidadValor = parseFloat(cantidad.value) || 0;

    let precioValor = parseFloat(precio.value) || 0;

    let resultado = cantidadValor * precioValor;

    subtotal.value = "Q" + resultado.toFixed(2);

    let totalGeneral = 0;

    document.querySelectorAll('.subtotal').forEach(campo => {

        let valor = campo.value.replace('Q', '');

        totalGeneral += parseFloat(valor) || 0;

    });

    totalTexto.textContent = "Q" + totalGeneral.toFixed(2);

});

document.addEventListener('click', function(e){

    if(e.target.classList.contains('eliminar-fila')){

        e.target.closest('tr').remove();

        let totalGeneral = 0;

        document.querySelectorAll('.subtotal').forEach(campo => {

            let valor = campo.value.replace('Q', '');

            totalGeneral += parseFloat(valor) || 0;

        });

        document.querySelector('.text-success').textContent =
            "Q" + totalGeneral.toFixed(2);

    }

});

</script>

</body>
</html>