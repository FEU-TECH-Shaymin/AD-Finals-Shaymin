<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php'; // This will load paths, .env, and constants

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('❌ Method Not Allowed');
}

$userId = $_POST['user_id'] ?? null;

if (!$userId || !is_numeric($userId)) {
    http_response_code(400);
    exit('❌ Invalid User ID');
}

try {
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        $_ENV['PG_HOST'],
        $_ENV['PG_PORT'],
        $_ENV['PG_DB']
    );

    $pdo = new PDO($dsn, $_ENV['PG_USER'], $_ENV['PG_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);

    // Redirect back to the user list
    header('Location: /pages/admin-users/index.php');
    exit();
} catch (PDOException $e) {
    http_response_code(500);
    echo '❌ Database Error: ' . $e->getMessage();
}
