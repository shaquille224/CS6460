-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 08, 2018 at 01:32 AM
-- Server version: 5.7.21
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `indoor_location`
--

-- --------------------------------------------------------

--
-- Table structure for table `personlocation`
--

CREATE TABLE `personlocation` (
  `person_id` int(11) NOT NULL,
  `library` int(6) NOT NULL DEFAULT '0',
  `gym` int(6) NOT NULL DEFAULT '0',
  `activitycenter` int(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personlocation`
--

INSERT INTO `personlocation` (`person_id`, `library`, `gym`, `activitycenter`) VALUES
(1, 0, 1, 0),
(2, 2, 1, 1),
(3, 0, 0, 0),
(4, 0, 0, 0),
(10, 0, 0, 0),
(20, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `username`, `password`, `email`, `name`, `phone`) VALUES
(1, 'Teacher1', '13492b987524620172d3e9768b598374', 'teacher1@123.com', 'teacher 1', '111111111'),
(2, 'Teacher2', '198806', 'teacher2@123.com', 'Teacher A', '123456789'),
(3, 'Teacher3', '198806', 'teacher3@123.com', 'Teacher B', '123456780');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `member`) VALUES
(1, 'Chuck', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `phone`) VALUES
(1, 'Test', '13492b987524620172d3e9768b598374', 'cyang@123.com', 'Chao1', '123456789'),
(2, 'Test1', '13492b987524620172d3e9768b598374', 'cyang@145.com', 'Yang', '987654321'),
(3, 'Test2', '13492b987524620172d3e9768b598374', 'cyang1@123.com', 'Chuck1', '1234567890'),
(4, 'Test3', '13492b987524620172d3e9768b598374', 'cyang3@123.com', 'Chuck3', '1223333'),
(10, 'Test4', '13492b987524620172d3e9768b598374', 'cyang4@123.com', 'Chuck4', '1233333'),
(20, 'Test20', '13492b987524620172d3e9768b598374', 'cyang20@123.com', 'Chuck9', '123456987');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `personlocation`
--
ALTER TABLE `personlocation`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
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
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `personlocation`
--
ALTER TABLE `personlocation`
  ADD CONSTRAINT `personlocation_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
