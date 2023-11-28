-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2023 at 01:41 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppko_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `nama_kendaraan` varchar(50) NOT NULL,
  `merk_kendaraan` varchar(50) NOT NULL,
  `plat_nomor` varchar(15) NOT NULL,
  `status_kendaraan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `nama_kendaraan`, `merk_kendaraan`, `plat_nomor`, `status_kendaraan`) VALUES
(1, 'Xenia', 'Daihatsu', 'B 456 FFI', 'Tidak Tersedia'),
(2, 'Avanza', 'Toyota', 'B 456 FIF', 'Tersedia'),
(3, 'APV', 'Toyota', 'B 556 FRD', 'Tersedia'),
(4, 'Ertiga', 'Suzuki', 'B 214 FKB', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `kd_transaksi` varchar(50) NOT NULL,
  `tujuan` varchar(150) NOT NULL,
  `keperluan` varchar(120) NOT NULL,
  `bukti` varchar(155) NOT NULL,
  `waktu_pergi` datetime NOT NULL,
  `waktu_kembali` datetime NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `nama_bp` varchar(150) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `tgl_PManager` date DEFAULT NULL,
  `tgl_PUmum` date NOT NULL,
  `tgl_PAsmen` date NOT NULL,
  `tgl_PSpv` date NOT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `kendaraan_id` int(11) NOT NULL,
  `supir` varchar(150) NOT NULL,
  `uang_jalan` decimal(10,0) NOT NULL,
  `total_biaya` decimal(10,0) NOT NULL,
  `sisa_saldo` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id_pengajuan`, `id_author`, `tgl_pengajuan`, `kd_transaksi`, `tujuan`, `keperluan`, `bukti`, `waktu_pergi`, `waktu_kembali`, `no_hp`, `nama_bp`, `keterangan`, `tgl_PManager`, `tgl_PUmum`, `tgl_PAsmen`, `tgl_PSpv`, `tgl_selesai`, `status`, `kendaraan_id`, `supir`, `uang_jalan`, `total_biaya`, `sisa_saldo`) VALUES
(80, 14322566, '2023-11-24', '0005/PPKO/11/2023', 'Ullam cupidatat iure', 'Eum labore molestiae', '655ff41b9fb1a.', '2018-11-06 12:14:00', '1987-05-15 17:59:00', 'In ratione qui eaque', 'Ex molestias sint in', 'Qui nesciunt optio', '2023-11-24', '2023-11-24', '2023-11-24', '2023-11-24', '2023-11-24', 'Peminjaman Selesai', 2, 'Abdul - 0854776812', '300000', '225000', '75000'),
(81, 14322566, '2023-11-24', '0006/PPKO/11/2023', 'Atque omnis sit con', 'Voluptatum quia aute', '65603c713f29b.', '2001-05-11 19:21:00', '1976-08-01 13:16:00', 'Sint iusto id aut su', 'Pariatur Aut nisi h', 'Ex officiis dolor qu', '2023-11-27', '2023-11-27', '2023-11-27', '2023-11-27', '2023-11-27', 'Peminjaman Selesai', 4, 'Udin - 088477341902', '200000', '125000', '75000'),
(82, 14322566, '2023-11-27', '0007/PPKO/11/2023', 'Fugiat quo sed at c', 'Et qui voluptas tota', '6564131522e5c.', '1992-12-03 20:47:00', '1988-12-20 06:13:00', 'Pariatur Omnis libe', 'Deleniti sint animi', 'Non qui aut exercita', '2023-11-27', '2023-11-27', '2023-11-27', '2023-11-27', NULL, 'Disetujui Manager GA', 1, 'Abdul - 0854776812', '500000', '0', '0'),
(83, 12003244, '2023-11-27', '0008/PPKO/11/2023', 'Cupidatat quis nesci', 'Qui eu est ad dolor', '6564406a9ef5d.', '2006-11-13 08:29:00', '1987-11-10 00:19:00', 'Qui et corrupti qui', 'In pariatur Exercit', 'Facere minima rem qu', '2023-11-27', '2023-11-27', '2023-11-27', '2023-11-27', '2023-11-27', 'Peminjaman Selesai', 2, 'Udin - 088477341902', '1500000', '1200000', '300000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nik` int(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_divisi` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL,
  `status_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `nik`, `password`, `nama_divisi`, `level`, `status_user`) VALUES
(12, 'Renaldi', 12003244, '123', 'Finance', 'Staff', 'Aktif'),
(14, 'Admin', 15300100, '123', 'HC, GA DAN IT', 'Admin', 'Aktif'),
(15, 'Abdul', 1345645678, '123', 'Finance', 'Staff', 'Aktif'),
(16, 'Bambang', 1400776868, '123', 'HC, GA DAN IT', 'Manager', 'Aktif'),
(18, 'Halim', 15200100, '123', 'SDM', 'Staff', 'Aktif'),
(19, 'Chandra', 13500200, '123', 'SDM', 'Manager', 'Aktif'),
(20, 'Abdul Munaq', 15600300, '123', 'General Affair', 'Umum', 'Aktif'),
(21, 'Ahmad', 14200988, '123', 'Finance', 'Manager', 'Aktif'),
(22, 'Fahri', 17544700, '123', 'General Affair', 'Asman', 'Aktif'),
(23, 'Kodir', 107766993, '123', 'General Affair', 'ManagerGA', 'Aktif'),
(24, 'aldi', 14322566, '123', 'SDM', 'Staff', 'Aktif'),
(25, 'Fikri', 173299765, '123', 'HC, GA DAN IT', 'Staff', 'Aktif'),
(30, 'Parjo', 14235684, '123', 'SDM', 'Staff', 'Tidak Aktif'),
(33, 'ilham', 14325002, '123', 'Bidang Umum', 'ManagerGA', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
