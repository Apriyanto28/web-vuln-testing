<?php
require 'db.php';
$action = isset($_GET['action']) ? $_GET['action'] : '';
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if($action == 'add' && isset($_GET['id'])){
  $id = (int)$_GET['id'];
  $_SESSION['cart'][] = $id;
  header('Location: cart.php'); exit;
}
?>
<!doctype html><html><head>
  <meta charset="utf-8"><title>Keranjang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body>
<div class="container my-4">
  <h2>Keranjang Anda</h2>
  <?php if(empty($_SESSION['cart'])): ?>
    <div class="alert alert-info">Keranjang kosong.</div>
  <?php else: ?>
    <ul class="list-group mb-3">
      <?php
      $ids = implode(',', array_map('intval', $_SESSION['cart']));
      $res = $mysqli->query("SELECT * FROM products WHERE id IN ($ids)");
      while($row = $res->fetch_assoc()):
      ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <?php echo $row['name']; ?>
          <span>Rp <?php echo number_format($row['price'],2); ?></span>
        </li>
      <?php endwhile; ?>
    </ul>
    <a href="checkout.php" class="btn btn-primary">Checkout</a>
  <?php endif; ?>
</div>
</body></html>
