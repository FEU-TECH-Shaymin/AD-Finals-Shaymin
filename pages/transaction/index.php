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
        <section class="transaction-section d-flex align-items-center" style="min-height: 100vh;">
            <div class="card p-4 shadow-lg" style="max-width: 800px; width: 100%;"class="card p-4 shadow-lg" style="max-width: 800px; width: 100%;">
                <h2 class="text-center transaction-txt">Transaction</h2>
                <div class="checkout-content">
                    <form class="checkout-form" id="form" action="submit_transaction.php" method="POST">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" id="full_name" name="full_name" class="form-control" required>
                                    <div class="invalid-feedback">Please enter your full name.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                    <input type="phoneNumber" id="phoneNumber" name="phoneNumber" class="form-control" required>
                                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="address" id="address" name="address" class="form-control" required>
                                    <div class="invalid-feedback">Please enter a valid address.</div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="order-summary">
                                    
                                </div>
                            </div>
                        </div>
                    </form>
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
            "./assets/js/script.js"
        ]
    ]
);
?>