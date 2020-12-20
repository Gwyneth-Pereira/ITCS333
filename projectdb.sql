-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 16, 2020 at 10:46 PM
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
  `bid` float DEFAULT NULL,
  `bidder` varchar(30) DEFAULT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`id`, `owner`, `product`, `start`, `end`, `startprice`, `bid`, `bidder`, `status`) VALUES
(1, 'admin', 1, '2020-12-12 03:31:32', '2021-01-08 03:29:29', 250.25, NULL, NULL, 'active'),
(2, 'admin', 2, '2020-12-12 03:31:32', '2020-12-15 03:29:29', 230.5, NULL, NULL, 'pending'),
(3, 'admin', 3, '2020-12-14 18:03:38', '2020-12-31 18:03:35', 250.325, NULL, NULL, 'active'),
(4, 'admin', 4, '2020-12-16 00:33:31', '2020-12-16 00:35:29', 60.5, NULL, NULL, 'pending'),
(5, 'admin', 5, '2020-12-16 00:39:12', '2020-12-16 00:41:02', 60.5, NULL, NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `auction` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `message` varchar(200) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `product`, `picture`) VALUES
(1, 1, 'images/products/pic16079709988254689885fd7b0b6ca221.jpeg'),
(2, 1, 'images/products/pic160797099811339726625fd7b0b6cb53a.jpg'),
(3, 1, 'images/products/pic16079709981863486265fd7b0b6cc51b.jpg'),
(4, 5, 'images/products/pic16080684716726376715fd92d77e2e22.png'),
(5, 5, 'images/products/pic16080684711783988165fd92d77e4ea3.png'),
(6, 5, 'images/products/pic16080684716062547045fd92d77e6e82.jpeg'),
(7, 5, 'images/products/pic160806847119401703695fd92d77e7c9e.jpg'),
(8, 5, 'images/products/pic160806847120309101385fd92d77e87b8.jpg'),
(9, 5, 'images/products/pic160806881510410289845fd92ecf89546.png'),
(10, 5, 'images/products/pic16080688154322898265fd92ecf8ae20.png'),
(11, 5, 'images/products/pic16080688158698633665fd92ecf8c243.jpeg'),
(12, 5, 'images/products/pic1608068815828953725fd92ecf8d701.jpg'),
(13, 5, 'images/products/pic16080688152446252355fd92ecf900d7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `details` varchar(200) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `category`) VALUES
(1, 'p1', 'Product1', 'Art'),
(2, 'p2', 'Product2', 'Electronics'),
(3, 'adfa', 'asdfasd', 'Books'),
(4, 'hike', 'asdhfadv\r\nasdvnasdvnasd\r\ncasndvuansd\r\nvasd', 'Clothings'),
(5, 'hike', 'hsdoifasdfa\r\nadsfnasdf\r\ndfnasdf', 'Clothings');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `question` varchar(300) NOT NULL,
  `asker` varchar(150) NOT NULL,
  `answer` varchar(500) DEFAULT NULL,
  `questiondate` datetime NOT NULL,
  `answerdate` datetime DEFAULT NULL,
  `owner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `auction` int(11) NOT NULL,
  `number` int(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product`),
  ADD KEY `asker` (`asker`),
  ADD KEY `prodowner` (`owner`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction` (`auction`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `asker` FOREIGN KEY (`asker`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `prodowner` FOREIGN KEY (`owner`) REFERENCES `auctions` (`owner`),
  ADD CONSTRAINT `product` FOREIGN KEY (`product`) REFERENCES `products` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
