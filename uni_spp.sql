-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Bulan Mei 2026 pada 13.33
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uni_spp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cek_pembayaran`
--

CREATE TABLE `cek_pembayaran` (
  `id_cek` int(11) NOT NULL,
  `nisn` varchar(10) NOT NULL,
  `tgl_terakhir_bayar` date NOT NULL,
  `tgl_sekarang` date NOT NULL,
  `status_pembayaran` enum('Belum Lunas','Sudah Lunas') NOT NULL,
  `jumlah_bulan` varchar(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `no_telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cek_pembayaran`
--

INSERT INTO `cek_pembayaran` (`id_cek`, `nisn`, `tgl_terakhir_bayar`, `tgl_sekarang`, `status_pembayaran`, `jumlah_bulan`, `nama`, `no_telp`) VALUES
(1, '0101010101', '2026-05-25', '2026-05-25', 'Belum Lunas', '1', 'Anggria Tis', '089191919191'),
(3, '0303030303', '2026-05-25', '2026-05-25', 'Belum Lunas', '0', 'Putri Dyatna ', '089921218876'),
(4, '0505050505', '2026-06-26', '2026-05-25', 'Sudah Lunas', '2', 'Anjari Wan', '087654321122');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` varchar(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `komp_keahlian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `nama_kelas`, `komp_keahlian`) VALUES
('KLS001', 'X MM 1', 'Multi Media'),
('KLS002', 'X RPL 1', 'Rekayasa Perangkat Lunak'),
('KLS003', 'XI RPL 1', 'Rekayasa Perangkat Lunak'),
('KLS004', 'XII RPL 1', 'Rekayasa Perangkat Lunak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` varchar(11) NOT NULL,
  `status` enum('Belum Lunas','Sudah Lunas') NOT NULL DEFAULT 'Belum Lunas',
  `nisn` varchar(10) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `tgl_terakhir_bayar` date NOT NULL,
  `batas_pembayaran` date NOT NULL,
  `jumlah_bulan` varchar(10) NOT NULL,
  `id_spp` varchar(40) NOT NULL,
  `nominal_bayar` varchar(100) NOT NULL,
  `jumlah_bayar` varchar(40) NOT NULL,
  `kembalian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pembayaran`, `status`, `nisn`, `tgl_bayar`, `tgl_terakhir_bayar`, `batas_pembayaran`, `jumlah_bulan`, `id_spp`, `nominal_bayar`, `jumlah_bayar`, `kembalian`) VALUES
('TRX17796752', 'Belum Lunas', '0101010101', '2026-05-25', '2026-05-25', '2026-05-27', '1', 'SPP001', '250000', '250000', '0'),
('TRX17796754', 'Sudah Lunas', '0202020202', '2026-05-25', '2026-05-25', '2026-05-28', '3', 'SPP002', '750000', '800000', '50000'),
('TRX17796791', 'Sudah Lunas', '0505050505', '2026-05-25', '2026-06-26', '2026-06-30', '2', 'SPP002', '500000', '500000', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_petugas`
--

CREATE TABLE `tb_petugas` (
  `id_petugas` varchar(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama_petugas` varchar(35) NOT NULL,
  `level` enum('admin','petugas','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_petugas`
--

INSERT INTO `tb_petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES
('PTG001', 'admin', 'admin123', 'Administrator Utama', 'admin'),
('PTG002', 'erika', 'erika123', 'Erika', 'petugas'),
('PTG003', 'kamari', 'kamari123', 'Kamari', 'siswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nisn` varchar(10) NOT NULL,
  `nis` varchar(8) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_kelas` varchar(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `id_spp` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `nama_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES
('0101010101', '11111111', 'Anggria Tis', 'KLS001', 'X MM 1', 'Pamulang', '089191919191', 'SPP001'),
('0202020202', '22222222', 'Tjinra Paysi', 'KLS001', 'X MM 1', 'Pamulang Timur', '087777777777', 'SPP002'),
('0303030303', '33333333', 'Putri Dyatna ', 'KLS004', 'XII RPL 1', 'Serang', '089921218876', 'SPP001'),
('0505050505', '55555555', 'Anjari Wan', 'KLS003', 'XI RPL 1', 'Pondok Benda', '087654321122', 'SPP002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_spp`
--

CREATE TABLE `tb_spp` (
  `id_spp` varchar(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `nominal` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_spp`
--

INSERT INTO `tb_spp` (`id_spp`, `tahun`, `nominal`) VALUES
('SPP001', 2025, '200000'),
('SPP002', 2026, '250000'),
('SPP003', 2027, '300000'),
('SPP004', 2028, '700000'),
('SPP005', 2024, '150000');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cek_pembayaran`
--
ALTER TABLE `cek_pembayaran`
  ADD PRIMARY KEY (`id_cek`),
  ADD KEY `nisn` (`nisn`);

--
-- Indeks untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `nisn` (`nisn`);

--
-- Indeks untuk tabel `tb_petugas`
--
ALTER TABLE `tb_petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `tb_spp`
--
ALTER TABLE `tb_spp`
  ADD PRIMARY KEY (`id_spp`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cek_pembayaran`
--
ALTER TABLE `cek_pembayaran`
  MODIFY `id_cek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cek_pembayaran`
--
ALTER TABLE `cek_pembayaran`
  ADD CONSTRAINT `cek_pembayaran_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `tb_siswa` (`nisn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD CONSTRAINT `tb_pembayaran_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `tb_siswa` (`nisn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
