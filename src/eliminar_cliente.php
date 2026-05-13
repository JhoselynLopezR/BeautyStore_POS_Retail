<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "DELETE FROM clientes
            WHERE id_cliente = '$id'";

    if($conexion->query($sql)){

        header("Location: clientes.php");

    }else{

        echo "Error al eliminar cliente";

    }

}else{

    header("Location: clientes.php");

}

?>