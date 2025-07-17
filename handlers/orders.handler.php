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
    $productIds = $_POST['product_id'] ?? [];
    $quantities = $_POST['quantity'] ?? [];

    if (!is_numeric($totalAmount) || empty($productIds) || empty($quantities)) {
        die('Invalid form submission.');
    }

    $order = [
        'user_id' => $user['user_id'],
        'total_amount' => (float) $totalAmount,
        'status' => $status
    ];

    // Step 1: Insert into orders table
    $pdo = connectOrdersDB();

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_amount, status)
            VALUES (:user_id, :total_amount, :status)
            RETURNING order_id
        ");
        $stmt->execute([
            ':user_id' => $order['user_id'],
            ':total_amount' => $order['total_amount'],
            ':status' => $order['status']
        ]);

        $orderId = $stmt->fetchColumn();

        // Step 2: Insert into order_items table
        $itemStmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity)
            VALUES (:order_id, :product_id, :quantity)
        ");

        foreach ($productIds as $index => $productId) {
            $quantity = (int) $quantities[$index];

            if ($quantity > 0) {
                $itemStmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $productId,
                    ':quantity' => $quantity
                ]);
            }
        }

        $pdo->commit();
        header('Location: /pages/orders/index.php?success=1');
        exit;
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Order failed: " . $e->getMessage();
    }
}
