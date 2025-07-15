<?php
declare(strict_types=1);

require_once LAYOUTS_PATH . "/main.layout.php";

renderMainLayout(
    function () {
        ?>
        <!--Contact Hero Section-->
        <section class="contact-hero-section">
            <div class="container text-center">
                <h1>Need Help Surviving?</h1>
                <p>
                    Whether you're looking for gear recommendations or having trouble trading your Zombie Crystals, our squad is ready in the shadows—Outlast is here.
                </p>
                <a href="#contact-form" class="btn contact-cta">Contact Us</a>
            </div>
        </section>

        
        <?php
    },
);
?>