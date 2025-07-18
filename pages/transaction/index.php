<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/transactions.util.php';
require_once LAYOUTS_PATH . '/main.layout.php';

Auth::init();
$user = Auth::user();

if (!$user) {
    header('Location: /pages/login/index.php');
    exit;
}

$transactions = getUserTransactions($user['id']);

renderMainLayout(function () use ($transactions) {
?>
<div id="transaction-page" class="container py-4">
    <h2 class="mb-4">Your Transactions</h2>

    <?php if (empty($transactions)): ?>
        <p>No transactions yet.</p>
    <?php else: ?>
        <?php foreach ($transactions as $txn): ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Transaction #<?= htmlspecialchars($txn['transaction_id']) ?></strong>
                    <span class="badge badge-<?= $txn['status'] === 'completed' ? 'success' : 'warning' ?>">
                        <?= ucfirst($txn['status']) ?>
                    </span>
                </div>
                <div class="card-body">
                    <p><strong>Date:</strong> <?= htmlspecialchars($txn['transaction_date']) ?></p>
                    <p><strong>Currency:</strong> 
                        <img class="currency-icon" src="/pages/transaction/assets/img/crystal.png" alt="Crystal">
                        <?= htmlspecialchars($txn['currency']) ?>
                    </p>
                    <p><strong>Total Amount:</strong>
                        <img class="currency-icon" src="/pages/transaction/assets/img/crystal.png" alt="Crystal">
                        <?= htmlspecialchars($txn['total_amount']) ?>
                    </p>
                    <p><strong>Amount Paid:</strong>
                        <img class="currency-icon" src="/pages/transaction/assets/img/crystal.png" alt="Crystal">
                        <?= htmlspecialchars($txn['amount_paid']) ?>
                    </p>
                    <p><strong>Change:</strong>
                        <img class="currency-icon" src="/pages/transaction/assets/img/crystal.png" alt="Crystal">
                        <?= htmlspecialchars($txn['change']) ?>
                    </p>

                    <?php if ($txn['status'] === 'pending'): ?>
                        <form action="/handlers/confirm.handler.php" method="POST" class="mt-3">
                            <input type="hidden" name="transaction_id" value="<?= htmlspecialchars($txn['transaction_id']) ?>">
                            <button type="submit" class="btn btn-confirm">Confirm Payment</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php
});
