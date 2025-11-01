<?php
session_start();

// Update admin_status if admin is logged in
if (isset($_SESSION['admin'])) {
    $adminName = $_SESSION['admin'];

    $host = "localhost";
    $db = "cstusybk_chatdb";
    $user = "cstusybk_cstudio";
    $pass = "Aaron176!!!!@@@@";

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Prepare and execute update
    $stmt = $conn->prepare("UPDATE admin_status SET online=0, last_seen=NOW() WHERE admin_username=?");
    $stmt->bind_param("s", $adminName);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Remove all session data
session_unset();
session_destroy();

// Redirect to visitor chat page
header('Location: index.php');
exit;
?>
