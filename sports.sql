-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 07:35 AM
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
-- Database: `sports`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`) VALUES
(1, 'admin', 'cGFzc3dvcmQ=', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('Present','Absent','Late','Excused') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `member_id`, `attendance_date`, `status`, `created_at`) VALUES
(5, 7, '2025-03-17', 'Present', '2025-03-17 06:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `club_services`
--

CREATE TABLE `club_services` (
  `club_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `goal` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `club_del` varchar(120) NOT NULL DEFAULT 'present'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `club_services`
--

INSERT INTO `club_services` (`club_id`, `name`, `position`, `goal`, `created_at`, `club_del`) VALUES
(11, 'Tursker FC', 'Super cup', 'To be the best club', '2025-03-15 09:18:47', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
  `coach_id` int(11) NOT NULL,
  `coach_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `professionalism` varchar(255) NOT NULL,
  `club_id` int(11) NOT NULL,
  `password` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`coach_id`, `coach_name`, `phone`, `email`, `professionalism`, `club_id`, `password`, `created_at`) VALUES
(5, 'Noel Chumba', '0700916212', 'c@gmail.com', 'Football', 11, '$2y$10$e3K1c8vppHUI5vlJXuacN.EapbTZaLUwfuxU0oE0qr.RZXgFq4O/6', '2025-03-15 09:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `age` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `training_time` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `meStatus` varchar(120) NOT NULL DEFAULT 'Approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `firstname`, `lastname`, `email`, `phone`, `age`, `club_id`, `plan_id`, `training_time`, `password`, `meStatus`, `created_at`) VALUES
(7, 'Brian', 'babu', 'b@gmail.com', '0700916212', 23, 11, 10, 'Morning Session: 8:00am To 12:00pm', '$2y$10$Fz6VMnSbISVHEmfSPCdtu.au8Le2aPDeGbGuCL61OLnOht3x2O3GC', 'Approved', '2025-03-15 09:47:17'),
(8, 'Janelle', 'kavuli', 'j@gmail.com', '0700916212', 20, 11, 10, 'Afternoon Session: 4:00pm To 8:00pm', '$2y$10$rk18b5vc1rAyPuC4eZov/uBrgDAjVLKXWeJRu6151HjdCckKwobXu', 'Approved', '2025-03-16 13:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `planname` varchar(255) NOT NULL,
  `planLength` varchar(120) NOT NULL,
  `fees` decimal(10,2) NOT NULL,
  `planend` varchar(120) NOT NULL,
  `plan_del` varchar(120) NOT NULL DEFAULT 'present'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `planname`, `planLength`, `fees`, `planend`, `plan_del`) VALUES
(10, 'one-year', '5 Years', 2000.00, '2030', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `position`, `email`, `phone`, `password`, `created_at`) VALUES
(10, 'lawrence', 'Clerk', 'l@gmail.com', '0798568790', 'MTIz', '2025-03-15 09:17:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `club_services`
--
ALTER TABLE `club_services`
  ADD PRIMARY KEY (`club_id`);

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`coach_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `club_id` (`club_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `club_services`
--
ALTER TABLE `club_services`
  MODIFY `club_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
  MODIFY `coach_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `club_services` (`club_id`),
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`plan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
