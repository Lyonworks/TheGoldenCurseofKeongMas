<?php
$title = 'Manage Comments';

include 'layout/header.php';
include '../process/get_data.php';
$comments = getAllComments();
mysqli_query($conn, "UPDATE comments SET is_read = 1 WHERE is_read = 0");
?>

<div class="p-4 w-100">
  <h1 class="fw-bold mb-4">Manage Comments</h1>

  <div class="card shadow-sm rounded-4 p-3">
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center mb-0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Comment</th>
            <th>Type</th>
            <th width="120">Actions</th>
          </tr>
        </thead>
        <tbody>

        <?php if (!empty($comments)): ?>
          <?php foreach ($comments as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['name']) ?></td>

            <td>
              <?= nl2br(htmlspecialchars($c['message'])) ?>
            </td>

            <td>
              <?= $c['id_parent'] ? 'Reply' : 'Comment' ?>
            </td>

            <td>
              <form action="../process/delete_comment_admin.php"
                    method="POST"
                    onsubmit="return confirm('Delete this comment?');">

                <input type="hidden"
                       name="id"
                       value="<?= $c['id_comments'] ?>">

                <button class="btn btn-danger btn-sm">
                  Delete
                </button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-muted">
              No comments found
            </td>
          </tr>
        <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'layout/footer.php'; ?>
