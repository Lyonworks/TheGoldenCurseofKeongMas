    </main>
  </div>
</div>
<script src="../assets/bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

<script>
  const toggleBtn = document.getElementById('toggleSidebar');
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.getElementById('sidebarOverlay');

  // buka/tutup sidebar
  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
    document.body.classList.toggle('sidebar-open');
  });

  // klik overlay = tutup sidebar
  overlay.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
    document.body.classList.remove('sidebar-open');
  });
</script>
</body>
</html>
