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
        <section class="login-section d-flex align-items-center" style="min-height: 100vh;">
            <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
                <form id="sign-in-form" action="/handlers/auth.handler.php" method="POST">
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

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>

                    <input type="hidden" name="action" value="login">

                    <button type="submit" class="btn btn-primary w-100 mb-2">Log In</button>
                    <p class="text-center small">
                        Don't have an account? <a href="../signup/index.php">Sign Up</a>
                    </p>
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
