<?php
declare(strict_types=1);

// Use base project paths
require_once realpath(__DIR__ . '/../../bootstrap.php');
require_once UTILS_PATH . '/auth.util.php';
require_once LAYOUTS_PATH . '/main.layout.php';

Auth::init();
$user = Auth::user();

renderMainLayout(function () use ($user) {
    if (!$user) {
        echo "<p>Please log in to place an order.</p>";
        return;
    }
    ?>
    <!-- CSS path based on public URL -->
    <link rel="stylesheet" href="/pages/orders/assets/css/style.css">

    <h2>Place an Order</h2>

    <form action="/handlers/submit_order.handler.php" method="POST">
        <div>
            <label for="total_amount">Total Amount (₱):</label>
            <input type="number" step="0.01" name="total_amount" id="total_amount" required>
        </div>

        <div>
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="pending" selected>Pending</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>

        <button type="submit">Submit Order</button>
    </form>
<?php
});
?>
