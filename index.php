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
        <section class="hero-section">
            <div class="container-fluid">
                <div class="col hero-txt">
                    <img src="./assets/img/outlastLogoWhite.png" alt="Outlast Logo" class="hero-img">
                    <h1 class="hero-subheading">Survive the Horde. <br> Thrive in the Apocalypse.</h1>
                    <p class="hero-body">
                        When the world fell, we didn’t hide—we prepared. Get the ultimate survival gear. Trade in Zombie Crystals and secure your life.
                    </p>
                    <a href="./pages/products/index.php" class="btn btn-lg hero-cta">Our Products<i class="lni lni-arrow-right"></i></a>
                </div>
            </div>
            <div id="image"></div>
            <div id="glitch"></div>
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
          <!-- <img src="./assets/img/chooseOutlast.png" alt="Why Choose Outlast" class="choose-img"> -->
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
            "./assets/js/script.js"
        ]
    ]
);
?>