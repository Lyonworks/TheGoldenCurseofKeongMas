<?php
include "../config/database.php";
include "../helpers/log.php";

$id = (int) $_POST['id'];

$query  = "SELECT image FROM merchandise WHERE id_merchandise = $id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($result);

if (!empty($data['image'])) {
    $path = "../assets/img/" . $data['image'];
    if (file_exists($path)) {
        unlink($path);
    }
}

mysqli_query($conn, "DELETE FROM merchandise WHERE id_merchandise = $id");

logActivity('Admin', 'delete', "Deleted merchandise ID $id");

header("Location: ../admin/merchandise.php?success=deleted");
exit();
