<?php
require 'db.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }

$id = isset($_GET['id']) ? $_GET['id'] : 0;  // RAW → SQLi demo
$prod = $mysqli->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
if(!$prod){ die('Produk tidak ditemukan'); }

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $name  = $_POST['name'];                   // RAW (XSS demo)
  $desc  = $_POST['description'];            // RAW (XSS demo)
  $price = $_POST['price'];

  $sql = "UPDATE products SET
            name='".$mysqli->real_escape_string($name)."',
            description='".$mysqli->real_escape_string($desc)."',
            price=$price
          WHERE id=$id";                      // tetap RAW
  if($mysqli->query($sql)){
    header('Location: admin_dashboard.php#products'); exit;
  } else {
    $msg = 'Gagal: '.$mysqli->error;
  }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><title>Edit Product — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-4" style="max-width:720px">
  <div class="card card-v">
    <div class="card-body p-4">
      <h4 class="mb-3"><i class="bi bi-pencil-square"></i> Edit Product #<?= $prod['id'] ?></h4>
      <?php if($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama</label>
          <input class="form-control" name="name" value="<?php echo $prod['name']; // RAW ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Harga</label>
          <input class="form-control" name="price" value="<?= $prod['price'] ?>">
        </div>
        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea class="form-control" name="description" rows="5"><?php echo $prod['description']; // RAW ?></textarea>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-success"><i class="bi bi-save"></i> Update</button>
          <a class="btn btn-outline-secondary" href="admin_dashboard.php#products"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
      </form>
      <!-- <div class="alert alert-warning mt-3 small mb-0">LAB mode: parameter <code>id</code> dipakai langsung di SQL; output RAW.</div> -->
    </div>
  </div>
</div>
</body>
</html>
