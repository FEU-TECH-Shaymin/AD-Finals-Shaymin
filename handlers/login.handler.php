<?php
require_once UTILS_PATH . '/database.util.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$user = $_POST['username'] ?? '';
$pass = $_POST['password'] ?? '';

if (empty($user) || empty($pass)) {
    exit('Username and password are required.');
}

$sql  = 'SELECT * FROM users WHERE username = :u LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->execute([':u' => $user]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && password_verify($pass, $row['password'])) {
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['role']    = $row['role'];
    header('Location: /dashboard.php');
    exit;
}

exit('Invalid credentials.');
