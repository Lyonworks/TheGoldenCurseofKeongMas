<footer class="bg-dark text-white text-center py-3">
    <hr>
    © 2026 The Golden Curse of Keong Mas
</footer>

<script>
document.addEventListener('click', function(e) {
  const img = e.target.closest('.about-clickable');
  if (!img) return;

  const src = img.getAttribute('data-image');
  document.getElementById('aboutModalImage').src = src;
});
</script>

<script src="assets/bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/aos/dist/aos.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
