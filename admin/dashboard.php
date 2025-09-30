<?php
// session_start();
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php'; // Database connection

// Redirect to login if admin is not logged in
if(!isset($_SESSION['admin_name'])){
    header("Location: login.php");
    exit();
}

// ---------- Fetch stats ----------
$totalOrders   = count_rows('orders');
$totalUsers    = count_rows('users');
$totalProducts = count_rows('products');

// Total revenue (handle NULL if no orders yet)
$revenueRow = fetch_assoc("SELECT SUM(total) AS total FROM orders");
$totalRevenue = $revenueRow['total'] ?? 0;

// ---------- Fetch recent 10 orders ----------
$recentOrders = fetch_all("SELECT id, customer_name, total, status, created_at FROM orders ORDER BY created_at DESC LIMIT 10");
?>

<div class="main-content">
    <div class="container-fluid">
        <h2 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?></h2>

        <!-- Stats Cards -->
        <div class="row mt-4 g-4">
            <div class="col-md-3">
                <div class="card p-3 bg-primary text-white">
                    <h5>Total Orders</h5>
                    <h3><?= $totalOrders ?></h3>
                    <i class="bi bi-cart-check" style="font-size:1.5rem"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 bg-success text-white">
                    <h5>Total Users</h5>
                    <h3><?= $totalUsers ?></h3>
                    <i class="bi bi-people" style="font-size:1.5rem"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 bg-warning text-dark">
                    <h5>Total Products</h5>
                    <h3><?= $totalProducts ?></h3>
                    <i class="bi bi-box-seam" style="font-size:1.5rem"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 bg-danger text-white">
                    <h5>Total Revenue</h5>
                    <h3>$<?= number_format($totalRevenue, 2) ?></h3>
                    <i class="bi bi-currency-dollar" style="font-size:1.5rem"></i>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="mt-5">
            <h4>Recent Orders</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#Order ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($recentOrders)): ?>
                            <?php foreach($recentOrders as $row): ?>
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
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No recent orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
