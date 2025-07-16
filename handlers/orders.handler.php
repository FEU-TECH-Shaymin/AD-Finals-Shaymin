<?php
declare(strict_types=1);

require_once UTILS_PATH . '/orders.util.php';
require_once UTILS_PATH . '/auth.util.php';
Auth::init();

$action = $_GET['action'] ?? $_POST['action'] ?? null;

switch ($action) {
    case 'getAll':
        if (!Auth::isAdmin()) {
            http_response_code(403);
            echo json_encode(['error' => 'Admin access only']);
            exit;
        }
        echo json_encode(OrdersUtil::getAll());
        break;

    case 'get':
        $id = $_GET['id'] ?? '';
        echo json_encode(OrdersUtil::getById($id));
        break;

    case 'getByUser':
        if (!Auth::check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Login required']);
            exit;
        }
        $userId = $_SESSION['user']['user_id'];
        echo json_encode(OrdersUtil::getByUser($userId));
        break;

    case 'create':
        if (!Auth::check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Login required']);
            exit;
        }
        $data = [
            'user_id' => $_SESSION['user']['user_id'],
            'total_amount' => $_POST['total_amount'],
            'status' => $_POST['status'] ?? 'pending',
        ];
        echo json_encode(['success' => OrdersUtil::create($data)]);
        break;

    case 'updateStatus':
        if (!Auth::isAdmin()) {
            http_response_code(403);
            echo json_encode(['error' => 'Admin access only']);
            exit;
        }
        $id = $_POST['order_id'];
        $status = $_POST['status'];
        echo json_encode(['success' => OrdersUtil::updateStatus($id, $status)]);
        break;

    case 'delete':
        if (!Auth::isAdmin()) {
            http_response_code(403);
            echo json_encode(['error' => 'Admin access only']);
            exit;
        }
        $id = $_POST['order_id'];
        echo json_encode(['success' => OrdersUtil::delete($id)]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
}
