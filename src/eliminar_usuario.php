<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_GET['id'];

if($id == 1){

    echo "<script>
        alert('No se puede eliminar el administrador principal');
        window.location='usuarios.php';
    </script>";

    exit();
}

$sql = "DELETE FROM empleados 
        WHERE id_empleado = '$id'";

if($conexion->query($sql)){

    header("Location: usuarios.php");

}else{

    echo "Error al eliminar usuario";

}

?>