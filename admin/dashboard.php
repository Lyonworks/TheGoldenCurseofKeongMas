<?php
$title = 'Admin Dashboard';

include 'layout/header.php';
include '../process/get_data.php';

$activity       = getAllActivities();
$unreadComments = getUnreadCommentsCount();
$merchCount     = getMerchandiseCount();
$newsCount      = getNewsCount();
$latestNews     = getLatestNews(5);
?>

<div class="p-4 w-100">
  <h1 class="fw-bold mb-4">Welcome to Admin Dashboard</h1>

  <div class="row dashboard-row g-3">

    <div class="col-12 col-lg-8 d-flex flex-column gap-3">

      <!-- RECENT ACTIVITIES -->
      <div class="card shadow-sm flex-fill">
        <div class="card-header fw-bold"><img src="assets/icons/tab_recent.png" class="me-2"> Recent Activities</div>
        <div class="card-body p-0 scroll-card">
          <ul class="list-group list-group-flush">
            <?php if (!empty($activity)): ?>
              <?php foreach ($activity as $a): ?>
                <li class="list-group-item d-flex justify-content-between">
                  <div>
                    <strong><?= htmlspecialchars($a['name']) ?></strong>
                    <small class="text-muted">(<?= strtoupper($a['action']) ?>)</small><br>
                    <small><?= htmlspecialchars($a['description']) ?></small>
                  </div>
                  <small class="text-muted">
                    <?= date('d M Y H:i', strtotime($a['created_at'])) ?>
                  </small>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="list-group-item text-muted text-center">
                No activities yet
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <!-- LATEST NEWS -->
      <div class="card shadow-sm flex-fill">
        <div class="card-header fw-bold"><img src="assets/icons/newss.png" class="me-2"> Latest News</div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            <?php if (!empty($latestNews)): ?>
              <?php foreach ($latestNews as $n): ?>
                <li class="list-group-item d-flex justify-content-between">
                  <span><?= htmlspecialchars($n['title']) ?></span>
                  <small class="text-muted">
                    <?= date('d M Y', strtotime($n['created_at'])) ?>
                  </small>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="list-group-item text-muted text-center">
                No news available
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

    </div>

    <div class="col-12 col-lg-4 d-flex flex-column gap-3">
      <div class="row g-3">
        <!-- MERCH -->
        <div class="col-6">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
              <h6 class="mb-1"><img src="assets/icons/shopping_cartt.png" class="me-2"> Merchandise</h6>
              <div class="fs-4 fw-bold text-warning"><?= $merchCount ?></div>
              <small class="text-muted">Products</small>
            </div>
            <a href="merchandise.php" class="stretched-link"></a>
          </div>
        </div>

        <!-- NEWS -->
        <div class="col-6">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
              <h6 class="mb-1"><img src="assets/icons/newss.png" class="me-2"> News</h6>
              <div class="fs-4 fw-bold text-warning"><?= $newsCount ?></div>
              <small class="text-muted">Published</small>
            </div>
            <a href="news.php" class="stretched-link"></a>
          </div>
        </div>

        <!-- COMMENTS -->
        <div class="col-6">
          <div class="card shadow-sm h-100 position-relative">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
              <h6 class="mb-1"><img src="assets/icons/commentt.png" class="me-2"> Comments</h6>
              <div class="position-relative fs-3">
                <span class="fw-bold text-warning"><?= $unreadComments ?></span>
                <?php if ($unreadComments > 0): ?>
                  <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                    <?= $unreadComments ?>
                  </span>
                <?php endif; ?>
              </div>
              <small class="text-muted mt-1">New</small>
            </div>
            <a href="comment.php" class="stretched-link"></a>
          </div>
        </div>

        <!-- CLOCK -->
        <div class="col-6">
          <div class="card shadow-sm h-100 text-center">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
              <h5 id="clock" class="mb-0"></h5>
              <small id="date" class="text-muted"></small>
            </div>
          </div>
        </div>
      </div>

      <!-- QUICK ACTION -->
      <div class="card shadow-sm">
        <div class="card-header fw-bold"><img src="assets/icons/bolt.png" class="me-2"> Quick Actions</div>
        <div class="card-body d-grid gap-2">
          <a href="news.php?add=1" class="btn btn-outline-warning"><img src="assets/icons/add.png"> Add News</a>
          <a href="merchandise.php?add=1" class="btn btn-outline-warning"><img src="assets/icons/add.png"> Add Merchandise</a>
          <a href="comment.php" target="_blank" class="btn btn-outline-warning"><img src="assets/icons/rate_review.png"> Manage Comments</a>
          <a href="../index.php" target="_blank" class="btn btn-outline-warning"><img src="assets/icons/pageview.png"> View Website</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function updateClock() {
  const now = new window.Date();
  document.getElementById('clock').innerText = now.toLocaleTimeString();
  document.getElementById('date').innerText = now.toDateString();
}
setInterval(updateClock, 1000);
updateClock();
</script>

<?php include 'layout/footer.php'; ?>
