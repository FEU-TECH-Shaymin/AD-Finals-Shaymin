<?php
declare(strict_types=1);

class OrdersUtil
{
    // ✅ Create a new order (User Only)
    public static function create(PDO $pdo, array $data): bool
    {
        $sql = "
            INSERT INTO public.orders (
                user_id,
                total_amount,
                status
            ) VALUES (
                :user_id,
                :total_amount,
                :status
            )
        ";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':user_id'      => $data['user_id'],
            ':total_amount' => $data['total_amount'],
            ':status'       => $data['status'] ?? 'pending',
        ]);
    }

    // ✅ Get all orders for a specific user (User Only)
    public static function getByUser(PDO $pdo, string $userId): array
    {
        $stmt = $pdo->prepare("SELECT * FROM public.orders WHERE user_id = :user_id ORDER BY order_date DESC");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Admin: Get all orders in the system (Admin Only)
    public static function getAll(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM public.orders ORDER BY order_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
