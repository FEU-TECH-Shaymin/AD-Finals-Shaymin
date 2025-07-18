<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $txnId = $_POST['transaction_id'] ?? '';

    if (!$txnId) {
        die("Invalid transaction.");
    }

    try {
        $pdo = new PDO(
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

        $stmt = $pdo->prepare("
            UPDATE transactions 
            SET status = 'completed'
            WHERE transaction_id = :id
        ");
        $stmt->execute([':id' => $txnId]);

        header("Location: /pages/transaction/index.php?success=confirmed");
        exit;
    } catch (Throwable $e) {
        echo "Error confirming payment: " . $e->getMessage();
    }
}
