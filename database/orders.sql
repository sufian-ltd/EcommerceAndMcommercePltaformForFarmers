-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2019 at 09:40 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmers_web_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `productName` varchar(250) NOT NULL,
  `qtn` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `orderDate` varchar(250) NOT NULL,
  `deliveryDate` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `supplierStatus` varchar(250) NOT NULL,
  `userStatus` varchar(250) NOT NULL,
  `payment` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `productId`, `productName`, `qtn`, `cost`, `orderDate`, `deliveryDate`, `status`, `supplierStatus`, `userStatus`, `payment`) VALUES
(1, 7, 2, 'product1', 40, 4920, '07/07/2019 10:26 pm', '07/07/2019 10:26 pm', 'Delivered', '', '', ''),
(3, 7, 2, 'product1', 40, 4920, '07/07/2019 10:26 pm', '07/07/2019 10:26 pm', 'Delivered', '', '', ''),
(4, 7, 7, 'Product Cat 8', 45, 50445, '02/09/2019 12:23 am', '02/09/2019 12:23 am', 'Sending', 'Delivery Pending', 'Not Received', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
