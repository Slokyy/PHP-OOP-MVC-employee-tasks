-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 03, 2022 at 04:58 PM
-- Server version: 5.7.31
-- PHP Version: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backend_zaposleni`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` double NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`lastname`),
  UNIQUE KEY `email` (`email`),
  KEY `employees_position` (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `position_id`, `firstname`, `lastname`, `password`, `salary`, `email`) VALUES
(1, 1, 'John', 'Doe', '5ebe2294ecd0e0f08eab7690d2a6ee69', 1200, 'johndoe@macrohard.com'),
(2, 3, 'Maria', 'Smith', NULL, 1340, 'mariasmith@macrohard.com'),
(3, 4, 'Alex', 'Williams', NULL, 1500, 'alexwilliams@marcrohard.com'),
(4, 2, 'Molly', 'Jones', NULL, 1700, 'mollyjones@macrohard.com'),
(5, 2, 'Derek', 'Brownsworth', NULL, 1650, 'derekbrownsworth@macrohard.com'),
(6, 2, 'Linus', 'Lafreigne', NULL, 1750, 'linuslafreigne@macrohard.com'),
(7, 2, 'Slobodan', 'Cvetkovic', NULL, 1523.23, 'slobodancv@macrohard.com'),
(11, 2, 'Marko', 'Markovic', NULL, 1842, 'marko@macrohard.com'),
(13, 4, 'Nikola', 'Nikolic', NULL, 1745, 'nikola@macrohard.com'),
(16, 2, 'Martin', 'Medic', NULL, 1234, 'martinmedic@macrohard.com'),
(18, 3, 'Alexandra', 'Costarica', NULL, 1678.55, 'alexandracostarica@macrohard.com'),
(19, 4, 'Danniel', 'Wallowich', NULL, 2100, 'danielwallowich@macrohard.com');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position_name`) VALUES
(1, 'Administrator'),
(2, 'Programmer'),
(3, 'Designer'),
(4, 'Manager');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_position` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
