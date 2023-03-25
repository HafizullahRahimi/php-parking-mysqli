-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 25 mars 2023 kl 11:19
-- Serverversion: 10.4.27-MariaDB
-- PHP-version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `prague_parking`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `bills`
--

CREATE TABLE `bills` (
  `reg_number` varchar(4) NOT NULL,
  `vehicle_type` tinyint(4) NOT NULL,
  `number_plate` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `arrival_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `departure_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumpning av Data i tabell `bills`
--

INSERT INTO `bills` (`reg_number`, `vehicle_type`, `number_plate`, `user_id`, `arrival_date`, `departure_date`) VALUES
('R140', 2, 'KLO7000', 23, '2023-02-23 10:55:28', NULL),
('R365', 1, 'HTN3450', 21, '2023-02-21 18:32:58', NULL),
('R681', 1, 'LOP9000', 2, '2023-02-23 15:19:48', NULL),
('R683', 1, 'KLI3400', 22, '2023-02-23 18:30:13', NULL),
('R880', 2, 'SHE78000', 24, '2023-02-23 13:10:08', NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur `parking`
--

CREATE TABLE `parking` (
  `id` tinyint(4) NOT NULL,
  `place` tinyint(4) NOT NULL,
  `part` tinyint(4) NOT NULL,
  `reg_number` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumpning av Data i tabell `parking`
--

INSERT INTO `parking` (`id`, `place`, `part`, `reg_number`) VALUES
(1, 1, 1, 'R880'),
(2, 1, 2, NULL),
(3, 2, 1, 'R140'),
(4, 2, 2, NULL),
(5, 3, 1, NULL),
(6, 3, 2, NULL),
(7, 4, 1, NULL),
(8, 4, 2, NULL),
(9, 5, 1, NULL),
(10, 5, 2, NULL),
(11, 6, 1, 'R681'),
(12, 6, 2, 'R681'),
(13, 7, 1, NULL),
(14, 7, 2, NULL),
(15, 8, 1, NULL),
(16, 8, 2, NULL),
(17, 9, 1, 'R365'),
(18, 9, 2, 'R365'),
(19, 10, 1, 'R683'),
(20, 10, 2, 'R683');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 1,
  `image` varchar(150) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `gender`, `role`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hafizullahrahimi@hotmail.com', '1234h', 'Hafizullah', 'Rahimi', 1, 0, 'admin.png', 1, '2023-02-20 12:06:11', NULL),
(2, 'Wille600@hotmail.com', '1234w', 'Wille', 'West', 1, 1, 'user.png', 1, '2023-02-20 12:06:24', NULL),
(3, 'Nancy-davolio@gmail.com', '123456', 'Sara', 'Davolio ', 0, 1, 'user.png', 1, '2023-02-20 12:06:41', NULL),
(5, 'Robert-king500@gmail.com', '1234rk', 'Robert', 'King', 1, 1, NULL, 1, '2023-02-20 12:07:59', NULL),
(18, 'john@example.com', '1234d', 'John', 'Doe', 1, 1, 'user.png', 1, '2023-02-21 15:07:50', NULL),
(20, 'Reza9098@gmail.com', '1234r', 'Reza', 'Nori', 1, 1, 'user.png', 1, '2023-02-21 15:43:20', NULL),
(21, 'Ali4005@gmail.com', '1234a', 'Ali', 'Ahmadi', 1, 1, 'user.png', 1, '2023-02-21 17:04:20', NULL),
(22, 'Javad450@gmail.com', '1234j', 'Javad', 'Alizade', 1, 1, 'user.png', 1, '2023-02-23 10:48:54', NULL),
(23, 'Peter6090@gmail.com', '1234p', 'Peter', 'wille', 1, 1, 'user.png', 1, '2023-02-23 10:55:07', NULL),
(24, 'Navid5000@gmail.com', '1234n', 'Navid', 'Navid', 1, 1, 'user.png', 1, '2023-02-23 13:09:47', NULL);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`reg_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Index för tabell `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_number` (`reg_number`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `parking`
--
ALTER TABLE `parking`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Restriktioner för tabell `parking`
--
ALTER TABLE `parking`
  ADD CONSTRAINT `parking_ibfk_1` FOREIGN KEY (`reg_number`) REFERENCES `bills` (`reg_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
