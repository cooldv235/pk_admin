-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2018 at 12:24 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primatvq_news`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `news_category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `content` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `published_on` datetime NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `is_trend` tinyint(1) NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `news_category_id`, `title`, `short_description`, `content`, `user_id`, `state_id`, `featured_image`, `published_on`, `slug`, `meta_title`, `meta_description`, `meta_keyword`, `is_trend`, `is_hot`, `is_featured`, `is_active`, `created`, `modified`) VALUES
(1, 0, '', '', '', 1, 0, 'Lighthouse2.jpg', '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 1, '2018-01-13 07:54:37', '2018-01-13 07:54:37'),
(4, 1, 'cbfghy', 'cbfghy', '<p>cbfghy</p>', 1, 0, 'Hydrangeas1.jpg', '2018-01-04 00:00:00', 'cbfghy', '', '', '', 0, 0, 0, 1, '2018-01-13 08:12:47', '2018-01-13 08:12:47'),
(5, 0, 'cbfghy', 'cbfghy', '<p>vbcgfht</p>', 1, 0, 'Penguins6.jpg', '2018-01-08 00:00:00', 'cbfghybjuy1', '', '', '', 0, 0, 0, 1, '2018-01-13 08:20:37', '2018-01-13 08:20:37'),
(6, 0, 'cbfghy', 'cbfghy', '<p>vcxdfbgs</p>', 1, 0, 'Penguins7.jpg', '2018-01-22 00:00:00', 'cbfghybjuy11', '', '', '', 0, 0, 0, 1, '2018-01-13 08:27:27', '2018-01-13 08:27:27'),
(7, 0, 'cbfghy', 'cbfghy', '<p>ghyhg</p>', 1, 0, 'Penguins8.jpg', '2018-01-06 00:00:00', 'cbfghybjuy111', '', '', '', 0, 0, 0, 1, '2018-01-13 08:29:55', '2018-01-13 08:29:55'),
(8, 0, 'cbfghy', 'cbfghy', '<p>&nbsp;vnghjnfty</p>', 1, 0, 'Chrysanthemum.jpg', '2018-01-01 00:00:00', 'cbfghybjuy1111bgbf', '', '', '', 0, 0, 0, 1, '2018-01-13 08:32:38', '2018-01-13 08:32:38'),
(9, 1, 'test2324', 'vdfcvdfg', '<p>vgtrh</p>', 1, 0, 'Chrysanthemum1.jpg', '2018-01-30 00:00:00', 'vdfgd', '', '', '', 0, 0, 0, 1, '2018-01-13 08:39:16', '2018-01-13 08:39:16'),
(11, 1, ' $id ', ' $id ', '<p>&nbsp;$id&nbsp;</p>', 1, 0, 'Desert.jpg', '2018-01-07 00:00:00', '$id', '', '', '', 0, 0, 0, 1, '2018-01-13 08:43:49', '2018-01-13 08:43:49'),
(13, 0, '$id[''id'']', '$id[''id'']', '<p>$id[&#39;id&#39;]</p>', 1, 0, 'Desert2.jpg', '2018-01-22 00:00:00', '$id[''id'']', '', '', '', 0, 0, 0, 1, '2018-01-13 08:45:17', '2018-01-13 08:45:17'),
(15, 0, '$id[''id'']', '$id[''id'']', '<p>$id[&#39;id&#39;]</p>', 1, 0, 'Hydrangeas3.jpg', '2018-01-02 00:00:00', '$id[''id'']1', '', '', '', 0, 0, 0, 1, '2018-01-13 08:46:00', '2018-01-13 08:46:00'),
(16, 0, 'abc', 'abc', '<p>xcc</p>', 1, 0, 'Penguins9.jpg', '2018-01-07 00:00:00', 'abc', '', '', '', 0, 0, 0, 1, '2018-01-13 08:51:35', '2018-01-13 08:51:35'),
(18, 0, 'xcdf', 'cxdfrd', '<p>cxdfrd</p>', 1, 0, 'Hydrangeas4.jpg', '2018-01-21 00:00:00', 'cxdfrd', '', '', '', 0, 0, 0, 1, '2018-01-13 08:52:58', '2018-01-13 08:52:58'),
(20, 1, 'cxdfrd', 'cxdfrd', '<p>cxdfrd</p>', 1, 0, 'Penguins11.jpg', '2018-01-17 00:00:00', 'cxdfrd1', '', '', '', 0, 0, 0, 1, '2018-01-13 08:54:57', '2018-01-13 08:54:57'),
(21, 2, 'business', 'business related news', 'Indu Malhotra''s potential appointment to SC is historic, but lack of gender diversity in judiciary worrisomeFirstpost 2h ago?RELATED COVERAGESupreme Court Crisis LIVE: Bar Council to Hold Press Conference ShortlyLive Updating News18 37m ago?Three legal eagles decode the Supreme Court crisisEconomic Times 9m ago?Acted in interest of judiciary, justice: Kurian JosephTimes of India 3h ago?A truly independent judiciary cannot be subverted from within or outsideOpinion The Indian Express 5h ago?View full coverage?', 1, 0, 'Desert5.jpg', '2018-01-13 00:00:00', 'business', '', '', '', 0, 0, 0, 1, '2018-01-13 11:04:49', '2018-01-13 12:58:45'),
(22, 1, 'vbfg', 'gfhdty', '<p>fhdrtft</p>', 1, 0, 'Hydrangeas7.jpg', '2018-01-30 00:00:00', 'ghftf', '', '', '', 0, 0, 0, 1, '2018-01-19 02:08:52', '2018-01-19 02:08:52'),
(23, 1, 'czdv', 'fgser', '<p>fserger</p>', 1, 0, 'Lighthouse5.jpg', '2018-01-21 00:00:00', 'dfvesr', '', '', '', 0, 0, 0, 1, '2018-01-19 02:10:37', '2018-01-19 02:10:37'),
(24, 0, 'czdv', 'fgser', '<p>ffgdrg</p>', 1, 0, 'Penguins16.jpg', '2018-01-03 00:00:00', 'dfvesrght', '', '', '', 0, 0, 0, 1, '2018-01-19 02:11:59', '2018-01-19 02:11:59'),
(25, 1, 'czdv', 'fgser', '<p>gbfghrt</p>', 1, 2, 'Penguins17.jpg', '2018-01-04 00:00:00', 'dfvesrght1', '', '', '', 0, 0, 0, 1, '2018-01-19 02:15:06', '2018-01-19 13:07:10'),
(26, 2, 'test', 'test', '<p>test</p>', 1, 2, 'Hydrangeas9.jpg', '2018-01-03 00:00:00', 'test', '', '', '', 1, 1, 1, 1, '2018-01-29 08:23:29', '2018-01-29 12:00:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
