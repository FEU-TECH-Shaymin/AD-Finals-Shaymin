<?php
declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once LAYOUTS_PATH . '/main.layout.php';
require_once UTILS_PATH . '/auth.util.php';

Auth::init();
$user = Auth::user();

renderMainLayout(function () use ($user) {
    if (!$user) {
        echo "<div class='container py-5'><div class='alert alert-warning text-center'>Please log in to place an order.</div></div>";
        return;
    }

    // ✅ Fetch products from DB
    $pdo = connectOrdersDB();
    $products = $pdo->query("SELECT product_id, product_name, price FROM products")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <link rel="stylesheet" href="/pages/orders/assets/css/style.css">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Place an Order</h2>
                <form action="/handlers/orders.handler.php" method="POST" class="p-4 bg-white shadow rounded">

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price (₱)</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                                        <td><?= number_format((float)$product['price'], 2) ?></td>
                                        <td>
                                            <input type="hidden" name="product_id[]" value="<?= $product['product_id'] ?>">
                                            <input type="number" class="form-control text-center" name="quantity[]" min="0" value="0">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
});
