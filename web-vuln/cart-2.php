<?php
require 'db.php'; require 'layout.php';
$action = $_GET['action'] ?? '';
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if($action === 'add' && isset($_GET['id'])){
  $id = (int)$_GET['id']; // cast ringan
  $_SESSION['cart'][] = $id;
  header('Location: cart.php?toast=1'); exit;
}

app_header('Keranjang');
?>
<main class="container my-5">
  <h3 class="mb-3"><i class="bi bi-cart"></i> Keranjang</h3>
  <?php if(empty($_SESSION['cart'])): ?>
    <div class="card card-v">
      <div class="card-body text-center py-5">
        <i class="bi bi-bag-x" style="font-size:3rem"></i>
        <p class="mt-3">Keranjang kosong.</p>
        <a class="btn btn-primary" href="products.php"><i class="bi bi-grid"></i> Belanja</a>
      </div>
    </div>
  <?php else:
      $ids = implode(',', array_map('intval', $_SESSION['cart']));
      $res = $mysqli->query("SELECT * FROM products WHERE id IN ($ids)"); // (tetap pola risk)
      $total = 0;
  ?>
    <div class="card card-v">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead><tr><th>Produk</th><th class="text-end">Harga</th></tr></thead>
            <tbody>
              <?php while($row = $res->fetch_assoc()): $total += $row['price']; ?>
              <tr>
                <td><?php echo $row['name']; // RAW ?></td>
                <td class="text-end">Rp <?php echo number_format($row['price'],2); ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Total</th>
                <th class="text-end">Rp <?= number_format($total,2) ?></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="d-flex justify-content-between">
          <a class="btn btn-outline-secondary" href="products.php"><i class="bi bi-arrow-left"></i> Lanjut Belanja</a>
          <a class="btn btn-primary" href="checkout.php"><i class="bi bi-credit-card"></i> Checkout</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</main>
<?php app_footer(); ?>
