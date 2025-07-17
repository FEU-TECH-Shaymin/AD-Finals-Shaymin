<?php

declare(strict_types=1);

// 1) Autoload
require 'vendor/autoload.php';

// 2) Bootstrap
require 'bootstrap.php';

// 3) Load environment
$typeConfig = require_once UTILS_PATH . '/envSetter.util.php';

// 4) Connect to PostgreSQL
$pgConfig = [
    'host' => $typeConfig['pgHost'],
    'port' => $typeConfig['pgPort'],
    'db'   => $typeConfig['pgDb'],
    'user' => $typeConfig['pgUser'],
    'pass' => $typeConfig['pgPassword'],
];

try {
    $dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
    $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "✅ Connected to PostgreSQL successfully.\n";
} catch (PDOException $e) {
    echo "❌ Connection to PostgreSQL failed: " . $e->getMessage() . "\n";
    exit(1);
}

// 5) Dummy definitions
$seedMap = [
    'users' => '/users.staticData.php',
    'products' => '/products.staticData.php',
    'orders' => '/orders.staticData.php',
    'transactions' => '/transactions.staticData.php',
];

// 6) Seeding
foreach ($seedMap as $table => $file) {
    echo "🌱 Seeding {$table}…\n";

    $data = require_once DUMMIES_PATH . $file;

    switch ($table) {
        case 'users':
            $stmt = $pdo->prepare("
                INSERT INTO users (user_id, first_name, middle_name, last_name, password, username, role)
                VALUES (:user_id, :first_name, :middle_name, :last_name, :password, :username, :role)
            ");
            foreach ($data as $u) {
                $stmt->execute([
                    ':user_id' => $u['user_id'],
                    ':first_name' => $u['first_name'],
                    ':middle_name' => $u['middle_name'],
                    ':last_name' => $u['last_name'],
                    ':password' => password_hash($u['password'], PASSWORD_DEFAULT),
                    ':username' => $u['username'],
                    ':role' => $u['role'],
                ]);
            }
            break;

        case 'products':
            $stmt = $pdo->prepare("
                INSERT INTO products (name, description, category, price, stock_quantity, image_path)
                VALUES (:name, :description, :category, :price, :stock_quantity, :image_path)
            ");
            foreach ($data as $p) {
                $stmt->execute([
                    ':name' => $p['name'],
                    ':description' => $p['description'],
                    ':category' => $p['category'],
                    ':price' => $p['price'],
                    ':stock_quantity' => $p['stock_quantity'],
                    ':image_path' => $p['image_path'] ?? null,
                ]);
            }
            break;

        case 'orders':
            $stmt = $pdo->prepare("
                INSERT INTO orders (order_id, user_id, order_date, total_amount, status)
                VALUES (:order_id, :user_id, :order_date, :total_amount, :status)
            ");
            foreach ($data as $o) {
                $stmt->execute([
                    ':order_id' => $o['order_id'],
                    ':user_id' => $o['user_id'],
                    ':order_date' => $o['order_date'],
                    ':total_amount' => $o['total_amount'],
                    ':status' => $o['status'],
                ]);
            }
            break;

        case 'transactions':
            $stmt = $pdo->prepare("
                INSERT INTO transactions (transaction_id, user_id, order_id, transaction_date, currency, amount_paid, total_amount, status)
                VALUES (:transaction_id, :user_id, :order_id, :transaction_date, :currency, :amount_paid, :total_amount, :status)
            ");
            foreach ($data as $t) {
                $stmt->execute([
                    ':transaction_id' => $t['transaction_id'],
                    ':user_id' => $t['user_id'],
                    ':order_id' => $t['order_id'],
                    ':transaction_date' => $t['transaction_date'],
                    ':currency' => $t['currency'],
                    ':amount_paid' => $t['amount_paid'],
                    ':total_amount' => $t['total_amount'],
                    ':status' => $t['status'],
                ]);
            }
            break;

        default:
            echo "⚠️ Skipping unknown table: {$table}\n";
    }

    echo "✅ Done seeding {$table}\n";
}

// 7) Generate dummy order_items
echo "🌱 Seeding order_items…\n";

// Fetch all orders and products
$orderIds = $pdo->query("SELECT order_id FROM orders")->fetchAll(PDO::FETCH_COLUMN);
$productIds = $pdo->query("SELECT product_id FROM products")->fetchAll(PDO::FETCH_COLUMN);

// Prepare insert
$orderItemStmt = $pdo->prepare("
    INSERT INTO order_items (item_id, order_id, product_id, quantity)
    VALUES (gen_random_uuid(), :order_id, :product_id, :quantity)
");

foreach ($orderIds as $orderId) {
    $numItems = rand(1, 3); // 1 to 3 items per order

    $selectedProducts = array_rand($productIds, min($numItems, count($productIds)));

    if (!is_array($selectedProducts)) {
        $selectedProducts = [$selectedProducts];
    }

    foreach ($selectedProducts as $index) {
        $productId = $productIds[$index];
        $quantity = rand(1, 5);

        $orderItemStmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $productId,
            ':quantity' => $quantity,
        ]);
    }
}

echo "✅ Done seeding order_items\n";
echo "🎉 PostgreSQL seeding complete!\n";
