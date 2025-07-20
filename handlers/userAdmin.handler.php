<?php
header('Content-Type: application/json');
$pdo = require __DIR__ . '/../utils/database.util.php';

$action = $_POST['action'] ?? '';
$response = ['message' => 'Unknown action.'];

switch ($action) {
    case 'create':
        $username = $_POST['username'] ?? '';
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $checkStmt->execute([$username]);
        if ($checkStmt->fetchColumn() > 0) {
            $response['message'] = '❌ Username already exists.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (role, first_name, middle_name, last_name, username, password)
            VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['role'], $_POST['first_name'], $_POST['middle_name'],
                $_POST['last_name'], $username, password_hash($_POST['password'], PASSWORD_DEFAULT)
            ]);
            $response['message'] = '✅ User added successfully.';
        }
        break;

    case 'find':
        $username = $_POST['username'] ?? '';
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $response['message'] = '🔍 User found.';
            $response['user'] = $user;
        } else {
            $response['message'] = '⚠️ User not found.';
        }
        break;

    case 'update':
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE username = ?");
        $stmt->execute([$_POST['new_username'], $_POST['old_username']]);
        $response['message'] = '✏️ Username updated.';
        break;

    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM users WHERE username = ?");
        $stmt->execute([$_POST['username']]);
        $response['message'] = '🗑️ User deleted.';
        break;

    case 'see':
        $allUsers = $pdo->query("SELECT user_id, username, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
        $response['users'] = $allUsers;
        $response['message'] = count($allUsers) > 0 ? '👥 Users loaded.' : '⚠️ No users found.';
        break;

    default:
        $response['message'] = '❓ Invalid action.';
}

echo json_encode($response);
exit;
