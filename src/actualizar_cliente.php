<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_POST['id_cliente'];

$nombre = $_POST['nombre'];

$nit = $_POST['nit'];

$telefono = $_POST['telefono'];

$correo = $_POST['correo'];

$sql = "UPDATE clientes

        SET nombre = '$nombre',
            nit = '$nit',
            telefono = '$telefono',
            correo = '$correo'

        WHERE id_cliente = '$id'";

if($conexion->query($sql)){

    header("Location: clientes.php");

}else{

    echo "Error al actualizar cliente";

}

?>