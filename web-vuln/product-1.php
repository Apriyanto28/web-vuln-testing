<?php
require 'db.php';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
// vulnerable to SQL injection (no prepared statements)
$res = $mysqli->query("SELECT * FROM products WHERE id = $id");
$product = $res->fetch_assoc();
?>
<!doctype html><html><head>
  <meta charset="utf-8"><title>Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body>
<div class="container my-4">
  <?php if($product): ?>
    <h2><?php echo $product['name']; // no escaping — intentional ?></h2>
    <p><?php echo $product['description']; ?></p>
    <p><strong>Rp <?php echo number_format($product['price'],2); ?></strong></p>
    <a href="cart.php?action=add&id=<?=$product['id']?>" class="btn btn-success">Tambah ke Keranjang</a>
  <?php else: ?>
    <div class="alert alert-warning">Produk tidak ditemukan.</div>
  <?php endif; ?>
</div>
</body></html>
