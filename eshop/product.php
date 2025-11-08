<?php
include 'includes/header.php';
include 'includes/db_connect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>

<form method="POST" action="cart.php">
  <input type="hidden" name="product_id" value="<?php echo $id; ?>">
  <input type="number" name="quantity" value="1" min="1">
  <button type="submit" name="add_to_cart">Add to Cart</button>
</form>