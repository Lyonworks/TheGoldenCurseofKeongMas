<?php
session_start();
include '../config/database.php';
include '../helpers/log.php';

if (!isset($_SESSION['user_token'], $_POST['id_comments'], $_POST['message'])) {
    header("Location: ../index.php#comment");
    exit;
}

$id         = (int) $_POST['id_comments'];
$message    = mysqli_real_escape_string($conn, $_POST['message']);
$user_token = $_SESSION['user_token'];


$get = mysqli_query(
    $conn,
    "SELECT name FROM comments 
     WHERE id_comments=$id AND user_token='$user_token'"
);

$data = mysqli_fetch_assoc($get);

if (!$data) {
    header("Location: ../index.php#comment");
    exit;
}


mysqli_query(
    $conn,
    "UPDATE comments 
     SET message='$message'
     WHERE id_comments=$id AND user_token='$user_token'"
);


logActivity(
    $data['name'],
    'edit',
    "Edited comment: \"$message_short\""
);

header("Location: ../index.php#comment");
exit;
