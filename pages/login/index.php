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
    function () use ($error, $message) {
        ?>
        <section class="login-section d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
                <form action="/handlers/auth.handler.php" method="POST">
                    <h2 class="text-center mb-4">Log In</h2>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                </form>
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
