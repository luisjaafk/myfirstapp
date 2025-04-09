<?php
require_once '../config/conexion.php';

function agregarPermiso($request)
{
    try {
        if (empty($request['nombre_permiso'])) {
            throw new Exception("El nombre del permiso es obligatorio");
        }

        $nombrePermiso = $request['nombre_permiso'];
        $conexion = conectar();
        $sql = "INSERT INTO permisos (nombre_permiso) VALUES ('{$nombrePermiso}')";


        if (!$conexion->query($sql)) {
            throw new Exception("Error en la consulta: " . $conexion->error);
        }

        return true;
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
        return false;
    }
}

function listarPermisos()
{
    $sql = "SELECT * FROM `permisos`";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    if ($resultado) {
        $permisos = $resultado->fetch_all(MYSQLI_ASSOC); 
        return $permisos;
    } else {
        return ["error" => "No se pudieron listar los roles"]; 
    }
}
function eliminarPermiso($id)
{
    $conexion = conectar();

    // Eliminar relaciones del permiso con roles
    $sqlDeleteRelaciones = "DELETE FROM roles_has_permisos WHERE id_permiso = {$id}";
    $conexion->query($sqlDeleteRelaciones);

    // Ahora eliminar el permiso
    $sql = "DELETE FROM permisos WHERE id = {$id}";
    return $conexion->query($sql);
}
function ActualizarPermiso($request)
{
    $sql = "UPDATE `permisos` SET 
    `nombre_permiso`='{$request['nombrePermiso']}'
    WHERE `id` = {$request['id']}";
    $conexion = conectar();
    if ($conexion->query($sql)) {
        return true;
    } else {
        return false;
    }
}

?>
