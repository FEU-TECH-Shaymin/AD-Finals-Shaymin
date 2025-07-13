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