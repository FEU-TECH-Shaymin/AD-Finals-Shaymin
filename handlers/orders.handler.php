<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once VENDOR_PATH . '/autoload.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/envSetter.util.php';
require_once UTILS_PATH . '/orders.util.php';

Auth::init();

$dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $_ENV['PG_HOST'], $_ENV['PG_PORT'], $_ENV['PG_DB']);
$pdo = new PDO($dsn, $_ENV['PG_USER'], $_ENV['PG_PASS'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$action = $_REQUEST['action'] ?? null;

// ✅ 1. User: Create Order
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Auth::check()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $data = [
        'user_id'      => $_SESSION['user']['id'],
        'total_amount' => $_POST['total_amount'] ?? 0,
        'status'       => $_POST['status'] ?? 'pending',
    ];

    echo json_encode(['success' => OrdersUtil::create($pdo, $data)]);
    exit;
}

// ✅ 2. User: View Own Orders
if ($action === 'getByUser') {
    if (!Auth::check()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    echo json_encode(OrdersUtil::getByUser($pdo, $_SESSION['user']['id']));
    exit;
}

// ✅ 3. Admin: View All Orders
if ($action === 'getAll') {
    if (!Auth::check() || $_SESSION['user']['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(['error' => 'Admin access only']);
        exit;
    }

    echo json_encode(OrdersUtil::getAll($pdo));
    exit;
}

// ❌ Fallback for invalid action
http_response_code(400);
echo json_encode(['error' => 'Invalid or missing action']);
