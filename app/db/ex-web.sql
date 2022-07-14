-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 14 Jul 2022 pada 19.25
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ex-web`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_berita`
--

CREATE TABLE `tbl_berita` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `judul` varchar(250) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_berita_kategori`
--

CREATE TABLE `tbl_berita_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kerjasama`
--

CREATE TABLE `tbl_kerjasama` (
  `id` int(11) DEFAULT NULL,
  `id_umkm` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `file_kerjasama` text DEFAULT NULL,
  `status` enum('MENUNGGU','DITERIMA','DISETUJUI') DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id` int(11) NOT NULL,
  `id_menu_head` int(11) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL COMMENT '1:Aktif, 2:Nonaktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `id_menu_head`, `urutan`, `title`, `url`, `icon`, `status`) VALUES
(1, 1, 1, 'Dashboard', 'dashboard', 'nav-icon fas fa-tachometer-alt', 'ACTIVE'),
(2, 2, 2, 'Transaksi Penjualan', 'transaksi', 'fa fa-wallet', 'ACTIVE'),
(3, 2, 3, 'Berita', 'berita', 'fas fa-list-alt', 'ACTIVE'),
(4, 2, 4, 'Berita Kategori', 'berita', 'fas fa-list-alt', 'ACTIVE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu_head`
--

CREATE TABLE `tbl_menu_head` (
  `id` int(11) NOT NULL,
  `urutan` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_menu_head`
--

INSERT INTO `tbl_menu_head` (`id`, `urutan`, `title`, `status`) VALUES
(1, 1, 'DASHBOARD', 'ACTIVE'),
(2, 2, 'LAPORAN', 'ACTIVE'),
(3, 3, 'BERITA', 'ACTIVE'),
(4, 4, 'DATA', 'ACTIVE'),
(5, 5, 'SETTING', 'ACTIVE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu_role`
--

CREATE TABLE `tbl_menu_role` (
  `id` int(11) NOT NULL,
  `id_menu_head` int(11) DEFAULT NULL COMMENT 'IDMenuHead',
  `role` enum('SUPERADMIN','UMKM','RESELLER') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_menu_role`
--

INSERT INTO `tbl_menu_role` (`id`, `id_menu_head`, `role`) VALUES
(1, 1, 'SUPERADMIN'),
(2, 2, 'SUPERADMIN'),
(3, 3, 'SUPERADMIN'),
(4, 4, 'SUPERADMIN'),
(5, 5, 'SUPERADMIN'),
(6, 1, 'UMKM'),
(7, 2, 'UMKM'),
(8, 3, 'UMKM');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu_sub`
--

CREATE TABLE `tbl_menu_sub` (
  `id` int(11) NOT NULL,
  `role` enum('SUPERADMIN','UMKM','RESELLER') DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` int(11) NOT NULL,
  `role` enum('SUPERADMIN','UMKM','RESELLER') DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `role`, `nama`, `username`, `email`, `no_hp`, `password`, `foto`, `status`, `create_date`, `create_user`, `edit_date`, `edit_user`) VALUES
(5, 'SUPERADMIN', 'makmudin', NULL, 'id.makmudin@gmail.com', '089672231770', '$2y$10$jdtb46saCnkEbPJwvpTTyOxfKZ/hrDpy3ZCRwPwq3z5XVopqpxi1S', 'http://localhost:8080/assets/photo-user/ypia-uai_1.png', 'ACTIVE', '2022-07-14 11:49:49', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_produk_umkm`
--

CREATE TABLE `tbl_produk_umkm` (
  `id` int(11) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `qty_min` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_umkm`
--

CREATE TABLE `tbl_umkm` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(200) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `tbl_berita_kategori`
--
ALTER TABLE `tbl_berita_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menu_head`
--
ALTER TABLE `tbl_menu_head`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menu_role`
--
ALTER TABLE `tbl_menu_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menu_sub`
--
ALTER TABLE `tbl_menu_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_berita_kategori`
--
ALTER TABLE `tbl_berita_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu_head`
--
ALTER TABLE `tbl_menu_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu_role`
--
ALTER TABLE `tbl_menu_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu_sub`
--
ALTER TABLE `tbl_menu_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  ADD CONSTRAINT `id_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_berita_kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
