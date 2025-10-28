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
        header('Location: chat.php');
        exit;
    } else {
        echo "<script>alert('登入失敗！帳號或密碼錯誤');history.back();</script>";
    }
}
?>