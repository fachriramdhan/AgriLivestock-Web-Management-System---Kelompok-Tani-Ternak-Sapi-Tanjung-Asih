SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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

-- --------------------------------------------------------

--
-- Constraints and Indexes
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

--
-- AUTO_INCREMENT settings
--

ALTER TABLE `anggota` MODIFY `id_anggota` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `jadwal_kegiatan` MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `kesehatan_sapi` MODIFY `id_kesehatan` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `pakan_sapi` MODIFY `id_pakan` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `produksi_olahan` MODIFY `id_olahan` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `produksi_susu` MODIFY `id_produksi` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `sapi` MODIFY `id_sapi` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `user` MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- Foreign Key Constraints
--

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