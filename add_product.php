<?php
include 'db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $price = $_POST['price'];

    // Upload Image
    $image = "";
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
        }
        $image = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    // Insert into DB
    $query = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
    if (mysqli_query($conn, $query)) {
        $msg = "<div class='alert alert-success'>✅ Product added successfully!</div>";
        header("Refresh:1; url=index.php");
    } else {
        $msg = "<div class='alert alert-danger'>❌ Error: " . mysqli_error($conn) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">My Shop</a>
    <div class="ms-auto">
      <a href="orders.php" class="btn btn-outline-light">View Orders</a>
    </div>
  </div>
</nav>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">➕ Add New Product</h4>
        </div>
        <div class="card-body">
          <?php echo $msg; ?>
          <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Product Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Price (Rs)</label>
              <input type="number" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Image</label>
              <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Add Product</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
