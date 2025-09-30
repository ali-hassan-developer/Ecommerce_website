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
    $userId = intval($_POST['user_id']);
    $newStatus = trim($_POST['status']);
    update('users', ['status' => $newStatus], $userId);
    header("Location: users.php");
    exit();
}

// ---------- Handle Soft Delete ----------
if(isset($_GET['delete'])){
    $userId = intval($_GET['delete']);
    update('users', ['is_deleted' => 'yes'], $userId);
    header("Location: users.php");
    exit();
}

// ---------- Fetch all users ----------
$users = fetch_all("SELECT * FROM users WHERE is_deleted='no' ORDER BY id DESC");
?>

<div class="main-content">
    <div class="container-fluid">
        <h2 class="mb-4">Users</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($users)): ?>
                        <?php foreach($users as $row): ?>
                            <?php
                                $statusClass = ($row['status'] === 'Active') ? 'bg-success' : 'bg-danger';
                            ?>
                            <tr>
                                <td><?= intval($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['role']) ?></td>
                                <td><span class="badge <?= $statusClass ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                                <td>
                                    <!-- Status Update Form -->
                                    <form method="post" class="d-flex gap-2 mb-1">
                                        <input type="hidden" name="user_id" value="<?= intval($row['id']) ?>">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="Active" <?= $row['status']=='Active'?'selected':'' ?>>Active</option>
                                            <option value="Inactive" <?= $row['status']=='Inactive'?'selected':'' ?>>Inactive</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-sm btn-primary">Update</button>
                                    </form>

                                    <!-- Delete Button -->
                                    <a href="users.php?delete=<?= intval($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
