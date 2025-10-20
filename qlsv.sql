-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 02:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlsv`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gpa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `gpa`) VALUES
(1, 'FPT', 2.8),
(2, 'VIETTEL', 3),
(3, 'VNPT', 2.5),
(7, 'PwC', 3.6);

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `score_10` float NOT NULL,
  `score_4` float NOT NULL,
  `score_char` char(2) NOT NULL,
  `pass` enum('True','False') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `student_id`, `subject_id`, `score_10`, `score_4`, `score_char`, `pass`) VALUES
(1, 3, 1, 10, 4, 'A+', 'True'),
(17, 3, 2, 10, 4, 'A+', 'True'),
(47, 3, 6, 8, 3, 'A', 'True'),
(49, 74, 1, 9, 4, 'A+', 'True'),
(50, 74, 2, 8, 3.5, 'B+', 'True'),
(51, 3, 7, 10, 4, 'A+', 'True'),
(52, 7, 6, 3.8, 0, 'F', 'False'),
(53, 43, 6, 3, 0, 'F', 'False'),
(56, 78, 1, 3, 0, 'F', 'False'),
(58, 7, 13, 3, 0, 'F', 'False'),
(59, 74, 14, 8.7, 3.8, 'A', 'True'),
(60, 7, 2, 3, 0, 'F', 'False'),
(61, 82, 7, 3, 0, 'F', 'False'),
(62, 83, 7, 9, 4, 'A+', 'True'),
(63, 84, 7, 8, 3.5, 'B+', 'True'),
(64, 7, 14, 8, 3.5, 'B+', 'True'),
(65, 7, 9, 8.6, 3.8, 'A', 'True'),
(66, 3, 13, 7, 3, 'B', 'True'),
(67, 77, 9, 3.8, 0, 'F', 'False'),
(68, 78, 14, 3.9, 0, 'F', 'False'),
(69, 86, 21, 6, 2, 'C', 'True'),
(70, 85, 21, 7, 3, 'B', 'True'),
(71, 81, 21, 8, 3.5, 'B+', 'True'),
(72, 80, 14, 8, 3.5, 'B+', 'True'),
(73, 79, 14, 5, 1.5, 'D+', 'True'),
(74, 7, 21, 3, 0, 'F', 'False');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `credits` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `credits`) VALUES
(1, 'INT111', 'Toán rời rạc 1', 3),
(2, 'INT112', 'IOT', 3),
(6, 'INT113', 'An Toàn Mạng', 3),
(7, 'INT114', 'Toán cao cấp ', 2),
(8, 'INT115', 'Toán rời rạc 2', 3),
(9, 'INT116', 'Lập trình C++', 2),
(10, 'INT117', 'Lập trình Python', 3),
(11, 'INT118', 'Lập trình Java', 3),
(12, 'INT119', 'Phân tích mã độc', 2),
(13, 'INT120', 'Giải tích 1', 2),
(14, 'INT121', 'Giải tích 2', 2),
(21, 'INT122', 'Tư Tưởng Hồ Chí Minh', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('Nam','Nữ') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `usertype`, `fullname`, `dob`, `address`, `gender`, `phone`, `email`, `class`, `major`) VALUES
(1, 'admin', '123456', 'admin', 'Trần Mạnh Tấn', '2003-03-30', 'Hà Nội', 'Nam', '0987654321', 'admin@gmail.com', NULL, NULL),
(3, 'B21DCCN111', '123456', 'student', 'Hà Mai Loan', '2003-03-11', 'Hà Nội', 'Nữ', '0976998003', 'LoanHm@gmail.com', 'D21DCCN03-B', 'CNTT'),
(7, 'B20DCAT100', '123456', 'student', 'Hà Mai Linh', '2002-02-02', 'Hà Nội', 'Nữ', '0976888003', 'LinhHM@gmail.com', 'D20DCCN01-B', 'ATTT'),
(43, 'B20DCAT113', '123456', 'student', 'Hà Mai Thu', '2002-01-02', 'Hà Nam', 'Nữ', '0976888113', 'ThuHM@gmail.com', 'D20DCCN01-B', 'ATTT'),
(74, 'B21DCAT171', '123456', 'student', 'Trần Mạnh Tấn', '2003-11-23', 'Hà Nội', 'Nam', '0987654322', 'TanTM@gmail.com', 'D21DCCN03-B', 'ATTT'),
(77, 'B21DCAT172', '123456', 'student', 'Nguyễn Văn An', '2003-11-12', 'Nghệ An', 'Nam', '0987454322', 'AnNV@gmail.com', 'D21DCAT01-B', 'ATTT'),
(78, 'B21DCCN173', '123456', 'student', 'Trần Thị An', '2003-12-31', 'Nghệ An', 'Nữ', '0985432322', 'AnTT@gmail.com', 'D21DCCN01-B', 'CNTT'),
(79, 'B21DCDT111', '123456', 'student', 'Hà Văn Tú', '2003-03-24', 'Bắc Giang', 'Nam', '0941427412', 'TuHV@gmail.com', 'D21DCDT01-B', 'ĐT'),
(80, 'B21DCDT112', '123456', 'student', 'Hà Văn Hoàng', '2003-04-12', 'Bắc Giang', 'Nam', '0946827412', 'HoangHV@gmail.com', 'D21DCDT01-B', 'ĐT'),
(81, 'B21DCVT112', '123456', 'student', 'Hà Văn Hải', '2003-12-12', 'Bắc Giang', 'Nam', '0946787412', 'HaiHV@gmail.com', 'D21DCVT01-B', 'VT'),
(82, 'B21DCKT112', '123456', 'student', 'Trần Thị Lan', '2003-05-04', 'Bắc Giang', 'Nữ', '0946947412', 'LanTT@gmail.com', 'D21DCKT03-B', 'KT'),
(83, 'B21DCKT008', '123456', 'student', 'Nguyễn Thị Lan', '2003-05-08', 'Bắc Ninh', 'Nữ', '0976888222', 'LanNT@gmail.com', 'D21DCKT03-B', 'KT'),
(84, 'B21DCKT009', '123456', 'student', 'Nguyễn Ngọc Lan', '2003-08-04', 'Hải Phòng', 'Nữ', '0976888332', 'LanNN@gmail.com', 'D21DCKT03-B', 'KT'),
(85, 'B21DCPT009', '123456', 'student', 'Nguyễn Lan Anh', '2003-06-12', 'Hải Phòng', 'Nữ', '0976888442', 'AnhNL@gmail.com', 'D21DCPT03-B', 'ĐPT'),
(86, 'B21DCPT010', '123456', 'student', 'Nguyễn Thị Mai', '2003-08-03', 'Hải Phòng', 'Nữ', '0976888772', 'MaiNT@gmail.com', 'D21DCPT03-B', 'ĐPT'),
(94, 'B21DCCN113', '123456', 'student', 'Hà Văn Linh', '2003-12-03', 'Bắc Giang', 'Nam', '0976888428', 'LinhHV@gmail.com', 'D21DCCN04-B', 'ATTT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student` (`student_id`),
  ADD KEY `subject` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
