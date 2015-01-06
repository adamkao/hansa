-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 05, 2015 at 06:07 PM
-- Server version: 5.5.36-cll-lve
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `hansagamesrecord`
--

CREATE TABLE IF NOT EXISTS `hansagamesrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `players` int(11) NOT NULL,
  `player1` varchar(16) NOT NULL,
  `player2` varchar(16) NOT NULL,
  `player3` varchar(16) NOT NULL,
  `player4` varchar(16) DEFAULT NULL,
  `player5` varchar(16) DEFAULT NULL,
  `expansion` int(11) NOT NULL,
  `winner1` varchar(16) NOT NULL,
  `winner2` varchar(16) DEFAULT NULL,
  `winner3` varchar(16) DEFAULT NULL,
  `winner4` varchar(16) DEFAULT NULL,
  `winner5` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
