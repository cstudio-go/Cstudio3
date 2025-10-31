<?php
session_start();
unset($_SESSION['is_admin']);
session_destroy();

$redirect = $_GET['redirect'] ?? '/blog/bloglist.html';

// ensure redirect starts from root (fixes relative path problem)
if (strpos($redirect, '/') !== 0) {
  $redirect = '/' . $redirect;
}

header("Location: $redirect");
exit;
?>
