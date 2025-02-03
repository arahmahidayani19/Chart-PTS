-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 03, 2025 at 03:15 AM
-- Server version: 5.7.39
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `machine_downtime`
--

-- --------------------------------------------------------

--
-- Table structure for table `machine_status`
--

CREATE TABLE `machine_status` (
  `id` int(11) NOT NULL,
  `machine_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_status`
--

INSERT INTO `machine_status` (`id`, `machine_code`, `reason_code`, `start_time`, `end_time`, `created_at`) VALUES
(1, 'M01', 'NPO', '2025-01-11 02:00:00', '2025-01-11 11:00:00', '2025-02-02 14:04:15'),
(2, 'M03', 'NPO', '2025-01-12 08:00:00', '2025-01-12 15:00:00', '2025-02-02 14:04:15'),
(3, 'M04', 'NPO', '2025-01-11 02:00:00', '2025-01-11 23:00:00', '2025-02-02 14:04:15'),
(4, 'M05', 'NPO', '2025-01-10 10:00:00', '2025-01-10 18:00:00', '2025-02-03 02:14:24'),
(5, 'M06', 'NPO', '2025-01-12 05:00:00', '2025-01-12 12:30:00', '2025-02-03 02:14:24'),
(6, 'M07', 'NPO', '2025-01-15 08:00:00', '2025-01-16 14:00:00', '2025-02-03 02:14:24'),
(7, 'M08', 'NPO', '2025-01-14 06:30:00', '2025-01-14 13:45:00', '2025-02-03 02:14:24'),
(8, 'M09', 'NPO', '2025-01-13 03:00:00', '2025-01-13 09:00:00', '2025-02-03 02:14:24'),
(9, 'M10', 'NPO', '2025-01-17 01:00:00', '2025-01-18 20:00:00', '2025-02-03 02:14:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `machine_status`
--
ALTER TABLE `machine_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `machine_status`
--
ALTER TABLE `machine_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
