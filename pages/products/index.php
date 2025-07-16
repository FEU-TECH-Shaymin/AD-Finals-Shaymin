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
        <!-- 🔍 Search Form -->
        <section class="section">
            <div class="container-fluid">
                <form method="GET">
                    <input type="text" name="search" placeholder="Search by name or category..." value="<?= htmlspecialchars($keyword) ?>">
                    <button type="submit">Search</button>
                </form>
            </div>
        </section>

        <!-- 📦 Product List -->
        <section class="section">
            <div class="container-fluid">
                <div class="product-list" style="margin-top: 1rem;">
                    <?php if (empty($products)): ?>
                        <p>No products found.</p>
                    <?php else: ?>
                        <?php foreach ($products as $p): ?>
                            <div class="product" style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ccc;">
                                <strong><?= htmlspecialchars($p['name']) ?></strong><br>
                                <small>Category: <?= htmlspecialchars($p['category']) ?></small><br>
                                ₱<?= number_format((float)$p['price'], 2) ?><br>
                                In Stock: <?= (int)$p['stock_quantity'] ?><br>
                                <em><?= htmlspecialchars($p['description']) ?></em>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
