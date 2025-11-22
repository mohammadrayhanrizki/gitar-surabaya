-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2025 at 04:05 AM
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
(1, 'admin', 'admin123');

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
(7, 'promo ', '100%', '19112025133925download.jpeg', '2025-11-19 13:39:25'),
(8, 'diskon 30%', 'murah', '191120251339401401615.png', '2025-11-19 13:39:40');

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
(10, 'ww', '2', '- gitar biasa (Rp 14.000)', 14000.00, '2025-11-19 20:19:17', 'Pending'),
(11, 'ww', '2', '- gitar biasa (Rp 14.000)', 14000.00, '2025-11-19 20:19:17', 'Pending'),
(12, 'rey', '111', '- rey (Rp 13.323)\n- Yamaha Waguri (Rp 1.400.000)', 1413323.00, '2025-11-19 20:31:19', 'Pending'),
(13, 'rey', '111', '- rey (Rp 13.323)\n- Yamaha Waguri (Rp 1.400.000)', 1413323.00, '2025-11-19 20:31:19', 'Pending'),
(14, 'Rey', '08786311811', '- Yamaha Waguri (Rp 1.400.000)\n- gitar biasa (Rp 14.000)', 1414000.00, '2025-11-20 16:16:25', 'Pending');

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
(19, 'Yamaha Waguri', 'Bromo', 1400000.00, 1, 'mulus', '191120251256011401615.png', '2025-11-19 12:56:01'),
(20, 'gitar biasa', 'Yamaha', 14000.00, 1, 'dad', '19112025125631000038500_1551240228-foto_menghitung_persen.jpg', '2025-11-19 12:56:31');

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
(73, 'Admin menghapus produk rey', '2025-11-20 09:17:48');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `riwayat_aktivitas`
--
ALTER TABLE `riwayat_aktivitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
