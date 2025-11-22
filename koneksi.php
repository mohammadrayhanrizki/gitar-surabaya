<?php
// koneksi.php
require_once 'config.php'; // Load konfigurasi

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>