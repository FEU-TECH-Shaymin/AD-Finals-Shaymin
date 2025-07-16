<?php 
declare(strict_types=1);

// call the layout you want to use from layout folder
require_once LAYOUTS_PATH . "/main.layout.php";
// $mongoCheckerResult = require_once HANDLERS_PATH . "/mongodbChecker.handler.php";
// $postgresqlCheckerResult = require_once HANDLERS_PATH . "/postgreChecker.handler.php";

// Fetch values from database
$totalUsers = getTotalUsers();      // example function
$totalProducts = getTotalProducts();
$totalOrders = getTotalOrders();

// Call layout renderer
renderMainLayout(
    function () use ($totalUsers, $totalProducts, $totalOrders) {
        ?>
        <!-- Hero Section -->
        <section class="dashboard-wrapper">
            <div class="container-fluid">
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