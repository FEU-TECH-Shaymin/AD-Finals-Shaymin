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
