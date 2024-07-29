-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2024 at 01:21 PM
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
-- Database: `user_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','userclient') NOT NULL DEFAULT 'userclient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, '@Belljonson', '$2y$10$a.uplFAv9uhijhsVXd73nOXpEMh8kgPWwr2X.WBiQLp', ''),
(2, 'joyjonson', '$2y$10$J9tsvGroXsvnAbw5qGYJyukZxYEYy9rHjdkV0DYT5e5', ''),
(3, '@hailey', '$2y$10$xIrCN9OWw1LGVYzkDE2YbuXzVSFEQvrpzTZBqC7sRz6', ''),
(4, 'Julius Jonson', '$2y$10$lQBztZKDdRlNLajssFS4R.iuBqmmLZO5aWI3DxuyYjK', ''),
(6, 'joybeljonson7@gmail.com', '$2y$10$1UToJooMqfw1V9jmlfvuBe2oQ50ZCpmTG.fo7dL0y1HOyyMHkSdXS', ''),
(7, 'joybeljonson01@gmail.com', '$2y$10$.8kgp7ELrsPGwZhJuLE3PuqaTkYZ35b.5yNSwCIfcD4RFdpD4nwza', 'userclient'),
(8, 'princessjonson4@gmail.com', '$2y$10$BXkbBbN8jBYG9HOnXcbLt.TF6Ro1h/lfBxIWQTkVe1X/1hlmFFys2', 'admin'),
(9, 'rubyjean5@gmail.com', '$2y$10$5yH7owN4v4PKpNPKgv3ZDupMdtRG5FeYcjQwVkKCjyuBUI0CpNdbS', 'userclient'),
(10, 'johnjonson6@gmail.com', '$2y$10$Iadg9LVeTCDHLc2MRPrCU.MWAVQIlkUG2ATGP0bZ84LByJt.MLhBm', 'userclient'),
(11, 'jomaryjonson7@gmail.com', '$2y$10$5OJE48JoxJ9BV94H2cIyXehB8fo5cZnop8Njx2KFGXrEHNZ20gc3y', 'userclient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
