<?php
session_start();
include 'includes/db.php';

// Agar cart empty hai to redirect kar do
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment = mysqli_real_escape_string($conn, $_POST['payment']);

    // ✅ Calculate total amount
    $total = 0;
    foreach ($_SESSION['cart'] as $id => $item) {
        $row = fetch_assoc("SELECT * FROM products WHERE id=$id");
        $total += $row['price'] * $item['qty'];
    }

    // ✅ Save order in orders table (using insert function)
    $orderData = [
        'customer_name'  => $name,
        'email'          => $email,
        'address'        => $address,
        'phone'          => $phone,
        'payment_method' => $payment,
        'total'          => $total
    ];
    $order = insert('orders', $orderData); // ye order ka pura row return karega
    $order_id = $order['id']; // last inserted order id

    // ✅ Save each product in order_items
    foreach ($_SESSION['cart'] as $id => $item) {
        $qty   = $item['qty'];
        $price = $item['price'];

        $orderItemData = [
            'order_id'   => $order_id,
            'product_id' => $id,
            'quantity'   => $qty,
            'price'      => $price
        ];
        insert('order_items', $orderItemData);
    }

    // ✅ Empty cart after order placed
    unset($_SESSION['cart']);

    // ✅ Success page
    echo "<div style='text-align:center; font-family:Arial; margin-top:50px;'>
            <h2>✅ Thank you, $name! Your order has been placed successfully.</h2>
            <p>We will deliver your items to: <strong>$total</strong></p>
            <a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#198754; color:#fff; text-decoration:none; border-radius:5px;'>Continue Shopping</a>
          </div>";
} else {
    header("Location: checkout.php");
    exit();
}
?>
