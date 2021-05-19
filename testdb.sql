-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2021 at 12:17 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `denis`
--

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `type_sort` varchar(64) DEFAULT NULL,
  `belongesToType` int(10) UNSIGNED DEFAULT NULL,
  `belongesToSubType` int(10) UNSIGNED DEFAULT NULL,
  `mainType` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `type_sort`, `belongesToType`, `belongesToSubType`, `mainType`) VALUES
(1, 'FrontEnd', 'main', NULL, NULL, NULL),
(2, 'BackEnd', 'main', NULL, NULL, NULL),
(3, 'Angular', 'mid', NULL, NULL, 1),
(4, 'AngularJs', 'sub', 3, NULL, 1),
(5, 'Angular2', 'sub', 3, NULL, 1),
(6, 'React', 'mid', NULL, NULL, 1),
(7, 'React native', 'sub', 6, NULL, 1),
(8, 'Vue', 'mid', NULL, NULL, 1),
(9, 'PHP', 'mid', NULL, NULL, 2),
(10, 'Symfony', 'sub', 9, NULL, 2),
(11, 'Silex', 'min', 9, 10, 2),
(12, 'Laravel', 'sub', 9, NULL, 2),
(13, 'Lumen', 'min', 9, 12, 2),
(14, 'NodeJs', 'mid', NULL, NULL, 2),
(15, 'Express', 'sub', 14, NULL, 2),
(16, 'NestJs', 'sub', 14, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `type_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type_id`) VALUES
(1, 'Alen', 'alen-ziberi@hotmail.com', 'alen123', 3),
(2, 'Brainster', 'brainster@mail.com', '$2y$10$KH3DTlNH/rKpryuFuQpPu.fJAAwmXxL4yGqaqd.5nQb9Icqi1c81u', 13),
(3, 'admin', 'admin@admin.com', '$2y$10$13cNLpjziqiWirFZfRpyiuBM4NzK9Z1AIU9O93vnmaQFjly.VCQFO', 9),
(4, 'elena', 'elena@elena.com', '$2y$10$NMI5Gg1uhChMQr6YErIQau8vvYOUkbuz3iDmavw.aEDU.tVQkG70y', 2),
(5, 'test1', 'email@test.com', 'testPass', 3),
(6, 'asd', 'asd', 'password', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_belonges_to` (`belongesToType`),
  ADD KEY `type_belonges_to_sub` (`belongesToSubType`),
  ADD KEY `type_belonges_to_main` (`mainType`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emial_unique` (`email`),
  ADD KEY `type_id_fk` (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `types`
--
ALTER TABLE `types`
  ADD CONSTRAINT `type_belonges_to` FOREIGN KEY (`belongesToType`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `type_belonges_to_main` FOREIGN KEY (`mainType`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `type_belonges_to_sub` FOREIGN KEY (`belongesToSubType`) REFERENCES `types` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `type_id_fk` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
