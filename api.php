<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$conexion = new mysqli("mysql-jhonatan1.alwaysdata.net", "jhonatan1", "clase123", "jhonatan1_gestion_usuarios");

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión"]));
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // LISTAR
    case 'GET':
        $result = $conexion->query("SELECT * FROM usuarios");
        $usuarios = [];

        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        echo json_encode($usuarios);
        break;

    // CREAR
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        $nombre = $data['nombre'];
        $cedula = $data['cedula'];
        $telefono = $data['telefono'];

        $sql = "INSERT INTO usuarios (nombre, cedula, telefono)
                VALUES ('$nombre', '$cedula', '$telefono')";

        if ($conexion->query($sql)) {
            echo json_encode(["mensaje" => "Usuario creado"]);
        } else {
            echo json_encode(["error" => "Error al crear"]);
        }
        break;

    // ACTUALIZAR
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data['id'];
        $nombre = $data['nombre'];
        $cedula = $data['cedula'];
        $telefono = $data['telefono'];

        $sql = "UPDATE usuarios 
                SET nombre='$nombre', cedula='$cedula', telefono='$telefono'
                WHERE id=$id";

        if ($conexion->query($sql)) {
            echo json_encode(["mensaje" => "Usuario actualizado"]);
        } else {
            echo json_encode(["error" => "Error al actualizar"]);
        }
        break;

    // ELIMINAR
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];

        $sql = "DELETE FROM usuarios WHERE id=$id";

        if ($conexion->query($sql)) {
            echo json_encode(["mensaje" => "Usuario eliminado"]);
        } else {
            echo json_encode(["error" => "Error al eliminar"]);
        }
        break;
}
?>