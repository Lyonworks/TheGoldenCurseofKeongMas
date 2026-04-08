<?php
include "../config/database.php";
include "../helpers/log.php";

$title   = mysqli_real_escape_string($conn, $_POST['title']);
$content = mysqli_real_escape_string($conn, $_POST['content']);
$author  = mysqli_real_escape_string($conn, $_POST['author']);

if (empty($_FILES['image_file']['name']) || $_FILES['image_file']['error'] !== 0) {
    header("Location: ../admin/news.php?error=Image is required");
    exit;
}

$upload_dir = '../assets/img/news/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$file_name   = time() . '_' . basename($_FILES['image_file']['name']);
$upload_path = $upload_dir . $file_name;

if (!move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_path)) {
    header("Location: ../admin/news.php?error=Upload failed");
    exit;
}

$image = mysqli_real_escape_string($conn, $file_name);

$query = "
INSERT INTO news (title, content, author, image, created_at)
VALUES ('$title', '$content', '$author', '$image', NOW())
";

if (!mysqli_query($conn, $query)) {
    die("DB ERROR: " . mysqli_error($conn));
}

logActivity($author, 'add', "Added news: $title");

header("Location: ../admin/news.php?success=added");
exit;
