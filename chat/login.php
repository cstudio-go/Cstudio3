<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && hash('sha256', $password) === $admin['password']) {
        $_SESSION['admin'] = $admin['username'];

        // --- Update admin_status in DB ---
        $adminName = $admin['username'];
        $stmt2 = $conn->prepare("SELECT id FROM admin_status WHERE admin_username=?");
        $stmt2->bind_param("s", $adminName);
        $stmt2->execute();
        $stmt2->store_result();

        if ($stmt2->num_rows > 0) {
            $update = $conn->prepare("UPDATE admin_status SET online=1, last_seen=NOW() WHERE admin_username=?");
            $update->bind_param("s", $adminName);
            $update->execute();
            $update->close();
        } else {
            $insert = $conn->prepare("INSERT INTO admin_status (admin_username, online, last_seen) VALUES (?, 1, NOW())");
            $insert->bind_param("s", $adminName);
            $insert->execute();
            $insert->close();
        }

        $stmt2->close();

        header('Location: chat.php');
        exit;
    } else {
        echo "<script>alert('登入失敗！帳號或密碼錯誤');history.back();</script>";
    }
}
?>
