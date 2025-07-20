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
        <!-- User Section -->
            <section class="user-section">
                <div class="container-fluid user-img-wrapper">
                    <img src="./assets/img/outlast-user-txt.png" class="img-fluid user-sc-img" alt="">
                </div>
            </section>

            <section class="about-section">
                <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6">
                    <img src="./assets/img/outlastImage1.png" alt="Woman standing infront of door" class="img-fluid abt-img">
                    </div>
                    <div class="col-12 col-sm-6">
                    <img src="./assets/img/outlastImage2.png" alt="Why Choose Outlast text" class="img-fluid abt-img">
                    </div>
                </div>
                </div>
            </section>

            <section class="about-cards">
                <div class="about-container container">
                <div class="row g-4" id="about-cards-grid"></div>
                </div>
            </section>

            <section class="zcry-section">
                <div class="container-fluid zcry-container">
                <div class="row g-0">
                    <div class="col-12 col-sm-6 zcry-col">
                    <img src="./assets/img/zcry-img.png" alt="" class="img-fluid zcry-img">
                    </div>
                    <div class="col-12 col-sm-6 d-flex align-items-center justify-content-center">
                    <div class="zcry-text">
                        <img src="./assets/img/zcry-heading.png" alt="Zombie Crystals text" class="img-fluid zcry-txt">
                        <h5>
                        In the ashes of the old world, currency is no longer paper and metal. Now, only Zombie Crystals (ZCRY)—harvested from the skulls of the undead—hold value. These glowing shards hum with lingering energy, accepted universally in settlements and black markets alike. Power, trade, and survival—everything runs on the crystal now.
                        </h5>
                    </div>
                    </div>
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
            "./assets/js/script.js",
            "/pages/user/assets/js/script.js"
        ]
    ]
);
?>