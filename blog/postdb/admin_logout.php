<?php
session_start();
unset($_SESSION['is_admin']);
session_destroy();

$redirect = $_GET['redirect'] ?? '/blog/bloglist.html'; // default fallback
header("Location: $redirect");
exit;
?>