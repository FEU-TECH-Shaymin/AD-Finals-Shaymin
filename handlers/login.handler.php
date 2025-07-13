<?php
require_once UTILS_PATH . '/database.util.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');