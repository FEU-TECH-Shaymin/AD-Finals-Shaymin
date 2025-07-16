<?php 
declare(strict_types=1);

// call the layout you want to use from layout folder
require_once LAYOUTS_PATH . "/main.layout.php";
// $mongoCheckerResult = require_once HANDLERS_PATH . "/mongodbChecker.handler.php";
// $postgresqlCheckerResult = require_once HANDLERS_PATH . "/postgreChecker.handler.php";

// Call layout renderer
renderMainLayout(
    function () {
        ?>
        <!-- Hero Section -->
        <section class="admin-order-section">
            <div class="container-fluid">
                <form action="/handlers/orders.handler.php" method="POST">
                    <input type="hidden" name="action" value="create">

                    <label for="total_amount">Total Amount (₱)</label>
                    <input type="number" step="0.01" min="0" name="total_amount" id="total_amount" required>

                    <!-- Optional: Allow user to select status if you want -->
                    <label for="status">Order Status</label>
                    <select name="status" id="status">
                    <option value="pending" selected>Pending</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    </select>
                    <button type="submit">Submit Order</button>
                </form>
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