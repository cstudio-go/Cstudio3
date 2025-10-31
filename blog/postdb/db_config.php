<?php
$servername = "localhost";
$username = "cstusybk_cstudio";
$password = "Aaron176!!!!@@@@";
$dbname = "cstusybk_postdb";

$conn = new mysqli($servername, $username, $password, $dbname);

$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
