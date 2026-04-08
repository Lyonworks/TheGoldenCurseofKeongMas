<?php
include "../config/database.php";
include "../helpers/log.php";

$name        = mysqli_real_escape_string($conn, $_POST['name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price       = (int) $_POST['price'];
$stock       = (int) ($_POST['stock'] ?? 0);
$limited     = isset($_POST['limited']) ? 1 : 0;
$image       = NULL;

if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === 0) {
    $upload_dir = '../assets/img/merchandise/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_name   = time() . '_' . basename($_FILES['image_file']['name']);
    $upload_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_path)) {
        $image = 'merchandise/' . $file_name;
        $image = mysqli_real_escape_string($conn, $image);
    }
}

$query = "
INSERT INTO merchandise (name, description, price, stock, limited, image)
VALUES (
    '$name',
    '$description',
    $price,
    $stock,
    $limited,
    " . ($image ? "'$image'" : "NULL") . "
)";

if (!mysqli_query($conn, $query)) {
    die("DB ERROR: " . mysqli_error($conn));
}

logActivity('Admin', 'add', "Added merchandise: $name");

header("Location: ../admin/merchandise.php?success=added");
exit;
