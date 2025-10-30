<?php
header('Content-Type: application/json');
session_start();

// Database connection
$host = 'localhost';
$user = 'cstusybk_cstudio';
$pass = 'Aaron176!!!!@@@@';
$dbname = 'cstusybk_chatdb';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error'=>'Database connection failed']));
}

// Get page ID
$pageId = $_POST['page_id'] ?? null;
if (!$pageId) {
    echo json_encode(['error'=>'No page_id provided']);
    exit;
}

// Increment like count (no cookie check)
$stmt = $conn->prepare("INSERT INTO likes (page_id, like_count) VALUES (?,1)
                        ON DUPLICATE KEY UPDATE like_count=like_count+1");
$stmt->bind_param('s', $pageId);
$stmt->execute();

// Get updated count
$stmt = $conn->prepare("SELECT like_count FROM likes WHERE page_id=?");
$stmt->bind_param('s', $pageId);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

// Return updated likes
echo json_encode(['likes' => $result['like_count']]);

$conn->close();