-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2023 at 09:11 PM
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
-- Database: `bahia`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `role`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin'),
(7, 'xmts', '10bbd75d711b60e9e9c89c169381b09c4da114fb', 'admin'),
(11, 'staff', '6ccb4b7c39a6e77f76ecfa935a855c6c46ad5611', 'staff'),
(12, 'Bahia', '7b902e6ff1db9f560443f2048974fd7d386975b0', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `id` int(100) NOT NULL,
  `batch_num` int(100) NOT NULL DEFAULT 2,
  `pid` int(100) NOT NULL,
  `batch_price` int(10) NOT NULL,
  `batch_stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `batch_num`, `pid`, `batch_price`, `batch_stock`) VALUES
(1, 2, 21, 210, 0),
(2, 3, 21, 250, 3),
(3, 4, 21, 123, 6),
(4, 2, 13, 123, 3),
(5, 3, 13, 300, 10),
(6, 4, 13, 350, 10);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `booking_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `rooms` int(1) NOT NULL,
  `check_in` varchar(10) NOT NULL,
  `check_out` varchar(10) NOT NULL,
  `adults` int(1) NOT NULL,
  `childs` int(1) NOT NULL,
  `category` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `method` varchar(50) NOT NULL,
  `proof` varchar(100) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `booking_id`, `name`, `email`, `number`, `rooms`, `check_in`, `check_out`, `adults`, `childs`, `category`, `payment_status`, `method`, `proof`, `price`) VALUES
(57, '37', 'rz6My', 'Red Dalunos', 'rdalunos20@gmail.com', '0956996199', 2, '2023-07-14', '2023-07-14', 1, 0, 'Standard', 'Not Paid', 'PAY UPON CHECK IN', 'PAYUPONCHECKIN', 2995),
(58, '37', 'tFBRG', 'Red Dalunos', 'rdalunos20@gmail.com', '0956996199', 1, '2023-07-14', '2023-07-14', 1, 0, 'Deluxe', 'Paid', 'ONLINEPAYMENT', 'tFBRG_proof.jpg', 4000);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `fee` int(10) NOT NULL,
  `address` varchar(250) NOT NULL,
  `batch` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_img` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `cat_img`, `price`, `details`) VALUES
(14, 'Standard', 'Standard_cat.jpg', 2995, 'May kama'),
(15, 'Deluxe', 'Deluxe_cat.jpg', 4000, 'eto din may kama'),
(16, 'Premium', 'Premium_cat.jpg', 5000, 'lalo na to');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(100) NOT NULL,
  `city_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`) VALUES
(1, 'Caloocan'),
(2, 'Las Piñas');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `event` varchar(255) NOT NULL,
  `log` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `username`, `event`, `log`, `date`) VALUES
(147, '', 'Remove Feedback', 'Removed feedback of erismendoza21@gmail.com', '2023-07-13 08:27:37'),
(148, 'admin', 'deleted User Account', 'deleted user account ERIS', '2023-07-13 08:34:54'),
(149, 'admin', 'deleted User Account', 'deleted user account test', '2023-07-13 08:35:20'),
(150, 'admin', 'Removed bookings', 'Removed booking no.nNZpo', '2023-07-13 12:38:16'),
(151, 'admin', 'Removed bookings', 'Removed booking no.nNZpo', '2023-07-13 12:42:53'),
(152, 'admin', 'Removed bookings', 'Removed booking no.nNZpo', '2023-07-13 12:44:57'),
(153, 'admin', 'Removed bookings', 'Removed booking no.nNZpo', '2023-07-13 12:59:42'),
(154, 'admin', 'Removed bookings', 'Removed booking no.nNZpo', '2023-07-13 13:09:49'),
(155, 'admin', 'Removed bookings', 'Removed booking no.nNZpo', '2023-07-13 13:26:02'),
(156, 'admin', 'Update Category', 'Updated the Category image of Standard', '2023-07-13 14:42:38'),
(157, 'admin', 'Update Category', 'Updated the Category image of Deluxe', '2023-07-13 14:43:29'),
(158, 'admin', 'Update Category', 'Updated the Category image of Premium', '2023-07-13 14:43:36'),
(159, 'admin', 'Removed bookings', 'Removed booking no.XnVnM', '2023-07-13 17:59:19'),
(160, 'admin', 'Deactivate User Account', 'Deactivate user account Red Dalunos', '2023-07-13 18:07:10'),
(161, 'admin', 'Deactivate User Account', 'Deactivate user account eris', '2023-07-13 18:07:34'),
(162, 'admin', 'deleted User Account', 'deleted user account eris', '2023-07-13 18:07:52'),
(163, 'admin', 'deleted User Account', 'deleted user account Red Dalunos', '2023-07-13 18:07:59'),
(164, 'admin', 'Removed bookings', 'Removed booking no.nVXTK', '2023-07-13 18:40:13'),
(165, 'admin', 'Removed bookings', 'Removed booking no.YqaN3', '2023-07-13 18:42:09'),
(166, 'admin', 'Removed bookings', 'Removed booking no.Sw1yJ', '2023-07-13 18:42:54'),
(167, 'admin', 'Removed bookings', 'Removed booking no.9CWez', '2023-07-13 18:43:55'),
(168, 'admin', 'Removed bookings', 'Removed booking no.sVEiP', '2023-07-13 18:44:00'),
(169, 'admin', 'Removed bookings', 'Removed booking no.rlzhL', '2023-07-13 18:49:00'),
(170, 'admin', 'Removed bookings', 'Removed booking no.sU5ZK', '2023-07-13 18:53:45'),
(171, 'admin', 'Removed bookings', 'Removed booking no.5wuU4', '2023-07-13 18:55:16'),
(172, 'admin', 'Removed bookings', 'Removed booking no.NSE0N', '2023-07-13 18:56:55'),
(173, 'admin', 'Removed bookings', 'Removed booking no.zCtgX', '2023-07-13 18:59:39'),
(174, 'admin', 'Update booking Status', 'Updated booking no.1 to Not Paid', '2023-07-13 19:00:33'),
(175, 'admin', 'Update booking Status', 'Updated booking no.1 to Paid', '2023-07-13 19:00:37'),
(176, 'admin', 'Removed bookings', 'Removed booking no.V77g8', '2023-07-13 19:01:23'),
(177, 'admin', 'Removed bookings', 'Removed booking no.qKRWJ', '2023-07-13 19:04:48'),
(178, 'admin', 'Add Admin Account', 'Added admin account Bahia', '2023-07-13 19:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(5, 34, 'Red Dalunos', 'rdalunos20@gmail.com', '09569961990', 'www');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `proof` varchar(100) NOT NULL,
  `fee` int(10) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_no` mediumtext NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `pids` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `proof`, `fee`, `address`, `total_products`, `total_price`, `placed_on`, `order_no`, `payment_status`, `pids`) VALUES
(5, 1, 'eris', '09265409224', 'erismendoza21@gmail.com', 'COD', '', 0, '01, #2, Corpuz, Banicain, olongapo, zambales, Philippines - 2022', 'HAND-CARFT GIFT BOX FOR YOUR LOVED ONE (250 x 1)', 250, '2023-03-11 14:22:52', '516998', 'Delivered', '16,'),
(6, 1, 'eris', '123231321', 'erismendoza21@gmail.com', 'COD', '', 0, '01, #2, Corpuz, Banicain, olongapo, zambales, Philippines - 2022', 'eris (10 x 1)stock (123 x 1)', 133, '2023-03-11 14:48:46', '745245', 'Pending', '0');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `review` varchar(255) NOT NULL,
  `rating` int(5) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `pid`, `user_id`, `review`, `rating`, `date`) VALUES
(8, 13, 12, 'Thank you for wonderful product!', 4, '2023-05-16');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(100) NOT NULL,
  `name` int(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `category` varchar(500) NOT NULL,
  `status` varchar(10) NOT NULL,
  `image_01` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `details`, `price`, `category`, `status`, `image_01`) VALUES
(24, 1, '1222', 5000, 'Deluxe', 'Occupied', '1_img1.jpg'),
(25, 2, '', 0, 'Standard', 'Occupied', '');

-- --------------------------------------------------------

--
-- Table structure for table `streets`
--

CREATE TABLE `streets` (
  `id` int(100) NOT NULL,
  `cid` int(100) NOT NULL,
  `street_name` varchar(500) NOT NULL,
  `deliv_fee` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `streets`
--

INSERT INTO `streets` (`id`, `cid`, `street_name`, `deliv_fee`) VALUES
(1, 1, '#169BaesaRoad', '40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `number` varchar(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `image` varchar(500) NOT NULL,
  `token` varchar(20) NOT NULL,
  `confirmation` int(1) NOT NULL DEFAULT 0,
  `deactive` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `number`, `address`, `image`, `token`, `confirmation`, `deactive`) VALUES
(32, 'test', 'test@test.com', '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', '12312321312', 'tes', '', 'd6b03552b1', 0, 1),
(36, 'Red Dalunos', '201911264@gordoncollege.edu.ph', 'a0bfce00c7df8f0e85a30ca75f1a9ca019b34968', '09777882882', '', '', '', 1, 0),
(37, 'Red Dalunos', 'rdalunos20@gmail.com', 'a0bfce00c7df8f0e85a30ca75f1a9ca019b34968', '09569961990', '', '', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `streets`
--
ALTER TABLE `streets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `streets`
--
ALTER TABLE `streets`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
