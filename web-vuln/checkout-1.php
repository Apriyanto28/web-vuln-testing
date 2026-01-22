<?php
require 'db.php';
if(!isset($_SESSION['user'])) {
  header('Location: login_user.php'); exit;
}
$user = $_SESSION['user'];

$ids = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if(empty($ids)){
  header('Location: cart.php'); exit;
}
$items = json_encode($ids);
$total = 0;
$ids_str = implode(',', array_map('intval', $ids));
$res = $mysqli->query("SELECT SUM(price) AS s FROM products WHERE id IN ($ids_str)");
$row = $res->fetch_assoc();
$total = $row['s'] ?: 0.0;

// vulnerable insert (no prepared)
$mysqli->query("INSERT INTO orders (user_id, items, total) VALUES ({$user['id']}, '".$mysqli->real_escape_string($items)."', $total)");
unset($_SESSION['cart']);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container my-4">
  <div class="alert alert-success">Pesanan berhasil dibuat. Total: Rp <?=number_format($total,2)?></div>
  <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
</div>
</body></html>
