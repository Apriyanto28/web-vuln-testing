<?php
// login_user.php (updated)
// Pastikan file db.php melakukan session_start() dan koneksi $mysqli
//require 'db.php';
require 'db.php';
require 'layout.php';
app_header('Apri Shop Medan');

$msg = '';

// Jika sudah login, redirect
if(isset($_SESSION['user'])){
    header('Location: index.php');
    exit;
}

// Tampilkan pesan sukses kalau baru registrasi
$registered_success = isset($_GET['registered']) && $_GET['registered'] == '1';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $u = isset($_POST['username']) ? $mysqli->real_escape_string($_POST['username']) : '';
  $p = isset($_POST['password']) ? $_POST['password'] : '';

  // Tetap MD5 (LAB mode)
  $p_md5 = md5($p);
  // Vulnerable query intentionally (lab)
  $res = $mysqli->query("SELECT * FROM users WHERE username = '$u' AND password = '$p_md5' AND is_admin = 0 LIMIT 1");
  if($res && $res->num_rows){
    $_SESSION['user'] = $res->fetch_assoc();
    header('Location: index.php'); exit;
  } else {
    $msg = 'Login gagal — periksa username / password';
  }
}
?>
<!--
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login User — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  // Bootstrap & Icons
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
  <style>
    .card-v { border:none; border-radius:12px; box-shadow:0 8px 26px rgba(0,0,0,.06); }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#0d6efd;">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-shield-lock"></i> VulnShop</a>
    <div class="ms-auto d-flex gap-2">
      <a class="btn btn-light btn-sm" href="login_user.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
      <a class="btn btn-outline-light btn-sm" href="login_admin.php"><i class="bi bi-key"></i> Admin</a>
    </div>
  </div>
</nav>
-->
<div class="container my-5" style="max-width:720px;">
  <div class="card card-v">
    <div class="card-body p-4">
      <h3 class="mb-3"><i class="bi bi-box-arrow-in-right"></i> Login User</h3>

      <!-- show registered success -->
      <?php if($registered_success): ?>
        <div class="alert alert-success">
          Registrasi berhasil. Silakan login dengan akun baru Anda.
        </div>
      <?php endif; ?>

      <!-- show login error -->
      <?php if($msg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <form method="post" class="row g-3">
        <div class="col-12">
          <label class="form-label">Username</label>
          <input class="form-control" name="username" required>
        </div>
        <div class="col-12">
          <label class="form-label">Password</label>
          <input class="form-control" name="password" type="password" required>
        </div>

        <div class="col-12 d-grid">
          <button class="btn btn-primary"><i class="bi bi-unlock"></i> Login</button>
        </div>

        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Belum punya akun? Silahkan di daftar ... !!!</small>
            <!-- Tombol/link pendaftaran -->
            <a href="register.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-plus"></i> Daftar</a>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<!--
<footer class="text-center py-4 text-muted small">
  VulnShop Demo · Lab Keamanan Web (SQLi, XSS, Clickjacking) — Lokal. Jangan gunakan di server publik / data nyata.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
      -->
<?php app_footer(); ?>
