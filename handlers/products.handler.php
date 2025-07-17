<?php
declare(strict_types=1);

require_once UTILS_PATH . '/products.util.php';

// Parse action from GET or POST
$action = $_GET['action'] ?? $_POST['action'] ?? null;

switch ($action) {
    case 'getAll':
        echo json_encode(ProductsUtil::getAll());
        break;

    case 'get':
        $id = $_GET['id'] ?? '';
        echo json_encode(ProductsUtil::getById($id));
        break;

    case 'create':
        $data = $_POST;
        echo json_encode(['success' => ProductsUtil::create($data)]);
        break;

    case 'update':
        $id = $_POST['product_id'];
        $data = $_POST;
        echo json_encode(['success' => ProductsUtil::update($id, $data)]);
        break;

    case 'delete':
        $id = $_POST['product_id'];
        echo json_encode(['success' => ProductsUtil::delete($id)]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
}
