<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_POST['id_proveedor'];

$empresa = $_POST['nombre_empresa'];

$nit = $_POST['nit'];

$telefono = $_POST['telefono'];

$correo = $_POST['correo'];

$sql = "UPDATE proveedores
        SET nombre_empresa = '$empresa',
            nit = '$nit',
            telefono = '$telefono',
            correo = '$correo'
        WHERE id_proveedor = '$id'";

if($conexion->query($sql)){

    header("Location: proveedores.php");

}else{

    echo "Error al actualizar proveedor";

}

?>