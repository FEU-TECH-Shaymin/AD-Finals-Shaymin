<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

Auth::init();
$user = Auth::user();

if (!$user || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/login/index.php');
    exit;
}

$transactionId = $_POST['transaction_id'] ?? '';

if (!$transactionId) {
    die('Invalid transaction ID.');
}

$pdo = connectOrdersDB();

$stmt = $pdo->prepare("
    UPDATE transactions
    SET status = 'paid'
    WHERE transaction_id = :transaction_id AND user_id = :user_id
");
$stmt->execute([
    ':transaction_id' => $transactionId,
    ':user_id' => $user['id'],
]);

header('Location: /pages/transactions/index.php?confirmed=1');
exit;
