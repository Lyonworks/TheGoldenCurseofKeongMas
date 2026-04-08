<?php
include "../config/database.php";
include "../helpers/log.php";

$id_merchandise = (int) $_POST['id_merchandise'];
$name           = mysqli_real_escape_string($conn, $_POST['name']);
$description    = mysqli_real_escape_string($conn, $_POST['description']);
$price          = (int) $_POST['price'];
$stock          = (int) ($_POST['stock'] ?? 0);
$limited        = isset($_POST['limited']) ? 1 : 0;

$get = mysqli_query(
    $conn,
    "SELECT image FROM merchandise WHERE id_merchandise=$id_merchandise"
);
$old = mysqli_fetch_assoc($get);
$image = $old['image'];

if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === 0) {
    $upload_dir = '../assets/img/merchandise/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (!empty($image)) {
        $old_path = '../assets/img/' . $image;
        if (file_exists($old_path)) {
            unlink($old_path);
        }
    }

    $file_name   = time() . '_' . basename($_FILES['image_file']['name']);
    $upload_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_path)) {
        $image = 'merchandise/' . $file_name;
        $image = mysqli_real_escape_string($conn, $image);
    }
}

$query = "
UPDATE merchandise SET
    name='$name',
    description='$description',
    price=$price,
    stock=$stock,
    limited=$limited" .
    ($image ? ", image='$image'" : "") . "
WHERE id_merchandise=$id_merchandise
";


if (mysqli_query($conn, $query)) {
    logActivity('Admin', 'edit', "Updated merchandise: $name");
    header("Location: ../admin/merchandise.php?success=updated");
} else {
    die(mysqli_error($conn));
}
exit;
