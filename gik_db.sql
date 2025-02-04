-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2025 at 10:46 AM
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
(10, 'sumaira', 'sumairanoori624@gmail.com', '$2y$10$D/Tuw4erYUZCXFx/5y7fiOPXpxgNEOelNXrFZmO3NKPPSnVXslori'),
(20, 'Christopher Swanson', 'pobyhojoz@mailinator.com', '$2y$10$1dRnLuD6swa/h4Ad6K5ibeJ7RSOdRLq.j4N/twxlvfe/4dmhDhAKy'),
(21, 'maziti', 'cenuzi@mailinator.com', '$2y$10$4R.WEue6NAhWPRp8JoWnOOOfyAcX7qCAP8r2DTKb/id0LeodJHmAa');

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
(6, 'uploads/67a09ec73d5145.25036801.png', 'Amela Gonzales', 'wemunutu@mailinator.com', 'Delectus reprehende', 'Qui nostrud eu culpa', '+1 (619) 373-8321', 'married', 'canceled', NULL, '2025-02-03 10:47:35', 'Bevis Price', 0, 'Quia eos qui maxime ', 'other', 'Duis optio enim con', '\"Inventore consequat\"'),
(7, 'uploads/67a09ed81c5915.91552066.png', 'Abraham Rosales', 'kerojibijo@mailinator.com', 'Qui mollitia ut volu', 'Deleniti in inventor', '+1 (908) 234-6997', 'married', 'canceled', NULL, '2025-02-03 10:47:52', 'Joseph Miles', 0, 'Corrupti harum nemo', 'female', 'Est sed sint aut dol', '\"Qui maxime aliqua A\"'),
(8, 'uploads/67a0a345ef5924.95446514.png', 'Harding Short', 'kuvefupahi@mailinator.com', 'Non libero vel aliqu', 'Voluptas quo perspic', '+1 (149) 192-7751', 'married', 'canceled', NULL, '2025-02-03 11:06:45', 'Leo Burt', 0, 'Earum vel nesciunt ', 'male', 'Dolorem sit elit ex', '\"In veniam maxime qu\"'),
(9, 'uploads/67a0a3559654c0.57120053.png', 'Ryder Fuentes', 'dowiho@mailinator.com', 'Ea quasi voluptas do', 'Qui in consequatur ', '+1 (404) 314-7211', 'unmarried', 'canceled', NULL, '2025-02-03 11:07:01', 'Cameran Madden', 0, 'Quis ut quia dolores', 'other', 'Eaque dolor elit ne', '\"Accusamus consequatu\"'),
(10, 'uploads/67a0a368077123.23041488.png', 'Denise Ramirez', 'poqicy@mailinator.com', 'Obcaecati consequatu', 'Aliquam consectetur ', '+1 (449) 237-2112', 'unmarried', 'canceled', NULL, '2025-02-03 11:07:20', 'Hyacinth Middleton', 0, 'Doloribus voluptate ', 'female', 'Quisquam reiciendis ', '\"Modi nostrum reprehe\"');

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
(10, 'sumaira', 'sumairanoori624@gmail.com', '$2y$10$D/Tuw4erYUZCXFx/5y7fiOPXpxgNEOelNXrFZmO3NKPPSnVXslori', 1, '2025-02-03 10:42:20'),
(11, 'memona', 'memona@gmail.com', '$2y$10$OD7V.NN8apklS2OIQCQSYOaJi6qLHQ9fBSCbgG3OEI.8g9fAiDsc6', 3, '2025-02-03 10:43:16'),
(15, 'Eaton Finley', 'pewimuku@mailinator.com', '$2y$10$gIGV40WfvkTyqs5covhpxuQszLUY31/a2QOK4Gy80qFNN52VID4zi', 3, '2025-02-03 10:57:04'),
(19, 'fati', 'wytekim@mailinator.com', '$2y$10$rHGildThClQgiTszE/lm.OW301HbT99YU293Nbt437UnGhHQJbS1S', 3, '2025-02-03 11:34:29'),
(20, 'Christopher Swanson', 'pobyhojoz@mailinator.com', '$2y$10$1dRnLuD6swa/h4Ad6K5ibeJ7RSOdRLq.j4N/twxlvfe/4dmhDhAKy', 1, '2025-02-03 11:35:19'),
(21, 'maziti', 'cenuzi@mailinator.com', '$2y$10$4R.WEue6NAhWPRp8JoWnOOOfyAcX7qCAP8r2DTKb/id0LeodJHmAa', 1, '2025-02-03 11:35:54');

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
(11, 'Kyla Holmes', 'Amet vero et adipis', '../frontend/uploads/67a1d990cf1c62.64321036.jpg', '2025-02-04 09:10:40'),
(13, 'Jerome Pittman', 'Qui ipsum est quia ', '../frontend/uploads/67a1d9a977fe88.50842575.jpg', '2025-02-04 09:11:05'),
(14, 'Cassidy Oneal', 'Sed dolor asperiores', '../frontend/uploads/67a1d9b8a782f6.08237821.png', '2025-02-04 09:11:20'),
(15, 'Illiana Noel', 'Qui ipsum est repreh', '../frontend/uploads/67a1d9c891d849.42706016.jpg', '2025-02-04 09:11:36');

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
(6, 'Amela Gonzales', 'wemunutu@mailinator.com', ''),
(7, 'Abraham Rosales', 'kerojibijo@mailinator.com', ''),
(8, 'Harding Short', 'kuvefupahi@mailinator.com', ''),
(9, 'Ryder Fuentes', 'dowiho@mailinator.com', ''),
(10, 'Denise Ramirez', 'poqicy@mailinator.com', ''),
(11, 'memona', 'memona@gmail.com', '$2y$10$OD7V.NN8apklS2OIQCQSYOaJi6qLHQ9fBSCbgG3OEI.8g9fAiDsc6'),
(15, 'Eaton Finley', 'pewimuku@mailinator.com', '$2y$10$gIGV40WfvkTyqs5covhpxuQszLUY31/a2QOK4Gy80qFNN52VID4zi'),
(19, 'fati', 'wytekim@mailinator.com', '$2y$10$rHGildThClQgiTszE/lm.OW301HbT99YU293Nbt437UnGhHQJbS1S');

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

-- --------------------------------------------------------

--
-- Table structure for table `teacher_student`
--

CREATE TABLE `teacher_student` (
  `id` int(11) NOT NULL,
  `tid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `teacher_student`
--
ALTER TABLE `teacher_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tid` (`tid`) USING BTREE,
  ADD KEY `sid` (`sid`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `a_users`
--
ALTER TABLE `a_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `corses`
--
ALTER TABLE `corses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `teacher_student`
--
ALTER TABLE `teacher_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_teacher_course` FOREIGN KEY (`course_id`) REFERENCES `corses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `a_users` (`id`);

--
-- Constraints for table `teacher_student`
--
ALTER TABLE `teacher_student`
  ADD CONSTRAINT `teacher_student_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `teacher` (`tid`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_student_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
