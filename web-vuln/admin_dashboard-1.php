<?php
require 'db.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container my-4">
  <h2>Admin Dashboard</h2>
  <p>Selamat datang, <?php echo $_SESSION['user']['fullname']; // unsanitized ?></p>
  <h4>Daftar Pesanan</h4>
  <table class="table">
    <thead><tr><th>ID</th><th>User ID</th><th>Items</th><th>Total</th><th>Tgl</th></tr></thead>
    <tbody>
      <?php $res = $mysqli->query("SELECT * FROM orders ORDER BY created_at DESC");
      while($o = $res->fetch_assoc()): ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= $o['user_id'] ?></td>
          <td><?= $o['items'] ?></td>
          <td><?= number_format($o['total'],2) ?></td>
          <td><?= $o['created_at'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body></html>
