<?php
// layout.php - Wajib: sudah require 'db.php' di tiap halaman sebelum include layout
function app_header($title = 'Apri Shop Medan') { ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title><?= $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & Icons -->
<!--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<!--  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">-->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.css" rel="stylesheet">
  <link href="theme.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-primary navbar-dark shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-shield-lock"></i> ApriSHop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="products.php"><i class="bi bi-grid"></i> Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="bi bi-cart"></i> Keranjang</a></li>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>
          <li class="nav-item"><a class="nav-link" href="admin_dashboard.php"><i class="bi bi-speedometer2"></i> Admin</a></li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['user'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-circle"></i> <?= $_SESSION['user']['username'] ?></a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if($_SESSION['user']['is_admin']): ?>
                <li><a class="dropdown-item" href="admin_profile.php"><i class="bi bi-person-gear"></i> Admin Profile</a></li>
              <?php endif; ?>
              <li><a class="dropdown-item" href="user_profile.php"><i class="bi bi-person"></i> Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!--<li class="nav-item"><a class="btn btn-light btn-sm me-2" href="login_user.php"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>-->
          <li class="nav-item"><a class="btn btn-light btn-sm me-2" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
          <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="login_admin.php"><i class="bi bi-key"></i> Admin</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<?php } // end app_header

function app_footer() { ?>
<footer class="border-top mt-5">
  <div class="container py-4 text-center small text-muted">
    <div>Apri Shop Medan &middot; Belanja hemat tidak pakai ribet</div>
    <div class="mt-1">&copy; <?= date('Y') ?> Apri Shop Medan</div>
  </div>
</footer>

<!-- Toast container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
  <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <i class="bi bi-check2-circle me-1"></i> Aksi berhasil.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Trigger toast by query ?toast=1
  (new URLSearchParams(location.search)).get('toast') && new bootstrap.Toast(document.getElementById('liveToast')).show();
</script>
</body>
</html>
<?php } // end app_footer
