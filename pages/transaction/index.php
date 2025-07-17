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
          <div class="container">
    <div class="form-header">
      <h1>Transaction</h1>
    </div>

    <div class="checkout-content">
      <form class="checkout-form" action="submit_transaction.php" method="POST">
        <label>
          Full Name <span>*</span>
          <input type="text" name="fullname" required>
        </label>

        <label>
          Email <span>*</span>
          <input type="email" name="email" required>
        </label>

        <label>
          Phone Number <span>*</span>
          <input type="tel" name="phone" required>
        </label>

        <label>
          Address <span>*</span>
          <input type="text" name="address" required>
        </label>
      </form>

      <div class="order-summary">
        <h2>Order Summary</h2>
        <p><strong>Product:</strong> Outlast Survival Kit</p>
        <p><strong>Price:</strong> ₱1,299.00</p>
        <p class="total"><strong>Total:</strong> ₱1,299.00</p>

        <div class="buttons">
          <button class="confirm" type="submit" form="form">Confirm Order</button>
          <button class="cancel" onclick="window.location.href='index.php'">Cancel</button>
        </div>
      </div>
    </div>
  </div>
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