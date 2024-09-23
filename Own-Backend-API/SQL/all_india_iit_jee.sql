-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2024 at 12:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `all_india_iit_jee`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `booking_date` date NOT NULL,
  `otp` int(11) NOT NULL,
  `slot` varchar(255) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `email`, `phone`, `booking_date`, `otp`, `slot`, `booking_id`, `is_verified`, `created_at`) VALUES
(1, 'Ashutosh Kumar', 'ashutosh@gmail.com', '7827046470', '2024-09-05', 937470, 'morning', 'IITJEE777655', 1, '2024-09-05 08:02:58'),
(2, 'Ashutosh Kumar', 'ashutosh@gmail.com', '7827046470', '2024-09-05', 483440, 'morning', 'IITJEE895433', 1, '2024-09-05 08:11:03'),
(3, 'Ashutosh Kumar', 'ashutosh@gmail.com', '7827046470', '2024-09-05', 893682, 'morning', 'IITJEE626181', 1, '2024-09-05 08:14:06'),
(4, 'Ashutosh Kumar', 'mr.ashutoshkumargautam@gmail.com', '7827046470', '2024-09-05', 995640, 'morning', 'IITJEE787970', 1, '2024-09-05 08:14:28'),
(5, 'Ashutosh Kumar', 'mr.ashutoshkumargautam@gmail.com', '7827046470', '2024-09-05', 900841, 'morning', 'IITJEE458905', 1, '2024-09-05 08:16:08'),
(6, 'Ashutosh Kumar', 'mr.ashutoshkumargautam@gmail.com', '7827046470', '2024-09-05', 522610, 'morning', 'IITJEE297275', 1, '2024-09-05 09:20:26'),
(7, 'amit', 'amit.yadav.marketing@testbook.com', '7827046470', '2024-09-05', 257233, 'evening', 'IITJEE633202', 1, '2024-09-05 09:24:20'),
(8, 'Testing', 'ashish.raj@testbook.com', '08798798', '2024-09-05', 964541, 'morning', 'IITJEE153147', 1, '2024-09-05 09:46:38'),
(9, 'Ashutosh Kumar', 'ashutosh.s.kumar@testbook.com', '7827046470', '2024-09-05', 585969, 'morning', 'IITJEE830687', 1, '2024-09-05 13:35:05'),
(10, 'Ashutosh Kumar', 'ashutosh.s.kumar@testbook.com', '7827046470', '2024-09-06', 728994, 'morning', 'IITJEE154353', 1, '2024-09-06 08:34:30'),
(11, 'Ashutosh Kumar', 'ashutosh@gmail.com', '7827046470', '2024-09-06', 123628, 'morning', 'IITJEE762657', 1, '2024-09-06 10:47:35'),
(12, 'Ashutosh Kumar', 'ashutoshkumargautam@gmail.com', '7827046470', '2024-09-06', 711335, 'morning', 'IITJEE822088', 0, '2024-09-06 10:48:32'),
(13, 'Ashutosh Kumar', 'ashutosh@gmail.com', '7827046470', '2024-09-06', 108418, 'morning', 'IITJEE773784', 1, '2024-09-06 10:54:49'),
(14, 'Ashutosh Kumar', 'ashutosh@gmail.com', '7827046470', '2024-09-06', 599499, 'morning', 'IITJEE608040', 1, '2024-09-06 11:16:17'),
(15, 'Ashutosh Kumar', 'ashutosh@gmail.com', '7827046470', '2024-09-06', 159076, 'morning', 'IITJEE691901', 1, '2024-09-06 11:19:14'),
(16, 'Ashutosh Kumar', 'ashutosh@gmail.com', '9650797375', '2024-09-06', 634123, 'morning', 'IITJEE423662', 1, '2024-09-06 13:26:38'),
(17, 'Ashutosh Kumar', 'ashutosh.s.kumar@testbook.com', '7827046470', '2024-09-07', 602026, 'morning', 'IITJEE865420', 1, '2024-09-07 11:21:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
