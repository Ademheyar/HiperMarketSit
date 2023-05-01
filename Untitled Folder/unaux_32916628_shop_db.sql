-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql109.byetcluster.com
-- Generation Time: Feb 12, 2023 at 12:46 PM
-- Server version: 10.3.27-MariaDB
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
-- Database: `unaux_32916628_shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(255) NOT NULL,
  `name` int(11) NOT NULL,
  `number` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `flat` int(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `pin_code` int(255) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `barcode` text NOT NULL,
  `at_shop` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL DEFAULT 1,
  `cost` double NOT NULL,
  `tax` double NOT NULL,
  `price` varchar(255) NOT NULL,
  `include_tax` tinyint(1) NOT NULL,
  `price_change` tinyint(1) NOT NULL,
  `more_info` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Service` tinyint(1) NOT NULL,
  `Default_Quantity` tinyint(1) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `Description`, `Service`, `Default_Quantity`, `Active`) VALUES
(70, 'Long Sleeve Women Blouses', '', '', ' Long Sleeve Women Crop Top', '', 1, 90, 50, '180', 0, 0, '{S,[|Black,|,]},{M,[|Black,|,]},{L,[|Black,|,]},{XL,[|Black,|,]},{XXL,[|Black,|,]},', '77C415E6-150E-4A0E-94D9-DCE098E702A4.jpeg', 'New Printed Long Sleeve Women Crop Top Shirt Fashion Shirts Women Clothing 2021 For Women Blouses', 0, 1, 1),
(71, 'Sexy V Neck Backless Dresses', '', 'Backless Elegant Formal Dresses', '', '', 1, 100, 0, '220', 0, 0, '{XS,[|Black,|,|White ,|,]},{S,[|Black,|,|White ,|,]},{M,[|Black,|,|White ,|,]},{L,[|Black,|,|White ,|,]},', 'F31F8626-5A24-42C3-85CB-21EAA5F62E81.png', 'KFD8936 2021 spring summer New women dress Fashion sexy V neck Backless elegant Formal dresses', 0, 1, 1),
(78, 'Neck Sleeveless Hollowed-out Backless Jumpsuit ', '', 'Jumpsuit', '', '', 1, 120, 0, '250', 0, 0, '{S,[|Blue,5|,]},{M,[|Blue,5|,]},{L,[|Blue,5|,]},{XL,[|Blue,5|,]},{XXL,[|Blue,5|,]},', 'D6317403-2E86-4126-A311-6F1C145D0CFE.png', 'Jumpsuit Women Fashion Casual Printing Square Neck Sleeveless Hollowed-out Backless Jumpsuit Women', 0, 1, 1),
(81, 'Classy Long Sleeves Casual Dresse', '', 'Dress', '', '', 1, 100, 0, '220', 0, 0, '{S,[|BLACK,5|,|WHITE,5|,|RED,5|,]},{XS,[|BLACK,5|,]},{L,[|BLACK,5|,|WHITE,5|,|RED,5|,]},{XL,[|BLACK,5|,|WHITE,5|,|RED,5|,]},{XXL,[|BLACK,5|,|WHITE,5|,|RED,5|,]},{M,[|WHITE,5|,|RED,5|,]},', 'IMG-20221203-WA0000.jpg', 'New arrivals 2022Trend Casual White lace ruffle women Clothing Chic classy Long Sleeves casual Dresse', 0, 1, 1),
(82, 'Gold Argyle Print Lantern Sleeve Tie Neck Belted Dress', '', 'Dress', '', '', 1, 230, 0, '250', 0, 0, '{M,[|WHITE,5|,|GREEN,|,|BLUE,|,|MAROON,|,]},{L,[|WHITE,|,|GREEN,|,|BLUE,|,|MAROON,|,]},{XL,[|WHITE,|,|GREEN,|,|BLUE,|,|MAROON,|,]},{XXL,[|WHITE,|,|GREEN,|,|MAROON,|,]},{XXXL,[|WHITE,|,|GREEN,|,|BLUE,|,|MAROON,|,]},', 'IMG-20221202-WA0014.jpg', 'Gold Argyle Print Lantern Sleeve Tie Neck Belted Dress', 0, 1, 1),
(84, 'Swimming Costume', 's-214', 'Swimming 2pcs', '', '', 1, 100, 0, '200', 0, 0, '{2XL,[|BLUE,4|,|BLACK,3|,]},{3XL,[|BLUE,4|,|BLACK,5|,]},{4XL,[|BLUE,5|,|YELLOW,3|,]},{5XL,[|BLUE,5|,|BLACK,5|,]},{6XL,[|YELLOW,3|,]},', '1565358289155_955169c1-b3f9-4fd8-8797-62d5fb6aecaf_1024x1024.jpg', 'Swimming Costume 2pcs pant and bra', 0, 1, 1),
(85, 'Elegant Sleeveless Body Suit', '', 'Jumpsuits', '', '', 1, 0, 0, '150', 0, 0, '', 'IMG-20221202-WA0001.jpg', 'Stylish spring gym club girls elegant Sleeveless body suit  women unisex acid washed jumpsuits sleepwear for party  ', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_fname` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `user_state` varchar(255) NOT NULL,
  `user_shop_id` int(255) NOT NULL,
  `user_shop_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_password`, `user_fname`, `user_lname`, `user_state`, `user_shop_id`, `user_shop_name`) VALUES
(2, 'Adem heyar', '123', 'Adem', 'heyar', 'Admin', 0, ''),
(3, 'semira', '123', 'semira', 'heyar', 'Admin', 0, 'Adot');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
