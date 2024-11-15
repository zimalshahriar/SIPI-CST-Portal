-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 04:54 PM
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
-- Database: `sipi_cst_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `semester` enum('All Semester','1st','2nd','3rd','4th','5th','6th','7th','8th') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `file_path`, `semester`, `created_at`) VALUES
(10, 'test-02', '214444cshddiakdoiuj', NULL, '8th', '2024-11-14 09:37:17'),
(11, 'Test', NULL, '../../../uploads/67376db409d40-sodapdf-converted.pdf', 'All Semester', '2024-11-15 15:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `date`, `subject_id`, `student_id`, `status`) VALUES
(1, '2024-11-07', 1, 11, 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `day` enum('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `semester` enum('1st','2nd','3rd','4th','5th','6th','7th','8th') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `subject_id`, `day`, `start_time`, `end_time`, `teacher_name`, `semester`) VALUES
(3, 1, 'Monday', '06:10:00', '07:10:00', 'Sourov Sarker', '7th');

-- --------------------------------------------------------

--
-- Table structure for table `grade_reports`
--

CREATE TABLE `grade_reports` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `attendance` decimal(5,2) DEFAULT NULL,
  `mid_exam` decimal(5,2) DEFAULT NULL,
  `class_test` decimal(5,2) DEFAULT NULL,
  `quiz_test` decimal(5,2) DEFAULT NULL,
  `performance_assessment` decimal(5,2) DEFAULT NULL,
  `assignment_homework` decimal(5,2) DEFAULT NULL,
  `total_tc` decimal(5,2) DEFAULT NULL,
  `experiment` decimal(5,2) DEFAULT NULL,
  `homework` decimal(5,2) DEFAULT NULL,
  `error` decimal(5,2) DEFAULT NULL,
  `evaluation` decimal(5,2) DEFAULT NULL,
  `discussion_solution` decimal(5,2) DEFAULT NULL,
  `additional_hours` decimal(5,2) DEFAULT NULL,
  `total_pc` decimal(5,2) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_reports`
--

INSERT INTO `grade_reports` (`id`, `student_id`, `subject_id`, `semester`, `attendance`, `mid_exam`, `class_test`, `quiz_test`, `performance_assessment`, `assignment_homework`, `total_tc`, `experiment`, `homework`, `error`, `evaluation`, `discussion_solution`, `additional_hours`, `total_pc`, `remarks`) VALUES
(5, 11, 1, '7th', 55.00, 15.00, 5.00, 4.00, 3.00, 5.00, 32.00, 4.00, 3.00, 4.00, 4.00, 5.00, 4.00, 24.00, 'Good'),
(6, 15, 1, '7th', 85.00, 18.00, 5.00, 4.00, 4.00, 5.00, 36.00, 4.00, 5.00, 5.00, 5.00, 5.00, 5.00, 29.00, 'GOOD');

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
(2, '2020-21'),
(1, '2021-22');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_code` varchar(10) NOT NULL,
  `semester` enum('1st','2nd','3rd','4th','5th','6th','7th','8th') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_code`, `semester`) VALUES
(1, 'Cyber Security & Ethics', '66675', '7th');

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
(10, 'student-1', 'Sourov Sarker', 'sourovsarker-21ia@dipti.com.bd', '$2y$10$KulKopoP5l60K392GELmZu45wZnXTXLMsYkL/JArGCkMkd31UpkAC', 'student', '2021-22', '8th', NULL, '', '2024-10-27 06:28:37'),
(11, 'nauijdi', 'daw', 'ajhnd@djkd.cc', '$2y$10$bJ1NewAVxrZ/w68DJc1uBuRtRl2Og5J16sbnNNWBehheWuQ.jmRMa', 'student', '2021-22', '7th', NULL, '', '2024-10-28 05:30:41'),
(12, '281/20 CMT-67', 'Shahriar Zim', 'sz.zim2050@gmail.com', '$2y$10$YkFcruvhV8jGkVZV3rQB9O/ITAj2DWcYAcRsETf9Jw57Gu1bV2HwO', 'student', '2020-21', '8th', NULL, '', '2024-11-14 05:33:36'),
(14, '000/00 CST-Demo', 'Demo', 'demo123@email.com', '$2y$10$w0MmYIzfR9A.LNgAvKXyouDPbPjSovxjSc23Fv2p.8kmi0rv8PJru', 'student', '2021-22', '5th', NULL, '', '2024-11-14 09:35:34'),
(15, 'STD-Demo', 'Std Demo', 'stddemo123@email.com', '$2y$10$xhNVzjfCx7pcl1DkdCV66.7e9d.d80Jd7QgroTiqyJCdsDbPxy54S', 'student', '2020-21', '7th', NULL, '', '2024-11-14 09:55:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `grade_reports`
--
ALTER TABLE `grade_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session` (`session`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grade_reports`
--
ALTER TABLE `grade_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD CONSTRAINT `class_schedule_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `grade_reports`
--
ALTER TABLE `grade_reports`
  ADD CONSTRAINT `grade_reports_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `grade_reports_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
