<?php
session_start();
include 'db_config.php';

if (isset($_GET['token'], $_GET['email'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT id, token_expiry FROM users WHERE email = ? AND token = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userId, $tokenExpiry);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (strtotime($tokenExpiry) >= time()) {
            // Token valid: log in
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $email;

            // Optional: clear token
            $stmt = $conn->prepare("UPDATE users SET token = NULL, token_expiry = NULL WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();

            echo "Logged in successfully!";
            exit;
        } else {
            echo "Token expired.";
        }
    } else {
        echo "Invalid token.";
    }
}
?>
