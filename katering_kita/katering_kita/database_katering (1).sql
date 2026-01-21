-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2026 at 09:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_katering`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `session_id`, `id_menu`, `nama_menu`, `harga`, `qty`, `subtotal`, `created_at`) VALUES
(1, 'de0fjk8bt8aukkfpggt9u3jh14', 1, 'Nasi Box Ayam', 25000.00, 1, 25000.00, '2025-12-21 15:30:32'),
(2, 'de0fjk8bt8aukkfpggt9u3jh14', 2, 'Snack Box', 15000.00, 1, 15000.00, '2025-12-21 15:31:07'),
(3, 'de0fjk8bt8aukkfpggt9u3jh14', 1, 'Nasi Box Ayam', 25000.00, 1, 25000.00, '2025-12-21 15:31:17'),
(4, 'mqm551897hu4paqsllcjlk6g3l', 2, 'Snack Box', 15000.00, 2, 30000.00, '2025-12-21 23:41:02'),
(5, 'mqm551897hu4paqsllcjlk6g3l', 1, 'Nasi Box Ayam', 25000.00, 1, 25000.00, '2025-12-21 23:44:26'),
(6, 'mqm551897hu4paqsllcjlk6g3l', 1, 'Nasi Box Ayam', 25000.00, 1, 25000.00, '2025-12-21 23:45:05'),
(7, 'mqm551897hu4paqsllcjlk6g3l', 2, 'Snack Box', 15000.00, 2, 30000.00, '2025-12-21 23:46:17'),
(8, 'mqm551897hu4paqsllcjlk6g3l', 1, 'Nasi Box Ayam', 25000.00, 1, 25000.00, '2025-12-21 23:47:32'),
(9, 'mqm551897hu4paqsllcjlk6g3l', 2, 'Snack Box', 15000.00, 2, 30000.00, '2025-12-21 23:48:19'),
(10, 'g7ojghehkg4lkf5umc9tulnm36', 1, 'Nasi Box Ayam', 25000.00, 1, 25000.00, '2025-12-22 00:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `jenis_kontak` enum('instagram','email','whatsapp','lokasi') NOT NULL,
  `nilai` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id_kontak`, `jenis_kontak`, `nilai`, `icon`, `status_aktif`, `created_at`) VALUES
(1, 'instagram', 'Catering_Kita', 'fab fa-instagram text-danger', 1, '2025-11-30 14:12:29'),
(2, 'email', 'cateringkita@gmail.com', 'fas fa-envelope text-primary', 1, '2025-11-30 14:12:29'),
(3, 'whatsapp', '082455667788', 'fab fa-whatsapp text-success', 1, '2025-11-30 14:12:29'),
(4, 'lokasi', 'https://www.google.com/maps?q=-0.9561132,100.4113067&z=17&hl=en', 'fas fa-map-marker-alt text-danger', 1, '2025-11-30 14:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `status` enum('tersedia','habis') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `id_kategori`, `nama_menu`, `deskripsi`, `harga`, `foto`, `status`) VALUES
(1, NULL, 'Nasi Box Ayam', '', 25000.00, 'https://itsfood.id/uploads/images/products/display/Product_8751.jpg', 'tersedia'),
(2, NULL, 'Snack Box', NULL, 15000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRrJDQdUXHHUbaKiC1rwbJENPTdx7UXzNWOtw&s', 'tersedia'),
(4, NULL, 'Risoles', '', 2000.00, 'https://assets.unileversolutions.com/recipes-v2/257225.jpg', 'tersedia'),
(6, NULL, 'Ikan Bakar', 'Ikan bakar uenak', 17000.00, 'https://img-global.cpcdn.com/recipes/2ccac1143bd680b2/1200x630cq80/photo.jpg', 'tersedia'),
(8, NULL, 'Pecel Lele', '', 17000.00, 'https://assets.pikiran-rakyat.com/crop/0x0:0x0/720x0/webp/photo/2023/01/25/2724889521.jpg', 'tersedia'),
(9, NULL, 'Tahu Isi', 'Tahu isi rasa keju', 3000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTnc1Sg362Tfx3jcNl7C6SLXzYwZ4U_8leK8A&s', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id_metode` int(11) NOT NULL,
  `nama_metode` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id_metode`, `nama_metode`, `status`, `created_at`) VALUES
(1, 'Transfer Bank', 1, '2026-01-02 11:43:56'),
(2, 'Cash on Delivery', 1, '2026-01-02 11:43:56'),
(3, 'OVO', 1, '2026-01-02 11:43:56'),
(4, 'GoPay', 1, '2026-01-02 11:43:56'),
(6, 'DANA', 1, '2026-01-03 09:40:17');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_acara` date NOT NULL,
  `metode_pembayaran` enum('Transfer Bank','Cash on Delivery','OVO','GoPay') NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `status_pesanan` enum('menunggu_pembayaran','sudah_bayar','dikirim','selesai','dibatalkan') DEFAULT 'menunggu_pembayaran',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bukti_transfer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `nama`, `telepon`, `email`, `alamat`, `tanggal_acara`, `metode_pembayaran`, `total_harga`, `status_pesanan`, `created_at`, `bukti_transfer`) VALUES
(9, 'is', '456', 'ind@gmail.com', 'ghh', '2026-01-10', 'Transfer Bank', 45000.00, 'selesai', '2026-01-03 02:33:17', NULL),
(22, 'aziz', '085265969168', 'nickname0836617363@gmail.com', 'adsad', '2026-01-10', '', 42000.00, 'sudah_bayar', '2026-01-10 11:16:15', NULL),
(52, 'aziz', '085265969168', 'nickname0836617363@gmail.com', 'pauh', '2026-01-21', '', 20000.00, 'menunggu_pembayaran', '2026-01-20 20:09:16', NULL),
(53, 'aziz', '085265969168', 'nickname0836617363@gmail.com', 'pauh', '2026-01-21', '', 20000.00, 'sudah_bayar', '2026-01-20 20:11:22', NULL),
(54, 'Radhiatul Zahra', '12312313', 'radhiatulzahra57@gmail.com', 'Talang', '2026-01-21', 'GoPay', 45000.00, '', '2026-01-20 20:19:14', NULL),
(55, 'Radhiatul Zahra', '12312313', 'radhiatulzahra57@gmail.com', 'Talang', '2026-01-21', 'GoPay', 45000.00, 'sudah_bayar', '2026-01-20 20:19:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan') DEFAULT 'pelanggan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `password`, `role`, `created_at`, `username`) VALUES
(7, 'admin', '$2y$10$oHyN4/K655KVQeN.pyuCnO0QXSQzfVTPb4CRXUJOco4mp9RGBYY7W', 'admin', '2026-01-02 09:31:51', 'admin'),
(8, 'laras', '$2y$10$uE1G4W3sRQqwoWTa/FzypepIG1vkYkn3lH2VS2Y5YnN2ipe1tysCK', 'pelanggan', '2026-01-02 10:22:28', 'lala'),
(12, 'aziz', '$2y$10$vSNOnYLtIRLC1TPCYewTbeewegtFxIX2uwMSWn/ByhLUl.RWF3xBS', 'pelanggan', '2026-01-20 18:53:49', 'aziz'),
(13, 'Farhan Nul Aziz', '$2y$10$KRKNCz9Eft7POv0FQlWOlu0J7IwvMWZDxxS21V.8EieKFTdu/9kru', 'pelanggan', '2026-01-20 20:00:53', 'farhan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id_metode`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id_metode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_menu` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
