-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 27 Sep 2022 pada 10.23
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
  `ringkasan` text DEFAULT NULL,
  `flag` enum('BLOG','INFO UMKM','INFO RESELLER') DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_berita`
--

INSERT INTO `tbl_berita` (`id`, `id_kategori`, `judul`, `isi`, `ringkasan`, `flag`, `slug`, `foto`, `status`, `penulis`, `create_user`, `create_date`, `edit_user`, `edit_date`) VALUES
(1, 1, 'Berita 1', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#039;lorem ipsum&#039; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here', 'INFO RESELLER', 'berita-1', 'http://localhost:8080/assets/photo-berita/jajakor_2.png', 'ACTIVE', 'Makmudin', 'makmudin', '2022-07-23 21:33:27', 'makmudin', '2022-07-23 22:51:40'),
(6, 3, 'Berita 2', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#039;lorem ipsum&#039; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here', 'BLOG', 'berita-2', 'http://localhost:8080/assets/photo-berita/DSCF0595_5.JPG', 'ACTIVE', 'Makmudin', 'makmudin', '2022-07-23 21:36:26', 'makmudin', '2022-07-23 22:51:35');

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

--
-- Dumping data untuk tabel `tbl_berita_kategori`
--

INSERT INTO `tbl_berita_kategori` (`id`, `nama`, `status`, `create_user`, `create_date`, `edit_user`, `edit_date`) VALUES
(1, 'Eksportir  ', 'ACTIVE', 'makmudin', '2022-07-23 21:30:09', NULL, NULL),
(2, 'Promo', 'ACTIVE', 'makmudin', '2022-07-23 21:30:25', NULL, NULL),
(3, 'Lifestyle', 'ACTIVE', 'makmudin', '2022-07-23 21:30:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_city`
--

CREATE TABLE `tbl_city` (
  `city_id` bigint(20) NOT NULL,
  `province_id` bigint(20) NOT NULL,
  `city_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_city`
--

INSERT INTO `tbl_city` (`city_id`, `province_id`, `city_name`) VALUES
(1, 21, 'Aceh Barat'),
(2, 21, 'Aceh Barat Daya'),
(3, 21, 'Aceh Besar'),
(4, 21, 'Aceh Jaya'),
(5, 21, 'Aceh Selatan'),
(6, 21, 'Aceh Singkil'),
(7, 21, 'Aceh Tamiang'),
(8, 21, 'Aceh Tengah'),
(9, 21, 'Aceh Tenggara'),
(10, 21, 'Aceh Timur'),
(11, 21, 'Aceh Utara'),
(12, 32, 'Agam'),
(13, 23, 'Alor'),
(14, 19, 'Ambon'),
(15, 34, 'Asahan'),
(16, 24, 'Asmat'),
(17, 1, 'Badung'),
(18, 13, 'Balangan'),
(19, 15, 'Balikpapan'),
(20, 21, 'Banda Aceh'),
(21, 18, 'Bandar Lampung'),
(22, 9, 'Bandung'),
(23, 9, 'Bandung'),
(24, 9, 'Bandung Barat'),
(25, 29, 'Banggai'),
(26, 29, 'Banggai Kepulauan'),
(27, 2, 'Bangka'),
(28, 2, 'Bangka Barat'),
(29, 2, 'Bangka Selatan'),
(30, 2, 'Bangka Tengah'),
(31, 11, 'Bangkalan'),
(32, 1, 'Bangli'),
(33, 13, 'Banjar'),
(34, 9, 'Banjar'),
(35, 13, 'Banjarbaru'),
(36, 13, 'Banjarmasin'),
(37, 10, 'Banjarnegara'),
(38, 28, 'Bantaeng'),
(39, 5, 'Bantul'),
(40, 33, 'Banyuasin'),
(41, 10, 'Banyumas'),
(42, 11, 'Banyuwangi'),
(43, 13, 'Barito Kuala'),
(44, 14, 'Barito Selatan'),
(45, 14, 'Barito Timur'),
(46, 14, 'Barito Utara'),
(47, 28, 'Barru'),
(48, 17, 'Batam'),
(49, 10, 'Batang'),
(50, 8, 'Batang Hari'),
(51, 11, 'Batu'),
(52, 34, 'Batu Bara'),
(53, 30, 'Bau-Bau'),
(54, 9, 'Bekasi'),
(55, 9, 'Bekasi'),
(56, 2, 'Belitung'),
(57, 2, 'Belitung Timur'),
(58, 23, 'Belu'),
(59, 21, 'Bener Meriah'),
(60, 26, 'Bengkalis'),
(61, 12, 'Bengkayang'),
(62, 4, 'Bengkulu'),
(63, 4, 'Bengkulu Selatan'),
(64, 4, 'Bengkulu Tengah'),
(65, 4, 'Bengkulu Utara'),
(66, 15, 'Berau'),
(67, 24, 'Biak Numfor'),
(68, 22, 'Bima'),
(69, 22, 'Bima'),
(70, 34, 'Binjai'),
(71, 17, 'Bintan'),
(72, 21, 'Bireuen'),
(73, 31, 'Bitung'),
(74, 11, 'Blitar'),
(75, 11, 'Blitar'),
(76, 10, 'Blora'),
(77, 7, 'Boalemo'),
(78, 9, 'Bogor'),
(79, 9, 'Bogor'),
(80, 11, 'Bojonegoro'),
(81, 31, 'Bolaang Mongondow (Bolmong)'),
(82, 31, 'Bolaang Mongondow Selatan'),
(83, 31, 'Bolaang Mongondow Timur'),
(84, 31, 'Bolaang Mongondow Utara'),
(85, 30, 'Bombana'),
(86, 11, 'Bondowoso'),
(87, 28, 'Bone'),
(88, 7, 'Bone Bolango'),
(89, 15, 'Bontang'),
(90, 24, 'Boven Digoel'),
(91, 10, 'Boyolali'),
(92, 10, 'Brebes'),
(93, 32, 'Bukittinggi'),
(94, 1, 'Buleleng'),
(95, 28, 'Bulukumba'),
(96, 16, 'Bulungan (Bulongan)'),
(97, 8, 'Bungo'),
(98, 29, 'Buol'),
(99, 19, 'Buru'),
(100, 19, 'Buru Selatan'),
(101, 30, 'Buton'),
(102, 30, 'Buton Utara'),
(103, 9, 'Ciamis'),
(104, 9, 'Cianjur'),
(105, 10, 'Cilacap'),
(106, 3, 'Cilegon'),
(107, 9, 'Cimahi'),
(108, 9, 'Cirebon'),
(109, 9, 'Cirebon'),
(110, 34, 'Dairi'),
(111, 24, 'Deiyai (Deliyai)'),
(112, 34, 'Deli Serdang'),
(113, 10, 'Demak'),
(114, 1, 'Denpasar'),
(115, 9, 'Depok'),
(116, 32, 'Dharmasraya'),
(117, 24, 'Dogiyai'),
(118, 22, 'Dompu'),
(119, 29, 'Donggala'),
(120, 26, 'Dumai'),
(121, 33, 'Empat Lawang'),
(122, 23, 'Ende'),
(123, 28, 'Enrekang'),
(124, 25, 'Fakfak'),
(125, 23, 'Flores Timur'),
(126, 9, 'Garut'),
(127, 21, 'Gayo Lues'),
(128, 1, 'Gianyar'),
(129, 7, 'Gorontalo'),
(130, 7, 'Gorontalo'),
(131, 7, 'Gorontalo Utara'),
(132, 28, 'Gowa'),
(133, 11, 'Gresik'),
(134, 10, 'Grobogan'),
(135, 5, 'Gunung Kidul'),
(136, 14, 'Gunung Mas'),
(137, 34, 'Gunungsitoli'),
(138, 20, 'Halmahera Barat'),
(139, 20, 'Halmahera Selatan'),
(140, 20, 'Halmahera Tengah'),
(141, 20, 'Halmahera Timur'),
(142, 20, 'Halmahera Utara'),
(143, 13, 'Hulu Sungai Selatan'),
(144, 13, 'Hulu Sungai Tengah'),
(145, 13, 'Hulu Sungai Utara'),
(146, 34, 'Humbang Hasundutan'),
(147, 26, 'Indragiri Hilir'),
(148, 26, 'Indragiri Hulu'),
(149, 9, 'Indramayu'),
(150, 24, 'Intan Jaya'),
(151, 6, 'Jakarta Barat'),
(152, 6, 'Jakarta Pusat'),
(153, 6, 'Jakarta Selatan'),
(154, 6, 'Jakarta Timur'),
(155, 6, 'Jakarta Utara'),
(156, 8, 'Jambi'),
(157, 24, 'Jayapura'),
(158, 24, 'Jayapura'),
(159, 24, 'Jayawijaya'),
(160, 11, 'Jember'),
(161, 1, 'Jembrana'),
(162, 28, 'Jeneponto'),
(163, 10, 'Jepara'),
(164, 11, 'Jombang'),
(165, 25, 'Kaimana'),
(166, 26, 'Kampar'),
(167, 14, 'Kapuas'),
(168, 12, 'Kapuas Hulu'),
(169, 10, 'Karanganyar'),
(170, 1, 'Karangasem'),
(171, 9, 'Karawang'),
(172, 17, 'Karimun'),
(173, 34, 'Karo'),
(174, 14, 'Katingan'),
(175, 4, 'Kaur'),
(176, 12, 'Kayong Utara'),
(177, 10, 'Kebumen'),
(178, 11, 'Kediri'),
(179, 11, 'Kediri'),
(180, 24, 'Keerom'),
(181, 10, 'Kendal'),
(182, 30, 'Kendari'),
(183, 4, 'Kepahiang'),
(184, 17, 'Kepulauan Anambas'),
(185, 19, 'Kepulauan Aru'),
(186, 32, 'Kepulauan Mentawai'),
(187, 26, 'Kepulauan Meranti'),
(188, 31, 'Kepulauan Sangihe'),
(189, 6, 'Kepulauan Seribu'),
(190, 31, 'Kepulauan Siau Tagulandang Biaro (Sitaro)'),
(191, 20, 'Kepulauan Sula'),
(192, 31, 'Kepulauan Talaud'),
(193, 24, 'Kepulauan Yapen (Yapen Waropen)'),
(194, 8, 'Kerinci'),
(195, 12, 'Ketapang'),
(196, 10, 'Klaten'),
(197, 1, 'Klungkung'),
(198, 30, 'Kolaka'),
(199, 30, 'Kolaka Utara'),
(200, 30, 'Konawe'),
(201, 30, 'Konawe Selatan'),
(202, 30, 'Konawe Utara'),
(203, 13, 'Kotabaru'),
(204, 31, 'Kotamobagu'),
(205, 14, 'Kotawaringin Barat'),
(206, 14, 'Kotawaringin Timur'),
(207, 26, 'Kuantan Singingi'),
(208, 12, 'Kubu Raya'),
(209, 10, 'Kudus'),
(210, 5, 'Kulon Progo'),
(211, 9, 'Kuningan'),
(212, 23, 'Kupang'),
(213, 23, 'Kupang'),
(214, 15, 'Kutai Barat'),
(215, 15, 'Kutai Kartanegara'),
(216, 15, 'Kutai Timur'),
(217, 34, 'Labuhan Batu'),
(218, 34, 'Labuhan Batu Selatan'),
(219, 34, 'Labuhan Batu Utara'),
(220, 33, 'Lahat'),
(221, 14, 'Lamandau'),
(222, 11, 'Lamongan'),
(223, 18, 'Lampung Barat'),
(224, 18, 'Lampung Selatan'),
(225, 18, 'Lampung Tengah'),
(226, 18, 'Lampung Timur'),
(227, 18, 'Lampung Utara'),
(228, 12, 'Landak'),
(229, 34, 'Langkat'),
(230, 21, 'Langsa'),
(231, 24, 'Lanny Jaya'),
(232, 3, 'Lebak'),
(233, 4, 'Lebong'),
(234, 23, 'Lembata'),
(235, 21, 'Lhokseumawe'),
(236, 32, 'Lima Puluh Koto/Kota'),
(237, 17, 'Lingga'),
(238, 22, 'Lombok Barat'),
(239, 22, 'Lombok Tengah'),
(240, 22, 'Lombok Timur'),
(241, 22, 'Lombok Utara'),
(242, 33, 'Lubuk Linggau'),
(243, 11, 'Lumajang'),
(244, 28, 'Luwu'),
(245, 28, 'Luwu Timur'),
(246, 28, 'Luwu Utara'),
(247, 11, 'Madiun'),
(248, 11, 'Madiun'),
(249, 10, 'Magelang'),
(250, 10, 'Magelang'),
(251, 11, 'Magetan'),
(252, 9, 'Majalengka'),
(253, 27, 'Majene'),
(254, 28, 'Makassar'),
(255, 11, 'Malang'),
(256, 11, 'Malang'),
(257, 16, 'Malinau'),
(258, 19, 'Maluku Barat Daya'),
(259, 19, 'Maluku Tengah'),
(260, 19, 'Maluku Tenggara'),
(261, 19, 'Maluku Tenggara Barat'),
(262, 27, 'Mamasa'),
(263, 24, 'Mamberamo Raya'),
(264, 24, 'Mamberamo Tengah'),
(265, 27, 'Mamuju'),
(266, 27, 'Mamuju Utara'),
(267, 31, 'Manado'),
(268, 34, 'Mandailing Natal'),
(269, 23, 'Manggarai'),
(270, 23, 'Manggarai Barat'),
(271, 23, 'Manggarai Timur'),
(272, 25, 'Manokwari'),
(273, 25, 'Manokwari Selatan'),
(274, 24, 'Mappi'),
(275, 28, 'Maros'),
(276, 22, 'Mataram'),
(277, 25, 'Maybrat'),
(278, 34, 'Medan'),
(279, 12, 'Melawi'),
(280, 8, 'Merangin'),
(281, 24, 'Merauke'),
(282, 18, 'Mesuji'),
(283, 18, 'Metro'),
(284, 24, 'Mimika'),
(285, 31, 'Minahasa'),
(286, 31, 'Minahasa Selatan'),
(287, 31, 'Minahasa Tenggara'),
(288, 31, 'Minahasa Utara'),
(289, 11, 'Mojokerto'),
(290, 11, 'Mojokerto'),
(291, 29, 'Morowali'),
(292, 33, 'Muara Enim'),
(293, 8, 'Muaro Jambi'),
(294, 4, 'Muko Muko'),
(295, 30, 'Muna'),
(296, 14, 'Murung Raya'),
(297, 33, 'Musi Banyuasin'),
(298, 33, 'Musi Rawas'),
(299, 24, 'Nabire'),
(300, 21, 'Nagan Raya'),
(301, 23, 'Nagekeo'),
(302, 17, 'Natuna'),
(303, 24, 'Nduga'),
(304, 23, 'Ngada'),
(305, 11, 'Nganjuk'),
(306, 11, 'Ngawi'),
(307, 34, 'Nias'),
(308, 34, 'Nias Barat'),
(309, 34, 'Nias Selatan'),
(310, 34, 'Nias Utara'),
(311, 16, 'Nunukan'),
(312, 33, 'Ogan Ilir'),
(313, 33, 'Ogan Komering Ilir'),
(314, 33, 'Ogan Komering Ulu'),
(315, 33, 'Ogan Komering Ulu Selatan'),
(316, 33, 'Ogan Komering Ulu Timur'),
(317, 11, 'Pacitan'),
(318, 32, 'Padang'),
(319, 34, 'Padang Lawas'),
(320, 34, 'Padang Lawas Utara'),
(321, 32, 'Padang Panjang'),
(322, 32, 'Padang Pariaman'),
(323, 34, 'Padang Sidempuan'),
(324, 33, 'Pagar Alam'),
(325, 34, 'Pakpak Bharat'),
(326, 14, 'Palangka Raya'),
(327, 33, 'Palembang'),
(328, 28, 'Palopo'),
(329, 29, 'Palu'),
(330, 11, 'Pamekasan'),
(331, 3, 'Pandeglang'),
(332, 9, 'Pangandaran'),
(333, 28, 'Pangkajene Kepulauan'),
(334, 2, 'Pangkal Pinang'),
(335, 24, 'Paniai'),
(336, 28, 'Parepare'),
(337, 32, 'Pariaman'),
(338, 29, 'Parigi Moutong'),
(339, 32, 'Pasaman'),
(340, 32, 'Pasaman Barat'),
(341, 15, 'Paser'),
(342, 11, 'Pasuruan'),
(343, 11, 'Pasuruan'),
(344, 10, 'Pati'),
(345, 32, 'Payakumbuh'),
(346, 25, 'Pegunungan Arfak'),
(347, 24, 'Pegunungan Bintang'),
(348, 10, 'Pekalongan'),
(349, 10, 'Pekalongan'),
(350, 26, 'Pekanbaru'),
(351, 26, 'Pelalawan'),
(352, 10, 'Pemalang'),
(353, 34, 'Pematang Siantar'),
(354, 15, 'Penajam Paser Utara'),
(355, 18, 'Pesawaran'),
(356, 18, 'Pesisir Barat'),
(357, 32, 'Pesisir Selatan'),
(358, 21, 'Pidie'),
(359, 21, 'Pidie Jaya'),
(360, 28, 'Pinrang'),
(361, 7, 'Pohuwato'),
(362, 27, 'Polewali Mandar'),
(363, 11, 'Ponorogo'),
(364, 12, 'Pontianak'),
(365, 12, 'Pontianak'),
(366, 29, 'Poso'),
(367, 33, 'Prabumulih'),
(368, 18, 'Pringsewu'),
(369, 11, 'Probolinggo'),
(370, 11, 'Probolinggo'),
(371, 14, 'Pulang Pisau'),
(372, 20, 'Pulau Morotai'),
(373, 24, 'Puncak'),
(374, 24, 'Puncak Jaya'),
(375, 10, 'Purbalingga'),
(376, 9, 'Purwakarta'),
(377, 10, 'Purworejo'),
(378, 25, 'Raja Ampat'),
(379, 4, 'Rejang Lebong'),
(380, 10, 'Rembang'),
(381, 26, 'Rokan Hilir'),
(382, 26, 'Rokan Hulu'),
(383, 23, 'Rote Ndao'),
(384, 21, 'Sabang'),
(385, 23, 'Sabu Raijua'),
(386, 10, 'Salatiga'),
(387, 15, 'Samarinda'),
(388, 12, 'Sambas'),
(389, 34, 'Samosir'),
(390, 11, 'Sampang'),
(391, 12, 'Sanggau'),
(392, 24, 'Sarmi'),
(393, 8, 'Sarolangun'),
(394, 32, 'Sawah Lunto'),
(395, 12, 'Sekadau'),
(396, 28, 'Selayar (Kepulauan Selayar)'),
(397, 4, 'Seluma'),
(398, 10, 'Semarang'),
(399, 10, 'Semarang'),
(400, 19, 'Seram Bagian Barat'),
(401, 19, 'Seram Bagian Timur'),
(402, 3, 'Serang'),
(403, 3, 'Serang'),
(404, 34, 'Serdang Bedagai'),
(405, 14, 'Seruyan'),
(406, 26, 'Siak'),
(407, 34, 'Sibolga'),
(408, 28, 'Sidenreng Rappang/Rapang'),
(409, 11, 'Sidoarjo'),
(410, 29, 'Sigi'),
(411, 32, 'Sijunjung (Sawah Lunto Sijunjung)'),
(412, 23, 'Sikka'),
(413, 34, 'Simalungun'),
(414, 21, 'Simeulue'),
(415, 12, 'Singkawang'),
(416, 28, 'Sinjai'),
(417, 12, 'Sintang'),
(418, 11, 'Situbondo'),
(419, 5, 'Sleman'),
(420, 32, 'Solok'),
(421, 32, 'Solok'),
(422, 32, 'Solok Selatan'),
(423, 28, 'Soppeng'),
(424, 25, 'Sorong'),
(425, 25, 'Sorong'),
(426, 25, 'Sorong Selatan'),
(427, 10, 'Sragen'),
(428, 9, 'Subang'),
(429, 21, 'Subulussalam'),
(430, 9, 'Sukabumi'),
(431, 9, 'Sukabumi'),
(432, 14, 'Sukamara'),
(433, 10, 'Sukoharjo'),
(434, 23, 'Sumba Barat'),
(435, 23, 'Sumba Barat Daya'),
(436, 23, 'Sumba Tengah'),
(437, 23, 'Sumba Timur'),
(438, 22, 'Sumbawa'),
(439, 22, 'Sumbawa Barat'),
(440, 9, 'Sumedang'),
(441, 11, 'Sumenep'),
(442, 8, 'Sungaipenuh'),
(443, 24, 'Supiori'),
(444, 11, 'Surabaya'),
(445, 10, 'Surakarta (Solo)'),
(446, 13, 'Tabalong'),
(447, 1, 'Tabanan'),
(448, 28, 'Takalar'),
(449, 25, 'Tambrauw'),
(450, 16, 'Tana Tidung'),
(451, 28, 'Tana Toraja'),
(452, 13, 'Tanah Bumbu'),
(453, 32, 'Tanah Datar'),
(454, 13, 'Tanah Laut'),
(455, 3, 'Tangerang'),
(456, 3, 'Tangerang'),
(457, 3, 'Tangerang Selatan'),
(458, 18, 'Tanggamus'),
(459, 34, 'Tanjung Balai'),
(460, 8, 'Tanjung Jabung Barat'),
(461, 8, 'Tanjung Jabung Timur'),
(462, 17, 'Tanjung Pinang'),
(463, 34, 'Tapanuli Selatan'),
(464, 34, 'Tapanuli Tengah'),
(465, 34, 'Tapanuli Utara'),
(466, 13, 'Tapin'),
(467, 16, 'Tarakan'),
(468, 9, 'Tasikmalaya'),
(469, 9, 'Tasikmalaya'),
(470, 34, 'Tebing Tinggi'),
(471, 8, 'Tebo'),
(472, 10, 'Tegal'),
(473, 10, 'Tegal'),
(474, 25, 'Teluk Bintuni'),
(475, 25, 'Teluk Wondama'),
(476, 10, 'Temanggung'),
(477, 20, 'Ternate'),
(478, 20, 'Tidore Kepulauan'),
(479, 23, 'Timor Tengah Selatan'),
(480, 23, 'Timor Tengah Utara'),
(481, 34, 'Toba Samosir'),
(482, 29, 'Tojo Una-Una'),
(483, 29, 'Toli-Toli'),
(484, 24, 'Tolikara'),
(485, 31, 'Tomohon'),
(486, 28, 'Toraja Utara'),
(487, 11, 'Trenggalek'),
(488, 19, 'Tual'),
(489, 11, 'Tuban'),
(490, 18, 'Tulang Bawang'),
(491, 18, 'Tulang Bawang Barat'),
(492, 11, 'Tulungagung'),
(493, 28, 'Wajo'),
(494, 30, 'Wakatobi'),
(495, 24, 'Waropen'),
(496, 18, 'Way Kanan'),
(497, 10, 'Wonogiri'),
(498, 10, 'Wonosobo'),
(499, 24, 'Yahukimo'),
(500, 24, 'Yalimo'),
(501, 5, 'Yogyakarta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori_produk`
--

CREATE TABLE `tbl_kategori_produk` (
  `id` int(11) NOT NULL,
  `id_umkm` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_kategori_produk`
--

INSERT INTO `tbl_kategori_produk` (`id`, `id_umkm`, `nama`, `status`, `create_user`, `create_date`, `edit_user`, `edit_date`) VALUES
(3, 1, 'Frozen Food', 'ACTIVE', 'UMKM - JELETOT', '2022-07-23 21:43:12', NULL, NULL),
(4, 1, 'Sambel Jeletot', 'ACTIVE', 'UMKM - JELETOT', '2022-07-23 21:43:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori_umkm`
--

CREATE TABLE `tbl_kategori_umkm` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','','') DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_kategori_umkm`
--

INSERT INTO `tbl_kategori_umkm` (`id`, `nama`, `status`, `create_user`, `create_date`, `edit_user`, `edit_date`) VALUES
(1, 'Seni Kriya', 'ACTIVE', 'makmudin', '2022-07-23 21:23:17', NULL, NULL),
(2, 'Fashion', 'ACTIVE', 'makmudin', '2022-07-23 21:23:29', NULL, NULL),
(3, 'F&amp;B', 'ACTIVE', 'makmudin', '2022-07-23 21:23:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kerjasama`
--

CREATE TABLE `tbl_kerjasama` (
  `id` int(11) NOT NULL,
  `id_umkm` int(11) DEFAULT NULL,
  `id_reseller` int(11) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `file_kerjasama` text DEFAULT NULL,
  `lama_kerjasama` int(11) DEFAULT NULL COMMENT 'Bulan',
  `status` enum('Active','Inactive') DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kerjasama_produk`
--

CREATE TABLE `tbl_kerjasama_produk` (
  `id` int(11) NOT NULL,
  `id_kerjasama` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga_reseller` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kerjasama_transaksi`
--

CREATE TABLE `tbl_kerjasama_transaksi` (
  `id` int(11) NOT NULL,
  `id_kerjasama` int(11) NOT NULL,
  `bulan_ke` int(11) NOT NULL,
  `laporan_teks` text NOT NULL,
  `laporan_photo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id` int(11) NOT NULL,
  `id_menu_title` int(11) DEFAULT NULL,
  `role` enum('SUPERADMIN','UMKM','RESELLER') DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL COMMENT '1:Aktif, 2:Nonaktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `id_menu_title`, `role`, `urutan`, `title`, `url`, `icon`, `status`) VALUES
(1, 1, 'SUPERADMIN', 1, 'Dashboard', '/admin/dashboard', 'nav-icon fas fa-tachometer-alt', 'ACTIVE'),
(2, 2, 'SUPERADMIN', 2, 'Transaksi Penjualan', '/transaksi', 'fa fa-wallet', 'ACTIVE'),
(3, 3, 'SUPERADMIN', 3, 'Berita', '/admin/berita', 'fas fa-list-alt', 'ACTIVE'),
(4, 3, 'SUPERADMIN', 4, 'Berita Kategori', '/admin/berita_kategori', 'fas fa-list-alt', 'ACTIVE'),
(5, 4, 'UMKM', 1, 'Produk', '/umkm/produk', 'fas fa-list-alt', 'ACTIVE'),
(6, 4, 'UMKM', 2, 'Kategori Produk', '/umkm/kategori-produk', 'fas fa-list-alt', 'ACTIVE'),
(7, 5, 'UMKM', 1, 'Profil', '/umkm/profil', 'fas fa-list-alt', 'ACTIVE'),
(8, 6, 'UMKM', 1, 'Kontrak Perjanjian', '/umkm/kontrak-perjanjian', 'fas fa-list-alt', 'ACTIVE'),
(9, 2, 'UMKM', 1, 'Transaksi', '/umkm/laporan-transaksi', 'fas fa-list-alt', 'ACTIVE'),
(10, 5, 'SUPERADMIN', 1, 'Pengguna', '/admin/user', 'fas fa-list-alt', 'ACTIVE'),
(11, 4, 'SUPERADMIN', 1, 'UMKM', '/admin/umkm', 'fas fa-list-alt', 'ACTIVE'),
(12, 4, 'SUPERADMIN', 1, 'Produk', '/admin/produk', 'fas fa-list-alt', 'ACTIVE'),
(13, 4, 'SUPERADMIN', 1, 'Kategori UMKM', '/admin/kategori-umkm', 'fas fa-list-alt', 'ACTIVE'),
(14, 4, 'RESELLER', 1, 'Pesanan Saya', '/reseller/transaksi', 'fas fa-list-alt', 'ACTIVE'),
(15, 5, 'RESELLER', 1, 'Profil', '/reseller/profil', 'fas fa-list-alt', 'ACTIVE'),
(16, 4, 'RESELLER', 1, 'Chat', '/reseller/chat', 'fas fa-list-alt', 'INACTIVE'),
(17, 3, 'RESELLER', 1, 'Berita', '/reseller/berita', 'fas fa-list-alt', 'ACTIVE'),
(18, 4, 'RESELLER', 2, 'Kerjasama Saya', '/reseller/kerjasama-saya', 'fas fa-list-alt', 'ACTIVE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu_title`
--

CREATE TABLE `tbl_menu_title` (
  `id` int(11) NOT NULL,
  `urutan` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_menu_title`
--

INSERT INTO `tbl_menu_title` (`id`, `urutan`, `title`, `status`) VALUES
(1, 1, 'DASHBOARD', 'ACTIVE'),
(2, 2, 'LAPORAN', 'ACTIVE'),
(3, 3, 'BERITA', 'ACTIVE'),
(4, 4, 'DATA', 'ACTIVE'),
(5, 5, 'SETTING', 'ACTIVE'),
(6, 1, 'KERJASAMA', 'ACTIVE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` int(11) NOT NULL,
  `role` enum('SUPERADMIN','UMKM','RESELLER') DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `id_propinsi` int(11) DEFAULT NULL,
  `id_kota` int(11) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `role`, `nama`, `email`, `tgl_lahir`, `no_hp`, `password`, `foto`, `alamat`, `id_propinsi`, `id_kota`, `status`, `create_date`, `create_user`, `edit_date`, `edit_user`) VALUES
(5, 'SUPERADMIN', 'makmudin', 'id.makmudin@gmail.com', NULL, '089672231770', '$2y$10$jdtb46saCnkEbPJwvpTTyOxfKZ/hrDpy3ZCRwPwq3z5XVopqpxi1S', 'http://localhost:8080/assets/photo-user/ypia-uai_1.png', NULL, NULL, NULL, 'ACTIVE', '2022-07-14 11:49:49', NULL, NULL, NULL),
(9, 'UMKM', 'UMKM - JELETOT', 'umkm@gmail.com', NULL, '089672231770', '$2y$10$jdtb46saCnkEbPJwvpTTyOxfKZ/hrDpy3ZCRwPwq3z5XVopqpxi1S', 'http://localhost:8080/assets/photo-user/Jeletot Kabeh Stiker.png', NULL, NULL, NULL, 'ACTIVE', '2022-07-23 21:28:11', 'makmudin', NULL, NULL),
(10, 'UMKM', 'coba umkm', 'coba@umkm.id', NULL, '0986899', '$2y$10$75aXOn8o7OVvhxE9XODsw.mfkjSyhvMJu0uuebm6PB/AHKaIhvjMW', 'http://localhost:8080/assets/admin/img/avatar5.png', NULL, NULL, NULL, 'ACTIVE', '2022-08-06 11:05:01', 'makmudin', NULL, NULL),
(12, 'RESELLER', 'Reseller', 'reseller@exportir.id', NULL, '089672231770', '$2y$10$jdtb46saCnkEbPJwvpTTyOxfKZ/hrDpy3ZCRwPwq3z5XVopqpxi1S', 'http://localhost:8080/assets/photo-user/makmudin.jpg', NULL, NULL, NULL, 'ACTIVE', '2022-09-13 01:40:54', 'makmudin', NULL, NULL),
(13, 'RESELLER', 'Aan Nurjanah', 'dev@uswah.id', NULL, '089672231770', '$2y$10$mFGxHzYuAzob89xtUa5gku6oCA/J5x.LXuGWlsvojcsRl55o62nju', NULL, NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL),
(14, 'RESELLER', 'makmudin@reseller.id', 'makmudin@reseller.id', NULL, '089672231770', '$2y$10$uOpnRa9ezs43PxtucMr8S./pq0IJjAEwJodIxNWVNAHqzig2E.3Vm', NULL, NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_produk_umkm`
--

CREATE TABLE `tbl_produk_umkm` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `id_umkm` int(11) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `qty_min` int(11) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_produk_umkm`
--

INSERT INTO `tbl_produk_umkm` (`id`, `id_kategori`, `foto`, `id_umkm`, `nama`, `harga`, `deskripsi`, `qty`, `qty_min`, `satuan`, `weight`, `status`) VALUES
(3, 3, 'http://localhost:8080/assets/photo-produk/DSCF0595.JPG', 1, 'Seblak Frozen Seafood', 0, 'lorem ipsum asdfapsdofakpsdf asdpfoaksdpfoak sdflakxcj vlkajsdf asdfasdlfkajs ladksjflakdsf&amp;nbsp;', 5, 20, 'Pcs', 100, 'ACTIVE'),
(4, 3, 'http://localhost:8080/assets/photo-produk/DSCF0591.JPG', 1, 'Jajakor', 0, 'lorem ipsum asdfapsdofakpsdf asdpfoaksdpfoak sdflakxcj vlkajsdf asdfasdlfkajs ladksjflakdsf&amp;nbsp;', 1000, 10, 'Pcs', NULL, 'ACTIVE'),
(5, 3, 'http://localhost:8080/assets/photo-produk/DSCF0620.JPG', 1, 'Dumpling', 750000, 'lorem ipsum asdfapsdofakpsdf asdpfoaksdpfoak sdflakxcj vlkajsdf asdfasdlfkajs ladksjflakdsf&amp;nbsp; lorem ipsum asdfapsdofakpsdf asdpfoaksdpfoak sdflakxcj vlkajsdf asdfasdlfkajs ladksjflakdsf&amp;nbsp;', 100, 12, 'Pcs', NULL, 'ACTIVE'),
(6, 4, 'http://localhost:8080/assets/photo-produk/DSCF0620.JPG', 1, 'wesfrsdf', 234234235, 'lorem ipsum asdfapsdofakpsdf asdpfoaksdpfoak sdflakxcj vlkajsdf asdfasdlfkajs ladksjflakdsf&amp;nbsp;', 232, 234235, 'pcs', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_propinsi`
--

CREATE TABLE `tbl_propinsi` (
  `province_id` bigint(20) NOT NULL,
  `province` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_propinsi`
--

INSERT INTO `tbl_propinsi` (`province_id`, `province`) VALUES
(1, 'Bali'),
(2, 'Bangka Belitung'),
(3, 'Banten'),
(4, 'Bengkulu'),
(5, 'DI Yogyakarta'),
(6, 'DKI Jakarta'),
(7, 'Gorontalo'),
(8, 'Jambi'),
(9, 'Jawa Barat'),
(10, 'Jawa Tengah'),
(11, 'Jawa Timur'),
(12, 'Kalimantan Barat'),
(13, 'Kalimantan Selatan'),
(14, 'Kalimantan Tengah'),
(15, 'Kalimantan Timur'),
(16, 'Kalimantan Utara'),
(17, 'Kepulauan Riau'),
(18, 'Lampung'),
(19, 'Maluku'),
(20, 'Maluku Utara'),
(21, 'Nanggroe Aceh Darussalam (NAD)'),
(22, 'Nusa Tenggara Barat (NTB)'),
(23, 'Nusa Tenggara Timur (NTT)'),
(24, 'Papua'),
(25, 'Papua Barat'),
(26, 'Riau'),
(27, 'Sulawesi Barat'),
(28, 'Sulawesi Selatan'),
(29, 'Sulawesi Tengah'),
(30, 'Sulawesi Tenggara'),
(31, 'Sulawesi Utara'),
(32, 'Sumatera Barat'),
(33, 'Sumatera Selatan'),
(34, 'Sumatera Utara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id` int(12) NOT NULL,
  `id_pembayaran` bigint(20) DEFAULT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `id_pengguna` int(12) NOT NULL,
  `id_umkm` int(20) NOT NULL,
  `jumlah` int(255) DEFAULT NULL,
  `ongkir` int(20) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nohp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `kurir` varchar(255) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `no_resi` varchar(255) DEFAULT NULL,
  `status` enum('BELUM','SEDANG','SUDAH','SELESAI') NOT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NULL DEFAULT current_timestamp(),
  `checkout` enum('Y','T') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id`, `id_pembayaran`, `kode_transaksi`, `id_pengguna`, `id_umkm`, `jumlah`, `ongkir`, `nama`, `email`, `nohp`, `alamat`, `keterangan`, `kurir`, `service`, `no_resi`, `status`, `created_date`, `updated_date`, `checkout`) VALUES
(6, 4, 'TR220922-JQYWOJ9Q', 11, 1, 2264000, 14000, 'zxc', 'xzc@gmail.com', '9876', 'hjk', 'asd', 'pos', 'Pos Reguler', NULL, 'BELUM', '2022-09-22 14:34:56', '2022-09-22 14:34:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi_detail`
--

CREATE TABLE `tbl_transaksi_detail` (
  `id` int(12) NOT NULL,
  `id_transaksi` int(12) DEFAULT NULL,
  `id_barang` int(12) DEFAULT NULL,
  `qty` int(20) NOT NULL,
  `weight` int(20) NOT NULL,
  `harga` int(20) NOT NULL,
  `subtotal` int(20) NOT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_transaksi_detail`
--

INSERT INTO `tbl_transaksi_detail` (`id`, `id_transaksi`, `id_barang`, `qty`, `weight`, `harga`, `subtotal`, `created_date`, `updated_date`) VALUES
(5, 6, 5, 3, 1000, 750000, 2250000, '2022-09-22 14:34:56', '2022-09-22 14:34:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi_pembayaran`
--

CREATE TABLE `tbl_transaksi_pembayaran` (
  `id` bigint(20) NOT NULL,
  `total_tagihan` int(20) DEFAULT NULL,
  `bukti_url` text DEFAULT NULL,
  `status` enum('BELUM','SUDAH','BATAL') NOT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp(),
  `create_user` varchar(50) DEFAULT NULL,
  `edit_date` timestamp NULL DEFAULT current_timestamp(),
  `edit_user` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_transaksi_pembayaran`
--

INSERT INTO `tbl_transaksi_pembayaran` (`id`, `total_tagihan`, `bukti_url`, `status`, `create_date`, `create_user`, `edit_date`, `edit_user`) VALUES
(4, 2264000, NULL, 'BELUM', '2022-09-22 14:34:56', 'reseller', '2022-09-22 14:34:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_umkm`
--

CREATE TABLE `tbl_umkm` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(50) DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `deskripsi` varchar(200) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `edit_user` varchar(100) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_umkm`
--

INSERT INTO `tbl_umkm` (`id`, `id_pengguna`, `id_kategori`, `nama`, `alamat`, `no_telepon`, `slug`, `city_id`, `deskripsi`, `foto`, `status`, `create_user`, `create_date`, `edit_user`, `edit_date`) VALUES
(1, 9, 3, 'Jeletot Kabeh', 'indramayu', '089672231870', 'jeletot-kabeh', 149, '\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type ', 'http://localhost:8080/assets/photo-umkm/kimchi_1.jpg', 'ACTIVE', NULL, '2022-07-16 05:03:46', 'UMKM - JELETOT', '2022-08-23 13:18:19'),
(5, 10, 2, 'Coba UMKM', 'Jakarta', 'no_telepon', 'coba-umkm', 22, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type a', 'http://localhost:8080/assets/photo-umkm/kimchi_1.jpg', 'ACTIVE', 'makmudin', '2022-08-06 11:05:37', 'makmudin', '2022-08-06 11:06:19');

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
-- Indeks untuk tabel `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indeks untuk tabel `tbl_kategori_produk`
--
ALTER TABLE `tbl_kategori_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_umkm` (`id_umkm`);

--
-- Indeks untuk tabel `tbl_kategori_umkm`
--
ALTER TABLE `tbl_kategori_umkm`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_kerjasama`
--
ALTER TABLE `tbl_kerjasama`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_umkm` (`id_umkm`),
  ADD KEY `id_pengguna` (`id_reseller`);

--
-- Indeks untuk tabel `tbl_kerjasama_produk`
--
ALTER TABLE `tbl_kerjasama_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_kerjasama_transaksi`
--
ALTER TABLE `tbl_kerjasama_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_menu_title` (`id_menu_title`);

--
-- Indeks untuk tabel `tbl_menu_title`
--
ALTER TABLE `tbl_menu_title`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_produk_umkm`
--
ALTER TABLE `tbl_produk_umkm`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_propinsi`
--
ALTER TABLE `tbl_propinsi`
  ADD PRIMARY KEY (`province_id`);

--
-- Indeks untuk tabel `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_transaksi_detail`
--
ALTER TABLE `tbl_transaksi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_transaksi_pembayaran`
--
ALTER TABLE `tbl_transaksi_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_umkm`
--
ALTER TABLE `tbl_umkm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_berita_kategori`
--
ALTER TABLE `tbl_berita_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategori_produk`
--
ALTER TABLE `tbl_kategori_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategori_umkm`
--
ALTER TABLE `tbl_kategori_umkm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_kerjasama`
--
ALTER TABLE `tbl_kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_kerjasama_produk`
--
ALTER TABLE `tbl_kerjasama_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_kerjasama_transaksi`
--
ALTER TABLE `tbl_kerjasama_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu_title`
--
ALTER TABLE `tbl_menu_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tbl_produk_umkm`
--
ALTER TABLE `tbl_produk_umkm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_transaksi_detail`
--
ALTER TABLE `tbl_transaksi_detail`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_transaksi_pembayaran`
--
ALTER TABLE `tbl_transaksi_pembayaran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_umkm`
--
ALTER TABLE `tbl_umkm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  ADD CONSTRAINT `id_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_berita_kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_berita_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_berita_kategori` (`id`);

--
-- Ketidakleluasaan untuk tabel `tbl_kategori_produk`
--
ALTER TABLE `tbl_kategori_produk`
  ADD CONSTRAINT `tbl_kategori_produk_ibfk_1` FOREIGN KEY (`id_umkm`) REFERENCES `tbl_umkm` (`id`);

--
-- Ketidakleluasaan untuk tabel `tbl_kerjasama`
--
ALTER TABLE `tbl_kerjasama`
  ADD CONSTRAINT `tbl_kerjasama_ibfk_1` FOREIGN KEY (`id_umkm`) REFERENCES `tbl_umkm` (`id`),
  ADD CONSTRAINT `tbl_kerjasama_ibfk_2` FOREIGN KEY (`id_reseller`) REFERENCES `tbl_pengguna` (`id`);

--
-- Ketidakleluasaan untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD CONSTRAINT `tbl_menu_ibfk_1` FOREIGN KEY (`id_menu_title`) REFERENCES `tbl_menu_title` (`id`);

--
-- Ketidakleluasaan untuk tabel `tbl_umkm`
--
ALTER TABLE `tbl_umkm`
  ADD CONSTRAINT `tbl_umkm_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
