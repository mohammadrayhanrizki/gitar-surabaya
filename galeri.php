<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya - Galeri</title>
    <link rel="icon" type="image/png" href="./images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/galeri.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <style>
        .item-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

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
            $query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
            if (mysqli_num_rows($query) > 0) {
                $delay = 100;
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <div class="gallery-item" data-animate="zoom-fade" data-delay="<?= $delay; ?>">
                        <div class="item-placeholder" title="<?= $row['judul']; ?>">
                            <img src="images/gallery/<?= $row['gambar']; ?>" alt="<?= $row['judul']; ?>">
                        </div>
                    </div>
                    <?php $delay += 100;
                }
            } else {
                echo '<p style="grid-column: 1/-1; text-align: center; color: #888;">Belum ada foto di galeri.</p>';
            } ?>
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