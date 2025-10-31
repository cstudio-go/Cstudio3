<?php
header('Content-Type: application/json');
include 'db_config.php';

$post_id = $_POST['post_id'] ?? null;

if (!$post_id) {
    echo json_encode(['error' => 'No post_id provided']);
    exit;
}

// Increment like count
$stmt = $conn->prepare("INSERT INTO likes (post_id, like_count) VALUES (?, 1)
                        ON DUPLICATE KEY UPDATE like_count = like_count + 1");
$stmt->bind_param("s", $post_id);
$stmt->execute();

// Get updated count
$stmt = $conn->prepare("SELECT like_count FROM likes WHERE post_id = ?");
$stmt->bind_param("s", $post_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode(['likes' => $result['like_count']]);
$conn->close();
?>