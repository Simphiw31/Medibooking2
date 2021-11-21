-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2021 at 07:18 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `med_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminstrator`
--

CREATE TABLE `adminstrator` (
  `adminId` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `date_of_birth` date NOT NULL DEFAULT current_timestamp(),
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adminstrator`
--

INSERT INTO `adminstrator` (`adminId`, `name`, `surname`, `email`, `phone`, `date_of_birth`, `password`) VALUES
('mnce13', 'Mncedisi', 'Sithole', 'Nel12@gmail.com', '0796752429', '2021-06-01', 'MAronyo');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_ID` int(3) NOT NULL,
  `patient_id` bigint(12) NOT NULL,
  `schedule_id` int(10) NOT NULL,
  `appSymptom` varchar(100) NOT NULL,
  `appComment` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'process'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_ID`, `patient_id`, `schedule_id`, `appSymptom`, `appComment`, `status`) VALUES
(86, 920517105553, 40, 'Pening Kepala', 'Bila doktor free?', 'done'),
(87, 12345, 41, 'dizzyness', 'i can\'t sleep ', 'done'),
(90, 4563, 44, 'Post-viral cough', 'i was not feeling well the past few days becaase of dry cough, dizzyness', 'done'),
(91, 123456, 42, 'Post-viral cough', 'huvyvjkzdsghbkjdx', 'done');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `icDoctor` bigint(12) NOT NULL,
  `password` varchar(20) NOT NULL,
  `doctor_id` int(3) NOT NULL,
  `doctorFirstName` varchar(50) NOT NULL,
  `doctorLastName` varchar(50) NOT NULL,
  `doctorAddress` varchar(100) NOT NULL,
  `doctorPhone` varchar(15) NOT NULL,
  `doctorEmail` varchar(20) NOT NULL,
  `doctorDOB` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`icDoctor`, `password`, `doctor_id`, `doctorFirstName`, `doctorLastName`, `doctorAddress`, `doctorPhone`, `doctorEmail`, `doctorDOB`) VALUES
(123, 'MAronyo', 12, 'Mncedisi', 'Neliswa', 'Nelsprit GAME ext9', '0822149368', 'Mnce12@gmail.com', '2001-07-12'),
(1566, '1234', 34, 'Xolani', 'Given', 'Kwamhlanga', '+793-3651-446', 'Simpiwe12@gmail.com', '1997-04-16');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `scheduleDate` date NOT NULL,
  `scheduleDay` varchar(15) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `bookAvail` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `scheduleDate`, `scheduleDay`, `startTime`, `endTime`, `bookAvail`) VALUES
(40, '2021-07-13', 'Tuesday', '09:00:00', '10:00:00', 'notavail'),
(41, '2021-07-18', 'Sunday', '10:00:00', '11:00:00', 'notavail'),
(42, '2021-08-13', 'Friday', '11:00:00', '12:00:00', 'notavail'),
(43, '2021-08-19', 'Thursday', '11:00:00', '12:00:00', 'available'),
(44, '2021-07-28', 'Wesday', '01:00:00', '02:00:00', 'notavail');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` bigint(12) NOT NULL,
  `password` varchar(20) NOT NULL,
  `patientFirstName` varchar(20) NOT NULL,
  `patientLastName` varchar(20) NOT NULL,
  `patientMaritialStatus` varchar(10) NOT NULL,
  `patientDOB` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `patientStreetAddress` varchar(100) NOT NULL,
  `patientPhone` varchar(15) NOT NULL,
  `patientEmail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `password`, `patientFirstName`, `patientLastName`, `patientMaritialStatus`, `patientDOB`, `gender`, `patientStreetAddress`, `patientPhone`, `patientEmail`) VALUES
(97, 'phindile', 'Phindile', 'Perseverance', '', '1998-09-14', 'female', '', '', 'phindile12@gmail.com'),
(3566, 'kill', 'yyy', 'sss', '', '1987-09-14', 'male', '', '', 'dcvqHgbzs'),
(4563, 'emmanuel', 'Emmanuel', 'Emza', '', '1999-06-12', 'male', '', '', 'emmanuel12@gmail.com'),
(12345, '123', 'neliswa', 'mncedisi', 'single', '2001-12-07', 'male', 'corridor hills', '796752429', 'neliswa12@gmail.com'),
(123456, '1234', 'Phindile', 'Emza', 'single', '1997-09-14', 'female', 'p.o box 1098', '796752429', 'nel12@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `receptionist_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receptionist`
--

INSERT INTO `receptionist` (`receptionist_id`, `name`, `surname`, `email`, `phone`, `password`) VALUES
('emza12', 'emmanuel', '', 'emza12@gmail.com', '0796752429', 'MAronyo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminstrator`
--
ALTER TABLE `adminstrator`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_ID`),
  ADD UNIQUE KEY `schedule_id_2` (`schedule_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`icDoctor`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD PRIMARY KEY (`receptionist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_4` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`),
  ADD CONSTRAINT `appointment_ibfk_5` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
