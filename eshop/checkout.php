<?php
session_start();
include 'includes/header.php';
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $address = $_POST['address'];

  // Save order
  $conn->query("INSERT INTO orders (customer_name, address) VALUES ('$name', '$address')");
  $order_id = $conn->insert_id;

  // Save items
  foreach ($_SESSION['cart'] as $id => $qty) {
    $conn->query("INSERT INTO order_items (order_id, product_id, quantity)
                  VALUES ($order_id, $id, $qty)");
  }

  echo "<p>Thank you for your order!</p>";
  $_SESSION['cart'] = []; // clear cart
}

include 'includes/footer.php';
?>