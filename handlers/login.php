<?php
require_once UTILS_PATH . '/../utils/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$user = $_POST['username'] ?? '';
$pass = $_POST['password'] ?? '';

$sql  = 'SELECT * FROM users WHERE username = :u LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->execute([':u' => $user]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && password_verify($pass, $row['password'])) {
    // Success: stash minimal user data in the session
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['role']    = $row['role'];
    header('Location: /dashboard.php');
    exit;
}

exit('Invalid credentials.');
