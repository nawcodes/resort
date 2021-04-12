-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2021 at 03:10 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `bank_name` varchar(128) NOT NULL,
  `bank_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `name`, `bank_name`, `bank_id`) VALUES
(1, 'cikidang@resorts', 'BCA', '1676545952');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `id_costumers` int(11) NOT NULL,
  `id_type_rooms` int(11) NOT NULL,
  `rooms` int(11) NOT NULL,
  `id_extra` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `person` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `age_child` int(11) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking_confirm`
--

CREATE TABLE `booking_confirm` (
  `id` int(11) NOT NULL,
  `id_booking_orders` int(11) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `from_bank` varchar(255) NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `change` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_confirm`
--

INSERT INTO `booking_confirm` (`id`, `id_booking_orders`, `account_name`, `account_number`, `from_bank`, `nominal`, `change`, `image`, `date_created`) VALUES
(1, 1, 'Rifal Nurjamil', '20180050049', 'BCA', '5000000', '0', '8123055665734377132145-payment.png', '2021-03-24 12:22:36'),
(2, 2, '201800050049', '20180050049', 'BCA', '10000000', '0', '9764932269539661025227-payment.jpg', '2021-03-25 01:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `booking_orders`
--

CREATE TABLE `booking_orders` (
  `id` int(11) NOT NULL,
  `id_costumers` int(11) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` enum('waiting','unconfirmed','paid','canceled') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_orders`
--

INSERT INTO `booking_orders` (`id`, `id_costumers`, `invoice`, `amount`, `status`, `date_created`) VALUES
(1, 1, '8123055665734377132145', '5000000', 'paid', '2021-03-24 12:24:45'),
(2, 2, '9764932269539661025227', '10000000', 'paid', '2021-03-25 01:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `booking_orders_detail`
--

CREATE TABLE `booking_orders_detail` (
  `id` int(11) NOT NULL,
  `id_booking_orders` int(11) NOT NULL,
  `id_type_rooms` int(11) NOT NULL,
  `rooms` int(11) NOT NULL,
  `id_extra` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `person` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `age_child` int(11) NOT NULL,
  `subtotal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_orders_detail`
--

INSERT INTO `booking_orders_detail` (`id`, `id_booking_orders`, `id_type_rooms`, `rooms`, `id_extra`, `date_from`, `date_to`, `person`, `adult`, `child`, `age_child`, `subtotal`) VALUES
(1, 1, 1, 1, 0, '2021-03-25', '2021-03-30', 1, 1, 0, 0, '5000000'),
(2, 2, 2, 1, 0, '2021-03-25', '2021-03-30', 1, 1, 0, 0, '10000000');

-- --------------------------------------------------------

--
-- Table structure for table `costumers`
--

CREATE TABLE `costumers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(17) NOT NULL,
  `address` text NOT NULL,
  `account_id` varchar(255) NOT NULL,
  `account_image` varchar(255) NOT NULL,
  `account_image_user` varchar(255) NOT NULL,
  `passport` varchar(255) NOT NULL,
  `visa` varchar(255) NOT NULL,
  `is_healthy` int(1) NOT NULL,
  `is_approved` enum('unverified','verified','failed','') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `costumers`
--

INSERT INTO `costumers` (`id`, `name`, `email`, `phone`, `address`, `account_id`, `account_image`, `account_image_user`, `passport`, `visa`, `is_healthy`, `is_approved`, `date_created`) VALUES
(1, 'rifalnurchya', 'rifalnurchya@gmail.com', '085940775599', 'Jakarta', '8123055665734377', 'rifalnurchya-ktp-2018-05-04_(1).png', 'rifalnurchya-ktp-2018-05-04_(1).png', '', '', 1, 'verified', '2021-03-24 12:23:59'),
(2, 'deden', 'ray.alleniuz@gmail.com', '085940775599', 'Jakarta', '9764932269539661', 'deden-ktp-od.png', 'deden-ktp-od.png', '', '', 1, 'unverified', '2021-03-25 01:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `costumers_key`
--

CREATE TABLE `costumers_key` (
  `id` int(11) NOT NULL,
  `id_registered_key` int(11) NOT NULL,
  `id_rooms_key` int(11) NOT NULL,
  `id_costumers` int(11) NOT NULL,
  `id_booking_orders` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `costumers_key`
--

INSERT INTO `costumers_key` (`id`, `id_registered_key`, `id_rooms_key`, `id_costumers`, `id_booking_orders`) VALUES
(2, 0, 2, 2, 2),
(4, 0, 4, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `extra`
--

CREATE TABLE `extra` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `type` enum('bed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `extra`
--

INSERT INTO `extra` (`id`, `name`, `price`, `type`) VALUES
(1, 'Extra Bed', '200000', 'bed');

-- --------------------------------------------------------

--
-- Table structure for table `master_key`
--

CREATE TABLE `master_key` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `id_rooms_key` int(11) NOT NULL,
  `id_registered_key` int(11) NOT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `registered_key`
--

CREATE TABLE `registered_key` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `role_key` enum('master','costumer','guest','') NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `id_rooms` int(11) NOT NULL,
  `id_type_rooms` int(11) NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id` int(11) NOT NULL,
  `number_rooms` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_type_rooms` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `number_rooms`, `status`, `id_type_rooms`) VALUES
(1, 201, 0, 1),
(2, 202, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_key`
--

CREATE TABLE `rooms_key` (
  `id` int(11) NOT NULL,
  `id_registered_key` int(11) NOT NULL,
  `qrcode_key` varchar(255) NOT NULL,
  `time_expired` datetime NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `type_rooms`
--

CREATE TABLE `type_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price_pernight` varchar(255) NOT NULL,
  `facilities` text NOT NULL,
  `max_person` int(11) NOT NULL,
  `twin_bed` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_rooms`
--

INSERT INTO `type_rooms` (`id`, `name`, `price_pernight`, `facilities`, `max_person`, `twin_bed`, `image`) VALUES
(1, 'standart', '1000000', 'Wifi ', 3, 0, ''),
(2, 'suites', '2000000', 'Wifi', 4, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `image`, `id_role`, `is_active`, `date_created`) VALUES
(1, 'owner', 'owner@gmail.com', '$2y$10$Df5f66WJSpSuYyF2OPEMe.AqRcIIeLJYdtmmFE7wLxV/SdFibue4O', 'owner-user-alex-suprun-ZHvM3XIOHoE-unsplash.jpg', 1, 1, '2021-03-24 12:15:43');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_confirm`
--
ALTER TABLE `booking_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_orders`
--
ALTER TABLE `booking_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_orders_detail`
--
ALTER TABLE `booking_orders_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `costumers`
--
ALTER TABLE `costumers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `costumers_key`
--
ALTER TABLE `costumers_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `extra`
--
ALTER TABLE `extra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_key`
--
ALTER TABLE `master_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_key`
--
ALTER TABLE `registered_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms_key`
--
ALTER TABLE `rooms_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `type_rooms`
--
ALTER TABLE `type_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
