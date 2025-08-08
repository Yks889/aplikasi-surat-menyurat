-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: ci4_db:3306
-- Generation Time: Aug 08, 2025 at 04:22 AM
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
(11, 16, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 1253216398426', 'surat-masuk', '2025-08-04 02:55:32');

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
(11, 43, 2, 'tester', '2025-07-25 07:59:53'),
(13, 42, 2, 'mohon ditindak lanjuti tesss', '2025-07-25 08:10:57'),
(25, 46, 2, 'qwertyui', '2025-08-04 10:01:53'),
(26, 46, 1, 'adhsajdaxan', '2025-08-04 14:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `disposisi_user`
--

CREATE TABLE `disposisi_user` (
  `id` int(11) NOT NULL,
  `disposisi_id` int(11) DEFAULT NULL,
  `ke_user_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'belum dibaca',
  `dibaca_pada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disposisi_user`
--

INSERT INTO `disposisi_user` (`id`, `disposisi_id`, `ke_user_id`, `status`, `dibaca_pada`) VALUES
(38, 11, 3, 'belum dibaca', NULL),
(39, 11, 5, 'belum dibaca', NULL),
(40, 11, 16, 'dibaca', '2025-07-25 15:25:50'),
(53, 13, 3, 'belum dibaca', NULL),
(54, 13, 5, 'belum dibaca', NULL),
(88, 25, 3, 'belum dibaca', NULL),
(89, 25, 5, 'belum dibaca', NULL),
(90, 25, 16, 'dibaca', '2025-08-04 14:14:18'),
(94, 26, 3, 'belum dibaca', NULL),
(95, 26, 16, 'dibaca', '2025-08-04 14:14:18');

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
-- Table structure for table `pengajuan_surat_keluar`
--

CREATE TABLE `pengajuan_surat_keluar` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `dari` varchar(255) DEFAULT NULL,
  `kepada` varchar(255) DEFAULT NULL,
  `surat_masuk_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('belum','diterima','ditolak') DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengajuan_surat_keluar`
--

INSERT INTO `pengajuan_surat_keluar` (`id`, `judul`, `deskripsi`, `dari`, `kepada`, `surat_masuk_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 'halo', 'qwerty', 'Rafi Noer Salim', 'Admin', 46, '2025-08-05 02:51:50', '2025-08-05 11:10:09', 'diterima'),
(2, 'qwerty', 'qwertyu', 'Rafi Noer Salim', 'Admin', 46, '2025-08-05 14:50:43', '2025-08-05 14:56:44', 'ditolak'),
(3, 'qwerty', 'nshdygada', 'Rafi Noer Salim', 'Admin', 46, '2025-08-06 16:07:29', '2025-08-06 16:07:29', 'belum'),
(4, 'wdfAA SCA', 'MCASDADA\r\n', 'Rafi Noer Salim', 'Admin', 46, '2025-08-06 16:09:17', '2025-08-06 16:09:17', 'belum'),
(5, 'duwqduqw', 'anuasiasncisc', 'Rafi Noer Salim', 'Admin', NULL, '2025-08-07 11:52:24', '2025-08-07 11:52:24', 'belum'),
(6, 'asdaysduasd', 'sbdusadasdiasd', 'Rafi Noer Salim', 'Admin', NULL, '2025-08-07 13:40:44', '2025-08-07 13:40:44', 'belum'),
(7, 'gyasdau', 'ashudsahdiasd', 'Rafi Noer Salim', 'Admin', NULL, '2025-08-07 13:44:30', '2025-08-07 13:44:30', 'belum'),
(8, 'sadsadsad', 'asdas', 'Rafi Noer Salim', 'Admin', NULL, '2025-08-07 13:45:59', '2025-08-07 14:18:33', 'diterima'),
(9, 'fdsafsd', 'sdfsdfsdf', 'Rafi Noer Salim', 'Admin', NULL, '2025-08-07 13:46:42', '2025-08-07 14:08:28', 'ditolak');

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
(17, 'SPm', '002/GMTNET-SPm/VII/2025', 'kamu', 1, '2025-07-12', 'vvkhb', 1, '1752292913_ebe946e8ab7e3d993dbc.png', 1, '2025-07-12 11:01:53', NULL),
(18, 'SU', '003/GMTNET-SU/VII/2025', 'qwertyu', 1, '2025-07-12', 'qwertyuio', 1, '1752299527_da1dec84c57b02177e30.png', 3, '2025-07-12 12:52:07', NULL),
(19, 'SPm', '004/GAIN-SPm/VII/2025', 'sayaasdasd', 2, '2025-07-24', 'asdasdsad', 1, '1753416057_69b800bce1fd7d03606a.docx', 1, '2025-07-25 04:00:57', NULL),
(20, 'SPp', '002/GMTNET-SPp/VIII/2025', 'saya', 1, '2025-08-05', 'qwertyu', 1, '1754361868_8ea59bb91a1713bfe7e2.png', 1, '2025-08-05 02:44:28', NULL);

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
(41, '123456', 1, 'qwerty', 'qwertyuio', '2025-07-10', '2025-07-12 05:12:29', '1752297149_6c8ed96c3428adb1aa9c.png', 3, '2025-07-12 05:12:29', '2025-07-12 05:12:29'),
(42, '12345678', 1, 'qwerty', 'qwertyui', '2025-07-17', '2025-07-12 05:50:55', '1752299455_0cfaa4bb9e4ccdb256b2.png', 2, '2025-07-12 05:50:55', '2025-07-12 05:50:55'),
(43, '1234567', 1, 'syahdan', 'pkl', '2025-07-12', '2025-07-12 06:46:18', '1752302778_11e2ce601afdb61ba46f.png', 5, '2025-07-12 06:46:18', '2025-07-12 06:46:18'),
(46, '1253216398426', 1, 'saya', 'wqwertyghjk,', '2025-08-04', '2025-08-04 09:55:32', '1754276132_2a76f4b849bd98a63c7f.jpeg', 16, '2025-08-04 02:55:32', '2025-08-04 02:55:32');

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
(6, 1, '1753498219_ee0ba0afe11543051337.jpeg', '2025-07-26 09:50:19');

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
(1, 'Mas Ferry', '$2y$10$qpB.GNi02lCsAv3hM.HXoerMRZ0n.QOv5Gou3cci9kVV/XKxKhRRO', 'admin', 'Ferry Dwiyanto', 'admin@gmail.com', '1753508683_0db3dc4c9a458b32197d.jpeg', '2025-07-02 15:08:42', '2025-07-26 12:45:10'),
(2, 'Mas Kadimas', '$2y$10$78wnT5w3Oh1OTnp9KB8VR.gp9g/rfpokJw5QItXwGgWBpw2DVjwdC', 'operator', 'Kadimas Yusuf', 'operator@gmail.com', NULL, '2025-07-02 15:36:20', '2025-07-23 06:25:21'),
(3, 'rafinoer', '$2y$10$Z1b1gy07ck2JedUbwEPDsOAX/kM.j3rYiT/Tne0HcM7UTirIJCQZG', 'user', 'rafi noer', 'rasdy@gmail.com', NULL, '2025-07-02 16:14:25', '2025-07-12 06:41:41'),
(5, 'syahdan', '$2y$10$vHcjsdlPiL9fEI6fWiW6Pe/JhdxBsHJSBJ/1MSeoer6F3LGeMukaO', 'user', 'Syahdan Qyan', 'syahdan@gmail.com', '1752486978_822cb65dff337f455744.jpg', '2025-07-04 09:36:23', '2025-07-14 09:56:26'),
(16, 'user1', '$2y$10$8UmHkRuV4NDlafwmTTnv9ubKmKN.2l9uRzIZOhf962KiaayiPf57C', 'user', 'Rafi Noer Salim', 'asdsadfh@gmail.com', '1753508563_af0dc1fcc6344451c51b.png', '2025-07-23 05:56:58', '2025-07-26 12:42:43');

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
-- Indexes for table `pengajuan_surat_keluar`
--
ALTER TABLE `pengajuan_surat_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_masuk_id` (`surat_masuk_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `disposisi_user`
--
ALTER TABLE `disposisi_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pengajuan_surat_keluar`
--
ALTER TABLE `pengajuan_surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tanda_tangan`
--
ALTER TABLE `tanda_tangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `pengajuan_surat_keluar`
--
ALTER TABLE `pengajuan_surat_keluar`
  ADD CONSTRAINT `pengajuan_surat_keluar_ibfk_1` FOREIGN KEY (`surat_masuk_id`) REFERENCES `surat_masuk` (`id`) ON DELETE SET NULL;

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
