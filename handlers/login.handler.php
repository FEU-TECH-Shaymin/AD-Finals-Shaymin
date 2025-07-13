<?php 
require_once UTILS_PATH . '/database.util.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    exit('Username and password are required.');
}

$sql  = 'SELECT * FROM users WHERE username = :u LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->execute([':u' => $username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && password_verify($password, $row['password'])) {
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['role']    = $row['role'];
    $_SESSION['username'] = $row['username'];

    // ✅ Redirect based on role
    if ($row['role'] === 'admin') {
        header('Location: /admin_dashboard.php');
    } else {
        header('Location: /customer_dashboard.php');
    }
    exit;
}

// Optionally redirect back to login page with error
header('Location: /pages/login/index.php?error=invalid');
exit;
