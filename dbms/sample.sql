-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2022 at 01:28 AM
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
-- Database: `sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `number` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `email`, `number`, `password`, `date_created`) VALUES
(5, 'asd', 'asd@g.com', '123456786', '36f17c3939ac3e7b2fc9396fa8e953ea', '2022-11-12'),
(6, 'ako', 'ako@gg.aim', '1234567', '827ccb0eea8a706c4c34a16891f84e7b', '2022-11-13');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plane_type` varchar(45) NOT NULL,
  `speed` bigint(11) NOT NULL,
  `destination` varchar(45) NOT NULL,
  `gas_tank` bigint(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `user_id`, `plane_type`, `speed`, `destination`, `gas_tank`, `date`) VALUES
(1, 5, 'fighter jet FRT 43', 50, 'taiwan', 1000, '2022-11-13'),
(2, 5, 'fighter jet XF 43', 100, 'thailand', 500, '2022-11-13'),
(3, 5, 'Aero Frost A1', 35, 'cebu', 400, '2022-11-13'),
(4, 5, 'FR fx 43', 45, 'finland', 120, '2022-11-13'),
(5, 5, 'Samp 45S', 302, 'france', 320, '2022-11-13'),
(10, 6, 'CBX', 35, 'taiwan', 200, '2022-11-13'),
(11, 6, 'PRIT xx2', 100, 'france', 200, '2022-11-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
