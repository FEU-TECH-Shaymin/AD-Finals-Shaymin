<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once LAYOUTS_PATH . "/main.layout.php";
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/transactions.util.php';

Auth::init();
$user = Auth::user();

renderMainLayout(function () use ($user) {
    if (!$user) {
        echo "<div class='container py-5'><div class='alert alert-danger'>You must be logged in to view transactions.</div></div>";
        return;
    }

    $transactions = getTransactionsWithDetails($user['id']);
    ?>

    <div class="container py-5">
        <h2 class="mb-4">My Transactions</h2>

        <?php if (isset($_GET['confirmed'])): ?>
            <div class="alert alert-success">Payment confirmed successfully.</div>
        <?php endif; ?>

        <?php if (empty($transactions)): ?>
            <div class="alert alert-info">No transactions found.</div>
        <?php else: ?>
            <?php foreach ($transactions as $txn): ?>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Order ID: <?= htmlspecialchars($txn['order_id']) ?></strong>
                        <span>Status:
                            <?php if ($txn['status'] === 'paid'): ?>
                                <span class="badge bg-success">Paid</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <p><strong>Date:</strong> <?= htmlspecialchars($txn['transaction_date']) ?></p>
                        <p><strong>Total Amount:</strong> <img src="/assets/zombie-crystal.png" style="height: 20px;"> <?= htmlspecialchars($txn['total_amount']) ?></p>
                        <p><strong>Amount Paid:</strong> <img src="/assets/zombie-crystal.png" style="height: 20px;"> <?= htmlspecialchars($txn['amount_paid']) ?></p>
                        <p><strong>Change:</strong> <img src="/assets/zombie-crystal.png" style="height: 20px;"> <?= htmlspecialchars($txn['change']) ?></p>

                        <hr>
                        <h5>Products:</h5>
                        <ul class="list-group">
                            <?php foreach ($txn['products'] as $product): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($product['product_name']) ?> × <?= $product['quantity'] ?>
                                    <span><img src="/assets/zombie-crystal.png" style="height: 16px;"> <?= htmlspecialchars($product['price'] * $product['quantity']) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <?php if ($txn['status'] === 'pending'): ?>
                            <form action="/handlers/confirm.handler.php" method="POST" class="mt-3">
                                <input type="hidden" name="transaction_id" value="<?= htmlspecialchars($txn['transaction_id']) ?>">
                                <button type="submit" class="btn btn-success">Confirm Payment</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php
});
