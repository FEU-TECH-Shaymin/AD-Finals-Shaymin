<?php 
declare(strict_types=1);

// call the layout you want to use from layout folder
require_once LAYOUTS_PATH . "/main.layout.php";

$error = urldecode(trim((string) ($_GET['error'] ?? '')));
$message = urldecode(trim((string) ($_GET['message'] ?? '')));

// Call layout renderer
renderMainLayout(
    function () use ($error, $message) {
        ?>
        <section class="signup-section d-flex align-items-center" style="min-height: 100vh;">
            <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
                <form id="sign-up-form" action="/handlers/signup.handler.php" method="POST">
                    <h2 class="text-center mb-4">Sign Up</h2>

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
                        <div class="invalid-feedback">Please enter a username.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" minlength="8" required>
                        <div class="invalid-feedback">Password must be at least 8 characters.</div>
                    </div>

                    <input type="hidden" name="action" value="signup">

                    <button type="submit" class="btn btn-primary w-100 mb-2">Sign Up</button>
                    <p class="text-center small">
                        Already have an account? <a href="../login/index.php">Log In</a>
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