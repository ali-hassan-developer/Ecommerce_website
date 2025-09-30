<?php
// session_start();
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

// Redirect if admin not logged in
if(!isset($_SESSION['admin_name'])){
    header("Location: login.php");
    exit();
}

// ---------- Handle Status Update ----------
if(isset($_POST['update_status'])){
    $orderId = intval($_POST['order_id']);
    $newStatus = trim($_POST['status']);
    update('orders', ['status' => $newStatus], $orderId);
    header("Location: orders.php");
    exit();
}

// ---------- Fetch all orders ----------
$orders = fetch_all("SELECT * FROM orders ORDER BY created_at DESC");
?>

<div class="main-content">
    <div class="container-fluid">
        <h2 class="mb-4">Orders</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($orders)): ?>
                        <?php foreach($orders as $row): ?>
                            <?php
                                $status = strtolower(trim($row['status']));
                                $statusClass = ($status === 'completed') ? 'bg-success' :
                                               (($status === 'pending') ? 'bg-warning text-dark' : 'bg-danger');
                            ?>
                            <tr>
                                <td><?= intval($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                <td>$<?= number_format($row['total'], 2) ?></td>
                                <td><span class="badge <?= $statusClass ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                <td>
                                    <!-- Status Update Form -->
                                    <form method="post" class="d-flex gap-2">
                                        <input type="hidden" name="order_id" value="<?= intval($row['id']) ?>">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="Pending" <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
                                            <option value="Processing" <?= $row['status']=='Processing'?'selected':'' ?>>Processing</option>
                                            <option value="Completed" <?= $row['status']=='Completed'?'selected':'' ?>>Completed</option>
                                            <option value="Shipped" <?= $row['status']=='Shipped'?'selected':'' ?>>Shipped</option>
                                            <option value="Cancelled" <?= $row['status']=='Cancelled'?'selected':'' ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
