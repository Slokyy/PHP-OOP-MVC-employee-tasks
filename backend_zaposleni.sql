-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 07, 2022 at 06:52 AM
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
  `salary` decimal(10,2) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`lastname`),
  UNIQUE KEY `email` (`email`),
  KEY `employees_position` (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `position_id`, `firstname`, `lastname`, `password`, `salary`, `email`) VALUES
(1, 1, 'John', 'Doe', '5ebe2294ecd0e0f08eab7690d2a6ee69', '1499.00', 'johndoe@macrohard.com'),
(2, 3, 'Maria', 'Smith', NULL, '1340.00', 'mariasmith@macrohard.com'),
(3, 4, 'Alex', 'Williams', NULL, '1500.00', 'alexwilliams@marcrohard.com'),
(4, 2, 'Molly', 'Jones', NULL, '1700.00', 'mollyjones@macrohard.com'),
(5, 2, 'Derek', 'Brownsworth', NULL, '1650.00', 'derekbrownsworth@macrohard.com'),
(6, 2, 'Linus', 'Lafreigne', NULL, '1750.00', 'linuslafreigne@macrohard.com'),
(7, 2, 'Slobodan', 'Cvetkovic', NULL, '2523.23', 'slobodancv@macrohard.com'),
(11, 2, 'Marko', 'Markovic', NULL, '1842.00', 'marko@macrohard.com'),
(13, 3, 'Nikola', 'Nikolic', NULL, '1745.00', 'nikolanikolic@macrohard.com'),
(18, 3, 'Alexandra', 'Costarica', NULL, '1678.55', 'alexandracostarica@macrohard.com'),
(19, 3, 'Martha', 'Batman', NULL, '2250.00', 'marthabatman@macrohard.com'),
(23, 4, 'Danijela', 'Kisanovic', NULL, '1999.00', 'danijelakisanovic@macrohard.com');

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

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_description` varchar(756) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `project_description`) VALUES
(7, 'PHP MVC implementacija', 'PHP MVC implementacija u projektu za obuku organizovanu od strane Infostuda i Concorda'),
(8, 'React Integration', 'React integration into existing project');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `task_description` varchar(756) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_deadline` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_task_fk` (`project_id`),
  KEY `employee_task_fk` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `employee_id`, `task_description`, `task_deadline`) VALUES
(2, 7, 7, 'Implementacija mvc arhitekture radi sto elegantijeg resavanja taskova u buducnosti', '2022-04-15'),
(3, 7, 11, 'PHP Controller implementation', '2022-04-08'),
(4, 7, 6, 'Model implementacija', '2022-04-15'),
(5, 7, 13, 'View implementacija i inicijalni dizajn', '2022-04-12'),
(6, 8, 13, 'MVP implementacija unutar reacta, i generalna postavka', '2022-04-11'),
(7, 8, 3, 'Nadgledanje sprinta i provera statusa taska', '2022-04-15');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_position` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `task_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
