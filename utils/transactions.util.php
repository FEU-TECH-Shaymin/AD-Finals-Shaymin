<?php
declare(strict_types=1);

function connectTransactionsDB(): PDO {
    // You can customize this if needed; assumes same DB as orders
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
        SELECT * FROM transactions
        WHERE user_id = :user_id
        ORDER BY transaction_date DESC
    ");
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
