<?php
$host = "127.0.0.1"; //localhost
$usuario = "root";
$clave = "1234";
$bd = "tareasdb";

function conectar(){
    global $host, $usuario, $clave, $bd;
    $conexion = new mysqli($host, $usuario, $clave, $bd);
    if($conexion->connect_error){
        die("Error de conexion: " . $conexion->connect_error);
    }
    return $conexion;
}

?>
