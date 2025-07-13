<?php
require_once UTILS_PATH . '/database.util.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit;
}

$first_name  = trim($_POST['first_name'] ?? '');
$middle_name = trim($_POST['middle_name'] ?? '');
$last_name   = trim($_POST['last_name'] ?? '');
$username    = trim($_POST['username'] ?? '');
$email       = trim($_POST['email'] ?? '');
$password    = $_POST['password'] ?? '';

if (!$first_name || !$last_name || !$username || !$email || !$password) {
    header('Location: /pages/signup/index.php?error=' . urlencode('Please fill in all required fields.'));
    exit;
}

$hash = password_hash($password, PASSWORD_BCRYPT);

$sql = <<<SQL
INSERT INTO users (first_name, middle_name, last_name, username, email, password)
VALUES (:first_name, :middle_name, :last_name, :username, :email, :password)
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':first_name'  => $first_name,
        ':middle_name' => $middle_name ?: null,
        ':last_name'   => $last_name,
        ':username'    => $username,
        ':email'       => $email,
        ':password'    => $hash,
    ]);

    header('Location: /pages/login/index.php?registered=1');
    exit;

} catch (PDOException $e) {
    if ($e->getCode() === '23505') {
        header('Location: /pages/signup/index.php?error=' . urlencode('Username or email already exists.'));
    } else {
        header('Location: /pages/signup/index.php?error=' . urlencode('Registration failed. Please try again.'));
    }
    exit;
}
