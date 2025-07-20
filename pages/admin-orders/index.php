<?php 
declare(strict_types=1);

require_once LAYOUTS_PATH . "/main.layout.php";
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/transactions.util.php';

Auth::init();
$user = Auth::user();

if (!$user) {
    echo "<div class='container text-center text-danger py-5'><h4>User not authenticated.</h4></div>";
    exit;
}

$transactions = getAllTransactions();

renderMainLayout(function () use ($transactions, $user) {
?>
<section class="aos-section text-white py-5">
    <div class="container">
        <h2 class="text-center aos-title mb-4">Orders List</h2>

        <?php if (empty($transactions)): ?>
            <p class="text-center text-muted">No orders yet.</p>
        <?php else: ?>
            <?php foreach ($transactions as $tx): ?>
                <form 
                    class="aos-form mb-4 p-4 rounded"
                    method="<?= $tx['status'] === 'pending' ? 'POST' : 'GET' ?>" 
                    action="<?= $tx['status'] === 'pending' ? '/handlers/mark_completed.handler.php' : '#' ?>"
                >
                    <div class="form-group mb-3">
                        <label>User</label>
                        <input type="text" class="form-control readonly-input" 
                            value="<?= htmlspecialchars($tx['first_name'] . ' ' . $tx['last_name']) ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Date</label>
                        <input type="text" class="form-control readonly-input" 
                            value="<?= htmlspecialchars($tx['transaction_date']) ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Products</label>
                        <textarea class="form-control readonly-input" rows="2" readonly><?= htmlspecialchars($tx['products_summary'] ?? 'N/A') ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Currency</label>
                        <input type="text" class="form-control readonly-input" 
                            value="<?= htmlspecialchars($tx['currency']) ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Amount Paid</label>
                        <input type="text" class="form-control readonly-input" 
                            value="<?= number_format((float)$tx['amount_paid'], 2) ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Total Amount</label>
                        <input type="text" class="form-control readonly-input" 
                            value="<?= number_format((float)$tx['total_amount'], 2) ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Change</label>
                        <input type="text" class="form-control readonly-input" 
                            value="<?= number_format((float)$tx['change'], 2) ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status</label>
                        <input type="text" class="form-control readonly-input" 
                            value="<?= ucfirst($tx['status']) ?>" readonly>
                    </div>

                    <?php if ($tx['status'] === 'pending'): ?>
                        <input type="hidden" name="transaction_id" value="<?= $tx['transaction_id'] ?>">
                    <?php endif; ?>
                </form>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
<?php
}, [
    "css" => ["./assets/css/style.css"],
    "js" => []
]);
