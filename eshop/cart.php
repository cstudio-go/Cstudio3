<?php
session_start();
include('includes/db_connect.php');

if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];

  $_SESSION['cart'][$product_id] = $quantity;
  header('Location: cart.php');
}
?>