-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 15, 2021 at 05:17 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id17597613_kashie`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `sno` int(3) NOT NULL,
  `sender` text NOT NULL,
  `receiver` text NOT NULL,
  `balance` int(8) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`sno`, `sender`, `receiver`, `balance`, `datetime`) VALUES
(1, 'Rohil Shah', 'Romil Shah', 2112, '2021-09-12 16:08:35'),
(2, 'Romil Shah', 'Rohil Shah', 2112, '2021-09-12 16:09:36'),
(3, 'Nirali Mehta', 'Romil Shah', 10000, '2021-09-13 12:55:20'),
(4, 'Romil Shah', 'Matt Casey', 25000, '2021-09-15 16:51:33'),
(5, 'Gabriella Dawson', 'Antonio Dawson', 7500, '2021-09-15 17:11:37'),
(6, 'Matt Casey', 'Rohil Shah', 25000, '2021-09-15 17:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `balance` int(8) NOT NULL,
  `phone` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `balance`, `phone`) VALUES
(1, 'Romil Shah', 'rshah@gmail.com', 186200, 8347243540),
(2, 'Rohil Shah', 'rohils@gmail.com', 236312, 8347243547),
(3, 'Kashish Patel', 'kpatel@gmail.com', 131200, 9724470707),
(4, 'Nirali Mehta', 'nilu@gmail.com', 120902, 7016634555),
(5, 'Matt Casey', 'mcasey@chicagofire.com', 200000, 1408400400),
(6, 'Kelly Severide', 'kseveride@chicagofire.com', 150000, 1408400401),
(7, 'Leslie Shay', 'lshay@chicagofire.com', 175000, 1408400402),
(8, 'Gabriella Dawson', 'gdawson@chicagofire.com', 167500, 1408400403),
(9, 'Antonio Dawson', 'adawson@chicagopd.com', 132500, 1408400300),
(10, 'Jay Halstead', 'jhalstead@chicagopd.com', 125000, 1408400301);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `sno` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
