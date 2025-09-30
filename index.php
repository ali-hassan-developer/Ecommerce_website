<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Shop - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .hero {
      height: 100vh;
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                  url('assets/images/hero-bg.jpg') center/cover no-repeat;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
      animation: fadeInDown 1s ease;
    }
    .hero p {
      font-size: 1.2rem;
      animation: fadeInUp 1.2s ease;
    }
    .btn-custom {
      background: #ff6f61;
      border: none;
      padding: 12px 28px;
      font-weight: 500;
      color: white;
      border-radius: 50px;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: #e65c50;
      transform: translateY(-3px);
    }
    @keyframes fadeInDown {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    @keyframes fadeInUp {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    .category-card, .product-card {
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .category-card:hover, .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    footer {
      background: #222;
      color: #aaa;
      padding: 30px 0;
    }
    footer a {
      color: #ff6f61;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <div>
    <h1>Welcome to My Shop</h1>
    <p>Your one-stop destination for amazing products</p>
    <a href="shop.php" class="btn btn-custom mt-3">Shop Now</a>
  </div>
</section>

<!-- Categories -->
<section class="container py-5">
  <h2 class="text-center mb-4" data-aos="fade-up">Browse Categories</h2>
  <div class="row g-4">
    <div class="col-md-4" data-aos="zoom-in">
      <div class="card category-card p-3 text-center">
        <img src="assets/images/laptop.jpg" class="mx-auto" style="height:80px;" alt="">
        <h5 class="mt-3">Electronics</h5>
      </div>
    </div>
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
      <div class="card category-card p-3 text-center">
        <img src="assets/images/blog-2.jpg" class="mx-auto" style="height:80px;" alt="">
        <h5 class="mt-3">Fashion</h5>
      </div>
    </div>
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="400">
      <div class="card category-card p-3 text-center">
        <img src="assets/images/blog-3.jpg" class="mx-auto" style="height:80px;" alt="">
        <h5 class="mt-3">Home Decor</h5>
      </div>
    </div>
  </div>
</section>

<!-- Featured Products -->
<section class="container py-5">
  <h2 class="text-center mb-4" data-aos="fade-up">Featured Products</h2>
  <div class="row g-4">
    <div class="col-md-3" data-aos="fade-up">
      <div class="card product-card">
        <img src="assets/images/blog-6.jpg" class="card-img-top" alt="">
        <div class="card-body text-center">
          <h6 class="card-title">Product 1</h6>
          <p>$29.99</p>
          <a href="cart.php" class="btn btn-sm btn-custom">Add to Cart</a>
        </div>
      </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
      <div class="card product-card">
        <img src="assets/images/blog-5.jpg" class="card-img-top" alt="">
        <div class="card-body text-center">
          <h6 class="card-title">Product 2</h6>
          <p>$39.99</p>
          <a href="cart.php" class="btn btn-sm btn-custom">Add to Cart</a>
        </div>
      </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
      <div class="card product-card">
        <img src="assets/images/blog-4.jpg" class="card-img-top" alt="">
        <div class="card-body text-center">
          <h6 class="card-title">Product 3</h6>
          <p>$49.99</p>
          <a href="cart.php" class="btn btn-sm btn-custom">Add to Cart</a>
        </div>
      </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
      <div class="card product-card">
        <img src="assets/images/about-img.jpg" class="card-img-top" alt="">
        <div class="card-body text-center">
          <h6 class="card-title">Product 4</h6>
          <p>$19.99</p>
          <a href="cart.php" class="btn btn-sm btn-custom">Add to Cart</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Banner -->
<section class="text-center text-white py-5" style="background:#ff6f61;" data-aos="fade-up">
  <h2>Join Our Community of Happy Shoppers</h2>
  <a href="register.php" class="btn btn-light mt-3">Create Account</a>
</section>

<!-- Footer -->
<footer>
  <div class="container text-center">
    <p>&copy; <?= date('Y'); ?> My Shop. All rights reserved.</p>
    <p>Follow us:
      <a href="#">Facebook</a> | <a href="#">Instagram</a> | <a href="#">Twitter</a>
    </p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</body>
</html>
