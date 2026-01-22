<?php
require 'db.php';
if(!isset($_SESSION['user'])) { header('Location: login_user.php'); exit; }
?>
<!doctype html><html><head><meta charset="utf-8"><title>Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container my-4">
  <h2>Profile</h2>
  <p><strong>Nama:</strong> <?php echo $_SESSION['user']['fullname']; // unsanitized ?></p>
  <p><strong>Email:</strong> <?php echo $_SESSION['user']['email']; ?></p>

  <h4>Edit Bio (stored XSS demo)</h4>
  <?php
  // using users.fullname column as demo: allow update (this is vulnerable)
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fullname = $_POST['fullname'];
    $id = (int)$_SESSION['user']['id'];
    $mysqli->query("UPDATE users SET fullname = '".$mysqli->real_escape_string($fullname)."' WHERE id = $id");
    // refresh session
    $r = $mysqli->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
    $_SESSION['user'] = $r;
    echo "<div class='alert alert-success'>Updated</div>";
  }
  ?>
  <form method="post">
    <div class="mb-3">
      <label>Nama Lengkap</label>
      <input class="form-control" name="fullname" value="<?php echo $_SESSION['user']['fullname']; ?>">
    </div>
    <button class="btn btn-primary">Simpan</button>
  </form>
</div>
</body></html>
