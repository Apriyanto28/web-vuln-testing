<?php
require 'db.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }

$id = isset($_GET['id']) ? $_GET['id'] : 0;               // RAW → SQLi demo
$user = $mysqli->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if(!$user){ die('User tidak ditemukan'); }

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $username = $mysqli->real_escape_string($_POST['username']);
  $password = $_POST['password']; // jika diisi → MD5
  $fullname = $_POST['fullname']; // RAW (stored XSS demo)
  $email    = $mysqli->real_escape_string($_POST['email']);
  $is_admin = isset($_POST['is_admin']) ? 1 : 0;

  $set_pwd = $password !== '' ? ", password='".md5($password)."'" : "";
  $sql = "UPDATE users SET
            username='$username',
            fullname='".$mysqli->real_escape_string($fullname)."',
            email='$email',
            is_admin=$is_admin
            $set_pwd
          WHERE id=$id";                                   // tetap RAW
  if($mysqli->query($sql)){
    // jika edit user yg sedang login, segarkan session agar perubahan terlihat
    if(isset($_SESSION['user']) && $_SESSION['user']['id'] == $user['id']){
      $_SESSION['user'] = $mysqli->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
    }
    header('Location: admin_dashboard.php#users'); exit;
  } else {
    $msg = 'Gagal: '.$mysqli->error;
  }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><title>Edit User — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-4" style="max-width:720px">
  <div class="card card-v">
    <div class="card-body p-4">
      <h4 class="mb-3"><i class="bi bi-pencil-square"></i> Edit User #<?= $user['id'] ?></h4>
      <?php if($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Username</label>
          <input class="form-control" name="username" value="<?= $user['username'] ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input class="form-control" name="password" type="password" placeholder="Kosongkan jika tidak ganti">
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Lengkap</label>
          <input class="form-control" name="fullname" value="<?php echo $user['fullname']; // RAW ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" type="email" value="<?= $user['email'] ?>">
        </div>
        <div class="col-12 form-check">
          <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" <?= $user['is_admin'] ? 'checked':'' ?>>
          <label class="form-check-label" for="is_admin">Jadikan Admin</label>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
          <a class="btn btn-outline-secondary" href="admin_dashboard.php#users"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
      </form>
<!--      <div class="alert alert-warning mt-3 small mb-0">LAB mode: parameter <code>id</code> dipakai langsung di SQL (SQLi), output RAW, hashing MD5.</div> -->
    </div>
  </div>
</div>
</body>
</html>
