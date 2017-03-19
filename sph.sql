-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2017 at 03:30 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sopian`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_level`
--

CREATE TABLE `m_level` (
  `level_id` int(11) NOT NULL,
  `nama_level` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_level`
--

INSERT INTO `m_level` (`level_id`, `nama_level`) VALUES
(1, 'Admin'),
(2, 'Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `m_sph`
--

CREATE TABLE `m_sph` (
  `sph_id` int(11) NOT NULL,
  `nomor_sph` varchar(50) NOT NULL,
  `tanggal_sph` date NOT NULL,
  `tujuan_sph` varchar(50) NOT NULL,
  `lokasi_sph` varchar(50) NOT NULL,
  `perihal_sph` varchar(100) NOT NULL,
  `jumlah` double NOT NULL,
  `file_sph` varchar(50) DEFAULT NULL,
  `file_supplier` varchar(50) DEFAULT NULL,
  `active` varchar(1) NOT NULL,
  `ip_address` varchar(30) NOT NULL,
  `hostname` varchar(40) NOT NULL,
  `creation_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_update_date` datetime NOT NULL,
  `last_updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_sph`
--

INSERT INTO `m_sph` (`sph_id`, `nomor_sph`, `tanggal_sph`, `tujuan_sph`, `lokasi_sph`, `perihal_sph`, `jumlah`, `file_sph`, `file_supplier`, `active`, `ip_address`, `hostname`, `creation_date`, `created_by`, `last_update_date`, `last_updated_by`) VALUES
(2, '4545646', '2017-01-03', 'dfgdfgdgf', 'rdtrtrt', 'ghjgjhj', 4545456, NULL, NULL, 'N', '', '', '2017-01-01 14:04:06', 1, '0000-00-00 00:00:00', 0),
(6, '010/020.00001', '2017-03-01', 'Apa Aja', 'Apa Aja', 'Apa AJa', 9800000, NULL, NULL, 'Y', '::1', 'indra-hp', '2017-03-15 05:20:41', 1, '2017-03-15 05:24:49', 1),
(7, '010/020.00002', '2017-03-02', 'Apa Aja', 'Apa Aja', 'Apa Aja', 99999, NULL, NULL, 'Y', '::1', 'indra-hp', '2017-03-15 05:22:44', 1, '2017-03-15 05:24:40', 1),
(8, '010/020.00003', '2017-03-22', 'aS', 'As', 'As', 0, NULL, NULL, 'Y', '::1', 'indra-hp', '2017-03-18 05:39:20', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `user_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `last_login_date` datetime NOT NULL,
  `active` varchar(1) NOT NULL,
  `ip_address` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`user_id`, `level_id`, `email`, `password`, `creation_date`, `created_by`, `last_updated_by`, `last_login_date`, `active`, `ip_address`) VALUES
(1, 1, 'sopian@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', '2016-12-31 00:00:00', 1, 1, '2017-03-18 05:39:00', 'Y', '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `m_level`
--
ALTER TABLE `m_level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `m_sph`
--
ALTER TABLE `m_sph`
  ADD PRIMARY KEY (`sph_id`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_level`
--
ALTER TABLE `m_level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `m_sph`
--
ALTER TABLE `m_sph`
  MODIFY `sph_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
