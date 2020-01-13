-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 13, 2020 at 08:49 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `aid` bigint(20) NOT NULL AUTO_INCREMENT,
  `aname` varchar(250) NOT NULL,
  `aemail` varchar(250) NOT NULL,
  `apassword` varchar(250) NOT NULL,
  `adate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`aid`, `aname`, `aemail`, `apassword`, `adate`) VALUES
(1, 'test123e', 'test@app.com', 'da6cb383f8f9e58f2c8af88a8c0eb65e', '2020-01-10 19:08:13'),
(2, 'test123ea', 'test@app.coma', 'da6cb383f8f9e58f2c8af88a8c0eb65e', '2020-01-10 19:08:33'),
(3, 'test123ea444', 'test@app.fgh', 'da6cb383f8f9e58f2c8af88a8c0eb65e', '2020-01-10 19:10:28'),
(4, 'testing_123', 'test@gg.fgh', '5b473d36c94d32fbd7f3c6920c2d3533', '2020-01-10 19:30:28'),
(5, '123456789', 'test@gmail.com', '25f9e794323b453885f5181f1b624d0b', '2020-01-11 11:50:55'),
(6, 'TTTT', 'test@gmail.com1', '25f9e794323b453885f5181f1b624d0b', '2020-01-11 11:51:47'),
(8, 'prashant', 'prashantgecg@gmail.com', '25f9e794323b453885f5181f1b624d0b', '2020-01-13 11:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` bigint(20) NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) NOT NULL,
  `uemail` varchar(255) NOT NULL,
  `upassword` varchar(255) NOT NULL,
  `ugender` varchar(50) NOT NULL,
  `ufname` varchar(100) NOT NULL,
  `ulname` varchar(100) NOT NULL,
  `uabout` text NOT NULL,
  `uimage` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
