<?php
include "../config/database.php";
include "../helpers/log.php";

$description = $_POST['description'];

$query = "UPDATE about SET description='$description' WHERE id_about=1";
mysqli_query($conn, $query);

logActivity('Admin', 'edit', 'Updated about description');

header("Location: ../admin/about.php?success=updated");
exit();
?>
