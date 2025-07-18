<?php
declare(strict_types=1);

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
 * Insert order into the orders table and return the order_id
 */
function insertOrder(array $data): array {
    try {
        $pdo = connectOrdersDB();

        // Use RETURNING to safely get UUID even if primary key is not SERIAL
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_amount, status)
            VALUES (:user_id, :total_amount, :status)
            RETURNING order_id
        ");

        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':total_amount' => $data['total_amount'],
            ':status' => $data['status']
        ]);

        $orderId = $stmt->fetchColumn();

        return ['success' => true, 'order_id' => $orderId];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

/**
 * Fetch all available products with stock > 0
 */
function fetchAllProducts(): array {
    try {
        $pdo = connectOrdersDB();
        $stmt = $pdo->query("
            SELECT product_id, name, price, stock_quantity
            FROM products
            WHERE stock_quantity > 0
            ORDER BY name
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Fetch prices for multiple products using their IDs
 */
function fetchProductPrices(array $productIds): array {
    if (empty($productIds)) return [];

    try {
        $pdo = connectOrdersDB();
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $stmt = $pdo->prepare("
            SELECT product_id, price FROM products
            WHERE product_id IN ($placeholders)
        ");
        $stmt->execute($productIds);

        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // [product_id => price]
    } catch (PDOException $e) {
        return [];
    }
}
