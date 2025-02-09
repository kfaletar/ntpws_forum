-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 01:56 PM
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
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `thread_id`, `user_id`, `content`, `created_at`) VALUES
(4, 3, 4, 'Upeco kečiguu!123\r\n', '2025-02-09 11:21:05'),
(6, 4, 5, 'formula 2 mi je bolja od jedinice', '2025-02-09 12:10:44'),
(7, 3, 5, 'Ja SMUDŽA!', '2025-02-09 12:11:16'),
(8, 5, 4, 'LoL je super!', '2025-02-09 12:16:51'),
(9, 6, 7, 'Smite je bolji od LoL-a', '2025-02-09 12:31:19'),
(12, 7, 8, 'daaaa', '2025-02-09 12:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `thread_id`) VALUES
(1, 4, 3),
(3, 4, 5),
(8, 5, 4),
(6, 6, 3),
(5, 6, 4),
(4, 6, 5),
(11, 7, 4),
(10, 7, 5),
(9, 7, 6),
(12, 8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `title`, `user_id`, `created_at`) VALUES
(3, 'Pecanje123', 4, '2025-02-09 11:20:41'),
(4, 'Formula 2', 5, '2025-02-09 12:10:25'),
(5, 'LoL', 4, '2025-02-09 12:16:28'),
(6, 'Smite', 7, '2025-02-09 12:31:03'),
(7, 'Premier Fantasy najbolji Fantasy!', 6, '2025-02-09 12:41:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(4, 'karlo', '$2y$10$TEsYDd6EoVnuEN2GUbVp/O8FvpW27tTsCtcy/GfZblAwbkf.wUIWu', 1, '2025-02-09 11:16:46'), --password 'karlo'
(5, 'admin', '$2y$10$H.MXQ35gG9a/nPMPnyEftuIKRyCV/gY.aEaN1vgmzNI5GExV4HWy.', 2, '2025-02-09 11:57:32'), --password 'admin'
(6, 'filip', '$2y$10$Q3sQk0ZS8yW.ScLairckFu2OiHV96YfOEruNCkBFyqYsmI8ZSmSRS', 1, '2025-02-09 12:21:28'), --password 'filip'
(7, 'marko', '$2y$10$UGTIjWLOeVd0FiTqLkDTuejGJip/e7UDuE4S/V9ZNQzSpy2xOdraa', 1, '2025-02-09 12:30:41'), --password 'marko'
(8, 'darko', '$2y$10$734JpPlCEDxxsdTumgYX9ObUfpJkXFeol.DRaIM8E3AisLtfxiGoa', 1, '2025-02-09 12:41:37'); --password 'darko'

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`thread_id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
