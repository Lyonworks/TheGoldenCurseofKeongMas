<?php
session_start();
require '../config/database.php';

// Cek login
if (!isset($_SESSION['admin']) || empty($_SESSION['admin']['id_admin'])) {
    header('Location: ../admin/login.php');
    exit;
}

$id = $_SESSION['admin']['id_admin'] ?? null;

// Ambil input
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Validasi username
if ($username === '') {
    header('Location: ../admin/admin.php?error=' . urlencode('Username tidak boleh kosong'));
    exit;
}

// 🔍 DEBUG (aktifkan kalau masih error)
// var_dump($id, $username); exit;

// Cek username sudah dipakai atau belum
$checkStmt = mysqli_prepare($conn, 'SELECT id_admin FROM admins WHERE username = ? AND id_admin != ?');
if (!$checkStmt) {
    die('Prepare failed: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($checkStmt, 'si', $username, $id);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    mysqli_stmt_close($checkStmt);
    header('Location: ../admin/admin.php?error=' . urlencode('Username sudah digunakan'));
    exit;
}
mysqli_stmt_close($checkStmt);

// Handle password (optional)
$passwordHash = null;
if ($password !== '' || $confirmPassword !== '') {

    if ($password !== $confirmPassword) {
        header('Location: ../admin/admin.php?error=' . urlencode('Password dan konfirmasi tidak cocok'));
        exit;
    }

    if (strlen($password) < 8) {
        header('Location: ../admin/admin.php?error=' . urlencode('Password minimal 8 karakter'));
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    if (!$passwordHash) {
        header('Location: ../admin/admin.php?error=' . urlencode('Gagal membuat hash password'));
        exit;
    }
}

// Query update
if ($passwordHash !== null) {
    $updateStmt = mysqli_prepare($conn, 'UPDATE admins SET username = ?, password = ? WHERE id_admin = ?');
    if (!$updateStmt) {
        die('Prepare failed: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($updateStmt, 'ssi', $username, $passwordHash, $id);
} else {
    $updateStmt = mysqli_prepare($conn, 'UPDATE admins SET username = ? WHERE id_admin = ?');
    if (!$updateStmt) {
        die('Prepare failed: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($updateStmt, 'si', $username, $id);
}

// Eksekusi
if (!mysqli_stmt_execute($updateStmt)) {
    mysqli_stmt_close($updateStmt);
    header('Location: ../admin/admin.php?error=' . urlencode('Error: ' . mysqli_stmt_error($updateStmt)));
    exit;
}

// CEK affected rows
$affectedRows = mysqli_stmt_affected_rows($updateStmt);

// Jika 0 affected rows tapi username berbeda, update tetap dianggap berhasil
if ($affectedRows < 0) {
    mysqli_stmt_close($updateStmt);
    header('Location: ../admin/admin.php?error=' . urlencode('Database error'));
    exit;
}

mysqli_stmt_close($updateStmt);

// Update session
$_SESSION['admin']['username'] = $username;

// Debug: write to error log
error_log('Admin update: id_admin=' . $id . ' username=' . $username . ' affected_rows=' . $affectedRows);

// Redirect sukses
header('Location: ../admin/admin.php?success=' . urlencode('Pengaturan admin berhasil diperbarui'));
exit;
