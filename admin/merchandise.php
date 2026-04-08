<?php
$title = 'Manage Merchandise';

include 'layout/header.php';
include '../process/get_data.php';
$merchandise = getAllMerchandise();

$edit_id = null;
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    foreach ($merchandise as $item) {
        if ($item['id'] == $edit_id) {
            $edit_data = $item;
            break;
        }
    }
}
?>

<div class="p-4 w-100">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="fw-bold mb-0">Manage Merchandise</h1>

    <a href="?add=1" class="btn btn-primary">
      + Add Merchandise
    </a>
  </div>

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

  <!-- Form Add/Edit -->
  <?php if (isset($_GET['add']) || $edit_id): ?>
  <div class="card shadow-sm rounded-4 p-3 mb-4">
    <h5 class="card-title mb-3"><?= $edit_id ? 'Edit Merchandise' : 'Add Merchandise' ?></h5>

    <form action="<?= $edit_id ? '../process/edit_merchandise.php' : '../process/add_merchandise.php' ?>"
          method="POST" enctype="multipart/form-data">

      <?php if ($edit_id): ?>
        <input type="hidden" name="id" value="<?= $edit_id ?>">
        <input type="hidden" name="image" value="<?= htmlspecialchars($edit_data['image']) ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required
              value="<?= $edit_data['name'] ?? '' ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required><?= $edit_data['description'] ?? '' ?></textarea>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Price</label>
          <input type="number" name="price" class="form-control" required
                value="<?= $edit_data['price'] ?? '' ?>">
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Stock</label>
          <input type="number" name="stock" class="form-control" min="0" required
                value="<?= $edit_data['stock'] ?? 0 ?>">
        </div>

        <div class="col-md-4 mb-3 d-flex align-items-center">
          <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" name="limited" value="1"
              <?= isset($edit_data['limited']) && $edit_data['limited'] ? 'checked' : '' ?>>
            <label class="form-check-label">LIMITED ITEM</label>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" name="image_file" class="form-control" <?= !$edit_id ? 'required' : '' ?>>
        <?php if ($edit_id && $edit_data['image']): ?>
          <small class="text-muted">Current: <?= $edit_data['image'] ?></small>
        <?php endif; ?>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-success"><?= $edit_id ? 'Update' : 'Add' ?></button>
        <a href="merchandise.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
  <?php endif; ?>

  <!-- Table -->
  <div class="card shadow-sm rounded-4 p-3">
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center mb-0">
        <thead>
          <tr>
            <th>Preview</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th width="120">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($merchandise as $r): ?>
          <tr>
            <td>
              <?php if (isset($r['image']) && $r['image']): ?>
                <img src="../assets/img/<?= htmlspecialchars($r['image']) ?>" alt="Merchandise" style="max-width: 100px; max-height: 100px;">
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($r['name'] ?? '') ?></td>
            <td><?= htmlspecialchars($r['description'] ?? '') ?></td>
            <td>Rp <?= isset($r['price']) ? number_format($r['price']) : '0' ?></td>
            <td><?= $r['stock'] ?></td>
            <td>
              <?php if ($r['stock'] <= 0): ?>
                <span class="badge bg-danger">SOLD OUT</span>
              <?php elseif ($r['limited']): ?>
                <span class="badge bg-warning text-dark">LIMITED</span>
              <?php else: ?>
                <span class="badge bg-success">READY</span>
              <?php endif; ?>
            </td>
            <td>
              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMerchandiseModal"
                      data-id_merchandise="<?= $r['id_merchandise'] ?>"
                      data-name="<?= htmlspecialchars($r['name'], ENT_QUOTES) ?>"
                      data-description="<?= htmlspecialchars($r['description'], ENT_QUOTES) ?>"
                      data-price="<?= $r['price'] ?>"
                      data-stock="<?= $r['stock'] ?>"
                      data-limited="<?= $r['limited'] ?>"
                      data-image="<?= htmlspecialchars($r['image'], ENT_QUOTES) ?>">
                Edit
              </button>

              <form action="../process/delete_merchandise.php" method="POST" style="display:inline" onsubmit="return confirm('Are you sure?');">
                <input type="hidden" name="id" value="<?= $r['id_merchandise'] ?>">
                <button class="btn btn-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>

          <?php if (empty($merchandise)): ?>
          <tr>
            <td colspan="4" class="text-muted text-center">No merchandise found</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="editMerchandiseModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <form action="../process/edit_merchandise.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit Merchandise</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="editMerchId" name="id_merchandise">
          <input type="hidden" id="editOldImage" name="image">

          <div class="mb-3">
            <label>Name</label>
            <input id="editName" name="name" class="form-control">
          </div>

          <div class="mb-3">
            <label>Description</label>
            <textarea id="editDescription" name="description" class="form-control"></textarea>
          </div>

          <div class="row">
            <div class="col-md-4">
              <label>Price</label>
              <input id="editPrice" name="price" class="form-control">
            </div>
            <div class="col-md-4">
              <label>Stock</label>
              <input id="editStock" name="stock" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-center">
              <div class="form-check mt-4">
                <input id="editLimited" type="checkbox" name="limited" value="1" class="form-check-input">
                <label class="form-check-label">LIMITED</label>
              </div>
            </div>
          </div>

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
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-bs-target="#editMerchandiseModal"]');
    if (!btn) return;

    const id      = btn.getAttribute('data-id_merchandise');
    const name    = btn.getAttribute('data-name');
    const desc    = btn.getAttribute('data-description');
    const price   = btn.getAttribute('data-price');
    const stock   = btn.getAttribute('data-stock');
    const image   = btn.getAttribute('data-image');
    const limited = btn.getAttribute('data-limited');

    document.getElementById('editMerchId').value = id;
    document.getElementById('editOldImage').value = image;

    document.getElementById('editName').value = name;
    document.getElementById('editDescription').value = desc;
    document.getElementById('editPrice').value = price;
    document.getElementById('editStock').value = stock;
    document.getElementById('editLimited').checked = (limited == 1);

    document.getElementById('editImagePreview').src =
      '../assets/img/' + image;
  });
</script>

<?php include 'layout/footer.php'; ?>
