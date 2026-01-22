<?php
require 'db.php'; require 'layout.php';
//if(!isset($_SESSION['user'])) { header('Location: login_user.php'); exit; }
if(!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$ids = $_SESSION['cart'] ?? [];
if(empty($ids)){ header('Location: cart.php'); exit; }
$ids_str = implode(',', array_map('intval', $ids));
$res = $mysqli->query("SELECT SUM(price) AS s FROM products WHERE id IN ($ids_str)");
$row = $res->fetch_assoc();
$total = $row['s'] ?: 0.0;
$items = json_encode($ids);
$mysqli->query("INSERT INTO orders (user_id, items, total) VALUES ({$_SESSION['user']['id']}, '".$mysqli->real_escape_string($items)."', $total)");
unset($_SESSION['cart']);
app_header('Checkout');
?>
<main class="container my-5" style="max-width:720px">
  <div class="card card-v">
    <div class="card-body p-4 text-center">
      <i class="bi bi-check-circle" style="font-size:3rem"></i>
      <h3 class="mt-3">Pesanan Berhasil</h3>
      <p>Total: <b>Rp <?= number_format($total,2) ?></b></p>
      <a class="btn btn-primary" href="index.php"><i class="bi bi-house"></i> Kembali ke Beranda</a>
    </div>
  </div>
</main>
<?php app_footer(); ?>
