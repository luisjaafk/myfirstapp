<?php
require_once '../config/conexion.php';

function asignarPermisoARol($request)
{
    try {
        if (empty($request['id_rol']) || empty($request['id_permiso'])) {
            throw new Exception("El rol y el permiso son obligatorios");
        }

        $idRol = $request['id_rol'];
        $idPermiso = $request['id_permiso'];

        $conexion = conectar();

        $sqlVerificarRol = "SELECT * FROM roles WHERE id = ?";
        $sqlVerificarPermiso = "SELECT * FROM permisos WHERE id = ?";

        $stmtRol = $conexion->prepare($sqlVerificarRol);
        $stmtRol->bind_param("i", $idRol); 
        $stmtRol->execute();
        $resultadoRol = $stmtRol->get_result();

        $stmtPermiso = $conexion->prepare($sqlVerificarPermiso);
        $stmtPermiso->bind_param("i", $idPermiso); 
        $stmtPermiso->execute();
        $resultadoPermiso = $stmtPermiso->get_result();

        if ($resultadoRol->num_rows == 0) {
            throw new Exception("El rol no existe");
        }
        if ($resultadoPermiso->num_rows == 0) {
            throw new Exception("El permiso no existe");
        }

        $sql = "INSERT INTO roles_has_permisos (id_rol, id_permiso) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $idRol, $idPermiso); 
        if ($stmt->execute()) {
            $stmt->close();
            $conexion->close();
            return true;
        } else {
            throw new Exception("Error al asignar el permiso al rol: " . $conexion->error);
        }

    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
        return false;
    }
}
?>
