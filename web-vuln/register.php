<?php
// register.php
require 'db.php';

// Jika sudah login, arahkan kembali
if(isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Ambil input (minimal escaping)
    $username = isset($_POST['username']) ? $mysqli->real_escape_string(trim($_POST['username'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password2= isset($_POST['password2']) ? $_POST['password2'] : '';
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email    = isset($_POST['email']) ? $mysqli->real_escape_string(trim($_POST['email'])) : '';

    // Validasi sederhana
    if($username === '' || $password === '' || $password2 === ''){
        $msg = 'Username dan password wajib diisi.';
    } elseif($password !== $password2){
        $msg = 'Password & konfirmasi tidak cocok.';
    } else {
        // Cek apakah username sudah ada
        $r = $mysqli->query("SELECT id FROM users WHERE username = '$username' LIMIT 1");
        if($r && $r->num_rows > 0){
            $msg = 'Username sudah digunakan.';
        } else {
            // Hash MD5 (sesuai permintaan lab). CATAT: MD5 tidak aman untuk produksi.
            $pwd_md5 = md5($password);
            $fullname_db = $mysqli->real_escape_string($fullname); // simpan raw-ish (stored XSS demo)
            $sql = "INSERT INTO users (username, password, fullname, email, is_admin)
                    VALUES ('$username', '$pwd_md5', '$fullname_db', '$email', 0)";
            if($mysqli->query($sql)){
                // redirect ke login dengan pesan sukses (toast)
                //header('Location: login_user.php?registered=1');
                header('Location: login.php?registered=1');
                exit;
            } else {
                $msg = 'Gagal registrasi: ' . $mysqli->error;
            }
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Register — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
  <style>
    .card-v { border:none; border-radius:12px; box-shadow:0 8px 26px rgba(0,0,0,.06); }
  </style>
</head>
<body class="bg-light">

<div class="container my-5" style="max-width:720px;">
  <div class="card card-v">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="bi bi-person-plus"></i> Daftar Akun Baru</h4>
        <!--<a href="login_user.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-arrow-in-right"></i> Login</a>-->
        <a href="login.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-arrow-in-right"></i> Login</a>
      </div>

      <?php if($msg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Username</label>
          <input class="form-control" name="username" required value="<?= isset($username) ? htmlspecialchars($username, ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" type="email" value="<?= isset($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input class="form-control" name="password" type="password" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Konfirmasi Password</label>
          <input class="form-control" name="password2" type="password" required>
        </div>

        <div class="col-12">
          <label class="form-label">Nama Lengkap</label>
          <input class="form-control" name="fullname" value="<?= isset($fullname) ? htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') : '' ?>">
          <div class="form-text small">Jangan lupa memasukkan nama lengkap Anda ... !!!</div>
        </div>

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary"><i class="bi bi-person-plus"></i> Daftar</button>
          <a class="btn btn-outline-secondary" href="index.php"><i class="bi bi-house"></i> Batal</a>
        </div>
      </form>

      <hr class="my-4">
        <!--
      <div class="small text-muted">
        <strong>Catatan (LAB):</strong> Akun disimpan dengan hashing MD5 (demo). MD5 lemah untuk password. Setelah pengujian, migrasikan ke <code>password_hash()</code>.
      </div>
      -->
    </div>
  </div>
</div>

</body>
</html>
