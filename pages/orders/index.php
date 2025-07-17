<?php
declare(strict_types=1);
require_once __DIR__ . '/../../layouts/main.layout.php';
require_once __DIR__ . '/../../utils/auth.util.php';

Auth::init();
$user = Auth::user();

renderMainLayout(function () use ($user) {
    if (!$user) {
        echo "<p>Please log in to place an order.</p>";
        return;
    }
    ?>
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
