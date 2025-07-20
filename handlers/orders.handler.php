<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/orders.util.php';
require_once UTILS_PATH . '/transactions.util.php';
require_once UTILS_PATH . '/auth.util.php';

Auth::init();
$user = Auth::user();

if (!$user) {
    header('Location: /pages/login/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderItemsRaw = $_POST['order_items'] ?? '';
    $orderItems = json_decode($orderItemsRaw, true);

    if (!is_array($orderItems) || empty($orderItems)) {
        die('Invalid or missing order items.');
    }

    $productIds = [];
    $quantities = [];

    foreach ($orderItems as $item) {
        if (!isset($item['product_id'], $item['quantity'])) {
            die('Invalid item structure.');
        }
        $productIds[] = $item['product_id'];
        $quantities[] = $item['quantity'];
    }

    if (!is_array($productIds)) {
        $productIds = [$productIds];
    }
    if (!is_array($quantities)) {
        $quantities = [$quantities];
    }

    if (empty($productIds) || empty($quantities) || count($productIds) !== count($quantities)) {
        die('Invalid form submission.');
    }

    $pdo = connectOrdersDB();

    try {
        $pdo->beginTransaction();

        // ✅ Fetch product prices
        $productPrices = fetchProductPrices($productIds);

        if (count($productPrices) !== count($productIds)) {
            throw new Exception("One or more selected products do not exist.");
        }

        $totalAmount = 0;
        $productData = [];

        foreach ($productIds as $index => $productId) {
            $productId = (string) $productId;
            $quantity = (int) $quantities[$index];

            if ($quantity > 0 && isset($productPrices[$productId])) {
                $totalAmount += $productPrices[$productId] * $quantity;
                $productData[] = [
                    'id' => $productId,
                    'quantity' => $quantity
                ];
            }
        }

        if ($totalAmount <= 0 || empty($productData)) {
            throw new Exception("Invalid total amount or no valid products.");
        }

        // ✅ Insert order
        $orderResult = insertOrder([
            'user_id' => $user['user_id'],
            'total_amount' => $totalAmount,
            'status' => 'pending'
        ]);

        if (!$orderResult['success']) {
            throw new Exception("Failed to create order: " . $orderResult['message']);
        }

        $orderId = $orderResult['order_id'];

        // ✅ Insert order items
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

        // ✅ Get amount paid from POST
        $amountPaid = isset($_POST['amount_paid']) ? floatval($_POST['amount_paid']) : 0;

        // ✅ Compute change
        $change = $amountPaid - $totalAmount;

        // ✅ Insert transaction
        $transactionStmt = $pdo->prepare("
            INSERT INTO transactions (
                user_id, order_id, currency, amount_paid, total_amount, status, transaction_date
            ) VALUES (
                :user_id, :order_id, :currency, :amount_paid, :total_amount, 'completed', NOW()
            )
        ");
        $transactionStmt->execute([
            ':user_id' => $user['user_id'],
            ':order_id' => $orderId,
            ':currency' => 'Zombie Crystal',
            ':amount_paid' => $amountPaid,
            ':total_amount' => $totalAmount,
        ]);

        $pdo->commit();

        header('Location: /pages/transaction/index.php?success=1');
        exit;
    } catch (Throwable $e) {
        $pdo->rollBack();
        echo "Order failed: " . $e->getMessage();
    }
}
