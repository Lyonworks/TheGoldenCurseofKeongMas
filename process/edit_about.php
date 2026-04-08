<?php
include "../config/database.php";
include "../helpers/log.php";

$id = $_POST['id'];
$description = $_POST['description'];
$image = $_POST['image'];

// Handle file upload
if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
    $upload_dir = '../assets/img/about/';
    
    // Create directory if not exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_name = basename($_FILES['image_file']['name']);
    $upload_path = $upload_dir . time() . '_' . $file_name;
    
    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_path)) {
        $image = str_replace('../assets/img/about/', '', $upload_path);
    }
}

$query = "UPDATE about SET description='$description', image='$image' WHERE id_about='$id'";
mysqli_query($conn, $query);

logActivity('Admin', 'edit', "Updated about section ID $id");

header("Location: ../admin/about.php?success=updated");
exit();
?>
