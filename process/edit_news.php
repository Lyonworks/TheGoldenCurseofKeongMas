<?php
include "../config/database.php";
include "../helpers/log.php";

$id_news = (int) $_POST['id_news'];
$title   = mysqli_real_escape_string($conn, $_POST['title']);
$content = mysqli_real_escape_string($conn, $_POST['content']);
$author  = mysqli_real_escape_string($conn, $_POST['author']);
$image   = mysqli_real_escape_string($conn, $_POST['old_image']);

if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === 0) {

    $upload_dir = '../assets/img/news/';

    if (!empty($image)) {
        $old_path = $upload_dir . $image;
        if (file_exists($old_path)) {
            unlink($old_path);
        }
    }

    $file_name   = time() . '_' . basename($_FILES['image_file']['name']);
    $upload_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_path)) {
        $image = mysqli_real_escape_string($conn, $file_name);
    }
}

$query = "
UPDATE news SET
    title   = '$title',
    content = '$content',
    author  = '$author',
    image   = '$image'
WHERE id_news = $id_news
";

if (!mysqli_query($conn, $query)) {
    die("DB ERROR: " . mysqli_error($conn));
}

logActivity($author, 'edit', "Updated news: $title");

header("Location: ../admin/news.php?success=updated");
exit;
