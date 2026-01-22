<?php
require 'db.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }

// Ambil data ringkas untuk kartu ringkasan
$users_total   = $mysqli->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'] ?? 0;
$orders_total  = $mysqli->query("SELECT COUNT(*) c FROM orders")->fetch_assoc()['c'] ?? 0;
$products_total= $mysqli->query("SELECT COUNT(*) c FROM products")->fetch_assoc()['c'] ?? 0;

// Latest 8 rows untuk tiap tabel (RAW output sebagian untuk tujuan lab)
$users_res   = $mysqli->query("SELECT id, username, fullname, email, is_admin FROM users ORDER BY id DESC LIMIT 8");
$orders_res  = $mysqli->query("SELECT id, user_id, items, total, created_at FROM orders ORDER BY id DESC LIMIT 8");
$products_res= $mysqli->query("SELECT id, name, price, description FROM products ORDER BY id DESC LIMIT 8");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard — Apri Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
  <style>
    /* --- gaya dashboard mirip screenshot --- */
    .admin-shell{min-height:100vh; display:grid; grid-template-columns:260px 1fr; background:#f4f6fb;}
    .admin-sidebar{background:#3b2b8c; color:#fff;}
    .admin-sidebar .brand{padding:18px 20px; font-weight:700; font-size:1.15rem; display:flex; align-items:center; gap:.5rem;}
    .admin-sidebar .nav-link{color:#cfd3ff; padding:.65rem 1rem; border-radius:.5rem; margin:.15rem .5rem;}
    .admin-sidebar .nav-link.active, .admin-sidebar .nav-link:hover{background:#5a48d6; color:#fff;}
    .admin-topbar{background:#5a48d6; color:#fff; padding:.75rem 1rem; display:flex; align-items:center; justify-content:space-between;}
    .chip{display:inline-flex; align-items:center; gap:.35rem; padding:.35rem .6rem; border-radius:999px; font-size:.8rem;}
    .chip-blue{background:#eaf2ff; color:#2a5bd7;}
    .card-v{border:none; border-radius:12px; box-shadow:0 8px 26px rgba(0,0,0,.06); background:#fff;}
    .table thead th{background:#eef3ff; font-weight:600;}
    .toggle-badge{display:inline-block; width:44px; height:24px; background:#e9ecef; border-radius:24px; position:relative;}
    .toggle-badge::after{content:""; position:absolute; top:3px; left:3px; width:18px; height:18px; border-radius:50%; background:#adb5bd; transition:.2s;}
    .toggle-badge.on{background:#4cc9f0;}
    .toggle-badge.on::after{left:23px; background:#fff;}
    @media (max-width: 992px){ .admin-shell{grid-template-columns: 1fr;} .admin-sidebar{display:none;} }
  </style>
</head>
<body>

<div class="admin-shell">
  <!-- Sidebar -->
  <aside class="admin-sidebar">
    <div class="brand"><i class="bi bi-shield-lock"></i> ApriShop</div>
    <nav class="nav flex-column px-2 pb-3">
      <div class="text-uppercase small px-2 mb-1" style="opacity:.7">Website</div>
      <a class="nav-link" href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
      <a class="nav-link" href="admin_dashboard.php#users"><i class="bi bi-people me-2"></i>User</a>
      <a class="nav-link" href="admin_dashboard.php#products"><i class="bi bi-box-seam me-2"></i>Product</a>
      <a class="nav-link" href="admin_dashboard.php#orders"><i class="bi bi-receipt me-2"></i>Order</a>

      <div class="text-uppercase small px-2 mt-3 mb-1" style="opacity:.7">Pengaturan</div>
      <a class="nav-link" href="user_profile.php"><i class="bi bi-person-gear me-2"></i>Admin Profile</a>
      <a class="nav-link" href="index.php"><i class="bi bi-shop me-2"></i>Ke Toko</a>
      <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </nav>
  </aside>

  <!-- Konten -->
  <main>
    <!-- Topbar -->
    <div class="admin-topbar">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-light btn-sm d-lg-none" onclick="document.querySelector('.admin-sidebar').style.display='block'"><i class="bi bi-list"></i></button>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-white text-decoration-none" href="#">Home</a></li>
            <li class="breadcrumb-item text-white-50">Module Manager</li>
          </ol>
        </nav>
      </div>
      <div class="d-flex align-items-center gap-3">
        <a class="text-white opacity-75" href="user_profile.php" title="Profile"><i class="bi bi-person-circle fs-5"></i></a>
      </div>
    </div>

    <div class="container py-4">
      <h4 class="mb-3">Dashboard</h4>

      <!-- Ringkasan -->
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <div class="card-v p-3 d-flex flex-row align-items-center justify-content-between">
            <div>
              <div class="text-muted small">Total User</div>
              <div class="h4 mb-0"><?= $users_total ?></div>
            </div>
            <span class="chip chip-blue"><i class="bi bi-people"></i> User</span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-v p-3 d-flex flex-row align-items-center justify-content-between">
            <div>
              <div class="text-muted small">Total Order</div>
              <div class="h4 mb-0"><?= $orders_total ?></div>
            </div>
            <span class="chip chip-blue"><i class="bi bi-receipt"></i> Order</span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-v p-3 d-flex flex-row align-items-center justify-content-between">
            <div>
              <div class="text-muted small">Total Product</div>
              <div class="h4 mb-0"><?= $products_total ?></div>
            </div>
            <span class="chip chip-blue"><i class="bi bi-box-seam"></i> Product</span>
          </div>
        </div>
      </div>

      <!-- Tabel Users -->
      <section id="users" class="card-v mb-4">
        <div class="p-3 border-bottom bg-white">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0"><i class="bi bi-people me-1"></i> Daftar User</h5>
            <a class="btn btn-success btn-sm" href="user_add.php"><i class="bi bi-plus-lg"></i> Tambah User</a>
          </div>
        </div>
        <div class="p-3">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th style="width:70px">ID</th>
                  <th>Username</th>
                  <th>Nama Lengkap</th>
                  <th>Email</th>
                  <th style="width:90px">Admin</th>
                  <th style="width:120px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while($u = $users_res->fetch_assoc()): ?>
                  <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= $u['username'] ?></td>
                    <td><?php echo $u['fullname']; // RAW: demo stored XSS bila field tercemar ?></td>
                    <td><?= $u['email'] ?></td>
                    <td>
                      <span class="toggle-badge <?= $u['is_admin'] ? 'on':'' ?>" title="<?= $u['is_admin']?'Admin':'User' ?>"></span>
                    </td>
                    <td>
                      <a class="btn btn-sm btn-success" href="user_edit.php?id=<?= $u['id'] ?>"><i class="bi bi-pencil-square"></i> Edit</a>
                      <a class="btn btn-sm btn-danger" href="user_delete.php?id=<?= $u['id'] ?>" onclick="return confirm('Yakin untuk menghapus user <?= $u['username'] ?>?')"><i class="bi bi-trash"></i> Del</a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Tabel Orders -->
      <section id="orders" class="card-v mb-4">
        <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bi bi-receipt me-1"></i> Daftar Order</h5>
          <a class="btn btn-outline-primary btn-sm" href="#"><i class="bi bi-arrow-repeat"></i> Refresh</a>
        </div>
        <div class="p-3">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th style="width:170px">Order ID</th>
                  <th>User ID</th>
                  <!--<th>Items</th>-->
                  <th>Total</th>
                  <th style="width:170px">Tanggal</th>
                  <th style="width:120px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while($o = $orders_res->fetch_assoc()): ?>
                  <tr>
                    <td><?= $o['id'] ?></td>
                    <td><?= $o['user_id'] ?></td>
                    <!--<td><?php echo $o['items']; // RAW ?></td>-->
                    <td>$ <?= number_format($o['total'],2) ?></td>
                    <td><?= $o['created_at'] ?></td>
                    <td>
                        <a class="btn btn-sm btn-success" href="order_detail.php?id=<?= $o['id'] ?>">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Tabel Products -->
      <section id="products" class="card-v mb-4">
        <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bi bi-box-seam me-1"></i> Daftar Product</h5>
          <a class="btn btn-success btn-sm" href="product_add.php"><i class="bi bi-plus-lg"></i> Tambah Product</a>
        </div>
        <div class="p-3">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th style="width:170px">ID Product</th>
                  <th>Nama</th>
                  <th>Deskripsi</th>
                  <th class="text-end" style="width:140px">Harga</th>
                  <th style="width:140px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while($p = $products_res->fetch_assoc()): ?>
                  <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?php echo $p['name']; // RAW ?></td>
                    <td class="small"><?php echo $p['description']; // RAW ?></td>
                    <td class="text-end">$ <?= number_format($p['price'],2) ?></td>
                    <td>
                        <a class="btn btn-sm btn-success" href="product.php?id=<?= $p['id'] ?>">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                        <a class="btn btn-sm btn-primary" href="product_edit.php?id=<?= $p['id'] ?>">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a class="btn btn-sm btn-danger" href="product_delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Yakin menghapus produk <?= $p['name'] ?>?')">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
<!--
      <div class="alert alert-warning small">
        <strong>Lab Catatan:</strong> Halaman ini <em>tidak</em> mengirim header anti-iframe (X-Frame-Options/CSP) sehingga dapat diuji untuk <b>clickjacking</b>.  
        Kolom tertentu dibiarkan RAW (tanpa escaping) untuk demonstrasi <b>Stored/Reflected XSS</b>. Query tetap tanpa prepared statement (SQLi demo).
      </div>
-->
    </div>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
