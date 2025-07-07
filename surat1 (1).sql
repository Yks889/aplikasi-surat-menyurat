-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 04:35 AM
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
(1, 3, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 12.001/GMTNET/VII/2025', 'surat-masuk', '2025-07-05 14:27:59'),
(2, 3, 'Mengirim Surat', 'Anda mengirim surat dengan nomor: 2344634', 'surat-masuk', '2025-07-05 14:29:48');

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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama`, `singkatan`, `created_at`, `updated_at`) VALUES
(1, 'PT. Gonet Mandiri', 'GMTNE', '2025-07-02 15:08:57', '2025-07-05 10:43:00'),
(2, 'PT. Global Akses', 'GAIN', '2025-07-02 15:08:57', NULL),
(3, 'PT. Digital Solusi ', 'DIGISOL', '2025-07-02 15:08:57', '2025-07-05 10:42:38'),
(4, 'tester', 'GMTS', '2025-07-04 15:05:23', NULL),
(5, 'woy', 'WOYU', '2025-07-05 11:16:38', NULL),
(6, 'jasdu', 'ASJD', '2025-07-05 16:40:04', NULL);

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
(1, '07', '001/GMTNET-SM/VII/2025', 'dsjasd', 1, '2025-07-04', 'adasd', 1, '1751620571_5b10eb7d2b05da21f239.jpg', 1, '2025-07-04 16:16:11', NULL),
(2, '08', '002/GAIN-ST/VII/2025', 'sdfdsf', 2, '2025-07-04', 'dfsdjf', 1, '1751620903_d91a418bc2c0352467d8.jpg', 1, '2025-07-04 16:21:43', NULL),
(3, 'SK', '003/GMTNET-SK/VII/2025', 'jjjj', 1, '2025-07-04', 'jjjj', 1, '1751620934_e44321bcf0da9bd29f24.jpg', 1, '2025-07-04 16:22:14', NULL),
(4, 'SK', '001/GMTNET-SK/VI/2025', 'jjjj', 1, '2025-06-04', 'gggg', 1, '1751620988_4616cf44e35324e8a523.jpg', 1, '2025-07-04 16:23:08', NULL),
(5, 'SK', '001/GMTNET-SK/VIII/2025', 'ffff', 1, '2025-08-01', 'ggg', 1, '1751621102_a6c6813fc251895cd35f.jpg', 1, '2025-07-04 16:25:02', NULL),
(6, 'SK', '004/GAIN-SK/VII/2025', 'saya', 2, '2025-07-05', 'ajsdhd', 1, '1751688832_6c49ac12b9cf3bc33a24.jpg', 1, '2025-07-05 11:13:52', NULL),
(7, 'SK', '005/GMTNE-SK/VII/2025', 'saya', 1, '2025-07-05', 'hggugugug', 6, '1751689038_7277ff1a70dd421b38ec.jpg', 1, '2025-07-05 11:17:18', NULL),
(8, 'SK', '006/GMTNE-SK/VII/2025', 'saya', 1, '2025-07-05', 'uasdushdahsd', 1, '1751689927_06acf8973e4a4810575b.jpg', 1, '2025-07-05 11:32:07', NULL),
(9, 'PK', '007/GMTNE-PK/VII/2025', 'tester', 1, '2025-07-05', 'halooo', 1, '1751689961_ebd75d180cfef30e29a7.jpg', 1, '2025-07-05 11:32:41', NULL),
(10, 'SPp', '008/DIGISOL-SPp/VII/2025', 'tester', 3, '2025-07-05', 'haloo', 1, '1751690033_30432d40e5d96925a290.jpg', 1, '2025-07-05 11:33:53', NULL),
(11, 'SPb', '009/GMTNE-SPb/VII/2025', 'dsadsad', 1, '2025-07-05', 'sadas', 1, '1751693242_89525f702cb071b88fc7.jpg', 2, '2025-07-05 12:27:22', NULL),
(12, 'SK', '010/GMTNE-SK/VII/2025', 'ksadhd', 1, '2025-07-05', 'kndsahsd', 6, '1751694730_54912c159acc25d417f4.jpg', 2, '2025-07-05 12:52:10', NULL),
(13, 'SK', '001/GMTNE-SK/XI/2029', 'saya', 1, '2029-11-15', 'dzdsdhsd', 1, '1751695636_756c2b58bdbd7ac3cca3.jpg', 2, '2025-07-05 13:07:16', NULL);

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
(1, '12923219379743', 2, 'saya', 'aasuduhiaedgagffygefuegfuehhh', '2025-07-29', '2025-07-03 04:14:06', '1751516046_8ebc104c9e9e63dcec49.png', 3, '2025-07-03 04:14:06', '2025-07-03 06:43:16'),
(2, '13719383680972', 3, 'ibu siti', 'grhwspchsmqtrgpbhtcqjvdjfivrgl', '2025-07-06', '2025-07-07 13:00:00', '1278482642_c235ee86965fcc5b.png', 3, '2025-07-07 09:00:00', '2025-07-07 11:00:00'),
(3, '88893948185150', 3, 'cv mandiri', 'otcusxtuurhckprqmvhgrxlmtmdovp', '2025-07-29', '2025-07-29 18:00:00', '4054989706_0d30fc46880ea761.png', 3, '2025-07-29 14:00:00', '2025-07-29 16:00:00'),
(4, '44217164660759', 2, 'cv mandiri', 'lnftpyqeoxdtxvfciiwyvptstzbmzx', '2025-07-30', '2025-07-30 15:00:00', '1768040409_78b3f2cd92adf2e6.png', 3, '2025-07-30 11:00:00', '2025-07-30 12:00:00'),
(5, '85477026385188', 1, 'cv mandiri', 'klbfbumsdbwediatautwwhiinpehtp', '2025-07-31', '2025-07-31 18:00:00', '9131572143_b713f1939e8a0245.png', 3, '2025-07-31 14:00:00', '2025-07-31 15:00:00'),
(6, '45082384390483', 1, 'ibu siti', 'mrsuhzlglqtjrgbfyxivskrrtgomjc', '2025-07-16', '2025-07-18 00:00:00', '3987064043_caf7fa10d3c54d61.png', 3, '2025-07-17 20:00:00', '2025-07-17 23:00:00'),
(7, '88321180553262', 3, 'cv mandiri', 'xufgnvvysphenkcuznwgwvbfmdckrb', '2025-07-22', '2025-07-22 08:00:00', '3689529306_18d1fca9f8585406.png', 3, '2025-07-22 04:00:00', '2025-07-22 08:00:00'),
(8, '29462293765821', 2, 'ibu siti', 'vkybmqnkpxfzoljfzabfrowhfldlxq', '2025-07-11', '2025-07-11 07:00:00', '7803318650_dae085185197b67d.png', 3, '2025-07-11 03:00:00', '2025-07-11 04:00:00'),
(9, '55353495365314', 1, 'pt jaya abadi', 'dbmmkveivegnqzlyetmtapqqezdzrc', '2025-07-08', '2025-07-09 11:00:00', '7142214327_8573a3d1e298342f.png', 3, '2025-07-09 07:00:00', '2025-07-09 11:00:00'),
(10, '33402536965544', 2, 'cv mandiri', 'lhkfmecuznqrqjwahwtnaovmjndwll', '2025-07-04', '2025-07-05 21:00:00', '9155284009_28f5acf27094c942.png', 3, '2025-07-05 17:00:00', '2025-07-05 18:00:00'),
(11, '56173822503792', 2, 'cv mandiri', 'nqzgbgswrnoenbdnxmphcuwlfnpcei', '2025-07-03', '2025-07-03 04:00:00', '4334946777_942e0cb69dc88002.png', 3, '2025-07-03 00:00:00', '2025-07-03 02:00:00'),
(12, '67299888116312', 3, 'saya', 'whuvmjngjiezxhjfxctyuvhzqqeihi', '2025-07-09', '2025-07-09 01:00:00', '6465370955_f6ea1ac6a346e486.png', 3, '2025-07-08 21:00:00', '2025-07-09 00:00:00'),
(13, '79961584914009', 1, 'bpk agus', 'kxjcynuwxlbxjxfxgfwgeriqsddldf', '2025-07-08', '2025-07-08 10:00:00', '3920446431_a03790b48dfd6e1e.png', 3, '2025-07-08 06:00:00', '2025-07-08 09:00:00'),
(14, '48439194326652', 3, 'ibu siti', 'oguudfhgnkkormkkvefsvbymougtbp', '2025-07-10', '2025-07-10 06:00:00', '9803936933_7935ef18d4251592.png', 3, '2025-07-10 02:00:00', '2025-07-10 06:00:00'),
(15, '49637779513976', 3, 'ibu siti', 'whtakgcscbcarvmxnskgbdkxlryuto', '2025-07-21', '2025-07-21 06:00:00', '4006554465_a34a83048d3c9cda.png', 3, '2025-07-21 02:00:00', '2025-07-21 04:00:00'),
(16, '19496050372381', 3, 'pt jaya abadi', 'hupyebqxpnalyocbgqfoviiqtaqkkq', '2025-07-28', '2025-07-28 22:00:00', '7656572257_94cf6b58e064f6ae.png', 3, '2025-07-28 18:00:00', '2025-07-28 23:00:00'),
(17, '40834585684362', 1, 'ibu siti', 'zawhomkeldldqnqoylzxtqthddflbk', '2025-07-21', '2025-07-22 00:00:00', '2418391980_ce14712d2e89be62.png', 3, '2025-07-21 20:00:00', '2025-07-22 01:00:00'),
(18, '54483662952308', 1, 'bpk agus', 'pjaaxxdafnoguwgovzghbrgizgslpi', '2025-07-18', '2025-07-19 07:00:00', '3208520918_6cebdb82fb465a1c.png', 3, '2025-07-19 03:00:00', '2025-07-19 08:00:00'),
(19, '62290325586391', 1, 'cv mandiri', 'wcfhqpqixytikxvtakuobyjpdurrea', '2025-07-27', '2025-07-27 19:00:00', '7393213052_f1b1f90073ec6994.png', 3, '2025-07-27 15:00:00', '2025-07-27 17:00:00'),
(20, '67181753021125', 2, 'bpk agus', 'dihbdfzuorbpjzjohxntcafyfvbeno', '2025-07-04', '2025-07-05 07:00:00', '1099866516_c337e0b7c5dd512c.png', 3, '2025-07-05 03:00:00', '2025-07-05 06:00:00'),
(21, '49107212490022', 1, 'bpk agus', 'znanutzzscahrvyekptljqrtveudkd', '2025-07-06', '2025-07-07 05:00:00', '2714602375_5bf57035c8aace44.png', 3, '2025-07-07 01:00:00', '2025-07-07 05:00:00'),
(22, '213214', 1, 'sasa', 'ahahha', '2025-07-23', '2025-07-04 07:06:03', '1751612763_1ac1ed38ddbcda9645d0.png', 1, '2025-07-04 07:06:03', '2025-07-04 07:06:03'),
(23, '001.0.5/109/109.3.0.4.6. 12/2025', 1, 'saya', 'sasa', '2025-07-15', '2025-07-05 03:47:24', '1751687244_b2dfe7fbeea1792bd62f.jpg', 1, '2025-07-05 03:47:24', '2025-07-05 03:47:24'),
(24, '001.0.5/109/109.3.0.4.6. 12/2025', 2, 'saya', 'satsaugdsgasd', '2025-07-05', '2025-07-05 03:47:58', '1751687278_634b0bb41c95a42e8821.jpg', 1, '2025-07-05 03:47:58', '2025-07-05 03:47:58'),
(25, '12.001/GMTNET/VII/2025', 1, 'dhfha', 'ahsdhasdh', '2025-07-06', '2025-07-05 04:12:15', '1751688735_289b33bf10a7834de989.jpg', 1, '2025-07-05 04:12:15', '2025-07-05 04:12:15'),
(26, '11.001/GAIN/VII/2025', 1, 'saya', 'saduasufdfgug', '2029-07-05', '2025-07-05 04:20:43', '1751695734_23b206e3231f4e796ca3.jpg', 1, '2025-07-05 04:20:44', '2025-07-05 06:08:54'),
(27, '001.0.5/109/109.3.0.4.6. 12/2025', 2, 'saya', 'jasdudsa', '2025-07-05', '2025-07-05 04:30:19', '1751689819_1718eba4bb75eb9609ba.jpg', 1, '2025-07-05 04:30:19', '2025-07-05 04:30:19'),
(28, '2153432', 1, 'syaa', 'sadgd', '2025-07-05', '2025-07-05 05:55:31', '1751694931_ee7ab82f60c8b8d921d8.jpg', 2, '2025-07-05 05:55:31', '2025-07-05 05:55:31'),
(29, '16235', 2, 'saya', 'jasdguaw', '2025-07-05', '2025-07-05 06:44:21', '1751697861_b91999f905d0967b176b.docx', 3, '2025-07-05 06:44:21', '2025-07-05 06:44:21'),
(30, '21343', 3, 'saya', 'saya', '2025-07-05', '2025-07-05 07:11:10', '1751699470_84dec53ae2b4c507657e.docx', 3, '2025-07-05 07:11:10', '2025-07-05 07:11:10'),
(31, '12.001/GMTNET/VII/2025', 1, 'ashdeh', 'dfiofehf', '2025-07-05', '2025-07-05 07:27:59', '1751700479_f4982b5ef938b41381f4.jpg', 3, '2025-07-05 07:27:59', '2025-07-05 07:27:59'),
(32, '2344634', 3, 'saya', 'ksadhede', '2025-07-05', '2025-07-05 07:29:48', '1751700588_bf5e2fddf63ed9054fa2.jpg', 3, '2025-07-05 07:29:48', '2025-07-05 07:29:48');

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
(1, 1, '1751607902_c631bb4f6a53b2a663f5.png', '2025-07-04 05:45:02'),
(2, 6, '1751689287_79500aa12cbec696e8de.jpg', '2025-07-05 04:21:27');

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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Mas Verry ', 'admin@example.com', '2025-07-02 15:08:42', '2025-07-03 08:53:33'),
(2, 'operator1', '$2y$10$Yi5f9GzC/A8bo4pc0f0iCu3TShcKDXO70r7E6V2DnkQJ2eArF5WtG', 'operator', 'tester', 'operator@gmail.com', '2025-07-02 15:36:20', NULL),
(3, 'rasdy', '$2y$10$.pyrLw7zX.axUW8CMipzmeXzyBExgJDmUT3yjFxKavhPBGRDtZbgy', 'user', 'rasdy muhammad', 'rasdy@gmail.com', '2025-07-02 16:14:25', '2025-07-03 08:56:19'),
(5, 'syahdan ', '$2y$10$tEBELSJZuSZpQFYUSYSrAu2s5P/DBsJEOgZ4k0Hhm7dX0GnDlE8Mq', 'user', 'Syahdan Qyaan', 'syahdan@gmail.com', '2025-07-04 09:36:23', '2025-07-04 09:36:40'),
(6, 'admin2', '$2y$10$wLiDXaAcEXX/puN/IOUi1u9oKHsRvSniBa43EnPClw2NdOHp3rk7u', 'admin', 'rasdy', 'admin@gmail.com', '2025-07-05 04:15:54', '2025-07-05 04:15:54'),
(7, 'SAYA', '$2y$10$QrU7o2NT0.FJw8CcoTexi.HceAN3Xm9bWryp6Ijx3yEDL4dlQmeR6', 'user', 'testerrrrr', 'JANCOLK@gmail.com', '2025-07-05 08:27:57', '2025-07-05 08:27:57'),
(8, 'sayaa', '$2y$10$On1WrnRNUIsiUNYWcV2suuQwoII7USQ6glFfEJGcm1PQW5oD9LVRm', 'user', 'testerrrrr', 'aku@gmail.com', '2025-07-05 08:40:14', '2025-07-05 08:40:14'),
(9, 'sayaaaaa', '$2y$10$gdExwCc.Iw7cQHV0oAyhhuKCI962eIALfC7H2twA7liwIl3z9NPbm', 'user', 'testerrrrr', 'tester123@gmail.com', '2025-07-05 08:44:00', '2025-07-05 08:44:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tanda_tangan`
--
ALTER TABLE `tanda_tangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
