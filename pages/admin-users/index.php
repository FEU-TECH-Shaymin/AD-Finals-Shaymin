<?php

$pdo = require __DIR__ . '/../../utils/database.util.php';
require_once __DIR__ . '/../../layouts/main.layout.php';

require_once LAYOUTS_PATH . "/main.layout.php";

$error = null;

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

    $stmt = $pdo->query("
        SELECT user_id, first_name, middle_name, last_name, username, role, created_at
        FROM users
        ORDER BY created_at DESC
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "❌ Database error: " . $e->getMessage();
    $users = [];
}

renderMainLayout(function () use ($users, $error) {
    ?>
    <section class="admin-users-section">
        <div class="card p-4 shadow-lg aos-card" style="max-width: 1000px; width: 100%;">
            <h2 class="text-center signup-txt mb-4">All Users</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (empty($users)): ?>
                <p class="text-center">No users found.</p>
            <?php else: ?>
                <div class="table-wrapper aos-table">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['user_id']) ?></td>
                                    <td><?= htmlspecialchars("{$user['first_name']} {$user['middle_name']} {$user['last_name']}") ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                                    <td>
                                        <form method="POST" action="/handlers/delete.handler.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">🗑️ Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}, [
    "css" => ["./assets/css/style.css"],
    "js" => ["./assets/js/script.js"]
]);
