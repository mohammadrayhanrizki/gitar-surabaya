<?php
// galeri.php
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

</head>

<body>
    <?php include './includes/navbar.php'; ?>

    <main class="content-wrapper">
        <div class="galeri-text">
            <h2 data-animate="fade-down">Galeri Pembeli</h2>
            <p data-animate="fade-up" data-delay="100">Berikut adalah dokumentasi dan testimoni pelanggan kami</p>
        </div>

        <section class="gallery-grid">
            <div class="gallery-item" data-animate="zoom-fade" data-delay="100">
                <div class="item-placeholder">
                    <img src="images/foto_pembeli_a.jpg" alt="Pembeli Senang 1">
                </div>
            </div>

            <div class="gallery-item" data-animate="zoom-fade" data-delay="200">
                <div class="item-placeholder">
                    <img src="images/foto_gitar_keren.jpg" alt="Gitar Akustik Custom">
                </div>
            </div>

            <div class="gallery-item" data-animate="zoom-fade" data-delay="300">
                <div class="item-placeholder">
                    <img src="images/testimoni_budi.jpg" alt="Testimoni Budi">
                </div>
            </div>

            <div class="gallery-item" data-animate="zoom-fade" data-delay="400">
                <div class="item-placeholder">
                    <img src="images/toko_depan.jpg" alt="Tampak Depan Toko">
                </div>
            </div>

            <div class="gallery-item" data-animate="zoom-fade" data-delay="500">
                <div class="item-placeholder">
                    <img src="images/stok_baru.jpg" alt="Stok Gitar Baru">
                </div>
            </div>

        </section>
    </main>

    <?php include './includes/footer.php'; ?>
    <script src="./includes/script.js"></script>

    <script>
        var pusher = new Pusher('122fe5dc53b428646f8b', { cluster: 'ap1' });
        var channel = pusher.subscribe('gallery-channel');

        channel.bind('update-gallery', function (data) {
            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            Toast.fire({ icon: 'info', title: data.message || 'Galeri diperbarui!' });
            setTimeout(() => { location.reload(); }, 1500);
        });
    </script>
</body>

</html>