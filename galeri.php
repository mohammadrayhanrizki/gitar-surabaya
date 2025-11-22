<?php
include 'koneksi.php';

// Ambil data galeri dari database
$query_galeri = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya - Galeri</title>
    <link rel="icon" type="image/png" href="./images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Memuat stylesheet global dan komponen -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/galeri.css">
    
    <!-- SweetAlert untuk notifikasi Pusher -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Pusher untuk real-time update -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
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
            if (mysqli_num_rows($query_galeri) > 0):
                $delay = 100;
                while ($row = mysqli_fetch_assoc($query_galeri)): 
            ?>
                <div class="gallery-item" data-animate="zoom-fade" data-delay="<?= $delay; ?>">
                    <div class="item-placeholder">
                        <img src="images/gallery/<?= $row['gambar']; ?>" 
                             alt="<?= htmlspecialchars($row['judul']); ?>"
                             title="<?= htmlspecialchars($row['judul']); ?>">
                    </div>
                </div>
            <?php 
                $delay += 100;
                endwhile;
            else:
            ?>
                <div class="gallery-item" style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <p style="color: #999; font-size: 18px;">
                        <i class="fas fa-images" style="font-size: 48px; display: block; margin-bottom: 20px; opacity: 0.3;"></i>
                        Belum ada foto di galeri. Silakan upload melalui admin panel.
                    </p>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php include './includes/footer.php'; ?>
    <script src="./includes/script.js"></script>

    <script>
        // Pusher Real-time Update
        var pusher = new Pusher('122fe5dc53b428646f8b', { cluster: 'ap1' });
        var channel = pusher.subscribe('gallery-channel');

        channel.bind('update-gallery', function (data) {
            const Toast = Swal.mixin({ 
                toast: true, 
                position: 'top-end', 
                showConfirmButton: false, 
                timer: 3000,
                timerProgressBar: true
            });
            
            Toast.fire({ 
                icon: 'info', 
                title: data.message || 'Galeri diperbarui!' 
            });
            
            // Reload halaman setelah 1.5 detik
            setTimeout(() => { location.reload(); }, 1500);
        });
    </script>
</body>

</html>