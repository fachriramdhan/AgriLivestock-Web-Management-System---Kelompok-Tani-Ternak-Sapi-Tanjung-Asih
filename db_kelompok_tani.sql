-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 23, 2025 at 06:34 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kelompok_tani`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `alamat` text,
  `no_hp` varchar(15) DEFAULT NULL,
  `tanggal_gabung` date DEFAULT NULL,
  `status_anggota` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama_anggota`, `alamat`, `no_hp`, `tanggal_gabung`, `status_anggota`) VALUES
(1, 'Budi Santoso', 'Desa Tanjung Asih', '08123456789', '2025-12-23', 'aktif'),
(2, 'Budi Santoso', 'Desa Tanjung Asih', '08123456789', '2025-01-01', 'aktif'),
(3, 'Siti Aminah', 'Desa Tanjung Asih', '08123456780', '2025-01-02', 'aktif'),
(4, 'Ahmad Fauzi', 'Desa Tanjung Asih', '08123456781', '2025-01-03', 'aktif'),
(5, 'Rina Marlina', 'Desa Tanjung Asih', '08123456782', '2025-01-04', 'aktif'),
(6, 'Andi Saputra', 'Desa Tanjung Asih', '08123456783', '2025-01-05', 'aktif'),
(7, 'Lina Sari', 'Desa Tanjung Asih', '08123456784', '2025-01-06', 'aktif'),
(8, 'Hendra Wijaya', 'Desa Tanjung Asih', '08123456785', '2025-01-07', 'aktif'),
(9, 'Dewi Lestari', 'Desa Tanjung Asih', '08123456786', '2025-01-08', 'aktif'),
(10, 'Rudi Hartono', 'Desa Tanjung Asih', '08123456787', '2025-01-09', 'aktif'),
(11, 'Nina Puspita', 'Desa Tanjung Asih', '08123456788', '2025-01-10', 'aktif'),
(12, 'Budi Santoso', 'Desa Tanjung Asih', '08123456789', '2025-01-01', 'aktif'),
(13, 'Siti Aminah', 'Desa Tanjung Asih', '08123456780', '2025-01-02', 'aktif'),
(14, 'Ahmad Fauzi', 'Desa Tanjung Asih', '08123456781', '2025-01-03', 'aktif'),
(15, 'Rina Marlina', 'Desa Tanjung Asih', '08123456782', '2025-01-04', 'aktif'),
(16, 'Andi Saputra', 'Desa Tanjung Asih', '08123456783', '2025-01-05', 'aktif'),
(17, 'Lina Sari', 'Desa Tanjung Asih', '08123456784', '2025-01-06', 'aktif'),
(18, 'Hendra Wijaya', 'Desa Tanjung Asih', '08123456785', '2025-01-07', 'aktif'),
(19, 'Dewi Lestari', 'Desa Tanjung Asih', '08123456786', '2025-01-08', 'aktif'),
(20, 'Rudi Hartono', 'Desa Tanjung Asih', '08123456787', '2025-01-09', 'aktif'),
(21, 'Nina Puspita', 'Desa Tanjung Asih', '08123456788', '2025-01-10', 'aktif'),
(22, 'Budi Santoso', 'Desa Tanjung Asih', '08123456789', '2025-01-01', 'aktif'),
(23, 'Siti Aminah', 'Desa Tanjung Asih', '08123456780', '2025-01-02', 'aktif'),
(24, 'Ahmad Fauzi', 'Desa Tanjung Asih', '08123456781', '2025-01-03', 'aktif'),
(25, 'Rina Marlina', 'Desa Tanjung Asih', '08123456782', '2025-01-04', 'aktif'),
(26, 'Andi Saputra', 'Desa Tanjung Asih', '08123456783', '2025-01-05', 'aktif'),
(27, 'Lina Sari', 'Desa Tanjung Asih', '08123456784', '2025-01-06', 'aktif'),
(28, 'Hendra Wijaya', 'Desa Tanjung Asih', '08123456785', '2025-01-07', 'aktif'),
(29, 'Dewi Lestari', 'Desa Tanjung Asih', '08123456786', '2025-01-08', 'aktif'),
(30, 'Rudi Hartono', 'Desa Tanjung Asih', '08123456787', '2025-01-09', 'aktif'),
(31, 'Nina Puspita', 'Desa Tanjung Asih', '08123456788', '2025-01-10', 'aktif'),
(32, 'Budi Santoso', 'Desa Tanjung Asih', '08123456789', '2025-01-01', 'aktif'),
(33, 'Siti Aminah', 'Desa Tanjung Asih', '08123456780', '2025-02-01', 'aktif'),
(34, 'Ahmad Fauzi', 'Desa Tanjung Asih', '08123456781', '2025-03-01', 'aktif'),
(35, 'Rina Dewi', 'Desa Tanjung Asih', '08123456782', '2025-04-01', 'aktif'),
(36, 'Andi Wijaya', 'Desa Tanjung Asih', '08123456783', '2025-05-01', 'aktif'),
(37, 'Lina Marlina', 'Desa Tanjung Asih', '08123456784', '2025-06-01', 'aktif'),
(38, 'Hendra Kurnia', 'Desa Tanjung Asih', '08123456785', '2025-07-01', 'aktif'),
(39, 'Dewi Lestari', 'Desa Tanjung Asih', '08123456786', '2025-08-01', 'aktif'),
(40, 'Rudi Hartono', 'Desa Tanjung Asih', '08123456787', '2025-09-01', 'aktif'),
(41, 'Nina Sari', 'Desa Tanjung Asih', '08123456788', '2025-10-01', 'aktif'),
(42, 'Budi Santoso', 'Desa Tanjung Asih', '08123456789', '2025-01-01', 'aktif'),
(43, 'Siti Aminah', 'Desa Tanjung Asih', '08123456780', '2025-02-01', 'aktif'),
(44, 'Ahmad Fauzi', 'Desa Tanjung Asih', '08123456781', '2025-03-01', 'aktif'),
(45, 'Rina Dewi', 'Desa Tanjung Asih', '08123456782', '2025-04-01', 'aktif'),
(46, 'Andi Wijaya', 'Desa Tanjung Asih', '08123456783', '2025-05-01', 'aktif'),
(47, 'Lina Marlina', 'Desa Tanjung Asih', '08123456784', '2025-06-01', 'aktif'),
(48, 'Hendra Kurnia', 'Desa Tanjung Asih', '08123456785', '2025-07-01', 'aktif'),
(49, 'Dewi Lestari', 'Desa Tanjung Asih', '08123456786', '2025-08-01', 'aktif'),
(50, 'Rudi Hartono', 'Desa Tanjung Asih', '08123456787', '2025-09-01', 'aktif'),
(51, 'Nina Sari', 'Desa Tanjung Asih', '08123456788', '2025-10-01', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kegiatan`
--

CREATE TABLE `jadwal_kegiatan` (
  `id_jadwal` int NOT NULL,
  `dibuat_oleh` int NOT NULL,
  `jenis_kegiatan` enum('pemerahan','pakan','vaksinasi','pemeriksaan','rapat') NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal_kegiatan`
--

INSERT INTO `jadwal_kegiatan` (`id_jadwal`, `dibuat_oleh`, `jenis_kegiatan`, `tanggal`, `waktu`, `keterangan`) VALUES
(11, 1, 'vaksinasi', '2025-12-01', '06:00:00', 'Pemerahan rutin pagi kali'),
(12, 2, 'pakan', '2025-12-01', '09:00:00', 'Pemberian pakan sapi B'),
(13, 23, 'vaksinasi', '2025-12-01', '10:00:00', 'Vaksinasi sapi C'),
(14, 24, 'pemeriksaan', '2025-12-01', '11:00:00', 'Cek kesehatan sapi D'),
(15, 25, 'rapat', '2025-12-01', '13:00:00', 'Rapat peternak'),
(16, 26, 'pemerahan', '2025-12-02', '06:00:00', 'Pemerahan sapi F'),
(17, 27, 'pakan', '2025-12-02', '09:00:00', 'Pakan sapi G'),
(18, 28, 'vaksinasi', '2025-12-02', '10:00:00', 'Vaksinasi sapi H'),
(19, 29, 'pemeriksaan', '2025-12-02', '11:00:00', 'Cek kesehatan sapi I'),
(20, 30, 'rapat', '2025-12-02', '13:00:00', 'Rapat bulanan peternak'),
(21, 1, 'pemerahan', '2025-12-01', '06:00:00', 'Pemerahan rutin pagi'),
(22, 2, 'pakan', '2025-12-01', '09:00:00', 'Pemberian pakan sapi B'),
(23, 23, 'vaksinasi', '2025-12-01', '10:00:00', 'Vaksinasi sapi C'),
(24, 24, 'pemeriksaan', '2025-12-01', '11:00:00', 'Cek kesehatan sapi D'),
(25, 25, 'rapat', '2025-12-01', '13:00:00', 'Rapat peternak'),
(26, 26, 'pemerahan', '2025-12-02', '06:00:00', 'Pemerahan sapi F'),
(27, 27, 'pakan', '2025-12-02', '09:00:00', 'Pakan sapi G'),
(28, 28, 'vaksinasi', '2025-12-02', '10:00:00', 'Vaksinasi sapi H'),
(29, 29, 'pemeriksaan', '2025-12-02', '11:00:00', 'Cek kesehatan sapi I'),
(30, 30, 'rapat', '2025-12-02', '13:00:00', 'Rapat bulanan peternak'),
(31, 1, 'pemerahan', '2025-12-01', '06:00:00', 'Pemerahan rutin pagi'),
(32, 2, 'pakan', '2025-12-01', '09:00:00', 'Pemberian pakan sapi B'),
(33, 23, 'vaksinasi', '2025-12-01', '10:00:00', 'Vaksinasi sapi C'),
(34, 24, 'pemeriksaan', '2025-12-01', '11:00:00', 'Cek kesehatan sapi D'),
(35, 25, 'rapat', '2025-12-01', '13:00:00', 'Rapat peternak'),
(36, 26, 'pemerahan', '2025-12-02', '06:00:00', 'Pemerahan sapi F'),
(37, 27, 'pakan', '2025-12-02', '09:00:00', 'Pakan sapi G'),
(38, 28, 'vaksinasi', '2025-12-02', '10:00:00', 'Vaksinasi sapi H'),
(39, 29, 'pemeriksaan', '2025-12-02', '11:00:00', 'Cek kesehatan sapi I'),
(40, 30, 'rapat', '2025-12-02', '13:00:00', 'Rapat bulanan peternak'),
(41, 1, 'pemerahan', '2025-12-01', '06:00:00', 'Pemerahan rutin pagi'),
(42, 2, 'pakan', '2025-12-01', '09:00:00', 'Pemberian pakan sapi B'),
(43, 23, 'vaksinasi', '2025-12-01', '10:00:00', 'Vaksinasi sapi C'),
(44, 24, 'pemeriksaan', '2025-12-01', '11:00:00', 'Cek kesehatan sapi D'),
(45, 25, 'rapat', '2025-12-01', '13:00:00', 'Rapat peternak'),
(46, 26, 'pemerahan', '2025-12-02', '06:00:00', 'Pemerahan sapi F'),
(47, 27, 'pakan', '2025-12-02', '09:00:00', 'Pakan sapi G'),
(48, 28, 'vaksinasi', '2025-12-02', '10:00:00', 'Vaksinasi sapi H'),
(49, 29, 'pemeriksaan', '2025-12-02', '11:00:00', 'Cek kesehatan sapi I'),
(50, 30, 'rapat', '2025-12-02', '13:00:00', 'Rapat bulanan peternak'),
(51, 1, 'pemerahan', '2025-12-01', '06:00:00', 'Pemerahan rutin pagi'),
(52, 2, 'pakan', '2025-12-01', '09:00:00', 'Pemberian pakan sapi B'),
(53, 23, 'vaksinasi', '2025-12-01', '10:00:00', 'Vaksinasi sapi C'),
(54, 24, 'pemeriksaan', '2025-12-01', '11:00:00', 'Cek kesehatan sapi D'),
(55, 25, 'rapat', '2025-12-01', '13:00:00', 'Rapat peternak'),
(56, 26, 'pemerahan', '2025-12-02', '06:00:00', 'Pemerahan sapi F'),
(57, 27, 'pakan', '2025-12-02', '09:00:00', 'Pakan sapi G'),
(58, 28, 'vaksinasi', '2025-12-02', '10:00:00', 'Vaksinasi sapi H'),
(59, 29, 'pemeriksaan', '2025-12-02', '11:00:00', 'Cek kesehatan sapi I'),
(60, 30, 'rapat', '2025-12-02', '13:00:00', 'Rapat bulanan peternak'),
(61, 1, 'pemerahan', '2025-12-01', '06:00:00', 'Pemerahan rutin pagi'),
(62, 2, 'pakan', '2025-12-01', '09:00:00', 'Pemberian pakan sapi B'),
(63, 23, 'vaksinasi', '2025-12-01', '10:00:00', 'Vaksinasi sapi C'),
(64, 24, 'pemeriksaan', '2025-12-01', '11:00:00', 'Cek kesehatan sapi D'),
(65, 25, 'rapat', '2025-12-01', '13:00:00', 'Rapat peternak'),
(66, 26, 'pemerahan', '2025-12-02', '06:00:00', 'Pemerahan sapi F'),
(67, 27, 'pakan', '2025-12-02', '09:00:00', 'Pakan sapi G'),
(68, 28, 'vaksinasi', '2025-12-02', '10:00:00', 'Vaksinasi sapi H'),
(69, 29, 'pemeriksaan', '2025-12-02', '11:00:00', 'Cek kesehatan sapi I'),
(70, 30, 'rapat', '2025-12-02', '13:00:00', 'Rapat bulanan peternak');

-- --------------------------------------------------------

--
-- Table structure for table `kesehatan_sapi`
--

CREATE TABLE `kesehatan_sapi` (
  `id_kesehatan` int NOT NULL,
  `id_sapi` int NOT NULL,
  `id_user` int NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pemeriksaan` enum('rutin','sakit','vaksinasi','kebuntingan') NOT NULL,
  `gejala` varchar(100) DEFAULT NULL,
  `tindakan` enum('observasi','obat','vitamin','suntik') NOT NULL,
  `status_kesehatan` enum('sehat','perawatan','sakit') DEFAULT 'sehat',
  `catatan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kesehatan_sapi`
--

INSERT INTO `kesehatan_sapi` (`id_kesehatan`, `id_sapi`, `id_user`, `tanggal`, `jenis_pemeriksaan`, `gejala`, `tindakan`, `status_kesehatan`, `catatan`) VALUES
(51, 43, 2, '2025-12-01', 'rutin', '-', 'vitamin', 'sehat', 'Cek rutin pagi'),
(52, 44, 23, '2025-12-01', 'rutin', '-', 'suntik', 'sehat', 'Cek rutin siang'),
(53, 45, 24, '2025-12-01', 'sakit', 'demam', 'vitamin', 'perawatan', 'Perlu observasi'),
(54, 46, 25, '2025-12-01', 'vaksinasi', '-', 'suntik', 'sehat', 'Vaksinasi rutin'),
(55, 47, 26, '2025-12-01', 'rutin', '-', 'observasi', 'sehat', 'Cek rutin pagi'),
(56, 48, 27, '2025-12-01', 'sakit', 'batuk', 'obat', 'perawatan', 'Berikan obat malam'),
(57, 49, 28, '2025-12-01', 'rutin', '-', 'vitamin', 'sehat', 'Vitamin mingguan'),
(58, 50, 29, '2025-12-01', 'vaksinasi', '-', 'suntik', 'sehat', 'Vaksinasi H'),
(59, 51, 30, '2025-12-01', 'rutin', '-', 'observasi', 'sehat', 'Cek pagi I'),
(60, 52, 1, '2025-12-01', 'sakit', 'cacingan', 'obat', 'perawatan', 'Treatment harian');

-- --------------------------------------------------------

--
-- Table structure for table `pakan_sapi`
--

CREATE TABLE `pakan_sapi` (
  `id_pakan` int NOT NULL,
  `id_sapi` int NOT NULL,
  `id_user` int NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pakan` enum('rumput','konsentrat','jerami','ampas_tahu') NOT NULL,
  `waktu_pemberian` enum('pagi','siang','sore') NOT NULL,
  `jumlah_kg` decimal(5,2) NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pakan_sapi`
--

INSERT INTO `pakan_sapi` (`id_pakan`, `id_sapi`, `id_user`, `tanggal`, `jenis_pakan`, `waktu_pemberian`, `jumlah_kg`, `keterangan`) VALUES
(11, 43, 2, '2025-12-01', 'rumput', 'pagi', 5.50, 'Pagi rutin'),
(12, 44, 23, '2025-12-01', 'konsentrat', 'siang', 3.00, 'Tambahan energi'),
(13, 45, 24, '2025-12-01', 'jerami', 'sore', 4.20, 'Sore hari'),
(14, 46, 25, '2025-12-01', 'ampas_tahu', 'pagi', 2.50, 'Pagi rutin'),
(15, 47, 26, '2025-12-01', 'rumput', 'siang', 6.00, 'Siang hari'),
(16, 48, 27, '2025-12-01', 'konsentrat', 'sore', 3.50, 'Sore hari'),
(17, 49, 28, '2025-12-01', 'jerami', 'pagi', 4.00, 'Pagi rutin'),
(18, 50, 29, '2025-12-01', 'ampas_tahu', 'siang', 2.80, 'Siang hari'),
(19, 51, 30, '2025-12-01', 'rumput', 'sore', 5.00, 'Sore hari'),
(20, 52, 1, '2025-12-01', 'konsentrat', 'pagi', 3.20, 'Pagi rutin'),
(21, 43, 2, '0225-12-11', 'konsentrat', 'siang', 12.00, 'apik tenan');

-- --------------------------------------------------------

--
-- Table structure for table `produksi_olahan`
--

CREATE TABLE `produksi_olahan` (
  `id_olahan` int NOT NULL,
  `id_user` int NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_olahan` enum('pasteurisasi','yogurt','keju','mentega') NOT NULL,
  `bahan_baku_liter` decimal(5,2) NOT NULL,
  `jumlah_hasil` decimal(5,2) NOT NULL,
  `status_produksi` enum('proses','selesai') DEFAULT 'proses',
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produksi_olahan`
--

INSERT INTO `produksi_olahan` (`id_olahan`, `id_user`, `tanggal`, `jenis_olahan`, `bahan_baku_liter`, `jumlah_hasil`, `status_produksi`, `keterangan`) VALUES
(1, 2, '2025-12-01', 'pasteurisasi', 50.00, 48.00, 'selesai', 'Produksi pagi'),
(2, 23, '2025-12-01', 'yogurt', 40.00, 38.00, 'selesai', 'Produksi yogurt'),
(3, 24, '2025-12-01', 'keju', 30.00, 28.00, 'proses', 'Proses keju'),
(4, 25, '2025-12-01', 'mentega', 25.00, 24.00, 'selesai', 'Mentega pagi'),
(5, 26, '2025-12-02', 'pasteurisasi', 60.00, 58.00, 'selesai', 'Produksi tambahan'),
(6, 27, '2025-12-02', 'yogurt', 35.00, 33.00, 'selesai', 'Yogurt tambahan'),
(7, 28, '2025-12-02', 'keju', 20.00, 19.00, 'proses', 'Proses keju malam'),
(8, 29, '2025-12-02', 'mentega', 30.00, 29.00, 'selesai', 'Mentega tambahan'),
(9, 30, '2025-12-02', 'pasteurisasi', 55.00, 53.00, 'selesai', 'Produksi pagi'),
(10, 1, '2025-12-02', 'yogurt', 45.00, 43.00, 'selesai', 'Yogurt tambahan');

-- --------------------------------------------------------

--
-- Table structure for table `produksi_susu`
--

CREATE TABLE `produksi_susu` (
  `id_produksi` int NOT NULL,
  `id_user` int NOT NULL,
  `id_sapi` int NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_liter` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `waktu_pemerahan` enum('pagi','sore') NOT NULL DEFAULT 'pagi',
  `status_data` enum('draft','tervalidasi') NOT NULL DEFAULT 'draft',
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produksi_susu`
--

INSERT INTO `produksi_susu` (`id_produksi`, `id_user`, `id_sapi`, `tanggal`, `jumlah_liter`, `created_at`, `waktu_pemerahan`, `status_data`, `keterangan`) VALUES
(1, 1, 1, '2025-12-01', 10.50, '2025-12-23 14:55:50', 'pagi', 'draft', NULL),
(2, 2, 2, '2025-12-01', 12.00, '2025-12-23 14:55:50', 'pagi', 'draft', NULL),
(3, 3, 3, '2025-12-01', 8.20, '2025-12-23 14:55:50', 'sore', 'draft', NULL),
(4, 4, 4, '2025-12-01', 11.00, '2025-12-23 14:55:50', 'pagi', 'draft', NULL),
(5, 5, 5, '2025-12-01', 9.50, '2025-12-23 14:55:50', 'sore', 'draft', NULL),
(6, 6, 6, '2025-12-01', 10.00, '2025-12-23 14:55:50', 'pagi', 'draft', NULL),
(7, 7, 7, '2025-12-01', 7.80, '2025-12-23 14:55:50', 'sore', 'draft', NULL),
(8, 8, 8, '2025-12-01', 13.20, '2025-12-23 14:55:50', 'pagi', 'draft', NULL),
(9, 9, 9, '2025-12-01', 9.00, '2025-12-23 14:55:50', 'sore', 'draft', NULL),
(10, 10, 10, '2025-12-01', 11.50, '2025-12-23 14:55:50', 'pagi', 'draft', NULL),
(11, 26, 47, '2025-12-23', 12.00, '2025-12-23 15:40:40', 'pagi', 'draft', 'uapik puol');

-- --------------------------------------------------------

--
-- Table structure for table `sapi`
--

CREATE TABLE `sapi` (
  `id_sapi` int NOT NULL,
  `id_user` int NOT NULL,
  `kode_sapi` varchar(30) NOT NULL,
  `nama_sapi` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('jantan','betina') NOT NULL,
  `kategori_sapi` enum('pedet','dara','induk','pejantan') NOT NULL,
  `umur_bulan` int NOT NULL,
  `status_kebuntingan` enum('tidak','bunting') DEFAULT 'tidak',
  `status_laktasi` enum('tidak_laktasi','laktasi') DEFAULT 'tidak_laktasi',
  `periode_laktasi` int DEFAULT '0',
  `kondisi_kesehatan` enum('sehat','perhatian','sakit') DEFAULT 'sehat',
  `status_sapi` enum('aktif','dijual','mati') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sapi`
--

INSERT INTO `sapi` (`id_sapi`, `id_user`, `kode_sapi`, `nama_sapi`, `jenis_kelamin`, `kategori_sapi`, `umur_bulan`, `status_kebuntingan`, `status_laktasi`, `periode_laktasi`, `kondisi_kesehatan`, `status_sapi`, `created_at`) VALUES
(43, 2, 'S001', 'Sapi A', 'betina', 'induk', 21, 'tidak', 'laktasi', 3, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(44, 23, 'S002', 'Sapi B', 'jantan', 'pejantan', 12, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(45, 24, 'S003', 'Sapi C', 'betina', 'dara', 6, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(46, 25, 'S004', 'Sapi D', 'jantan', 'pedet', 3, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(47, 26, 'S005', 'Sapi E', 'betina', 'induk', 30, 'bunting', 'laktasi', 2, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(48, 27, 'S006', 'Sapi F', 'jantan', 'pejantan', 14, 'tidak', 'tidak_laktasi', 0, 'perhatian', 'aktif', '2025-12-23 14:52:41'),
(49, 28, 'S007', 'Sapi G', 'betina', 'dara', 8, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(50, 29, 'S008', 'Sapi H', 'jantan', 'pedet', 4, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(51, 30, 'S009', 'Sapi I', 'betina', 'induk', 28, 'bunting', 'laktasi', 1, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(52, 1, 'S010', 'Sapi J', 'jantan', 'pejantan', 16, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 14:52:41'),
(153, 2, 'S011', 'Sapi K', 'betina', 'induk', 27, 'tidak', 'laktasi', 2, 'sehat', 'aktif', '2025-12-23 15:12:07'),
(154, 23, 'S012', 'Sapi L', 'jantan', 'pejantan', 14, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 15:12:07'),
(155, 24, 'S013', 'Sapi M', 'betina', 'dara', 7, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 15:12:07'),
(156, 25, 'S014', 'Sapi N', 'jantan', 'pedet', 5, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 15:12:07'),
(157, 26, 'S015', 'Sapi O', 'betina', 'induk', 32, 'bunting', 'laktasi', 3, 'sehat', 'aktif', '2025-12-23 15:12:07'),
(158, 27, 'S016', 'Sapi P', 'jantan', 'pejantan', 15, 'tidak', 'tidak_laktasi', 0, 'perhatian', 'aktif', '2025-12-23 15:12:07'),
(159, 28, 'S017', 'Sapi Q', 'betina', 'dara', 9, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 15:12:07'),
(160, 29, 'S018', 'Sapi R', 'jantan', 'pedet', 6, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 15:12:07'),
(161, 30, 'S019', 'Sapi S', 'betina', 'induk', 29, 'bunting', 'laktasi', 1, 'sehat', 'aktif', '2025-12-23 15:12:07'),
(162, 1, 'S020', 'Sapi T', 'jantan', 'pejantan', 17, 'tidak', 'tidak_laktasi', 0, 'sehat', 'aktif', '2025-12-23 15:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `id_anggota` int DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `status_akun` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_anggota`, `username`, `password`, `role`, `status_akun`) VALUES
(1, NULL, 'admin', '$2y$10$kR95yJnnhMuZsY/DjGUJae8DrKKqe0SrG4evCSjs.jaKSrHcqMmii', 'admin', 'aktif'),
(2, 1, 'budi', '$2y$10$6KS6bUVCW//WnedzOmChXua6IqDDnAA7am2ccHDOggbZBKMuWjXvC', 'user', 'aktif'),
(23, 1, 'budi2', '$2y$10$6KS6bUVCW//WnedzOmChXua6IqDDnAA7am2ccHDOggbZBKMuWjXvC', 'user', 'aktif'),
(24, 2, 'siti', '$2y$10$/iIEGyd2y6q3/6CNc2rX9eO5rjz1Tq9Z5vymnl7yzDJ8a8vIPzQ2K', 'user', 'aktif'),
(25, 3, 'ahmad', '$2y$10$LYGajMJErC2QvAe2Ltj5R.5FFh1JQ6Z3V/2c2kA6vhj5n6Pb3Ih1a', 'user', 'aktif'),
(26, 4, 'rina', '$2y$10$C3fZAlnH0Gdb8Vj0I3Y.7uhp4ZfH4uP5/OMI9C/8SL5Er3CkHTD6W', 'user', 'aktif'),
(27, 5, 'andi', '$2y$10$E4G7qJwM0bH6Hk7L3sR.6vhT5ZkH9vQ7R/Ts4I0pJc6Bv5SgKkF1e', 'user', 'aktif'),
(28, 6, 'lina', '$2y$10$H8J2kDqM9wP9Kp8M3dS.9xhL6VnJ5uR9M/Qs6Y2tMd8Ck7HnRj4gW', 'user', 'aktif'),
(29, 7, 'hendra', '$2y$10$P3L4vJdN0fT3Qw8G1cS.5dhK8XnQ2yR6J/Sl7V9qHt4Ck3MkRj9fW', 'user', 'aktif'),
(30, 8, 'dewi', '$2y$10$R7M9sJbO4kV6Yp3H2tS.3ajL2YnR1vQ5P/Xs8G0mJt9Hk2LkQp7gU', 'user', 'aktif'),
(31, 9, 'rudi', '$2y$10$V2N4kLdP1bQ9Hw6J3xS.7thM5XkR0zQ6F/Tu1Y3nLd5Jk8KpHt3rF', 'user', 'aktif'),
(32, 10, 'nina', '$2y$10$Y5P7vJfR3hT2Kx9C1nS.8zhL4YnQ3vR9H/Ux2Q4kPd6Jm9GtSl1e', 'user', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

ALTER TABLE `jadwal_kegiatan`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `fk_jadwal_admin` (`dibuat_oleh`);

ALTER TABLE `kesehatan_sapi`
  ADD PRIMARY KEY (`id_kesehatan`),
  ADD KEY `fk_kesehatan_sapi` (`id_sapi`),
  ADD KEY `fk_kesehatan_user` (`id_user`);

ALTER TABLE `pakan_sapi`
  ADD PRIMARY KEY (`id_pakan`),
  ADD KEY `fk_pakan_sapi_sapi` (`id_sapi`),
  ADD KEY `fk_pakan_sapi_user` (`id_user`);

ALTER TABLE `produksi_olahan`
  ADD PRIMARY KEY (`id_olahan`),
  ADD KEY `fk_olahan_user` (`id_user`);

ALTER TABLE `produksi_susu`
  ADD PRIMARY KEY (`id_produksi`);

ALTER TABLE `sapi`
  ADD PRIMARY KEY (`id_sapi`),
  ADD UNIQUE KEY `kode_sapi` (`kode_sapi`),
  ADD KEY `fk_sapi_user` (`id_user`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_user_anggota` (`id_anggota`);

ALTER TABLE `anggota`
  MODIFY `id_anggota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

ALTER TABLE `jadwal_kegiatan`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

ALTER TABLE `kesehatan_sapi`
  MODIFY `id_kesehatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

ALTER TABLE `pakan_sapi`
  MODIFY `id_pakan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `produksi_olahan`
  MODIFY `id_olahan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `produksi_susu`
  MODIFY `id_produksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `sapi`
  MODIFY `id_sapi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

ALTER TABLE `jadwal_kegiatan`
  ADD CONSTRAINT `fk_jadwal_admin` FOREIGN KEY (`dibuat_oleh`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `kesehatan_sapi`
  ADD CONSTRAINT `fk_kesehatan_sapi` FOREIGN KEY (`id_sapi`) REFERENCES `sapi` (`id_sapi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kesehatan_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pakan_sapi`
  ADD CONSTRAINT `fk_pakan_sapi_sapi` FOREIGN KEY (`id_sapi`) REFERENCES `sapi` (`id_sapi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pakan_sapi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `produksi_olahan`
  ADD CONSTRAINT `fk_olahan_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sapi`
  ADD CONSTRAINT `fk_sapi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
