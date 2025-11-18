<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "toko_gitar";

// Melakukan koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>