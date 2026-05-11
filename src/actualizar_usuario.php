<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$id = $_POST['id_empleado'];

$nombre = $_POST['nombre_completo'];

$usuario = $_POST['usuario'];

$correo = $_POST['correo'];

$id_rol = $_POST['id_rol'];

$estado = $_POST['estado'];

$sql = "UPDATE empleados 
        SET nombre_completo = '$nombre',
            usuario = '$usuario',
            correo = '$correo',
            id_rol = '$id_rol',
            estado = '$estado'
        WHERE id_empleado = '$id'";

if($conexion->query($sql)){

    header("Location: usuarios.php");

}else{

    echo "Error al actualizar usuario";

}

?>