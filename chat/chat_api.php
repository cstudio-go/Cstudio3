<?php
session_start();
include 'db_config.php';
header("Content-Type: application/json");

$isAdmin = isset($_SESSION['admin']);
$adminNames = ["瑋語老師","瑋語","張瑋語","張老師","玮语老师","玮语","张玮语"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $conn->real_escape_string($_POST['name']);
    $msg   = $conn->real_escape_string($_POST['msg']);
    $color = $conn->real_escape_string($_POST['color']);

    // Only allow admin to post as admin names
    if (in_array($name, $adminNames) && !$isAdmin) {
        echo json_encode(['status' => 'error', 'msg' => 'Only admin can use this name']);
        exit;
    }

    $conn->query("INSERT INTO messages (name, msg, color, created_at) VALUES ('$name', '$msg', '$color', NOW())");
    echo json_encode(["status"=>"ok"]);
    exit;
}

// Fetch messages
$result = $conn->query("SELECT * FROM messages ORDER BY created_at ASC");
$messages = [];
while($row = $result->fetch_assoc()){
    $messages[] = $row;
}
echo json_encode($messages);
?>
