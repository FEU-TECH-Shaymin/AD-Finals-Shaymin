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

// Group products by category
$categories = [];
foreach ($products as $product) {
    $category = $product['category'] ?? 'Uncategorized';
    $categories[$category][] = $product;
}

// Call layout renderer
renderMainLayout(
    function () use ($keyword, $categories) {
        ?>
        <section class="all-categories-bg">
            <div class="top-bar">

            </div>

            <?php foreach ($categories as $category => $items): ?>
                <h2 class="category-title"><?= htmlspecialchars($category) ?></h2>
                <div class="product-grid">
                    <?php foreach ($items as $product): 
                        // Handle image path with fallback if file doesn't exist
                        $imageFilename = $product['image_path'] ?? 'default.png';
                        $imageDir = '/pages/products/assets/img/';
                        $absolutePath = $_SERVER['DOCUMENT_ROOT'] . $imageDir . $imageFilename;
                        $finalFilename = file_exists($absolutePath) ? $imageFilename : 'default.png';
                        $bgPath = $imageDir . rawurlencode($finalFilename);
                    ?>
                        <div 
                            class="product-card"
                            style="background-image: url('<?= htmlspecialchars($bgPath) ?>');"
                        >
                            <div class="product-info">
                                <div class="product-name"><?= htmlspecialchars($product['name'] ?? '') ?></div>
                                <div class="product-desc"><?= htmlspecialchars($product['description'] ?? '') ?></div>
                                <div class="product-price">
                                    <?= htmlspecialchars($product['price'] ?? '0.00') ?> zombie crystals
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </section>
        <?php
    },
    [
        "css" => [
            "./assets/css/style.css"
        ],
        "js" => [
            "/assets/js/script.js"
        ]
    ]
);
