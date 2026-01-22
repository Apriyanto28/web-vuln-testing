<?php
// db.php
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = ''; // sesuaikan XAMPP Anda
$DB_NAME = 'vulnshop';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("DB connect error: " . $mysqli->connect_error);
}
session_start();
?>
