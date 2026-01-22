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
    <!-- LEFT: Deskripsi produk -->
    <div class="col-lg-8">
      <div class="card card-v">
        <div class="card-body">
          <h2 class="mb-2"><?php echo $product['name']; // RAW ?></h2>
          <p class="text-muted"><?php echo $product['description']; // RAW ?></p>

          <div class="d-flex flex-wrap gap-3 align-items-center mt-3">
            <span class="h4 mb-0">Rp <?php echo number_format($product['price'],2); ?></span>
            <span class="badge bg-success-subtle text-success border border-success-subtle">
              <i class="bi bi-stars"></i> Best Seller
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Aside ala e-commerce -->
    <aside class="col-lg-4">
      <div class="card card-v">
        <div class="card-body">
          <!-- Price -->
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
              <div class="text-muted small">Harga</div>
              <div class="h4 mb-0">Rp <?php echo number_format($product['price'],2); ?></div>
            </div>
            <div class="text-warning">
              <!-- rating statis untuk tampilan -->
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star"></i>
            </div>
          </div>

          <!-- Stok / SKU dummy -->
          <div class="d-flex gap-3 align-items-center mb-3">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
              Stok: Ada
            </span>
            <span class="small text-muted">SKU: P-<?php echo (int)$product['id']; ?></span>
          </div>

          <!-- Qty + Add to cart -->
          <div class="mb-3">
            <label class="form-label small mb-1">Kuantitas</label>
            <div class="input-group" style="max-width:200px">
              <button class="btn btn-outline-secondary" type="button" id="qtyMinus"><i class="bi bi-dash"></i></button>
              <input type="number" class="form-control text-center" id="qty" value="1" min="1">
              <button class="btn btn-outline-secondary" type="button" id="qtyPlus"><i class="bi bi-plus"></i></button>
            </div>
          </div>

          <div class="d-grid gap-2 mb-3">
            <!-- Add to cart menggunakan qty -->
            <a id="btnAdd" class="btn btn-success"
               href="cart.php?action=add&id=<?= $product['id'] ?>">
              <i class="bi bi-bag-plus"></i> Tambah ke Keranjang
            </a>
            <a id="btnBuy" class="btn btn-outline-primary"
               href="cart.php?action=add&id=<?= $product['id'] ?>">
              <i class="bi bi-lightning-charge"></i> Beli Sekarang
            </a>
          </div>

          <!-- Info pengiriman & retur -->
          <div class="border rounded p-3 mb-3 bg-light">
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-truck me-2"></i>
              <strong>Pengiriman</strong>
            </div>
            <div class="small text-muted">
              Estimasi 1–3 hari kerja · Ongkir dihitung saat checkout.
            </div>
            <hr>
            <div class="d-flex align-items-center mb-1">
              <i class="bi bi-arrow-counterclockwise me-2"></i>
              <strong>Garansi & Retur</strong>
            </div>
            <div class="small text-muted">
              Garansi 7 hari: tukar/retur jika barang cacat.
            </div>
          </div>

          <!-- Metode pembayaran (dummy ikon) -->
          <div class="mb-3">
            <div class="small text-muted mb-1">Metode Pembayaran</div>
            <div class="d-flex flex-wrap gap-2">
              <span class="badge bg-dark-subtle text-dark">Transfer</span>
              <span class="badge bg-dark-subtle text-dark">VA</span>
              <span class="badge bg-dark-subtle text-dark">E-Wallet</span>
              <span class="badge bg-dark-subtle text-dark">COD*</span>
            </div>
          </div>

          <!-- Share / Wishlist (dummy) -->
          <div class="d-flex justify-content-between">
            <a class="btn btn-outline-secondary btn-sm" href="#" onclick="alert('Demo share');return false;">
              <i class="bi bi-share"></i> Bagikan
            </a>
            <a class="btn btn-outline-danger btn-sm" href="#" onclick="alert('Demo wishlist');return false;">
              <i class="bi bi-heart"></i> Wishlist
            </a>
          </div>

          <div class="alert alert-warning small mt-3 mb-0">
            <strong>LAB:</strong> parameter <code>id</code> langsung ke SQL (SQLi), judul/deskripsi ditampilkan RAW (XSS), header anti-iframe tidak aktif (.htaccess).
          </div>
        </div>
      </div>
    </aside>
  </div>
  <?php else: ?>
    <div class="alert alert-warning">Produk tidak ditemukan.</div>
  <?php endif; ?>
</main>

<script>
// Qty control + rakit URL dengan qty
const qtyInput = document.getElementById('qty');
const minusBtn = document.getElementById('qtyMinus');
const plusBtn  = document.getElementById('qtyPlus');
const btnAdd   = document.getElementById('btnAdd');
const btnBuy   = document.getElementById('btnBuy');

const clamp = v => Math.max(1, parseInt(v||'1',10));
function syncLinks(){
  const q = clamp(qtyInput.value);
  // tambahkan param qty agar cart bisa menambahkan beberapa item sekaligus (lihat patch di bawah)
  if(btnAdd) btnAdd.href = btnAdd.href.replace(/([&?])qty=\d+/,'$1').split('#')[0] + '&qty=' + q + '#ok';
  if(btnBuy) btnBuy.href = btnBuy.href.replace(/([&?])qty=\d+/,'$1').split('#')[0] + '&qty=' + q + '#ok';
}
minusBtn && minusBtn.addEventListener('click', () => { qtyInput.value = clamp(qtyInput.value) - 1; syncLinks(); });
plusBtn  && plusBtn.addEventListener('click',  () => { qtyInput.value = clamp(qtyInput.value) + 1; syncLinks(); });
qtyInput && qtyInput.addEventListener('input', syncLinks);
syncLinks();
</script>
<?php app_footer(); ?>
