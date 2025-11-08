<?php include('includes/db_connect.php'); ?>
<!DOCTYPE html>
<html>
<head><title>Products</title>
<link 
    href="bootstrap.min.css" 
    rel="stylesheet">
</head>
<body>
<h1>Products</h1>

<?php
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
  echo "<div>";
  echo "<img src='images/" . $row['image'] . "' width='150'>";
  echo "<h2>" . $row['name'] . "</h2>";
  echo "<p>$" . $row['price'] . "</p>";
  echo "<a href='product.php?id=" . $row['id'] . "'>View</a>";
  echo "</div>";
}
?>
</body>
</html>