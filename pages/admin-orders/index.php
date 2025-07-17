<?php 
declare(strict_types=1);

// call the layout you want to use from layout folder
require_once LAYOUTS_PATH . "/main.layout.php";
require_once UTILS_PATH . '/orders.util.php';
require_once UTILS_PATH . '/auth.util.php';
// $mongoCheckerResult = require_once HANDLERS_PATH . "/mongodbChecker.handler.php";
// $postgresqlCheckerResult = require_once HANDLERS_PATH . "/postgreChecker.handler.php";

$dsn = sprintf(
    'pgsql:host=%s;port=%s;dbname=%s',
    $_ENV['PG_HOST'],
    $_ENV['PG_PORT'],
    $_ENV['PG_DB']
);

$pdo = new PDO($dsn, $_ENV['PG_USER'], $_ENV['PG_PASS'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$orders = OrdersUtil::getAll($pdo);

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
                <td><?= number_format((float)$o['total_amount'], 2) ?></td>
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