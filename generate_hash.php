<?php
// Script sederhana untuk generate hash password
// Jalankan file ini di browser: localhost/gitar-surabaya/generate_hash.php?password=password_baru_anda

if (isset($_GET['password'])) {
    $password = $_GET['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    echo "<h3>Password Hash Generator</h3>";
    echo "Password Asli: <strong>" . htmlspecialchars($password) . "</strong><br>";
    echo "Password Hash: <br><textarea cols='60' rows='3'>" . $hash . "</textarea><br><br>";
    echo "<strong>Cara Pakai:</strong><br>";
    echo "1. Copy kode hash di atas.<br>";
    echo "2. Buka Database (phpMyAdmin) -> Tabel 'admin'.<br>";
    echo "3. Edit user admin, paste kode hash ini ke kolom 'PASSWORD'.<br>";
    echo "4. Simpan, lalu coba login di halaman login.php.";
} else {
    echo "<h3>Password Hash Generator</h3>";
    echo "Silakan masukkan password di URL parameter, contoh:<br>";
    echo "<a href='?password=admin123'>?password=admin123</a>";
}
?>
