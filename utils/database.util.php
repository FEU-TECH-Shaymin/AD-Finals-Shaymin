<?php
// No need to include autoload.php again — it's already done in bootstrap.php

require_once BASE_PATH . '/bootstrap.php'; // ✅ Make sure this is here

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$dsn = sprintf(
    "pgsql:host=%s;port=%s;dbname=%s",
    $_ENV['PG_HOST'],
    $_ENV['PG_PORT'],
    $_ENV['PG_DB']
);

try {
    $pdo = new PDO($dsn, $_ENV['PG_USER'], $_ENV['PG_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("PostgreSQL connection failed: " . $e->getMessage());
}

// Optional helper function if needed elsewhere
function getPostgreSQLConnection(): PDO {
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
return $pdo;