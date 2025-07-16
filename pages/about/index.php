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
        <!-- About Hero + Team Section -->
        <section class="about-hero-section">
            <div class="container text-center text-light">
                <h1 class="about-title">Who Are We?</h1>
                <p class="about-description">
                    We are survivors of the old world and builders of what comes next. When the world fell silent, we didn't.
                    We crafted tools, gathered knowledge, and built networks to help others endure.<br><br>
                    At Outlast, we supply the gear, knowledge, and essentials every survivor needs to face the horde and reclaim the future.
                    Whether you're hunting supplies, trading Zombie Crystals, or searching for safe ground — we're the ones lighting your path forward.<br><br>
                    Survive. Adapt. Outlast.
                </p>
                <a href="../contact/index.php" class="btn contact-cta">Contact Us</a>
            </div>
        </section>

        <!-- Meet The Team Section -->
        <section class="about-hero-section pt-5" id="team">
            <div class="container text-center text-light">
                <h2 class="team-title">Meet The Team</h2>
                <div class="row justify-content-center g-4">
                    <div class="col-md-4 col-lg-2">
                        <div class="team-card glass-card">
                            <img src="assets/img/AlexaGagan.png" alt="Alexa Gagan" class="team-img">
                            <h5>Alexa Gagan</h5>
                            <p class="role">Vision Weaver</p>
                            <p class="year">2nd Year - BSITWMA</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="team-card glass-card">
                            <img src="assets/img/michaela.jpg" alt="Michaela Gonzales" class="team-img">
                            <h5>Michaela Gonzales</h5>
                            <p class="role">The Archivist</p>
                            <p class="year">2nd Year - BSITWMA</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="team-card glass-card">
                            <img src="assets/img/shane.jpg" alt="Shane Oxina" class="team-img">
                            <h5>Shane Oxina</h5>
                            <p class="role">The Pathfinder</p>
                            <p class="year">2nd Year - BSITWMA</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="team-card glass-card">
                            <img src="assets/img/querviemanrique.jpg" alt="Quervie Manrique" class="team-img">
                            <h5>Quervie Manrique</h5>
                            <p class="role">Forge-Master</p>
                            <p class="year">2nd Year - BSITWMA</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="team-card glass-card">
                            <img src="assets/img/nicole.png" alt="Nicole Rivera" class="team-img">
                            <h5>Nicole Rivera</h5>
                            <p class="role">Relic Painter</p>
                            <p class="year">2nd Year - BSITWMA</p>
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

        ]
    ]
);
?>