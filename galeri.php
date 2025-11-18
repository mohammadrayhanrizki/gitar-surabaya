<?php
include 'koneksi.php'; // 1. Hubungkan ke database
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya - Galeri</title>
    <link rel="icon" type="image/png" href="./images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/galeri.css">

    <style>
        /* Pastikan gambar memenuhi kotak tanpa gepeng */
        .item-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Efek hover simpel untuk menampilkan judul (Opsional) */
        .item-placeholder {
            position: relative;
        }

        .item-placeholder:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include './includes/navbar.php'; ?>

    <main class="content-wrapper">
        <div class="galeri-text">
            <h2 data-animate="fade-down">Galeri Pembeli</h2>
            <p data-animate="fade-up" data-delay="100">Berikut adalah dokumentasi dan testimoni pelanggan kami</p>
        </div>

        <section class="gallery-grid">
            <?php
            // 2. Ambil data dari tabel galeri, urutkan dari yang terbaru
            $query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");

            // Cek apakah ada data?
            if (mysqli_num_rows($query) > 0) {
                $delay = 100; // Variabel untuk efek animasi bertingkat
            
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <div class="gallery-item" data-animate="zoom-fade" data-delay="<?= $delay; ?>">
                        <div class="item-placeholder" title="<?= $row['judul']; ?>">
                            <img src="images/gallery/<?= $row['gambar']; ?>" alt="<?= $row['judul']; ?>">
                        </div>
                    </div>
                    <?php
                    $delay += 100; // Tambah delay 100ms setiap gambar berikutnya
                }
            } else {
                // Jika database kosong
                echo '<p style="grid-column: 1/-1; text-align: center; color: #888;">Belum ada foto di galeri saat ini.</p>';
            }
            ?>
        </section>
    </main>

    <?php include './includes/footer.php'; ?>

    <script src="./includes/script.js"></script>
</body>

</html>