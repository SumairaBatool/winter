-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 10:12 AM
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
-- Database: `gik_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `email`, `admin_password`) VALUES
(4, 'xileq', 'hijyqikodu@mailinator.com', '$2y$10$jr0MibEHO7MHVrcpyFcoLeNBoZEIwQVPykoUtJ3rQA4BMliweu15O');

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` int(11) NOT NULL,
  `userimage` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `qulification` varchar(255) DEFAULT NULL,
  `village` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('married','unmarried') NOT NULL,
  `adm_status` varchar(50) DEFAULT 'pending',
  `course_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `fathername` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `district` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `paddress` text NOT NULL,
  `languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`languages`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `userimage`, `username`, `useremail`, `qulification`, `village`, `phone`, `status`, `adm_status`, `course_id`, `created_at`, `fathername`, `age`, `district`, `gender`, `paddress`, `languages`) VALUES
(1, 'uploads/67a0805acd1432.33172865.png', 'Rhoda Jenkins', 'mizy@mailinator.com', 'Placeat nihil in si', 'Sapiente ratione del', '+1 (625) 809-6997', 'married', 'canceled', 2, '2025-02-03 08:37:46', 'Thane Wise', 0, 'Saepe ipsam magnam i', 'other', 'Enim reprehenderit ', '\"Quia vel eius magnam\"'),
(2, 'uploads/67a0806875b0a0.09117929.png', 'Sonya Mayo', 'vapar@mailinator.com', 'Harum voluptatum qui', 'Eligendi iure qui ac', '+1 (711) 427-3305', 'unmarried', 'confirmed', 2, '2025-02-03 08:38:00', 'Yvette Morris', 0, 'Non quas quos non qu', 'other', 'Velit quia sit accus', '\"Sed dolor eos omnis\"'),
(3, 'uploads/67a084c9adf021.31564598.png', 'Norman Chen', 'jywerynet@mailinator.com', 'Qui laboris minus nu', 'Iste non praesentium', '+1 (202) 551-9783', 'unmarried', 'confirmed', 2, '2025-02-03 08:56:41', 'Zachery Lowe', 0, 'Ad dolorem a asperna', 'other', 'Magna expedita eius ', '\"Sit est sint in se\"');

-- --------------------------------------------------------

--
-- Table structure for table `a_users`
--

CREATE TABLE `a_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_users`
--

INSERT INTO `a_users` (`id`, `username`, `useremail`, `userpassword`, `role_id`, `created_at`) VALUES
(1, 'Rae Roy', 'paku@mailinator.com', '$2y$10$.Y120Y0jqUwgkp.OvbO8guXNpAXXKSp4G1bP1kmHdIfyk6p2auFMy', 2, '2025-02-03 08:19:22'),
(2, 'Kirestin Guzman', 'giqedu@mailinator.com', '$2y$10$V50fSueq3epCXWmp786QwennuohwmdLLPkcetW3TudPISXW9ykUAa', 3, '2025-02-03 08:20:38'),
(3, 'Raven Barnett', 'xerage@mailinator.com', '$2y$10$RXc1uUjq3eKYT3nAye..8OgpDlWoJRoKPfQ5KYMYNw3IOq8JBmLm2', 3, '2025-02-03 08:20:47'),
(4, 'xileq', 'hijyqikodu@mailinator.com', '$2y$10$jr0MibEHO7MHVrcpyFcoLeNBoZEIwQVPykoUtJ3rQA4BMliweu15O', 1, '2025-02-03 08:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `corses`
--

CREATE TABLE `corses` (
  `id` int(11) NOT NULL,
  `sub_name` varchar(255) NOT NULL,
  `sub_desc` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `corses`
--

INSERT INTO `corses` (`id`, `sub_name`, `sub_desc`, `image`, `created_at`) VALUES
(1, 'Byron Wallace', 'Consectetur labore q', 'frontend/uploads/courses/67a07a188e9a36.57600691.jpg', '2025-02-03 08:11:04'),
(2, 'Cora Cochran', 'Iste deserunt quia v', 'frontend/uploads/courses/67a07a3004a716.01132285.png', '2025-02-03 08:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Teacher'),
(3, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `sid` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `student_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`sid`, `student_name`, `email`, `student_password`) VALUES
(1, 'Rhoda Jenkins', 'mizy@mailinator.com', ''),
(2, 'Sonya Mayo', 'vapar@mailinator.com', '$2y$10$V50fSueq3epCXWmp786QwennuohwmdLLPkcetW3TudPISXW9ykUAa'),
(3, 'Norman Chen', 'jywerynet@mailinator.com', '$2y$10$RXc1uUjq3eKYT3nAye..8OgpDlWoJRoKPfQ5KYMYNw3IOq8JBmLm2');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `tid` int(11) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `teacher_password` varchar(255) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`tid`, `teacher_name`, `email`, `teacher_password`, `course_id`, `created_at`, `updated_at`) VALUES
(1, 'Simon Hunt', 'nosolixogi@mailinator.com', '', 1, '2025-02-03 08:17:34', '2025-02-03 08:17:34'),
(2, 'Violet Burns', 'qygyti@mailinator.com', '', 1, '2025-02-03 08:18:55', '2025-02-03 08:18:55'),
(3, 'Kristen Livingston', 'kepa@mailinator.com', '', 2, '2025-02-03 08:19:02', '2025-02-03 08:19:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `useremail` (`useremail`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `a_users`
--
ALTER TABLE `a_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `useremail` (`useremail`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `corses`
--
ALTER TABLE `corses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`tid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_teacher_course` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `a_users`
--
ALTER TABLE `a_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `corses`
--
ALTER TABLE `corses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `a_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `a_users` (`id`);

--
-- Constraints for table `admissions`
--
ALTER TABLE `admissions`
  ADD CONSTRAINT `admissions_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `corses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `a_users`
--
ALTER TABLE `a_users`
  ADD CONSTRAINT `a_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `a_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `a_users` (`id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_teacher_course` FOREIGN KEY (`course_id`) REFERENCES `corses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `a_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
