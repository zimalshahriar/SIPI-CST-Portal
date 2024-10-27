-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 05:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipi_cst_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `semester` enum('1st','2nd','3rd','4th','5th','6th','7th','8th','All Semester') NOT NULL DEFAULT 'All Semester'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `content`, `created_at`, `semester`) VALUES
(28, '3rd', 'for 3rd', '2024-10-27 11:41:11', '8th'),
(29, 'all', 'all semester', '2024-10-27 16:05:20', 'All Semester');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `session` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `session`) VALUES
(1, '2021-22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `user_type` enum('student','teacher','admin') NOT NULL,
  `session` varchar(20) DEFAULT NULL,
  `semester` enum('1st','2nd','3rd','4th','5th','6th','7th','8th') DEFAULT NULL,
  `role` enum('CI','Instructor','Junior Instructor') DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `password`, `user_type`, `session`, `semester`, `role`, `photo`, `created_at`) VALUES
(2, 'admin-1', 'Shahriar Zim', 'admin@example.com', '$2y$10$qscfVuILdDJ9GCeSKzXiy.IlsKUZzySerPHlKUrXK1ReI42W9Cf6u', 'admin', NULL, NULL, NULL, NULL, '2024-10-25 06:46:26'),
(3, 'CST-demo', 'Demo', 'demo@gmail.com', '$2y$10$5fDETN0RoTbWNa5R97Z1VeCprOIQIy66WY5GGXovXtOqzfbO5Z3Hy', 'student', '2021-22', '3rd', NULL, '', '2024-10-25 08:38:53'),
(7, 'JI-demo', 'Demo Teacher', 'demoteacher@email.com', '$2y$10$KvoISmjefm6XL7QFmZ4xcuOV0325APfl5qDhcwAjugy1sW/qR3y2S', 'teacher', NULL, NULL, 'Instructor', 'pngtree-teachers-day-characters-png-image_9143439.png', '2024-10-25 09:13:25'),
(8, 'sourov', 'Sourov Kumar', 'sourovkuamr@gmail.com', '$2y$10$61fcDzCuenqPOfWcK/023e7Qs0GuWJEi4ns.F4xUg.ODVt2xE3ezK', 'admin', NULL, NULL, NULL, 'logo.jpg', '2024-10-25 19:49:13'),
(9, 'teacher-1', 'Sourov Sarker', 'sourovsarker-21ia@dipti.com.bd', '$2y$10$luGze56bhGnYoV3r6fCuFuFuwv266POsBsbAQm.If.B7b0wghqqcW', 'teacher', NULL, NULL, 'CI', '', '2024-10-27 05:17:33'),
(10, 'student-1', 'Sourov Sarker', 'sourovsarker-21ia@dipti.com.bd', '$2y$10$KulKopoP5l60K392GELmZu45wZnXTXLMsYkL/JArGCkMkd31UpkAC', 'student', '2021-22', '8th', NULL, '', '2024-10-27 06:28:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session` (`session`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
