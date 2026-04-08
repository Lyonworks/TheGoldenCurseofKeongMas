<?php
session_start();
include '../config/database.php';
include '../helpers/log.php';

if (!isset($_SESSION['user_token'], $_POST['name'], $_POST['message'])) {
    header("Location: ../index.php#comment");
    exit;
}

$user_token = $_SESSION['user_token'];
$id_parent  = !empty($_POST['id_parent']) ? (int) $_POST['id_parent'] : NULL;
$name       = mysqli_real_escape_string($conn, $_POST['name']);
$message    = mysqli_real_escape_string($conn, $_POST['message']);

$query = "INSERT INTO comments (name, message, id_parent, user_token, created_at)
          VALUES (?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssis", $name, $message, $id_parent, $user_token);
mysqli_stmt_execute($stmt);

logActivity(
    $name,
    'add',
    $id_parent
        ? "Reply added to comment ID $id_parent"
        : "New comment added"
);

header("Location: ../index.php#comment");
exit;
