<?php

$host = "localhost";
$usuario = "admin_jhoss";
$password = "admin_jhoss";
$bd = "Proyecto_Ventas";

$conexion = new mysqli($host, $usuario, $password, $bd);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>