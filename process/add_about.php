<?php
include "../config/database.php";
include "../helpers/log.php";

$description = $_POST['description'];
$image = $_POST['image'];

if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
    $upload_dir = '../assets/img/about/';
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_name = basename($_FILES['image_file']['name']);
    $upload_path = $upload_dir . time() . '_' . $file_name;
    
    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_path)) {
        $image = str_replace('../assets/img/about/', '', $upload_path);
    }
}

$query = "INSERT INTO about (description, image) VALUES ('$description', '$image')";
mysqli_query($conn, $query);

logActivity('Admin', 'add', 'Added about section');

header("Location: ../admin/about.php?success=added");
exit();

