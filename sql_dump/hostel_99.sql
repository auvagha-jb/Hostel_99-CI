-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2019 at 08:38 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel_99`
--

-- --------------------------------------------------------

--
-- Table structure for table `hostels`
--

CREATE TABLE `hostels` (
  `hostel_no` int(255) NOT NULL,
  `hostel_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `road` varchar(255) NOT NULL,
  `county` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `total_available` int(11) DEFAULT NULL,
  `total_occupied` int(11) DEFAULT NULL,
  `vacancies` int(11) DEFAULT NULL,
  `avg_rating` float DEFAULT NULL,
  `total_rating` int(11) DEFAULT NULL,
  `blacklist` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hostels`
--

INSERT INTO `hostels` (`hostel_no`, `hostel_name`, `description`, `location`, `road`, `county`, `type`, `image`, `total_available`, `total_occupied`, `vacancies`, `avg_rating`, `total_rating`, `blacklist`) VALUES
(1, 'Mock Hostel', 'Test Hostel', 'Madaraka', 'Ole Sangale Rd', 'Nairobi', 'Mixed', 'westlands-backpackers.jpg', 36, 3, 33, 4, 4, 0),
(627792366, 'testing3', 'test', 'test', 'test', 'test', 'Male', 'Route print 2.png', 2, 0, 2, NULL, NULL, 1),
(781554491, 'Test2', 'test', 'Nairobi west', 'Test', 'Nairobi', 'Mixed', 'rc-two.jpg', 9, 0, 9, NULL, NULL, 0),
(1229930077, 'Yale Kids', 'A quiet serene environment for college going students. Premium quality at economy prices.', 'Nairobi West', 'Lang\'ata Road', 'Nairobi', 'Mixed', 'westlands-backpackers.jpg', 34, 0, 34, NULL, NULL, 0),
(1278073193, 'testing2', 'test ', 'test', 'test', 'test', 'Female', 'Route print 2.png', 6, 0, 6, NULL, NULL, 0),
(1349612707, 'Travelers Oasis', 'Located in Nairobi, within 8 km of Kenyatta International Conference Centre and 10 km of Nairobi National Museum, Travelers oasis offers accommodation with a shared lounge. Located around 1.8 km from Century Cinemax Junction, the hostel is also 1.8 km awa', 'Westlands ', 'Westlands Rd.', 'Nairobi', 'Mixed', 'travelers-oasis.jpg', 30, 0, 30, NULL, NULL, 0),
(1505066674, 'John\'s Hostel', 'A quiet riverside hostel dedicated to giving premium accommodation to students.', 'Eastleigh', 'First Avenue', 'Nairobi', 'Mixed', 'john\'s-hostel-two.jpg', 50, 0, 50, NULL, NULL, 0),
(1610837799, 'testing', 'test', 'Nai', 'test', 'Nairobi', 'Male', 'Route print 2.png', 2, 0, 2, NULL, NULL, 0),
(1719975542, 'Rich Kids and Co', 'Comfortable living made cheaper.\r\n', 'Westlands', 'Waiyaki Way', 'Nairobi', 'Mixed', 'rc-three.jpg', 65, 0, 65, NULL, NULL, 0),
(1763611811, 'test', 'test', 'test', 'test', 't', 'Female', 'rc-two.jpg', 1, 0, 1, NULL, NULL, 0),
(1781712626, 'Test Hostel', 'Test', 'Test', 'test', 'Test', 'Mixed', 'rc-two.jpg', 6, 0, 6, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hostels`
--
ALTER TABLE `hostels`
  ADD PRIMARY KEY (`hostel_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hostels`
--
ALTER TABLE `hostels`
  MODIFY `hostel_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1781712627;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
