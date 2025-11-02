<?php
session_start();

// hard-coded credentials
$admin_user = "cstudio";
$admin_pass = "Aaron176!";

// Get the redirect path from query string
$redirect = $_GET['redirect'] ?? '/blog/a28.html'; // fallback if not provided

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['is_admin'] = 1;
        // make sure the redirect path is safe
        header("Location: $redirect");
        exit;
    } else {
        $error = "帳號或密碼錯誤";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<style>
body, html {
    height: 100%;
    font-size: 1rem; /* base font size */
  }
  h3 {
    font-size: 1.5rem; /* prevent shrinking too much on mobile */
  }
  @media (max-width: 576px) {
    h3{
      margin: 0 auto;
    }

</style>
</head>
<body class="d-flex justify-content-center align-items-center">
<div class="text-center w-100" style="max-width: 350px;">
<h3 style="margin-bottom: 10px;">管理員登入</h3>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" class="form-control" name="username" placeholder="Username" required><br>
    <input type="password" class="form-control" name="password" placeholder="Password" required><br>
    <button class="btn btn-primary btn-sm" style="padding: 5px 50px;" type="submit">Login</button>
</form>
</div>
</body>
</html>
