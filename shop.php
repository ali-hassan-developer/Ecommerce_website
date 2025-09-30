```php
<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<div class="container py-5">
  <div class="text-center mb-5" data-aos="fade-down">
    <h1 class="fw-bold">Our Products</h1>
    <p class="text-muted">Browse our latest collection and enjoy shopping!</p>
  </div>

  <div class="row g-4">
    <?php
    $products = selectAll('products',"is_deleted='no'");
    if (count($products) > 0):
      foreach ($products as $row): 
    ?>
        <div class="col-md-3 col-sm-6" data-aos="zoom-in">
          <div class="card product-card h-100 border-0 shadow-sm">
            <!-- Product Image -->
            <img src="assets/images/<?= $row['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']); ?>" style="height:200px; object-fit:cover;">

            <div class="card-body text-center">
              <!-- Product Name -->
              <h5 class="card-title" style="color:#000; font-weight:600;">
                <?= htmlspecialchars($row['name']); ?>
              </h5>
              <!-- Product Price -->
              <p class="card-text" style="color:#444; font-size:16px;">
                $<?= number_format($row['price'], 2); ?>
              </p>
              <!-- Add to Cart -->
              <a href="cart.php?action=add&id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
                Add to Cart
              </a>
            </div>
          </div>
        </div>
    <?php 
      endforeach;
    else:
      echo "<p class='text-center'>No products available.</p>";
    endif;
    ?>
  </div>
</div>

<footer class="mt-5">
  <div class="container text-center">
    <p>&copy; <?= date('Y'); ?> My Shop. All rights reserved.</p>
  </div>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>
```
