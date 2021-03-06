-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2018 at 12:28 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primatvq_abhitakk`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `login_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `account_type`, `login_id`, `is_active`, `created`, `modified`) VALUES
(1, 1, 1, 'customers', 2, 1, '2017-12-11 08:12:45', '2017-12-11 08:12:45'),
(2, 1, 2, 'employees', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 1, 'customers', 3, 1, '2017-12-13 05:42:22', '2017-12-13 05:42:22'),
(4, 3, 1, 'customers', 4, 1, '2017-12-14 01:26:40', '2017-12-14 01:26:40'),
(5, 4, 1, 'customers', 5, 1, '2017-12-14 17:33:20', '2017-12-14 17:33:20'),
(6, 5, 1, 'customers', 6, 1, '2017-12-16 16:39:01', '2017-12-16 16:39:01'),
(7, 6, 1, 'customers', 7, 1, '2017-12-18 14:18:19', '2017-12-18 14:18:19'),
(8, 7, 1, 'customers', 8, 1, '2017-12-20 01:05:24', '2017-12-20 01:05:24'),
(9, 8, 1, 'customers', 9, 1, '2017-12-20 13:54:53', '2017-12-20 13:54:53'),
(10, 9, 1, 'customers', 10, 1, '2017-12-20 13:56:45', '2017-12-20 13:56:45'),
(11, 10, 1, 'customers', 11, 1, '2017-12-20 13:59:14', '2017-12-20 13:59:14'),
(12, 11, 1, 'customers', 12, 1, '2017-12-20 14:03:39', '2017-12-20 14:03:39'),
(13, 12, 1, 'customers', 13, 1, '2017-12-20 14:05:45', '2017-12-20 14:05:45'),
(14, 13, 1, 'customers', 14, 1, '2017-12-20 14:09:27', '2017-12-20 14:09:27'),
(15, 14, 1, 'customers', 15, 1, '2017-12-20 15:22:50', '2017-12-20 15:22:50'),
(16, 15, 1, 'customers', 16, 1, '2017-12-20 15:26:08', '2017-12-20 15:26:08'),
(17, 16, 1, 'customers', 17, 1, '2017-12-20 15:38:08', '2017-12-20 15:38:08'),
(18, 17, 1, 'customers', 18, 1, '2017-12-20 15:44:11', '2017-12-20 15:44:11'),
(19, 18, 1, 'customers', 19, 1, '2017-12-20 15:53:34', '2017-12-20 15:53:34'),
(20, 19, 1, 'customers', 20, 1, '2017-12-20 15:56:38', '2017-12-20 15:56:38'),
(21, 20, 1, 'customers', 21, 1, '2017-12-20 16:06:24', '2017-12-20 16:06:24'),
(22, 21, 1, 'customers', 22, 1, '2017-12-20 16:07:52', '2017-12-20 16:07:52'),
(23, 22, 1, 'customers', 23, 1, '2017-12-20 17:22:53', '2017-12-20 17:22:53'),
(24, 23, 1, 'customers', 24, 1, '2017-12-20 17:24:24', '2017-12-20 17:24:24'),
(25, 24, 1, 'customers', 25, 1, '2017-12-20 17:38:32', '2017-12-20 17:38:32'),
(26, 25, 1, 'customers', 26, 1, '2017-12-20 17:48:27', '2017-12-20 17:48:27'),
(27, 26, 1, 'customers', 27, 1, '2017-12-20 19:24:05', '2017-12-20 19:24:05'),
(28, 27, 1, 'customers', 28, 1, '2017-12-20 19:28:30', '2017-12-20 19:28:30'),
(29, 28, 1, 'customers', 29, 1, '2017-12-20 19:36:40', '2017-12-20 19:36:40'),
(30, 29, 1, 'customers', 30, 1, '2017-12-20 19:41:39', '2017-12-20 19:41:39'),
(31, 30, 1, 'customers', 31, 1, '2017-12-20 19:44:33', '2017-12-20 19:44:33'),
(32, 31, 1, 'customers', 32, 1, '2017-12-20 19:47:18', '2017-12-20 19:47:18'),
(33, 32, 1, 'customers', 33, 1, '2017-12-20 19:49:18', '2017-12-20 19:49:18'),
(34, 33, 1, 'customers', 34, 1, '2017-12-20 19:52:21', '2017-12-20 19:52:21'),
(35, 34, 1, 'customers', 35, 1, '2017-12-20 20:03:17', '2017-12-20 20:03:17'),
(36, 35, 1, 'customers', 36, 1, '2017-12-20 20:05:44', '2017-12-20 20:05:44'),
(37, 36, 1, 'customers', 37, 1, '2017-12-20 20:27:04', '2017-12-20 20:27:04'),
(38, 37, 1, 'customers', 38, 1, '2017-12-20 20:46:10', '2017-12-20 20:46:10'),
(39, 38, 1, 'customers', 39, 1, '2017-12-20 20:52:56', '2017-12-20 20:52:56'),
(40, 39, 1, 'customers', 40, 1, '2017-12-21 14:50:47', '2017-12-21 14:50:47'),
(41, 40, 1, 'customers', 41, 1, '2017-12-21 14:52:10', '2017-12-21 14:52:10'),
(42, 41, 1, 'customers', 42, 1, '2017-12-21 14:53:42', '2017-12-21 14:53:42'),
(43, 38, 1, 'customers', 43, 1, '2017-12-21 23:31:08', '2017-12-21 23:31:08'),
(44, 39, 1, 'customers', 44, 1, '2017-12-22 00:06:03', '2017-12-22 00:06:03'),
(45, 40, 1, 'customers', 45, 1, '2017-12-22 00:11:16', '2017-12-22 00:11:16'),
(46, 41, 1, 'customers', 46, 1, '2017-12-22 00:18:37', '2017-12-22 00:18:37'),
(47, 42, 1, 'customers', 47, 1, '2017-12-22 00:21:21', '2017-12-22 00:21:21'),
(48, 43, 1, 'customers', 48, 1, '2017-12-22 00:26:42', '2017-12-22 00:26:42'),
(49, 44, 1, 'customers', 49, 1, '2017-12-22 00:31:49', '2017-12-22 00:31:49'),
(50, 45, 1, 'customers', 50, 1, '2017-12-22 00:35:44', '2017-12-22 00:35:44'),
(51, 46, 1, 'customers', 51, 1, '2017-12-22 00:41:18', '2017-12-22 00:41:18'),
(52, 47, 1, 'customers', 52, 1, '2017-12-22 00:43:21', '2017-12-22 00:43:21'),
(53, 48, 1, 'customers', 53, 1, '2017-12-22 00:45:45', '2017-12-22 00:45:45'),
(54, 49, 1, 'customers', 54, 1, '2017-12-22 00:52:29', '2017-12-22 00:52:29'),
(55, 50, 1, 'customers', 55, 1, '2017-12-22 00:55:11', '2017-12-22 00:55:11'),
(56, 51, 1, 'customers', 56, 1, '2017-12-22 11:01:15', '2017-12-22 11:01:15'),
(57, 13, 5, '', 60, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 14, 5, 'employees', 61, 1, '2018-03-27 09:56:38', '2018-03-27 09:56:38'),
(59, 15, 5, 'employees', 62, 1, '2018-03-28 12:37:01', '2018-03-28 12:37:01'),
(60, 53, 1, 'customers', 63, 1, '2018-03-29 13:57:04', '2018-03-29 13:57:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
