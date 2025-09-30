
<?php
session_start();
include 'includes/db.php'; 

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Add product to cart
if ((isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id']))) {
  $id = intval($_GET['id']);
  $product = fetch_assoc("SELECT * FROM products WHERE id=$id AND is_deleted='no'");
  if ($product) {
    if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id]['qty'] += 1;
    } else {
      $_SESSION['cart'][$id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'qty' => 1,
        'img' => "assets/images/" . $product['image']
      ];
    }
  }
  header("Location: cart.php");
  exit;
}

// Remove product
if (isset($_GET['remove'])) {
  $id = intval($_GET['remove']);
  unset($_SESSION['cart'][$id]);
  header("Location: cart.php");
  exit;
}

// Calculate total
$totalAmount = array_sum(array_map(function ($i) {
  return $i['price'] * $i['qty'];
}, $_SESSION['cart']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .cart-img { width: 80px; height: auto; }
    .qty-btn { cursor: pointer; }
    .cart-item { transition: transform 0.3s ease; }
    .cart-item:hover { transform: translateY(-5px); }
  </style>
</head>
<body>
  <div class="container py-5">
    <h2 class="mb-4 text-center">Your Shopping Cart</h2>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-dark">
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($_SESSION['cart'])): ?>
              <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <tr class="cart-item">
                  <td>
                    <img src="<?= htmlspecialchars($item['img']) ?>" 
                         alt="<?= htmlspecialchars($item['name']) ?>" 
                         class="cart-img me-2">
                    <?= htmlspecialchars($item['name']) ?>
                  </td>
                  <td>
                    Rs <span class="price" data-price="<?= intval($item['price']) ?>">
                      <?= intval($item['price']) ?>
                    </span>
                  </td>
                  <td>
                    <div class="input-group" style="width:120px;">
                      <button type="button" class="btn btn-outline-secondary qty-btn" onclick="changeQty(<?= $id ?>,-1)">-</button>
                      <input type="number" id="qty-<?= $id ?>" value="<?= $item['qty'] ?>" min="0" class="form-control text-center" onchange="updateSubtotal(<?= $id ?>)">
                      <button type="button" class="btn btn-outline-secondary qty-btn" onclick="changeQty(<?= $id ?>,1)">+</button>
                    </div>
                  </td>
                  <td>
                    Rs <span class="subtotal" id="subtotal-<?= $id ?>">
                      <?= intval($item['price'] * $item['qty']) ?>
                    </span>
                  </td>
                  <td>
                    <a href="cart.php?remove=<?= $id ?>" class="btn btn-danger btn-sm">Remove</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">Your cart is empty</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4">
        <h4>Total: Rs <span id="totalAmount"><?= intval($totalAmount) ?></span></h4>
        <div>
          <a href="shop.php" class="btn btn-secondary">← Back to Shop</a>
          <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
      </div>
  </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function changeQty(id, delta) {
  let $qtyInput = $('#qty-' + id);
  let current = parseInt($qtyInput.val());
  let newQty = current + delta;
  if (newQty < 0) newQty = 0;
  $qtyInput.val(newQty);
  updateSubtotal(id);
}

function updateSubtotal(id) {
  let $row = $('#qty-' + id).closest('tr');
  let price = parseInt($row.find('.price').data('price'));
  let qty = parseInt($('#qty-' + id).val());
  if (isNaN(qty) || qty < 0) qty = 0;

  let subtotal = price * qty;
  $row.find('.subtotal').text(subtotal);
  updateTotal();

  // backend update via AJAX
  $.post('update_cart.php', {id: id, qty: qty});
}

function updateTotal() {
  let total = 0;
  $('.subtotal').each(function () {
    total += parseInt($(this).text());
  });
  $('#totalAmount').text(total);
}
</script>
</body>
</html>
```
