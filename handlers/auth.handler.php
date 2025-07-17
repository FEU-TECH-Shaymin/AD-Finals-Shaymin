<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once VENDOR_PATH . '/autoload.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/envSetter.util.php';

Auth::init();

// Connect to PostgreSQL using .env variables
$dsn = sprintf(
    'pgsql:host=%s;port=%s;dbname=%s',
    $_ENV['PG_HOST'],
    $_ENV['PG_PORT'],
    $_ENV['PG_DB']
);

try {
    $pdo = new PDO($dsn, $_ENV['PG_USER'], $_ENV['PG_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    exit('❌ DB Connection Failed: ' . $e->getMessage());
}

$action = $_REQUEST['action'] ?? null;

// --- LOGIN ---
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameInput = trim($_POST['username'] ?? '');
    $passwordInput = trim($_POST['password'] ?? '');

    if (Auth::login($pdo, $usernameInput, $passwordInput)) {
        $user = Auth::user();

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: /pages/admin/index.php');
        } else {
            header('Location: /pages/user/index.php');
        }
        exit;
    } else {
        header('Location: /pages/login/index.php?error=' . urlencode('Invalid Credentials'));
        exit;
    }
}

// --- LOGOUT ---
elseif ($action === 'logout') {
    Auth::logout();
    header('Location: /pages/login/index.php');
    exit;
}

// --- Default fallback ---
header('Location: /pages/login/index.php');
exit;

