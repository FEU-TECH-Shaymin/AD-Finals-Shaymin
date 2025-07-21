<?php
declare(strict_types=1);

// 1) Composer autoload
require_once 'vendor/autoload.php';

// 2) Composer bootstrap
require_once 'bootstrap.php';

// 3) envSetter
$typeConfig = require_once UTILS_PATH . '/envSetter.util.php';

// Prepare config array
$pgConfig = [
    'host' => $typeConfig['pgHost'],
    'port' => $typeConfig['pgPort'],
    'db'   => $typeConfig['pgDb'],
    'user' => $typeConfig['pgUser'],
    'pass' => $typeConfig['pgPassword'],
];

// ——— Connect to PostgreSQL ———
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";

try {
    $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "✅ Connected to PostgreSQL\n";
} catch (PDOException $e) {
    echo "❌ Connection Failed: " . $e->getMessage() . "\n";
    exit(1);
}

// ——— Apply schemas ———
$modelFiles = [
    'users.model.sql',
    'orders.model.sql',
    'products.model.sql',
    'transactions.model.sql',
    'orderItems.model.sql',
];

foreach ($modelFiles as $modelFile) {
$path = BASE_PATH . "/database/{$modelFile}";
    echo "Applying schema from {$path}…\n";

    $sql = file_get_contents($path);

    if ($sql === false) {
        throw new RuntimeException("Could not read {$path}");
    } else {
        echo "✅ Creation Success from {$path}\n";
    }

    $pdo->exec($sql);
}

// ——— TRUNCATE tables ———
echo "Truncating tables…\n";

$tables = ['users', 'orders', 'products', 'transactions'];

foreach ($tables as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
    echo "✅ Truncated table: {$table}\n";
}

echo "🎉 Reset Completed\n"; 