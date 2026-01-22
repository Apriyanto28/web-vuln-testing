<?php
require 'db.php';
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $username = $mysqli->real_escape_string($_POST['username']);
  $password = $_POST['password'];
  $fullname = $mysqli->real_escape_string($_POST['fullname']);
  $email = $mysqli->real_escape_string($_POST['email']);

  // hash MD5 sebelum disimpan
  $pwd_md5 = md5($password);

  $sql = "INSERT INTO users (username,password,fullname,email,is_admin) VALUES ('$username','$pwd_md5','$fullname','$email',0)";
  if($mysqli->query($sql)){
    $msg = "Registrasi berhasil. Silakan login.";
  } else {
    $msg = "Gagal: " . $mysqli->error;
  }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container my-5">
  <h3>Register User</h3>
  <?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>
  <form method="post">
    <div class="mb-3"><label>Username</label><input class="form-control" name="username" required></div>
    <div class="mb-3"><label>Password</label><input class="form-control" name="password" type="password" required></div>
    <div class="mb-3"><label>Nama Lengkap</label><input class="form-control" name="fullname"></div>
    <div class="mb-3"><label>Email</label><input class="form-control" name="email" type="email"></div>
    <button class="btn btn-primary">Daftar</button>
  </form>
</div>
</body></html>
