-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: ci4_db:3306
-- Generation Time: Aug 19, 2025 at 06:39 AM
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
(14, 51, 2, 'bjjk', '2025-08-16 09:22:01');

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
(39, 11, 5, 'dibaca', '2025-08-09 09:54:51'),
(40, 11, 16, 'dibaca', '2025-07-25 15:25:50'),
(53, 13, 3, 'belum dibaca', NULL),
(54, 13, 5, 'dibaca', '2025-08-09 09:54:51'),
(55, 14, 5, 'dibaca', '2025-08-16 13:22:56');

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
  `user_id` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `dari` varchar(255) DEFAULT NULL,
  `kepada` varchar(255) DEFAULT NULL,
  `surat_masuk_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('belum','diterima','ditolak','selesai') DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengajuan_surat_keluar`
--

INSERT INTO `pengajuan_surat_keluar` (`id`, `user_id`, `judul`, `deskripsi`, `dari`, `kepada`, `surat_masuk_id`, `created_at`, `updated_at`, `status`) VALUES
(10, 5, 'mambu', 'kamu badeg tebak ambu\r\n', 'Syahdan Qyan', 'Admin', NULL, '2025-08-08 15:41:32', '2025-08-19 06:27:26', 'diterima'),
(11, 5, 'syahdan', 'mau masuk', 'Syahdan Qyan', 'Admin', NULL, '2025-08-14 09:28:09', '2025-08-19 06:27:26', 'diterima'),
(12, 5, 'slcisa', 'aohscu', 'Syahdan Qyan', 'Admin', 42, '2025-08-15 14:56:25', '2025-08-19 06:27:26', 'ditolak'),
(13, 5, 'smjcjsoj', 'ndaocoeoihcs', 'Syahdan Qyan', 'Admin', 42, '2025-08-15 15:00:22', '2025-08-19 06:27:26', 'diterima'),
(14, 5, 'qwert', 'wertyu', 'Syahdan Qyan', 'Admin', 51, '2025-08-16 13:23:06', '2025-08-19 06:27:26', 'diterima');

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
(3, 'PT. Digital Solusi ', 'DIGISOL', '2025-07-02 15:08:57', '2025-08-19 03:19:45');

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
(24, 'SPb', '001/GAIN-SPb/VIII/2025', 'qewwe', 2, '2025-08-16', 'asdasd', 8, '1755317190_569e9262cb6f760a465d.png', 1, '2025-08-16 04:06:30', NULL),
(25, 'SPp', '002/GAIN-SPp/VIII/2025', 'wertyu', 2, '2025-08-16', 'ygsadasdasd', 8, '1755317217_ccb26a4a28db90f54648.png', 1, '2025-08-16 04:06:57', NULL),
(26, 'SPm', '003/GMTNET-SPm/VIII/2025', 'asdsadasd', 1, '2025-08-16', 'dsadasdsad', 9, '1755317254_aea7847e2908993517da.png', 1, '2025-08-16 04:07:34', NULL);

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
(49, 'ksjhdkasdkhhc', 2, 'aebcjdblea', 'ahfjlnaei', '2025-08-15', '2025-08-15 11:12:40', '1755231160_ef9e8437f08449face1b.png', 2, '2025-08-15 04:12:40', '2025-08-15 04:12:40'),
(51, 'coba', 1, 'sya', 'awcsw', '2025-08-15', '2025-08-15 13:44:56', '1755240296_72fa4541f2ad8173a002.png', 2, '2025-08-15 06:44:56', '2025-08-15 06:44:56'),
(52, 'shdiooci', 1, 'sldcn seknc', 'aecfve', '2025-08-15', '2025-08-15 15:37:16', '1755247036_8ff728fc58ee80539b82.png', 2, '2025-08-15 08:37:16', '2025-08-15 08:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `tanda_tangan`
--

CREATE TABLE `tanda_tangan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tanda_tangan`
--

INSERT INTO `tanda_tangan` (`id`, `user_id`, `file`, `uploaded_at`, `nama`) VALUES
(8, NULL, '1755315891_21b0858df75dc544211d.png', '2025-08-16 10:44:51', 'halo'),
(9, NULL, '1755317233_2659d30cdbf64d968cfc.png', '2025-08-16 11:07:13', 'tes'),
(10, NULL, '1755325339_9770786df3245f3d9d44.png', '2025-08-16 13:22:19', 'yes'),
(11, NULL, 'ttd_1755573604_1755573604_529c613a30d4d0d40720.png', '2025-08-19 10:20:04', 'ahloses');

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
(1, 'Mas Ferry', '$2y$10$qpB.GNi02lCsAv3hM.HXoerMRZ0n.QOv5Gou3cci9kVV/XKxKhRRO', 'admin', 'Ferry Dwiyanto', 'admin@gmail.com', '1755325153_dc1726e8d447345d9664.jpeg', '2025-07-02 15:08:42', '2025-08-16 13:19:13'),
(2, 'Mas Kadimas', '$2y$10$78wnT5w3Oh1OTnp9KB8VR.gp9g/rfpokJw5QItXwGgWBpw2DVjwdC', 'operator', 'Kadimas Yusuf', 'operator@gmail.com', NULL, '2025-07-02 15:36:20', '2025-07-23 06:25:21'),
(3, 'rafinoer', '$2y$10$Z1b1gy07ck2JedUbwEPDsOAX/kM.j3rYiT/Tne0HcM7UTirIJCQZG', 'user', 'rafi noer', 'rasdy@gmail.com', NULL, '2025-07-02 16:14:25', '2025-07-12 06:41:41'),
(5, 'syahdan', '$2y$10$vHcjsdlPiL9fEI6fWiW6Pe/JhdxBsHJSBJ/1MSeoer6F3LGeMukaO', 'user', 'Syahdan Qyan', 'syahdan@gmail.com', NULL, '2025-07-04 09:36:23', '2025-08-15 15:10:50'),
(9, 'user1', '$2y$10$EJdVCCg6NhWqylLUnDp53ubajGCjQ6nGY/xr.qYhjc9u5sbPFkcky', 'user', 'Rafi Noer Salim', 'ahsdasdasd@gmail.com', NULL, '2025-08-19 13:36:42', '2025-08-19 13:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `user_id`, `username`, `full_name`, `role`, `title`, `description`, `type`, `created_at`) VALUES
(1, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 13:17:29'),
(2, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 13:17:39'),
(3, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 13:17:47'),
(4, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 13:17:57'),
(5, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 13:22:51'),
(6, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 13:23:07'),
(7, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Mengirim Surat Masuk', 'Mengirim surat dengan nomor: aykcjadfhe', 'surat-masuk', '2025-08-15 13:27:40'),
(8, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 13:27:53'),
(9, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 13:28:04'),
(10, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 13:43:32'),
(11, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 13:43:51'),
(12, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 13:45:13'),
(13, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 13:45:34'),
(14, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 13:59:40'),
(15, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 13:59:59'),
(16, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Menghapus Surat Masuk', 'Menghapus surat masuk dengan nomor: aykcjadfhe', 'surat-masuk', '2025-08-15 14:00:31'),
(17, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 14:00:50'),
(18, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 14:01:11'),
(19, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 14:48:02'),
(20, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 14:48:21'),
(21, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 14:56:31'),
(22, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 14:56:42'),
(26, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:00:27'),
(27, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:00:36'),
(28, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:04:15'),
(29, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:04:24'),
(30, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:10:22'),
(31, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:10:32'),
(32, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Menghapus Foto Profil', 'Menghapus foto profil', 'profile', '2025-08-15 15:10:50'),
(33, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:10:57'),
(34, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:11:07'),
(35, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:17:15'),
(36, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:17:35'),
(37, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:24:35'),
(38, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:24:58'),
(39, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:31:29'),
(40, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:31:49'),
(41, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Menambahkan Surat Masuk', 'Menambahkan surat masuk dengan nomor: shdiooci', 'surat-masuk', '2025-08-15 15:37:16'),
(42, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:37:25'),
(43, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:37:34'),
(44, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:41:02'),
(45, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:41:16'),
(46, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Menghapus Surat Keluar', 'Menghapus surat keluar dengan nomor: 001/GMTNET-SK/VIII/2025', 'surat-keluar', '2025-08-15 15:41:30'),
(47, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-15 15:41:37'),
(48, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-15 15:41:45'),
(49, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:07:29'),
(50, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:09:23'),
(51, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:09:49'),
(52, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:10:41'),
(53, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:11:04'),
(54, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:11:56'),
(55, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:17:04'),
(56, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Mengirim Disposisi', 'Mengirim disposisi untuk surat ID: 51', 'disposisi', '2025-08-16 09:22:01'),
(57, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:22:36'),
(58, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:22:59'),
(59, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:23:59'),
(60, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:24:27'),
(61, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:28:54'),
(62, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:29:18'),
(63, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:30:03'),
(64, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:31:45'),
(65, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:34:08'),
(66, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:34:31'),
(67, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:38:23'),
(68, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:38:49'),
(69, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Menghapus User', 'Menghapus user dengan username: user1', 'user-management', '2025-08-16 09:40:40'),
(70, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 09:40:58'),
(71, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 09:42:10'),
(72, 2, 'Mas Kadimas', 'Kadimas Yusuf', 'operator', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 10:17:21'),
(73, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 10:17:27'),
(74, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 12:14:49'),
(75, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 12:32:53'),
(76, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 12:32:57'),
(77, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 13:00:28'),
(78, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 13:07:15'),
(79, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 13:18:37'),
(80, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 13:18:41'),
(81, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 13:18:45'),
(82, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 13:19:16'),
(83, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 13:19:19'),
(84, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 13:19:22'),
(85, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 13:20:44'),
(86, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 13:22:32'),
(87, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 13:22:44'),
(88, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Mengajukan Surat Keluar', 'Mengajukan surat keluar untuk surat masuk dengan nomor: coba', 'pengajuan-surat', '2025-08-16 13:23:06'),
(89, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 13:23:13'),
(90, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-16 13:23:17'),
(91, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-16 14:56:14'),
(92, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 09:29:15'),
(93, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 10:06:20'),
(94, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 10:07:01'),
(95, 5, 'syahdan', 'Syahdan Qyan', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 10:08:10'),
(96, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 10:08:13'),
(97, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menambahkan Jenis Surat', 'Menambahkan jenis surat baru: artdsaw (ASU)', 'jenis-surat', '2025-08-19 10:17:44'),
(98, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 10:17:53'),
(99, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 10:18:37'),
(100, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menghapus Jenis Surat', 'Menghapus jenis surat: artdsaw (ASU)', 'jenis-surat', '2025-08-19 10:19:24'),
(101, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Memperbarui Perusahaan', 'Memperbarui data perusahaan: PT. Digital Solusi  (DIGISOL1)', 'perusahaan', '2025-08-19 10:19:36'),
(102, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Memperbarui Perusahaan', 'Memperbarui data perusahaan: PT. Digital Solusi  (DIGISOL)', 'perusahaan', '2025-08-19 10:19:45'),
(103, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Mengupload Tanda Tangan', 'Mengupload tanda tangan digital: ahloses', 'tanda-tangan', '2025-08-19 10:20:04'),
(104, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 10:20:23'),
(105, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 10:22:35'),
(106, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menambahkan User Baru', 'Menambahkan user dengan username: user1 dan role: user', 'user-management', '2025-08-19 10:30:06'),
(107, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 10:30:10'),
(111, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 10:31:26'),
(112, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menghapus User', 'Menghapus user dengan username: user1 (Role: user)', 'user-management', '2025-08-19 10:32:30'),
(113, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menambahkan User Baru', 'Menambahkan user dengan username: user1 dan role: user', 'user-management', '2025-08-19 12:42:26'),
(114, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 12:42:30'),
(117, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 12:50:07'),
(118, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 13:04:18'),
(122, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 13:06:02'),
(123, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menghapus User', 'Menghapus user dengan username: user1 (Role: user)', 'user-management', '2025-08-19 13:06:07'),
(124, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Mengakses Form Surat', 'Mengakses form surat untuk pengajuan ID 16', 'pengajuan_surat', '2025-08-19 13:06:19'),
(125, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menolak Pengajuan Surat', 'Menolak pengajuan surat keluar dengan ID 16', 'pengajuan_surat', '2025-08-19 13:06:24'),
(126, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menambahkan User Baru', 'Menambahkan user dengan username: user1 dan role: user', 'user-management', '2025-08-19 13:08:15'),
(127, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 13:08:33'),
(130, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 13:08:52'),
(131, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 13:25:55'),
(137, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 13:35:31'),
(138, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menghapus User', 'Menghapus user dengan username: user1 (Role: user)', 'user-management', '2025-08-19 13:35:41'),
(139, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Menambahkan User Baru', 'Menambahkan user dengan username: user1 dan role: user', 'user-management', '2025-08-19 13:36:42'),
(140, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 13:37:00'),
(141, 9, 'user1', 'Rafi Noer Salim', 'user', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 13:37:04'),
(142, 9, 'user1', 'Rafi Noer Salim', 'user', 'Logout', 'User keluar dari sistem', 'logout', '2025-08-19 13:37:24'),
(143, 1, 'Mas Ferry', 'Ferry Dwiyanto', 'admin', 'Login Berhasil', 'User berhasil login ke sistem', 'login', '2025-08-19 13:37:29');

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
  ADD KEY `surat_masuk_id` (`surat_masuk_id`),
  ADD KEY `fk_pengajuan_user` (`user_id`);

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
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_activity_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `disposisi_user`
--
ALTER TABLE `disposisi_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pengajuan_surat_keluar`
--
ALTER TABLE `pengajuan_surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tanda_tangan`
--
ALTER TABLE `tanda_tangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

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
  ADD CONSTRAINT `fk_pengajuan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengajuan_surat_keluar_ibfk_1` FOREIGN KEY (`surat_masuk_id`) REFERENCES `surat_masuk` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `fk_createdby` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `fk_tanda_tangan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
