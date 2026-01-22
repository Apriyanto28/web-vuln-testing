<?php
require 'db.php'; 
require 'layout.php';

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// aksi
$action = $_GET['action'] ?? '';
if($action === 'add' && isset($_GET['id'])){
  $id = (int)$_GET['id'];
  $_SESSION['cart'][] = $id;
  header('Location: cart.php?toast=1'); exit;
}
if($action === 'remove' && isset($_GET['id'])){
  $id = (int)$_GET['id'];
  $idx = array_search($id, $_SESSION['cart']); // hapus SATU kemunculan
  if($idx !== false){ unset($_SESSION['cart'][$idx]); $_SESSION['cart'] = array_values($_SESSION['cart']); }
  header('Location: cart.php'); exit;
}
if($action === 'remove_all' && isset($_GET['id'])){
  $id = (int)$_GET['id'];
  $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], fn($x) => (int)$x !== $id));
  header('Location: cart.php'); exit;
}
if($action === 'clear'){
  unset($_SESSION['cart']);
  $_SESSION['cart'] = [];
  header('Location: cart.php'); exit;
}

// siapkan data untuk render
app_header('Keranjang');
$cart = $_SESSION['cart'];
?>
<main class="container my-5">
  <h3 class="mb-3"><i class="bi bi-cart"></i> Keranjang</h3>

  <?php if(empty($cart)): ?>
    <div class="card card-v">
      <div class="card-body text-center py-5">
        <i class="bi bi-bag-x" style="font-size:3rem"></i>
        <p class="mt-3 mb-1">Keranjang kosong.</p>
        <a class="btn btn-primary" href="products.php"><i class="bi bi-grid"></i> Belanja</a>
      </div>
    </div>
  <?php else: 
      // hitung qty per product id
      $qty = [];
      foreach($cart as $pid){ $pid = (int)$pid; $qty[$pid] = ($qty[$pid] ?? 0) + 1; }
      $ids = implode(',', array_map('intval', array_keys($qty)));
      // (masih pola risk lab) - query IN ($ids)
      $res = $mysqli->query("SELECT * FROM products WHERE id IN ($ids)");
      // map id->product
      $products = [];
      while($row = $res->fetch_assoc()){ $products[(int)$row['id']] = $row; }
      $total = 0;
  ?>
    <div class="card card-v">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="fw-semibold">Ringkasan Keranjang</div>
          <div class="d-flex gap-2">
            <a class="btn btn-outline-danger btn-sm" href="cart.php?action=clear" onclick="return confirm('Kosongkan keranjang?')">
              <i class="bi bi-trash"></i> Kosongkan
            </a>
            <a class="btn btn-outline-secondary btn-sm" href="products.php"><i class="bi bi-arrow-left"></i> Lanjut Belanja</a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width:80px">ID</th>
                <th>Produk (RAW)</th>
                <th class="text-center" style="width:120px">Qty</th>
                <th class="text-end" style="width:160px">Harga</th>
                <th class="text-end" style="width:160px">Subtotal</th>
                <th style="width:190px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($qty as $pid => $q): 
                    $p = $products[$pid] ?? null;
                    if(!$p) continue;
                    $subtotal = $p['price'] * $q;
                    $total += $subtotal;
              ?>
              <tr>
                <td><?= $pid ?></td>
                <td><?php echo $p['name']; // RAW untuk lab ?></td>
                <td class="text-center">
                  <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?= $q ?></span>
                </td>
                <td class="text-end">Rp <?= number_format($p['price'],2) ?></td>
                <td class="text-end">Rp <?= number_format($subtotal,2) ?></td>
                <td class="d-flex gap-2">
                  <!-- Hapus satu -->
                  <a class="btn btn-outline-warning btn-sm" href="cart.php?action=remove&id=<?= $pid ?>" title="Hapus satu (−1)">
                    <i class="bi bi-dash-circle"></i> Hapus (−1)
                  </a>
                  <!-- Hapus semua item sejenis -->
                  <a class="btn btn-outline-danger btn-sm" href="cart.php?action=remove_all&id=<?= $pid ?>" 
                     onclick="return confirm('Hapus semua item produk ini?')">
                    <i class="bi bi-x-circle"></i> Hapus semua
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4" class="text-end">Total</th>
                <th class="text-end">Rp <?= number_format($total,2) ?></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>

        <div class="d-flex justify-content-end">
          <a class="btn btn-primary" href="checkout.php"><i class="bi bi-credit-card"></i> Checkout</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</main>
<?php app_footer(); ?>
