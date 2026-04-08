<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect("localhost", "root", "", "keongmas");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_token'])) {
    $_SESSION['user_token'] = bin2hex(random_bytes(16));
}
?>
