<?php
require 'db.php';
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $u = $mysqli->real_escape_string($_POST['username']);
  $p = $_POST['password'];
  
  // bandingkan dengan MD5 dari input password
  $p_md5 = md5($p);

  // vulnerable query intentionally (lab), tapi input username di-escape
  $res = $mysqli->query("SELECT * FROM users WHERE username = '$u' AND password = '$p_md5' AND is_admin = 0 LIMIT 1");
  if($res && $res->num_rows){
    $_SESSION['user'] = $res->fetch_assoc();
    header('Location: index.php'); exit;
  } else $msg = 'Login gagal';
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container my-5">
  <h3>Login User</h3>
  <?php if($msg) echo "<div class='alert alert-danger'>$msg</div>"; ?>
  <form method="post">
    <div class="mb-3"><label>Username</label><input class="form-control" name="username" required></div>
    <div class="mb-3"><label>Password</label><input class="form-control" name="password" type="password" required></div>
    <button class="btn btn-primary">Login</button>
  </form>
</div>
</body></html>
