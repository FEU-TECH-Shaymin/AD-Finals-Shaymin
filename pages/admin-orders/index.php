<?php 
declare(strict_types=1);

// call the layout you want to use from layout folder
require_once LAYOUTS_PATH . "/main.layout.php";
require_once UTILS_PATH . '/orders.util.php';
require_once UTILS_PATH . '/auth.util.php';
// $mongoCheckerResult = require_once HANDLERS_PATH . "/mongodbChecker.handler.php";
// $postgresqlCheckerResult = require_once HANDLERS_PATH . "/postgreChecker.handler.php";

// Extended Dummy Data for testing
$orders = [
    ['order_id' => 1, 'user_id' => 101, 'total_amount' => 999.99, 'status' => 'pending', 'order_date' => '2024-07-01 10:30:00'],
    ['order_id' => 2, 'user_id' => 102, 'total_amount' => 1499.50, 'status' => 'shipped', 'order_date' => '2024-07-02 14:45:00'],
    ['order_id' => 3, 'user_id' => 103, 'total_amount' => 2000.00, 'status' => 'delivered', 'order_date' => '2024-07-03 09:15:00'],
    ['order_id' => 4, 'user_id' => 104, 'total_amount' => 875.75, 'status' => 'pending', 'order_date' => '2024-07-04 11:20:00'],
    ['order_id' => 5, 'user_id' => 105, 'total_amount' => 1320.40, 'status' => 'shipped', 'order_date' => '2024-07-05 13:55:00'],
    ['order_id' => 6, 'user_id' => 106, 'total_amount' => 1575.00, 'status' => 'delivered', 'order_date' => '2024-07-06 08:40:00'],
    ['order_id' => 7, 'user_id' => 107, 'total_amount' => 1100.00, 'status' => 'pending', 'order_date' => '2024-07-07 16:25:00'],
    ['order_id' => 8, 'user_id' => 108, 'total_amount' => 980.50, 'status' => 'shipped', 'order_date' => '2024-07-08 12:10:00'],
    ['order_id' => 9, 'user_id' => 109, 'total_amount' => 2100.99, 'status' => 'delivered', 'order_date' => '2024-07-09 09:50:00'],
    ['order_id' => 10, 'user_id' => 110, 'total_amount' => 1235.35, 'status' => 'pending', 'order_date' => '2024-07-10 15:00:00'],
    ['order_id' => 11, 'user_id' => 111, 'total_amount' => 1400.00, 'status' => 'shipped', 'order_date' => '2024-07-11 17:30:00'],
    ['order_id' => 12, 'user_id' => 112, 'total_amount' => 1750.80, 'status' => 'delivered', 'order_date' => '2024-07-12 10:45:00'],
    ['order_id' => 13, 'user_id' => 113, 'total_amount' => 890.25, 'status' => 'pending', 'order_date' => '2024-07-13 14:20:00'],
    ['order_id' => 14, 'user_id' => 114, 'total_amount' => 1350.00, 'status' => 'shipped', 'order_date' => '2024-07-14 13:35:00'],
    ['order_id' => 15, 'user_id' => 115, 'total_amount' => 1600.60, 'status' => 'delivered', 'order_date' => '2024-07-15 11:05:00'],
    ['order_id' => 16, 'user_id' => 116, 'total_amount' => 995.99, 'status' => 'pending', 'order_date' => '2024-07-16 09:15:00'],
    ['order_id' => 17, 'user_id' => 117, 'total_amount' => 1450.75, 'status' => 'shipped', 'order_date' => '2024-07-17 16:45:00'],
    ['order_id' => 18, 'user_id' => 118, 'total_amount' => 1850.00, 'status' => 'delivered', 'order_date' => '2024-07-18 10:25:00'],
    ['order_id' => 19, 'user_id' => 119, 'total_amount' => 1050.50, 'status' => 'pending', 'order_date' => '2024-07-19 12:55:00'],
    ['order_id' => 20, 'user_id' => 120, 'total_amount' => 1500.00, 'status' => 'shipped', 'order_date' => '2024-07-20 14:35:00'],
];

// Optionally test error
// $error = "Sample error message.";

// Call layout renderer
renderMainLayout(
    function () {
        ?>
        <!-- Admin Order Section -->
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
                <td>₱<?= number_format((float)$o['total_amount'], 2) ?></td>
                <td><?= htmlspecialchars($o['status']) ?></td>
                <td><?= htmlspecialchars($o['order_date']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
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
?>