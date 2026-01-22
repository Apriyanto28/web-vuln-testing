<?php
// order_history.php — riwayat pesanan user biasa
require 'db.php';
require 'layout.php';
#app_header('Apri Shop Medan');

if(!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
// Khusus user biasa saja
if($_SESSION['user']['is_admin']) { die('Halaman ini khusus untuk user biasa.'); }

$user = $_SESSION['user'];
$uid  = (int)$user['id'];

// Ambil riwayat order user saat ini
$res = $mysqli->query("SELECT * FROM orders WHERE user_id = $uid ORDER BY created_at DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Riwayat Pesanan — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
  <style>
    .card-v{border:none;border-radius:12px;box-shadow:0 8px 26px rgba(0,0,0,.06);}
    .table thead th{background:#eef3ff;font-weight:600;}
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#0d6efd;">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-shield-lock"></i> Apri Shop</a>
    <div class="ms-auto">
      <a class="btn btn-outline-light btn-sm" href="user_profile.php"><i class="bi bi-person"></i> Profile</a>
    </div>
  </div>
</nav>

<div class="container my-4" style="max-width:980px">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Pesanan</h4>
    <a class="btn btn-outline-secondary btn-sm" href="index.php"><i class="bi bi-house"></i> Beranda</a>
  </div>

  <div class="card card-v">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th style="width:80px">ID</th>
              <th>Items (RAW)</th>
              <th class="text-end" style="width:160px">Total</th>
              <th style="width:180px">Tanggal</th>
              <th style="width:120px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if($res && $res->num_rows): ?>
              <?php while($o = $res->fetch_assoc()): ?>
              <tr>
                <td><?= $o['id'] ?></td>
                <td><?php echo $o['items']; // RAW untuk lab ?></td>
                <td class="text-end">Rp <?= number_format($o['total'],2) ?></td>
                <td><?= $o['created_at'] ?></td>
                <td>
                  <a class="btn btn-sm btn-success" href="order_detail.php?id=<?= $o['id'] ?>">
                    <i class="bi bi-eye"></i> Detail
                  </a>
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5" class="text-center text-muted">Belum ada pesanan.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
<!--
      <div class="alert alert-warning small mb-0 mt-3">
        <b>LAB:</b> Kolom <em>items</em> ditampilkan tanpa escaping (XSS demo). Query tanpa prepared statements.
      </div>
-->
    </div>
  </div>
</div>

</body>
</html>
