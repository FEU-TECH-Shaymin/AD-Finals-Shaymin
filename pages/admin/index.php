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
            <div class="container text-center text-light">
                <h1 class="dashboard-welcome">Welcome, Admin!</h1>
                <div class="row justify-content-center g-4 mt-4">
                    <div class="col-md-3">
                        <div class="dashboard-card glass-card">
                            <img src="assets/img/total-user-icon.png" alt="Users Icon" class="dash-icon">
                            <h5>Total Users</h5>
                            <p class="dash-count"><?= $totalUsers ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-card glass-card">
                            <img src="assets/img/total-product-icon.png" alt="Products Icon" class="dash-icon">
                            <h5>Total Products</h5>
                            <p class="dash-count"><?= $totalProducts ?></p>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="dashboard-card glass-card">
                            <img src="assets/img/cart-icon.png" alt="Orders Icon" class="dash-icon">
                            <h5>Total Orders</h5>
                            <p class="dash-count"><?= $totalOrders ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section></section>
        <?php
    },
    [
        "css" => [
            "./assets/css/style.css"
        ],
        "js" => [
        ]
    ]
);
// Simulated queries (replace with real queries)
function getTotalUsers(): int { return 157; }
function getTotalProducts(): int { return 56; }
function getTotalOrders(): int { return 93; }