-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2025 at 01:01 AM
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
(7, 'keren', '01122025125845Macbook-Air-localhost.png', '2025-12-01 12:58:45');

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
(31, 'HMF Kuroi Drednought', 'Karafuru', 450000.00, 1, 'Murah', '02122025173859Karafuru1.jpg', '2025-12-02 10:38:59'),
(32, 'HMF SEMI', 'Karafuru', 400000.00, 2, 'Murah', '02122025174028HMF SEMI.jpg', '2025-12-02 10:40:28'),
(33, 'Cowboy GW/GWC 240 NA/NS', 'Cowboy', 850000.00, 2, 'Berkualitas', '02122025174133Cowboy1.jpg', '2025-12-02 10:41:33'),
(34, 'Cowboy GW 120 NA/NS', 'Cowboy', 750000.00, 2, 'Berkualitas', '02122025174331Cowboy2.jpg', '2025-12-02 10:43:31'),
(35, 'Cowboy CG 100 NA/CGC 100 NS', 'Cowboy', 800000.00, 2, 'Berkualitas', '02122025174640Cowboy3.jpg', '2025-12-02 10:46:40'),
(36, 'Cowboy AEG C GNS/GNS', 'Cowboy', 1200000.00, 2, 'Berkualitas', '02122025174814Cowboy4.jpg', '2025-12-02 10:48:14'),
(37, 'DND Karafuru Viber', 'Karafuru', 900000.00, 1, 'Murah', '02122025174924Karafuru2.jpg', '2025-12-02 10:49:24'),
(38, 'FJR Karafuru Kuroi', 'Karafuru', 475000.00, 2, 'Murah ', '02122025175053Karafuru3.jpg', '2025-12-02 10:50:53'),
(39, 'Bromo BAA4CE', 'Bromo', 1950000.00, 2, 'Keren', '02122025175300Bromo2.jpg', '2025-12-02 10:53:00'),
(40, 'Bromo BAA2CE', 'Bromo', 1860000.00, 1, 'Berkualitas', '02122025175645Bromo3.jpg', '2025-12-02 10:56:45'),
(41, 'Bromo BAA8S', 'Bromo', 1660000.00, 2, 'Berkualitas', '02122025175841Bromo4.jpg', '2025-12-02 10:58:41'),
(42, 'Bromo BAT2M', 'Bromo', 2150000.00, 2, 'BErkualitas', '02122025175950Bromo5.jpg', '2025-12-02 10:59:50'),
(43, 'Cowboy AEG 240/235 GNS', 'Cowboy', 1200000.00, 2, 'Keren', '02122025180108cowboy5.jpg', '2025-12-02 11:01:08'),
(44, 'Odlair OM501 Blue Denim/Chinos', 'Odlair', 2200000.00, 2, 'Bagus', '02122025180243Odlair1.jpg', '2025-12-02 11:02:43'),
(45, 'Karafuru Shiroi', 'Karafuru', 650000.00, 2, 'Murah', '02122025180455Karafuru4.jpg', '2025-12-02 11:04:55'),
(46, 'Bromo BAA1', 'Bromo', 1410000.00, 2, 'Berkualitas', '02122025180858Bromo6.jpg', '2025-12-02 11:08:58'),
(47, 'Bromo BAB1', 'Bromo', 1310000.00, 2, 'Berkualitas', '02122025181102Bromo7.jpg', '2025-12-02 11:11:02'),
(48, 'Bromo BAR1H', 'Bromo', 3750000.00, 2, 'Berkualitas', '02122025185832Bromo8.jpg', '2025-12-02 11:58:32'),
(49, 'Odlair OD511 S', 'Odlair', 2225000.00, 2, 'Keren', '02122025190123Odlair2.jpg', '2025-12-02 12:01:23'),
(50, 'Yamaha Apx600 Natural', 'Yamaha', 3100000.00, 2, 'Berkualitas', '02122025190704Yamaha3.jpg', '2025-12-02 12:07:04'),
(51, 'Yamaha Apx600 OBB (Oriental Blue Burst)', 'Yamaha', 3100000.00, 2, 'Berkualitas', '02122025190844Yamaha4.jpg', '2025-12-02 12:08:44'),
(52, 'Yamaha FS100C', 'Yamaha', 1650000.00, 2, 'Berkualitas', '02122025191024yamaha5.jpg', '2025-12-02 12:10:24'),
(53, 'Yamaha Cs40', 'Yamaha', 1550000.00, 2, 'Berkualitas', '02122025191219yamaha6.jpg', '2025-12-02 12:12:19'),
(54, 'Yamaha f310 Original', 'Yamaha', 1450000.00, 2, 'Berkualitas', '02122025191901yamaha8.jpg', '2025-12-02 12:19:01'),
(55, 'Yamaha C315 Original', 'Yamaha', 1200000.00, 2, 'Berkualitas', '02122025192538Yamaha9.jpg', '2025-12-02 12:25:38'),
(56, 'Cowboy GWC360 NT', 'Cowboy', 1100000.00, 2, 'Bagus', '03122025074922Cowboy6.jpg', '2025-12-03 00:49:22'),
(57, 'Cowboy junior gw120', 'Cowboy', 750000.00, 2, 'Bagus', '03122025075051cowboy7.jpg', '2025-12-03 00:50:51'),
(58, 'Cowboy gwc235', 'Cowboy', 800000.00, 2, 'Bagus', '03122025075149cowboy8.jpg', '2025-12-03 00:51:49'),
(59, 'COWBOY CGC100', 'Cowboy', 800000.00, 2, 'Bagus', '03122025075357cowboy9.jpg', '2025-12-03 00:53:57'),
(60, 'cowboy GW2/3', 'Cowboy', 800000.00, 2, 'Bagus', '03122025075507cowboy10.jpg', '2025-12-03 00:55:07'),
(61, 'cowboy gwc240 na/ns original', 'Cowboy', 850000.00, 2, 'Bagus', '03122025075651cowboy11.jpg', '2025-12-03 00:56:51'),
(62, 'karafuru saki', 'Karafuru', 350000.00, 4, 'Murah', '03122025075756karafuru5.jpg', '2025-12-03 00:57:56'),
(63, 'yamaha f400 original', 'Yamaha', 165000.00, 1, 'Berkualitas', '03122025075949yamaha10.jpg', '2025-12-03 00:59:49');

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
(152, 'Admin menambahkan produk yamaha f400 original (Stok: 1)', '2025-12-03 00:59:49');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `riwayat_aktivitas`
--
ALTER TABLE `riwayat_aktivitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
