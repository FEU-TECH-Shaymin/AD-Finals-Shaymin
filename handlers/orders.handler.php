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
    $productIds = $_POST['product_id'] ?? [];
    $quantities = $_POST['quantity'] ?? [];

    if (empty($productIds) || empty($quantities) || count($productIds) !== count($quantities)) {
        die('Invalid form submission.');
    }

    // Step 1: Connect to DB
    $pdo = connectOrdersDB();

    try {
        $pdo->beginTransaction();

        // Step 2: Calculate total price from product IDs and quantities
        $totalAmount = 0;
        $productData = [];

        $inClause = implode(',', array_fill(0, count($productIds), '?'));
        $stmt = $pdo->prepare("SELECT product_id, price FROM products WHERE product_id IN ($inClause)");
        $stmt->execute($productIds);
        $prices = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // [product_id => price]

        foreach ($productIds as $index => $productId) {
            $productId = (int) $productId;
            $quantity = (int) $quantities[$index];

            if ($quantity > 0 && isset($prices[$productId])) {
                $totalAmount += $prices[$productId] * $quantity;
                $productData[] = ['id' => $productId, 'quantity' => $quantity];
            }
        }

        if ($totalAmount <= 0) {
            throw new Exception("Invalid total amount.");
        }

        // Step 3: Insert into orders table
        $orderStmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_amount, status)
            VALUES (:user_id, :total_amount, 'pending')
            RETURNING order_id
        ");
        $orderStmt->execute([
            ':user_id' => $user['user_id'],
            ':total_amount' => $totalAmount
        ]);

        $orderId = $orderStmt->fetchColumn();

        // Step 4: Insert into order_items table
        $itemStmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity)
            VALUES (:order_id, :product_id, :quantity)
        ");

        foreach ($productData as $item) {
            $itemStmt->execute([
                ':order_id' => $orderId,
                ':product_id' => $item['id'],
                ':quantity' => $item['quantity']
            ]);
        }

        $pdo->commit();
        header('Location: /pages/orders/index.php?success=1');
        exit;
    } catch (Throwable $e) {
        $pdo->rollBack();
        echo "Order failed: " . $e->getMessage();
    }
}
