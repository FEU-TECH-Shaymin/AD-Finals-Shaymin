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

$categories = [
  "Weapons" => [
    ["name" => "Baseball Bat", "desc" => "Sturdy blunt weapon effective for close combat and self-defense", "price" => 10, "bg" => "images/baseball bat.png"],
    ["name" => "Sword", "desc" => "Sharp melee weapon ideal for silent and precise attacks.", "price" => 10, "bg" => "images/sword.png"],
    ["name" => "Knife", "desc" => "Compact blade suitable for stealth and utility purposes.", "price" => 10, "bg" => "images/knife.png"],
    ["name" => "Axe", "desc" => "Heavy-duty weapon capable of chopping through bone and wood.", "price" => 10, "bg" => "images/axe.png"],
    ["name" => "Machete", "desc" => "Long blade perfect for slashing through dense areas or enemies.", "price" => 25, "bg" => "images/machete.png"],
    ["name" => "Chainsaw", "desc" => "Devastating close-range weapon with high damage output.", "price" => 25, "bg" => "images/chainsaw.png"],
    ["name" => "Gun", "desc" => "Reliable ranged weapon suitable for rapid elimination of threats.", "price" => 25, "bg" => "images/gun.png"],
    ["name" => "Bow and Arrow", "desc" => "Silent ranged weapon useful for distance attacks and reuse of ammo.", "price" => 25, "bg" => "images/bow and arrow.jpg"],
    ["name" => "Flamethrower", "desc" => "Spreads fire across multiple targets, effective for crowd control.", "price" => 50, "bg" => "images/flame thrower.jpg"],
    ["name" => "Bazooka", "desc" => "Powerful explosive weapon designed for maximum destruction.", "price" => 50, "bg" => "images/bazooka.jpg"],
  ],

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

            <?php foreach ($categories as $category => $items): ?>
                <h2 class="category-title"><?= $category ?></h2>
                <div class="product-grid">
                    <?php foreach ($items as $product): ?>
                        <div class="product-card" style="background-image: url('<?= $product['bg'] ?>');">
                            <div class="product-info">
                                <div class="product-name"><?= $product['name'] ?></div>
                                <div class="product-desc"><?= $product['desc'] ?></div>
                                <div class="product-price"><?= $product['price'] ?> zombie crystals</div>
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
            "./assets/js/script.js"
        ]
    ]
);
