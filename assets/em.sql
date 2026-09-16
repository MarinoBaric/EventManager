-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 07, 2026 at 03:17 PM
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
-- Database: `em`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

DROP TABLE IF EXISTS `attendee`;
CREATE TABLE `attendee` (
  `attendee_id` smallint(5) UNSIGNED NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendee`
--

INSERT INTO `attendee` (`attendee_id`, `first_name`, `last_name`, `email`, `username`, `password`, `role_id`) VALUES
(1, 'Kristina', 'Marasović', 'kristina.marasovic@croatia.rit.edu', 'km', '$2y$10$pdb9ubrwk26x8ldH06VP1uKXyAMm9D2F3O7XY8IkIsNW2g.DdsRs.', 1),
(2, 'Kristina', 'Marasović', 'kxmzgr@rit.edu', 'kmu', '$2y$10$/TGAngySy2s117SvEBhQzuw5V2bVroaNbwuzgquvZ2MuhoWaD8HyS', 2),
(3, 'Marino', 'Baric', 'marino.baric@example.com', 'marino', '$2y$10$hBGWc8ob3Vdj/bgFWKRNhebx6Zg6GitpwEMoFCkZiL3YJhGXrqBWS', 1),
(4, 'Ana', 'Horvat', 'ana.horvat@example.com', 'anah', '$2y$10$a8.IL8JHsL68nivL/PEpneY8IxMh31K5PxUd4SDQTGfeO055yyWUm', 2),
(5, 'Ivan', 'Kovacic', 'ivan.kovacic@example.com', 'ivank', '$2y$10$/TGAngySy2s117SvEBhQzuw5V2bVroaNbwuzgquvZ2MuhoWaD8HyS', 1),
(6, 'Petra', 'Novak', 'petra.novak@example.com', 'petran', '$2y$10$/TGAngySy2s117SvEBhQzuw5V2bVroaNbwuzgquvZ2MuhoWaD8HyS', 2),
(7, 'Luka', 'Babic', 'luka.babic@example.com', 'lukab', '$2y$10$/TGAngySy2s117SvEBhQzuw5V2bVroaNbwuzgquvZ2MuhoWaD8HyS', 2),
(8, 'Test', 'Test', 'test@test.com', 'testko', '$2y$10$VsyROF9eX.U0jrbqh8K4se6AT./YEUuUqpGK6f5hgN4mSqRjW7T4q', 2);

-- --------------------------------------------------------

--
-- Table structure for table `attendee_event`
--

DROP TABLE IF EXISTS `attendee_event`;
CREATE TABLE `attendee_event` (
  `attendee_id` smallint(5) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendee_event`
--

INSERT INTO `attendee_event` (`attendee_id`, `event_id`, `paid`) VALUES
(2, 1, 1),
(2, 2, 1),
(2, 3, 0),
(4, 1, 1),
(4, 3, 1),
(4, 5, 0),
(4, 6, 0),
(5, 2, 1),
(5, 4, 0),
(5, 6, 0),
(6, 2, 1),
(6, 5, 1),
(7, 3, 1),
(7, 4, 1),
(7, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `allowed_number` int(11) NOT NULL,
  `venue_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `name`, `start_date`, `end_date`, `allowed_number`, `venue_id`) VALUES
(1, 'PHP Workshop', '2026-10-05 10:00:00', '2026-10-05 13:00:00', 25, 1),
(2, 'Web Development Conference', '2026-10-10 09:00:00', '2026-10-10 17:00:00', 100, 3),
(3, 'Database Workshop', '2026-10-15 12:00:00', '2026-10-15 15:00:00', 20, 2),
(4, 'Cybersecurity Seminar', '2026-10-20 14:00:00', '2026-10-20 18:00:00', 80, 4),
(5, 'Introduction to MVC', '2026-10-25 10:00:00', '2026-10-25 12:00:00', 30, 1),
(6, 'JavaScript Basics', '2026-11-02 11:00:00', '2026-11-02 14:00:00', 200, 5);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`) VALUES
(1, 'admin'),
(2, 'attendee');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

DROP TABLE IF EXISTS `venue`;
CREATE TABLE `venue` (
  `venue_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`venue_id`, `name`, `capacity`) VALUES
(1, 'RIT Croatia Zagreb - Room 1', 30),
(2, 'RIT Croatia Zagreb - Room 2', 25),
(3, 'Zagreb Convention Hall', 150),
(4, 'Arena Zagreb Conference Room', 100),
(5, 'Online Event', 500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`attendee_id`),
  ADD KEY `idx_fk_role_id` (`role_id`);

--
-- Indexes for table `attendee_event`
--
ALTER TABLE `attendee_event`
  ADD PRIMARY KEY (`attendee_id`,`event_id`),
  ADD KEY `idx_fk_attendee_id` (`attendee_id`),
  ADD KEY `idx_fk_event_id` (`event_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `unique_name` (`name`),
  ADD KEY `idx_fk_venue_id` (`venue_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `unique_name` (`name`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`venue_id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendee`
--
ALTER TABLE `attendee`
  MODIFY `attendee_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `venue_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendee`
--
ALTER TABLE `attendee`
  ADD CONSTRAINT `fk_attendee_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `attendee_event`
--
ALTER TABLE `attendee_event`
  ADD CONSTRAINT `fk_attendee_event_attendee` FOREIGN KEY (`attendee_id`) REFERENCES `attendee` (`attendee_id`),
  ADD CONSTRAINT `fk_attendee_event_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`venue_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
