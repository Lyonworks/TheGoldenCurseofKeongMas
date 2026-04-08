<?php
include '../config/database.php';

function getAllActivities() {
    global $conn;
    $query = "SELECT * FROM activity ORDER BY created_at DESC LIMIT 10";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        return [];
    }
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function logActivity($user, $action, $description)
{
    global $conn;

    $user = mysqli_real_escape_string($conn, $user);
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);

    mysqli_query($conn, "
        INSERT INTO activity (user, action, description)
        VALUES ('$user', '$action', '$description')
    ");
}

function getUnreadCommentsCount() {
    global $conn;

    $result = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM comments WHERE is_read = 0"
    );

    if (!$result) return 0;

    $row = mysqli_fetch_assoc($result);
    return (int) $row['total'];
}

function getMerchandiseCount() {
  global $conn;
  $q = mysqli_query($conn, "SELECT COUNT(*) total FROM merchandise");
  return mysqli_fetch_assoc($q)['total'] ?? 0;
}

function getNewsCount() {
  global $conn;
  $q = mysqli_query($conn, "SELECT COUNT(*) total FROM news");
  return mysqli_fetch_assoc($q)['total'] ?? 0;
}

function getLatestNews($limit = 3) {
  global $conn;
  $q = mysqli_query($conn, "SELECT id_news, title, created_at FROM news ORDER BY created_at DESC LIMIT $limit");
  return mysqli_fetch_all($q, MYSQLI_ASSOC);
}

function getAllAbout() {
    global $conn;
    $query = "SELECT * FROM about";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllAboutImages() {
    global $conn;
    $query = "SELECT * FROM about_images ORDER BY id_image DESC";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllMerchandise() {
    global $conn;
    $query = "SELECT * FROM merchandise";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllNews() {
    global $conn;
    $q = mysqli_query($conn, "SELECT * FROM news ORDER BY created_at DESC");
    return $q ? mysqli_fetch_all($q, MYSQLI_ASSOC) : [];
}

function getAllComments() {
    global $conn;
    $query = "SELECT * FROM comments";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>