<?php
declare(strict_types=1);

// Load environment variables
require_once BASE_PATH . '/bootstrap.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

/**
 * Standalone PostgreSQL connection
 */
function connectOrdersDB(): PDO {
    $dsn = sprintf(
        "pgsql:host=%s;port=%s;dbname=%s",
        $_ENV['PG_HOST'],
        $_ENV['PG_PORT'],
        $_ENV['PG_DB']
    );

    return new PDO($dsn, $_ENV['PG_USER'], $_ENV['PG_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}

/**
 * Insert order into the orders table
 */
function insertOrder(array $data): array
{
    try {
        $pdo = connectOrdersDB();

        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_amount, status)
            VALUES (:user_id, :total_amount, :status)
        ");

        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':total_amount' => $data['total_amount'],
            ':status' => $data['status']
        ]);

        return ['success' => true];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}
