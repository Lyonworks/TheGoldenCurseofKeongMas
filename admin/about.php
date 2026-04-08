<?php
$title = 'Manage About';

include 'layout/header.php';
include '../process/get_data.php';
$about = getAllAbout();
$about_images = getAllAboutImages();
$description_data = !empty($about) ? $about[0] : null;
?>

<div class="p-4 w-100">
  <h1 class="fw-bold mb-4">Manage About</h1>

  <!-- Error/Success Messages -->
  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Error: <?= htmlspecialchars($_GET['error']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>
  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      ✓ <?= htmlspecialchars($_GET['success']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Section Description -->
  <div class="card shadow-sm rounded-4 p-3 mb-4">
    <h5 class="card-title mb-3">Edit Description</h5>
    <form action="../process/update_about_desc.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4" required><?= $description_data ? htmlspecialchars($description_data['description']) : '' ?></textarea>
      </div>
      <button type="submit" class="btn btn-success">Update Description</button>
    </form>
  </div>

  <!-- Section Images -->
  <div class="card shadow-sm rounded-4 p-3">
    <h5 class="card-title mb-3">Images List</h5>
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center mb-0">
        <thead>
            <tr>
            <th width="300">Preview</th>
            <th>Image Name</th>
            <th width="120">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($about_images as $img): ?>
            <tr>
            <td>
              <img src="../assets/img/<?= $img['image'] ?>" alt="About Image" style="max-width: 300px; max-height: 300px;">
            </td>
            <td><?= htmlspecialchars($img['image']) ?></td>
            <td>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editImageModal" 
                        data-image-id="<?= $img['id_image'] ?>" 
                        data-image-path="<?= htmlspecialchars($img['image']) ?>">
                  Edit
                </button>
            </td>
            </tr>
            <?php endforeach; ?>

            <?php if (empty($about_images)): ?>
            <tr>
            <td colspan="3" class="text-muted text-center">No images found</td>
            </tr>
            <?php endif; ?>
        </tbody>
        </table>
    </div>
  </div>
</div>

<div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="../process/edit_about_image.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="editImageLabel">Edit Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="editImageId">
          <input type="hidden" name="image" id="editOldImage">

          <div class="mb-3">
            <img id="editImagePreview" class="img-fluid rounded mb-2">
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
  document.addEventListener('click', function(e) {
    const btn = e.target.closest('[data-bs-target="#editImageModal"]');
    if (!btn) return;

    const imageId = btn.getAttribute('data-image-id');
    const imagePath = btn.getAttribute('data-image-path');

    document.getElementById('editImageId').value = imageId;
    document.getElementById('editOldImage').value = imagePath;
    document.getElementById('editImagePreview').src = '../assets/img/' + imagePath;
  });
</script>

<?php include 'layout/footer.php'; ?>
