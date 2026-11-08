-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2026 pada 23.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_admin`
--

CREATE TABLE `t_admin` (
  `f_id` int(11) NOT NULL,
  `f_nama` varchar(200) NOT NULL,
  `f_username` varchar(200) NOT NULL,
  `f_password` varchar(200) NOT NULL,
  `f_level` enum('Admin','Pustakawan') NOT NULL,
  `f_status` enum('Aktif','Tidak Aktif') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_admin`
--

INSERT INTO `t_admin` (`f_id`, `f_nama`, `f_username`, `f_password`, `f_level`, `f_status`, `created_at`, `updated_at`) VALUES
(2, 'Faqih', 'admin123', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', 'Aktif', '2026-11-01 16:57:15', '2026-11-08 22:22:43'),
(4, 'Ardi', 'ardi123', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', 'Aktif', '2026-11-01 16:57:15', '2026-11-01 16:57:15'),
(5, 'Lazuardi', 'lazu123', 'e10adc3949ba59abbe56e057f20f883e', 'Pustakawan', 'Aktif', '2026-11-01 17:15:30', '2026-11-01 17:15:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_anggota`
--

CREATE TABLE `t_anggota` (
  `f_id` int(11) NOT NULL,
  `f_nama` varchar(200) NOT NULL,
  `f_username` varchar(200) NOT NULL,
  `f_password` varchar(200) NOT NULL,
  `f_tempatlahir` varchar(100) NOT NULL,
  `f_tangallahir` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_anggota`
--

INSERT INTO `t_anggota` (`f_id`, `f_nama`, `f_username`, `f_password`, `f_tempatlahir`, `f_tangallahir`, `created_at`, `updated_at`) VALUES
(3, 'Rifqi', 'rifqi123', 'e10adc3949ba59abbe56e057f20f883e', 'Jakarta', '2004-02-12', '2026-11-01 16:57:50', '2026-11-01 16:57:50'),
(4, 'Rapi', 'rapi123', 'e10adc3949ba59abbe56e057f20f883e', 'Yogyakarta', '2003-02-14', '2026-11-01 16:57:50', '2026-11-01 16:57:50'),
(5, 'Haikal', 'kal123', '4297f44b13955235245b2497399d7a93', 'Bandung', '2004-03-12', '2026-11-01 16:57:50', '2026-11-01 16:57:50'),
(6, 'Sandika', 'dika123', 'e10adc3949ba59abbe56e057f20f883e', 'Jakarta', '2009-12-31', '2026-11-01 19:25:20', '2026-11-01 19:39:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_buku`
--

CREATE TABLE `t_buku` (
  `f_id` int(11) NOT NULL,
  `f_idkategori` int(11) NOT NULL,
  `f_judul` varchar(200) NOT NULL,
  `f_pengarang` varchar(200) NOT NULL,
  `f_penerbit` varchar(200) NOT NULL,
  `f_deskripsi` varchar(700) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_buku`
--

INSERT INTO `t_buku` (`f_id`, `f_idkategori`, `f_judul`, `f_pengarang`, `f_penerbit`, `f_deskripsi`, `created_at`, `updated_at`) VALUES
(4, 3, 'The Hobbit', 'J.R.R. Tolkien', 'George Allen & Unwin', 'Menceritakan petualangan Bilbo Baggins, seorang hobbit yang ikut dalam perjalanan bersama para kurcaci untuk merebut kembali harta karun yang dijaga naga Smaug.', '2026-11-01 16:58:19', '2026-11-01 18:04:35'),
(5, 3, 'Harry Potter and the Philosopher’s Stone', 'J.K. Rowling', 'Bloomsbury', 'Berkisah tentang Harry Potter, seorang anak yang mengetahui bahwa dirinya adalah penyihir dan mulai belajar di Hogwarts, sekolah sihir yang penuh misteri.', '2026-11-01 17:59:02', '2026-11-01 19:18:41'),
(6, 2, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 'Mengisahkan perjuangan sepuluh anak di Belitung dalam mengejar pendidikan, menghadapi keterbatasan ekonomi, dan mempertahankan impian mereka.', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(7, 2, 'Norwegian Wood', 'Haruki Murakami', 'Kodansha', 'Novel tentang Toru Watanabe yang mengenang masa mudanya, cinta, kehilangan, persahabatan, dan perjalanan emosional menuju kedewasaan.', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(8, 4, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Harper', 'Membahas sejarah perkembangan manusia dari zaman purba hingga era modern, termasuk evolusi, revolusi pertanian, perkembangan budaya, dan kemajuan peradaban.', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(9, 4, 'Atomic Habits', 'James Clear', 'Avery', ': Membahas cara membangun kebiasaan baik dan menghilangkan kebiasaan buruk melalui perubahan kecil yang dilakukan secara konsisten dalam kehidupan sehari-hari.', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(10, 5, 'Steve Jobs', 'Walter Isaacson', 'Simon & Schuster', 'Menceritakan perjalanan hidup Steve Jobs, salah satu pendiri Apple, mulai dari masa mudanya, perjalanan membangun perusahaan teknologi, hingga kontribusinya terhadap perkembangan teknologi dunia.', '2026-11-01 18:12:51', '2026-11-01 18:12:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_detailbuku`
--

CREATE TABLE `t_detailbuku` (
  `f_id` int(11) NOT NULL,
  `f_idbuku` int(11) NOT NULL,
  `f_status` enum('Tersedia','Tidak Tersedia') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_detailbuku`
--

INSERT INTO `t_detailbuku` (`f_id`, `f_idbuku`, `f_status`, `created_at`, `updated_at`) VALUES
(13, 4, 'Tersedia', '2026-11-01 17:00:43', '2026-11-02 02:55:52'),
(14, 4, 'Tersedia', '2026-11-01 17:00:43', '2026-11-01 17:00:43'),
(15, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(16, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(17, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(18, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(19, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(20, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(21, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(22, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(23, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(24, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(25, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(26, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(27, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(28, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(29, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(30, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(31, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(32, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(33, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(34, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(35, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(36, 5, 'Tersedia', '2026-11-01 17:59:02', '2026-11-01 17:59:02'),
(37, 5, 'Tidak Tersedia', '2026-11-01 17:59:02', '2026-11-02 05:36:39'),
(38, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(39, 6, 'Tidak Tersedia', '2026-11-01 18:05:57', '2026-11-01 19:16:53'),
(40, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(41, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(42, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(43, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(44, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(45, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(46, 6, 'Tidak Tersedia', '2026-11-01 18:05:57', '2026-11-01 19:29:19'),
(47, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(48, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(49, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(50, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(51, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(52, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(53, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(54, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(55, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(56, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(57, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(58, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(59, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(60, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(61, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(62, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(63, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(64, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(65, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(66, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(67, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(68, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(69, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(70, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(71, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(72, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(73, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(74, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(75, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(76, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(77, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(78, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(79, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(80, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(81, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(82, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(83, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(84, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(85, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(86, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(87, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(88, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(89, 6, 'Tidak Tersedia', '2026-11-01 18:05:57', '2026-11-01 19:33:06'),
(90, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(91, 6, 'Tersedia', '2026-11-01 18:05:57', '2026-11-01 18:05:57'),
(92, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(93, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(94, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(95, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(96, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(97, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(98, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(99, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(100, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(101, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(102, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(103, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(104, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(105, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(106, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(107, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(108, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(109, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(110, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(111, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(112, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(113, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(114, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(115, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(116, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(117, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(118, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(119, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(120, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(121, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(122, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(123, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(124, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(125, 7, 'Tersedia', '2026-11-01 18:08:17', '2026-11-01 18:08:17'),
(126, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(127, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(128, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(129, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(130, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(131, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(132, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(133, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(134, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(135, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(136, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(137, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(138, 8, 'Tidak Tersedia', '2026-11-01 18:09:32', '2026-11-08 21:57:29'),
(139, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(140, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(141, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(142, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(143, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(144, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(145, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(146, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(147, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(148, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(149, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(150, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(151, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(152, 8, 'Tersedia', '2026-11-01 18:09:32', '2026-11-01 18:09:32'),
(153, 9, 'Tidak Tersedia', '2026-11-01 18:10:32', '2026-11-02 05:32:46'),
(154, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(155, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(156, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(157, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(158, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(159, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(160, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(161, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(162, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(163, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(164, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(165, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(166, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(167, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(168, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(169, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(170, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(171, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(172, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(173, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(174, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(175, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(176, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(177, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(178, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(179, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(180, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(181, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(182, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(183, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(184, 9, 'Tersedia', '2026-11-01 18:10:32', '2026-11-01 18:10:32'),
(185, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(186, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(187, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(188, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(189, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(190, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(191, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(192, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(193, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(194, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(195, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(196, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(197, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(198, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(199, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(200, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(201, 10, 'Tersedia', '2026-11-01 18:12:51', '2026-11-01 18:12:51'),
(202, 4, 'Tersedia', '2026-11-01 18:13:57', '2026-11-01 18:13:57'),
(203, 4, 'Tersedia', '2026-11-01 18:13:58', '2026-11-01 18:13:58'),
(204, 4, 'Tersedia', '2026-11-01 18:13:58', '2026-11-01 18:13:58'),
(205, 4, 'Tersedia', '2026-11-01 18:13:59', '2026-11-01 18:13:59'),
(206, 4, 'Tersedia', '2026-11-02 02:55:36', '2026-11-02 02:55:36'),
(207, 4, 'Tersedia', '2026-11-02 02:55:37', '2026-11-02 02:55:37'),
(208, 4, 'Tersedia', '2026-11-02 02:55:38', '2026-11-02 02:55:38'),
(209, 4, 'Tersedia', '2026-11-02 02:55:38', '2026-11-02 02:55:38'),
(210, 4, 'Tersedia', '2026-11-02 02:55:40', '2026-11-02 02:55:40'),
(211, 4, 'Tersedia', '2026-11-02 02:55:40', '2026-11-02 02:55:40'),
(212, 4, 'Tersedia', '2026-11-02 04:26:26', '2026-11-02 04:26:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_detailpeminjaman`
--

CREATE TABLE `t_detailpeminjaman` (
  `f_id` int(11) NOT NULL,
  `f_idpeminjaman` int(11) NOT NULL,
  `f_iddetailbuku` int(11) NOT NULL,
  `f_tanggalkembali` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_detailpeminjaman`
--

INSERT INTO `t_detailpeminjaman` (`f_id`, `f_idpeminjaman`, `f_iddetailbuku`, `f_tanggalkembali`, `created_at`, `updated_at`) VALUES
(3, 3, 14, '2023-02-22', '2026-11-01 16:59:08', '2026-11-01 16:59:08'),
(4, 4, 13, '2026-11-02', '2026-11-01 16:59:08', '2026-11-02 02:55:52'),
(5, 5, 89, '0000-00-00', '2026-11-01 19:33:06', '2026-11-01 19:33:06'),
(6, 6, 153, '0000-00-00', '2026-11-02 05:32:46', '2026-11-02 05:32:46'),
(7, 7, 37, '0000-00-00', '2026-11-02 05:36:39', '2026-11-02 05:36:39'),
(8, 8, 138, '0000-00-00', '2026-11-08 21:57:29', '2026-11-08 21:57:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kategori`
--

CREATE TABLE `t_kategori` (
  `f_id` int(11) NOT NULL,
  `f_kategori` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kategori`
--

INSERT INTO `t_kategori` (`f_id`, `f_kategori`, `created_at`, `updated_at`) VALUES
(2, 'Fiksi', '2026-11-01 16:59:40', '2026-11-01 17:49:49'),
(3, 'Fantasi', '2026-11-01 16:59:40', '2026-11-01 17:49:59'),
(4, 'Non-Fiksi', '2026-11-01 16:59:40', '2026-11-01 17:50:21'),
(5, 'Biografi', '2026-11-01 16:59:40', '2026-11-01 17:50:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_peminjaman`
--

CREATE TABLE `t_peminjaman` (
  `f_id` int(11) NOT NULL,
  `f_idadmin` int(11) NOT NULL,
  `f_idanggota` int(11) NOT NULL,
  `f_tanggalpeminjaman` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_peminjaman`
--

INSERT INTO `t_peminjaman` (`f_id`, `f_idadmin`, `f_idanggota`, `f_tanggalpeminjaman`, `created_at`, `updated_at`) VALUES
(3, 2, 5, '2026-01-10', '2026-11-01 17:00:11', '2026-11-02 05:22:10'),
(4, 2, 3, '2026-01-11', '2026-11-01 17:00:11', '2026-11-02 05:19:55'),
(5, 4, 5, '2026-11-01', '2026-11-01 19:33:06', '2026-11-01 19:33:06'),
(6, 4, 5, '2026-11-02', '2026-11-02 05:32:46', '2026-11-02 05:32:46'),
(7, 2, 5, '2026-11-01', '2026-11-02 05:36:39', '2026-11-02 05:36:39'),
(8, 5, 4, '2026-11-08', '2026-11-08 21:57:29', '2026-11-08 21:57:29');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`f_id`);

--
-- Indeks untuk tabel `t_anggota`
--
ALTER TABLE `t_anggota`
  ADD PRIMARY KEY (`f_id`);

--
-- Indeks untuk tabel `t_buku`
--
ALTER TABLE `t_buku`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idkategori` (`f_idkategori`);

--
-- Indeks untuk tabel `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idbuku` (`f_idbuku`);

--
-- Indeks untuk tabel `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idpeminjaman` (`f_idpeminjaman`),
  ADD KEY `t_detailpeminjaman_ibfk_1` (`f_iddetailbuku`);

--
-- Indeks untuk tabel `t_kategori`
--
ALTER TABLE `t_kategori`
  ADD PRIMARY KEY (`f_id`);

--
-- Indeks untuk tabel `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idadmin` (`f_idadmin`),
  ADD KEY `f_idanggota` (`f_idanggota`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `t_anggota`
--
ALTER TABLE `t_anggota`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `t_buku`
--
ALTER TABLE `t_buku`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT untuk tabel `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `t_kategori`
--
ALTER TABLE `t_kategori`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_buku`
--
ALTER TABLE `t_buku`
  ADD CONSTRAINT `t_buku_ibfk_1` FOREIGN KEY (`f_idkategori`) REFERENCES `t_kategori` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  ADD CONSTRAINT `t_detailbuku_ibfk_1` FOREIGN KEY (`f_idbuku`) REFERENCES `t_buku` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  ADD CONSTRAINT `t_detailpeminjaman_ibfk_1` FOREIGN KEY (`f_iddetailbuku`) REFERENCES `t_detailbuku` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_detailpeminjaman_ibfk_2` FOREIGN KEY (`f_idpeminjaman`) REFERENCES `t_peminjaman` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  ADD CONSTRAINT `t_peminjaman_ibfk_1` FOREIGN KEY (`f_idadmin`) REFERENCES `t_admin` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_peminjaman_ibfk_2` FOREIGN KEY (`f_idanggota`) REFERENCES `t_anggota` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
