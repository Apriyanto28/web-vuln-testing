<?php
require 'db.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  // Tetap LAB: tanpa prepared statement, sebagian RAW
  $name  = $_POST['name'];                      // RAW (XSS demo)
  $desc  = $_POST['description'];               // RAW (XSS demo)
  $price = $_POST['price'];                     // tidak divalidasi (SQLi/logic issue demo)

  if($name === '' || $price === ''){
    $msg = 'Nama & Harga wajib diisi';
  } else {
    // hanya escape ringan untuk karakter khusus tertentu, tetap bisa dieksploitasi lewat payload lain
    $sql = "INSERT INTO products (name, description, price)
            VALUES ('".$mysqli->real_escape_string($name)."',
                    '".$mysqli->real_escape_string($desc)."',
                    $price)";
    if($mysqli->query($sql)){
      header('Location: admin_dashboard.php#products'); exit;
    } else {
      $msg = 'Gagal: '.$mysqli->error;
    }
  }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><title>Tambah Product — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-4" style="max-width:720px">
  <div class="card card-v">
    <div class="card-body p-4">
      <h4 class="mb-3"><i class="bi bi-box-seam"></i> Tambah Product</h4>
      <?php if($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama</label>
          <input class="form-control" name="name" placeholder="Nama produk">
          <!--<div class="form-text">Ditampilkan tanpa escaping (stored XSS demo).</div>-->
        </div>
        <div class="col-md-6">
          <label class="form-label">Harga</label>
          <input class="form-control" name="price" placeholder="99.99">
        </div>
        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea class="form-control" name="description" rows="4" placeholder="Deskripsi singkat"></textarea>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
          <a class="btn btn-outline-secondary" href="admin_dashboard.php#products"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
      </form>
      <!-- <div class="alert alert-warning mt-3 small mb-0">LAB mode: tanpa prepared statements, output RAW, validasi minimal.</div> -->
    </div>
  </div>
</div>
</body>
</html>
