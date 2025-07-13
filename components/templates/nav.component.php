<?php
declare(strict_types=1);

function navHeader(array $navList, ?array $user = null): void
{
        ?>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto d-flex align-items-center" href="/index.php">
                <img src="/assets/img/outlastLogo.png" alt="Outlast Logo" class="navbar-img">
            </a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title d-flex align-items-center" id="offcanvasNavbarLabel">
                        <img src="/assets/img/outlastLgRed.png" alt="Outlast Logo">
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
