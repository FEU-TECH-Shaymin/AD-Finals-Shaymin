<?php
declare(strict_types=1);

require_once UTILS_PATH . '/envSetter.util.php';

class ProductsUtil {
    private static function connect(): PDO {
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $_ENV['PG_HOST'],
            $_ENV['PG_PORT'],
            $_ENV['PG_DB']
        );

        return new PDO(
            $dsn,
            $_ENV['PG_USER'],
            $_ENV['PG_PASS'],
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

    public static function search(string $keyword): array {
        $pdo = self::connect();
        $stmt = $pdo->prepare("
            SELECT * FROM products
            WHERE name ILIKE :kw OR description ILIKE :kw OR category ILIKE :kw
            ORDER BY name
        ");
        $stmt->execute([
            'kw' => '%' . $keyword . '%'
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
