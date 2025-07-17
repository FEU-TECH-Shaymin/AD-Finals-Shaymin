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
<section class="admin-container">
    <h1>User Administration</h1>

    <form method="POST" class="glass-box">
        <h2>Create Users</h2>
        <div class="grid">
            <select name="role" required>
                <option value="">Role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="middle_name" placeholder="Middle Name">
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button name="create">Sign Up</button>
    </form>

    <form method="POST" class="glass-box">
        <h2>See All Users</h2>
        <button name="see">See Users</button>
        <?php if (!empty($allUsers)): ?>
            <table>
                <thead>
                    <tr><th>ID</th><th>Username</th><th>Role</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($allUsers as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['user_id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </form>

    <form method="POST" class="glass-box">
        <h2>Find User by Username</h2>
        <input type="text" name="find_username" placeholder="Username">
        <button name="find">Find</button>
        <?php if ($foundUser): ?>
            <p>Found: <?= htmlspecialchars($foundUser['first_name'] . ' ' . $foundUser['last_name']) ?> (<?= htmlspecialchars($foundUser['role']) ?>)</p>
        <?php endif ?>
    </form>

    <form method="POST" class="glass-box">
        <h2>Update Username</h2>
        <input type="text" name="old_username" placeholder="Username">
        <input type="text" name="new_username" placeholder="New Username">
        <button name="update">Update</button>
    </form>

    <form method="POST" class="glass-box">
        <h2>Delete User</h2>
        <input type="text" name="delete_username" placeholder="Username">
        <button name="delete">Delete</button>
    </form>
</section>
<?php
}, [
    "css" => ["./assets/css/dashboard.css"],
    "js" => []
]);
