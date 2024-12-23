-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql206.byetcluster.com
-- Generation Time: Dec 23, 2024 at 03:11 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `b7_37365160_truck_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `goods_type` varchar(255) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `package_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `route_from` int(11) DEFAULT NULL,
  `route_to` int(11) DEFAULT NULL,
  `delivery_status` enum('Pending','In Transit','Delivered') DEFAULT 'Pending'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `cargo_id` int(11) NOT NULL,
  `truck_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `package_volume` decimal(10,2) NOT NULL,
  `status` enum('In Transit','Delivered','Pending') DEFAULT 'In Transit',
  `route_from` int(11) NOT NULL,
  `route_to` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `package_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`cargo_id`, `truck_id`, `driver_id`, `package_volume`, `status`, `route_from`, `route_to`, `price`, `payment_status`, `package_id`) VALUES
(26, 1, 0, '1200.00', 'In Transit', 1, 20, '1400.00', 'Unpaid', 0),
(25, 3, 0, '0.00', 'In Transit', 1, 20, '1400.00', 'Unpaid', 0),
(24, 3, 0, '0.00', 'In Transit', 1, 20, '1400.00', 'Unpaid', 0),
(23, 2, 0, '0.00', 'In Transit', 1, 20, '1400.00', 'Unpaid', 0),
(27, 2, 0, '3000.50', 'In Transit', 2, 19, '1200.00', 'Unpaid', 0),
(28, 1, 0, '1500.00', 'In Transit', 1, 20, '1400.00', 'Unpaid', 0),
(29, 1, 0, '1500.00', 'In Transit', 1, 20, '1400.00', 'Unpaid', 0),
(53, 3, 0, '2000.00', 'Delivered', 15, 1, '900.00', 'Paid', 10),
(54, 4, 0, '1500.00', 'Delivered', 1, 20, '1400.00', 'Paid', 8),
(52, 1, 1, '1000.00', 'In Transit', 1, 20, '1400.00', 'Paid', 0),
(50, 3, 0, '2000.00', 'Delivered', 1, 20, '1400.00', 'Paid', 7),
(49, 2, 0, '500.00', 'Delivered', 1, 9, '400.00', 'Paid', 5),
(48, 3, 0, '250.00', 'In Transit', 1, 20, '1400.00', 'Unpaid', 3),
(47, 3, 0, '1200.00', 'Delivered', 1, 20, '1400.00', 'Paid', 2),
(46, 3, 0, '1500.00', 'Delivered', 1, 20, '1400.00', 'Paid', 1),
(56, 3, 0, '1500.00', 'In Transit', 1, 20, '1400.00', 'Unpaid', 8),
(55, 3, 0, '2000.00', 'Delivered', 1, 20, '1400.00', 'Paid', 10);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_truck_id` int(11) DEFAULT NULL,
  `license_number` varchar(50) NOT NULL,
  `license_expiry_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `user_id`, `assigned_truck_id`, `license_number`, `license_expiry_date`, `created_at`) VALUES
(1, 2, 1, 'LIC12345', '2025-12-31', '2024-12-21 05:59:54'),
(2, 2, 2, 'LIC67890', '2025-06-15', '2024-12-21 05:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `status` enum('pending','in-transit','delivered') DEFAULT 'pending',
  `description` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `customer_id`, `product_id`, `weight`, `status`, `description`) VALUES
(10, 0, 101, '2000.00', 'delivered', 'Concrete'),
(8, 0, 102, '1500.00', 'in-transit', 'Glass'),
(6, 1, 103, '1000.00', 'pending', 'Woods');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `volume` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `volume`) VALUES
(4, 'Steel', 'Durable metal for construction.', '500.00'),
(6, 'Cement', 'Powder used for concrete production.', '100.00'),
(7, 'Bricks', 'Standard-size blocks for construction.', '400.00'),
(8, 'Sand', 'Fine aggregate material for concrete.', '200.00'),
(9, 'Gravel', 'Coarse aggregate for building foundations.', '250.00'),
(10, 'Plywood', 'Thin sheets of wood pressed together.', '150.00'),
(11, 'Glass', 'Transparent material for windows.', '50.00'),
(12, 'PVC Pipes', 'Plastic pipes for plumbing.', '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `truck_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `route_from` int(11) NOT NULL,
  `route_to` int(11) NOT NULL,
  `package_volume` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `delivery_status` enum('In Transit','Delivered','Pending') NOT NULL,
  `payment_status` enum('Paid','Unpaid') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `cargo_id`, `truck_id`, `driver_id`, `route_from`, `route_to`, `package_volume`, `price`, `delivery_status`, `payment_status`) VALUES
(13, 26, 1, 0, 1, 20, '1200.00', '1400.00', 'In Transit', 'Unpaid'),
(12, 0, 3, 0, 1, 20, '0.00', '1400.00', 'In Transit', 'Unpaid'),
(11, 0, 3, 0, 1, 20, '0.00', '1400.00', 'In Transit', 'Unpaid'),
(10, 0, 2, 0, 1, 20, '0.00', '1400.00', 'In Transit', 'Unpaid'),
(14, 27, 2, 0, 2, 19, '3000.50', '1200.00', 'In Transit', 'Unpaid'),
(15, 28, 1, 0, 1, 20, '1500.00', '1400.00', 'In Transit', 'Unpaid'),
(16, 29, 1, 0, 1, 20, '1500.00', '1400.00', 'In Transit', 'Unpaid'),
(36, 49, 2, 0, 1, 9, '500.00', '400.00', 'Delivered', 'Paid'),
(38, 51, 2, 0, 1, 19, '1000.00', '1300.00', 'Delivered', 'Paid'),
(39, 0, 1, 1, 1, 20, '1000.00', '1400.00', 'In Transit', 'Paid'),
(35, 48, 3, 0, 1, 20, '250.00', '1400.00', 'In Transit', 'Unpaid'),
(37, 50, 3, 0, 1, 20, '2000.00', '1400.00', 'Delivered', 'Paid'),
(33, 46, 3, 0, 1, 20, '1500.00', '1400.00', 'Delivered', 'Paid'),
(34, 47, 3, 0, 1, 20, '1200.00', '1400.00', 'Delivered', 'Paid'),
(29, 42, 0, 0, 1, 20, '1200.00', '1400.00', 'Delivered', 'Unpaid'),
(32, 45, 4, 0, 2, 20, '3000.50', '1300.00', 'Delivered', 'Paid'),
(31, 44, 3, 0, 1, 20, '1500.00', '1400.00', 'In Transit', 'Unpaid'),
(28, 41, 3, 0, 1, 20, '1500.00', '1400.00', 'In Transit', 'Unpaid'),
(40, 53, 3, 0, 15, 1, '2000.00', '900.00', 'Delivered', 'Paid'),
(41, 54, 4, 0, 1, 20, '1500.00', '1400.00', 'Delivered', 'Paid'),
(42, 55, 3, 0, 1, 20, '2000.00', '1400.00', 'Delivered', 'Paid'),
(43, 56, 3, 0, 1, 20, '1500.00', '1400.00', 'In Transit', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `delivery_location` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `truck`
--

CREATE TABLE `truck` (
  `truck_id` int(11) NOT NULL,
  `license_plate` varchar(20) NOT NULL,
  `truck_type` varchar(50) NOT NULL,
  `capacity` decimal(10,2) NOT NULL,
  `status` enum('Available','In Use','Maintenance') DEFAULT 'Available',
  `driver_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `truck`
--

INSERT INTO `truck` (`truck_id`, `license_plate`, `truck_type`, `capacity`, `status`, `driver_id`) VALUES
(3, 'ZAC-2341', 'Flat Bed', '2000.00', 'In Use', NULL),
(2, 'LMN-9101', 'Container', '2500.00', 'Available', NULL),
(1, 'MPN-3912', 'Flat Bed', '2000.00', 'Available', NULL),
(4, 'ABT-1245 ', 'Box', '1500.00', 'Available', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','driver','customer') NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `role`, `contact_number`, `address`) VALUES
(4, 'Og Admin', 'admin', '$2y$10$H0DQiSS/izJTD0rdHYj6EuZaT3C1.20BYYOG474EyySL3oDSEQQLK', 'admin', '09762135530', 'bsu'),
(13, 'Heisenberg', 'Heisenberg', '$2y$10$rjrW.1SWkGkRO2cyMcQQq.bCR8ZdZLjk8dncp8sd8.b/BjPQFBbCi', 'customer', '1111', 'Bsu'),
(16, 'Driver3', '', '$2y$10$FYMG6jGTuyBQZ3YVp.gdEObAAYpZ/Mp8gthlza3SL3nQdPkiIhGty', 'driver', '3333', 'bsu'),
(15, 'Driver2', '', '$2y$10$PLV7uv5RW.UnjxHu7c4K2O7.yv1MsWUCHYmbWjGNZfteMl5CUVUk2', 'driver', '2222', 'bsu'),
(14, 'Driver1', '', '$2y$10$dap.uQH.kpuc0rvRuuvNhuMOxZnrIIr/MtnZ2qNKB6UDq.FTK40i2', 'driver', '1111', 'Bsu'),
(17, 'Jesse', 'Jesse', '$2y$10$u1detSSF/srtVwOZ8L61N.ONo5O/YRxRaiUh/ZVmItTUq1ObUGXX.', 'driver', '4444', 'Bsu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `fk_cargo` (`cargo_id`),
  ADD KEY `fk_route_from` (`route_from`),
  ADD KEY `fk_route_to` (`route_to`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`cargo_id`),
  ADD KEY `truck_id` (`truck_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `fk_cargo_package` (`package_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `license_number` (`license_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_truck_id` (`assigned_truck_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `truck_id` (`truck_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `fk_reports_cargo` (`cargo_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `cargo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
