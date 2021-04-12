-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 22, 2021 at 08:38 AM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `indonesianseez-hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int NOT NULL,
  `name` varchar(128) NOT NULL,
  `bank_name` varchar(128) NOT NULL,
  `bank_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `name`, `bank_name`, `bank_id`) VALUES
(1, 'cikidang@resortst', 'BCA', '1676545952');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int NOT NULL,
  `id_costumers` varchar(255) NOT NULL,
  `id_type_rooms` int NOT NULL,
  `rooms` int NOT NULL,
  `id_extra` int NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `person` int NOT NULL,
  `adult` int NOT NULL,
  `child` int NOT NULL,
  `age_child` int NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_confirm`
--

CREATE TABLE `booking_confirm` (
  `id` int NOT NULL,
  `id_booking_orders` int NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `from_bank` varchar(128) NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `change` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking_confirm`
--

INSERT INTO `booking_confirm` (`id`, `id_booking_orders`, `account_name`, `account_number`, `from_bank`, `nominal`, `change`, `image`) VALUES
(1, 5, 'Rifal Nurjamil', '20180050049', 'BCA', '980000', '0', '3202270702000001114055-payment.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `booking_orders`
--

CREATE TABLE `booking_orders` (
  `id` int NOT NULL,
  `id_costumers` int NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` enum('waiting','unconfirmed','paid','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking_orders`
--

INSERT INTO `booking_orders` (`id`, `id_costumers`, `invoice`, `amount`, `status`) VALUES
(5, 5, '3202270702000001114055', '980000', 'paid'),
(6, 6, '8239243574778490120657', '780000', 'waiting');

-- --------------------------------------------------------

--
-- Table structure for table `booking_orders_detail`
--

CREATE TABLE `booking_orders_detail` (
  `id` int NOT NULL,
  `id_booking_orders` int NOT NULL,
  `id_type_rooms` int NOT NULL,
  `rooms` int NOT NULL,
  `id_extra` int NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `person` int NOT NULL,
  `adult` int NOT NULL,
  `child` int NOT NULL,
  `age_child` int NOT NULL,
  `subtotal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking_orders_detail`
--

INSERT INTO `booking_orders_detail` (`id`, `id_booking_orders`, `id_type_rooms`, `rooms`, `id_extra`, `date_from`, `date_to`, `person`, `adult`, `child`, `age_child`, `subtotal`) VALUES
(2, 2, 1, 1, 1, '2021-03-22', '2021-03-26', 1, 1, 0, 0, '980000'),
(3, 3, 1, 1, 1, '2021-03-22', '2021-03-26', 1, 1, 0, 0, '980000'),
(4, 4, 1, 1, 1, '2021-03-22', '2021-03-26', 1, 1, 0, 0, '980000'),
(5, 5, 1, 1, 1, '2021-03-22', '2021-03-26', 1, 1, 0, 0, '980000'),
(6, 6, 3, 1, 0, '2021-03-22', '2021-03-24', 1, 1, 0, 0, '780000');

-- --------------------------------------------------------

--
-- Table structure for table `costumers`
--

CREATE TABLE `costumers` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(17) NOT NULL,
  `address` text NOT NULL,
  `account_id` varchar(255) NOT NULL,
  `account_image` varchar(255) NOT NULL,
  `account_image_user` varchar(255) NOT NULL,
  `passport` varchar(255) NOT NULL,
  `visa` varchar(255) NOT NULL,
  `is_healthy` int NOT NULL,
  `is_approved` enum('unverified','verified','failed','') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `costumers`
--

INSERT INTO `costumers` (`id`, `name`, `email`, `phone`, `address`, `account_id`, `account_image`, `account_image_user`, `passport`, `visa`, `is_healthy`, `is_approved`) VALUES
(5, 'rifalnurchya', 'rifalnurchya@gmail.com', '085940775599', 'Jakarta', '3202270702000001', 'rifalnurchya-ktp-IMG_20200904_185153.jpg', 'rifalnurchya-ktp-IMG_20200904_185153.jpg', '', '', 1, ''),
(6, 'rifalnurchya', 'rifalnurchya@gmail.com', '085940775599', 'Jakarta', '8239243574778490', '', '', '', '', 1, 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `costumers_key`
--

CREATE TABLE `costumers_key` (
  `id` int NOT NULL,
  `id_registered_key` int NOT NULL,
  `id_rooms_key` int NOT NULL,
  `id_costumers` int NOT NULL,
  `id_booking_orders` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `costumers_key`
--

INSERT INTO `costumers_key` (`id`, `id_registered_key`, `id_rooms_key`, `id_costumers`, `id_booking_orders`) VALUES
(2, 4, 4, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `extra`
--

CREATE TABLE `extra` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `type` enum('bed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `extra`
--

INSERT INTO `extra` (`id`, `name`, `price`, `type`) VALUES
(1, 'Mini', '180000', 'bed'),
(2, 'Big', '240000', 'bed');

-- --------------------------------------------------------

--
-- Table structure for table `master_key`
--

CREATE TABLE `master_key` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_rooms_key` int NOT NULL,
  `id_registered_key` int NOT NULL,
  `author` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_key`
--

CREATE TABLE `registered_key` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `role_key` enum('master','costumer','guest','') NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `id_rooms` mediumint NOT NULL,
  `id_type_rooms` int NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registered_key`
--

INSERT INTO `registered_key` (`id`, `title`, `role_key`, `date_from`, `date_to`, `id_rooms`, `id_type_rooms`) VALUES
(4, 'rifalnurchya', 'costumer', '2021-03-22', '2021-03-26', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'owner'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int NOT NULL,
  `number_rooms` int NOT NULL,
  `status` int NOT NULL,
  `id_type_rooms` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `number_rooms`, `status`, `id_type_rooms`) VALUES
(1, 1, 0, 3),
(2, 2, 1, 1),
(3, 3, 0, 2),
(4, 4, 0, 2),
(5, 5, 0, 3),
(6, 6, 0, 3),
(7, 7, 0, 4),
(8, 8, 0, 1),
(10, 9, 0, 2),
(12, 202, 0, 1),
(13, 201, 0, 3),
(14, 205, 0, 5),
(16, 206, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_key`
--

CREATE TABLE `rooms_key` (
  `id` int NOT NULL,
  `id_registered_key` int NOT NULL,
  `qrcode_key` varchar(255) NOT NULL,
  `time_expired` datetime NOT NULL,
  `is_active` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms_key`
--

INSERT INTO `rooms_key` (`id`, `id_registered_key`, `qrcode_key`, `time_expired`, `is_active`) VALUES
(1, 1, '3202270702000001114645.png', '2021-03-26 12:00:00', 1),
(4, 4, '3202270702000001121421.png', '2021-03-26 12:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `type_rooms`
--

CREATE TABLE `type_rooms` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price_pernight` varchar(255) NOT NULL,
  `facilities` text NOT NULL,
  `max_person` int NOT NULL,
  `twin_bed` int NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `type_rooms`
--

INSERT INTO `type_rooms` (`id`, `name`, `price_pernight`, `facilities`, `max_person`, `twin_bed`, `image`) VALUES
(1, 'standart', '200000', 'Greates Facilities', 3, 0, ''),
(2, 'deluxe', '290000', '', 3, 1, 'deluxe-image-sidekix-media-8qNuR1lIv_k-unsplash.jpg'),
(3, 'superior', '390000', '', 3, 0, ''),
(4, 'family', '490000', '', 6, 0, ''),
(5, 'royal', '590000', '', 3, 0, ''),
(6, 'suites', '690000', 'The Royal Suites', 3, 1, ''),
(11, 'royal suites', '2000000', 'Great Royal Suites', 5, 0, 'royal-suites-image-sidekix-media-8qNuR1lIv_k-unsplash.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `id_role` int NOT NULL,
  `is_active` int NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `image`, `id_role`, `is_active`) VALUES
(5, 'rifal.keksukabumi', 'rifal.keksukabumi@gmail.com', '$2y$10$KTuJUupe0Dz5I4MuhCvBZ.L2bIGyNnizEIn.v0u1U3PudMvs0MU5G', '', 2, 1),
(6, 'owner', 'owner@gmail.com', '$2y$10$Df5f66WJSpSuYyF2OPEMe.AqRcIIeLJYdtmmFE7wLxV/SdFibue4O', 'owner-user-alex-suprun-ZHvM3XIOHoE-unsplash.jpg', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_confirm`
--
ALTER TABLE `booking_confirm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_orders`
--
ALTER TABLE `booking_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_orders_detail`
--
ALTER TABLE `booking_orders_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `costumers`
--
ALTER TABLE `costumers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `costumers_key`
--
ALTER TABLE `costumers_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra`
--
ALTER TABLE `extra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_key`
--
ALTER TABLE `master_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_key`
--
ALTER TABLE `registered_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms_key`
--
ALTER TABLE `rooms_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_rooms`
--
ALTER TABLE `type_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking_confirm`
--
ALTER TABLE `booking_confirm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_orders`
--
ALTER TABLE `booking_orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking_orders_detail`
--
ALTER TABLE `booking_orders_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `costumers`
--
ALTER TABLE `costumers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `costumers_key`
--
ALTER TABLE `costumers_key`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `extra`
--
ALTER TABLE `extra`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_key`
--
ALTER TABLE `master_key`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registered_key`
--
ALTER TABLE `registered_key`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rooms_key`
--
ALTER TABLE `rooms_key`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `type_rooms`
--
ALTER TABLE `type_rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;