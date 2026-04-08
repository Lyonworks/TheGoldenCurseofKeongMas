<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../assets/icon.png">
  <title><?= $title ?? 'Admin Panel'; ?></title>
  <link rel="stylesheet" href="./assets/css/app.css">
  <link rel="stylesheet" href="../assets/bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>
<body>

<div class="admin-wrapper d-flex">
  <aside class="sidebar text-white p-3 min-vh-100">
    <a href="dashboard.php">
      <img src="./assets/icons/teks.png" class="img-fluid ">
    </a>
    <hr style="color: #e99c05">

    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a href="dashboard.php" class="nav-link text-white fw-bold <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>"><img src="../assets/icons/dashboard.png" class="me-2" width="20" height="20">Dashboard</a>
      </li>
      <li class="nav-item mb-2">
        <a href="about.php" class="nav-link text-white fw-bold <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>"><img src="../assets/icons/info.png" class="me-2" width="20" height="20">About</a>
      </li>
      <li class="nav-item mb-2">
        <a href="merchandise.php" class="nav-link text-white fw-bold <?= basename($_SERVER['PHP_SELF']) == 'merchandise.php' ? 'active' : '' ?>"><img src="../assets/icons/shopping_cart.png" class="me-2" width="20" height="20">Merchandise</a>
      </li>
      <li class="nav-item mb-2">
        <a href="news.php" class="nav-link text-white fw-bold <?= basename($_SERVER['PHP_SELF']) == 'news.php' ? 'active' : '' ?>"><img src="../assets/icons/news.png" class="me-2" width="20" height="20">News</a>
      </li>
      <li class="nav-item mb-2">
        <a href="comment.php" class="nav-link text-white fw-bold <?= basename($_SERVER['PHP_SELF']) == 'comment.php' ? 'active' : '' ?>"><img src="../assets/icons/comment.png" class="me-2" width="20" height="20">Comment</a>
      </li>
    </ul>
  </aside>

  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="content flex-grow-1 d-flex flex-column">
    <header class="header d-flex justify-content-between align-items-center text-white p-3 gap-3">
      
      <button class="btn d-md-none" id="toggleSidebar">
        <img src="../assets/icons/menu.png" alt="Menu" width="20" height="20">
      </button>

      <div class="dropdown ms-auto">
        <a href="#"
          class="text-white text-decoration-none fw-bold dropdown-toggle"
          data-bs-toggle="dropdown">
          <?= htmlspecialchars($_SESSION['admin']['username']); ?>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item fw-bold"
              href="admin.php">
              Settings
            </a>
            <a class="dropdown-item fw-bold text-danger"
              href="logout.php"
              onclick="return confirm('Logout dari admin?')">
              Logout
            </a>
          </li>
        </ul>
      </div>
    </header>

    <main class="main-content p-4">
