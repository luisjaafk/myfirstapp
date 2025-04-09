<?php
function crearUsuario($request)
{
    try {
        $passwordHash = password_hash($request['password'], PASSWORD_BCRYPT);
        $sql = "INSERT INTO `users`(`id`, `nombre`, `apellido`, `email`, `password`, `id_rol`)
        VALUES (null, '{$request['nombre']}', '{$request['apellido']}', '{$request['email']}', '{$passwordHash}', {$request['id_rol']})";
        $conexion = conectar();
        if (!$conexion->query($sql)) {
            throw new Exception("Error en la consulta: " . $conexion->error);
        }
        return true;
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
        return false;
    }
}

function listarUsuarios()
{
    $sql = "SELECT * FROM `users`";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
    return $usuarios;
}
function ObtenerUsuarios($id)
{
    $sql = "SELECT * FROM `users` WHERE `id` = {$id}";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
    return $usuarios;
}
function eliminarUsuario($id)
{
    $sql = "DELETE FROM `users` WHERE `id` = {$id}";
    $conexion = conectar();
    if ($conexion->query($sql)) {
        return true;
    } else {
        return false;
    }
}
function ActualizarUsuario($request)
{
    $sql = "UPDATE `users` SET 
    `nombre`='{$request['nombre']}',
    `apellido`='{$request['apellido']}',
    `email`='{$request['email']}',
    `id_rol`={$request['id_rol']} 
    WHERE `id` = {$request['id']}";
    $conexion = conectar();
    if ($conexion->query($sql)) {
        return true;
    } else {
        return false;
    }
}