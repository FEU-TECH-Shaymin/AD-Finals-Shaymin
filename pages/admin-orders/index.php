<?php 
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once LAYOUTS_PATH . "/main.layout.php";
require_once UTILS_PATH . '/orders.util.php';
require_once UTILS_PATH . '/auth.util.php';

// Initialize $error to avoid undefined variable
$error = '';

// Connect using your existing util function
$pdo = connectOrdersDB();

// Simple fallback if $pdo fails
if (!$pdo) {
    $error = "Failed to connect to the orders database.";
    $orders = [];
} else {
    try {
        $stmt = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error fetching orders: " . $e->getMessage();
        $orders = [];
    }
}

renderMainLayout(
    function () use ($orders, $error) {
        ?>
        <section class="admin-orders-section">
            <div class="card p-4 shadow-lg aos-card" style="max-width: 900px; width: 100%;">
                <h2 class="text-center signup-txt mb-4">All Orders</h2>

                <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>

                <?php if (empty($orders)): ?>
                <p class="text-center">No orders found.</p>
                <?php else: ?>
                <div class="table-wrapper aos-table">
                    <table class="table table-hover table-sm mb-0">
                        <colgroup>
                            <col style="width: 15%;">
                            <col style="width: 15%;">
                            <col style="width: 20%;">
                            <col style="width: 20%;">
                            <col style="width: 30%;">
                        </colgroup>
                        <thead class="table-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>User ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                    </table>

                    <div class="table-body-scroll">
                        <table class="table table-hover table-sm mb-0">
                            <colgroup>
                                <col style="width: 15%;">
                                <col style="width: 15%;">
                                <col style="width: 20%;">
                                <col style="width: 20%;">
                                <col style="width: 30%;">
                            </colgroup>
                            <tbody>
                                <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td><?= htmlspecialchars($o['order_id']) ?></td>
                                    <td><?= htmlspecialchars($o['user_id']) ?></td>
                                    <td><?= number_format((float)$o['total_amount'], 2) ?></td>
                                    <td><?= htmlspecialchars($o['status']) ?></td>
                                    <td><?= htmlspecialchars($o['order_date']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    },
    [
        "css" => [
            "./assets/css/style.css"
        ],
        "js" => [
            "./assets/js/script.js"
        ]
    ]
);
