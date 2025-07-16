<?php
declare(strict_types=1);

require_once UTILS_PATH . '/envSetter.util.php';

class OrdersUtil {
    private static function connect(): PDO {
        return new PDO(
            $_ENV['pgsql_dsn'],
            $_ENV['pgsql_user'],
            $_ENV['pgsql_pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    // 🟢 Get all orders (Admin)
    public static function getAll(): array {
        $pdo = self::connect();
        $stmt = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🟢 Get orders by user ID (User)
    public static function getByUser(string $userId): array {
        $pdo = self::connect();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :uid ORDER BY order_date DESC");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🟢 Get single order by ID
    public static function getById(string $orderId): ?array {
        $pdo = self::connect();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = :id");
        $stmt->execute(['id' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // 🟢 Create a new order (User)
    public static function create(array $data): bool {
        $pdo = self::connect();
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_amount, status)
            VALUES (:user_id, :total_amount, :status)
        ");
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'total_amount' => $data['total_amount'],
            'status' => $data['status'] ?? 'pending',
        ]);
    }

    // 🟡 Update status (Admin)
    public static function updateStatus(string $orderId, string $status): bool {
        $pdo = self::connect();
        $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE order_id = :id");
        return $stmt->execute(['status' => $status, 'id' => $orderId]);
    }

    // 🔴 Cancel/Delete (Optional)
    public static function delete(string $orderId): bool {
        $pdo = self::connect();
        $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = :id");
        return $stmt->execute(['id' => $orderId]);
    }
}
