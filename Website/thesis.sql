-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2018 at 07:32 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesis`
--
CREATE DATABASE IF NOT EXISTS `thesis` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `thesis`;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(2) NOT NULL,
  `device_id` varchar(20) NOT NULL,
  `device_latitude` varchar(50) NOT NULL,
  `device_longitude` varchar(50) NOT NULL,
  `device_altitude` decimal(9,6) NOT NULL,
  `device_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `device_id`, `device_latitude`, `device_longitude`, `device_altitude`, `device_status`) VALUES
(0, '20080519091900000', '14.6221', '121.0860', '14.000000', 'Active'),
(1, '20080519091900001', '14.6221', '121.08140979999999', '11.000000', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rescue_team`
--

CREATE TABLE `rescue_team` (
  `id` int(5) NOT NULL,
  `rescue_team_username` varchar(20) NOT NULL,
  `rescue_team_password` varchar(20) NOT NULL,
  `rescue_team_name` varchar(32) NOT NULL,
  `rescue_team_location` varchar(50) NOT NULL,
  `rescue_team_status` varchar(10) NOT NULL,
  `rescue_team_current_task` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rescue_team`
--

INSERT INTO `rescue_team` (`id`, `rescue_team_username`, `rescue_team_password`, `rescue_team_name`, `rescue_team_location`, `rescue_team_status`, `rescue_team_current_task`) VALUES
(1, 'sample', 'sample', 'Santolan Volunteer 01', 'LRT, Santolan', 'On Route', '20080519091900000'),
(2, 'test', 'test', 'Santolan Rescue 02', 'LRT, Santolan', 'On Route', '20080519091900001');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` varchar(10) NOT NULL,
  `log` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `status`, `log`) VALUES
(1, 'admin', 'admin', 'inactive', '2018-01-08 15:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `rescue_team`
--
ALTER TABLE `rescue_team`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rescue_team`
--
ALTER TABLE `rescue_team`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
