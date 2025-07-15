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

        <!--Contact Info Section-->
        <section class="contact-info-section">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-md-3 icon-box">
                        <img src="#" alt="Location Icon" class="contact-icon">
                        <h5>Where to Find Us</h5>
                        <p>311 Recto Ave. Sampaloc,<br>Metro Manila</p>
                    </div>
                    <div class="col-md-3 icon-box">
                        <img src="#" alt="Working Hours Icon" class="contact-icon">
                        <h5>Working Hours</h5>
                        <p>Mon to Sat: 9:00 am - 6:00 pm<br>Sunday: 9:00 am - 4:00 pm</p>
                    </div>
                    <div class="col-md-3 icon-box">
                        <img src="#" alt="Location Icon" class="contact-icon">
                        <h5>Communication</h5>
                        <p>+63 912 345 6789<br>outlast@gmail.com</p>
                    </div>
                </div>
            </div>
        </section>
        <?php
    },
);
?>