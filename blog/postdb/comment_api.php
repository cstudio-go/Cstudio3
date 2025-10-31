
<?php
session_start();
$is_admin = $_SESSION['is_admin'] ?? 0;

header('Content-Type: application/json');
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add a comment
    $post_id = $_POST['post_id'] ?? '';
    $name = $_POST['name'] ?? 'Anonymous';
    $comment = $_POST['comment'] ?? '';


    if ($post_id && $comment) {
        $is_admin = $_SESSION['is_admin'] ?? 0;
        $stmt = $conn->prepare("INSERT INTO comments (post_id, name, comment, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $post_id, $name, $comment, $is_admin);
        $stmt->execute();
    }
    echo json_encode(['status' => 'ok']);
} else {
    // Get all comments for a post
    $post_id = $_GET['post_id'] ?? '';
    $stmt = $conn->prepare("SELECT name, comment, created_at, is_admin FROM comments WHERE post_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    echo json_encode($comments);
}

$conn->close();
?>
