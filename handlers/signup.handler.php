<?php
declare(strict_types=1);

// ✅ DEBUGGING ENABLED – REMOVE IN PRODUCTION
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once BASE_PATH . '/bootstrap.php';
require_once VENDOR_PATH . '/autoload.php';
require_once UTILS_PATH . '/envSetter.util.php';
require_once UTILS_PATH . '/signup.util.php';
require_once UTILS_PATH . '/auth.util.php';

Auth::init();

// Load database credentials from env
$env = require UTILS_PATH . '/envSetter.util.php';
$dsn = "pgsql:host={$env['pgHost']};port={$env['pgPort']};dbname={$env['pgDb']}";
$pdo = new PDO($dsn, $env['pgUser'], $env['pgPassword'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// Accept POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/signup/index.php');
    exit;
}

// Collect input
$input = [
    'first_name'   => $_POST['first_name'] ?? '',
    'middle_name'  => $_POST['middle_name'] ?? '',
    'last_name'    => $_POST['last_name'] ?? '',
    'username'     => $_POST['username'] ?? '',
    'email'        => $_POST['email'] ?? '',
    'password'     => $_POST['password'] ?? '',
];

// Validate
$errors = Signup::validate($input);
if (!empty($errors)) {
    $_SESSION['signup_errors'] = $errors;
    $_SESSION['signup_old'] = $input;
    header('Location: /pages/signup/index.php');
    exit;
}

// Attempt to create & log in user
try {
    Signup::create($pdo, $input);

    if (Auth::login($pdo, $input['username'], $input['password'])) {
        header('Location: /pages/user/index.php');
        exit;
    }

    // Auto-login failed
    $_SESSION['signup_errors'] = ['Account created, but login failed. Please log in manually.'];
    header('Location: /pages/login/index.php');
    exit;

} catch (PDOException $e) {
    if ($e->getCode() === '23505') {
        $_SESSION['signup_errors'] = ['Username or email already exists.'];
        $_SESSION['signup_old'] = $input;
        header('Location: /pages/signup/index.php');
        exit;
    }

    error_log('[signup.handler] PDOException: ' . $e->getMessage());
    http_response_code(500);
    exit('❌ Server error: ' . $e->getMessage());
}
