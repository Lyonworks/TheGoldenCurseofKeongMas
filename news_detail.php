<?php
include 'config/database.php';

if (!isset($_GET['id'])) {
  header("Location: news.php");
  exit;
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM news WHERE id_news = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "News not found.";
  exit;
}

$news = $result->fetch_assoc();
?>

<?php include 'layout/header.php'; ?>

<div class="container mt-5 py-5">
  <div class="row justify-content-center">
    <div class="col-lg-9">

      <div class="card news-cardd shadow-lg border-0 rounded-4 p-4">

        <h1 class="fw-bold mb-2">
          <?= htmlspecialchars($news['title']) ?>
        </h1>

        <div class="d-flex align-items-center gap-3 text-muted mb-4">
          <span>
            <img src="assets/icons/person.png" alt="Author Icon" style="height: 16px; width: 16px; filter: invert(1);">
            Written by <strong><?= htmlspecialchars($news['author']) ?></strong>
          </span>
          <span>|</span>
          <span>
            <img src="assets/icons/calendar_month.png" alt="Calendar Icon" style="height: 16px; width: 16px; filter: invert(1);">
            <?= date('Y-m-d', strtotime($news['created_at'])) ?>
          </span>
        </div>

        <?php if (!empty($news['image'])): ?>
          <div class="mb-4">
            <img
              src="assets/img/news/<?= htmlspecialchars($news['image']) ?>"
              class="img-fluid rounded-3 w-100"
              alt="<?= htmlspecialchars($news['title']) ?>">
          </div>
        <?php endif; ?>

        <p class="fs-5">
          <?= nl2br(htmlspecialchars($news['content'])) ?>
        </p>

        <div class="mt-4">
          <a href="news.php" class="btn btn-secondary px-4">
            BACK
          </a>
        </div>

      </div>

    </div>
  </div>
</div>

<?php include 'layout/footer.php'; ?>
