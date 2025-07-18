<?php
declare(strict_types=1);

function connectOrdersDB(): PDO {
    // You likely already have this elsewhere, but just to be sure:
    return new PDO('pgsql:host=localhost;port=5112;dbname=your_db_name', 'your_user', 'your_password', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}

function getUserTransactionsWithItems(int $userId): array {
    $pdo = connectOrdersDB();

    // Get all transactions for the user
    $stmt = $pdo->prepare("
        SELECT 
            t.transaction_id,
            t.order_id,
            t.currency,
            t.amount_paid,
            t.total_amount,
            t.change,
            t.status,
            t.transaction_date,
            o.total_amount AS order_total,
            o.status AS order_status
        FROM transactions t
        JOIN orders o ON t.order_id = o.order_id
        WHERE t.user_id = :user_id
        ORDER BY t.transaction_date DESC
    ");
    $stmt->execute([':user_id' => $userId]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // For each transaction, fetch the items
    foreach ($transactions as &$transaction) {
        $itemsStmt = $pdo->prepare("
            SELECT 
                oi.product_id,
                p.name AS product_name,
                p.price,
                oi.quantity,
                (p.price * oi.quantity) AS subtotal
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = :order_id
        ");
        $itemsStmt->execute([':order_id' => $transaction['order_id']]);
        $transaction['items'] = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $transactions;
}
