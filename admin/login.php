<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="../assets/bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

  <form action="../process/admin_login.php"
        method="POST"
        class="bg-secondary p-4 rounded text-white"
        style="width:320px">

    <h4 class="text-center mb-3">Admin Login</h4>

    <input type="text"
           name="username"
           class="form-control mb-2"
           placeholder="Username"
           required>

    <input type="password"
           name="password"
           class="form-control mb-3"
           placeholder="Password"
           required>

    <button class="btn btn-warning w-100">
      Login
    </button>

  </form>
</body>
</html>
