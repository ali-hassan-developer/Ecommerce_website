<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - My Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5, #d9e2ec);
            min-height: 100vh;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .form-label {
            font-weight: 500;
        }

        button[type="submit"] {
            background: #667eea;
            border: none;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            background: #764ba2;
            transform: scale(1.03);
        }

        /* Responsive tweaks */
        @media (max-width: 576px) {
            .card {
                margin: 0 15px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include 'includes/header.php'; ?>

    <!-- Checkout Form -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient text-dark text-center">
                        <h4 class="mb-0">Checkout</h4>
                        <small class="text-dark">Please provide your details to complete the order</small>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="place_order.php">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="03XXXXXXXXX" required pattern="^03[0-9]{9}$" title="Enter a valid 11-digit phone number starting with 03">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="123 Street, City, Country" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Payment Method</label>
                                <select name="payment" class="form-select">
                                    <option value="COD">Cash on Delivery</option>
                                    <option value="Card">Card (Demo)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-lg text-white w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
