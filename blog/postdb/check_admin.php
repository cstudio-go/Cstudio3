<?php
session_start();
header('Content-Type: application/json');
$is_admin = $_SESSION['is_admin'] ?? 0;
echo json_encode(['is_admin' => $is_admin]);
?>