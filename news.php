<?php
include 'config/database.php';
include 'layout/header.php';

$newsQuery = mysqli_query(
  $conn,
  "SELECT * FROM news ORDER BY created_at DESC"
);
?>
<main class="flex-grow-1">
<section class="news-list mt-5 py-5">
  <div class="container">

    <h2 class="text-center mb-5">NEWS</h2>

    <div class="row g-4">
      <?php if ($newsQuery && mysqli_num_rows($newsQuery) > 0): ?>
        <?php while ($n = mysqli_fetch_assoc($newsQuery)): ?>
          <div class="col-lg-4 col-md-6">
            <a href="news_detail.php?id=<?= $n['id_news'] ?>"
               class="text-decoration-none text-white">

              <div class="card news-card h-100 border-0 shadow-sm">

                <img
                  src="assets/img/news/<?= htmlspecialchars($n['image']) ?>"
                  class="card-img-top"
                  alt="<?= htmlspecialchars($n['title']) ?>">

                <div class="card-body">
                  <small class="text-warning">
                    <?= date('d M Y', strtotime($n['created_at'])) ?>
                  </small>

                  <h5 class="card-title mt-2">
                    <?= htmlspecialchars($n['title']) ?>
                  </h5>

                  <p class="card-text opacity-75">
                    <?= substr(strip_tags($n['content']), 0, 120) ?>...
                  </p>
                </div>

              </div>
            </a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center opacity-75">No news available</p>
      <?php endif; ?>
    </div>

  </div>
</section>
</main>
<?php include 'layout/footer.php'; ?>
