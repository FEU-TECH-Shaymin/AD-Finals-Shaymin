<?php
declare(strict_types=1);

require_once UTILS_PATH . '/envSetter.util.php';

class ProductsUtil {
    private static function connect(): PDO {
        return new PDO(
            $_ENV['pgsql_dsn'],
            $_ENV['pgsql_user'],
            $_ENV['pgsql_pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public static function getAll(): array {
        $pdo = self::connect();
        $stmt = $pdo->query("SELECT * FROM products ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(string $productId): ?array {
        $pdo = self::connect();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :id");
        $stmt->execute(['id' => $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function create(array $data): bool {
        $pdo = self::connect();
        $stmt = $pdo->prepare("
            INSERT INTO products (name, description, category, price, stock_quantity)
            VALUES (:name, :description, :category, :price, :stock)
        ");
        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'category' => $data['category'],
            'price' => $data['price'],
            'stock' => $data['stock_quantity']
        ]);
    }

    public static function update(string $productId, array $data): bool {
        $pdo = self::connect();
        $stmt = $pdo->prepare("
            UPDATE products
            SET name = :name, description = :description, category = :category,
                price = :price, stock_quantity = :stock
            WHERE product_id = :id
        ");
        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'category' => $data['category'],
            'price' => $data['price'],
            'stock' => $data['stock_quantity'],
            'id' => $productId
        ]);
    }

    public static function delete(string $productId): bool {
        $pdo = self::connect();
        $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :id");
        return $stmt->execute(['id' => $productId]);
    }
}
