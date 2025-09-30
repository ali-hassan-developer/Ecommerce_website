<?php

include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php'; 

$msg = "";
$uploadDir = "../assets/images/";

// ---------- Handle Add Product ----------
if (isset($_POST['add_product'])) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '0';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $stock_status = isset($_POST['stock_status']) ? trim($_POST['stock_status']) : 'in_stock';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $imageName = '';

    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = 'product_' . time() . '.' . $ext;
        $target = $uploadDir . $imageName;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imageName = '';
            $msg = "Failed to upload image.";
        }
    }

    if ($msg == '') {
        $data = [
            'name' => $name,
            'price' => $price,
            'category' => $category,
            'stock_status' => $stock_status,
            'description' => $description,
            'image' => $imageName,
            'is_deleted' => 'no'
        ];
        $newId = insert('products', $data);
        if ($newId) {
            $msg = "Product added successfully!";
        } else {
            $msg = "Error adding product.";
        }
    }
}

// ---------- Handle Update Product ----------
if (isset($_POST['update_product'])) {
    $id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    if ($id > 0) {
        // Fetch existing product to know current image
        $existing = fetch_assoc("SELECT * FROM products WHERE id = " . intval($id));
        $imageName = isset($existing['image']) ? $existing['image'] : '';

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $price = isset($_POST['price']) ? trim($_POST['price']) : '0';
        $category = isset($_POST['category']) ? trim($_POST['category']) : '';
        $stock_status = isset($_POST['stock_status']) ? trim($_POST['stock_status']) : 'in_stock';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';

        if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newImage = 'product_' . $id . '_' . time() . '.' . $ext;
            $target = $uploadDir . $newImage;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // delete old image if exists
                if (!empty($imageName) && file_exists($uploadDir . $imageName)) {
                    @unlink($uploadDir . $imageName);
                }
                $imageName = $newImage;
            }
        }

        $data = [
            'name' => $name,
            'price' => $price,
            'category' => $category,
            'stock_status' => $stock_status,
            'description' => $description,
            'image' => $imageName
        ];

        if (update('products', $data, $id)) {
            $msg = "Product updated successfully!";
        } else {
            $msg = "Error updating product.";
        }
    } else {
        $msg = "Invalid product ID.";
    }
}

// ---------- Handle Delete (soft delete) ----------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        // soft delete
        update('products', ['is_deleted' => 'yes'], $id);
        header("Location: products.php");
        exit();
    }
}

// ---------- Fetch products ----------
$products = fetch_all("SELECT * FROM products WHERE is_deleted='no' ORDER BY id DESC");
?>

<div class="main-content">
    <div class="container-fluid">
        <h2 class="mb-4">Products</h2>

        <?php if (!empty($msg)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <!-- Add Product Button -->
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">+ Add Product</button>
        </div>

        <!-- Products Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th style="width:120px">Price</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th style="width:160px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): foreach ($products as $row): ?>
                    <tr>
                        <td><?= intval($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>$<?= number_format($row['price'], 2) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= ucfirst(str_replace('_', ' ', $row['stock_status'])) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm editBtn"
                                data-id="<?= intval($row['id']) ?>"
                                data-name="<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>"
                                data-price="<?= htmlspecialchars($row['price'], ENT_QUOTES) ?>"
                                data-category="<?= htmlspecialchars($row['category'], ENT_QUOTES) ?>"
                                data-stock="<?= htmlspecialchars($row['stock_status'], ENT_QUOTES) ?>"
                                data-description="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>"
                                data-image="<?= htmlspecialchars($row['image'], ENT_QUOTES) ?>">
                                Edit
                            </button>
                            <a href="products.php?delete=<?= intval($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="6" class="text-center">No products found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Add Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stock Status</label>
                    <select name="stock_status" class="form-select">
                        <option value="in_stock">In Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="product_id" id="edit_product_id">
        <div class="modal-header">
          <h5 class="modal-title">Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" id="edit_category" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stock Status</label>
                    <select name="stock_status" id="edit_stock_status" class="form-select">
                        <option value="in_stock">In Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="edit_description" class="form-control" rows="4"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Current Image</label>
                    <img id="edit_image_preview" src="" style="max-width:150px; display:block; margin-bottom:10px;"/>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Leave blank to keep existing image</small>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.editBtn').on('click', function(){
        var id = $(this).data('id');
        $('#edit_product_id').val(id);
        $('#edit_name').val($(this).data('name'));
        $('#edit_price').val($(this).data('price'));
        $('#edit_category').val($(this).data('category'));
        $('#edit_stock_status').val($(this).data('stock'));
        $('#edit_description').val($(this).data('description'));
        var image = $(this).data('image');
        if(image){
            $('#edit_image_preview').attr('src','../assets/images/'+image).show();
        } else {
            $('#edit_image_preview').hide();
        }
        $('#editProductModal').modal('show');
    });
});
</script>
