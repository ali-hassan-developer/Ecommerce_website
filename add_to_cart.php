<?php
session_start();
include 'includes/db.php';

// Check if product ID is passed
if(isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM products WHERE id=$product_id");

    if($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Add to session cart
        if(isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['qty'] += 1; // Increment quantity
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price'=> $product['price'],
                'qty'  => 1,
                'img'  => $product['image']
            ];
        }
    }
}

// Redirect back to shop
header("Location: shop.php");
exit();
?>
