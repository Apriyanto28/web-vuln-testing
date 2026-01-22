<?php
require 'db.php'; require 'layout.php';
$id = isset($_GET['id']) ? $_GET['id'] : 0; // RAW (vulnerable)
$res = $mysqli->query("SELECT * FROM products WHERE id = $id"); // SQLi sengaja
$product = $res ? $res->fetch_assoc() : null;
app_header('Detail Produk');
?>
<main class="container my-5">
  <?php if($product): ?>
    <div class="row gy-4">
      <div class="col-lg-7">
        <div class="card card-v">
          <div class="card-body">
            <h3 class="mb-2"><?php echo $product['name']; // RAW ?></h3>
            <p class="text-muted"><?php echo $product['description']; // RAW ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 mb-0">Rp <?php echo number_format($product['price'],2); ?></span>
              <a class="btn btn-success" href="cart.php?action=add&id=<?=$product['id']?>&toast=1">
                <i class="bi bi-bag-plus"></i> Tambah ke Keranjang
              </a>
            </div>
          </div>
        </div>
      </div>
      <aside class="col-lg-5">
        <div class="card card-v">
          <div class="card-body">
            <h5>Info Uji Keamanan</h5>
            <ul class="small mb-0">
              <li>Parameter <code>id</code> langsung ke SQL (SQL Injection demo).</li>
              <li>Judul & deskripsi ditampilkan tanpa escaping (Reflected/Stored XSS demo jika data terkontaminasi).</li>
              <li>Header anti-iframe tidak diaktifkan (.htaccess) → clickjacking dapat diuji.</li>
            </ul>
          </div>
        </div>
      </aside>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">Produk tidak ditemukan.</div>
  <?php endif; ?>
</main>
<?php app_footer(); ?>
