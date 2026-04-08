<?php
$title = 'Manage News';

include 'layout/header.php';
include '../process/get_data.php';

$news = getAllNews();
?>

<div class="p-4 w-100">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="fw-bold mb-0">Manage News</h1>

    <a href="?add=1" class="btn btn-primary">
      + Add News
    </a>
  </div>

  <!-- ALERT -->
  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <?= htmlspecialchars($_GET['error']) ?>
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <?= htmlspecialchars($_GET['success']) ?>
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- ADD NEWS -->
  <?php if (isset($_GET['add'])): ?>
  <div class="card shadow-sm rounded-4 p-3 mb-4">
    <h5 class="mb-3">Add News</h5>

    <form action="../process/add_news.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Author</label>
        <input id="editAuthor" name="author" class="form-control">
      </div>

      <div class="mb-3">
        <label>Content</label>
        <textarea name="content" rows="5" class="form-control" required></textarea>
      </div>

      <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image_file" class="form-control" required>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-success">Publish</button>
        <a href="news.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
  <?php endif; ?>

  <!-- TABLE -->
  <div class="card shadow-sm rounded-4 p-3">
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center mb-0">
        <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Content</th>
            <th>Date</th>
            <th>Thumbnail</th>
            <th width="120">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($news as $n): ?>
          <tr>
            <td><?= htmlspecialchars($n['title']) ?></td>
            <td><?= htmlspecialchars($n['author']) ?></td>
            <td><?= nl2br(htmlspecialchars($n['content'])) ?></td>
            <td><?= date('d M Y', strtotime($n['created_at'])) ?></td>
            <td>
              <img src="../assets/img/news/<?= htmlspecialchars($n['image']) ?>"
                   style="max-height:80px">
            </td>
            <td>
              <button class="btn btn-warning btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#editNewsModal"
                data-id="<?= $n['id_news'] ?>"
                data-title="<?= htmlspecialchars($n['title'], ENT_QUOTES) ?>"
                data-author="<?= htmlspecialchars($n['author'], ENT_QUOTES) ?>"
                data-content="<?= htmlspecialchars($n['content'], ENT_QUOTES) ?>"
                data-image="<?= htmlspecialchars($n['image'], ENT_QUOTES) ?>">
                Edit
              </button>

              <form action="../process/delete_news.php" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this news?')">
                <input type="hidden" name="id" value="<?= $n['id_news'] ?>">
                <button class="btn btn-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>

          <?php if (empty($news)): ?>
          <tr>
            <td colspan="4" class="text-muted">No news found</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editNewsModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="../process/edit_news.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit News</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id_news" id="editNewsId">
          <input type="hidden" name="old_image" id="editOldImage">

          <div class="mb-3">
            <label>Title</label>
            <input id="editTitle" name="title" class="form-control">
          </div>

          <div class="mb-3">
            <label>Author</label>
            <input id="editAuthor" name="author" class="form-control">
          </div>

          <div class="mb-3">
            <label>Content</label>
            <textarea id="editContent" name="content" rows="5" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <img id="editImagePreview" class="img-fluid rounded mb-2" style="max-height: 200px;">
            <input type="file" name="image_file" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success">Update</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('click', function (e) {
  const btn = e.target.closest('[data-bs-target="#editNewsModal"]');
  if (!btn) return;

  document.getElementById('editNewsId').value = btn.dataset.id;
  document.getElementById('editTitle').value = btn.dataset.title;
  document.getElementById('editAuthor').value = btn.dataset.author;
  document.getElementById('editContent').value = btn.dataset.content;
  document.getElementById('editOldImage').value = btn.dataset.image;
  document.getElementById('editImagePreview').src =
    '../assets/img/news/' + btn.dataset.image;
});
</script>


<?php include 'layout/footer.php'; ?>
