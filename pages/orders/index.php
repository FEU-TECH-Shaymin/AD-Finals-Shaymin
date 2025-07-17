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
    ?>
    <!-- Link to custom orders CSS -->
    <link rel="stylesheet" href="/pages/orders/assets/css/style.css">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Place an Order</h2>
                <form action="/handlers/orders.handler.php" method="POST" class="p-4 bg-white shadow rounded">
                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Total Amount (₱):</label>
                        <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" selected>Pending</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
});
