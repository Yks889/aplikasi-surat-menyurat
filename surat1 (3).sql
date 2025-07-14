-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2025 at 11:01 AM
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
-- Database: `surat1`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `title`, `description`, `type`, `created_at`) VALUES
(4, 36, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 12.001/GMTNET/VII/2025', 'surat-masuk', '2025-07-14 11:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL COMMENT 'Nama Lengkap Jenis Surat',
  `singkatan` varchar(10) NOT NULL COMMENT 'Singkatan Jenis Surat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_surat`
--

INSERT INTO `jenis_surat` (`id`, `nama`, `singkatan`) VALUES
(1, 'Surat Keputusan', 'SK'),
(2, 'Surat Undangan', 'SU'),
(3, 'Surat Permohonan', 'SPm'),
(4, 'Surat Pemberitahuan', 'SPb'),
(5, 'Surat Peminjaman', 'SPp'),
(6, 'Surat Pernyataan', 'SPn'),
(7, 'Surat Mandat', 'SM'),
(8, 'Surat Tugas', 'ST'),
(9, 'Surat Keterangan', 'SKet'),
(10, 'Surat Rekomendasi', 'SR'),
(11, 'Surat Balasan', 'SB'),
(12, 'Surat Perintah Perjalanan Dinas', 'SPPD'),
(13, 'Sertifikat', 'SRT'),
(14, 'Perjanjian Kerja', 'PK'),
(15, 'Surat Pengantar', 'SPeng');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `singkatan` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama`, `singkatan`, `created_at`, `updated_at`) VALUES
(1, 'PT. Gonet Mandiri', 'GMTNET', '2025-07-02 15:08:57', '2025-07-08 13:42:14'),
(2, 'PT. Global Akses', 'GAIN', '2025-07-02 15:08:57', NULL),
(3, 'PT. Digital Solusi ', 'DIGISOL', '2025-07-02 15:08:57', '2025-07-05 10:42:38'),
(7, 'saya', 'SAYASSS', '2025-07-08 11:56:58', NULL),
(8, 'sausg', 'SAUD', '2025-07-08 12:31:39', NULL),
(9, 'anjay', 'SU', '2025-07-08 12:35:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id` int(11) NOT NULL,
  `kode_surat` varchar(100) NOT NULL,
  `nomor_surat` varchar(100) NOT NULL,
  `untuk` varchar(255) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `perihal` text NOT NULL,
  `penandatangan_id` int(11) DEFAULT NULL,
  `file_surat` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_keluar`
--

INSERT INTO `surat_keluar` (`id`, `kode_surat`, `nomor_surat`, `untuk`, `perusahaan_id`, `tanggal_surat`, `perihal`, `penandatangan_id`, `file_surat`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 'SK', '001/GMTNET-SK/VI/2025', 'jjjj', 1, '2025-06-04', 'gggg', 1, '1751620988_4616cf44e35324e8a523.jpg', 1, '2025-07-04 16:23:08', NULL),
(5, 'SK', '001/GMTNET-SK/VIII/2025', 'ffff', 1, '2025-08-01', 'ggg', 1, '1751621102_a6c6813fc251895cd35f.jpg', 1, '2025-07-04 16:25:02', NULL),
(13, 'SK', '002/GMTNET-SK/XI/2029', 'saya', 1, '2029-11-15', 'dzdsdhsd', 1, '1751695636_756c2b58bdbd7ac3cca3.jpg', 2, '2025-07-05 13:07:16', '2025-07-10 11:48:34'),
(14, 'SKet', '011/GMTNET-SPm/VII/2025', 'saya', 1, '2025-07-08', 'kasdusdhhdsa', 1, '1751956855_cd429306eeb718c438b9.png', 1, '2025-07-08 13:40:55', '2025-07-08 15:03:02'),
(15, 'SKet', '008/GAIN-SKet/VII/2025', 'uasdhhhh', 2, '2025-07-23', 'asudsd', 1, '1751957990_f8fe4bb5963c007b4ce9.png', 1, '2025-07-08 13:59:50', '2025-07-14 11:00:04'),
(16, 'SPm', '005/GAIN-SPm/VII/2025', 'saya', 2, '2025-07-08', 'hadhasjd', 1, '1751958797_8a9beb802c988fa7b3f6.png', 1, '2025-07-08 14:13:17', '2025-07-10 09:39:25'),
(20, 'SPp', '007/GAIN-SPp/VII/2025', 'saya', 2, '2025-07-10', 'uashda', 1, '1752115020_cb1d28d9ffcc7fef9e18.png', 1, '2025-07-10 09:37:00', '2025-07-11 14:22:52'),
(21, 'SU', '005/GMTNET-SU/VII/2025', 'asyd', 1, '2025-07-10', 'kjsad', 1, '1752122202_7353b0029fa0ab8e7d5f.png', 2, '2025-07-10 11:36:42', NULL),
(22, 'SU', '006/GAIN-SU/VII/2025', 'saya', 2, '2025-07-10', 'ashdsad', 1, '1752123421_90cf268df6a138661aa6.png', 1, '2025-07-10 11:57:01', NULL),
(23, 'SPb', '007/SAUD-SPb/VII/2025', 'saya', 8, '2025-07-11', 'sagdasd', 1, '1752221285_aeb54737e8f9a2fd8c7c.jpg', 1, '2025-07-11 15:08:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(100) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `dari` varchar(100) NOT NULL,
  `perihal` text NOT NULL,
  `tgl_surat` date NOT NULL,
  `waktu_diterima` datetime NOT NULL,
  `file_surat` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_masuk`
--

INSERT INTO `surat_masuk` (`id`, `nomor_surat`, `perusahaan_id`, `dari`, `perihal`, `tgl_surat`, `waktu_diterima`, `file_surat`, `created_by`, `created_at`, `updated_at`) VALUES
(23, '001.0.5/109/109.3.0.4.6. 12/2025', 1, 'saya', 'sasa', '2025-07-15', '2025-07-05 03:47:24', '1751687244_b2dfe7fbeea1792bd62f.jpg', 1, '2025-07-05 03:47:24', '2025-07-05 03:47:24'),
(35, '12531234777hjjj', 2, 'saya', 'yewgdushhh', '2025-07-16', '2025-07-08 04:54:37', '1751950477_14b2c7facd3fe5fb447f.jpg', 1, '2025-07-08 04:54:37', '2025-07-10 04:22:58'),
(36, '11.001/GAIN/VII/2025', 2, 'saya', 'ijsadiasd', '2025-07-09', '2025-07-08 08:01:14', '1751961674_a79407d6c47645a368e2.png', 1, '2025-07-08 08:01:14', '2025-07-08 08:01:14'),
(37, '43231', 3, 'saya', 'agsdhid', '2025-07-10', '2025-07-10 04:23:30', '1752121410_a584a982739f6eb40d41.png', 2, '2025-07-10 04:23:30', '2025-07-10 04:23:30'),
(38, '261354', 2, 'saya', 'uagduhsgd', '2025-07-22', '2025-07-10 04:27:37', '1752121657_7a90c7a5ede353af8363.png', 1, '2025-07-10 04:27:37', '2025-07-10 04:40:31'),
(39, '11.001/GAIN/VII/2025', 2, 'salim', 'gonet homee', '2025-07-25', '2025-07-10 07:04:52', '1752131092_1910381dfefb6e6958c3.png', 2, '2025-07-10 07:04:52', '2025-07-10 07:04:52'),
(41, '121234213', 2, 'uagdsasd', 'ausdsad', '2025-07-14', '2025-07-14 03:47:29', '1752464849_a8b850dfb11bdf85c47b.png', 1, '2025-07-14 03:47:29', '2025-07-14 03:47:29'),
(42, '12.001/GMTNET/VII/2025', 1, 'saya', 'qwertyuio', '2025-07-14', '2025-07-14 04:21:00', '1752466860_207ef6b1fdfcbe906333.png', 36, '2025-07-14 04:21:00', '2025-07-14 04:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `tanda_tangan`
--

CREATE TABLE `tanda_tangan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tanda_tangan`
--

INSERT INTO `tanda_tangan` (`id`, `user_id`, `file`, `uploaded_at`) VALUES
(4, 6, '1752476682_e52042a496421f007a02.png', '2025-07-14 07:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires_at` datetime DEFAULT NULL,
  `role` enum('admin','operator','user') NOT NULL DEFAULT 'user',
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `reset_token`, `reset_expires_at`, `role`, `full_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'b8da92b0a2690df02fc8663dce5829316b752f92482cc5ba3efff22489bac550', '2025-07-11 04:37:27', 'admin', 'Mas Ferry ', 'admin@gmail.com', '2025-07-02 15:08:42', '2025-07-14 04:17:52'),
(2, 'Mas Dimas', '$2y$10$czvmP3Ep0mALWufW0c4UwO9x5zVpRyKVDyeW0kZIdOZq.x3oCAGLW', NULL, NULL, 'operator', 'Kadimas Yusuf Fhatur', 'hashduas@gmail.com', '2025-07-02 15:36:20', '2025-07-14 02:41:59'),
(5, 'syahdanu', '$2y$10$tEBELSJZuSZpQFYUSYSrAu2s5P/DBsJEOgZ4k0Hhm7dX0GnDlE8Mq', NULL, NULL, 'user', 'Syahdan Qyaan', 'syahdan@gmail.com', '2025-07-04 09:36:23', '2025-07-11 07:26:04'),
(6, 'admin2', '$2y$10$wLiDXaAcEXX/puN/IOUi1u9oKHsRvSniBa43EnPClw2NdOHp3rk7u', NULL, NULL, 'admin', 'Mas Wahyu', 'admin@gmail.com', '2025-07-05 04:15:54', '2025-07-14 07:04:15'),
(16, 'dadid', '$2y$10$i5pwYv3wICExMdx5vPszfehNa5j0UrAtOJxyktrppvbG429EJfpH6', NULL, NULL, 'operator', 'dadid maulanaaaa', 'saya123@gmail.com', '2025-07-08 10:52:10', '2025-07-08 10:52:52'),
(31, 'user77', '$2y$10$/T.EnVbFqVpJ65Xrg7r2L.hExXIJToME8dJBSV.PIqth2q5fcRtTW', NULL, NULL, 'user', 'asdisad', 'daiufasdadsh@gmail.com', '2025-07-12 07:51:31', '2025-07-12 07:51:31'),
(34, 'usertt', '$2y$10$Sec8tu75xmWxGST29Pj/x.avVI8ExoDl9m/Dq7HL2JD.cKCmNRKb2', NULL, NULL, 'operator', 'JASYGDASD', 'aysdasd@gmail.com', '2025-07-14 02:39:46', '2025-07-14 02:39:46'),
(35, 'usad44', '$2y$10$4pLw27fCaYTYRR7GFTOEnOUAioUsCLkvjFirk47r2.zlO4PXxl6jm', NULL, NULL, 'user', 'asudas', 'ausdasd@gmail.com', '2025-07-14 02:42:53', '2025-07-14 02:42:53'),
(36, 'sitan', '$2y$10$d6FMoUexHWoVZeuaIJZk3OR79KRoWmw7fyKfrEnqkO8uai0WoO4CO', NULL, NULL, 'user', 'sitan', 'sitan@gmail.com', '2025-07-14 04:20:06', '2025-07-14 04:20:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perusahaan_id` (`perusahaan_id`),
  ADD KEY `penandatangan_id` (`penandatangan_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_suratmasuk_perusahaan` (`perusahaan_id`),
  ADD KEY `fk_suratmasuk_user` (`created_by`);

--
-- Indexes for table `tanda_tangan`
--
ALTER TABLE `tanda_tangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tanda_tangan`
--
ALTER TABLE `tanda_tangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `fk_createdby` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_penandatangan` FOREIGN KEY (`penandatangan_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_perusahaan` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `fk_suratmasuk_perusahaan` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_suratmasuk_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tanda_tangan`
--
ALTER TABLE `tanda_tangan`
  ADD CONSTRAINT `tanda_tangan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
