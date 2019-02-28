-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2018 at 01:33 PM
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
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `amenity_no` int(255) NOT NULL,
  `hostel_no` int(255) NOT NULL,
  `amenity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`amenity_no`, `hostel_no`, `amenity`) VALUES
(1, 1, 'Wifi'),
(2, 1, 'Hot Shower'),
(3, 1505066674, 'Wifi'),
(4, 1505066674, 'Pool Table'),
(5, 1719975542, 'Wifi'),
(6, 1719975542, 'Play Room'),
(7, 1349612707, 'Free Parking'),
(8, 1349612707, 'Free Wifi'),
(9, 1349612707, 'Breakfast and Dinner'),
(10, 1349612707, 'Lunch on Weekends'),
(11, 1229930077, 'Wifi'),
(12, 1229930077, 'Hot shower'),
(13, 1781712626, 'test'),
(14, 1763611811, 'test'),
(15, 781554491, 'Wifi'),
(16, 1610837799, 'Food'),
(17, 1278073193, 'TV room'),
(18, 627792366, 'Wifi');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_no` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `hostel_no` int(255) NOT NULL,
  `room_chosen` varchar(255) NOT NULL,
  `no_sharing` varchar(255) NOT NULL,
  `total_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_no`, `user_id`, `hostel_no`, `room_chosen`, `no_sharing`, `total_price`) VALUES
(2, 10, 1, 'F2', '2', NULL),
(6, 9, 1, 'F3', '4', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_no` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `hostel_no` int(255) NOT NULL,
  `payment_via` varchar(255) NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `payment_for` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `refunded` int(11) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_no` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `review` text NOT NULL,
  `hostel_no` int(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_no`, `rating`, `review`, `hostel_no`, `user_id`) VALUES
(1, 4, 'Quite good', 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `hostel_no` int(255) NOT NULL,
  `no_sharing` int(255) NOT NULL,
  `monthly_rent` int(255) NOT NULL,
  `male_count` int(11) DEFAULT NULL,
  `female_count` int(11) DEFAULT NULL,
  `blocked_male` int(11) DEFAULT NULL,
  `blocked_female` int(11) DEFAULT NULL,
  `room_limit` int(11) NOT NULL,
  `current_capacity` int(11) NOT NULL,
  `total_capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`hostel_no`, `no_sharing`, `monthly_rent`, `male_count`, `female_count`, `blocked_male`, `blocked_female`, `room_limit`, `current_capacity`, `total_capacity`) VALUES
(1, 1, 10000, 0, 0, 0, 0, 2, 0, 2),
(1, 2, 8000, 0, 1, 0, 2, 2, 1, 4),
(1, 4, 7000, 0, 2, 0, 4, 4, 2, 16),
(1, 8, 2000, 0, 0, 0, 0, 2, 0, 16),
(627792366, 1, 9000, NULL, NULL, NULL, NULL, 2, 0, 2),
(781554491, 1, 4000, NULL, NULL, NULL, NULL, 3, 0, 3),
(781554491, 2, 2000, NULL, NULL, NULL, NULL, 3, 0, 6),
(1229930077, 3, 11500, NULL, NULL, NULL, NULL, 3, 0, 9),
(1229930077, 5, 10000, NULL, NULL, NULL, NULL, 5, 0, 25),
(1278073193, 1, 9000, NULL, NULL, NULL, NULL, 6, 0, 6),
(1349612707, 1, 15000, NULL, NULL, NULL, NULL, 10, 0, 10),
(1349612707, 2, 12500, NULL, NULL, NULL, NULL, 10, 0, 20),
(1505066674, 2, 10000, NULL, NULL, NULL, NULL, 5, 0, 10),
(1505066674, 4, 6000, NULL, NULL, NULL, NULL, 10, 0, 40),
(1610837799, 1, 9000, NULL, NULL, NULL, NULL, 2, 0, 2),
(1719975542, 1, 6000, NULL, NULL, NULL, NULL, 5, 0, 5),
(1719975542, 4, 4000, NULL, NULL, NULL, NULL, 5, 0, 20),
(1719975542, 8, 2000, NULL, NULL, NULL, NULL, 5, 0, 40),
(1763611811, 1, 2000, NULL, NULL, NULL, NULL, 1, 0, 1),
(1781712626, 1, 2500, NULL, NULL, NULL, NULL, 2, 0, 2),
(1781712626, 2, 3500, NULL, NULL, NULL, NULL, 2, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `room_allocation`
--

CREATE TABLE `room_allocation` (
  `hostel_no` int(255) NOT NULL,
  `room_no` varchar(255) NOT NULL,
  `wing` varchar(255) NOT NULL,
  `no_sharing` int(11) NOT NULL,
  `no_occupied` int(11) NOT NULL,
  `spaces` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room_allocation`
--

INSERT INTO `room_allocation` (`hostel_no`, `room_no`, `wing`, `no_sharing`, `no_occupied`, `spaces`) VALUES
(1, 'F1', 'female', 1, 0, 1),
(1, 'F2', 'female', 2, 1, 1),
(1, 'F3', 'female', 4, 2, 2),
(1, 'F4', 'female', 4, 0, 4),
(1, 'F5', 'female', 8, 0, 8),
(1, 'M1', 'male', 1, 0, 1),
(1, 'M2', 'male', 2, 0, 2),
(1, 'M3', 'male', 4, 0, 4),
(1, 'M4', 'male', 4, 0, 4),
(1, 'M5', 'male', 8, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `rule_no` int(255) NOT NULL,
  `hostel_no` int(255) NOT NULL,
  `rule` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`rule_no`, `hostel_no`, `rule`) VALUES
(1, 1, 'No drugs'),
(2, 1, 'No alcohol'),
(3, 1505066674, 'No drugs'),
(4, 1505066674, 'No visitors after 6 pm'),
(5, 1719975542, 'No drugs'),
(7, 1719975542, 'No alcohol'),
(8, 1349612707, 'No drugs'),
(9, 1349612707, 'No guests past 7pm'),
(10, 1229930077, 'No drugs'),
(11, 1229930077, 'No alcohol'),
(12, 1781712626, 'Test'),
(13, 1763611811, 'tset'),
(14, 781554491, 'No drugs'),
(15, 1610837799, 'None'),
(16, 1278073193, 'none'),
(17, 627792366, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_history`
--

CREATE TABLE `tenant_history` (
  `record_id` int(255) NOT NULL,
  `hostel_no` int(255) NOT NULL,
  `date_checked_in` datetime NOT NULL,
  `date_checked_out` datetime DEFAULT NULL,
  `blacklist` int(1) NOT NULL,
  `reason` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant_history`
--

INSERT INTO `tenant_history` (`record_id`, `hostel_no`, `date_checked_in`, `date_checked_out`, `blacklist`, `reason`) VALUES
(44332413, 1, '2018-10-11 13:20:47', '2018-10-11 13:23:53', 0, NULL),
(47052368, 1, '2018-10-13 20:50:59', '2018-10-13 21:33:58', 0, NULL),
(147251179, 1, '2018-10-13 23:00:09', '2018-10-13 23:08:25', 0, NULL),
(150006956, 1, '2018-10-13 23:01:07', '2018-10-13 23:08:38', 0, NULL),
(158525448, 1, '2018-10-13 23:00:25', '2018-10-13 23:08:33', 0, NULL),
(178189244, 1, '2018-10-13 23:30:28', '2018-10-14 00:21:15', 0, NULL),
(179806173, 1, '2018-10-27 02:43:09', '2018-10-31 13:35:07', 0, NULL),
(211394068, 1, '2018-10-12 22:17:45', '2018-10-12 22:56:05', 0, NULL),
(219328924, 1, '2018-10-13 23:30:06', '2018-10-14 14:40:13', 0, NULL),
(304527994, 1, '2018-10-22 11:40:50', '2018-10-22 17:51:27', 0, NULL),
(308253415, 1, '2018-10-27 01:55:55', '2018-10-27 02:05:17', 0, NULL),
(318013527, 1, '2018-10-13 23:30:14', '2018-10-14 09:56:49', 0, NULL),
(349266956, 1, '2018-10-27 21:10:58', NULL, 0, NULL),
(361371341, 1, '2018-10-18 14:53:08', '2018-10-18 14:56:05', 0, NULL),
(432607006, 1, '2018-10-22 11:03:04', NULL, 0, NULL),
(465532335, 1, '2018-10-18 14:57:20', '2018-10-18 14:57:33', 0, NULL),
(609559336, 1, '2018-10-13 20:50:17', '2018-10-13 20:50:42', 0, NULL),
(625004341, 1, '2018-10-31 15:32:21', '2018-10-31 15:32:31', 0, NULL),
(678878701, 1, '2018-10-14 23:16:59', '2018-10-14 23:52:09', 0, NULL),
(723322422, 1, '2018-10-11 11:09:17', '2018-10-11 13:12:17', 0, NULL),
(725555398, 1, '2018-10-15 17:44:05', '2018-10-15 17:48:06', 0, NULL),
(750720448, 1, '2018-10-13 23:10:40', '2018-10-13 23:13:57', 0, NULL),
(766283096, 1, '2018-10-14 22:54:02', '2018-10-14 22:57:06', 0, NULL),
(772173909, 1, '2018-10-18 13:52:33', '2018-10-18 13:53:15', 0, NULL),
(784299452, 1, '2018-10-18 13:46:11', '2018-10-18 13:56:33', 0, NULL),
(793691730, 1, '2018-10-13 21:37:38', '2018-10-13 21:37:50', 0, NULL),
(815684267, 1, '2018-10-27 02:09:31', '2018-10-27 02:12:20', 0, NULL),
(839788006, 1, '2018-10-18 14:54:43', '2018-10-18 14:56:02', 0, NULL),
(892347864, 1, '2018-10-13 21:43:12', '2018-10-13 21:43:21', 0, NULL),
(923640848, 1, '2018-10-18 13:48:08', '2018-10-18 13:52:05', 0, NULL),
(932343495, 1, '2018-10-15 00:19:41', '2018-10-15 00:21:06', 0, NULL),
(952353101, 1, '2018-10-18 14:42:19', '2018-10-18 14:42:24', 0, NULL),
(977977750, 1, '2018-10-18 14:53:27', '2018-10-18 14:56:08', 0, NULL),
(1002458864, 1, '2018-10-22 18:01:17', '2018-10-22 18:01:37', 0, NULL),
(1029195321, 1, '2018-10-26 12:46:34', '2018-10-26 12:46:41', 0, NULL),
(1040944589, 1, '2018-10-14 23:43:40', '2018-10-15 10:25:32', 0, NULL),
(1068441984, 1, '2018-10-18 14:20:11', '2018-10-18 14:32:46', 0, NULL),
(1149700519, 1, '2018-10-14 22:57:14', '2018-10-14 22:58:25', 0, NULL),
(1159857484, 1, '2018-10-22 18:16:40', '2018-10-25 10:02:13', 0, NULL),
(1187670445, 1, '2018-10-14 19:08:09', '2018-10-14 19:11:38', 0, NULL),
(1209968805, 1, '2018-10-14 23:44:17', '2018-10-14 23:47:02', 0, NULL),
(1237210053, 1, '2018-10-13 23:10:10', '2018-10-13 23:13:53', 0, NULL),
(1240462250, 1, '2018-10-13 21:49:09', '2018-10-13 21:49:15', 0, NULL),
(1260059765, 1, '2018-10-15 00:38:50', '2018-10-15 10:25:35', 0, NULL),
(1335576373, 1, '2018-10-18 14:29:04', '2018-10-18 14:31:49', 0, NULL),
(1341480783, 1, '2018-10-31 14:39:07', '2018-10-31 14:39:14', 0, NULL),
(1352967846, 1, '2018-10-13 23:00:37', '2018-10-13 23:08:30', 0, NULL),
(1356602921, 1, '2018-10-13 23:10:29', '2018-10-13 23:14:03', 0, NULL),
(1358393542, 1, '2018-10-25 21:24:41', '2018-10-25 21:24:48', 0, NULL),
(1424621101, 1, '2018-10-14 23:00:49', '2018-10-14 23:38:42', 0, NULL),
(1431281150, 1, '2018-10-18 14:18:48', '2018-10-18 14:33:14', 0, NULL),
(1457557629, 1, '2018-10-31 14:42:32', '2018-10-31 14:42:39', 0, NULL),
(1470303694, 1, '2018-10-25 10:02:58', '2018-10-27 20:50:13', 0, NULL),
(1499344096, 1, '2018-10-18 14:57:28', '2018-10-18 14:57:36', 0, NULL),
(1499775141, 1, '2018-10-18 14:46:56', '2018-10-18 14:47:00', 0, NULL),
(1502881556, 1, '2018-10-15 17:40:56', '2018-10-15 17:41:30', 0, NULL),
(1526045623, 1, '2018-10-14 00:22:06', '2018-10-14 14:40:08', 0, NULL),
(1590621102, 1, '2018-10-26 12:34:27', '2018-10-26 12:34:40', 0, NULL),
(1642221689, 1, '2018-10-15 00:23:42', '2018-10-15 00:23:50', 0, NULL),
(1693842655, 1, '2018-10-18 13:43:36', '2018-10-18 13:45:52', 0, NULL),
(1758422956, 1, '2018-10-15 00:25:31', '2018-10-15 00:37:19', 0, NULL),
(1763928837, 1, '2018-10-14 22:45:34', '2018-10-14 22:46:40', 0, NULL),
(1770680512, 1, '2018-10-18 13:43:10', '2018-10-18 14:05:25', 0, NULL),
(1803241506, 1, '2018-10-14 09:57:01', '2018-10-14 13:20:48', 0, NULL),
(1805754031, 1, '2018-10-14 23:51:58', '2018-10-15 10:25:28', 0, NULL),
(1810260288, 1, '2018-10-13 21:38:04', '2018-10-13 21:38:48', 0, NULL),
(1820631937, 1, '2018-10-14 22:59:13', '2018-10-14 23:00:45', 0, NULL),
(1829935726, 1, '2018-10-26 12:46:56', '2018-10-26 12:47:02', 0, NULL),
(1834243063, 1, '2018-10-18 13:45:35', '2018-10-18 14:05:21', 0, NULL),
(1852852613, 1, '2018-10-14 11:34:05', '2018-10-14 11:34:29', 0, NULL),
(1867900093, 1, '2018-10-15 11:26:16', '2018-10-15 11:30:44', 0, NULL),
(1915643371, 1, '2018-10-27 22:14:56', NULL, 0, NULL),
(1931033239, 1, '2018-10-15 17:48:53', '2018-10-15 17:50:35', 0, NULL),
(1934813928, 1, '2018-10-26 12:41:51', '2018-10-26 12:46:18', 0, NULL),
(1939158273, 1, '2018-10-26 15:08:08', '2018-10-26 15:08:46', 0, NULL),
(1967836630, 1, '2018-10-13 23:10:23', '2018-10-13 23:14:00', 0, NULL),
(2057537329, 1, '2018-10-18 14:21:07', '2018-10-18 14:21:11', 0, NULL),
(2063244107, 1, '2018-10-14 23:58:38', '2018-10-15 00:08:28', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_history_bridge`
--

CREATE TABLE `tenant_history_bridge` (
  `user_id` int(255) NOT NULL,
  `record_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant_history_bridge`
--

INSERT INTO `tenant_history_bridge` (`user_id`, `record_id`) VALUES
(2, 147251179),
(2, 178189244),
(2, 179806173),
(2, 308253415),
(2, 625004341),
(2, 725555398),
(2, 815684267),
(2, 952353101),
(2, 977977750),
(2, 1002458864),
(2, 1029195321),
(2, 1068441984),
(2, 1237210053),
(2, 1260059765),
(2, 1341480783),
(2, 1358393542),
(2, 1457557629),
(2, 1499775141),
(2, 1590621102),
(2, 1642221689),
(2, 1758422956),
(2, 1770680512),
(2, 1803241506),
(2, 1829935726),
(2, 1934813928),
(2, 1939158273),
(7, 44332413),
(7, 304527994),
(7, 349266956),
(7, 784299452),
(7, 1159857484),
(7, 1209968805),
(7, 1352967846),
(7, 1356602921),
(7, 1470303694),
(7, 1526045623),
(7, 1693842655),
(7, 1805754031),
(7, 2057537329),
(9, 158525448),
(9, 318013527),
(9, 465532335),
(9, 1040944589),
(9, 1187670445),
(9, 1424621101),
(9, 1502881556),
(9, 1820631937),
(9, 1834243063),
(9, 1852852613),
(9, 1867900093),
(9, 1915643371),
(9, 1967836630),
(10, 47052368),
(10, 150006956),
(10, 211394068),
(10, 219328924),
(10, 432607006),
(10, 609559336),
(10, 678878701),
(10, 723322422),
(10, 750720448),
(10, 766283096),
(10, 793691730),
(10, 839788006),
(10, 892347864),
(10, 923640848),
(10, 932343495),
(10, 1149700519),
(10, 1240462250),
(10, 1335576373),
(10, 1763928837),
(10, 1810260288),
(10, 1931033239),
(10, 2063244107),
(11, 361371341),
(11, 772173909),
(11, 1431281150),
(11, 1499344096);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `country_code` varchar(11) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `user_status` varchar(255) DEFAULT NULL,
  `room_assigned` varchar(255) DEFAULT NULL,
  `no_sharing` varchar(255) DEFAULT NULL,
  `total_paid` int(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pwd`, `country_code`, `phone_no`, `gender`, `user_type`, `user_status`, `room_assigned`, `no_sharing`, `total_paid`, `blocked`) VALUES
(2, 'Jerry', 'Auvagha', 'jerrybenjamin007@gmail.com', '$2y$10$xkyZ0K2sjoHeljV3qVu9hOCA9FBXO5v9hDNTNhHRqXdUrkW3OLeme', '254', '722309497', 'male', 'Student', NULL, NULL, NULL, NULL, 0),
(3, 'Jerry', 'Auvagha', 'jerry.auvagha@strathmore.edu', '$2y$10$uSjIcP2.1ueDeWLu3OJmN.GCxgRAS6xOsDI7FftI9CPxXTxuqXP92', '254', '722309497', 'male', 'Hostel Owner', 'NULL', '', NULL, NULL, 0),
(4, 'John ', 'Doe', 'john.doe@strathmore.edu', '$2y$10$o1x0Fh561Cckc/lu5sSGFeCrhillF9RqFi.V4uMnjCAb8GnGq4R2C', '254', '722319498', 'male', 'Hostel Owner', NULL, '', NULL, NULL, 0),
(5, 'Jane', 'Doe', 'jane.doe@strathmore.edu', '$2y$10$jSF8k.4raXnCOZeagqD/rOlhLUrk1ZSR8pXZR9QX55308WcFWpySu', '254', '722319498', 'female', 'Hostel Owner', 'NULL', 'NULL', NULL, NULL, 0),
(6, 'Jane', 'Does', 'jane.does@strathmore.edu', '$2y$10$3Cf4lM4z66fDDwsSD5IiY.1wo9Uahs0pnBgBTWfgpUfy9PrtfHNJq', '254', '722319498', 'female', 'Hostel Owner', NULL, '', NULL, NULL, 0),
(7, 'Jane', 'Does', 'jane.does2@strathmore.edu', '$2y$10$ejmRYOyNqg1lGnhubYdSAuOhDsTcUOjBkQx.ZlXiUvQF27exjtSpG', '254', '722319898', 'female', 'Student', 'Tenant', 'F3', '4', NULL, 0),
(9, 'Rose', 'Njeri', 'rnjeri@kenindia.com', '$2y$10$iNJ5dyYb4dGFKYsWStxFQ.AsySRo/9d.3R6LoYLa0cwXAcMVSXuD2', '254', '721266332', 'female', 'Student', 'Tenant', 'F1', '1', NULL, 1),
(10, 'Mizzy', 'Bee', 'mizzy.bee@gmail.com', '$2y$10$j9CGxquS266NcA/oG/vKe.8/16WkBCaOug.8cXWosbCUhpYWMlmga', '254', '722319490', 'female', 'Student', 'Tenant', 'F2', '2', NULL, 0),
(11, 'Miriam', 'Mmboga', 'mmbogamiriam2@gmail.com', '$2y$10$HHNxYXPPXHGozA0kHeHtie5k.KB3KxHFK8KoAFWakE8O3GOCUOTLG', '254', '705793148', 'female', 'Student', NULL, NULL, NULL, NULL, 0),
(12, 'Afandi ', 'Indiatsi', 'gindiazi@gmail.com', '$2y$10$kGfX0cM9CZjB8Pph4qskpO7dia2OOJB8WQb/qrUzD9xgT7jb4m7RS', '254', '700900000', 'female', 'Admin', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_hostel_bridge`
--

CREATE TABLE `user_hostel_bridge` (
  `user_id` int(255) NOT NULL,
  `hostel_no` int(255) NOT NULL,
  `record_id` int(255) DEFAULT NULL,
  `logged_once` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_hostel_bridge`
--

INSERT INTO `user_hostel_bridge` (`user_id`, `hostel_no`, `record_id`, `logged_once`) VALUES
(3, 1, NULL, NULL),
(3, 781554491, NULL, NULL),
(3, 1229930077, NULL, NULL),
(3, 1610837799, NULL, NULL),
(3, 1719975542, NULL, NULL),
(3, 1763611811, NULL, NULL),
(3, 1781712626, NULL, NULL),
(4, 1349612707, NULL, NULL),
(4, 1505066674, NULL, NULL),
(5, 1, NULL, NULL),
(6, 627792366, NULL, NULL),
(6, 1278073193, NULL, NULL),
(7, 1, 349266956, NULL),
(9, 1, 1915643371, NULL),
(10, 1, 432607006, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_bridge`
--

CREATE TABLE `user_payment_bridge` (
  `user_id` int(255) NOT NULL,
  `payment_no` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`amenity_no`),
  ADD KEY `hostel_no` (`hostel_no`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_no`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hostel_no` (`hostel_no`);

--
-- Indexes for table `hostels`
--
ALTER TABLE `hostels`
  ADD PRIMARY KEY (`hostel_no`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_no`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hostel_no` (`hostel_no`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_no`),
  ADD KEY `hostel_no` (`hostel_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD UNIQUE KEY `hostel_no_2` (`hostel_no`,`no_sharing`),
  ADD KEY `hostel_no` (`hostel_no`) USING BTREE;

--
-- Indexes for table `room_allocation`
--
ALTER TABLE `room_allocation`
  ADD UNIQUE KEY `hostel_no_2` (`hostel_no`,`room_no`),
  ADD KEY `hostel_no` (`hostel_no`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`rule_no`),
  ADD KEY `hostel_no` (`hostel_no`);

--
-- Indexes for table `tenant_history`
--
ALTER TABLE `tenant_history`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `hostel_no` (`hostel_no`);

--
-- Indexes for table `tenant_history_bridge`
--
ALTER TABLE `tenant_history_bridge`
  ADD UNIQUE KEY `user_id_2` (`user_id`,`record_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `record_id` (`record_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_hostel_bridge`
--
ALTER TABLE `user_hostel_bridge`
  ADD UNIQUE KEY `user_id_2` (`user_id`,`hostel_no`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hostel_no` (`hostel_no`);

--
-- Indexes for table `user_payment_bridge`
--
ALTER TABLE `user_payment_bridge`
  ADD UNIQUE KEY `user_id_2` (`user_id`,`payment_no`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_no` (`payment_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `amenity_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `hostels`
--
ALTER TABLE `hostels`
  MODIFY `hostel_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1781712627;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_no` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `rule_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tenant_history`
--
ALTER TABLE `tenant_history`
  MODIFY `record_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2063244108;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenities`
--
ALTER TABLE `amenities`
  ADD CONSTRAINT `amenities_ibfk_1` FOREIGN KEY (`hostel_no`) REFERENCES `hostels` (`hostel_no`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hostel_no`) REFERENCES `hostels` (`hostel_no`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`hostel_no`) REFERENCES `hostels` (`hostel_no`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hostel_no`) REFERENCES `hostels` (`hostel_no`);

--
-- Constraints for table `room_allocation`
--
ALTER TABLE `room_allocation`
  ADD CONSTRAINT `room_allocation_ibfk_1` FOREIGN KEY (`hostel_no`) REFERENCES `hostels` (`hostel_no`);

--
-- Constraints for table `rules`
--
ALTER TABLE `rules`
  ADD CONSTRAINT `rules_ibfk_1` FOREIGN KEY (`hostel_no`) REFERENCES `hostels` (`hostel_no`);

--
-- Constraints for table `tenant_history_bridge`
--
ALTER TABLE `tenant_history_bridge`
  ADD CONSTRAINT `tenant_history_bridge_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `tenant_history_bridge_ibfk_2` FOREIGN KEY (`record_id`) REFERENCES `tenant_history` (`record_id`);

--
-- Constraints for table `user_hostel_bridge`
--
ALTER TABLE `user_hostel_bridge`
  ADD CONSTRAINT `user_hostel_bridge_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_hostel_bridge_ibfk_2` FOREIGN KEY (`hostel_no`) REFERENCES `hostels` (`hostel_no`);

--
-- Constraints for table `user_payment_bridge`
--
ALTER TABLE `user_payment_bridge`
  ADD CONSTRAINT `user_payment_bridge_ibfk_1` FOREIGN KEY (`payment_no`) REFERENCES `payments` (`payment_no`),
  ADD CONSTRAINT `user_payment_bridge_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
