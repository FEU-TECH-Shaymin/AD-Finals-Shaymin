<?php
require_once __DIR__ . '/../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);   // Method Not Allowed
    exit;
}

$first  = $_POST['first_name']  ?? '';
$middle = $_POST['middle_name'] ?? null;
$last   = $_POST['last_name']   ?? '';
$user   = $_POST['username']    ?? '';
$pass   = $_POST['password']    ?? '';

if (!$first || !$last || !$user || !$pass) {
    exit('Missing required fields.');
}

$hash = password_hash($pass, PASSWORD_BCRYPT);

$sql = <<<SQL
INSERT INTO users (first_name, middle_name, last_name, username, password)
VALUES (:f, :m, :l, :u, :p)
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':f' => $first,
        ':m' => $middle,
        ':l' => $last,
        ':u' => $user,
        ':p' => $hash,
    ]);
    header('Location: /login.html?registered=1');
} catch (PDOException $e) {
    if ($e->getCode() === '23505') {          // unique_violation
        exit('Username already taken.');
    }
    exit('Registration failed.');
}
