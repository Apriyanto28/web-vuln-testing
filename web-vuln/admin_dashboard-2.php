<?php
require 'db.php'; require 'layout.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }
app_header('Admin Dashboard');
?>
<main class="container my-5">
  <h3 class="mb-3"><i class="bi bi-speedometer2"></i> Admin Dashboard</h3>
  <div class="card card-v">
    <div class="card-body">
      <p class="mb-3">Selamat datang, <?php echo $_SESSION['user']['fullname']; // RAW ?></p>
      <h5>Daftar Pesanan</h5>
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead><tr><th>ID</th><th>User ID</th><th>Items</th><th>Total</th><th>Tgl</th></tr></thead>
          <tbody>
            <?php $res = $mysqli->query("SELECT * FROM orders ORDER BY created_at DESC");
            while($o = $res->fetch_assoc()): ?>
              <tr>
                <td><?= $o['id'] ?></td>
                <td><?= $o['user_id'] ?></td>
                <td><?= $o['items'] // RAW ?></td>
                <td>Rp <?= number_format($o['total'],2) ?></td>
                <td><?= $o['created_at'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <div class="alert alert-warning small mt-3 mb-0">
        Halaman ini tidak memiliki header anti-iframe &rarr; dapat diuji untuk <b>clickjacking</b>.
      </div>
    </div>
  </div>
</main>
<?php app_footer(); ?>
