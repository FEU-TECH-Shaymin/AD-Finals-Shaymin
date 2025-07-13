<?php
require_once UTILS_PATH . '/database.util.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');


if (empty($username) || empty($password)) {
    $error = urlencode("Username and password are required.");
    header("Location: /pages/login/index.php?error=$error");
    exit;
}
try {
    $pdo = getPdoInstance(); // Make sure this returns a PDO object from database.util.php

    $sql  = 'SELECT * FROM users WHERE username = :u LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':u' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        header('Location: /dashboard.php');
        exit;
    }