<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya</title>
    <!-- Memuat font dari Google -->
    <link rel="icon" type="image/png" href="./images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Memuat stylesheet global dan komponen -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/components.css">
    <!-- Memuat stylesheet khusus untuk halaman index -->
    <link rel="stylesheet" href="css/index.css">


</head>

<body>

    <!-- HEADER -->
    <!-- Bagian header berisi logo dan navigasi -->
    <?php include './includes/navbar.php'; ?>

    <!-- HERO SECTION -->
    <!-- Bagian utama hero dengan teks promosi dan gambar -->
    <section class="hero-content">
        <div class="container-section">
            <div class="text" data-animate="fade-up">
                <h5>TOKO GITAR</h5>
                <h1>PALING MURAH <br>SE-INDONESIA</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut non corrupti quibusdam eos enim totam
                    iusto! Sit, voluptas pariatur sunt dolorem alias repellendus soluta cum modi vero vitae!</p>
                <div class="hero-buttons" data-animate="fade-up" data-delay="200">
                    <!-- Tombol aksi utama -->
                    <a href="marketplace.php" class="btn-primary">BELANJA</a>
                    <a href="#kontak" class="btn-outline">KONTAK</a>
                </div>
            </div>
        </div>

        <!-- Gambar hero -->
        <div class="hero-bg" data-animate="fade-in" data-delay="300">
            <img src="./images/foto.png" alt="foto-gitar" class="guitar-img">
            <img src="./images/shadowbawahgitar.png" alt="bayangan-gitar" class="guitar-shadow">
            <img src="./images/shadowbg.png" alt="shadow-bg" class="shadow-bg">
        </div>
    </section>

    <!-- TENTANG KAMI -->
    <!-- Seksi tentang perusahaan / toko -->
    <section id="tentang" class="tentang-kami">
        <h2 data-animate="fade-down">Tentang Kami</h2>
        <div class="container-tentang">
            <div class="logo-tentang" data-animate="slide-left">
                <img src="./images/logogitarsby2.png" alt="Logo Gitar Surabaya">
            </div>
            <div class="text-tentang">
                <p data-animate="slide-right" data-delay="100">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Eos aut ullam cumque culpa! Doloremque
                    similique quod, ipsam nemo reiciendis earum nulla ex placeat distinctio nihil aliquid in nostrum
                    officiis quia?</p>
                <p data-animate="slide-right" data-delay="200">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Distinctio velit architecto soluta
                    accusantium reiciendis sed labore maxime odit quod voluptatibus obcaecati maiores tempore cum ipsam
                    sit minima, impedit consequuntur ipsa!</p>
                <p data-animate="slide-right" data-delay="300">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    Aspernatur, porro consectetur. Dolorum
                    libero laborum recusandae cumque, temporibus labore doloremque, numquam autem ullam provident illum
                    eligendi non consequuntur amet sapiente necessitatibus.</p>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <!-- Bagian bawah halaman berisi logo, kontak sosial, dan alamat -->
    <?php include './includes/footer.php'; ?>

    <!-- Memuat file JavaScript -->
    <script src="./includes/script.js"></script>
</body>

</html>