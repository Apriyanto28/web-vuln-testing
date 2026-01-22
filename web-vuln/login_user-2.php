<?php
require 'db.php'; require 'layout.php';
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $u = $mysqli->real_escape_string($_POST['username']);
  $p = $_POST['password'];
  $p_md5 = md5($p);
  $res = $mysqli->query("SELECT * FROM users WHERE username = '$u' AND password = '$p_md5' AND is_admin = 0 LIMIT 1");
  if($res && $res->num_rows){
    $_SESSION['user'] = $res->fetch_assoc();
    header('Location: index.php?toast=1'); exit;
  } else $msg = 'Login gagal';
}
app_header('Login User');
?>
<main class="container my-5" style="max-width:520px">
  <div class="card card-v">
    <div class="card-body p-4">
      <h3 class="mb-3"><i class="bi bi-box-arrow-in-right"></i> Login User</h3>
      <?php if($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
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
      </form>
      <hr>
      <p class="small text-muted mb-0">Form ini masih rentan SQLi (sengaja untuk lab).</p>
    </div>
  </div>
</main>
<?php app_footer(); ?>
