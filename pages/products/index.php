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
  "Medical" => [
    ["name" => "Bandaid", "desc" => "Adhesive bandage used for covering minor cuts and wounds.", "price" => 10, "bg" => "images/bandaid.jpg"],
    ["name" => "Bandage", "desc" => "Basic medical supply used to stop bleeding and heal minor wounds.", "price" => 25, "bg" => "images/bandage.jpg"],
    ["name" => "Healing Potion", "desc" => "Restores health quickly and effectively during critical moments.", "price" => 50, "bg" => "images/healing potion.jpg"],
  ],
  "Tools" => [
    ["name" => "Compass", "desc" => "Navigation tool used to determine direction and assist in orienteering.", "price" => 10, "bg" => "images/compass.jpg"],
    ["name" => "Flashlight", "desc" => "Portable light source essential for exploring dark areas.", "price" => 10, "bg" => "images/flashlight.jpg"],
    ["name" => "Lighter", "desc" => "Compact fire-starting tool useful for survival and cooking.", "price" => 10, "bg" => "images/lighter.jpg"],
    ["name" => "Radio", "desc" => "Communication device to receive emergency broadcasts and updates.", "price" => 25, "bg" => "images/radio.jpg"],
    ["name" => "Binoculars", "desc" => "Optical tool for scouting distant areas and spotting threats early.", "price" => 30, "bg" => "images/binoculars.jpg"],
  ],
  "Sustenance" => [
    ["name" => "Chocolate", "desc" => "High-energy food item that boosts morale and provides quick calories.", "price" => 5, "bg" => "images/chocolate.jpg"],
    ["name" => "Turon", "desc" => "Sweet banana roll snack that offers a quick energy boost.", "price" => 5, "bg" => "images/turon.jpg"],
    ["name" => "Chicken", "desc" => "Protein-rich meal ideal for restoring stamina.", "price" => 25, "bg" => "images/chicken.jpg"],
    ["name" => "Rice", "desc" => "Carbohydrate staple providing long-lasting energy.", "price" => 25, "bg" => "images/rice.jpg"],
    ["name" => "Water", "desc" => "Essential for hydration and survival.", "price" => 10, "bg" => "images/water.jpg"],
  ],
  "Bundles" => [
    ["name" => "Beginner’s Bundle", "desc" => "3 weapons, 2 medical, 2 sustenance (one food, one water)", "price" => 150, "bg" => "images/beginner.jpg"],
    ["name" => "Intermediate Bundle", "desc" => "2 weapons, 2 medical, 2 tools, 2 sustenance", "price" => 180, "bg" => "images/intermediate.jpg"],
    ["name" => "Advanced Bundle", "desc" => "5 weapons, 2 medical, 3 tools, 3 sustenance", "price" => 300, "bg" => "images/advanced.jpg"],
  ],
];

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

                                <!-- ADD TO CART FORM -->
                                 <form action="transaction.php" method="POST">
                                    <input type="hidden" name="name" value="<?= $product['name'] ?>">
                                    <input type="hidden" name="price" value="<?= $product['price'] ?>">
                                    <input type="hidden" name="desc" value="<?= $product['desc'] ?>">
                                    <input type="hidden" name="bg" value="<?= $product['bg'] ?>">
                                    <button class="add-to-cart" data-name="<?= $product['name'] ?>">Add to Cart</button>
                                </form>
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
