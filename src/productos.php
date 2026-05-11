<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT productos.*, 
               categorias.nombre_categoria,
               proveedores.nombre_empresa
        FROM productos
        INNER JOIN categorias
        ON productos.id_categoria = categorias.id_categoria
        INNER JOIN proveedores
        ON productos.id_proveedor = proveedores.id_proveedor
        ORDER BY productos.id_producto ASC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'creado'){ ?>

    <div class="position-fixed top-0 start-50 translate-middle-x p-3"
         style="z-index: 9999">

        <div class="alert alert-success shadow"
             id="alerta-exito">

            Producto registrado correctamente.

        </div>

    </div>

<?php } ?>

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Gestión de Productos</h2>

            <div>

                <a href="crear_producto.php"
                   class="btn btn-success me-2">

                   Nuevo Producto

                </a>

                <a href="dashboard.php"
                   class="btn btn-dark">

                   Volver

                </a>

            </div>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Marca</th>
                    <th>Tono</th>

                    <th>
                        Precio&nbsp;Venta
                    </th>

                    <th>Stock</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td><?php echo $fila['id_producto']; ?></td>

                    <td><?php echo $fila['nombre']; ?></td>

                    <td><?php echo $fila['nombre_categoria']; ?></td>

                    <td><?php echo $fila['nombre_empresa']; ?></td>

                    <td><?php echo $fila['marca']; ?></td>

                    <td><?php echo $fila['tono']; ?></td>

                    <td>
                        Q <?php echo $fila['precio_venta']; ?>
                    </td>

                    <td><?php echo $fila['stock_actual']; ?></td>

                    <td class="text-nowrap">

                        <a href="editar_producto.php?id=<?php echo $fila['id_producto']; ?>"
                           class="btn btn-warning btn-sm me-1 px-3">

                           Editar

                        </a>

                        <a href="eliminar_producto.php?id=<?php echo $fila['id_producto']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Desea eliminar este producto?')">

                           Eliminar

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<script>

setTimeout(() => {

    const alerta = document.getElementById('alerta-exito');

    if(alerta){
        alerta.style.display = 'none';
    }

}, 3000);

</script>

</body>
</html>