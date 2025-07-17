<?php
$pdo = require_once __DIR__ . '/../../utils/dbConnection.util.php';
require_once __DIR__ . '/../../layouts/main.layout.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $stmt = $pdo->prepare("INSERT INTO users (role, first_name, middle_name, last_name, username, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['role'], $_POST['first_name'], $_POST['middle_name'],
            $_POST['last_name'], $_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);
    }

    if (isset($_POST['find'])) {
        $foundStmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $foundStmt->execute([$_POST['find_username']]);
        $foundUser = $foundStmt->fetch(PDO::FETCH_ASSOC);
    }

    if (isset($_POST['update'])) {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE username = ?");
        $stmt->execute([$_POST['new_username'], $_POST['old_username']]);
    }

    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE username = ?");
        $stmt->execute([$_POST['delete_username']]);
    }
}

$allUsers = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

renderMainLayout(function () use ($allUsers, $foundUser ?? null) {
?>

<?php
}, [
    "css" => ["./assets/css/dashboard.css"],
    "js" => []
]);
