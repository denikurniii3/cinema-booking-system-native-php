-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2026 at 05:25 AM
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
-- Database: `db_bioskop`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id_booking` int(11) NOT NULL,
  `id_schedule` int(11) DEFAULT NULL,
  `nama_pemesan` varchar(100) DEFAULT NULL,
  `jumlah_tiket` int(11) DEFAULT NULL,
  `no_kursi` varchar(255) DEFAULT NULL,
  `total_bayar` decimal(10,2) DEFAULT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id_booking`, `id_schedule`, `nama_pemesan`, `jumlah_tiket`, `no_kursi`, `total_bayar`, `tanggal_pesan`) VALUES
(2, 2, 'Manok', 3, 'C5,C4,C6', 1500000.00, '2026-06-26 02:57:50'),
(3, 2, 'Mjakjask', 2, 'D4,D5', 1000000.00, '2026-06-26 03:02:05'),
(4, 3, 'aku dewe mas', 1, 'A1', 798484.00, '2026-06-26 03:02:24'),
(5, 2, 'dewean', 10, 'A1,A2,A3,A4,A5,A8,A7,A6,A9,A10', 5000000.00, '2026-06-26 03:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `cinemas`
--

CREATE TABLE `cinemas` (
  `id_cinema` int(11) NOT NULL,
  `nama_bioskop` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cinemas`
--

INSERT INTO `cinemas` (`id_cinema`, `nama_bioskop`, `alamat`) VALUES
(2, 'NSC KUDUS', 'Kudus MakkkkPak');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id_movie` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id_movie`, `judul`, `genre`, `durasi`, `rating`, `poster`) VALUES
(1, 'Spider-Man: No Way Home', 'Action', 148, 'R13+', 'https://tse1.mm.bing.net/th/id/OIP.ODgCzj-RIXirUelYaGBZKgHaEK?rs=1&pid=ImgDetMain&o=7&rm=3'),
(2, 'Manol', 'Aksian', 103, 'SU', 'https://th.bing.com/th/id/OIP.E8yzZJMxKvHyGMiRGMIn6AHaF7?o=7rm=3&rs=1&pid=ImgDetMain&o=7&rm=3');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id_schedule` int(11) NOT NULL,
  `id_movie` int(11) DEFAULT NULL,
  `id_studio` int(11) DEFAULT NULL,
  `jam_tayang` time DEFAULT NULL,
  `tanggal_tayang` date DEFAULT NULL,
  `harga_tiket` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id_schedule`, `id_movie`, `id_studio`, `jam_tayang`, `tanggal_tayang`, `harga_tiket`) VALUES
(2, 1, 3, '09:00:00', '2026-06-27', 500000.00),
(3, 2, 5, '08:08:00', '2026-06-29', 798484.00);

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `id_studio` int(11) NOT NULL,
  `id_cinema` int(11) DEFAULT NULL,
  `nama_studio` varchar(50) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`id_studio`, `id_cinema`, `nama_studio`, `kapasitas`) VALUES
(2, 2, 'STUDIO I', 100),
(3, 2, 'STUDI II', 50),
(4, 2, 'STUDIO III', 50),
(5, 2, 'STUDIO IV', 60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_schedule` (`id_schedule`);

--
-- Indexes for table `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`id_cinema`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id_movie`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id_schedule`),
  ADD KEY `id_movie` (`id_movie`),
  ADD KEY `id_studio` (`id_studio`);

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`id_studio`),
  ADD KEY `id_cinema` (`id_cinema`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `id_cinema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id_movie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id_schedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `studios`
--
ALTER TABLE `studios`
  MODIFY `id_studio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`id_schedule`) REFERENCES `schedules` (`id_schedule`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `movies` (`id_movie`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`id_studio`) REFERENCES `studios` (`id_studio`) ON DELETE CASCADE;

--
-- Constraints for table `studios`
--
ALTER TABLE `studios`
  ADD CONSTRAINT `studios_ibfk_1` FOREIGN KEY (`id_cinema`) REFERENCES `cinemas` (`id_cinema`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
