<?php
require 'db.php'; require 'layout.php';
//if(!isset($_SESSION['user'])) { header('Location: login_user.php'); exit; }
if(!isset($_SESSION['user'])) { header('Location: login.php'); exit; }

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $fullname = $_POST['fullname']; // RAW (stored XSS demo)
  $id = (int)$_SESSION['user']['id'];
  $mysqli->query("UPDATE users SET fullname = '".$mysqli->real_escape_string($fullname)."' WHERE id = $id");
  $_SESSION['user'] = $mysqli->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
  header('Location: user_profile.php?toast=1'); exit;
}
app_header('Profile');
?>
<main class="container my-5" style="max-width:720px">
  <div class="card card-v">
    <div class="card-body p-4">
      <h3 class="mb-3"><i class="bi bi-person-circle"></i> Profile</h3>
      
      <!-- Tombol Riwayat Pesanan: hanya muncul untuk user biasa -->
      <?php if(isset($_SESSION['user']) && !$_SESSION['user']['is_admin']): ?>
        <a class="btn btn-outline-primary btn-sm mb-3" href="order_history.php">
          <i class="bi bi-clock-history"></i> Lihat Riwayat Pesanan
        </a>
      <?php endif; ?>
      
      <div class="mb-3"><strong>Nama:</strong> <?php echo $_SESSION['user']['fullname']; // RAW ?></div>
      <div class="mb-4"><strong>Email:</strong> <?php echo $_SESSION['user']['email']; ?></div>

      <h5 class="mb-2">Edit Bio</h5>
      <form method="post" class="row g-3">
        <div class="col-12">
          <label class="form-label">Nama Lengkap</label>
          <input class="form-control" name="fullname" value="<?php echo $_SESSION['user']['fullname']; ?>">
        </div>
        <div class="col-12 d-grid">
          <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </div>
      </form>
      <!--<p class="small text-muted mt-3 mb-0">Nilai di atas ditampilkan tanpa escaping untuk keperluan demonstrasi.</p>-->
    </div>
  </div>
</main>
<?php app_footer(); ?>
