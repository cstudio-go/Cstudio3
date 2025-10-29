<?php
session_start();
include 'db_config.php'; // your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if user exists, or create
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO users (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $userId = $stmt->insert_id;
    } else {
        $stmt->bind_result($userId);
        $stmt->fetch();
    }

    // Generate a random login token
    $token = bin2hex(random_bytes(16));
    $expiry = date("Y-m-d H:i:s", strtotime("+15 minutes")); // valid 15 min

    // Save token to DB
    $stmt = $conn->prepare("UPDATE users SET token = ?, token_expiry = ? WHERE id = ?");
    $stmt->bind_param("ssi", $token, $expiry, $userId);
    $stmt->execute();

    // Send email
    $loginLink = "https://yourdomain.com/login.php?token=$token&email=" . urlencode($email);
    mail($email, "Your Login Link", "Click here to log in: $loginLink");

    echo "Check your email for the login link!";
}
?>
