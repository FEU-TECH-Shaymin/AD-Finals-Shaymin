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
        <!-- Products Management Section -->
        <section class="section">
            <div class="container-fluid">
                <form action="/handlers/products.handler.php" method="POST">
                    <input type="hidden" name="action" value="create">

                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" required>

                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="3"></textarea>

                    <label for="category">Category</label>
                    <select name="category" id="category" required>
                    <option value="" disabled selected>-- Select Category --</option>
                    <option value="Weapons">Weapons</option>
                    <option value="Medical">Medical</option>
                    <option value="Food">Food</option>
                    <option value="Tools">Tools</option>
                    </select>

                    <label for="price">Price (₱)</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" required>

                    <label for="stock_quantity">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" min="0" required>

                    <button type="submit">Add Product</button>
                </form>
            </div>
        </section>
        
        <section class="product-search-section">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by name or category..." value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit">Search</button>
            </form>

            <!-- Product List -->
            <div class="product-list">
                <?php if (!$products): ?>
                <p>No products found.</p>
                <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <div class="product">
                    <strong><?= htmlspecialchars($p['name']) ?></strong><br>
                    <small>Category: <?= htmlspecialchars($p['category']) ?></small><br>
                    ₱<?= number_format((float)$p['price'], 2) ?><br>
                    In Stock: <?= (int)$p['stock_quantity'] ?><br>
                    <em><?= htmlspecialchars($p['description']) ?></em>
                    </div>
                <?php endforeach; ?>
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