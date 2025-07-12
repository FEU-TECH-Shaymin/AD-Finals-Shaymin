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

// 5 ) Drop all existing tables
echo "Dropping old tables…\n";
foreach ([
    'transactions',
    'orders',
    'products',
    'users',
    'projects'
] as $table) {
    $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
    echo "🗑️  Dropped table: {$table}\n";
}

