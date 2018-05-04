-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2018 at 04:54 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloodbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_blood_info`
--

CREATE TABLE `add_blood_info` (
  `info_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `donor_name` varchar(30) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `bloodgroup_id` int(2) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `add_blood_info`
--

INSERT INTO `add_blood_info` (`info_id`, `hospital_id`, `donor_name`, `mobile_no`, `bloodgroup_id`, `datetime`) VALUES
(1, 2, 'mayank', 9473829483, 2, '2018-04-19 20:20:02'),
(2, 1, 'alok', 9837408274, 7, '2018-04-19 20:20:02'),
(3, 1, 'neha', 7788446637, 2, '2018-04-19 20:20:12'),
(4, 1, 'yash', 8808765743, 1, '2018-04-19 20:20:02'),
(5, 1, 'mubasshir', 8877994823, 1, '2018-04-19 20:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `available_samples`
--

CREATE TABLE `available_samples` (
  `sample_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `bloodgroup_id` int(11) NOT NULL,
  `availability` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `available_samples`
--

INSERT INTO `available_samples` (`sample_id`, `hospital_id`, `bloodgroup_id`, `availability`) VALUES
(1, 1, 1, '1'),
(2, 1, 2, '1'),
(3, 1, 3, '0'),
(4, 1, 4, '0'),
(5, 1, 5, '0'),
(6, 1, 6, '0'),
(7, 1, 7, '0'),
(8, 1, 8, '1'),
(9, 3, 1, '1'),
(10, 3, 2, '0'),
(11, 3, 3, '0'),
(12, 3, 4, '0'),
(13, 3, 5, '0'),
(14, 3, 6, '0'),
(15, 3, 7, '0'),
(16, 3, 8, '0');

-- --------------------------------------------------------

--
-- Table structure for table `blood_group`
--

CREATE TABLE `blood_group` (
  `bloodgroup_id` int(2) NOT NULL,
  `bloodgroup_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood_group`
--

INSERT INTO `blood_group` (`bloodgroup_id`, `bloodgroup_name`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals_info`
--

CREATE TABLE `hospitals_info` (
  `hospital_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(70) NOT NULL,
  `hospital_name` varchar(30) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `hospitals_info`
--

INSERT INTO `hospitals_info` (`hospital_id`, `username`, `password`, `hospital_name`, `mobile_no`, `salt`, `created_at`) VALUES
(1, 'aimesh', 'oqbSfZv6Nb5EwI3ISKDD51mqhV81NDA1YTY4NjQy', 'aimes', 9373217479, '5405a68642', '2018-04-16 22:00:27'),
(2, 'lataman', 'FyoD3OIupUgIKh+sUgSCWWvXp3VmZWU0ZjlhYWVj', 'lata mangeshkar hospital', 8956896723, 'fee4f9aaec', '2018-04-17 08:40:44'),
(3, 'wockhardt', 'KzDUAsAjyt6NsuIO2kppZ943s8RhYmQwZmUxYjZm', 'wockhardt', 7766885528, 'abd0fe1b6f', '2018-04-18 11:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `receivers_info`
--

CREATE TABLE `receivers_info` (
  `receiver_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(70) NOT NULL,
  `receiver_name` varchar(30) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `bloodgroup_id` int(2) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receivers_info`
--

INSERT INTO `receivers_info` (`receiver_id`, `username`, `password`, `receiver_name`, `mobile_no`, `bloodgroup_id`, `salt`, `created_at`) VALUES
(1, 'alokpp', 'O2Ob2WSxEJZGt0oVx762k8CUIoJkYTIwNWU2YTY1', 'alok paidalwar', 9421554013, 7, 'da205e6a65', '2018-04-16 21:57:31'),
(2, 'jugneets', '8fT9U4KU08LPL0kordFh8pcn9y80MzhiZDEyM2I2', 'jugneet singh', 9083865429, 5, '438bd123b6', '2018-04-17 08:40:19'),
(3, 'sanket', '7lKjgfuxqZrUaegtNNQscM+OQeUyYmVlNDEzYzQz', 'sanket thakre', 9922334455, 2, '2bee413c43', '2018-04-18 20:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `bloodgroup_id` int(2) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `receiver_id`, `hospital_id`, `bloodgroup_id`, `datetime`) VALUES
(1, 1, 1, 2, '2018-04-17 08:38:54'),
(2, 2, 1, 1, '2018-04-17 08:41:16'),
(3, 2, 1, 1, '2018-04-17 09:06:05'),
(4, 1, 1, 1, '2018-04-17 09:06:26'),
(5, 1, 1, 1, '2018-04-18 13:57:31'),
(6, 1, 1, 8, '2018-04-18 13:57:48'),
(7, 1, 1, 1, '2018-04-18 14:40:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_blood_info`
--
ALTER TABLE `add_blood_info`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `add_bloodgroup_id` (`bloodgroup_id`),
  ADD KEY `add_hospital_id` (`hospital_id`);

--
-- Indexes for table `available_samples`
--
ALTER TABLE `available_samples`
  ADD PRIMARY KEY (`sample_id`),
  ADD KEY `available_hospital_id` (`hospital_id`),
  ADD KEY `available_bloodgroup_id` (`bloodgroup_id`);

--
-- Indexes for table `blood_group`
--
ALTER TABLE `blood_group`
  ADD PRIMARY KEY (`bloodgroup_id`);

--
-- Indexes for table `hospitals_info`
--
ALTER TABLE `hospitals_info`
  ADD PRIMARY KEY (`hospital_id`);

--
-- Indexes for table `receivers_info`
--
ALTER TABLE `receivers_info`
  ADD PRIMARY KEY (`receiver_id`),
  ADD KEY `receiver_bloodgroup_id` (`bloodgroup_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `requests_receiver_id` (`receiver_id`),
  ADD KEY `requests_hospital_id` (`hospital_id`),
  ADD KEY `requests_bloodgroup_id` (`bloodgroup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_blood_info`
--
ALTER TABLE `add_blood_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `available_samples`
--
ALTER TABLE `available_samples`
  MODIFY `sample_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `blood_group`
--
ALTER TABLE `blood_group`
  MODIFY `bloodgroup_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `hospitals_info`
--
ALTER TABLE `hospitals_info`
  MODIFY `hospital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `receivers_info`
--
ALTER TABLE `receivers_info`
  MODIFY `receiver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_blood_info`
--
ALTER TABLE `add_blood_info`
  ADD CONSTRAINT `add_bloodgroup_id` FOREIGN KEY (`bloodgroup_id`) REFERENCES `blood_group` (`bloodgroup_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `add_hospital_id` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals_info` (`hospital_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `available_samples`
--
ALTER TABLE `available_samples`
  ADD CONSTRAINT `available_bloodgroup_id` FOREIGN KEY (`bloodgroup_id`) REFERENCES `blood_group` (`bloodgroup_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `available_hospital_id` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals_info` (`hospital_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receivers_info`
--
ALTER TABLE `receivers_info`
  ADD CONSTRAINT `receiver_bloodgroup_id` FOREIGN KEY (`bloodgroup_id`) REFERENCES `blood_group` (`bloodgroup_id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_bloodgroup_id` FOREIGN KEY (`bloodgroup_id`) REFERENCES `blood_group` (`bloodgroup_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_hospital_id` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals_info` (`hospital_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_receiver_id` FOREIGN KEY (`receiver_id`) REFERENCES `receivers_info` (`receiver_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
