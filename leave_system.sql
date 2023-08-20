-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2023 at 11:11 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leave_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` char(20) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `phone` bigint(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `DOJ` date NOT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `first_name`, `last_name`, `email`, `gender`, `password`, `phone`, `address`, `DOJ`, `role`) VALUES
('EMP01', 'Sanjib', 'Halder', 'sanjib.halder@thebges.edu.in', 'male', 'empsanjib', 9876461987, 'Kolkata', '2022-06-21', 3),
('EMP02', 'Akash ', 'Mehta', 'akashmehta@thebges.edu.in', 'male', 'empakash', 9831234500, 'Ballygunge', '2022-09-02', 3),
('EMP04', 'Priyanka', 'Banerjee', 'priyankabanerjee@thebges.edu.in', 'female', 'emppri', 9012679832, 'Sonarpur', '2023-10-14', 3),
('EMP06', 'Anamika', 'Guha', 'anamikaguha@yahoo.com', 'female', 'empana', 8909876513, 'Kolkata', '2023-07-12', 3),
('HR01', 'Pinki', 'Saha Sardar', 'pinkisahasardar@thebges.edu.in', 'female', 'hrpss', 8978654310, '98,M.G.Road', '2016-07-21', 2),
('PR001', 'Subhabrata', 'Ganguly', 'subhabrataganguly@thebges.edu.in', 'male', 'prtic', 7087563410, '22,A.P.C.Road', '2010-02-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE `leave` (
  `lv_id` int(11) NOT NULL,
  `emp_id` char(20) DEFAULT NULL,
  `leave_type` varchar(20) DEFAULT NULL,
  `credits` float DEFAULT NULL,
  `leaves_taken` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`lv_id`, `emp_id`, `leave_type`, `credits`, `leaves_taken`) VALUES
(1, 'EMP01', 'Casual Leave', 12, 0),
(2, 'EMP01', 'Medical Leave', 12, 3),
(3, 'EMP01', 'Earned Leave', 12, 0),
(7, 'EMP04', 'Casual Leave', 8, 0),
(8, 'EMP04', 'Medical Leave', 8, 1),
(9, 'EMP04', 'Earned Leave', 8, 0),
(10, 'EMP02', 'Casual Leave', 9, 0),
(11, 'EMP02', 'Medical Leave', 9, 0),
(12, 'EMP02', 'Earned Leave', 9, 0),
(19, 'EMP06', 'Casual Leave', 11, 0),
(20, 'EMP06', 'Medical Leave', 11, 0),
(21, 'EMP06', 'Earned Leave', 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `emp_id` varchar(20) NOT NULL,
  `leave_type` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days_requested` int(11) NOT NULL,
  `Reason` varchar(100) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Pending',
  `doc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`emp_id`, `leave_type`, `start_date`, `end_date`, `days_requested`, `Reason`, `status`, `doc`) VALUES
('EMP01', 'Casual Leave', '2023-07-12', '2023-07-13', 2, 'Casual', 'Pending', 'docs/sx7xs3ve3k.'),
('EMP04', 'Casual Leave', '2023-07-11', '2023-07-14', 4, 'casual', 'Rejected', 'docs/kjn4oz0bxn.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `leave`
--
ALTER TABLE `leave`
  ADD PRIMARY KEY (`lv_id`),
  ADD KEY `forr` (`emp_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`emp_id`,`start_date`,`end_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave`
--
ALTER TABLE `leave`
  MODIFY `lv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leave`
--
ALTER TABLE `leave`
  ADD CONSTRAINT `forr` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `forkey` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
