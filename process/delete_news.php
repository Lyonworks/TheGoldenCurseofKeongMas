<?php
include "../config/database.php";
include "../helpers/log.php";

$id = (int) $_POST['id'];

$get = mysqli_query($conn, "SELECT image FROM news WHERE id_news=$id");
$data = mysqli_fetch_assoc($get);

if (!empty($data['image'])) {
    $path = "../assets/img/" . $data['image'];
    if (file_exists($path)) {
        unlink($path);
    }
}

mysqli_query($conn, "DELETE FROM news WHERE id_news=$id");

logActivity('Admin', 'delete', "Deleted news ID $id");

header("Location: ../admin/news.php?success=deleted");
exit;
