-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 27, 2026 at 12:00 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_walikelas` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','sakit','izin','alfa') NOT NULL,
  `keterangan` text,
  `keterangan_waktu` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_siswa`, `id_walikelas`, `tanggal`, `status`, `keterangan`, `keterangan_waktu`, `created_at`) VALUES
(1, 5, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(2, 17, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(3, 18, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(4, 19, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(5, 20, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(6, 21, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(7, 22, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(8, 23, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(9, 24, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(10, 25, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(11, 26, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(12, 27, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(13, 28, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(14, 29, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(15, 30, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(16, 31, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(17, 32, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(18, 34, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(19, 33, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(20, 35, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(21, 36, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(22, 37, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(23, 38, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(24, 39, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(25, 40, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:22'),
(26, 5, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(27, 17, 2, '2026-02-24', 'sakit', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(28, 18, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(29, 19, 2, '2026-02-24', 'izin', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(30, 20, 2, '2026-02-24', 'sakit', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(31, 21, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(32, 22, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(33, 23, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(34, 24, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(35, 25, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(36, 26, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(37, 27, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(38, 28, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(39, 29, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(40, 30, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(41, 31, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(42, 32, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(43, 34, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(44, 33, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(45, 35, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(46, 36, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(47, 37, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(48, 38, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(49, 39, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(50, 40, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:14:41'),
(51, 5, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(52, 17, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(53, 18, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(54, 19, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(55, 20, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(56, 21, 2, '2026-02-24', 'izin', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(57, 22, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(58, 23, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(59, 24, 2, '2026-02-24', 'sakit', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(60, 25, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(61, 26, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(62, 27, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(63, 28, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(64, 29, 2, '2026-02-24', 'sakit', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(65, 30, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(66, 31, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(67, 32, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(68, 34, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(69, 33, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(70, 35, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(71, 36, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(72, 37, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(73, 38, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(74, 39, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(75, 40, 2, '2026-02-24', 'hadir', NULL, 'Selasa, 24 February 2026', '2026-02-24 03:19:41'),
(76, 5, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(79, 19, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(80, 20, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(81, 21, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(82, 22, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(83, 23, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(84, 24, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(85, 25, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(86, 26, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(87, 27, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(89, 29, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(90, 30, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(91, 31, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(92, 32, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(93, 34, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(94, 33, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(95, 35, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(96, 36, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(97, 37, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(98, 38, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(99, 39, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(100, 40, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 00:59:05'),
(101, 5, 2, '2026-02-25', 'sakit', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(104, 19, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(105, 20, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(106, 21, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(107, 22, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(108, 23, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(109, 24, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(110, 25, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(111, 26, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(112, 27, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(114, 29, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(115, 30, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(116, 31, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(117, 32, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(118, 34, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(119, 33, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(120, 35, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(121, 36, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(122, 37, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(123, 38, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(124, 39, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(125, 40, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:04:15'),
(126, 41, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:56'),
(129, 19, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(130, 20, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(131, 21, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(132, 22, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(133, 23, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(134, 24, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(135, 25, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(136, 26, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(137, 27, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(139, 29, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(140, 30, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(141, 31, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(142, 32, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(143, 34, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(144, 33, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(145, 35, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(146, 36, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(147, 37, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(148, 38, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(149, 39, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(150, 40, 2, '2026-02-25', 'hadir', NULL, 'Rabu, 25 February 2026', '2026-02-25 01:52:57'),
(151, 28, 1, '2026-02-25', 'sakit', 'Demam', NULL, '2026-02-25 03:28:06'),
(156, 17, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(158, 19, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(159, 20, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(160, 21, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(161, 22, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(162, 23, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(163, 24, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(165, 26, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(166, 27, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(167, 28, 2, '2026-02-26', 'sakit', 'demam tinggi', 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(168, 29, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(169, 30, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(170, 31, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(171, 32, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(172, 34, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(173, 33, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(174, 35, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(175, 36, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(176, 37, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(177, 38, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(178, 39, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(179, 40, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 01:05:27'),
(180, 43, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(181, 17, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(182, 18, 2, '2026-02-26', 'izin', 'Pulang', 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(183, 19, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(184, 20, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(185, 21, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(186, 22, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(187, 23, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(188, 24, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(189, 25, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(190, 26, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(191, 27, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(193, 29, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(194, 30, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(195, 31, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(196, 32, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(197, 34, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(198, 33, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(199, 35, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(200, 36, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(201, 37, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(202, 38, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(203, 39, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(204, 40, 2, '2026-02-26', 'hadir', NULL, 'Kamis, 26 February 2026', '2026-02-26 02:22:25'),
(205, 45, 2, '2026-02-27', 'sakit', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(206, 17, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(207, 18, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(208, 19, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(209, 20, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(210, 21, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(211, 22, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(212, 23, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(213, 24, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(214, 25, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(215, 26, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(216, 27, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(217, 28, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(218, 29, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(219, 30, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(220, 31, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(221, 32, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(222, 34, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(223, 33, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(224, 35, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(225, 36, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(226, 37, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(227, 38, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(228, 39, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36'),
(229, 40, 2, '2026-02-27', 'hadir', NULL, 'Jumat, 27 February 2026', '2026-02-26 23:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `id_walikelas` int DEFAULT NULL,
  `jurusan` varchar(20) DEFAULT NULL,
  `nomor_kelas` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `nama`, `kelas`, `id_walikelas`, `jurusan`, `nomor_kelas`) VALUES
(17, 'Ahmad Umar Al-jailani', '12', 2, 'PPLG', '2'),
(18, 'Arham Simansyah Lamabelawa', '12', 2, 'PPLG', '2'),
(19, 'Dwi Wahyuningsih', '12', 2, 'PPLG', '2'),
(20, 'Fahri S.A Mandar', '12', 2, 'PPLG', '2'),
(21, 'Fahzia Aziatun', '12', 2, 'PPLG', '2'),
(22, 'Fakhri Mumtaz Basyari', '12', 2, 'PPLG', '2'),
(23, 'Fathul Hidayat', '12', 2, 'PPLG', '2'),
(24, 'Fauzil Mutaqqim', '12', 2, 'PPLG', '2'),
(25, 'Fitriah', '12', 2, 'PPLG', '2'),
(26, 'Fitriani Juleha Abas', '12', 2, 'PPLG', '2'),
(27, 'Lailatul Ilma Al-Marifah', '12', 2, 'PPLG', '2'),
(28, 'Latifah Nurul Az-zahra', '12', 2, 'PPLG', '2'),
(29, 'Mahathir Mohammad', '12', 2, 'PPLG', '2'),
(30, 'Muhammad Alfian Kurniawan', '12', 2, 'PPLG', '2'),
(31, 'Nasywa Aulia Pratiwi', '12', 2, 'PPLG', '2'),
(32, 'Nia Vanidah', '12', 2, 'PPLG', '2'),
(33, 'Nuraima Ambutu', '12', 2, 'PPLG', '2'),
(34, 'Nur Fadillah', '12', 2, 'PPLG', '2'),
(35, 'Rizki Fredian Lobang pali', '12', 2, 'PPLG', '2'),
(36, 'Sulistia Wati Arif', '12', 2, 'PPLG', '2'),
(37, 'Syawal Saputra', '12', 2, 'PPLG', '2'),
(38, 'Ya Ayu Kurnia Patra', '12', 2, 'PPLG', '2'),
(39, 'Zachrani Wardatain Syaiful', '12', 2, 'PPLG', '2'),
(40, 'Zulfiadi Ngolo Soro', '12', 2, 'PPLG', '2'),
(45, 'Ade jainab', '12', 2, 'PPLG', '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pembina','walikelas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'pembina', '377a610343a9812be993e0e755b2e00f', 'pembina'),
(2, 'ilham ibrahim', 'dcf52f84dbf511ee4a0abcfc18093ee4', 'walikelas'),
(3, 'Abdul azis', 'dcf52f84dbf511ee4a0abcfc18093ee4', 'walikelas'),
(4, 'Nur laila', 'dcf52f84dbf511ee4a0abcfc18093ee4', 'walikelas'),
(5, 'Kurniawati', 'dcf52f84dbf511ee4a0abcfc18093ee4', 'walikelas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_walikelas` (`id_walikelas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `siswas`
--
ALTER TABLE `siswas`
  ADD CONSTRAINT `siswas_ibfk_1` FOREIGN KEY (`id_walikelas`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
