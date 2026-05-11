<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM productos
        WHERE id_producto = '$id'";

if($conexion->query($sql)){

    header("Location: productos.php");

}else{

    echo "Error al eliminar producto";

}

?>