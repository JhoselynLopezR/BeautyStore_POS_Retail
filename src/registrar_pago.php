<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$cuentas = $conexion->query("SELECT cuentas_por_pagar.*,
                                    proveedores.nombre_empresa

                             FROM cuentas_por_pagar

                             INNER JOIN compras
                             ON cuentas_por_pagar.id_compra = compras.id_compra

                             INNER JOIN proveedores
                             ON compras.id_proveedor = proveedores.id_proveedor

                             WHERE cuentas_por_pagar.estado != 'pagado'");

if(isset($_POST['guardar'])){

    $id_cpp = $_POST['id_cpp'];

    $monto = $_POST['monto'];

    $metodo_pago = $_POST['metodo_pago'];

    $descripcion = $_POST['descripcion'];

    $sql_pago = "INSERT INTO pagos_proveedores
                 (id_cpp,
                  monto,
                  metodo_pago,
                  descripcion)

                 VALUES

                 ('$id_cpp',
                  '$monto',
                  '$metodo_pago',
                  '$descripcion')";

    if($conexion->query($sql_pago)){

        $sql_saldo = "UPDATE cuentas_por_pagar
                      SET saldo_total = saldo_total - $monto
                      WHERE id_cpp = '$id_cpp'";

        $conexion->query($sql_saldo);

        $consulta = $conexion->query("SELECT saldo_total
                                      FROM cuentas_por_pagar
                                      WHERE id_cpp = '$id_cpp'");

        $datos = $consulta->fetch_assoc();

        if($datos['saldo_total'] <= 0){

            $conexion->query("UPDATE cuentas_por_pagar
                              SET estado = 'pagado',
                                  saldo_total = 0
                              WHERE id_cpp = '$id_cpp'");

        }else{

            $conexion->query("UPDATE cuentas_por_pagar
                              SET estado = 'parcial'
                              WHERE id_cpp = '$id_cpp'");

        }

        header("Location: pagos_proveedores.php");

    }else{

        echo "Error al registrar pago";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registrar Pago</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Registrar Pago
            </h2>

            <a href="pagos_proveedores.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Cuenta por pagar
                </label>

                <select name="id_cpp"
                        class="form-select"
                        required>

                    <option value="" disabled selected>
                        Seleccionar cuenta
                    </option>

                    <?php while($cuenta = $cuentas->fetch_assoc()) { ?>

                        <option value="<?php echo $cuenta['id_cpp']; ?>">

                            <?php echo $cuenta['nombre_empresa']; ?>
                            -
                            Saldo: Q<?php echo $cuenta['saldo_total']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="row">

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

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Método pago
                    </label>

                    <select name="metodo_pago"
                            class="form-select"
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

                        <option value="tarjeta">
                            Tarjeta
                        </option>

                    </select>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Descripción
                </label>

                <textarea name="descripcion"
                          class="form-control"
                          rows="3"></textarea>

            </div>

            <button type="submit"
                    name="guardar"
                    class="btn btn-success px-4">

                Registrar Pago

            </button>

        </form>

    </div>

</div>

</body>
</html>