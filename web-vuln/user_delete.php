<?php
require 'db.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }

$id = isset($_GET['id']) ? $_GET['id'] : 0;     // RAW → SQLi demo
// (opsional) cegah hapus diri sendiri — komentar jika ingin super-labile:
if(isset($_SESSION['user']) && $_SESSION['user']['id'] == (int)$id){
  die('Tidak boleh menghapus diri sendiri di demo ini.');
}

$mysqli->query("DELETE FROM users WHERE id = $id");  // tanpa prepared — lab
header('Location: admin_dashboard.php#users');
exit;
