<?php
session_start();
include '../config/database.php';
include '../helpers/log.php';

if (!isset($_GET['id'], $_SESSION['user_token'])) {
    header("Location: ../index.php#comment");
    exit;
}

$id = (int) $_GET['id'];
$user_token = $_SESSION['user_token'];

$get = mysqli_query($conn, "SELECT name FROM comments WHERE id_comments=$id");
$data = mysqli_fetch_assoc($get);


mysqli_query(
    $conn,
    "DELETE FROM comments 
     WHERE id_comments=$id AND user_token='$user_token'"
);


mysqli_query(
    $conn,
    "DELETE FROM comments 
     WHERE id_parent=$id AND user_token='$user_token'"
);


logActivity(
    $data['name'] ?? 'Unknown',
    'delete',
    "Deleted comment ID $id"
);

header("Location: ../index.php#comment");
exit;
