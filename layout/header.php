<?php
include './config/database.php';
session_start();
if (!isset($_SESSION['user_token'])) {
    $_SESSION['user_token'] = bin2hex(random_bytes(16));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="assets/icon.png">
  <title>The Golden Curse of Keong Mas</title>
  <link rel="stylesheet" href="assets/bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/aos/dist/aos.css">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="body d-flex flex-column min-vh-100" >

<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">

    <a class="navbar-brand" href="/">
      <img src="assets/icon.png" alt="Logo" style="max-height: 40px;">
    </a>

    <!-- TOGGLER (INI YANG KAMU BELUM PUNYA) -->
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menu"
            aria-controls="menu"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/index.php#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/index.php#merchandise">Merchandise</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/news.php">News</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/index.php#download">Download</a>
        </li>
      </ul>
    </div>

  </div>
</nav>
