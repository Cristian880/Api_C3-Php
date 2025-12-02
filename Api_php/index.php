<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
require_once 'invent.php';
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $item = getIventById($id);
            echo json_encode($item);
        } else {
            $items = getAllItems();
            echo json_encode($items);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if(!empty($data['descripcion']) && isset($data['cantidad'])){
            $descripcion = $data['descripcion'];
            $cantidad = $data['cantidad'];
            echo json_encode(['success' => createInvent($descripcion, $cantidad)]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos"]);
            exit();
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['id']) || empty($data['descripcion']) || !isset($data['cantidad'])) {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos"]);
            exit();
        }
        $id = intval($data['id'] ?? 0);
        $descripcion = $data['descripcion'] ?? '';
        $cantidad = $data['cantidad'] ?? 0;
        $result = updateInvent($id, $descripcion, $cantidad);
        echo json_encode($result);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID es requerido"]);
            exit();
        }
        $id = intval($data['id'] ?? 0);
        $result = deleteInvent($id);
        echo json_encode($result);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Metodo no permitido"]);
        break;
}
?>