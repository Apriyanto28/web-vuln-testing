<?php require 'db.php'; require 'layout.php'; app_header('Produk — VulnShop'); ?>
<main class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0"><i class="bi bi-grid"></i> Daftar Produk</h3>
    <form class="d-flex" method="get" action="products.php">
      <input class="form-control form-control-sm me-2" name="q" placeholder="Cari Produk">
      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-search"></i></button>
    </form>
  </div>

  <div class="row gy-4">
    <?php
      // tetap vulnerable (SQLi lewat pencarian jika Anda mau kembangkan)
      $where = "";
      if(isset($_GET['q']) && $_GET['q']!==""){
        $q = $_GET['q']; // sengaja tidak di-escape (lab)
        $where = "WHERE name LIKE '%$q%' OR description LIKE '%$q%'";
      }
      $res = $mysqli->query("SELECT * FROM products $where ORDER BY id DESC");
      while($p = $res->fetch_assoc()):
    ?>
    <div class="col-sm-6 col-lg-4">
      <div class="card card-v product-card h-100">
        <div class="card-body">
          <h5 class="card-title"><?php echo $p['name']; // RAW ?></h5>
          <p class="card-text small"><?php echo $p['description']; // RAW ?></p>
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Rp <?php echo number_format($p['price'],2); ?></span>
            <a class="btn btn-sm btn-primary" href="product.php?id=<?=$p['id']?>"><i class="bi bi-eye"></i> Detail</a>
          </div>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</main>
<?php app_footer(); ?>
