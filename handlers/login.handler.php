<?php
declare(strict_types=1);
session_start();

require_once '../bootstrap.php';

// Get PDO instance (make sure this returns a PDO object)
$pdo = require_once UTILS_PATH . '/database.util.php'; // or use getPdoInstance()

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validate input
if (empty($username) || empty($password)) {
    $error = urlencode('Username and password are required.');
    header("Location: /pages/login/index.php?error=$error");
    exit;
}

// Look up user
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check password
if (!$user || !password_verify($password, $user['password'])) {
    $error = urlencode('Invalid username or password.');
    header("Location: /pages/login/index.php?error=$error");
    exit;
}

// Login success: store user in session
$_SESSION['user'] = [
    'id'       => $user['user_id'],
    'username' => $user['username'],
    'role'     => $user['role']
];

// Redirect to dashboard/home
header('Location: /index.php');
exit;
