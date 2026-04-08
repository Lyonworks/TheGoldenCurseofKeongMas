<?php
session_start();
require '../config/database.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: ../admin/login.php?error=1");
    exit;
}

// Gunakan prepared statement
$stmt = mysqli_prepare($conn, 'SELECT id_admin, username, password FROM admins WHERE username = ?');
if (!$stmt) {
    header("Location: ../admin/login.php?error=1");
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    $admin = mysqli_fetch_assoc($result);
    
    if (password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = [
            'id_admin' => (int) $admin['id_admin'],
            'username' => $admin['username']
        ];
        
        mysqli_stmt_close($stmt);
        header("Location: ../admin/dashboard.php");
        exit;
    }
}

mysqli_stmt_close($stmt);
header("Location: ../admin/login.php?error=1");
exit;
