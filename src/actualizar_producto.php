<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_POST['id_producto'];

$id_categoria = $_POST['id_categoria'];

$id_proveedor = $_POST['id_proveedor'];

$nombre = $_POST['nombre'];

$marca = $_POST['marca'];

$tono = $_POST['tono'];

$fecha_vencimiento = $_POST['fecha_vencimiento'];

$precio_costo = $_POST['precio_costo'];

$precio_venta = $_POST['precio_venta'];

$stock_actual = $_POST['stock_actual'];

$stock_minimo = $_POST['stock_minimo'];

$sql = "UPDATE productos
        SET id_categoria = '$id_categoria',
            id_proveedor = '$id_proveedor',
            nombre = '$nombre',
            marca = '$marca',
            tono = '$tono',
            fecha_vencimiento = '$fecha_vencimiento',
            precio_costo = '$precio_costo',
            precio_venta = '$precio_venta',
            stock_actual = '$stock_actual',
            stock_minimo = '$stock_minimo'
        WHERE id_producto = '$id'";

if($conexion->query($sql)){

    header("Location: productos.php");

}else{

    echo "Error al actualizar producto";

}

?>