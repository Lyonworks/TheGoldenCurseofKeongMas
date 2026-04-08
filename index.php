<?php include 'layout/header.php'; ?>

<!-- HOME -->
<section id="home" class="vh-100 d-flex align-items-center text-center">
   <div class="container">
    <div class="row align-items-center mt-5">
      
      <!-- Keong Mas -->
      <div class="col-md-6" data-aos="fade-right">
          <img src="assets/keong.gif" class="img-fluid rounded" autoplay muted loop>
      </div>

      <!-- Judul -->
      <div class="col-md-6" data-aos="fade-left">
        <img src="assets/teks.png" style="max-width: 100%;">
        <h3 class="text-white mt-4">The Golden Journey to Break the Curse</h3>
        <a href="#download" class="btn btn-lg btn-warning fw-bold mt-5">GET THE GAME</a>
      </div>

    </div>
  </div>
</section>

<!-- ABOUT -->
<section id="about" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4" data-aos="fade-up">ABOUT GAME</h2>
    <?php
    $about_query = mysqli_query($conn, "SELECT * FROM about LIMIT 1");
    $about_data = mysqli_fetch_assoc($about_query);

    $images_query = mysqli_query($conn, "SELECT * FROM about_images ORDER BY id_image DESC");
    $about_images = $images_query ? mysqli_fetch_all($images_query, MYSQLI_ASSOC) : [];
    ?>
    <div class="row align-items-center mb-5">
      <div class="col-md-6" data-aos="zoom-in">
        <?php if (!empty($about_images)): ?>
          <div class="about-images-wrapper">
            <div class="about-images-container">
              <?php foreach ($about_images as $key => $img): ?>
                <div class="about-image-card" style="--delay: <?= $key ?>;">
                  <img 
                    src="assets/img/<?= htmlspecialchars($img['image']) ?>" 
                    alt="About Image <?= $key + 1 ?>"
                    class="about-clickable"
                    data-bs-toggle="modal"
                    data-bs-target="#aboutImageModal"
                    data-image="assets/img/<?= htmlspecialchars($img['image']) ?>">
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-md-6" data-aos="fade-left">
        <p class="text-justify"><?= nl2br(htmlspecialchars($about_data['description'])) ?></p>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="aboutImageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark border-0">

      <div class="modal-body text-center p-0 position-relative">

        <button 
          type="button" 
          class="btn-close position-absolute top-0 end-0 m-3 bg-white"
          data-bs-dismiss="modal">
        </button>

        <img id="aboutModalImage" class="img-fluid rounded">
      </div>

    </div>
  </div>
</div>

<section id="developer" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4" data-aos="fade-up">ABOUT DEVELOPER</h2>
    <div class="row align-items-center flex-column-reverse flex-md-row">
      <div class="col-md-8 mt-4 mt-md-0" data-aos="fade-right">
        <h4 class="fw-bold">IKMALION ARDYANSYAH</h4>
        <p class="opacity-80">
          Indie game & web developer who loves Indonesian folklore.
          <strong>The Golden Curse of Keong Mas</strong> is a passion project
          to revive local legends through games and interactive media.
        </p>
      </div>
      <div class="col-md-4 text-center" data-aos="zoom-in">
        <div class="pixel-frame">
          <img src="assets/developer.jpg" alt="Developer">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MERCHANDISE -->
<section id="merchandise" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">MERCHANDISE</h2>

    <div class="row g-4">
      <?php
      $query = mysqli_query($conn, "SELECT * FROM merchandise");
      while ($m = mysqli_fetch_assoc($query)) :
      ?>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card merchandise-card text-center position-relative"
          data-aos="zoom-in"
          data-aos-delay="100"
          data-bs-toggle="modal"
          data-bs-target="#merchandiseModal"
          data-name="<?= htmlspecialchars($m['name']) ?>"
          data-price="<?= number_format($m['price']) ?>"
          data-description="<?= htmlspecialchars($m['description']) ?>"
          data-stock="<?= $m['stock'] ?>"
          data-image="assets/img/<?= $m['image'] ?>">

        <?php if ($m['stock'] <= 0): ?>
          <span class="badge badge-soldout">SOLD OUT</span>
        <?php elseif ($m['limited'] == 1): ?>
          <span class="badge badge-limited">LIMITED</span>
        <?php endif; ?>

        <img src="assets/img/<?= $m['image'] ?>"
            class="card-img-top <?= $m['stock'] <= 0 ? 'img-soldout' : '' ?>"
            alt="<?= htmlspecialchars($m['name']) ?>">

        <div class="card-body">
          <h5 class="card-title mb-0"><?= htmlspecialchars($m['name']) ?></h5>
        </div>
      </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<div class="modal fade" id="merchandiseModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body py-4">
        <div class="row align-items-center g-4">

          <!-- IMAGE -->
          <div class="col-md-6 text-center">
            <div class="modal-image-wrapper">
              <img id="modalImage" class="img-fluid rounded-4 shadow-sm">
            </div>
          </div>

          <!-- INFO -->
          <div class="col-md-6 d-flex flex-column" style="height: 320px;">
            <h3 class="modal-title" id="modalName"></h3>
            
            <p id="modalDescription" class=" small mb-3 flex-grow-1"></p>

            <div class="price-box mb-2">
              <span class="currency">Rp</span>
              <span id="modalPrice" class="price-value"></span>
            </div>

            <div class="stock-box mb-auto">
              <span class="stock-label">Stock</span>
              <span id="modalStock" class="badge-stock"></span>
            </div>

            <a id="waBtn" href="#" target="_blank" class="btn btn-success btn-lg mt-3 w-100">
              <img src="assets/whatsapp.png" alt="WhatsApp" width="20" height="20" class="me-2">Order
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- NEWS -->
<section id="news" class="py-5 text-white">
  <div class="container">
    <h2 class="text-center mb-4" data-aos="fade-up">LATEST NEWS</h2>

    <div class="row g-4">
      <?php
      $newsQuery = mysqli_query(
        $conn,
        "SELECT * FROM news ORDER BY created_at DESC LIMIT 6"
      );

      if ($newsQuery && mysqli_num_rows($newsQuery) > 0):
        while ($n = mysqli_fetch_assoc($newsQuery)):
      ?>
        <div class="col-lg-4 col-md-6 col-12" data-aos="fade-up">
          <a href="news_detail.php?id=<?= $n['id_news'] ?>" class="text-decoration-none text-white">
            <div class="card h-100 border-0 news-card">
              <img 
                src="assets/img/news/<?= htmlspecialchars($n['image']) ?>" 
                class="card-img-top"
                alt="<?= htmlspecialchars($n['title']) ?>">

              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h5 class="card-title mb-0">
                    <?= substr(htmlspecialchars($n['title']), 0, 30) ?>...
                  </h5>
                  <small class="opacity-80 text-nowrap ms-2">
                    <?= date('d M Y', strtotime($n['created_at'])) ?>
                  </small>
                </div>
                <p class="card-text opacity-75">
                  <?= substr(strip_tags($n['content']), 0, 100) ?>...
                </p>
              </div>
            </div>
          </a>
        </div>
      <?php
        endwhile;
      else:
      ?>
        <p class="text-center opacity-75">No news available</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- DOWNLOAD -->
<section id="download" class="py-5 text-center" data-aos="zoom-in">
  <div class="container">
    <h2 class="mb-4">GET THE GAME</h2>
    <a href="#" class="btn btn-lg btn-warning fw-bold">DOWNLOAD NOW</a>
  </div>
</section>


<!-- COMMENT -->
<section id="comment" class="py-5 bg-dark text-white">
  <div class="container">
    <h2 class="text-center mb-4" data-aos="fade-up">FORUM</h2>

    <form action="process/add_comment.php" method="POST" data-aos="fade-up">
      <input type="hidden" name="id_parent" value="">
      <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
      <textarea name="message" class="form-control mb-2" placeholder="Comment" required></textarea>
      <button type="submit" class="btn btn-warning">Submit</button>
    </form>

    <hr>

    <div class="comment-list">
      <?php
        $comments = mysqli_query(
          $conn,
          "SELECT * FROM comments WHERE id_parent IS NULL ORDER BY id_comments DESC"
        );

        if (!$comments) {
            die("Query error: " . mysqli_error($conn));
        }

        while ($c = mysqli_fetch_assoc($comments)) :
      ?>
        <div class="comment-box mb-3 p-3 rounded bg-secondary"
             data-aos="fade-up"
             data-aos-delay="100">
          <div class="d-flex align-items-center gap-2 mb-1">
            <strong><?= htmlspecialchars($c['name']) ?></strong>
            <small class="text-light opacity-75">
              <?= date('d M Y, H:i', strtotime($c['created_at'])) ?>
            </small>
          </div>

          <p class="comment-text">
            <?= nl2br(htmlspecialchars($c['message'])) ?>
          </p>

          <?php if (isset($c['user_token'], $_SESSION['user_token']) 
                    && $c['user_token'] === $_SESSION['user_token']) : ?>
            <form action="process/update_comment.php"
                  method="POST"
                  class="edit-form d-none mt-2">

              <input type="hidden" name="id_comments" value="<?= $c['id_comments'] ?>">

              <textarea name="message"
                        class="form-control form-control-sm mb-2"
                        required><?= htmlspecialchars($c['message']) ?></textarea>

              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-success">
                  Save
                </button>
                <button type="button"
                        class="btn btn-sm btn-secondary cancel-edit">
                  Cancel
                </button>
              </div>
            </form>
          <?php endif; ?>

          <div class="d-flex gap-3">
            <a class="text-warning text-decoration-none reply-btn">
              Reply
            </a>

            <?php if (isset($c['user_token'], $_SESSION['user_token']) 
                      && $c['user_token'] === $_SESSION['user_token']) : ?>
              <a class="text-warning text-decoration-none edit-btn">
                Edit
              </a>

              <a href="process/delete_comment.php?id=<?= $c['id_comments'] ?>"
                class="text-warning text-decoration-none"
                onclick="return confirm('Delete this comment?')">
                Delete
              </a>
            <?php endif; ?>
          </div>

          <form action="process/add_comment.php"
                method="POST"
                class="reply-form d-none mt-2">

            <input type="hidden" name="id_parent" value="<?= $c['id_comments'] ?>">

            <input type="text"
                  name="name"
                  class="form-control form-control-sm mb-2"
                  placeholder="Your name"
                  required>

            <textarea name="message"
                      class="form-control form-control-sm mb-2"
                      placeholder="Write a reply..."
                      required></textarea>

            <button type="submit" class="btn btn-sm btn-warning">
              Submit Reply
            </button>
          </form>

          <div class="reply-list">
            <?php
              $replies = mysqli_query(
                $conn,
                "SELECT * FROM comments WHERE id_parent = {$c['id_comments']} ORDER BY id_comments ASC"
              );
              while ($r = mysqli_fetch_assoc($replies)) :
              ?>
                <div class="reply-box ms-4 mt-3" data-aos="fade-left">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <strong><?= htmlspecialchars($r['name']) ?></strong>
                    <small class="text-light opacity-75">
                      <?= date('d M Y, H:i', strtotime($r['created_at'])) ?>
                    </small>
                  </div>
                  <p class="comment-text">
                    <?= nl2br(htmlspecialchars($r['message'])) ?>
                  </p>

                  <?php if (isset($r['user_token'], $_SESSION['user_token']) 
                            && $r['user_token'] === $_SESSION['user_token']) : ?>
                    <form action="process/update_comment.php"
                          method="POST"
                          class="edit-form d-none mt-2">

                      <input type="hidden" name="id_comments" value="<?= $r['id_comments'] ?>">

                      <textarea name="message"
                                class="form-control form-control-sm mb-2"
                                required><?= htmlspecialchars($r['message']) ?></textarea>
                      <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-success">
                          Save
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-secondary cancel-edit">
                          Cancel
                        </button>
                      </div>
                    </form>
                  <?php endif; ?>

                  <div class="d-flex gap-3">
                    <?php if (isset($r['user_token'], $_SESSION['user_token']) 
                              && $r['user_token'] === $_SESSION['user_token']) : ?>
                      <a class="text-warning text-decoration-none edit-btn">
                        Edit
                      </a>

                      <a href="process/delete_comment.php?id=<?= $r['id_comments'] ?>"
                        class="text-warning text-decoration-none"
                        onclick="return confirm('Delete this comment?')">
                        Delete
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endwhile;
            ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<?php include 'layout/footer.php'; ?>