<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/orders.util.php';
require_once LAYOUTS_PATH . "/main.layout.php";

Auth::init();
$user = Auth::user();

renderMainLayout(function () use ($user) {
    if (!$user) {
        echo "<div class='container py-5'><div class='alert alert-warning text-center'>Please log in to place an order.</div></div>";
        return;
    }

    $pdo = connectOrdersDB();
    $products = $pdo->query("SELECT product_id, name AS product_name, price FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="orders-section">
    <div class="zombie-order-form">
        <h2 class="text-center mb-4 os-txt">Order Form</h2>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- ✅ Changed: product data passed via data-products attribute -->
                <form 
                    action="/handlers/orders.handler.php"
                    method="POST"
                    class="order-form"
                    id="orderForm"
                    data-products='<?= json_encode($products, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
                >
                    <input type="hidden" name="order_items" id="orderItems" />

                    <!-- Select and Add Product -->
                    <div class="mb-3 d-flex justify-content-between align-items-center select-product">
                        <div>
                            <label for="product" class="form-label os-label">Select Product</label>
                            <select id="product" class="form-select">
                                <option value="" disabled selected>Choose product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= htmlspecialchars($product['product_id']) ?>">
                                        <?= htmlspecialchars($product['product_name']) ?> (<?= $product['price'] ?> ZCRY)
                                    </option>a
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="quantity" class="form-label os-label">Quantity</label>
                            <input type="number" id="quantity" class="form-control" min="1" value="1" />
                        </div>
                    </div>

                    <!-- Order Table -->
                    <div id="orderTableWrapper" style="display: none;">
                        <table class="table-bordered" id="orderTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <!-- Payment Section -->
                    <div class="mb-3">
                        <label for="money_given" class="form-label os-label">Zombie Crystals Given</label>
                        <div class="input-group">
                            <span class="input-group-text" id="currencyIcon">
                                <img src="/pages/orders/assets/img/crystal.png" alt="Currency" style="width: 24px; height: 24px;" />
                            </span>
                           <input type="number" step="0.01" min="0" id="money_given" name="amount_paid" class="form-control" placeholder="Enter amount given" required />

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="total" class="form-label os-label">Total (Zombie Crystals)</label>
                        <input type="text" id="total" class="form-control" readonly value="0.00" />
                    </div>

                    <div class="mb-3">
                        <label for="change" class="form-label os-label">Change</label>
                        <input type="text" id="change" class="form-control" readonly value="0.00" />
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn zombie-submit" id="submitBtn" disabled>Confirm Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
}, [
    "css" => [
    "/pages/orders/assets/css/style.css"
    ],
    "js" => [
        "/pages/orders/assets/js/script.js"
    ]
]);
?>
