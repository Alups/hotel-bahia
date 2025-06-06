-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2023 at 07:00 AM
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
(11, 'staff', '6ccb4b7c39a6e77f76ecfa935a855c6c46ad5611', 'staff'),
(12, 'Bahia', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'admin'),
(13, 'Red', '38f078a81a2b033d197497af5b77f95b50bfcfb8', 'staff');

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
  `price` int(100) NOT NULL,
  `checkout` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_list`
--

CREATE TABLE `booking_list` (
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
  `price` int(100) NOT NULL,
  `checkout` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_list`
--

INSERT INTO `booking_list` (`id`, `user_id`, `booking_id`, `name`, `email`, `number`, `rooms`, `check_in`, `check_out`, `adults`, `childs`, `category`, `payment_status`, `method`, `proof`, `price`, `checkout`) VALUES
(2, '37', 'e2Lel', 'Red Dalunos', 'rdalunos20@gmail.com', '0956996199', 2, '2023-07-15', '2023-07-15', 1, 0, 'Standard', 'Paid', 'PAY UPON CHECK IN', 'PAYUPONCHECKIN', 2995, 1),
(4, '39', 'MGhms', 'Red Dalunos', 'rdalunos20@gmail.com', '0956996199', 2, '2023-07-15', '2023-07-15', 1, 0, 'Standard', 'Paid', 'PAY UPON CHECK IN', 'PAYUPONCHECKIN', 2990, 1);

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
(15, 'Deluxe', 'Deluxe_cat.jpg', 4000, 'eto din may kama'),
(16, 'Premium', 'Premium_cat.jpg', 5000, 'lalo na to'),
(17, 'Standard', 'Standard_cat.jpg', 2900, 'update ko lang test');

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
(186, 'Bahia', 'Removed bookings', 'Removed booking no.s1LSr', '2023-07-14 20:25:20'),
(187, 'Bahia', 'Update booking Status', 'Updated booking no.2 to Paid', '2023-07-14 20:29:12'),
(188, 'Bahia', 'Update booking Status', 'Updated booking no.2 to Not Paid', '2023-07-14 20:31:16'),
(189, 'Bahia', 'Removed bookings', 'Removed booking no.M81id', '2023-07-14 20:31:30'),
(190, 'Bahia', 'Removed bookings', 'Removed booking no.s1LSr', '2023-07-14 20:32:15'),
(191, 'Bahia', 'Removed bookings', 'Removed booking no.GOmpT', '2023-07-14 20:32:48'),
(192, 'Bahia', 'Removed bookings', 'Removed booking no.NEATX', '2023-07-14 20:34:00'),
(193, 'Bahia', 'Removed bookings', 'Removed booking no.NEATX', '2023-07-14 20:34:17'),
(194, 'Bahia', 'Removed bookings', 'Removed booking no.XCz1l', '2023-07-14 20:36:27'),
(195, 'Bahia', 'Removed bookings', 'Removed booking no.WS2JP', '2023-07-14 20:36:42'),
(196, 'Bahia', 'Removed bookings', 'Removed booking no.XCz1l', '2023-07-14 20:36:53'),
(197, 'Bahia', 'Removed bookings', 'Removed booking no.tdqTc', '2023-07-14 20:40:18'),
(198, 'Bahia', 'Removed bookings', 'Removed booking no.tdqTc', '2023-07-14 20:40:33'),
(199, 'Bahia', 'Removed bookings', 'Removed booking no.tdqTc', '2023-07-14 20:41:09'),
(200, 'Bahia', 'Removed bookings', 'Removed booking no.vq07X', '2023-07-14 20:41:56'),
(201, 'Bahia', 'Removed bookings', 'Removed booking no.e2Lel', '2023-07-14 20:42:01'),
(202, 'Bahia', 'Removed bookings', 'Removed booking no.vq07X', '2023-07-14 20:42:13'),
(203, 'Bahia', 'Deactivate User Account', 'Deactivate user account Red Dalunos', '2023-07-15 03:29:16'),
(204, 'Bahia', 'Deactivate User Account', 'Deactivate user account Red Dalunos', '2023-07-15 03:34:40'),
(205, 'Bahia', 'Add Product', 'Added new product 3', '2023-07-15 03:35:34'),
(206, 'Bahia', 'Add Product', 'Added new product 4', '2023-07-15 03:36:43'),
(207, 'Bahia', 'Remove room', 'Removed room 3', '2023-07-15 03:56:00'),
(208, 'Bahia', 'Remove room', 'Removed room 3', '2023-07-15 03:56:56'),
(209, 'Bahia', 'Add Product', 'Added new product 3', '2023-07-15 03:57:05'),
(210, 'Bahia', 'Remove room', 'Removed room 3', '2023-07-15 03:57:05'),
(211, 'Bahia', 'Remove room', 'Removed room 3', '2023-07-15 03:57:11'),
(212, 'Bahia', 'Remove room', 'Removed room 4', '2023-07-15 03:57:45'),
(213, 'Bahia', 'Remove room', 'Removed room 4', '2023-07-15 03:59:23'),
(214, 'Bahia', 'Add Product', 'Added new product 4', '2023-07-15 03:59:29'),
(215, 'Bahia', 'Remove room', 'Removed room 4', '2023-07-15 03:59:29'),
(216, 'Bahia', 'Remove room', 'Removed room 4', '2023-07-15 04:00:04'),
(217, 'Bahia', 'Remove room', 'Removed room 3', '2023-07-15 04:01:37'),
(218, 'Bahia', 'Remove room', 'Removed room 3', '2023-07-15 04:01:38'),
(219, 'Bahia', 'Remove room', 'Removed room 3', '2023-07-15 04:01:40'),
(220, 'Bahia', 'Remove room', 'Removed room 3', '2023-07-15 04:01:51'),
(221, 'Bahia', 'Remove room', 'Removed room 1', '2023-07-15 04:03:42'),
(222, 'Bahia', 'Remove room', 'Removed room 4', '2023-07-15 04:03:46'),
(223, 'Bahia', 'Remove room', 'Removed room 1', '2023-07-15 04:05:15'),
(224, 'Bahia', 'Remove room', 'Removed room 1', '2023-07-15 04:08:23'),
(225, 'Bahia', 'Add Product', 'Added new product 1', '2023-07-15 04:08:37'),
(226, 'Bahia', 'Add Product', 'Added new product 3', '2023-07-15 04:08:42'),
(227, 'Bahia', 'Remove room', 'Removed room 1', '2023-07-15 04:12:01'),
(228, 'Bahia', 'Add Product', 'Added new product 1', '2023-07-15 04:12:10'),
(229, 'Bahia', 'Remove room', 'Removed room 1', '2023-07-15 04:12:10'),
(230, 'Bahia', 'Add Product', 'Added new product 3', '2023-07-15 04:12:18'),
(231, 'Bahia', 'Remove room', 'Removed room 1', '2023-07-15 04:12:18'),
(232, 'Bahia', 'Add Product', 'Added new product 5', '2023-07-15 04:12:39'),
(233, 'Bahia', 'Add Product', 'Added new product 6', '2023-07-15 04:12:46'),
(234, 'Bahia', 'Update Category', 'Updated the Category image of Standard', '2023-07-15 04:13:10'),
(235, 'Bahia', 'Add Product', 'Added new product 7', '2023-07-15 04:19:02'),
(236, 'Bahia', 'update room', 'updated new room ', '2023-07-15 04:27:43'),
(237, 'Bahia', 'update room', 'updated new room 2', '2023-07-15 04:28:22'),
(238, 'Bahia', 'Remove room', 'Removed room 2', '2023-07-15 04:30:28'),
(239, 'Bahia', 'Add Room', 'Added new room 1', '2023-07-15 04:30:36'),
(240, 'Bahia', 'Remove room', 'Removed room 2', '2023-07-15 04:30:36'),
(241, 'Bahia', 'Add Room', 'Added new room 2', '2023-07-15 04:30:41'),
(242, 'Bahia', 'Remove room', 'Removed room 2', '2023-07-15 04:30:41'),
(243, 'Bahia', 'Remove room', 'Removed room 2', '2023-07-15 04:30:50'),
(244, 'Bahia', 'Remove room', 'Removed room 6', '2023-07-15 04:30:55'),
(245, 'Bahia', 'Removed bookings', 'Removed booking no.HZkAV', '2023-07-15 04:46:30'),
(246, 'Bahia', 'Removed bookings', 'Removed booking no.MGhms', '2023-07-15 04:46:45'),
(247, 'Bahia', 'Removed bookings', 'Removed booking no.HZkAV', '2023-07-15 04:46:56'),
(248, 'Bahia', 'Update Category', 'Updated the Category image of Standard', '2023-07-15 04:47:27'),
(249, 'Bahia', 'Update Category', 'Updated the Category image of Standard', '2023-07-15 04:47:50'),
(250, 'Bahia', 'Remove Category', 'Removed the Category name of Standard', '2023-07-15 04:50:20'),
(251, 'Bahia', 'Add new category', 'Added new category Standard', '2023-07-15 04:51:40'),
(252, 'Bahia', 'Add Admin Account', 'Added admin account Red', '2023-07-15 04:52:31'),
(253, 'Bahia', 'Upadate Admin Account', 'Updated admin account Red', '2023-07-15 04:52:45'),
(254, 'Bahia', 'Remove Admin Account', 'Removed admin account xmts', '2023-07-15 04:55:12'),
(255, '', 'Remove Feedback', 'Removed feedback of rdalunos20@gmail.com', '2023-07-15 04:55:39');

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
(26, 5, '', 0, 'Premium', 'Available', ''),
(29, 7, '', 0, 'Standard', 'Available', ''),
(30, 1, '', 0, 'Standard', 'Available', ''),
(31, 2, '', 0, 'Standard', 'Available', '');

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
(39, 'Red Dalunos', 'rdalunos20@gmail.com', 'a0bfce00c7df8f0e85a30ca75f1a9ca019b34968', '09569961990', '', '', '', 1, 0);

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
-- Indexes for table `booking_list`
--
ALTER TABLE `booking_list`
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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `booking_list`
--
ALTER TABLE `booking_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
