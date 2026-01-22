<?php
require 'db.php';
if(!isset($_SESSION['user'])) { die('Silakan login dulu'); }

$id = isset($_GET['id']) ? $_GET['id'] : 0;  // sengaja tanpa validasi → SQLi demo
$order = $mysqli->query("SELECT * FROM orders WHERE id = $id")->fetch_assoc();
if(!$order) die('Order tidak ditemukan.');

// Parse items (contoh format: [1,2,3])
$item_ids = trim($order['items'], "[]");
$item_list = $item_ids ? explode(",", $item_ids) : [];

// Ambil semua produk berdasarkan ID di atas
$products = [];
if (!empty($item_list)) {
  $ids = implode(",", $item_list); // RAW untuk SQLi test
  $q = $mysqli->query("SELECT * FROM products WHERE id IN ($ids)");
  while($r = $q->fetch_assoc()) $products[] = $r;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Order Detail — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
  <style>
    .card-v { border:none; border-radius:12px; box-shadow:0 8px 26px rgba(0,0,0,.06); }
    .table thead th { background:#eef3ff; font-weight:600; }
  </style>
</head>
<body class="bg-light">

<div class="container my-4" style="max-width:900px;">
  <div class="card card-v">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bi bi-receipt"></i> Detail Order #<?= $order['id'] ?></h4>
        <a class="btn btn-outline-secondary btn-sm" href="admin_dashboard.php#orders">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>

      <div class="mb-4">
        <table class="table table-sm w-auto">
          <tr><th>ID Pesanan</th><td><?= $order['id'] ?></td></tr>
          <tr><th>User ID</th><td><?= $order['user_id'] ?></td></tr>
          <!--<tr><th>Items</th><td><?php echo $order['items']; // sengaja RAW ?></td></tr>-->
          <!--<tr><th>Total</th><td>$ <?= number_format($order['total'], 2) ?></td></tr> -->
          <tr><th>Tanggal</th><td><?= $order['created_at'] ?></td></tr>
        </table>
      </div>

      <h5 class="mb-3"><i class="bi bi-box-seam"></i> Produk dalam Pesanan</h5>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th style="width:60px">ID</th>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th class="text-end" style="width:140px">Harga</th>
            </tr>
          </thead>
          <tbody>
            <?php if(empty($products)): ?>
              <tr><td colspan="4" class="text-center text-muted">Tidak ada produk.</td></tr>
            <?php else: ?>
              <?php foreach($products as $p): ?>
              <tr>
                <td><?= $p['id'] ?></td>
                <td><?php echo $p['name']; // RAW ?></td>
                <td><?php echo $p['description']; // RAW ?></td>
                <td class="text-end">$ <?= number_format($p['price'],2) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        <strong>Total: $ <?= number_format($order['total'],2) ?></strong>
      </div>
<!--
      <div class="alert alert-warning small mt-4 mb-0">
        <b>LAB Mode:</b> parameter <code>id</code> dipakai langsung di SQL (rentan SQL Injection),  
        kolom <b>Items/Name/Description</b> ditampilkan tanpa escaping (rentan XSS),  
        dan tidak ada validasi session admin. Gunakan hanya untuk pengujian keamanan.
      </div>
-->
    </div>
  </div>
</div>

</body>
</html>
