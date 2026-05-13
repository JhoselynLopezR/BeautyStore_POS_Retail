<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$cuentas = $conexion->query("SELECT cuentas_por_cobrar.*,
                                    clientes.nombre

                             FROM cuentas_por_cobrar

                             INNER JOIN facturas
                             ON cuentas_por_cobrar.id_factura = facturas.id_factura

                             INNER JOIN clientes
                             ON facturas.id_cliente = clientes.id_cliente

                             WHERE cuentas_por_cobrar.estado != 'pagado'

                             ORDER BY cuentas_por_cobrar.id_cpc DESC");

if(isset($_POST['guardar'])){

    $id_cpc = $_POST['id_cpc'];

    $monto = $_POST['monto'];

    $metodo_pago = $_POST['metodo_pago'];

    $descripcion = $_POST['descripcion'];

    $sql_pago = "INSERT INTO pagos_clientes
                 (id_cpc,
                  monto,
                  metodo_pago,
                  descripcion)

                 VALUES

                 ('$id_cpc',
                  '$monto',
                  '$metodo_pago',
                  '$descripcion')";

    if($conexion->query($sql_pago)){

        $sql_saldo = "UPDATE cuentas_por_cobrar
                      SET saldo_total = saldo_total - '$monto'
                      WHERE id_cpc = '$id_cpc'";

        $conexion->query($sql_saldo);

        $consulta = $conexion->query("SELECT saldo_total
                                      FROM cuentas_por_cobrar
                                      WHERE id_cpc = '$id_cpc'");

        $datos = $consulta->fetch_assoc();

        if($datos['saldo_total'] <= 0){

            $conexion->query("UPDATE cuentas_por_cobrar
                              SET estado = 'pagado',
                                  saldo_total = 0
                              WHERE id_cpc = '$id_cpc'");

        }else{

            $conexion->query("UPDATE cuentas_por_cobrar
                              SET estado = 'parcial'
                              WHERE id_cpc = '$id_cpc'");

        }

        header("Location: pagos_clientes.php");

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

    <title>Registrar Pago Cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Registrar Pago Cliente
            </h2>

            <a href="pagos_clientes.php"
               class="btn btn-dark">

               Volver

            </a>

        </div>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Cuenta por cobrar
                </label>

                <select name="id_cpc"
                        class="form-select"
                        required>

                    <option value="" disabled selected>
                        Seleccionar cuenta
                    </option>

                    <?php while($cuenta = $cuentas->fetch_assoc()) { ?>

                        <option value="<?php echo $cuenta['id_cpc']; ?>">

                            Cliente:
                            <?php echo $cuenta['nombre']; ?>

                            - Saldo:
                            Q<?php echo $cuenta['saldo_total']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="mb-3">

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

            <div class="mb-3">

                <label class="form-label">
                    Método pago
                </label>

                <select name="metodo_pago"
                        class="form-select"
                        required>

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