
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - E-Commerce Website</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .about-header {
      background: url('assets/images/about-banner.jpg') center/cover no-repeat;
      color: white;
      padding: 80px 0;
      text-align: center;
    }
    .team-member img {
      border-radius: 50%;
      width: 120px;
      height: 120px;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <!-- Banner Section -->
  <section class="about-header text-dark">
    <div class="container">
      <h1>About Us</h1>
      <p>Your trusted online shopping destination</p>
    </div>
  </section>

  <!-- About Content -->
  <div class="container my-5">
    <div class="row align-items-center">
      <div class="col-md-6">
        <img src="screenshots/2025-09-30 18_30_34-My Shop.png" alt="Our Store" class="img-fluid rounded">
      </div>
      <div class="col-md-6">
        <h2>Who We Are</h2>
        <p>
          Welcome to our E-Commerce Website! We aim to provide the best products at affordable prices.
          Our mission is to make shopping simple, fast, and reliable for everyone. 
          With a wide variety of items, secure payments, and quick delivery, we are your one-stop shop.
        </p>
        <p>
          Customer satisfaction is our top priority. We work with trusted suppliers and ensure
          that every product goes through quality checks before reaching you.
        </p>
      </div>
    </div>
  </div>

  <!-- Mission and Vision -->
  <div class="container my-5">
    <div class="row text-center">
      <div class="col-md-6">
        <h3>Our Mission</h3>
        <p>Deliver high-quality products with excellent service and unbeatable value.</p>
      </div>
      <div class="col-md-6">
        <h3>Our Vision</h3>
        <p>To become the leading online store where customers can shop with trust and ease.</p>
      </div>
    </div>
  </div>

  <!-- Team Section -->
  <!-- <div class="container my-5">
    <h2 class="text-center mb-4">Meet Our Team</h2>
    <div class="row text-center">
      <div class="col-md-4 team-member">
        <img src="assets/images/team1.jpg" alt="Team Member 1">
        <h5 class="mt-3"></h5>
        <p>Founder & CEO</p>
      </div>
      <div class="col-md-4 team-member">
        <img src="assets/images/team2.jpg" alt="Team Member 2">
        <h5 class="mt-3"></h5>
        <p>Operations Manager</p>
      </div>
      <div class="col-md-4 team-member">
        <img src="assets/images/team3.jpg" alt="Team Member 3">
        <h5 class="mt-3"></h5>
        <p>Marketing Head</p>
      </div>
    </div>
  </div> -->

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```
