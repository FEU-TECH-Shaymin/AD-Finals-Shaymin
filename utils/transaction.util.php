<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

class TransactionUtil
{
    private static function getPDO(): PDO
    {
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $_ENV['PG_HOST'],
            $_ENV['PG_PORT'],
            $_ENV['PG_DB']
        );

        return new PDO($dsn, $_ENV['PG_USER'], $_ENV['PG_PASS'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    public static function createTransaction(array $data): bool
    {
        try {
            $pdo = self::getPDO();

            $stmt = $pdo->prepare("
                INSERT INTO transactions (
                    user_id, order_id, currency, amount_paid, total_amount, status
                ) VALUES (
                    :user_id, :order_id, :currency, :amount_paid, :total_amount, :status
                )
            ");

            return $stmt->execute([
                ':user_id'      => $data['user_id'],
                ':order_id'     => $data['order_id'],
                ':currency'     => $data['currency'],
                ':amount_paid'  => $data['amount_paid'],
                ':total_amount' => $data['total_amount'],
                ':status'       => $data['status'],
            ]);
        } catch (PDOException $e) {
            error_log("❌ Transaction Error: " . $e->getMessage());
            return false;
        }
    }

    public static function createDummyOrder(string $userId): string
    {
        try {
            $pdo = self::getPDO();
            $stmt = $pdo->prepare("
                INSERT INTO orders (user_id, product_name, total_price)
                VALUES (:user_id, :product_name, :total_price)
                RETURNING order_id
            ");

            $stmt->execute([
                ':user_id' => $userId,
                ':product_name' => 'Outlast Survival Kit',
                ':total_price' => 1299.00,
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['order_id'] ?? throw new Exception("Order creation failed");
        } catch (PDOException $e) {
            error_log("❌ Dummy Order Error: " . $e->getMessage());
            throw $e;
        }
    }
}
