<?php
require_once BASE_PATH . '/utils/envSetter.util.php';

$config = require BASE_PATH . '/utils/envSetter.util.php';

try {
    $pdo = new PDO(
        "pgsql:host={$config['pgHost']};port={$config['pgPort']};dbname={$config['pgDb']}",
        $config['pgUser'],
        $config['pgPassword']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    die("PostgreSQL connection failed: " . $e->getMessage());
}
