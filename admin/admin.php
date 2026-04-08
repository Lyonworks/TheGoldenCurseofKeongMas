<?php
session_start();

$title = 'Admin Settings';
$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config/database.php';
    
    // Dapatkan id_admin dari session
    $id_admin = $_SESSION['admin']['id_admin'] ?? $_SESSION['admin']['id'] ?? null;
    $sessionUsername = $_SESSION['admin']['username'] ?? null;
    
    if (!$id_admin || !$sessionUsername) {
        $errorMsg = 'Session expired. Please login again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if (empty($username)) {
            $errorMsg = 'Username tidak boleh kosong';
        } else {
            // Cek username sudah ada
            $checkStmt = mysqli_prepare($conn, 'SELECT id_admin FROM admins WHERE username = ? AND id_admin != ?');
            mysqli_stmt_bind_param($checkStmt, 'si', $username, $id_admin);
            mysqli_stmt_execute($checkStmt);
            mysqli_stmt_store_result($checkStmt);
            
            if (mysqli_stmt_num_rows($checkStmt) > 0) {
                $errorMsg = 'Username sudah digunakan';
            } else {
                // Handle password
                $passwordHash = null;
                if (!empty($password) || !empty($confirm_password)) {
                    if ($password !== $confirm_password) {
                        $errorMsg = 'Password dan konfirmasi tidak cocok';
                    } elseif (strlen($password) < 8) {
                        $errorMsg = 'Password minimal 8 karakter';
                    } else {
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    }
                }
                
                // Lakukan update jika tidak ada error
                if (empty($errorMsg)) {
                    if ($passwordHash !== null) {
                        $updateStmt = mysqli_prepare($conn, 'UPDATE admins SET username = ?, password = ? WHERE id_admin = ?');
                        mysqli_stmt_bind_param($updateStmt, 'ssi', $username, $passwordHash, $id_admin);
                    } else {
                        $updateStmt = mysqli_prepare($conn, 'UPDATE admins SET username = ? WHERE id_admin = ?');
                        mysqli_stmt_bind_param($updateStmt, 'si', $username, $id_admin);
                    }
                    
                    if (mysqli_stmt_execute($updateStmt)) {
                        $_SESSION['admin']['username'] = $username;
                        $successMsg = 'Pengaturan admin berhasil diperbarui';
                    } else {
                        $errorMsg = 'Gagal memperbarui data admin';
                    }
                    mysqli_stmt_close($updateStmt);
                }
            }
            mysqli_stmt_close($checkStmt);
        }
    }
}

include 'layout/header.php';
$currentUsername = htmlspecialchars($_SESSION['admin']['username'] ?? '');
?>

<div class="p-4 w-100">
  <h1 class="fw-bold mb-4">Admin Settings</h1>

  <?php if (!empty($errorMsg)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($errorMsg) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (!empty($successMsg)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($successMsg) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="card shadow-sm rounded-4 p-4">
    <h5 class="card-title mb-4">Change Admin Account</h5>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="<?= $currentUsername ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Leave blank to keep current password">
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control" autocomplete="new-password" placeholder="Repeat new password">
      </div>

      <div class="text-muted mb-4">Isi username untuk mengganti nama admin. Isi password dan konfirmasi hanya jika ingin mengganti password.</div>

      <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
  </div>
</div>

<?php include 'layout/footer.php'; ?>
