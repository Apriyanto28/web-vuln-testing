<?php
require 'db.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) { die('Akses ditolak'); }

$id = isset($_GET['id']) ? $_GET['id'] : 0;   // RAW → SQLi demo
$mysqli->query("DELETE FROM products WHERE id = $id");   // tanpa prepared
header('Location: admin_dashboard.php#products');
exit;
