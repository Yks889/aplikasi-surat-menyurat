-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: ci4_db:3306
-- Generation Time: Jul 23, 2025 at 07:08 AM
-- Server version: 5.7.44
-- PHP Version: 8.2.27

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
  `description` text,
  `type` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `title`, `description`, `type`, `created_at`) VALUES
(1, 3, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 12.001/GMTNET/VII/2025', 'surat-masuk', '2025-07-05 14:27:59'),
(2, 3, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 2344634', 'surat-masuk', '2025-07-05 14:29:48'),
(3, 3, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 25252525', 'surat-masuk', '2025-07-07 11:59:51'),
(6, 3, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 25252525', 'surat-masuk', '2025-07-11 11:11:28'),
(7, 2, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 12345678', 'surat-masuk', '2025-07-12 12:50:55'),
(8, 5, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 1234567', 'surat-masuk', '2025-07-12 13:46:18'),
(9, 16, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 132213', 'surat-masuk', '2025-07-23 06:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id` int(11) NOT NULL,
  `surat_id` int(11) DEFAULT NULL,
  `dari_user_id` int(11) DEFAULT NULL,
  `catatan` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disposisi`
--

INSERT INTO `disposisi` (`id`, `surat_id`, `dari_user_id`, `catatan`, `created_at`) VALUES
(1, 42, NULL, 'asdasdwdads', '2025-07-23 04:03:24'),
(2, 42, NULL, 'AS', '2025-07-23 04:23:34'),
(3, 40, NULL, 'halo', '2025-07-23 05:38:19'),
(4, 42, NULL, 'asd', '2025-07-23 05:47:43'),
(5, 42, NULL, 'yfugh', '2025-07-23 05:48:22'),
(6, 42, 1, 'asdasdsa', '2025-07-23 05:55:51'),
(7, 44, 1, 'pee', '2025-07-23 06:24:22');

-- --------------------------------------------------------

--
-- Table structure for table `disposisi_user`
--

CREATE TABLE `disposisi_user` (
  `id` int(11) NOT NULL,
  `disposisi_id` int(11) DEFAULT NULL,
  `ke_user_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'belum dibaca'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disposisi_user`
--

INSERT INTO `disposisi_user` (`id`, `disposisi_id`, `ke_user_id`, `status`) VALUES
(1, 1, 1, 'belum dibaca'),
(2, 1, 2, 'belum dibaca'),
(3, 1, 3, 'belum dibaca'),
(4, 2, 1, 'belum dibaca'),
(5, 2, 2, 'belum dibaca'),
(6, 3, 5, 'belum dibaca'),
(7, 4, 1, 'belum dibaca'),
(8, 4, 2, 'belum dibaca'),
(9, 5, 2, 'belum dibaca'),
(10, 5, 3, 'belum dibaca'),
(11, 6, 1, 'belum dibaca'),
(12, 6, 2, 'belum dibaca'),
(13, 7, 16, 'belum dibaca');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL COMMENT 'Nama Lengkap Jenis Surat',
  `singkatan` varchar(10) NOT NULL COMMENT 'Singkatan Jenis Surat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_surat`
--

INSERT INTO `jenis_surat` (`id`, `nama`, `singkatan`) VALUES
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
(15, 'Surat Pengantar', 'SPeng'),
(16, 'sktester', 'SJAKSJAHDS');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `singkatan` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama`, `singkatan`, `created_at`, `updated_at`) VALUES
(1, 'PT. Gonet Mandiri', 'GMTNET', '2025-07-02 15:08:57', '2025-07-11 14:10:50'),
(2, 'PT. Global Akses', 'GAIN', '2025-07-02 15:08:57', NULL),
(3, 'PT. Digital Solusi ', 'DIGISOL', '2025-07-02 15:08:57', '2025-07-05 10:42:38');

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
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat_keluar`
--

INSERT INTO `surat_keluar` (`id`, `kode_surat`, `nomor_surat`, `untuk`, `perusahaan_id`, `tanggal_surat`, `perihal`, `penandatangan_id`, `file_surat`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 'SK', '001/GMTNET-SK/VI/2025', 'jjjj', 1, '2025-06-04', 'gggg', 1, '1751620988_4616cf44e35324e8a523.jpg', 1, '2025-07-04 16:23:08', NULL),
(5, 'SK', '001/GMTNET-SK/VIII/2025', 'ffff', 1, '2025-08-01', 'ggg', 1, '1751621102_a6c6813fc251895cd35f.jpg', 1, '2025-07-04 16:25:02', NULL),
(13, 'SK', '001/GMTNE-SK/XI/2029', 'saya', 1, '2029-11-15', 'dzdsdhsd', 1, '1751695636_756c2b58bdbd7ac3cca3.jpg', 2, '2025-07-05 13:07:16', NULL),
(16, 'SPp', '004/GMTNET-SPp/VII/2025', 'admin', 1, '2025-07-12', 'qwerty', 1, '1752292660_6511aa9c7adff4688079.png', 1, '2025-07-12 10:57:40', '2025-07-12 12:52:35'),
(17, 'SPm', '002/GMTNET-SPm/VII/2025', 'kamu', 1, '2025-07-12', 'vvkhb', 1, '1752292913_ebe946e8ab7e3d993dbc.png', 1, '2025-07-12 11:01:53', NULL),
(18, 'SU', '003/GMTNET-SU/VII/2025', 'qwertyu', 1, '2025-07-12', 'qwertyuio', 1, '1752299527_da1dec84c57b02177e30.png', 3, '2025-07-12 12:52:07', NULL);

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat_masuk`
--

INSERT INTO `surat_masuk` (`id`, `nomor_surat`, `perusahaan_id`, `dari`, `perihal`, `tgl_surat`, `waktu_diterima`, `file_surat`, `created_by`, `created_at`, `updated_at`) VALUES
(35, '2345', 2, 'aumaum', 'knapa', '2025-08-07', '2025-07-08 08:01:24', '1751961684_5afa126a60dfe2154c36.jpg', 1, '2025-07-08 08:01:24', '2025-07-08 08:01:24'),
(40, '1234567', 2, 'smkn', 'qwertyui', '2025-07-14', '2025-07-12 03:05:39', '1752289539_954af81697f23260e6b9.png', 1, '2025-07-12 03:05:39', '2025-07-12 03:05:39'),
(41, '123456', 1, 'qwerty', 'qwertyuio', '2025-07-10', '2025-07-12 05:12:29', '1752297149_6c8ed96c3428adb1aa9c.png', 3, '2025-07-12 05:12:29', '2025-07-12 05:12:29'),
(42, '12345678', 1, 'qwerty', 'qwertyui', '2025-07-17', '2025-07-12 05:50:55', '1752299455_0cfaa4bb9e4ccdb256b2.png', 2, '2025-07-12 05:50:55', '2025-07-12 05:50:55'),
(43, '1234567', 1, 'syahdan', 'pkl', '2025-07-12', '2025-07-12 06:46:18', '1752302778_11e2ce601afdb61ba46f.png', 5, '2025-07-12 06:46:18', '2025-07-12 06:46:18'),
(44, '132213', 2, 'saya', 'dsasad', '2025-07-23', '2025-07-23 06:02:47', '1753250567_91a2f726b1c2192c93cd.jpeg', 16, '2025-07-23 06:02:47', '2025-07-23 06:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `tanda_tangan`
--

CREATE TABLE `tanda_tangan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tanda_tangan`
--

INSERT INTO `tanda_tangan` (`id`, `user_id`, `file`, `uploaded_at`) VALUES
(5, 1, '1752633448_20d632069dfb09038689.png', '2025-07-16 02:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','operator','user') NOT NULL DEFAULT 'user',
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `email`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Mas Ferry', '$2y$10$qpB.GNi02lCsAv3hM.HXoerMRZ0n.QOv5Gou3cci9kVV/XKxKhRRO', 'admin', 'Ferry Dwiyanto', 'admin@gmail.com', NULL, '2025-07-02 15:08:42', '2025-07-15 06:51:16'),
(2, 'Mas Kadimas', '$2y$10$78wnT5w3Oh1OTnp9KB8VR.gp9g/rfpokJw5QItXwGgWBpw2DVjwdC', 'operator', 'Kadimas Yusuf', 'operator@gmail.com', NULL, '2025-07-02 15:36:20', '2025-07-23 06:25:21'),
(3, 'rafinoer', '$2y$10$Z1b1gy07ck2JedUbwEPDsOAX/kM.j3rYiT/Tne0HcM7UTirIJCQZG', 'user', 'rafi noer', 'rasdy@gmail.com', NULL, '2025-07-02 16:14:25', '2025-07-12 06:41:41'),
(5, 'syahdan', '$2y$10$vHcjsdlPiL9fEI6fWiW6Pe/JhdxBsHJSBJ/1MSeoer6F3LGeMukaO', 'user', 'Syahdan Qyan', 'syahdan@gmail.com', '1752486978_822cb65dff337f455744.jpg', '2025-07-04 09:36:23', '2025-07-14 09:56:26'),
(16, 'user1', '$2y$10$8UmHkRuV4NDlafwmTTnv9ubKmKN.2l9uRzIZOhf962KiaayiPf57C', 'user', 'Rafi Noer Salim', 'asdsadfh@gmail.com', NULL, '2025-07-23 05:56:58', '2025-07-23 05:56:58');

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
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disposisi_user`
--
ALTER TABLE `disposisi_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `disposisi_user`
--
ALTER TABLE `disposisi_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tanda_tangan`
--
ALTER TABLE `tanda_tangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
