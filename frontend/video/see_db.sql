-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 07:50 AM
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
-- Database: `see_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fathername` varchar(40) NOT NULL,
  `useremail` varchar(256) NOT NULL,
  `age` int(14) NOT NULL,
  `qulification` varchar(30) NOT NULL,
  `district` varchar(256) NOT NULL,
  `village` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `userimage` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gender` varchar(250) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `paddress` text NOT NULL,
  `languages` text NOT NULL,
  `status` varchar(256) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `adm_status` varchar(256) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `username`, `fathername`, `useremail`, `age`, `qulification`, `district`, `village`, `user_id`, `userimage`, `created_at`, `updated_at`, `gender`, `phone`, `paddress`, `languages`, `status`, `subject`, `adm_status`) VALUES
(9, 'alina zahid', 'muhammad hussain', 'alina@gmail.com', 25, 'BSCS', 'Ganchi', 'Daghoni', 42, 'uploads/667d846ebcec27.89603606.png', '2024-06-27 15:25:34', '2024-06-27 17:10:10', 'female', '06789543223', '', '[\"urdu\",\"english\"]', 'married', 'quran', 'confirmed'),
(10, 'sumaira batool', 'muhammad hussain', 'sumairanoori624@gmail.com', 26, 'BSCS', 'skardu', 'balghar', 44, 'uploads/667da506c7c2c2.98651921.jpeg', '2024-06-27 17:44:38', '2024-07-01 17:59:41', 'female', '06789543223', '', '[\"urdu\",\"english\"]', 'unmarried', 'davat', 'confirmed'),
(12, 'parveen bano', 'muhammad ali', 'parveen@gmail.com', 40, 'BSCS', 'skardu', 'surmo', 45, 'uploads/667dab12682eb4.88627292.jpg', '2024-06-27 18:10:26', '2024-07-05 18:40:29', 'male', '06789543223', '', '[\"english\"]', 'unmarried', 'fiqah', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `c_title` varchar(256) DEFAULT NULL,
  `c_desc` text DEFAULT NULL,
  `c_image` varchar(250) DEFAULT NULL,
  `c_price` varchar(240) DEFAULT 'free',
  `c_staus` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `c_title`, `c_desc`, `c_image`, `c_price`, `c_staus`, `created_at`) VALUES
(7, 'Ahkaam-e-Taharat', 'This is the course offered by Madrassah Shahhamdan.', 'uploads/courses/667bb67d8ee251.69212806.png', 'Free', 0, '2024-06-26 11:31:26'),
(8, 'Usool-e-Etiqadiya', 'This is the course offered by Madrassah Shahhamdan.', 'uploads/courses/667bb6c139e949.81096572.png', 'Free', 0, '2024-06-26 11:35:45'),
(9, 'Holy-Quran', 'This is the course offered by Madrassah Shahhamdan.', 'uploads/courses/667bb6e5406984.30862955.gif', 'Free', 0, '2024-06-26 11:36:21'),
(10, 'ALFiqh-ul-Ahvat', 'This is the course offered by Madrassah Shahhamdan.', 'uploads/courses/667bb70fe822c1.50813434.png', 'Free', 0, '2024-06-26 11:37:03'),
(12, 'masjid', 'nm,mhuyi8mnbygjhgbn', 'uploads/courses/66883e0e652a28.63145913.jpg', 'Free', 0, '2024-07-05 23:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `slider_img` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `des` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fathername` varchar(40) NOT NULL,
  `age` int(14) NOT NULL,
  `qulification` varchar(30) NOT NULL,
  `district` int(30) NOT NULL,
  `village` varchar(30) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `userimage` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gender` varchar(250) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `caste` varchar(250) NOT NULL,
  `paddress` text NOT NULL,
  `languages` text NOT NULL,
  `user_role` tinyint(2) NOT NULL DEFAULT 2,
  `role_name` varchar(256) DEFAULT 'Regular User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fathername`, `age`, `qulification`, `district`, `village`, `useremail`, `userpassword`, `userimage`, `created_at`, `updated_at`, `gender`, `phone`, `caste`, `paddress`, `languages`, `user_role`, `role_name`) VALUES
(44, 'sumaira batool', '', 0, '', 0, '', 'sumairanoori624@gmail.com', '$2y$10$IkVXztoAJB53X8LcTP3nAe61cLOIShOgWdkfS5LdAPe/tk7xVQP4C', '', '2024-06-27 17:43:24', '2024-06-27 17:43:24', '', '', '', '', '', 2, 'Regular User'),
(45, 'parveen bano', '', 0, '', 0, '', 'parveen@gmail.com', '$2y$10$o9E.0ZNzy/NCk7aDUC4wMea80ZT13hI96kTITmghjm8cwIhtZdh0u', '', '2024-06-27 18:08:37', '2024-06-27 18:11:46', '', '', '', '', '', 1, 'System Admistration'),
(46, 'Sumaira Batool', '', 0, '', 0, '', 'sumaira@gmail.com', '$2y$10$3CZN0Pd80esZJ3fRwhPFZOPk1ZXD5WrR5hhoMHXUy9Dg/RNyXZxmq', '', '2024-07-05 17:11:14', '2024-07-05 18:22:50', '', '', '', '', '', 1, 'System Admin'),
(47, 'parveen bano', '', 0, '', 0, '', 'sumi@gmail.com', '$2y$10$ZT42KnbcnQv.e1pvvGixQubDAeQ9JAQvXmHwUs1pD2pVquXQ5KVQu', '', '2024-07-06 18:07:32', '2024-07-06 18:07:32', '', '', '', '', '', 1, 'System Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `useremail` (`useremail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
