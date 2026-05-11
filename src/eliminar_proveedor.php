<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM proveedores
        WHERE id_proveedor = '$id'";

if($conexion->query($sql)){

    header("Location: proveedores.php");

}else{

    echo "Error al eliminar proveedor";

}

?>