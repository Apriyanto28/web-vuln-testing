<?php
require 'db.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  // RAW (tetap lab): escape ringan tapi tetap tanpa prepared statement
  $username = $mysqli->real_escape_string($_POST['username']);
  $password = $_POST['password'];              // akan di-MD5
  $fullname = $_POST['fullname'];              // RAW → XSS stored demo
  $email    = $mysqli->real_escape_string($_POST['email']);
  $is_admin = isset($_POST['is_admin']) ? 1 : 0;

  if($username === '' || $password === ''){
    $msg = 'Username & Password wajib diisi';
  } else {
    $pwd_md5 = md5($password);
    $sql = "INSERT INTO users (username,password,fullname,email,is_admin)
            VALUES ('$username','$pwd_md5','".$mysqli->real_escape_string($fullname)."','$email',$is_admin)";
    if($mysqli->query($sql)){
      header('Location: admin_dashboard.php#users'); exit;
    } else {
      $msg = 'Gagal: '.$mysqli->error;
    }
  }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><title>Tambah User — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-4" style="max-width:720px">
  <div class="card card-v">
    <div class="card-body p-4">
      <h4 class="mb-3"><i class="bi bi-person-plus"></i> Tambah User</h4>
      <?php if($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Username</label>
          <input class="form-control" name="username" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input class="form-control" name="password" type="password" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Lengkap</label>
          <input class="form-control" name="fullname">
<!--          <div class="form-text">Nilai ini ditampilkan tanpa escaping (stored XSS demo).</div>-->
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" type="email">
        </div>
        <div class="col-12 form-check">
          <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin">
          <label class="form-check-label" for="is_admin">Jadikan Admin</label>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
          <a class="btn btn-outline-secondary" href="admin_dashboard.php#users"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
      </form>
<!--      <div class="alert alert-warning mt-3 small mb-0">LAB mode: query tanpa prepared, MD5 hashing, output RAW.</div> -->
    </div>
  </div>
</div>
</body>
</html>
