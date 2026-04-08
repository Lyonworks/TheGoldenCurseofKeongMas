<?php
include "../config/database.php";
include "../helpers/log.php";

$id = $_POST['id'];
$old_image = $_POST['image'];

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
        $new_image = str_replace('../assets/img/', '', $upload_path);
        
        // Update database
        $query = "UPDATE about_images SET image='$new_image' WHERE id_image='$id'";
        mysqli_query($conn, $query);
        
        logActivity('Admin', 'edit', "Updated about image ID $id");
        
        header("Location: ../admin/about.php?success=image_updated");
        exit();
    } else {
        header("Location: ../admin/about.php?error=upload_failed");
        exit();
    }
} else {
    // No file uploaded, redirect back
    header("Location: ../admin/about.php?error=no_file_selected");
    exit();
}
?>