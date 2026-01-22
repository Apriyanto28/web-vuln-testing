<?php require 'db.php'; require 'layout.php'; app_header('Apri Shop Medan'); ?>
<header class="hero py-5">
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-lg-7">
        <h1 class="fw-bold">Apri Shop</h1>
        <p class="lead mb-4">Selamat datang di <b>Apri Shop Medan</b> belanja hemat dan tidak pakai ribet</p>
        <a class="btn btn-light btn-lg me-2" href="products.php"><i class="bi bi-grid"></i> Jelajahi Produk</a>
        <a class="btn btn-outline-light btn-lg" href="login_user.php"><i class="bi bi-box-arrow-in-right"></i> Mulai Login</a>
        <div class="mt-3"><span class="badge badge-soft rounded-pill">Mari Berbelanja</span></div>
      </div>
      <div class="col-lg-5 text-center">
        <i class="bi bi-cart4" style="font-size: 6rem;"></i>
      </div>
    </div>
  </div>
</header>

<main class="container my-5">
  <h4 class="mb-3">Produk Populer</h4>
  <div class="row gy-4">
    <?php $res = $mysqli->query("SELECT * FROM products LIMIT 6");
    while($p = $res->fetch_assoc()): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="card card-v product-card h-100">
          <div class="card-body">
            <h5 class="card-title"><?= $p['name']; // INTENTIONAL raw ?></h5>
            <p class="card-text small"><?= substr($p['description'],0,90); // raw ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-semibold">Rp <?= number_format($p['price'],2) ?></span>
              <a class="btn btn-sm btn-primary" href="product.php?id=<?= $p['id'] ?>"><i class="bi bi-eye"></i> Detail</a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</main>
<?php app_footer(); ?>
