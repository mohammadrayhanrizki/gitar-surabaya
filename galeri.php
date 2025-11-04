<?php
// galeri.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya</title>
    <link rel="icon" type="image/png" href="./images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include './includes/navbar.php'; ?>

    <main class="content-wrapper">
        <section class="gallery-grid">
            <?php for ($i = 1; $i <= 10; $i++):
                //ulang 2 foto bergantian
                $foto = ($i % 2 == 0) ? 'fotogaleri2.jpg' : 'fotogaleri1.jpg';
                ?>
                <div class="gallery-item" data-animate="zoom-fade" data-delay="<?= $i * 100 ?>">
                    <img src="images/<?= $foto ?>" alt="Galeri <?= $i ?>">
                </div>
                </div>
            <?php endfor; ?>
        </section>
    </main>

    <?php include './includes/footer.php'; ?>

    <script src="./includes/script.js"></script>
</body>

</html>