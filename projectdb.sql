-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2020 at 12:05 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `id` int(11) NOT NULL,
  `owner` varchar(30) NOT NULL,
  `product` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `startprice` float NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`id`, `owner`, `product`, `start`, `end`, `startprice`, `status`) VALUES
(1, 'admin', 1, '2020-12-12 03:31:32', '2021-01-08 03:29:29', 250.25, 'active'),
(2, 'admin', 2, '2020-12-12 03:31:32', '2020-12-15 03:29:29', 230.5, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `bidders`
--

CREATE TABLE `bidders` (
  `id` int(11) NOT NULL,
  `auction` int(11) NOT NULL,
  `bidder` varchar(30) NOT NULL,
  `bid` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bidders`
--

INSERT INTO `bidders` (`id`, `auction`, `bidder`, `bid`) VALUES
(1, 1, 'user', 350),
(2, 2, 'user', 345);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `details` varchar(200) NOT NULL,
  `category` varchar(50) NOT NULL,
  `picture` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `category`, `picture`) VALUES
(1, 'p1', 'Product1', 'Art', ''),
(2, 'p2', 'Product2', 'Electronics', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin full new', 'admin@admin.net'),
(2, 'user', '12dea96fec20593566ab75692c9949596833adc9', 'user', 'user@user.user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `product` (`product`);

--
-- Indexes for table `bidders`
--
ALTER TABLE `bidders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction` (`auction`),
  ADD KEY `bidder` (`bidder`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bidders`
--
ALTER TABLE `bidders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `auctions_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `auctions_ibfk_3` FOREIGN KEY (`product`) REFERENCES `products` (`id`);

--
-- Constraints for table `bidders`
--
ALTER TABLE `bidders`
  ADD CONSTRAINT `bidders_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`),
  ADD CONSTRAINT `bidders_ibfk_2` FOREIGN KEY (`bidder`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
