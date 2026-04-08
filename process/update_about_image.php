<?php
include "../config/database.php";
include "../helpers/log.php";

// Check if file was uploaded
if (!isset($_POST['id'])) {
    header("Location: ../admin/about.php?error=id_not_provided");
    exit();
}

$id = $_POST['id'];

// Check if new image was uploaded
if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
    $upload_dir = '../assets/img/about/';

    // Create directory if not exists
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            header("Location: ../admin/about.php?error=mkdir_failed");
            exit();
        }
    }

    // Get old image path to delete
    $old_query = "SELECT image FROM about_images WHERE id_image='$id'";
    $old_result = mysqli_query($conn, $old_query);
    $old_image = mysqli_fetch_assoc($old_result);

    if ($old_image) {
        $old_path = '../assets/img/' . $old_image['image'];
        if (file_exists($old_path)) {
            unlink($old_path);
        }
    }

    // Upload new image
    $file_name = basename($_FILES['image_file']['name']);
    $upload_path = $upload_dir . time() . '_' . $file_name;

    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_path)) {
        $image_path = str_replace(['\\', '../assets/img/'], ['/', ''], $upload_path);
        $image_path = mysqli_real_escape_string($conn, $image_path);

        $query = "UPDATE about_images SET image='$image_path' WHERE id_image='$id'";

        if (mysqli_query($conn, $query)) {
            logActivity('Admin', 'edit', "Updated about image ID $id");
            header("Location: ../admin/about.php?success=image_updated");
        } else {
            $error = "db_error_" . mysqli_error($conn);
            header("Location: ../admin/about.php?error=" . urlencode($error));
        }
    } else {
        header("Location: ../admin/about.php?error=move_uploaded_file_failed");
    }
} else {
    header("Location: ../admin/about.php?error=no_file_selected");
}
exit();
?>
