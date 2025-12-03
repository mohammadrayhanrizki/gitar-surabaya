<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya</title>
    <meta name="description"
        content="Pusat jual beli gitar akustik, listrik, dan aksesoris musik terlengkap di Surabaya. Harga murah, kualitas terjamin, dan bergaransi.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://gitarsurabaya.com/">
    <meta property="og:title" content="Gitar Surabaya - Toko Gitar Terlengkap & Termurah">
    <meta property="og:description"
        content="Pusat jual beli gitar akustik, listrik, dan aksesoris musik terlengkap di Surabaya.">
    <meta property="og:image" content="https://gitarsurabaya.com/images/logo.png">

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
                <p>Cari gitar akustik murah tapi tetap keren? GitarSurabaya Nginden siap bantu! Jual-beli gitar akustik
                    paling terjangkau se-Indonesia.</p>
                <div class="hero-buttons" data-animate="fade-up" data-delay="200">
                    <!-- Tombol aksi utama -->
                    <a href="marketplace.php" class="btn-primary">BELANJA</a>
                    <a href="https://linkbio.co/gitarsurabaya" target="_blank" class="btn-outline">KONTAK</a>
                </div>
            </div>
        </div>

        <!-- Gambar hero -->
        <div class="hero-bg" data-animate="fade-in" data-delay="300">
            <img src="./images/foto.png" alt="foto-gitar" class="guitar-img">
            <img src="./images/shadowfix2.png" alt="bayangan-gitar" class="guitar-shadow">
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
                <p data-animate="slide-right" data-delay="100">Didirikan tahun 2015, GitarSurabaya memulai usaha dengan
                    sistem door-to-door dan pemasaran melalui OLX serta Facebook. Pada 2016, stok gitar mulai stabil
                    (20–30 unit) di rumah Ngagel Mulyo No. 15, lalu Agustus tahun tersebut membuka toko pertama
                    berukuran 2×8 meter tanpa karyawan.

                </p>
                <p data-animate="slide-right" data-delay="200">Awal 2017, karyawan pertama bergabung, dan cabang
                    Semolowaru menjadi cabang paling ramai dari 2016–2024. Perkembangan pesat ini melahirkan cabang
                    kedua di Darmawangsa (Dito Music), lalu cabang ketiga di Lidah Kulon dan Malang pada tahun 2019.

                </p>
                <p data-animate="slide-right" data-delay="300">
                    Hingga kini, GitarSurabaya tetap fokus pada penyediaan gitar akustik terjangkau serta servis gitar
                    akustik profesional, dengan toko utama yang terus menjadi pusat keramaian pelanggan.</p>
            </div>
        </div>
    </section>

    <?php include './includes/footer.php'; ?>

    <script src="./includes/script.js"></script>
</body>

</html>