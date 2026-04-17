<?php
session_start();
include '../config/database.php';
include '../helpers/log.php';

if (!isset($_SESSION['admin']) || empty($_SESSION['admin']['id_admin'])) {
    header('Location: ../admin/login.php');
    exit;
}

if (!isset($_POST['id'])) {
    header('Location: ../admin/comment.php?error=missing_id');
    exit;
}

$id = (int) $_POST['id'];

$get = mysqli_query($conn, "SELECT name FROM comments WHERE id_comments=$id");
$data = mysqli_fetch_assoc($get);

mysqli_query($conn, "DELETE FROM comments WHERE id_comments=$id");
mysqli_query($conn, "DELETE FROM comments WHERE id_parent=$id");

logActivity('Admin', 'delete', "Deleted comment ID $id");

header('Location: ../admin/comment.php?success=deleted');
exit;
