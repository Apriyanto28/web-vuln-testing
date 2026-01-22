<?php
require 'db.php';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>VulnShop - Demo E-Commerce (Lab)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">VulnShop</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="user_profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang</a></li>
          <?php if($_SESSION['user']['is_admin']): ?>
            <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login_user.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="login_admin.php">Admin Login</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="products.php">Produk</a></li>
      </ul>
    </div>
  </div>
</nav>

<header class="bg-light py-5">
  <div class="container text-center">
    <h1 class="display-6">Selamat datang di VulnShop</h1>
    <p class="lead">Situs demo rentan untuk tujuan pengujian keamanan (lab lokal saja).</p>
    <a class="btn btn-primary" href="products.php">Lihat Produk</a>
  </div>
</header>

<div class="container my-5">
  <div class="row">
    <?php
    $res = $mysqli->query("SELECT * FROM products LIMIT 3");
    while($p = $res->fetch_assoc()):
    ?>
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title"><?=htmlspecialchars($p['name'])?></h5>
            <p class="card-text"><?=htmlspecialchars(substr($p['description'],0,80))?>...</p>
            <p><strong>Rp <?=number_format($p['price'],2)?></strong></p>
            <a href="product.php?id=<?=$p['id']?>" class="btn btn-outline-primary">Detail</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<footer class="bg-light py-3 text-center">Demo VulnShop &copy; Lab</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
