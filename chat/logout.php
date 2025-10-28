<?php
session_start();

// Remove all session data
session_unset();
session_destroy();

// Redirect to visitor chat page (or login page)
header('Location: index.php');
exit;
?>