-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2023 at 04:43 PM
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
-- Database: `ams`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` int(50) NOT NULL,
  `batch_name` varchar(255) NOT NULL,
  `dep_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `batch_name`, `dep_id`) VALUES
(3, 'BC 2021', 6),
(4, 'BBS 2020', 8),
(9, 'MBA 2021', 6),
(10, 'BCA 2022', 6);

-- --------------------------------------------------------

--
-- Table structure for table `batch_sem_link`
--

CREATE TABLE `batch_sem_link` (
  `batch_id` int(50) NOT NULL,
  `semester_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dep_id` int(10) NOT NULL,
  `dep_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dep_id`, `dep_name`) VALUES
(6, 'BCA'),
(7, 'CSIT'),
(8, 'BBS');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semester_id` int(50) NOT NULL,
  `semester_name` varchar(255) NOT NULL,
  `dep_id` int(50) NOT NULL,
  `batch_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semester_id`, `semester_name`, `dep_id`, `batch_id`) VALUES
(1, '1st Semester-CSIT', 7, 0),
(2, 'BCA 5TH', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sem_subject_link`
--

CREATE TABLE `sem_subject_link` (
  `semester_id` int(50) NOT NULL,
  `dep_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(50) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `roll_no` int(50) NOT NULL,
  `phone_no` bigint(10) NOT NULL,
  `address` varchar(55) NOT NULL,
  `batch_id` int(50) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_name`, `roll_no`, `phone_no`, `address`, `batch_id`, `email`) VALUES
(1, 'Bishal Rauniyar', 210615, 9843737513, 'Tankeshwor', 3, ''),
(2, 'Rohan Shrestha', 210604, 9878985858, 'Chapagaun', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(50) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `semester_id` int(50) NOT NULL,
  `dep_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `semester_id`, `dep_id`) VALUES
(1, 'Math-I', 1, 6),
(2, 'Accounting', 2, 6),
(4, 'C-Programming', 2, 6),
(5, 'iit', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `subject_sem_link`
--

CREATE TABLE `subject_sem_link` (
  `semester_id` int(50) NOT NULL,
  `subject_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` bigint(10) NOT NULL,
  `role` enum('ADMIN','TEACHER','STUDENT') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `phone_no`, `role`) VALUES
(1, 'bipkorn', '12345', 'bipkorn@gmail.com', 9841984112, 'ADMIN'),
(25, 'admin', 'admin', 'RARA@GMAIL.COM', 0, 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `batch_sem_link`
--
ALTER TABLE `batch_sem_link`
  ADD PRIMARY KEY (`batch_id`),
  ADD KEY `sem_id` (`semester_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`),
  ADD KEY `dep_id` (`dep_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `sem_subject_link`
--
ALTER TABLE `sem_subject_link`
  ADD PRIMARY KEY (`semester_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `roll_no` (`roll_no`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `FK_subject_department` (`dep_id`);

--
-- Indexes for table `subject_sem_link`
--
ALTER TABLE `subject_sem_link`
  ADD PRIMARY KEY (`semester_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batch_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `batch_sem_link`
--
ALTER TABLE `batch_sem_link`
  MODIFY `batch_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dep_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `semester_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subject_sem_link`
--
ALTER TABLE `subject_sem_link`
  MODIFY `semester_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batch`
--
ALTER TABLE `batch`
  ADD CONSTRAINT `batch_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dep_id`);

--
-- Constraints for table `batch_sem_link`
--
ALTER TABLE `batch_sem_link`
  ADD CONSTRAINT `batch_sem_link_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dep_id`);

--
-- Constraints for table `sem_subject_link`
--
ALTER TABLE `sem_subject_link`
  ADD CONSTRAINT `sem_subject_link_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dep_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `FK_subject_department` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dep_id`),
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

--
-- Constraints for table `subject_sem_link`
--
ALTER TABLE `subject_sem_link`
  ADD CONSTRAINT `subject_sem_link_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `semester` (`semester_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
