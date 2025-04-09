<?php
require_once '../config/conexion.php';
require_once '../config/jwt.php';
require_once '../app/users.php';
require_once '../app/auth.php';
require_once '../app/agregar_roles.php'; 
require_once '../app/agregar_permiso.php'; 
require_once '../app/PermisoToRol.php'; 

header('Content-Type: application/json');

$request = json_decode(file_get_contents("php://input"), true);

if (
    $_SERVER['REQUEST_URI'] == '/registrar/users'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {

    $respuesta = crearUsuario($request);
    if ($respuesta) {
        echo json_encode([
            "mensaje" => "Registro exitoso"
        ]);
    } else {
        echo json_encode([
            "mensaje" => "Hubo un error"
        ]);
    }

} elseif (
    $_SERVER['REQUEST_URI'] == '/listar/users'
    and $_SERVER['REQUEST_METHOD'] == 'GET'
) {

    $usuarios = listarUsuarios();
    echo json_encode($usuarios);

} elseif
(
    $_SERVER['REQUEST_URI'] == '/login'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {

    $usuario = iniciarSesion($request);

if ($usuario) {
    $token = generarJWTToken($usuario);
    echo json_encode([
        'usuario' => $usuario,
        'token' => $token
    ]);
} else {
    echo json_encode([
        'error' => 'Usuario o contraseña incorrectos'
    ]);
}
}  elseif (
    $_SERVER['REQUEST_URI'] == '/addrol'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $respuesta = agregarRol($request);

    if ($respuesta) {
        echo json_encode([
            "mensaje" => "Rol agregado exitosamente"
        ]);
    } else {
        echo json_encode([
            "mensaje" => "Hubo un error al agregar el rol"
        ]);
    }

}elseif (
    $_SERVER['REQUEST_URI'] == '/listar/roles'
    and $_SERVER['REQUEST_METHOD'] == 'GET'
) {

    $roles = listarRoles();
    echo json_encode($roles);

}elseif (
    $_SERVER['REQUEST_URI'] == '/addPermisoTuRon'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $respuesta = asignarPermisoARol($request);

    if ($respuesta) {
        echo json_encode([
            "mensaje" => "Permiso agregado exitosamente"
        ]);
    } else {
        echo json_encode([
            "mensaje" => "Hubo un error al agregar el permiso"
        ]);
    }

}elseif (
    $_SERVER['REQUEST_URI'] == '/addpermisos'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $respuesta = agregarPermiso($request);

    if ($respuesta) {
        echo json_encode([
            "mensaje" => "Permiso agregado exitosamente"
        ]);
    } else {
        echo json_encode([
            "mensaje" => "Hubo un error al agregar el permiso"
        ]);
    }

} elseif (
    $_SERVER['REQUEST_URI'] == '/obtener/usuarios'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $request = json_decode(file_get_contents("php://input"), true);
    $id = $request['id'] ?? null;

    if ($id !== null) {
        $usuarios = ObtenerUsuarios($id);
        echo json_encode($usuarios);
    } else {
        echo json_encode(["error" => "Falta el parámetro id"]);
    }
}
elseif (
    $_SERVER['REQUEST_URI'] == '/listar/permisos'
    and $_SERVER['REQUEST_METHOD'] == 'GET'
) {

    $permiso = listarPermisos();
    echo json_encode($permiso);
} elseif (
    $_SERVER['REQUEST_URI'] == '/eliminar/usuario'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $id = $request['id'] ?? null;

    if (!$id) {
        echo json_encode(["error" => "Falta el parámetro id"]);
        return;
    }

    if (eliminarUsuario($id)) {
        echo json_encode(["mensaje" => "Usuario eliminado exitosamente"]);
    } else {
        echo json_encode(["error" => "Hubo un error al eliminar el usuario"]);
    }
}
elseif (
    $_SERVER['REQUEST_URI'] == '/actualizar/usuario'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {

    $permiso = ActualizarUsuario($request);
    if ($permiso) {
        echo json_encode([
            "mensaje" => "Usuario actualizado exitosamente"
        ]);
    } else {
        echo json_encode([
            "mensaje" => "Hubo un error al actualizar el usuario"
        ]);
    }
    echo json_encode($permiso);
}elseif (
    $_SERVER['REQUEST_URI'] == '/actualizar/rol'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {

    $permiso = ActualizarRol($request);
    if ($permiso) {
        echo json_encode([
            "mensaje" => "Rol actualizado exitosamente"
        ]);
    } else {
        echo json_encode([
            "mensaje" => "Hubo un error al actualizar el rol"
        ]);
    }
    echo json_encode($permiso);
}elseif (
    $_SERVER['REQUEST_URI'] == '/actualizar/permiso'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {

    $permiso = ActualizarPermiso($request);
    if ($permiso) {
        echo json_encode([
            "mensaje" => "Permiso actualizado exitosamente"
        ]);
    } else {
        echo json_encode([
            "mensaje" => "Hubo un error al actualizar el permiso"
        ]);
    }
    echo json_encode($permiso);
}  elseif (
    $_SERVER['REQUEST_URI'] == '/eliminar/rol'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $id = $request['id'] ?? null;

    if (!$id) {
        echo json_encode(["error" => "Falta el parámetro id"]);
        return;
    }

    if (eliminarRol($id)) {
        echo json_encode(["mensaje" => "Rol eliminado exitosamente"]);
    } else {
        echo json_encode(["error" => "Hubo un error al eliminar el rol"]);
    }
} elseif (
    $_SERVER['REQUEST_URI'] == '/eliminar/permiso'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $id = $request['id'] ?? null;

    if (!$id) {
        echo json_encode(["error" => "Falta el parámetro id"]);
        return;
    }

    if (eliminarPermiso($id)) {
        echo json_encode(["mensaje" => "Permiso eliminado exitosamente"]);
    } else {
        echo json_encode(["error" => "Hubo un error al eliminar el permiso"]);
    }

}else {
    echo json_encode(['error' => 'Ruta no encontrada']);
}


?>
