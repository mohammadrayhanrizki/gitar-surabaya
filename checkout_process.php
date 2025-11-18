<?php
include 'koneksi.php';

// Terima data JSON dari JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $nama = mysqli_real_escape_string($conn, $data['nama']);
    $wa = mysqli_real_escape_string($conn, $data['wa']);
    $list = mysqli_real_escape_string($conn, $data['list']);
    $total = $data['total'];

    // Simpan ke Tabel Pesanan
    $query = "INSERT INTO pesanan (nama_pemesan, whatsapp, list_pesanan, total_harga, tanggal, status) 
              VALUES ('$nama', '$wa', '$list', '$total', NOW(), 'Pending')";

    if (mysqli_query($conn, $query)) {
        // Kirim respon sukses ke JS
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
}
?>