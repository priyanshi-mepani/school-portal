-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2026 at 01:37 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `enrolled_units` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `course`, `password`, `enrolled_units`) VALUES
(2, 'admin', 'admin@admin.com', 'Not Enrolled', '$2y$10$sRvDkRxxVmEAqRnh2A/pVO4WCC89C.1MoGNdeIGXfv1LcyTwkAft6', NULL),
(3, 'admin', 'piyugorasiya20@gmail.com', 'Not Enrolled', '$2y$10$JW4No/vBMGjUjWUUw0hALul0PB7eU3fHIuW9korDPLzr4WBBWWuli', NULL),
(4, 'student', 'priyashi.mepani@gmail.com', 'Business Management, Graphic Design, Mobile App Development, Dig, Python Programming', '$2y$10$/dRxrWf4Ba456Hm54Rmuu.dQZzfU.k8HhCknXXbWFKO71np2buZOK', ' Data Structures | Leadership, Business Strategy | System Protection | Photoshop, Illustrator | Android Basics | SEO | Python Basics'),
(5, 'student', 'khrishilk@gmail.com', 'Data Science, Web Development', '$2y$10$Kxbewwtfuc12gk2MbjYhauXwLqeSAfUXorbEM5cyaNJViR0tlpdLO', 'Data Analysis, Data Visualization | HTML5, JavaScript'),
(11, 'student', 'hiranijiya91@gmail.com', 'Graphic Design', '$2y$10$SsoeyYfdX5I8Ng7RgockKuzDSFPiMvejh89b9geU5lti4XLxflVyG', 'Photoshop, Illustrator, Branding Design');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
