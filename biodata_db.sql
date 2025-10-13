-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Okt 2025 pada 12.29
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
-- Database: `biodata_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Teknik Informatika', '2025-10-13 08:55:26', '2025-10-13 09:57:22', NULL),
(2, 'Sistem Informasi', '2025-10-13 08:55:26', NULL, NULL),
(3, 'Manajemen', '2025-10-13 08:55:26', NULL, NULL),
(4, 'Akuntansi', '2025-10-13 08:55:26', NULL, NULL),
(5, 'Desain Komunikasi Visual', '2025-10-13 09:57:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `umur` int(11) NOT NULL,
  `jurusan_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `umur`, `jurusan_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, NULL, 'chyaa', 21, 1, '2025-10-13 08:55:08', '2025-10-13 09:23:43', '2025-10-13 09:48:14'),
(13, NULL, 'joraaa', 25, NULL, '2025-10-13 08:55:08', NULL, '2025-10-13 09:10:05'),
(14, NULL, 'bemon', 23, 2, '2025-10-13 09:09:57', '2025-10-13 09:23:52', '2025-10-13 09:23:55'),
(15, NULL, 'joraaa', 25, 3, '2025-10-13 09:24:07', NULL, '2025-10-13 09:48:17'),
(16, NULL, 'bemon', 28, 4, '2025-10-13 09:24:20', NULL, '2025-10-13 09:48:22'),
(17, '2311060125', 'Sahira Khairun Najah', 21, 1, '2025-10-13 09:54:56', '2025-10-13 10:05:59', NULL),
(18, NULL, 'Reina Fauzia Hidayat', 21, 4, '2025-10-13 09:55:25', NULL, '2025-10-13 10:06:11'),
(19, '2311060068', 'Kania Junia Risa', 21, 1, '2025-10-13 10:06:51', NULL, NULL),
(20, '2311060079', 'Siti Hapsoh', 21, 1, '2025-10-13 10:07:16', NULL, NULL),
(21, '2311060080', 'Siti Sarah Maulani', 22, 1, '2025-10-13 10:07:59', NULL, NULL),
(22, '2311060081', 'Sri Mutmainah', 22, 1, '2025-10-13 10:08:38', NULL, NULL),
(23, '2311060065', 'Inkana Arwa', 23, 1, '2025-10-13 10:09:05', NULL, NULL),
(24, '2311060062', 'Faiza Fitra Hanifa', 21, 1, '2025-10-13 10:09:39', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jurusan` (`jurusan_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `fk_jurusan` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
