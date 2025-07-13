<?php
declare(strict_types=1);

// call the layout you want to use from layout folder
require_once LAYOUTS_PATH . "/main.layout.php";
// $mongoCheckerResult = require_once HANDLERS_PATH . "/mongodbChecker.handler.php";
// $postgresqlCheckerResult = require_once HANDLERS_PATH . "/postgreChecker.handler.php";

$error = trim((string) ($_GET['error'] ?? ''));
$error = str_replace("%", " ", $error);

$message = trim((string) ($_GET['message'] ?? ''));
$message = str_replace("%", " ", $message);

// Call layout renderer
renderMainLayout(
    function () {
        ?>
        <!-- Hero Section -->
        <section class="section">
            <div class="container-fluid">
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
