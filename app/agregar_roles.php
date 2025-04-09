<?php
require_once '../config/conexion.php';

function agregarRol($request)
{
    try {
        if (empty($request['nombre_rol'])) {
            throw new Exception("El nombre del rol es obligatorio");
        }

        $nombreRol = $request['nombre_rol'];
        $conexion = conectar();
        $sql = "INSERT INTO roles (nombre_rol) VALUES ('{$nombreRol}')";

        if (!$conexion->query($sql)) {
            throw new Exception("Error en la consulta: " . $conexion->error);
        }

        return true;
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
        return false;
    }
}

function listarRoles()
{
    $sql = "SELECT * FROM `roles`";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    if ($resultado) {
        $roles = $resultado->fetch_all(MYSQLI_ASSOC); 
        return $roles;
    } else {
        return ["error" => "No se pudieron listar los roles"]; 
    }
}
function eliminarRol($id)
{
    $conexion = conectar();
    $sqlDeleteRelaciones = "DELETE FROM roles_has_permisos WHERE id_rol = {$id}";
    $conexion->query($sqlDeleteRelaciones);
    $sql = "DELETE FROM roles WHERE id = {$id}";
    return $conexion->query($sql);
}
function ActualizarRol($request)
{
    $sql = "UPDATE `roles` SET 
    `nombre_rol`='{$request['nombreRol']}'
    WHERE `id` = {$request['id']}";
    $conexion = conectar();
    if ($conexion->query($sql)) {
        return true;
    } else {
        return false;
    }
}

?>
