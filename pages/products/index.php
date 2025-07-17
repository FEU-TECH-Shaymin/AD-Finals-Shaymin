<?php 
declare(strict_types=1);

// Load layout and utilities
require_once LAYOUTS_PATH . "/main.layout.php";
require_once UTILS_PATH . "/products.util.php";

// Prepare search keyword and product list
$keyword = trim($_GET['search'] ?? '');
$products = $keyword
    ? ProductsUtil::search($keyword)
    : ProductsUtil::getAll();

// Call layout renderer
renderMainLayout(
    function () use ($keyword, $products) {
        ?>
        <section class="all-categories-bg">
            <div class="top-bar">
                <img src="images/outlastLogo.png" class="logo" alt="Outlast Logo">
                <div class="search-section">
                    <input type="text" class="search" placeholder="Search">
                    <img src="images/search.png" class="search-icon" alt="Search">
                </div>
                <div class="icons">
                    <img src="images/carttt.png" alt="Cart" class="icon-img">
                </div>
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
