<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/orders.util.php';
require_once UTILS_PATH . '/auth.util.php';

Auth::init();
$user = Auth::user();

if (!$user) {
    header('Location: /pages/login/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalAmount = $_POST['total_amount'] ?? null;
    $status = $_POST['status'] ?? 'pending';

    if (!is_numeric($totalAmount)) {
        die('Invalid total amount.');
    }

    $order = [
        'user_id' => $user['user_id'],
        'total_amount' => (float) $totalAmount,
        'status' => $status
    ];

    $result = insertOrder($order);

    if ($result['success']) {
        header('Location: /pages/orders/index.php?success=1');
    } else {
        echo "Order failed: " . $result['message'];
    }
}
