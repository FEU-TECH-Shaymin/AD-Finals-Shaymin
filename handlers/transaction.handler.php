<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';
require_once UTILS_PATH . '/transaction.util.php';
require_once UTILS_PATH . '/auth.util.php'; // If you need user context

// Basic POST validation
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit('Method Not Allowed');
}

$fullname = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$address  = trim($_POST['address'] ?? '');

// Validate required fields
if (!$fullname || !$email || !$phone || !$address) {
    http_response_code(400); // Bad Request
    exit('Missing required fields.');
}

// Optionally, get logged-in user ID
session_start();
$userId = $_SESSION['user']['user_id'] ?? null;
if (!$userId) {
    http_response_code(401); // Unauthorized
    exit('You must be logged in.');
}

// Simulate order creation (can be real later)
$orderId = TransactionUtil::createDummyOrder($userId); // Add if needed

// Perform transaction insert
$success = TransactionUtil::createTransaction([
    'user_id'      => $userId,
    'order_id'     => $orderId,
    'currency'     => 'Zombie Crystal',
    'amount_paid'  => 1299.00,
    'total_amount' => 1299.00,
    'status'       => 'completed'
]);

if ($success) {
    header('Location: /pages/user/index.php');
    exit;
} else {
    http_response_code(500);
    exit('Transaction failed.');
}
