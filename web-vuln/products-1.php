<?php
require 'db.php';
?>
<!doctype html>
<html><head>
  <meta charset="utf-8"><title>Produk - VulnShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <h2>Daftar Produk</h2>
  <div class="row">
    <?php
    $res = $mysqli->query("SELECT * FROM products");
    while($p = $res->fetch_assoc()):
    ?>
    <div class="col-md-4">
      <div class="card mb-3 product-card">
        <div class="card-body">
          <h5 class="card-title"><?php echo $p['name']; // intentionally unsanitized for testing XSS ?></h5>
          <p class="card-text"><?php echo $p['description']; // vulnerable ?></p>
          <p class="card-text"><strong>Rp <?php echo number_format($p['price'],2); ?></strong></p>
          <a href="product.php?id=<?=$p['id']?>" class="btn btn-primary">Lihat</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>
</body></html>
