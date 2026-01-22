<?php
require 'db.php'; require 'layout.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;              // RAW (vulnerable)
$res = $mysqli->query("SELECT * FROM products WHERE id = $id"); // SQLi demo
$product = $res ? $res->fetch_assoc() : null;

app_header('Detail Produk');
?>
<main class="container my-5" style="max-width:980px">
  <?php if($product): ?>
  <!-- Kartu utama (1 kolom) -->
  <div class="card card-v mb-4">
    <div class="card-body p-4">
      <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
          <h2 class="mb-1"><?php echo $product['name']; // RAW ?></h2>
          <div class="text-warning mb-2">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            <i class="bi bi-star"></i>
            <span class="small text-muted ms-2">4.0 • 120 ulasan</span>
          </div>
          <p class="text-muted mb-3"><?php echo $product['description']; // RAW ?></p>
        </div>
        <div class="text-end">
          <div class="small text-muted">Harga</div>
          <div class="display-6 mb-2" style="line-height:1">$ <?php echo number_format($product['price'],2); ?></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle">
            <i class="bi bi-box-seam"></i> Stok: Ada
          </span>
        </div>
      </div>

      <hr class="my-4">

      <!-- Aksi (qty + tombol) -->
      <div class="d-flex flex-wrap align-items-center gap-3">
        <div>
          <label class="form-label small mb-1">Kuantitas</label>
          <div class="input-group" style="max-width:220px">
            <button class="btn btn-outline-secondary" type="button" id="qtyMinus"><i class="bi bi-dash"></i></button>
            <input type="number" class="form-control text-center" id="qty" value="1" min="1">
            <button class="btn btn-outline-secondary" type="button" id="qtyPlus"><i class="bi bi-plus"></i></button>
          </div>
        </div>
        <div class="flex-grow-1"></div>
        <div class="d-flex flex-wrap gap-2">
          <a id="btnAdd" class="btn btn-success"
             href="cart.php?action=add&id=<?= $product['id'] ?>">
            <i class="bi bi-bag-plus"></i> Tambah ke Keranjang
          </a>
          <a id="btnBuy" class="btn btn-outline-primary"
             href="cart.php?action=add&id=<?= $product['id'] ?>">
            <i class="bi bi-lightning-charge"></i> Beli Sekarang
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Info pendukung (masih 1 kolom, ditumpuk) -->
  <div class="row g-3">
    <div class="col-12">
      <div class="card card-v">
        <div class="card-body">
          <h5 class="mb-2"><i class="bi bi-truck"></i> Pengiriman</h5>
          <div class="small text-muted">Estimasi 1–3 hari kerja · Ongkir dihitung saat checkout.</div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card card-v">
        <div class="card-body">
          <h5 class="mb-2"><i class="bi bi-arrow-counterclockwise"></i> Garansi & Retur</h5>
          <div class="small text-muted">Garansi 7 hari — tukar/retur jika barang cacat.</div>
        </div>
      </div>
    </div>
<!--
    <div class="col-12">
      <div class="card card-v">
        <div class="card-body">
          <h5 class="mb-2"><i class="bi bi-shield-exclamation"></i> Info Uji Keamanan</h5>
          <ul class="small mb-0">
            <li>Parameter <code>id</code> langsung ke SQL (SQL Injection demo).</li>
            <li>Judul & deskripsi ditampilkan tanpa escaping (Reflected/Stored XSS demo jika data terkontaminasi).</li>
            <li>Header anti-iframe tidak diaktifkan (.htaccess) → clickjacking dapat diuji.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  -->

  <?php else: ?>
    <div class="alert alert-warning">Produk tidak ditemukan.</div>
  <?php endif; ?>
</main>

<script>
// Kendali qty + sisipkan qty ke URL tombol
const qtyInput = document.getElementById('qty');
const minusBtn = document.getElementById('qtyMinus');
const plusBtn  = document.getElementById('qtyPlus');
const btnAdd   = document.getElementById('btnAdd');
const btnBuy   = document.getElementById('btnBuy');

const clamp = v => Math.max(1, parseInt(v||'1',10));
function syncLinks(){
  const q = clamp(qtyInput.value);
  const addBase = btnAdd.dataset.base || btnAdd.href.split('?')[0] + '?action=add&id=<?= (int)$id ?>';
  const buyBase = btnBuy.dataset.base || btnBuy.href.split('?')[0] + '?action=add&id=<?= (int)$id ?>';
  btnAdd.dataset.base = addBase; btnBuy.dataset.base = buyBase;
  btnAdd.href = addBase + '&qty=' + q + '#ok';
  btnBuy.href = buyBase + '&qty=' + q + '#ok';
}
minusBtn && minusBtn.addEventListener('click', () => { qtyInput.value = clamp(qtyInput.value) - 1; syncLinks(); });
plusBtn  && plusBtn.addEventListener('click',  () => { qtyInput.value = clamp(qtyInput.value) + 1; syncLinks(); });
qtyInput && qtyInput.addEventListener('input', syncLinks);
syncLinks();
</script>
<?php app_footer(); ?>
