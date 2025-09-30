```php
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - E-Commerce Website</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .contact-header {
      background: url('assets/images/contact-banner.jpg') center/cover no-repeat;
      color: white;
      padding: 80px 0;
      text-align: center;
    }
  </style>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <!-- Banner Section -->
  <section class="contact-header text-dark">
    <div class="container">
      <h1>Contact Us</h1>
      <p>We would love to hear from you</p>
    </div>
  </section>

  <!-- Contact Form -->
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <h2>Get in Touch</h2>
        <p>If you have any questions, feel free to send us a message. Our support team will get back to you soon!</p>
        <form action="send_message.php" method="POST">
          <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
      </div>

      <!-- Contact Info -->
      <div class="col-md-6">
        <h2>Our Contact Info</h2>
        <ul class="list-unstyled">
          <li><strong>Address:</strong> 123 Main Street, Karachi, Pakistan</li>
          <li><strong>Email:</strong> support@ecommerce.com</li>
          <li><strong>Phone:</strong> +92 300 1234567</li>
        </ul>

        <!-- Google Map -->
        <div class="mt-4">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28934.13213287352!2d67.0011!3d24.8607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjTCsDUxJzM4LjUiTiA2N8KwMDAnMTkuOSJF!5e0!3m2!1sen!2s!4v1616592856740!5m2!1sen!2s" 
            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```
