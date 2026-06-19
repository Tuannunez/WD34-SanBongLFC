-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2026 at 07:07 AM
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
-- Database: `wd34_sanbonglfc`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `stadium_id` int NOT NULL,
  `booking_date` datetime NOT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending',
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `stadium_id`, `booking_date`, `status`, `notes`, `created_at`) VALUES
(1, 3, 3, '2026-06-14 12:48:00', 'confirmed', 'fsdfs', '2026-06-19 05:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `stadiums`
--

CREATE TABLE `stadiums` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('5','7','11') DEFAULT '5',
  `price_per_hour` decimal(12,2) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stadiums`
--

INSERT INTO `stadiums` (`id`, `name`, `address`, `description`, `image`, `type`, `price_per_hour`, `status`, `created_at`) VALUES
(1, 'Sân Mini A', 'Thanh Xuân, Hà Nội', 'Sân cỏ nhân tạo chất lượng cao', 'san-a.jpg', '5', 300000.00, 1, '2026-06-16 08:18:52'),
(2, 'Sân Mini B', 'Thanh Xuân, Hà Nội', 'Sân 7 người tiêu chuẩn', 'san-b.jpg', '7', 500000.00, 1, '2026-06-16 08:18:52'),
(3, 'Sân Vận Động Ca1', 'Thanh Xuân, Hà Nội', 'Sân 11 người', 'san-c.jpg', '11', 500000.00, 1, '2026-06-16 08:18:52'),
(6, 'sân Minh khai', 'tây tựu - từ liêm - hà nội', 'yyyyfyy', 'stadiums/1781838742-san-b.jpg', '5', 350000.00, 1, '2026-06-19 03:12:24'),
(7, 'Sân bóng Lai Xá', 'lai Xá - Hoài Đức- HN', 'Cỏ đẹp, mới', 'stadiums/1781842103-and.jpg', '7', 350000.00, 1, '2026-06-19 04:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(1, 'PTT', 'Minh', 'tuanthanh008@gmail.com', '$2y$10$DiOOGC6gbn3T/CUo2ICfvOyyo.hZgT3xkrrA539YDsPR8uEvExlwC', '0998675112', 'Tòa 91 HN', 'customer', '2026-06-15 08:38:34'),
(7, 'Admin', 'admin', 'admin@example.com', '$2y$10$PU34XTs4osE3IDr05EuzI.3N7vJ7s93QGTlOE7Lm.YtdAv3p/nQqi', NULL, NULL, 'admin', '2026-06-16 07:07:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stadiums`
--
ALTER TABLE `stadiums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stadiums`
--
ALTER TABLE `stadiums`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
