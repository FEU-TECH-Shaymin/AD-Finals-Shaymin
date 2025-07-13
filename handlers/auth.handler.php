<?php
declare(strict_types=1);
session_start();

// Load bootstrap and database
require_once '../bootstrap.php';
$pdo = require_once UTILS_PATH . '/database.util.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Invalid username or password';
    header('Location: /login.php');
    exit;
}

$_SESSION['user'] = [
    'id'       => $user['user_id'],
    'username' => $user['username'],
    'role'     => $user['role']
];

header('Location: /index.php');
exit;
