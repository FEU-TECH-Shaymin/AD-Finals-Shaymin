<?php
declare(strict_types=1);

function connectTransactionsDB(): PDO {
    return new PDO(
        sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $_ENV['PG_HOST'],
            $_ENV['PG_PORT'],
            $_ENV['PG_DB']
        ),
        $_ENV['PG_USER'],
        $_ENV['PG_PASS'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}

function getUserTransactions(string $userId): array {
    $pdo = connectTransactionsDB();
    $stmt = $pdo->prepare("
        SELECT 
            t.transaction_id,
            t.transaction_date,
            t.currency,
            t.amount_paid,
            t.total_amount,
            t.change,
            t.status,
            o.order_id,

            (
                SELECT string_agg(p.name || ' x' || oi.quantity, ', ')
                FROM order_items oi
                JOIN products p ON p.product_id = oi.product_id
                WHERE oi.order_id = o.order_id
            ) AS products_summary

        FROM transactions t
        JOIN orders o ON t.order_id = o.order_id
        WHERE t.user_id = :user_id
        ORDER BY t.transaction_date DESC
    ");
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
