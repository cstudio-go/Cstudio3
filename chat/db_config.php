<?php
$servername = "localhost";
$username = "cstusybk_cstudio";
$password = "Aaron176!!!!@@@@";
$dbname = "cstusybk_chatdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>