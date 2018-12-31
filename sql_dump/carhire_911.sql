-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2018 at 09:56 AM
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
-- Database: `carhire_911`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `colour` varchar(255) NOT NULL,
  `plate_no` varchar(255) NOT NULL,
  `base_price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `features` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `category`, `brand`, `model`, `colour`, `plate_no`, `base_price`, `image`, `status`, `features`) VALUES
(1, 'Sedan', 'Mercedes Benz', 'S 550', 'black', 'KCF 990J', 9000, 'mercedes-s550.jpg\r\n', 'available', 'Air conditioning\r\nGreat control\r\nGreat Chassis\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(1, 'Sales'),
(2, 'Accounts'),
(3, 'Inventory');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `logged_once` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `department_id`, `logged_once`) VALUES
(3, 2, 0),
(4, 1, 0),
(5, 2, 0),
(6, 1, 0),
(7, 2, 0),
(14, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `location_fee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `location_fee`) VALUES
(1, 'Nairobi office', 0),
(2, 'JKIA', 1500),
(3, 'Wilson Airport', 1000),
(4, 'Madaraka Express - Nairobi Terminus', 500),
(5, 'Mombasa Main Office', 0),
(6, 'Moi International Airport', 1500),
(7, 'Bamburi Airport', 1000),
(8, 'Madaraka Express - Mombasa Terminus', 500);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `res_no` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `pickup_location_id` int(11) NOT NULL,
  `return_location_id` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date NOT NULL,
  `mileage_onpick` int(11) DEFAULT NULL,
  `mileage_onreturn` int(11) DEFAULT NULL,
  `extra_mileage_fee` int(11) DEFAULT NULL,
  `extra_feat_fee` int(11) DEFAULT NULL,
  `amount_due` int(11) NOT NULL,
  `amount_paid` int(11) DEFAULT NULL,
  `car_condition` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_no` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL,
  `date_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `password`, `user_type`, `date_reg`) VALUES
(3, 'Janey', 'Rogers', 'janey.rogers@gmail.com', '$2y$10$kL.QHD2AeNewKZdtdMFdqOPHiPuNBeAgY1bJ43LNMQPGmBnqnyx.K', 'employee', '2018-09-29 11:23:49'),
(4, 'Ng\'ang\'alito', 'Njunguna', 'conman@gmail.com', '$2y$10$y4k1vBgWwzKJJ0QxbXozGuM.d6G1.v98ii7pafaYGIf.XhVeHZ0SO', 'employee', '2018-09-29 11:26:15'),
(5, 'Dean', 'Lewis', 'dean.lewis@gmail.com', '$2y$10$MD97qkycavXctgeJ8xUHfe5eWBPC4ju91QyfCnhdusT3nHZpqnDtu', 'employee', '2018-09-29 13:09:45'),
(6, 'David', 'Jones', 'djone@gmail.com', '$2y$10$UKaJxMZ/Xbn1/rlDaOW8EO3HkrjcXxlCNkcqCtG1XN7lI/400K9iC', 'employee', '2018-09-29 14:39:22'),
(7, 'Montreal ', 'Canada', 'cancan@gmail.com', '$2y$10$zbRBvkB2n1A5GsuGjJgBb.PHeWV87QeMKYFdzmpsSunJHEa0NWeva', 'employee', '2018-09-29 14:41:36'),
(14, 'James', 'Thurber', 'jaymo@gmail.com', '$2y$10$I32RI8CH4AswwvBhAhz8ge.xFPEeN3S5mAGxftLTHivlvVYBSS5Hi', 'employee', '2018-09-29 20:16:30'),
(16, 'Mike', 'Lowrey', 'mike.lowrey@gmail.com', '$2y$10$ebi/jMfOanCHKbbB3s1tMerDGfadJKDJ9u8F5S3u5kjvlqiimAKMy', 'customer', '2018-10-03 20:12:38'),
(17, 'Marcus ', 'Rashford', 'marcus.rashford@gmail.com', '$2y$10$I4IS2lAkFY5ZjLpASBN16ewpCIZ5DHQN82lN.dqxBsGQWYiDBmFka', 'customer', '2018-10-04 05:06:02'),
(18, 'Fidhrosa', 'Khalifa', 'fidhrosa@gmail.com', '$2y$10$iagfbIRBjGCok4guyN/.lurxQX6HG2xcEwjTwwXTS6vJ0yX3E05za', 'customer', '2018-10-04 05:12:48'),
(22, 'Amader', 'Tuni', 'amader.tuni@gmail.com', '$2y$10$vS1kqR..NUdwihYoESnSJO0bwTRDkwCZoVu4iBkeIgu8noq/evrz6', 'customer', '2018-10-05 15:13:57'),
(23, 'Alex', 'Tuntuni Smith', 'alex.smith@gmail.com', '$2y$10$Yvck9fzt3YeQRIDFVaSiN.2m0hXqmq/jOJuKkzBufR6rzXLSBvnxW', 'customer', '2018-10-05 17:58:30'),
(24, 'Jerry', 'Auvagha', 'jerry.auvagha@strathmore.edu', '$2y$10$pMokbTRAhfQoNa2B5iFnzuHmW/ru7fTVkgWaaZy24jPhC7e/cVblq', 'customer', '2018-10-06 19:43:42'),
(26, 'Jerry', 'Auvagha', 'jerrybenjamin007@gmail.com', '$2y$10$Qs0HFtHeVTCKhY1kTsRRVeMoWyiv02RRqFDdFdjUQFtHpemk8dZES', 'customer', '2018-10-06 20:24:06'),
(27, 'Gareth', 'Bale', 'gareth.bale@gmail.com', '$2y$10$2nU7yJc9Ahv8aPnST8SrgOWTnJeUmnyyo5y3AzMTQmWw9hsEwPy3m', 'customer', '2018-10-07 07:39:24'),
(29, 'Amanda', 'Gosling', 'amanda.gosling@gmail.com', '$2y$10$vMPjXyapvZUAX8cdkOigGuvfZohEsPMxl6iulzoDeqPzzpttapyX.', 'customer', '2018-10-07 07:48:18'),
(30, 'Johhny', 'Depp', 'sparrow@gmail.com', '$2y$10$0j1gqoVSt4obMxOJ0WEDdut861XG6Po/hcEucDtfVNK/M3KDaSpga', '1', '2018-10-21 20:24:09'),
(31, 'Julie', 'Chen', 'julie.chen@thetalk.com', '$2y$10$79/DOYS2Cl0chdSUA.2/JeZZ6ByW56jpSSmUBagEshI7tSWYmZ.dq', '1', '2018-10-21 20:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_reservation_bridge`
--

CREATE TABLE `user_reservation_bridge` (
  `user_id` int(11) NOT NULL,
  `res_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`res_no`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `pickup_location_id` (`pickup_location_id`),
  ADD KEY `return_location_id` (`return_location_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_no`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_reservation_bridge`
--
ALTER TABLE `user_reservation_bridge`
  ADD KEY `user` (`user_id`),
  ADD KEY `car_id` (`res_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `res_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`),
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`pickup_location_id`) REFERENCES `locations` (`location_id`),
  ADD CONSTRAINT `reservations_ibfk_5` FOREIGN KEY (`return_location_id`) REFERENCES `locations` (`location_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `user_reservation_bridge`
--
ALTER TABLE `user_reservation_bridge`
  ADD CONSTRAINT `user_reservation_bridge_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_reservation_bridge_ibfk_2` FOREIGN KEY (`res_no`) REFERENCES `reservations` (`res_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
