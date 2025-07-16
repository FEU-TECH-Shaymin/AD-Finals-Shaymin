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
        <!-- PASTE YOUR CODE HERE -->
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