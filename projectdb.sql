-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2020 at 06:08 AM
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
(1, 'admin', 1, '2020-12-12 03:31:32', '2021-01-08 03:29:29', 250.25, 350, 'user', 'active'),
(2, 'admin', 2, '2020-12-18 17:39:17', '2020-12-18 17:42:09', 300, 350, 'user', 'completed'),
(3, 'admin', 3, '2020-12-14 18:03:38', '2020-12-31 18:03:35', 250.325, 3002, 'user', 'active'),
(4, 'admin', 4, '2020-12-16 00:33:31', '2020-12-16 00:35:29', 60.5, NULL, NULL, 'failed'),
(5, 'admin', 5, '2020-12-16 00:39:12', '2020-12-16 00:41:02', 60.5, NULL, NULL, 'failed'),
(6, 'hike', 6, '2020-12-16 04:08:06', '2020-12-17 04:10:03', 26, NULL, NULL, 'noparticipation'),
(7, 'user', 7, '2020-12-17 19:08:20', '2020-12-24 19:08:13', 80, 450, 'admin', 'active'),
(8, 'user', 8, '2020-12-17 19:09:55', '2020-12-17 20:11:39', 325, 475, 'admin', 'completed'),
(9, 'admin', 9, '2020-12-17 22:21:41', '2020-12-17 23:21:36', 200, NULL, NULL, 'noparticipation'),
(10, 'admin', 10, '2020-12-19 04:21:02', '2020-12-19 04:26:48', 25, NULL, NULL, 'noparticipation'),
(11, 'admin', 11, '2020-12-20 03:17:35', '2020-12-20 03:20:30', 350, 499, 'user', 'completed'),
(12, 'admin', 12, '2020-12-20 03:18:03', '2020-12-20 03:21:58', 27.5, 29.9, 'user', 'completed'),
(13, 'admin', 13, '2020-12-20 03:18:43', '2020-12-20 03:21:21', 9500, 9995, 'user', 'completed');

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

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `auction`, `username`, `message`, `time`) VALUES
(1, 8, 'admin', 'hi im admin', '2020-12-18 06:53:35'),
(2, 8, 'admin', 'who are you?', '2020-12-18 06:53:41'),
(3, 8, 'user', 'hello this is user', '2020-12-18 06:54:16'),
(4, 8, 'user', 'im the owner of this auction', '2020-12-18 06:54:28'),
(5, 8, 'user', 'who are you?', '2020-12-18 07:15:44'),
(8, 8, 'user', 'who?', '2020-12-18 07:16:11'),
(9, 8, 'user', 'im the owner of this auction', '2020-12-18 07:16:25'),
(11, 8, 'user', 'ok?', '2020-12-18 07:17:07'),
(18, 8, 'user', 'yes', '2020-12-18 07:23:20'),
(21, 8, 'user', 'hello', '2020-12-18 17:42:40'),
(22, 8, 'user', 'hello', '2020-12-18 17:44:00'),
(23, 2, 'user', 'hi this the other new auction', '2020-12-18 17:52:09'),
(24, 2, 'admin', 'ok', '2020-12-20 02:04:24'),
(25, 2, 'admin', 'how are you', '2020-12-20 02:04:31');

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
(13, 5, 'images/products/pic16080688152446252355fd92ecf900d7.jpg'),
(14, 6, 'images/products/pic160808091116059695235fd95e0f534ba.png'),
(15, 6, 'images/products/pic160808091118714215255fd95e0f559b3.png'),
(16, 6, 'images/products/pic160808091120536018105fd95e0f57112.jpeg'),
(17, 7, 'images/products/pic160822131416690669035fdb8282c1970.png'),
(18, 7, 'images/products/pic1608221314284908085fdb8282c39cf.png'),
(19, 8, 'images/products/pic160822142011789298585fdb82ec7b4ec.png'),
(20, 8, 'images/products/pic16082214208253596385fdb82ec7c0d6.jpg'),
(21, 8, 'images/products/pic160822142017454100515fdb82ec7d1f6.jpg'),
(22, 8, 'images/products/pic160822142015439818645fdb82ec7da80.jpg'),
(23, 8, 'images/products/pic160822142011689696625fdb82ec7e79f.jpeg'),
(24, 10, 'images/products/pic160834089111720073525fdd559b7dd8e.jpg'),
(25, 10, 'images/products/pic16083408916611057155fdd559b806da.jpg'),
(26, 10, 'images/products/pic160834089116079653155fdd559b82314.jpeg');

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
(5, 'hike', 'hsdoifasdfa\r\nadsfnasdf\r\ndfnasdf', 'Clothings'),
(6, 'aasdfmasdf', 'ashdfiad', 'Clothings'),
(7, 'Jike', 'this is one of the \r\n\r\nbest \r\n\r\nproducts\r\n\r\n34??!!', 'Books'),
(8, 'full new laptop', 'Dell Inspiron\r\n\r\ncore i7\r\n\r\n8th gen\r\n\r\n8gb RAM', 'Electronics'),
(9, 'hikeee', 'extracting POS', 'Clothings'),
(10, 'hike hike', 'bath and body works', 'Health and Beauty'),
(11, 'New Laptop', 'Brand new laptop\r\nhigh specs', 'Electronics'),
(12, 'e-book', 'good book to read', 'Books'),
(13, 'bmw', 'BMW 530 2013', 'Vehicles');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `auctionid` int(11) NOT NULL,
  `buyerRating` float DEFAULT NULL,
  `sellerRating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`auctionid`, `buyerRating`, `sellerRating`) VALUES
(2, 1, 3),
(8, 1, 3),
(11, 3, 5),
(12, 4, 1),
(13, 5, 1);

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

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `name`, `auction`, `number`, `email`, `address`) VALUES
(5, 'Ibrahim Kubaisy', 8, 33268888, 'ibrahim.alkubaisy@gmail.com', 'Hidd'),
(6, 'Ibrahim Kubaisy', 8, 33268888, 'ibrahim.alkubaisy@gmail.com', 'Hidd'),
(7, 'Ibrahim Kubaisy', 2, 33268888, 'ibrahim.alkubaisy@gmail.com', 'Hidd Block 000,\r\n\r\nHouse 000, \r\nroad 000'),
(8, 'Ibrahim Kubaisy', 11, 33268888, 'ibrahim.alkubaisy@gmail.com', 'Hidd 000\r\n\r\nHouse 999'),
(9, 'Ibrahim Kubaisy', 13, 33268888, 'ibrahim.alkubaisy@gmail.com', 'Hidd 000\r\n\r\nHouse 999'),
(10, 'Ibrahim Kubaisy', 12, 33268888, 'ibrahim.alkubaisy@gmail.com', 'Hidd 000\r\n\r\nHouse 999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `picture` varchar(150) DEFAULT NULL,
  `buyerRating` float DEFAULT NULL,
  `sellerRating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `picture`, `buyerRating`, `sellerRating`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin full new', 'admin@admin.net', NULL, NULL, NULL),
(2, 'user', '12dea96fec20593566ab75692c9949596833adc9', 'user', 'user@user.user', NULL, NULL, NULL),
(3, 'hike', '87dc93cfe620c4baa64ed917c8ca6b53e9dbd2ca', 'hike', 'hike@hike.com', NULL, NULL, NULL),
(4, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'a a', 'aidf@nsdfa.c', NULL, NULL, NULL);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction` (`auction`),
  ADD KEY `username` (`username`);

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
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`auctionid`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `auctionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
