-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2025 at 12:22 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_gitar`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `PASSWORD`) VALUES
(1, 'admin', '$2y$10$fXMRmdQ1wwBvi3b2IJXlp.v4ispGfKTB3Nm5PUCKy5T0zjwBgDcte');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `subjudul` varchar(200) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `judul`, `subjudul`, `gambar`, `created_at`) VALUES
(23, '', '', '03122025180442bannerfixfinal1.png', '2025-12-03 11:04:42'),
(24, '', '', '03122025180647bannerfixfinal2.png', '2025-12-03 11:06:47'),
(25, '', '', '03122025182312bannerlesgitar.png', '2025-12-03 11:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `judul`, `gambar`, `tanggal_upload`) VALUES
(11, 'barusan beli', '03122025135833yamaha10.jpg', '2025-12-03 13:58:33'),
(12, 'pelanggan 1', '03122025135845fotogaleri1.jpg', '2025-12-03 13:58:45'),
(13, 'chill', '03122025135858fotogaleri2.jpg', '2025-12-03 13:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int NOT NULL,
  `nama_pemesan` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `list_pesanan` text,
  `total_harga` decimal(15,2) DEFAULT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Selesai','Batal') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama_pemesan`, `whatsapp`, `list_pesanan`, `total_harga`, `tanggal`, `status`) VALUES
(22, 'zydan', '089524274797', '- Odlair OD-500 High Performance (Rp 1.100.000)', 1100000.00, '2025-12-03 10:04:53', 'Pending'),
(23, 'John', '087863118174', '- Yamaha LL16 ARE Handcrafted (Rp 11.500.000)\n- HMF Karafuru Semi Hollow Body Custom (Rp 2.500.000)\n- Odlair OD-600 Premium Wood (Rp 1.350.000)\n- Odlair OD-500 High Performance (Rp 1.100.000)\n- Karafuru KF-500 Blue Ocean (Rp 950.000)\n- Cowboy Junior GW-120 Natural (Rp 650.000)', 18050000.00, '2025-12-03 12:26:22', 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `deskripsi` text,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `kategori`, `harga`, `stok`, `deskripsi`, `gambar`, `created_at`) VALUES
(1, 'Gitar Cowboy GWC-240 NS Original', 'Cowboy', 750000.00, 15, 'SPESIFIKASI\r\nUkuran: 41 Inch Dreadnought\r\nTop Body: Linden Wood\r\nBack & Side: Linden\r\nNeck: Mahogany + Trussrod\r\nFingerboard: Rosewood\r\nWarna: Natural Satin', '02122025174133Cowboy1.jpg', '2025-12-03 01:27:28'),
(2, 'Cowboy GWC-235 Coklat Tua', 'Cowboy', 720000.00, 10, 'DETAIL PRODUK\r\nUkuran: 38 Inch\r\nTop Body: Basswood\r\nNeck: Mahogany\r\nFingerboard: Rosewood\r\nWarna: Dark Brown\r\nFitur: Besi Tanam (Trussrod)', '02122025174331Cowboy2.jpg', '2025-12-03 01:27:28'),
(3, 'Cowboy Junior GW-120 Natural', 'Cowboy', 650000.00, 8, 'SPESIFIKASI\r\nUkuran: 3/4 (Travel Size)\r\nBody: Sapele Wood\r\nNeck: Mahogany\r\nFretboard: Rosewood\r\nSenar: String 0.10\r\nCocok untuk: Pemula & Wanita', '02122025174640Cowboy3.jpg', '2025-12-03 01:27:28'),
(4, 'Cowboy GWC-240 Hitam Doff', 'Cowboy', 760000.00, 12, 'SPESIFIKASI UTAMA\r\nWarna: Hitam Matte (Doff)\r\nBody: Linden Selected\r\nNeck: Mahogany\r\nTrussrod: Double Action\r\nDryer: Grover Chrome\r\nSuara: Garing & Nyaring', '02122025174814Cowboy4.jpg', '2025-12-03 01:27:28'),
(5, 'Cowboy GWC-240NA Premium', 'Cowboy', 800000.00, 5, 'FITUR\r\nTop Body: Siprus Laminasi\r\nBack/Side: Meranti\r\nNeck: Mahoni Utuh\r\nFret: Baja Stainless\r\nWarna: Natural Amber\r\nBonus: Tas & Kunci L', '02122025180108cowboy5.jpg', '2025-12-03 01:27:28'),
(6, 'Cowboy CGC-100 Klasik Nylon', 'Cowboy', 680000.00, 20, 'SPESIFIKASI KLASIK\r\nTipe: Gitar Klasik (Senar Nilon)\r\nTop: Basswood\r\nNeck: Nato\r\nFingerboard: Nato\r\nWarna: Natural Glossy\r\nKarakter Suara: Warm & Mellow', '03122025074922Cowboy6.jpg', '2025-12-03 01:27:28'),
(7, 'Cowboy High Grade Series 7', 'Cowboy', 950000.00, 4, 'SPESIFIKASI PRO\r\nTop: Spruce High Grade\r\nBack/Side: Rosewood Laminate\r\nBinding: Abalone Kerang\r\nTuner: Diecast Gold\r\nFinishing: High Gloss', '03122025075051cowboy7.jpg', '2025-12-03 01:27:28'),
(8, 'Cowboy Acoustic Electric Tuner', 'Cowboy', 1100000.00, 6, 'ELEKTRONIK\r\nPreamp: Cowboy AW-5 (Tuner LCD)\r\nEqualizer: Bass, Middle, Treble, Pres\r\nOutput: Jack 6.5mm & XLR Canon\r\nBody: Cutaway Dreadnought', '03122025075149cowboy8.jpg', '2025-12-03 01:27:28'),
(9, 'Cowboy GWC-235 Black Edition', 'Cowboy', 730000.00, 9, 'SPESIFIKASI\r\nWarna: Full Black\r\nBody: Basswood\r\nNeck: Mahogany\r\nFretboard: Mapleneck\r\nPlayability: Ceper & Nyaman', '03122025075357cowboy9.jpg', '2025-12-03 01:27:28'),
(10, 'Cowboy Concert Series 10', 'Cowboy', 850000.00, 7, 'SPESIFIKASI\r\nBody Shape: Grand Concert\r\nTop: Spruce\r\nBack/Side: Mahogany\r\nRosette: Laser Engraved\r\nWarna: Sunburst', '03122025075507cowboy10.jpg', '2025-12-03 01:27:28'),
(11, 'Cowboy Signature Series 11', 'Cowboy', 1200000.00, 3, 'PREMIUM SPECS\r\nTop: Solid Spruce\r\nBack/Side: Zebra Wood\r\nBinding: Kayu Maple\r\nInlay: Tanda Tangan Artist\r\nSenar: DAddario EXP', '03122025075651cowboy11.jpg', '2025-12-03 01:27:28'),
(12, 'Yamaha F310 Original Akustik', 'Yamaha', 1450000.00, 10, 'SPESIFIKASI LEGEND\r\nTop: Spruce\r\nBack/Side: Meranti\r\nNeck: Nato\r\nFingerboard: Rosewood\r\nScale: 634mm\r\nWarna: Natural Gloss', '02122025190704Yamaha3.jpg', '2025-12-03 01:27:28'),
(13, 'Yamaha C315 Klasik Pemula', 'Yamaha', 990000.00, 15, 'SPESIFIKASI\r\nTipe: Klasik (Nylon)\r\nTop: Spruce\r\nBody: Agathis\r\nNeck: Nato\r\nFinish: Matte (Tidak Licin)\r\nOriginal: Yamaha Indonesia', '02122025190844Yamaha4.jpg', '2025-12-03 01:27:28'),
(14, 'Yamaha FS800 Solid Top', 'Yamaha', 3500000.00, 2, 'FITUR PREMIUM\r\nTop: Solid Spruce (Kayu Asli)\r\nBack/Side: Nato/Okume\r\nBracing: Scalloped X\r\nBody: Concert Body\r\nSuara: Lebih Nendang & Sustain Panjang', '02122025191024yamaha5.jpg', '2025-12-03 01:27:28'),
(15, 'Yamaha APX600 Electric Acoustic', 'Yamaha', 3100000.00, 5, 'SPESIFIKASI PANGGUNG\r\nBody: Thin Line (Tipis)\r\nTop: Spruce\r\nPreamp: System 65 + Tuner\r\nPickup: Piezo SRT\r\nWarna: Old Violin Sunburst', '02122025191219yamaha6.jpg', '2025-12-03 01:27:28'),
(16, 'Yamaha CPX700II Medium Jumbo', 'Yamaha', 4500000.00, 1, 'SPESIFIKASI ARTIS\r\nBody: Medium Jumbo\r\nTop: Solid Spruce\r\nBack/Side: Nato\r\nPreamp: System 64 1-way ART\r\nSuara: Bass Tebal & Akustik Natural', '02122025191901yamaha8.jpg', '2025-12-03 01:27:28'),
(17, 'Yamaha LL16 ARE Handcrafted', 'Yamaha', 11500000.00, 1, 'MASTERPIECE\r\nTeknologi: A.R.E (Acoustic Resonance)\r\nTop: Solid Engelmann Spruce\r\nBack/Side: Solid Rosewood\r\nNeck: 5-ply Mahogany/Rosewood\r\nPickup: SRT Zero Impact\r\nCase: Hard Bag Original', '02122025192538Yamaha9.jpg', '2025-12-03 01:27:28'),
(18, 'Yamaha Revstar Element RSE20', 'Yamaha', 5900000.00, 2, 'GITAR LISTRIK\r\nBody: Chambered Mahogany\r\nNeck: Mahogany 3-Piece\r\nPickup: VH3 Alnico V Humbucker\r\nSwitch: Dry Switch (High Pass Filter)\r\nBridge: Tune-O-Matic', '03122025075949yamaha10.jpg', '2025-12-03 01:27:28'),
(19, 'Bromo BAA1 Mount Bromo Series', 'Bromo', 1250000.00, 5, 'SPESIFIKASI ALAM\r\nTop: Spruce\r\nBack/Side: Mahogany\r\nFretboard: Amara Ebony\r\nNut/Saddle: Nubone\r\nFinish: Satin Open Pore (Serat Kayu Terasa)', '02122025175300Bromo2.jpg', '2025-12-03 01:27:28'),
(20, 'Bromo BAT1 Travel Series', 'Bromo', 1150000.00, 8, 'TRAVEL COMPANION\r\nUkuran: Travel Size\r\nTop: Spruce\r\nBack/Side: Mahogany\r\nScale: 580mm (Pendek)\r\nGigbag: Bromo Padded Bag', '02122025175645Bromo3.jpg', '2025-12-03 01:27:28'),
(21, 'Bromo BAA2 Tahura Series', 'Bromo', 1400000.00, 4, 'SPESIFIKASI\r\nTop: Solid Mahogany\r\nBack/Side: Mahogany\r\nBinding: Maple Wood\r\nRosette: Abalone\r\nSuara: Warm & Woody', '02122025175841Bromo4.jpg', '2025-12-03 01:27:28'),
(22, 'Bromo BAR1 Ranupani Series', 'Bromo', 1650000.00, 3, 'SPESIFIKASI\r\nBody: Dreadnought Cutaway\r\nTop: Spruce\r\nBack/Side: Rosewood\r\nPreamp: Bromo BZP1\r\nTuner: Built-in LCD', '02122025175950Bromo5.jpg', '2025-12-03 01:27:28'),
(23, 'Bromo BAS1 Semeru Series', 'Bromo', 2100000.00, 2, 'FLAGSHIP MODEL\r\nTop: Solid Sitka Spruce\r\nBack/Side: Amara Ebony\r\nFretboard: Ebony\r\nInlay: Mt. Bromo Pearl\r\nFinish: Gloss Top, Satin Back', '02122025180858Bromo6.jpg', '2025-12-03 01:27:28'),
(24, 'Bromo BAT2 Travel Mahogany', 'Bromo', 1200000.00, 6, 'TRAVEL SPECS\r\nTop: Mahogany\r\nBack/Side: Mahogany\r\nNeck: Mahogany\r\nTone: Fokus di Mid-Range\r\nCocok: Fingerstyle Blues', '02122025181102Bromo7.jpg', '2025-12-03 01:27:28'),
(25, 'Bromo BAA1CE Electric', 'Bromo', 1550000.00, 5, 'SPESIFIKASI\r\nTipe: Akustik Elektrik\r\nBody: Dreadnought Cutaway\r\nTop: Spruce\r\nPreamp: 3-Band EQ\r\nOutput: Jack & XLR', '02122025185832Bromo8.jpg', '2025-12-03 01:27:28'),
(26, 'Karafuru KF-100 White Gloss', 'Karafuru', 850000.00, 10, 'TAMPIL BEDA\r\nWarna: Putih Susu Glossy\r\nBody: Basswood\r\nNeck: Maple\r\nFret: 21\r\nPlayability: Action Rendah', '02122025173859Karafuru1.jpg', '2025-12-03 01:27:28'),
(27, 'Karafuru KF-200 Sunburst', 'Karafuru', 900000.00, 8, 'VINTAGE STYLE\r\nWarna: 3-Tone Sunburst\r\nTop: Spruce Laminate\r\nBack/Side: Linden\r\nPickguard: Tortoise\r\nSuara: Bright', '02122025174924Karafuru2.jpg', '2025-12-03 01:27:28'),
(28, 'Karafuru KF-300 Black Matte', 'Karafuru', 875000.00, 12, 'ELEGANT LOOK\r\nWarna: Hitam Doff\r\nBody: Mahogany Top\r\nBinding: Putih Gading\r\nDryer: Black Diecast\r\nSenar: Bronze 0.11', '02122025175053Karafuru3.jpg', '2025-12-03 01:27:28'),
(29, 'Karafuru KF-400 Natural', 'Karafuru', 825000.00, 15, 'CLASSIC LOOK\r\nWarna: Natural Kayu\r\nTop: Spruce\r\nFinish: Satin (Halus)\r\nNeck Shape: C-Shape (Enak digenggam)', '02122025180455Karafuru4.jpg', '2025-12-03 01:27:28'),
(30, 'Karafuru KF-500 Blue Ocean', 'Karafuru', 950000.00, 5, 'WARNA UNIK\r\nWarna: Biru Laut Gradasi\r\nBody: Quilted Maple Top\r\nBack/Side: Mahogany\r\nInlay: Dot Pearl\r\nSuara: Jernih', '03122025075756karafuru5.jpg', '2025-12-03 01:27:28'),
(31, 'Odlair OD-500 High Performance', 'Odlair', 1100000.00, 6, 'PERFORMA TINGGI\r\nBody: Grand Auditorium\r\nTop: Selected Spruce\r\nBack/Side: Walnut\r\nArmrest: Bevel Cut (Nyaman di tangan)\r\nPreamp: Odlair EQ-4', '02122025180243Odlair1.jpg', '2025-12-03 01:27:28'),
(32, 'Odlair OD-600 Premium Wood', 'Odlair', 1350000.00, 4, 'KAYU EKSOTIS\r\nTop: Solid Cedar\r\nBack/Side: Rosewood\r\nFretboard: Richlite\r\nNut/Saddle: Bone (Tulang)\r\nSuara: Sangat Responsif', '02122025190123Odlair2.jpg', '2025-12-03 01:27:28'),
(33, 'HMF Karafuru Semi Hollow Body Custom', 'Karafuru', 2500000.00, 1, 'CUSTOM SHOP\r\nTipe: Semi-Hollow Electric\r\nBody: Maple\r\nNeck: Set-Neck Mahogany\r\nPickup: P90 Soapbar\r\nWarna: Cherry Red\r\nKondisi: Baru (Custom)', '02122025174028HMF SEMI.jpg', '2025-12-03 01:27:28');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_aktivitas`
--

CREATE TABLE `riwayat_aktivitas` (
  `id` int NOT NULL,
  `isi_aktivitas` varchar(255) DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `riwayat_aktivitas`
--

INSERT INTO `riwayat_aktivitas` (`id`, `isi_aktivitas`, `tanggal`) VALUES
(1, 'Admin menambahkan produk rey', '2025-11-17 20:30:46'),
(2, 'Admin menyelesaikan pesanan atas nama Tes User Baru', '2025-11-17 20:42:25'),
(3, 'Admin menghapus produk rey', '2025-11-17 20:57:56'),
(4, 'Admin menambahkan produk Zydan', '2025-11-17 20:58:31'),
(5, 'Admin menambahkan produk rey', '2025-11-17 21:19:27'),
(6, 'Admin menambahkan produk gitar biasa', '2025-11-17 21:23:15'),
(7, 'Admin menambahkan produk Bromo terbaru', '2025-11-17 21:29:49'),
(8, 'Admin menambahkan produk gitar biasa', '2025-11-17 21:35:32'),
(9, 'Admin menambahkan produk aa', '2025-11-17 21:35:56'),
(10, 'Admin menyelesaikan pesanan atas nama rey', '2025-11-18 00:04:44'),
(11, 'Admin mengubah status pesanan ID 3 menjadi Pending', '2025-11-18 00:07:24'),
(12, 'Admin mengubah status pesanan ID 6 menjadi Selesai', '2025-11-18 00:10:22'),
(13, 'Admin mengubah status pesanan ID 4 menjadi Selesai', '2025-11-18 00:19:31'),
(14, 'Admin menambahkan produk Yamaha Waguri', '2025-11-18 02:03:56'),
(15, 'Admin mengedit produk Yamaha Waguri', '2025-11-18 02:15:00'),
(16, 'Admin mengedit produk Yamaha Waguri', '2025-11-18 02:21:57'),
(17, 'Admin mengedit produk Yamaha Waguri', '2025-11-18 02:22:22'),
(18, 'Admin mengedit produk gitar biasa', '2025-11-18 02:23:13'),
(19, 'Admin menghapus produk Yamaha Waguri', '2025-11-18 02:23:39'),
(20, 'Admin menghapus produk aa', '2025-11-18 02:24:48'),
(21, 'Admin menghapus produk gitar biasa', '2025-11-18 02:24:54'),
(22, 'Admin menghapus produk Bromo terbaru', '2025-11-18 02:24:59'),
(23, 'Admin menghapus produk gitar biasa', '2025-11-18 02:25:04'),
(24, 'Admin menghapus produk rey', '2025-11-18 02:25:09'),
(25, 'Admin menghapus produk Zydan', '2025-11-18 02:25:14'),
(26, 'Admin menambahkan produk Yamaha Waguri (Stok: 5)', '2025-11-18 09:23:13'),
(27, 'Admin mengubah status pesanan ID 7 menjadi Selesai', '2025-11-18 09:24:15'),
(28, 'Admin mengubah status pesanan ID 7 menjadi Pending', '2025-11-18 09:24:20'),
(29, 'Admin menghapus produk Yamaha Waguri', '2025-11-18 09:27:52'),
(30, 'Admin menambahkan produk pick gitar (Stok: 100)', '2025-11-18 09:30:52'),
(31, 'Admin menghapus produk pick gitar', '2025-11-18 09:37:07'),
(32, 'Admin mengupload foto galeri: pelanggan', '2025-11-18 09:41:16'),
(33, 'Admin menghapus foto galeri: pelanggan', '2025-11-18 09:42:57'),
(34, 'Admin mengupload foto galeri: pelanggan', '2025-11-18 09:43:09'),
(35, 'Admin menghapus foto galeri: pelanggan', '2025-11-18 09:43:57'),
(36, 'Admin menambahkan produk Yamaha Waguri (Stok: 2)', '2025-11-18 14:32:26'),
(37, 'Admin menambahkan produk gitar listrik (Stok: 1)', '2025-11-18 14:37:08'),
(38, 'Admin menambahkan produk gitar biasa (Stok: 1)', '2025-11-18 15:06:45'),
(39, 'Admin menambahkan produk kfnKSADN (Stok: 222)', '2025-11-18 15:07:24'),
(40, 'Admin menambahkan produk ADAD (Stok: 22)', '2025-11-18 15:08:05'),
(41, 'Admin menghapus produk kfnKSADN', '2025-11-18 15:08:34'),
(42, 'Admin mengupload foto galeri: pembeli', '2025-11-18 15:14:33'),
(43, 'Admin mengupload foto galeri: wenal', '2025-11-18 15:14:52'),
(44, 'Admin menghapus foto galeri: wenal', '2025-11-18 15:15:18'),
(45, 'Admin menghapus foto galeri: pembeli', '2025-11-18 15:15:25'),
(46, 'Admin menghapus produk ADAD', '2025-11-18 15:15:41'),
(47, 'Admin menghapus produk gitar biasa', '2025-11-18 15:15:51'),
(48, 'Admin menghapus produk gitar biasa', '2025-11-18 15:16:58'),
(49, 'Admin menghapus produk gitar listrik', '2025-11-18 15:17:04'),
(50, 'Admin menghapus produk Yamaha Waguri', '2025-11-18 15:17:10'),
(51, 'Admin menambahkan produk aa (Stok: 2)', '2025-11-18 15:54:40'),
(52, 'Admin menghapus produk aa', '2025-11-18 15:56:05'),
(53, 'Admin mengubah status pesanan ID 9 menjadi Selesai', '2025-11-18 16:01:58'),
(54, 'Admin mengubah status pesanan ID 9 menjadi Pending', '2025-11-18 16:02:02'),
(55, 'Admin menambahkan produk fufuffafa (Stok: 1)', '2025-11-19 07:17:20'),
(56, 'Admin mengupload banner promo: diskon 30%', '2025-11-19 12:19:42'),
(57, 'Admin mengupload banner promo: diskon 30%', '2025-11-19 12:33:55'),
(58, 'Admin menghapus banner: diskon 30%', '2025-11-19 12:42:41'),
(59, 'Admin menghapus banner: diskon 30%', '2025-11-19 12:42:52'),
(60, 'Admin menghapus banner: diskon 30%', '2025-11-19 12:43:08'),
(61, 'Admin menghapus produk fufuffafa', '2025-11-19 12:44:12'),
(62, 'Admin mengupload banner promo: pelanggan', '2025-11-19 12:45:31'),
(63, 'Admin menghapus banner: pelanggan', '2025-11-19 12:48:42'),
(64, 'Admin mengupload banner promo: diskon 30%', '2025-11-19 12:49:20'),
(65, 'Admin menambahkan produk Yamaha Waguri (Stok: 1)', '2025-11-19 12:56:01'),
(66, 'Admin menambahkan produk gitar biasa (Stok: 1)', '2025-11-19 12:56:31'),
(67, 'Admin mengupload banner promo: pelanggan', '2025-11-19 13:03:36'),
(68, 'Admin menambahkan produk rey (Stok: 2)', '2025-11-19 13:24:00'),
(69, 'Admin menghapus banner: pelanggan', '2025-11-19 13:34:02'),
(70, 'Admin menghapus banner: diskon 30%', '2025-11-19 13:34:09'),
(71, 'Admin mengupload banner promo: promo ', '2025-11-19 13:39:25'),
(72, 'Admin mengupload banner promo: diskon 30%', '2025-11-19 13:39:40'),
(73, 'Admin menghapus produk rey', '2025-11-20 09:17:48'),
(74, 'Admin menghapus produk Yamaha Waguri', '2025-11-22 04:28:55'),
(75, 'Admin menghapus produk gitar biasa', '2025-11-22 04:29:07'),
(76, 'Admin menambahkan produk Yamaha Waguri (Stok: 1)', '2025-11-22 04:29:33'),
(77, 'Admin menambahkan produk reno (Stok: 1)', '2025-11-22 04:33:11'),
(78, 'Admin mengubah status pesanan ID 14 menjadi Selesai', '2025-11-22 04:35:17'),
(79, 'Admin mengubah status pesanan ID 14 menjadi Pending', '2025-11-22 04:35:22'),
(80, 'Admin menambahkan produk ghatfan  (Stok: 10)', '2025-11-22 04:40:29'),
(81, 'Admin mengedit produk ghatfan ', '2025-11-22 06:09:04'),
(82, 'Admin mengupload banner promo: diskon merdeka', '2025-11-22 06:30:53'),
(83, 'Admin menghapus banner: diskon merdeka', '2025-11-22 06:31:03'),
(84, 'Admin menambahkan produk zydan2 (Stok: 2)', '2025-11-22 10:28:55'),
(85, 'Admin mengupload foto galeri: zydan lagi band', '2025-11-22 10:43:07'),
(86, 'Admin menghapus produk zydan2', '2025-11-22 10:43:35'),
(87, 'Admin mengupload foto galeri: zydan ganteng', '2025-11-22 10:46:04'),
(88, 'Admin mengupload banner promo: diskon merdeka', '2025-11-22 10:46:48'),
(89, 'Admin menambahkan produk yamaha1 (Stok: 1)', '2025-11-22 10:48:36'),
(90, 'Admin menambahkan produk Yamaha2 (Stok: 1)', '2025-11-22 10:49:00'),
(91, 'Admin menambahkan produk yamaha3 (Stok: 1)', '2025-11-22 10:49:27'),
(92, 'Admin menambahkan produk aa (Stok: 1)', '2025-11-22 11:10:48'),
(93, 'Admin menghapus produk aa', '2025-11-22 11:46:27'),
(94, 'Admin mengubah status pesanan ID 19 menjadi Selesai', '2025-12-01 05:14:12'),
(95, 'Admin menghapus foto galeri: zydan lagi band', '2025-12-01 05:40:40'),
(96, 'Admin menghapus foto galeri: zydan ganteng', '2025-12-01 05:40:44'),
(97, 'Admin menghapus produk yamaha3', '2025-12-01 05:40:50'),
(98, 'Admin menghapus produk Yamaha2', '2025-12-01 05:40:56'),
(99, 'Admin menghapus produk yamaha1', '2025-12-01 05:41:07'),
(100, 'Admin menghapus produk ghatfan ', '2025-12-01 05:41:12'),
(101, 'Admin menghapus produk reno', '2025-12-01 05:41:17'),
(102, 'Admin menghapus produk Yamaha Waguri', '2025-12-01 05:41:22'),
(103, 'Admin menghapus banner: diskon merdeka', '2025-12-01 05:41:31'),
(104, 'Admin menghapus banner: diskon 30%', '2025-12-01 05:41:43'),
(105, 'Admin menghapus banner: promo ', '2025-12-01 05:41:46'),
(106, 'Admin menambahkan produk Zydan (Stok: 1)', '2025-12-01 05:42:44'),
(107, 'Admin mengupload foto galeri: keren', '2025-12-01 05:58:46'),
(108, 'Admin mengupload banner promo: pelanggan', '2025-12-01 06:09:51'),
(109, 'Admin menghapus banner: pelanggan', '2025-12-01 06:12:03'),
(110, 'Admin mengupload banner promo: ', '2025-12-01 06:16:17'),
(111, 'Admin menghapus banner: ', '2025-12-01 06:16:29'),
(112, 'Admin mengupload banner promo: merdeka', '2025-12-01 06:24:35'),
(113, 'Admin menghapus banner: merdeka', '2025-12-01 06:24:44'),
(114, 'Admin menghapus produk Zydan', '2025-12-02 10:20:07'),
(115, 'Admin menambahkan produk HMF Kuroi Drednought (Stok: 1)', '2025-12-02 10:38:59'),
(116, 'Admin menambahkan produk HMF SEMI (Stok: 2)', '2025-12-02 10:40:28'),
(117, 'Admin menambahkan produk Cowboy GW/GWC 240 NA/NS (Stok: 2)', '2025-12-02 10:41:33'),
(118, 'Admin menambahkan produk Cowboy GW 120 NA/NS (Stok: 2)', '2025-12-02 10:43:31'),
(119, 'Admin mengedit produk Cowboy GW 120 NA/NS', '2025-12-02 10:44:33'),
(120, 'Admin mengedit produk Cowboy GW/GWC 240 NA/NS', '2025-12-02 10:44:50'),
(121, 'Admin mengedit produk HMF SEMI', '2025-12-02 10:45:00'),
(122, 'Admin mengedit produk HMF Kuroi Drednought', '2025-12-02 10:45:09'),
(123, 'Admin mengedit produk HMF Kuroi Drednought', '2025-12-02 10:45:26'),
(124, 'Admin menambahkan produk Cowboy CG 100 NA/CGC 100 NS (Stok: 2)', '2025-12-02 10:46:40'),
(125, 'Admin menambahkan produk Cowboy AEG C GNS/GNS (Stok: 2)', '2025-12-02 10:48:14'),
(126, 'Admin menambahkan produk DND Karafuru Viber (Stok: 1)', '2025-12-02 10:49:24'),
(127, 'Admin menambahkan produk FJR Karafuru Kuroi (Stok: 2)', '2025-12-02 10:50:53'),
(128, 'Admin menambahkan produk Bromo BAA4CE (Stok: 2)', '2025-12-02 10:53:01'),
(129, 'Admin menambahkan produk Bromo BAA2CE (Stok: 1)', '2025-12-02 10:56:45'),
(130, 'Admin menambahkan produk Bromo BAA8S (Stok: 2)', '2025-12-02 10:58:41'),
(131, 'Admin menambahkan produk Bromo BAT2M (Stok: 2)', '2025-12-02 10:59:51'),
(132, 'Admin menambahkan produk Cowboy AEG 240/235 GNS (Stok: 2)', '2025-12-02 11:01:09'),
(133, 'Admin menambahkan produk Odlair OM501 Blue Denim/Chinos (Stok: 2)', '2025-12-02 11:02:44'),
(134, 'Admin menambahkan produk Karafuru Shiroi (Stok: 2)', '2025-12-02 11:04:55'),
(135, 'Admin menambahkan produk Bromo BAA1 (Stok: 2)', '2025-12-02 11:08:58'),
(136, 'Admin menambahkan produk Bromo BAB1 (Stok: 2)', '2025-12-02 11:11:03'),
(137, 'Admin menambahkan produk Bromo BAR1H (Stok: 2)', '2025-12-02 11:58:32'),
(138, 'Admin menambahkan produk Odlair OD511 S (Stok: 2)', '2025-12-02 12:01:23'),
(139, 'Admin menambahkan produk Yamaha Apx600 Natural (Stok: 2)', '2025-12-02 12:07:05'),
(140, 'Admin menambahkan produk Yamaha Apx600 OBB (Oriental Blue Burst) (Stok: 2)', '2025-12-02 12:08:45'),
(141, 'Admin menambahkan produk Yamaha FS100C (Stok: 2)', '2025-12-02 12:10:24'),
(142, 'Admin menambahkan produk Yamaha Cs40 (Stok: 2)', '2025-12-02 12:12:19'),
(143, 'Admin menambahkan produk Yamaha f310 Original (Stok: 2)', '2025-12-02 12:19:01'),
(144, 'Admin menambahkan produk Yamaha C315 Original (Stok: 2)', '2025-12-02 12:25:38'),
(145, 'Admin menambahkan produk Cowboy GWC360 NT (Stok: 2)', '2025-12-03 00:49:23'),
(146, 'Admin menambahkan produk Cowboy junior gw120 (Stok: 2)', '2025-12-03 00:50:51'),
(147, 'Admin menambahkan produk Cowboy gwc235 (Stok: 2)', '2025-12-03 00:51:50'),
(148, 'Admin menambahkan produk COWBOY CGC100 (Stok: 2)', '2025-12-03 00:53:58'),
(149, 'Admin menambahkan produk cowboy GW2/3 (Stok: 2)', '2025-12-03 00:55:07'),
(150, 'Admin menambahkan produk cowboy gwc240 na/ns original (Stok: 2)', '2025-12-03 00:56:51'),
(151, 'Admin menambahkan produk karafuru saki (Stok: 4)', '2025-12-03 00:57:56'),
(152, 'Admin menambahkan produk yamaha f400 original (Stok: 1)', '2025-12-03 00:59:49'),
(153, 'Admin menghapus produk Senar Gitar Akustik Elixir Nanoweb', '2025-12-03 01:24:56'),
(154, 'Admin menghapus produk Capo Gitar Aluminium Alloy', '2025-12-03 01:25:01'),
(155, 'Admin menghapus produk Capo Gitar Aluminium', '2025-12-03 01:29:05'),
(156, 'Admin menghapus produk Senar Elixir Nanoweb 0.10', '2025-12-03 01:29:11'),
(157, 'Admin mengedit produk HMF Karafuru Semi Hollow Body Custom', '2025-12-03 01:38:52'),
(158, 'Admin menghapus foto galeri: bagus', '2025-12-03 02:36:36'),
(159, 'Admin mengubah status pesanan ID 21 menjadi Selesai', '2025-12-03 02:39:57'),
(160, 'Admin mengubah status pesanan ID 21 menjadi Pending', '2025-12-03 02:40:03'),
(161, 'Admin mengupload banner promo: ', '2025-12-03 02:55:08'),
(162, 'Admin mengupload banner promo: ', '2025-12-03 02:57:41'),
(163, 'Admin mengupload banner promo: ', '2025-12-03 03:03:35'),
(164, 'Admin mengedit produk HMF Karafuru Semi Hollow Body Custom', '2025-12-03 03:25:11'),
(165, 'Admin mengedit produk HMF Karafuru Semi Hollow Body Custom', '2025-12-03 03:25:27'),
(166, 'Admin menambahkan produk Yamaha F310 Test (Stok: 2)', '2025-12-03 04:46:00'),
(167, 'Admin mengedit produk Yamaha F310 Test', '2025-12-03 05:01:53'),
(168, 'Admin menghapus produk Yamaha F310 Test', '2025-12-03 05:03:22'),
(169, 'Admin menambahkan produk A (Stok: 1)', '2025-12-03 05:03:44'),
(170, 'Admin menghapus produk A', '2025-12-03 05:04:01'),
(171, 'Admin menambahkan produk Gitar Keren (Stok: 10)', '2025-12-03 05:05:21'),
(172, 'Admin mengubah status pesanan ID 23 menjadi Selesai', '2025-12-03 05:26:49'),
(173, 'Admin mengubah status pesanan ID 23 menjadi Pending', '2025-12-03 05:27:17'),
(174, 'Admin mengubah status pesanan ID 23 menjadi Selesai', '2025-12-03 05:27:21'),
(175, 'Admin menambahkan produk Karafuru Terbaru (Stok: 1)', '2025-12-03 05:31:17'),
(176, 'Admin menghapus produk Karafuru Terbaru', '2025-12-03 05:36:20'),
(177, 'Admin menambahkan produk odlair baru nih (Stok: 1)', '2025-12-03 05:41:00'),
(178, 'Admin menambahkan produk baru lagi (Stok: 1)', '2025-12-03 05:41:32'),
(179, 'Admin mengupload foto galeri: kere n', '2025-12-03 05:44:31'),
(180, 'Admin mengupload foto galeri: vbagus', '2025-12-03 05:44:40'),
(181, 'Admin menghapus foto galeri: vbagus', '2025-12-03 06:57:52'),
(182, 'Admin menghapus foto galeri: kere n', '2025-12-03 06:57:57'),
(183, 'Admin mengupload foto galeri: barusan beli', '2025-12-03 06:58:33'),
(184, 'Admin mengupload foto galeri: pelanggan 1', '2025-12-03 06:58:45'),
(185, 'Admin mengupload foto galeri: chill', '2025-12-03 06:58:58'),
(186, 'Admin menghapus produk baru lagi', '2025-12-03 10:35:15'),
(187, 'Admin menghapus produk odlair baru nih', '2025-12-03 10:35:21'),
(188, 'Admin menghapus produk Gitar Keren', '2025-12-03 10:35:27'),
(189, 'Admin mengupload banner promo: ', '2025-12-03 10:41:14'),
(190, 'Admin menghapus banner: ', '2025-12-03 10:41:19'),
(191, 'Admin menghapus banner: ', '2025-12-03 10:42:16'),
(192, 'Admin menghapus banner: ', '2025-12-03 10:42:20'),
(193, 'Admin menghapus banner: ', '2025-12-03 10:42:24'),
(194, 'Admin mengupload banner promo: ', '2025-12-03 10:44:32'),
(195, 'Admin mengupload banner promo: ', '2025-12-03 10:48:05'),
(196, 'Admin menghapus banner: ', '2025-12-03 10:48:33'),
(197, 'Admin mengupload banner promo: ', '2025-12-03 10:51:45'),
(198, 'Admin mengupload banner promo: ', '2025-12-03 10:53:26'),
(199, 'Admin menghapus banner: ', '2025-12-03 10:53:57'),
(200, 'Admin mengupload banner promo: ', '2025-12-03 11:01:38'),
(201, 'Admin menghapus banner: ', '2025-12-03 11:04:23'),
(202, 'Admin menghapus banner: ', '2025-12-03 11:04:26'),
(203, 'Admin menghapus banner: ', '2025-12-03 11:04:29'),
(204, 'Admin mengupload banner promo: ', '2025-12-03 11:04:42'),
(205, 'Admin mengupload banner promo: ', '2025-12-03 11:06:47'),
(206, 'Admin mengupload banner promo: ', '2025-12-03 11:23:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_aktivitas`
--
ALTER TABLE `riwayat_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `riwayat_aktivitas`
--
ALTER TABLE `riwayat_aktivitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
