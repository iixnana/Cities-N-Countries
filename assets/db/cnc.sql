-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2019 at 01:34 PM
-- Server version: 5.7.24-log
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cnc`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--
-- Creation: Jun 27, 2019 at 08:22 PM
-- Last update: Jun 28, 2019 at 01:32 PM
--

CREATE TABLE `city` (
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL,
  `country` int(11) NOT NULL COMMENT 'Šalies ID',
  `title` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL COMMENT 'Pavadinimas',
  `size` int(11) NOT NULL COMMENT 'Plotas',
  `population` int(11) NOT NULL COMMENT 'Populiacija',
  `citycode` varchar(15) COLLATE utf8_lithuanian_ci NOT NULL COMMENT 'Miesto pašto kodas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci COMMENT='Miestai';

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`date`, `id`, `country`, `title`, `size`, `population`, `citycode`) VALUES
('2019-06-27 23:22:12', 1, 1, 'Kaunas', 157, 295269, '44xxx - 528888'),
('2019-06-27 23:22:12', 2, 2, 'Berlynas', 891, 3711930, 'xxxx'),
('2019-06-27 23:22:12', 4, 1, 'Vilnius', 2401, 549389, '98xxx'),
('2019-06-27 23:22:12', 9, 1, 'Naujoji Akmene', 50, 9300, '50xxx'),
('2019-06-27 23:22:12', 24, 1, 'Marijampole', 21, 36628, '68xxx'),
('2019-06-27 23:22:12', 25, 1, 'Panevezys', 52, 88678, '35xxx'),
('2019-06-27 23:22:12', 26, 1, 'Klaipeda', 110, 172272, '88xxx'),
('2019-06-27 23:22:12', 27, 1, 'Plunge', 12, 18904, '74xxx'),
('2019-06-28 16:06:50', 32, 4, 'Londonas', 1572, 8825000, '22'),
('2019-06-28 16:12:38', 33, 4, 'Birminghamas', 268, 1137100, '500'),
('2019-06-28 16:21:20', 35, 10, 'Seulas', 605, 9779000, 'xxxxxxx'),
('2019-06-28 16:22:00', 36, 10, 'Busanas', 766, 3600381, 'aaaaaa'),
('2019-06-28 16:22:58', 37, 9, 'Stokholmas', 188, 965232, '100 00-199 99'),
('2019-06-28 16:23:28', 38, 6, 'Helsinkis', 715, 650058, '50xxx'),
('2019-06-28 16:30:45', 40, 17, 'Miestas', 2, 1, '5');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--
-- Creation: Jun 28, 2019 at 12:57 PM
-- Last update: Jun 28, 2019 at 01:31 PM
--

CREATE TABLE `country` (
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL COMMENT 'Pavadinimas',
  `size` double NOT NULL DEFAULT '1' COMMENT 'Plotas',
  `population` int(11) NOT NULL DEFAULT '1' COMMENT 'Populiacija',
  `dialcode` varchar(10) COLLATE utf8_lithuanian_ci NOT NULL COMMENT 'Tel. kodas',
  `usedSize` int(11) NOT NULL DEFAULT '0',
  `usedPopulation` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci COMMENT='Šalys';

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`date`, `id`, `title`, `size`, `population`, `dialcode`, `usedSize`, `usedPopulation`) VALUES
('2019-06-23 23:16:12', 1, 'Lietuva', 65300, 2791133, '+370', 2803, 1170440),
('2019-06-24 23:16:12', 2, 'Vokietija', 357386, 83000001, '+49', 891, 3711930),
('2019-06-25 23:16:12', 4, 'Anglija', 130396, 50762900, '+44', 1840, 9962100),
('2019-06-27 23:16:12', 6, 'Suomija', 338145, 5541274, '+358', 715, 650058),
('2019-06-27 23:16:12', 9, 'Svedija', 449964, 9920624, '+46', 188, 965232),
('2019-06-27 23:16:12', 10, 'Pietu Koreja', 100210, 50704971, '+82', 1371, 13379381),
('2019-06-28 16:25:31', 16, 'Tuscias', 500, 1, 'nera', 0, 0),
('2019-06-28 16:25:54', 17, 'Trinti su miestais', 500, 55, '555', 2, 1),
('2019-06-28 16:26:21', 19, 'Trinti be miestu', 5000, 5000, '555', 0, 0),
('2019-06-28 16:27:17', 21, 'Naujoji Zelandija', 268680, 4604871, '64', 0, 0),
('2019-06-28 16:27:59', 22, 'Australija', 7686850, 24641662, '61', 0, 0),
('2019-06-28 16:28:35', 23, 'Prancuzija', 551695, 64938716, '+33', 0, 0),
('2019-06-28 16:29:24', 24, 'Jungtines Amerikos Valstijos', 9833520, 327167434, '+1', 0, 0),
('2019-06-28 16:29:56', 25, 'Belgija', 30688, 11420163, '+32', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country` (`country`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`country`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
