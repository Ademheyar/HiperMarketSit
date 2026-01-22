-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 05, 2024 at 08:49 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Shop`
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
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `document_barcode` text DEFAULT NULL,
  `documents_extension_barcode` text DEFAULT NULL,
  `user_id` text DEFAULT NULL,
  `customer_id` text DEFAULT NULL,
  `document_type` text DEFAULT NULL,
  `item` text DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `payments` text DEFAULT NULL,
  `document_created_date` text DEFAULT NULL,
  `document_expire_date` text DEFAULT NULL,
  `document_updated_date` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `document_barcode`, `documents_extension_barcode`, `user_id`, `customer_id`, `document_type`, `item`, `qty`, `price`, `discount`, `tax`, `payments`, `document_created_date`, `document_expire_date`, `document_updated_date`) VALUES
(1, '23:10-21244', '', '1', '', 'sale_item', '[[\"C16\",\"barcode\",\"C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME\",\"1\",\"10\",\"0\",\"0\",\"10\",\"black\",\"75\",\"Flag_squer\",\"\"],[\"C16\",\"barcode\",\"C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME\",\"1\",\"10\",\"0\",\"0\",\"10\",\"black\",\"75\",\"Flag_squer\",\"\"]]', 3, 290, 0, 0, '[[\"c\",\"10\",\"2024-05-12\",\"2024-05-12\",\"\",\"0\",\"\"]]', '2024-05-12', '2024-05-12', '2024-05-12'),
(2, '23:10-21244', '', '1', '', 'sale_item', '', 3, 90, 0, 0, '', '2024-05-01', '2024-05-02', '2024-05-03'),
(8, '23:10-21244', '', '1', '', 'sale_item', '', 3, 230, 0, 0, '', '2024-05-09', '2024-05-11', '2024-05-06');

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
  `more_info` longtext NOT NULL,
  `images` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Service` tinyint(1) NOT NULL,
  `Default_Quantity` tinyint(1) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1,
  `Product_created_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `Description`, `Service`, `Default_Quantity`, `Active`, `Product_created_date`) VALUES
(5, 'C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME', 'C11', '', '777', '1,', 0, 5, 0, '10', 0, 0, '[[\"Flag_squer\",[[\"C16\",[[\"black\",[[\"75\",[[\"\",\"10\",\"10\",\"000\",\"Flag_squer_C16_black_75_C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME_0.jpeg;Flag_squer_C16_black_75_C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME_3.jpeg;Flag_squer_C16_black_75_C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME_4.jpeg;Flag_squer_C16_black_75_C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME_5.jpeg\"]]]]]]],[\"C11\",[[\"black\",[[\"75\",[[\"\",\"7\",\"7\",\"777\",\"Flag_squer_C11_black_75_C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME_2.jpeg\"]]]]]]]]]]', '', 'undefined', 0, 0, 0, '15-02-2023'),
(39, 'CAROTONE CRAM BIG', '02-6454', '', '', '0,', 0, 35, 0, '85', 0, 0, '[[\"Flag_squer\",[[\"C-11\",[[\"black\",[[\"75\",[[\"\",\"3\",\"3\",\"000\",\"Flag_squer_C-11_black_75_C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME_0.jpeg;Flag_squer_C-11_black_75_C4_TABLAT_CYPROHEPTADINE_HCM_4MG_COMPRIME_1.jpeg\"]]]]]]]]]]', '', '', 0, 0, 1, '15-02-2023'),
(70, 'Long Sleeve Women Blouses', '', '', ' Long Sleeve Women Crop Top', '1,', 1, 90, 50, '180', 0, 0, '', '77C415E6-150E-4A0E-94D9-DCE098E702A4.jpeg', 'New Printed Long Sleeve Women Crop Top Shirt Fashion Shirts Women Clothing 2021 For Women Blouses', 0, 1, 1, '15-02-2023'),
(71, 'Sexy V Neck Backless Dresses', '', 'Backless Elegant Formal Dresses', '', '2,3,', 1, 100, 0, '220', 0, 0, '', 'F31F8626-5A24-42C3-85CB-21EAA5F62E81.png', 'KFD8936 2021 spring summer New women dress Fashion sexy V neck Backless elegant Formal dresses', 0, 1, 1, '15-02-2023'),
(78, 'Neck Sleeveless Hollowed-out Backless Jumpsuit ', '', 'Jumpsuit', '', '3,2,1,', 1, 120, 0, '250', 0, 0, '', 'D6317403-2E86-4126-A311-6F1C145D0CFE.png', 'Jumpsuit Women Fashion Casual Printing Square Neck Sleeveless Hollowed-out Backless Jumpsuit Women', 0, 1, 1, '15-02-2023'),
(81, 'Classy Long Sleeves Casual Dresse', '', 'Dress', '', '1,', 1, 100, 0, '220', 0, 0, '', 'IMG-20221203-WA0000.jpg', 'New arrivals 2022Trend Casual White lace ruffle women Clothing Chic classy Long Sleeves casual Dresse', 0, 1, 1, '15-02-2023'),
(82, 'Gold Argyle Print Lantern Sleeve Tie Neck Belted Dress', '', 'Dress', '', '1,', 1, 230, 0, '250', 0, 0, '', 'IMG-20221202-WA0014.jpg', 'Gold Argyle Print Lantern Sleeve Tie Neck Belted Dress', 0, 1, 1, '15-02-2023'),
(84, 'Swimming Costume', 's-214', 'Swimming 2pcs', '', '1,', 1, 100, 0, '200', 0, 0, '', '1565358289155_955169c1-b3f9-4fd8-8797-62d5fb6aecaf_1024x1024.jpg', 'Swimming Costume 2pcs pant and bra', 0, 1, 1, '15-02-2023'),
(85, 'Elegant Sleeveless Body Suit', '', 'Jumpsuits', '', '1,', 1, 0, 0, '150', 0, 0, '', 'IMG-20221202-WA0001.jpg', 'Stylish spring gym club girls elegant Sleeveless body suit  women unisex acid washed jumpsuits sleepwear for party  ', 0, 1, 1, '15-02-2023'),
(86, 'Long Shart', 'C4741', 'WOMENS LONG SHART DRESS', '', '1,', 1, 120, 90, '220', 0, 1, '', 'IMG_20230123_163331.jpg', 'LONG SHART DRESS TYPE SHART STYLE WITH ONE COLOR', 0, 0, 0, '15-02-2023'),
(87, 'name', 'code', '', 'barcode', '1,', 0, 200, 100, '400', 0, 1, '', 'IMG_20230123_163331.jpg', 'disc', 1, 0, 1, '15-02-2023'),
(88, 'name123', 'code', '', 'barcode', '1,', 0, 200, 100, '300', 0, 1, '', 'IMG_20230123_163331.jpg~IMG_20230201_203152_159.jpg', 'disc', 1, 0, 1, '15-02-2023'),
(94, 'NECKLESS 90S STYLE', '', 'NEKLESS', '', '1,', 0, 15, 0, '35', 0, 0, '', '1X10, , 96, 96, , ', '1X30, , 30, 30, , |]>)},\"', 0, 0, 0, '15-02-2023'),
(95, 'NECKLESS R(50)', '', '', '', '1,', 0, 30, 0, '50', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(111, 'NAILS FALER', '', '', '', '1,', 0, 5, 0, '10', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(124, 'FISHNET PANTYHOSE', 'JI_MEILIN', '', '', '1,', 0, 15, 0, '30', 0, 0, '', 'NO:007,6936773100156,4,4,,', 'NO:6735,6936773100156,17,17,,', 0, 0, 0, '15-02-2023'),
(128, 'BEAD KIT HAIR ACCESSORIES', '', 'HAIR ACCESSORIES', '', '1,', 0, 5, 0, '10', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(145, 'EYE SHADOW BRUSH QUZHIMEI, ANNINA, MEIYANI', 'PC82016, ES-004', 'EYE SHADOW STICK', '', '1,', 0, 5, 0, '15', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(148, 'NAILS PLAN SMALL', '', '', '', '1,', 0, 2.5, 0, '5', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(149, 'NAILS PLAN BIG', '', '', '', '1,', 0, 5, 0, '15', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(155, 'NAILS STYLISH', 'PK2388', 'NAILS STYLISH', '', '1,', 0, 7, 0, '15', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(249, 'MANS JEANS TROUSER CHAMIKEY FASHION WEAR', '8203', 'MANS JEANS TROUSER', '', '1,', 0, 120, 0, '220', 0, 0, '', '30,,1,1,,', '36,,2,2,,', 34, 0, 0, '15-02-2023'),
(250, 'MANS JEANS TROUSER OASIS', '803', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '180', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(251, 'MANS JEANS TROUSER E&F', 'J2197#', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '200', 0, 0, '', '36,,2,2,,', '30,,2,2,,', 34, 0, 0, '15-02-2023'),
(252, 'MANS JEANS TROUSER DG.MAN FASHION JEANS', '4370#', 'MANS JEANS TROUSER', '', '1,', 0, 120, 0, '220', 0, 0, '', '28,,3,3,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(253, 'MANS JEANS TROUSER', 'J013-4A#', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '200', 0, 0, '', '32,,2,2,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(254, 'MANS JEANS TROUSER CHAMIKEY', '20117', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '220', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(255, 'MANS JEANS TROUSER DG.MAN DENIM DIVISON', '3110#', 'MANS JEANS TROUSER', '', '1,', 0, 120, 0, '220', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(256, 'MANS JEANS TROUSER JIU DESIGN FASHION CITY', '12169', 'MANS JEANS TROUSER', '', '1,', 0, 120, 0, '220', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(257, 'MANS JEANS TROUSER JIU DESIGN FASHION SIMPLY', 'C46#', 'MANS JEANS TROUSER', '', '1,', 0, 120, 0, '220', 0, 0, '', '34,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(258, 'MANS JEANS TROUSER E&F', 'JD9330-3#', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '200', 0, 0, '', '34,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(259, 'MANS JEANS TROUSER JUI DESIGN FSHION SIMPLY', '2517-1', 'MANS JEANS TROUSER', '', '1,', 0, 120, 0, '220', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(260, 'MANS JEANS TROUSER CHAMIKEY ', '8085', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '220', 0, 0, '', '30,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(261, 'MANS JEANS TROUSER JIU DESIGN', 'C36#', 'MANS JEANS TROUSER', '', '1,', 0, 120, 0, '220', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(262, 'MANS JEANS TROUSER', '8006#', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '220', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(263, 'MANS JEANS TROUSER JIU DESIGN', 'B21#', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '220', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(264, 'MANS JEANS TROUSER CHAMIKEY', '8103', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '220', 0, 0, '', '32,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(265, 'MANS JEANS TROUSER ZUZECU', '', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '150', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(266, 'MANS KHAKI TROUSER CHINO', '6800-3#', 'MANS JEANS TROUSER', '', '1,', 0, 100, 0, '200', 0, 0, '', '34,,2,2,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(267, 'MANS KHAKI TROUSER', '6800-28#', 'MANS KHAKI TROUSER', '', '1,', 0, 100, 0, '200', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(268, 'MANS KHAKI TROUSER CHINO', 'S1-12#', 'MANS KHAKI TROUSER', '', '1,', 0, 100, 0, '200', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(269, 'MANS KHAKI TROUSER CHINO', 'K017#', 'MANS KHAKI TROUSER', '', '1,', 0, 100, 0, '200', 0, 0, '', '28,,2,2,,|]>,<BLACK,[|36,,1,1,,', '28,,1,1,,', 34, 32, 38, '15-02-2023'),
(270, 'MANS TRACK XN XINNUO VOGUEE JIU DESIGN', '1945', 'MANS TRACK', '', '1,', 0, 75, 0, '130', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(271, 'MANS KHAKI TROUSER  E&F', '502#', 'MANS KHAKI TROUSER ', '', '1,', 0, 100, 0, '200', 0, 0, '', '30,,2,2,,', '34,,3,3,,|]>,<BLACK_WHITE,[|34,,2,2,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(272, 'MANS KHAKI TROUSER E&F', '709#', 'MANS KHAKI TROUSER ', '', '1,', 0, 100, 0, '200', 0, 0, '', '34,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(273, 'MANS KHAKI TROUSER E&F', '512#', 'MANS KHAKI TROUSER ', '', '1,', 0, 100, 0, '200', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(274, 'MANS KHAKI TROUSER E&F', '505#', 'MANS KHAKI TROUSER ', '', '1,', 0, 100, 0, '200', 0, 0, '', '34,,3,3,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(275, 'MANS KHAKI TROUSER E&F', '506#', 'MANS KHAKI TROUSER ', '', '1,', 0, 100, 0, '200', 0, 0, '', '34,,2,2,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(276, 'MANS KHAKI TROUSER E&F', '515#', 'MANS KHAKI TROUSER ', '', '1,', 0, 100, 0, '200', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(277, 'MANS KHAKI SHORT TROUSER E&F', '886', 'MANS KHAKI SHORT TROUSER', '', '1,', 0, 100, 0, '200', 0, 0, '', '28,,4,4,,', '34,,1,1,,', 32, 30, 0, '15-02-2023'),
(278, 'MANS KHAKI SHORT TROUSER', '882', 'MANS KHAKI SHORT TROUSER', '', '1,', 0, 100, 0, '180', 0, 0, '', '32,,2,2,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(279, 'MANS KHAKI SHORT TROUSER E&F', '890#', 'MANS KHAKI SHORT TROUSER', '', '1,', 0, 100, 0, '180', 0, 0, '', '28,,4,4,,', '34,,2,2,,', 32, 30, 0, '15-02-2023'),
(280, 'MANS BICH SHORT TROUSER', '', 'MANS BICH SHORT TROUSER', '', '1,', 0, 35, 0, '35', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(281, 'MANS VEST D&T', '', 'MANS VEST', '', '1,', 0, 65, 0, '120', 0, 0, '', 'L,,5,5,,', 'XL,,2,2,,|]>,<BLACK+BLUE,[|L,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(282, 'MANS T-SHART PEP& CO TOUTH', '', 'MANS T-SHAER', '', '1,', 0, 50, 0, '75', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(283, 'MANS T-SHART NEW FEELING', '', 'MANS T-SHART', '', '1,', 0, 50, 0, '50', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(284, 'MANS T-SHART CATANIA', 'F1427', 'MANS T-SHART', '', '1,', 0, 70, 0, '100', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(285, 'MANS T-SHART ORIGINAL', '', 'MANS T-SHART', '', '1,', 0, 70, 0, '100', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(286, 'MANS T-SHART DESSEN', '60043', 'MANS T-SHART', '', '1,', 0, 50, 0, '75', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(287, 'MANS SHART NAN SLIMFIT', '', 'MANS SHART', '', '1,', 0, 100, 0, '150', 0, 0, '', '3XL,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(288, 'MANS SHORT SLIVE SHART NAN SLIMFIT', '', 'MANS SHART', '', '1,', 0, 100, 0, '150', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(289, 'MANS SHART FASHION', 'XF8803', 'MANS SHART', '', '1,', 0, 100, 0, '150', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(290, 'MANS SHART NEW FEELING SHORT SLIVE', 'N-1516', 'MANS SHART', '', '1,', 0, 50, 1, '75', 0, 0, '', 'XL,,3,3,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(291, 'MANS SHART SIJIA YUAN', 'N-1474', 'MANS SHART', '', '1,', 0, 50, 0, '75', 0, 0, '', 'XL,,2,2,,', '2XL,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(292, 'MANS JACKET SHORT SLIVE WITH STRIP', 'JH-83', 'MANS JACKET', '', '1,', 0, 100, 0, '150', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(293, 'MANS JACKET', '', 'MANS JACKET', '', '1,', 0, 100, 0, '150', 0, 0, '', '2XL,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(294, 'MANS RAIN JACKET ADDIDAS', '', 'MANS JACKET', '', '1,', 0, 100, 0, '150', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(295, 'MANS JEAN JACKET CATAMOA ', 'A110', 'MANS JACKET', '', '1,', 0, 150, 0, '300', 0, 0, '', '2XL,,1,1,,', '4XL,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(296, 'MANS JEAN JACKET', 'A108#', 'MANS JEAN JACKET', '', '1,', 0, 150, 0, '300', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(297, 'MANS JEAN JACKET AM/FS POSITIVE', 'KG2504', 'MANS JEAN JACKET', '', '1,', 0, 150, 0, '300', 0, 0, '', 'S,,1,1,,', '2XL,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(298, 'SUN GLASS  BIG', '', 'GLASS ', '', '1,', 0, 50, 0, '80', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(299, 'SUN GLASS SMALL', '', 'SUN GLASS', '', '1,', 0, 35, 0, '50', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(300, 'GLASS', '', 'GLASS', '', '1,', 0, 25, 0, '50', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(301, 'WOMANS BRA', '', 'BRA', '', '1,', 0, 25, 0, '50', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(302, 'WOMANS PANTS G-STRIM', '', 'WOMANS PANTS', '', '1,', 0, 10, 0, '25', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(303, 'WOMANS FULL PANTS ', '', 'WOMANS PANTS', '', '1,', 0, 10, 0, '25', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(304, 'WOMANS FULL PANT AMILA', '', 'WOMANS PANT', '', '1,', 0, 25, 0, '50', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(305, 'WOMANS LONG SCERFF', '', 'SCERFF', '', '1,', 0, 15, 0, '35', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(306, 'WINTER HAT ', '', 'WINTER HAT ', '', '1,', 0, 15, 0, '35', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(307, 'WINTER HAT AND SCARFF', '', 'WINTER HAT SCARFF', '', '1,', 0, 25, 0, '45', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(308, 'WINTER BABY HAT', '', 'WINTER HAT', '', '1,', 0, 15, 0, '25', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(309, 'WINTER FULL FACE HAT', '', 'WINTER FULL FACE HAT', '', '1,', 0, 20, 0, '45', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(310, 'WINTER ROUND SCARFF', '', 'WINTER ROUND SCARFF', '', '1,', 0, 10, 0, '20', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(311, 'WINTER KIDS SOCKS', '', 'WINTER SOCKS', '', '1,', 0, 15, 0, '30', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(312, 'WINTER LONG SOCKS', '', 'WINTER SOCKS', '', '1,', 0, 5, 0, '15', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(313, 'SOCKS', '', 'WINTER SOCKS', '', '1,', 0, 5, 0, '10', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(314, 'LONG SOCKS', '', 'LONG SOCKS', '', '1,', 0, 5, 0, '10', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(315, 'HAT', '', 'HAT', '', '1,', 0, 25, 0, '55', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(316, 'SPORT CAP HAT', '', 'CAP HAT', '', '1,', 0, 30, 0, '65', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(317, 'SHOELAY', '', 'SHOELAY', '', '1,', 0, 2.5, 0, '10', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(318, 'WOMANS BOOTS', '', 'WOMANS BOOTS', '', '1,', 0, 175, 0, '350', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(319, 'WOMANS TROUSER STORY FAHION', 'TG3177#', 'WOMANS TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,5,5,,', '32,,8,8,,', 26, 0, 0, '15-02-2023'),
(320, 'WOMANS TROUSER ', '2385#', 'WOMANS TROUSER ', '', '1,', 0, 100, 0, '180', 0, 0, '', '26,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(321, 'WOMANS TROUSER STORY FASHON', 'TG3195#', 'WOMANS TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(322, 'WOMANS TROUSER ', 'TG3191', 'WOMANS TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,3,3,,', '32,,4,4,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(323, 'WOMANS TROUSER  STOTY FASHION', 'TG3190#', 'WOMANS TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,6,6,,', '32,,7,7,,', 34, 0, 0, '15-02-2023'),
(324, 'WOMANS TROUSER  EVA.G', 'EVA8065', 'WOMANS TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(325, 'WOMANS TROUSER EVA', 'EVA2023', 'WOMANS TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(326, 'WOMANS TROUSER EVA', 'EVA8028', 'WOMANS TROUSER ', '', '1,', 0, 5, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(327, 'WOMANS TROUSER STORY FASHION', 'TG107#', 'WOMANS TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,2,2,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(328, 'WOMANS TROUSER STORY FASHION', 'TG2071#', 'WOMANS TROUSER ', '', '1,', 0, 5, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(329, 'WOMANS JEAN TROUSER STROY FASHION', 'TG1881#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(330, 'WOMANS JEAN TROUSER ICYPEAL', 'NO CODE 32 1', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(331, 'WOMANS JEAN TROUSER STORY FASHION', 'TG166#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(332, 'WOMANS JEAN TROUSER STORY FASHION', 'TG102#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '28,,3,3,,', '30,,3,3,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(333, 'WOMANS JEAN TROUSER STORY FAHION', 'TG3172#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '28,,3,3,,', '26,,1,1,,', 32, 30, 0, '15-02-2023'),
(334, 'WOMANS JEAN TROUSER ICYPEAY', '2212', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(335, 'WOMANS JEAN TROUSER', '2208', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '14', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(336, 'WOMANS JEAN TROUSER STORY FASHION', 'K201', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '28,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(337, 'WOMANS JEAN TROUSER STORY FASHION', 'K206', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(338, 'WOMANS JEAN TROUSER STORY FASHION', 'TG166', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '26,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(339, 'WOMANS JEAN TROUSER', 'TG3180#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '26,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(340, 'WOMANS JEAN TROUSER ICYPEAK', 'K2118', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(341, 'WOMANS JEAN TROUSER', 'K2118', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(342, 'WOMANS JEAN TROUSER STORY FASHION', 'FS-12#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '28,,2,2,,', '34,,2,2,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(343, 'WOMANS JEAN TROUSER STORY FASHION', 'FS-07#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '32,,8,8,,', '30,,3,6,,', 34, 0, 0, '15-02-2023'),
(344, 'WOMANS JEAN TROUSER', 'M6029#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(345, 'WOMANS JEAN TROUSER NEW ONE', 'M6009#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(346, 'WOMANS JEAN TROUSER STORY FASHION', 'TG3001#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '26,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(347, 'WOMANS JEAN TROUSER', 'TG3199#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(348, 'WOMANS JEAN TROUSER STORY FASHION', 'TG3192', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(349, 'WOMANS JEAN TROUSER STORY FASHION', 'TG151#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '130', 0, 0, '', '30,,8,8,,', '28,,1,1,,', 26, 0, 0, '15-02-2023'),
(350, 'WOMANS JEAN TROUSER STORY FASHION', 'TG211#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,5,5,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(351, 'WOMANS JEAN TROUSER COOLI CE', 'C1181#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(352, 'WOMANS JEAN TROUSER COOL ICE', 'C6571#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', 'L,,3,3,,', '2XL,,3,3,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(353, 'WOMANS JEAN TROUSER COOL ICE', 'C2847#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(354, 'WOMANS JEAN TROUSER', 'H-2404', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(355, 'WOMANS JEAN TROUSER LE COUTURE', 'H-2332', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', 'L,,1,1,,', '2XL,,1,1,,|]>,<RED,[|2XL,,1,1,,|]>,<WHITE,[|2XL,,1,2,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(356, 'WOMANS JEAN TROUSER COOL ICE', 'C6471', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '2XL,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(357, 'WOMANS JEAN TROUSER NEW FEELING', 'H-2323', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(358, 'WOMANS JEAN TROUSER COOL ICE', 'C6726', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', 'S,,1,1,,', 'M,,3,3,,|]>,<BLACK,[|XL,,1,1,,', 2, 0, 0, '15-02-2023'),
(359, 'WOMANS JEAN TROUSER RANBO NATION', 'D4819', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '36,,4,4,,', '34,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(360, 'WOMANS JEAN TROUSER COOL ICE', 'C295-6', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(361, 'WOMANS JEAN TROUSER', 'FA-3840', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(362, 'WOMANS JEAN TROUSER', 'L3200#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(363, 'WOMANS JEAN TROUSER NEW ONE', '0174#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '180', 0, 0, '', '30,,3,3,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(364, 'WOMANS JEAN TROUSER NEW FEELING', 'FD-284#', 'WOMANS JEAN TROUSER', '', '1,', 0, 95, 0, '180', 0, 0, '', '30,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(365, 'WOMANS JEAN TROUSER NEW ONE', '0149#', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '30,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(366, 'WOMANS JEAN TROUSER COOL ICE', 'C3027#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,6,6,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(367, 'WOMANS JEAN TROUSER COOL ICE', 'C2928#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,5,5,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(368, 'WOMANS JEAN TROUSER COOL ICE', 'C2969#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(369, 'WOMANS JEAN TROUSER COOL ICE', 'C3037#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,3,3,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(370, 'WOMANS JEAN TROUSER EVA.G', '8105#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,3,3,,', '34,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(371, 'WOMANS JEAN TROUSER NEW FEELING', 'FA-3422#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(372, 'WOMANS JEAN TROUSER NEW ONE', 'D-3095#', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(373, 'WOMANS JEAN TROUSER NEW ONE ', 'D-3094#', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(374, 'WOMANS JEAN TROUSER NEW FASHION', 'FA3303#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '38,,3,3,,', '34,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(375, 'WOMANS JEAN TROUSER', 'D3097#', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(376, 'WOMANS JEAN TROUSER NEW ONE', 'D3091#', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(377, 'WOMANS JEAN TROUSER NEW ONE', 'D3093', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(378, 'WOMANS JEAN TROUSER NEW FEELING', 'FA-2503#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(379, 'WOMANS JEAN TROUSER G.SUN', 'B-27#', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(380, 'WOMANS JEAN TROUSER G.SUN', 'B-30#', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '30,,1,1,,', '34,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(381, 'WOMANS JEAN TROUSER COOL ICE', 'C9854#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(382, 'WOMANS JEAN TROUSER COOL ICE', 'C9860#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(383, 'WOMANS JEAN TROUSER LE COULTUER', 'H-2226#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(384, 'WOMANS JEAN TROUSER NEW FEELING', 'H-2392', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', 'S,,1,1,,|]>,<BLACK,[|XL,,2,2,,', 'L,,1,1,,', 0, 0, 0, '15-02-2023'),
(385, 'WOMANS JEAN TROUSER COOL ICE', 'C6200#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '36,,1,1,,', '30,,3,3,,', 34, 0, 0, '15-02-2023'),
(386, 'WOMANS JEAN TROUSER COOL ICE', 'C6331#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '2XL,,3,3,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(387, 'WOMANS JEAN TROUSER EVA.G', '8087#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,6,6,,', '28,,6,6,,', 26, 32, 30, '15-02-2023'),
(388, 'WOMANS JEAN TROUSER COOL ICE', 'C6296#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,13,13,,', '28,,7,7,,', 32, 30, 38, '15-02-2023'),
(389, 'WOMANS JEAN TROUSER EVA.G', 'A0016', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,3,3,,', '28,,4,4,,', 26, 32, 30, '15-02-2023'),
(390, 'WOMANS JEAN TROUSER EVE.G', '8082', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,6,6,,', '28,,6,6,,', 26, 32, 30, '15-02-2023'),
(391, 'WOMANS JEAN TROUSER EVA.G', '632#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '28,,4,4,,', '26,,1,1,,', 32, 30, 0, '15-02-2023'),
(392, 'WOMANS JEAN TROUSER EVA.G', '8066', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,6,6,,', '28,,6,6,,', 26, 32, 30, '15-02-2023'),
(393, 'WOMANS JEAN TROUSER EVA.G', '8083', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,6,6,,', '28,,7,7,,', 26, 32, 30, '15-02-2023'),
(394, 'WOMANS JEAN TROUSER EVA.G', '8061', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,4,4,,', '28,,7,7,,', 26, 32, 30, '15-02-2023'),
(395, 'WOMANS JEAN TROUSER EVA.G', '8085', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,6,6,,', '28,,6,6,,', 26, 32, 30, '15-02-2023'),
(396, 'WOMANS SHORT JEAN TROUSER', 'C3006#', 'WOMANS  JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,5,5,,', '28,,7,7,,', 26, 0, 0, '15-02-2023'),
(397, 'WOMANS SHORT JEAN TROUSER COOL ICE', 'C3039#', 'WOMANS SHORT JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(398, 'WOMANS JEAN TROUSER', 'TG3149#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '30,,36,36,,', '28,,28,28,,', 26, 0, 0, '15-02-2023'),
(399, 'WOMANS JEAN TROUSER', 'FA-1283', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '28,,6,6,,', '30,,9,9,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(400, 'WOMANS JEAN TROUSER EVA.G', '6017', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '26,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(401, 'WOMANS JEAN TROUSER GOLDEN HORSE', 'Q-105', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '26,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(402, 'WOMANS JEAN TROUSER NEW ONE', '3346#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,12,12,,', '28,,11,11,,', 26, 32, 30, '15-02-2023'),
(403, 'WOMANS JEAN TROUSER EVA', '8086', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,9,9,,', '28,,9,9,,', 26, 32, 30, '15-02-2023'),
(404, 'WOMANS JEAN TROUSER', '3560', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,3,3,,', '28,,3,3,,', 26, 32, 30, '15-02-2023'),
(405, 'WOMANS JEAN TROUSER NEW ONE', '3359#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '34,,16,16,,', '28,,10,10,,', 26, 32, 30, '15-02-2023'),
(406, 'WOMANS JEAN TROUSER NEW ONE', '3343#', 'WOMANS JEAN TROUSER', '', '1,', 0, 90, 0, '180', 0, 0, '', '28,,7,7,,', '26,,8,8,,', 32, 30, 0, '15-02-2023'),
(407, 'WOMANS JEAN TROUSER GOLDEN SUN', 'B-132#', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(408, 'MAT SMALL', '', 'MAT', '', '1,', 0, 25, 0, '45', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(409, 'CURTAIN 5M NORMAL ', '', 'CURTAIN', '', '1,', 0, 175, 0, '300', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(410, 'CURTAIN 3M NORMAL ', '', 'CURTAIN', '', '1,', 0, 140, 0, '230', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(411, 'LED COLOR LIGHT', 'GSH-9009B', 'LIGHT', '', '1,', 0, 50, 0, '70', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(412, 'WOMANS JEAN TROUSER COOL ICE', 'C6364', 'WOMANS JEAN TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', '2XL,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(413, 'WOMANS JEAN TROUSER NEW FEELING', 'H-2338', 'WOMANS JEAN TROUSER ', '', '1,', 0, 75, 0, '140', 0, 0, '', 'M,,1,1,,|]>,<DARCK_BLUE,[|XL,,1,1,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(414, 'WOMANS JEAN TROUSER NEW FEELING', 'H-6339', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(415, 'WOMANS JEAN TROUSER LE COUTURE', 'H-1976', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(416, 'WOMANS JEAN TROUSER NEW FEELING', 'H-2483', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '38,,1,1,,|]>,<RED,[|30,,1,1,,', '36,,1,1,,', 38, 34, 36, '15-02-2023'),
(417, 'WOMANS JEAN TROUSER NEW FEELING', 'H-1976', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '36,,1,1,,', '38,,1,1,,|]>,<NAVY_BLUE,[|32,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(418, 'WOMANS JEAN TROUSER COOL ICE', 'C6354', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '36,,1,3,,', '38,,1,2,,', 34, 34, 36, '15-02-2023'),
(419, 'WOMANS JEAN TROUSER U-STAR', 'P1705', 'WOMANS JEAN TROUSER', '', '1,', 0, 140, 0, '220', 0, 0, '', '34,,1,1,,|]>,<MILITARY,[|32,,3,3,,', '30,,2,2,,', 28, 34, 30, '15-02-2023'),
(420, 'WOMANS JEAN TROUSER COOL ICE', 'C6588', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', 'S,,1,1,,|]>,<BLACK,[|L,,5,5,,', 'XL,,4,4,,', 0, 0, 0, '15-02-2023'),
(421, 'WOMANS LEZER TROUSER ', '', 'WOMANS LEZER TROUSER', '', '1,', 0, 140, 0, '200', 0, 0, '', 'XL,,5,5,,', 'M,,7,7,,', 0, 0, 0, '15-02-2023'),
(422, 'WOMANS LEAZER TROUSER NEW FEELING ', 'H-2176', 'WOMANS LEAZER TROUSER', '', '1,', 0, 75, 0, '200', 0, 0, '', 'XL,,2,2,,', 'M,,3,3,,', 2, 0, 0, '15-02-2023'),
(423, 'WOMANS JEAN TROUSER NEW ONE', '3511', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(424, 'WOMANS JEAN TROUSER STORY FASHION', '3188', 'WOMANS JEAN TROUSER', '', '1,', 0, 75, 0, '140', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(425, 'WOMANS JEAN TROUSER FUTURE STAR', 'FS-07#', 'WOMANS JEAN TROUSER', '', '1,', 0, 120, 0, '180', 0, 0, '', '34,,7,7,,', '36,,2,2,,', 30, 38, 34, '15-02-2023'),
(426, 'WOMANS JEAN TROUSER', 'FS-12#', 'WOMANS JEAN TROUSER', '', '1,', 0, 120, 0, '180', 0, 0, '', '34,,3,3,,', '36,,2,2,,', 28, 30, 34, '15-02-2023'),
(427, 'SALE BELLT', '', 'BELLT', '', '1,', 0, 10, 0, '20', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(428, 'WOMANS  BELLT', 'G-948#', 'BELLT', '', '1,', 0, 45, 0, '75', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(429, 'WOMANS BOOT SHOES', '106-5', 'WOMANS BOOT SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '8,,1,1,,', '3,,1,1,,', 6, 7, 4, '15-02-2023'),
(430, 'WOMANS BOOT SHOES', 'HM001', 'WOMANS BOOT SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '8,,1,1,,', '3,,1,1,,', 6, 7, 4, '15-02-2023'),
(431, 'WOMANS BOOT SHOES', 'HM602', 'WOMANS BOOT SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '8,,1,1,,', '3,,1,1,,', 6, 7, 4, '15-02-2023'),
(432, 'WOMANS BOOT SHOES', 'HM2611-5', 'WOMANS BOOT SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '8,,1,1,,', '3,,1,1,,', 6, 7, 4, '15-02-2023'),
(433, 'WOMANS SHOES EVER', 'EVER3301', 'WOMANS SHOES', '', '1,', 0, 35, 0, '65', 0, 0, '', '8,,10,10,,', '3,,4,4,,', 6, 7, 4, '15-02-2023'),
(434, 'UNISEX SHOES', 'QS-050', 'UNISEX SHOES', '', '1,', 0, 65, 0, '100', 0, 0, '', '5,,4,4,,', '3,,7,7,,', 6, 5, 4, '15-02-2023'),
(435, 'WOMANS BOOT SHOES', 'HM9-3', 'WOMANS BOOT SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '8,,1,1,,', '3,,1,1,,', 6, 7, 4, '15-02-2023'),
(436, 'WOMANS BOOT SHOES', 'HM11-1', 'WOMANS BOOT SHOES', '', '1,', 0, 175, 0, '300', 0, 0, '', '8,,1,1,,', '3,,1,1,,', 6, 7, 4, '15-02-2023'),
(437, 'WOMANS SHOES', 'FC-1027#', 'WOMANS SHOES', '', '1,', 0, 150, 0, '250', 0, 0, '', '3,,1,1,,', '7,,1,1,,', 6, 4, 3, '15-02-2023'),
(438, 'WOMANS SHOES', 'FC-1100#', 'WOMANS SHOES', '', '1,', 0, 120, 0, '190', 0, 0, '', '6,,3,3,,', '5,,1,1,,|]>,<RED,[|3,,1,1,,', 7, 6, 3, '15-02-2023'),
(439, 'WOMANS SHOES', 'FC-934-1#', 'WOMANS SHOES', '', '1,', 0, 130, 0, '190', 0, 0, '', '3,,1,1,,', '5,,3,3,,', 7, 6, 3, '15-02-2023'),
(440, 'WOMANS SHOES', 'FC-1027#', 'WOMANS SHOES', '', '1,', 0, 150, 0, '250', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(441, 'WOMANS SHOES', 'FC-1048#', 'WOMANS SHOES', '', '1,', 0, 160, 0, '280', 0, 0, '', '7,,1,1,,', '3,,1,1,,', 8, 7, 8, '15-02-2023'),
(442, 'WOMANS SHOES', 'FC-975#', 'WOMANS SHOES', '', '1,', 0, 140, 0, '220', 0, 0, '', '3,,3,3,,', '5,,5,5,,', 7, 8, 6, '15-02-2023'),
(443, 'WOMANS SHOES', 'NFL-2259', 'WOMANS SHOES', '', '1,', 0, 140, 0, '250', 0, 0, '', '6,,3,3,,|]>)}\"', '', 0, 0, 0, '15-02-2023'),
(444, 'WOMANS SHOES', 'BF-969#', 'WOMANS SHOES', '', '1,', 0, 150, 0, '250', 0, 0, '', '5,,2,2,,|]>,<CHAMPEN,[|6,,1,1,,', '5,,1,1,,|]>,<GOLD,[|6,,1,1,,', 5, 0, 0, '15-02-2023'),
(445, 'WOMANS SHOES', 'FC-972', 'WOMANS SHOES', '', '1,', 0, 150, 0, '250', 0, 0, '', '7,,1,1,,', '5,,1,1,,', 8, 4, 4, '15-02-2023'),
(446, 'WOMANS SHOES', 'JX-19', 'WOMANS SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '5,,2,2,,', '7,,1,1,,|]>)}\"', 0, 0, 0, '15-02-2023'),
(447, 'WOMANS SHOES', 'RJM1658-1', 'WOMANS SHOES', '', '1,', 0, 175, 0, '250', 0, 0, '', '7,,2,2,,', '9,,1,1,,', 6, 0, 0, '15-02-2023'),
(448, 'WOMANS SHOES', 'RJL1605-7', 'WOMANS SHOES', '', '1,', 0, 175, 0, '250', 0, 0, '', '6,,1,3,,', '4,,1,1,,', 5, 6, 5, '15-02-2023'),
(449, 'WOMANS SHOES', 'RJL1073-23', 'WOMANS SHOES', '', '1,', 0, 175, 0, '250', 0, 0, '', '6,,3,3,,', '5,,3,3,,', 8, 7, 6, '15-02-2023'),
(450, 'WOMANS SHOES', 'B307', 'WOMANS SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '6,,1,1,,', '4,,1,1,,|]>,<BROWN,[|4,,2,2,,', 6, 5, 8, '15-02-2023'),
(451, 'WOMANS SHOES', 'A-146', 'WOMANS SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '6,,5,5,,', '5,,1,1,,', 8, 9, 7, '15-02-2023'),
(452, 'WOMANS SHOES GOLIBAS', 'YJJ10.11', 'WOMANS SHOES', '', '1,', 0, 150, 0, '220', 0, 0, '', '7,,2,2,,', '8,,1,1,,', 11, 8, 9, '15-02-2023'),
(453, 'WOMANS SPORT SHOES IN P.R.C', '', 'WOMANS SHOES', '', '1,', 0, 175, 0, '250', 0, 0, '', '6,,11,11,,', '5,,8,8,,', 8, 3, 7, '15-02-2023'),
(454, 'WOMANS SHOES RUNX', '', 'WOMANS SHOES', '', '1,', 0, 120, 0, '200', 0, 0, '', '11,,1,1,,|]>,<WHITE,[|10,,3,3,,', '13,,1,1,,', 12, 9, 9, '15-02-2023'),
(455, 'WOMANS SHOES', 'YYT005', 'WOMANS SHOES', '', '1,', 0, 175, 0, '350', 0, 0, '', '6,,3,3,,', '5,,2,2,,', 8, 7, 6, '15-02-2023'),
(456, 'WOMANS SHOES', 'SX001', 'WOMANS SHOES', '', '1,', 0, 180, 0, '250', 0, 0, '', '6,,3,3,,', '5,,3,3,,', 8, 7, 0, '15-02-2023'),
(1088, 'MANS WATCH BELLT ', '', 'WATCH', '', '1,', 0, 35, 0, '50', 0, 0, '', '', '', 0, 0, 1, '15-02-2023'),
(1138, 'N', '', '', '', '1,', 0, 0, 0, '0', 0, 0, '', '', '', 0, 0, 0, '15-02-2023'),
(1139, 'NewProduct', '', 'Bottoms', '', '1,', 0, 2, 213, '123', 0, 0, '[[\"Flag_squer\",[[\"C-11\",[[\"black\",[[\"75\",[[\"\",\"3\",\"3\",\"000\",\"Flag_squer_C-11_black_75_NewProduct_0.jpeg;Flag_squer_C-11_black_75_NewProduct_1.jpeg\"]]]]]]]]]]', '', 'disc', 0, 0, 0, '15-02-2023'),
(1140, 'newtest', '', '', '', '', 0, 10, 50, '15', 0, 0, '[[\"Flag_squer\",[[\"C11\",[[\"black\",[[\"75\",[[\"\",\"55\",\"55\",\"5456\",\"Flag_squer_C11_black_75_newtest_0.jpeg\"]]]]]]]]]]', '', 'undefined', 0, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `Shop_Id` int(11) NOT NULL,
  `Shop_name` varchar(255) DEFAULT NULL,
  `Shop_brand_name` varchar(255) DEFAULT NULL,
  `shop_type` varchar(255) DEFAULT NULL,
  `Shop_oweners_id` text DEFAULT NULL,
  `Shop_linke` varchar(255) DEFAULT NULL,
  `Shop_contact` text NOT NULL,
  `shop_email` varchar(255) DEFAULT NULL,
  `shop_phone_no` varchar(200) DEFAULT NULL,
  `Shop_location` varchar(255) DEFAULT NULL,
  `Shop_about` text DEFAULT NULL,
  `Shop_rate` longtext DEFAULT NULL,
  `Shop_likes` longtext DEFAULT NULL,
  `Shop_followers` longtext DEFAULT NULL,
  `Shop_items` longtext DEFAULT NULL,
  `Shop_workers` text DEFAULT NULL,
  `Shop_password` varchar(255) DEFAULT NULL,
  `Shop_contry` varchar(255) DEFAULT NULL,
  `Shop_settings` text DEFAULT NULL,
  `Shop_Page` longtext NOT NULL,
  `Shop_profile_img` varchar(255) DEFAULT NULL,
  `Shop_banner_imgs` text DEFAULT NULL,
  `Shop_Payment_Tools` longtext DEFAULT NULL,
  `Shop_balance` decimal(10,2) DEFAULT NULL,
  `Shop_payment_info` text DEFAULT NULL,
  `Shop_isenabled` int(10) NOT NULL DEFAULT 0,
  `Company_Started_Date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`Shop_Id`, `Shop_name`, `Shop_brand_name`, `shop_type`, `Shop_oweners_id`, `Shop_linke`, `Shop_contact`, `shop_email`, `shop_phone_no`, `Shop_location`, `Shop_about`, `Shop_rate`, `Shop_likes`, `Shop_followers`, `Shop_items`, `Shop_workers`, `Shop_password`, `Shop_contry`, `Shop_settings`, `Shop_Page`, `Shop_profile_img`, `Shop_banner_imgs`, `Shop_Payment_Tools`, `Shop_balance`, `Shop_payment_info`, `Shop_isenabled`, `Company_Started_Date`) VALUES
(1, 'Test_Shop_Name ', 'test_shop_brand_name', 'c', '', NULL, '[[\"Gmail\", \"Root@h\"], [\"Phone Number\",\"159753\"], [\"Location\", \"root\"]]', '', '', '', 'Welcome to our shop! We offer a wide range of products and excellent customer service. Our goal is to provide a great shopping experience for all our customers.\"\r\n```\r\nThis description is short, friendly, and informative, and should give customers a good idea of what to expect from your shop.\r\n\r\nIf you need a slightly longer description, here is another option:\r\n```\r\n\"Welcome to our shop! We are a team of passionate individuals dedicated to providing a great shopping experience for our customers. We offer a wide range of products, from [category1] to [category2], and strive to provide excellent customer service. Our goal is to make sure every customer leaves our shop happy and satisfied.', 'inf~[[\"13\",\"4\",\"04-07-2024\"]]', '0~[]', '1~[[\"13\",\"1\",\"04-07-2024\"]]', '230~[[\"13\",\"5\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"70\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"78\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"81\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"82\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"84\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"85\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"86\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"87\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"88\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"94\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"95\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"111\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"124\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"128\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"145\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"148\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"149\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"155\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"249\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"250\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"251\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"252\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"253\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"254\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"255\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"256\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"257\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"258\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"259\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"260\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"261\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"262\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"263\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"264\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"265\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"266\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"267\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"268\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"269\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"270\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"271\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"272\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"273\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"274\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"275\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"276\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"277\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"278\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"279\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"280\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"281\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"282\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"283\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"284\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"285\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"286\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"287\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"288\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"289\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"290\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"291\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"292\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"293\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"294\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"295\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"296\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"297\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"298\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"299\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"300\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"301\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"302\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"303\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"304\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"305\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"306\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"307\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"308\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"309\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"310\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"311\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"312\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"313\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"314\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"315\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"316\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"317\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"318\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"319\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"320\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"321\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"322\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"323\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"324\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"325\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"326\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"327\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"328\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"329\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"330\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"331\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"332\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"333\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"334\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"335\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"336\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"337\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"338\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"339\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"340\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"341\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"342\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"343\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"344\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"345\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"346\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"347\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"348\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"349\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"350\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"351\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"352\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"353\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"354\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"355\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"356\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"357\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"358\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"359\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"360\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"361\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"362\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"363\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"364\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"365\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"366\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"367\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"368\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"369\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"370\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"371\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"372\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"373\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"374\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"375\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"376\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"377\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"378\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"379\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"380\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"381\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"382\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"383\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"384\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"385\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"386\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"387\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"388\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"389\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"390\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"391\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"392\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"393\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"394\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"395\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"396\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"397\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"398\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"399\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"400\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"401\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"402\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"403\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"404\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"405\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"406\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"407\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"408\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"409\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"410\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"411\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"412\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"413\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"414\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"415\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"416\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"417\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"418\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"419\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"420\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"421\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"422\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"423\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"424\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"425\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"426\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"427\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"428\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"429\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"430\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"431\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"432\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"433\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"434\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"435\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"436\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"437\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"438\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"439\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"440\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"441\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"442\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"443\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"444\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"445\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"446\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"447\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"448\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"449\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"450\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"451\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"452\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"453\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"454\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"455\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"456\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"1088\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"1138\",\"15-02-2023\",\"04-07-2024\"],[\"13\",\"1139\",\"15-02-2023\",\"04-07-2024\"]]', '3~[[13,0,[21]],[\"14\",1,[0]],[\"14\",1,[0]]]', 'root', 'Sa', NULL, '[[\"COLLECTIONS\",0,\"25%\",\"\",0,\"COLLECTIONS\",\"\"],[\"New Arrival0\",true,\"\",\"\",\"\",\"ITEMS\",\"\",\"\"],[\"BANNERS\",0,\"50%\",\"\",0,\"BANNERS\",\"\"],[\"ITEMS\",0,\"70%\",\"\",0,\"ITEMS\",\"\"]]', NULL, NULL, '[[\"g\",\"668\",\"g\",\"6f\",\"356\",true,true,true,true,true,true],[\"Cash\",\"1\",\"1\",\"1\",\"1\",true,true,true,true,true,true],[\"Card\",\"2\",\"2\",\"2\",\"2\",true,false,false,false,true,false],[\"Credit\",\"3\",\"3\",\"3\",\"3\",true,false,true,true,false,false],[\"Credit\",\"3\",\"3\",\"3\",\"3\",true,false,true,true,false,false]]', NULL, NULL, 0, '19-04-1954'),
(2, NULL, NULL, NULL, NULL, NULL, '[[\"Email\", \"Root@h\"], [\"Phone Number\",\"159753\"], [\"Location\", \"root\"]]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 0, '19-05-994');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(255) NOT NULL,
  `user_fname` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_gender` char(255) DEFAULT NULL,
  `user_country` varchar(255) DEFAULT NULL,
  `user_phone_No` varchar(255) DEFAULT '',
  `user_email` varchar(255) DEFAULT NULL,
  `user_contact` longtext DEFAULT NULL,
  `user_home_No` varchar(255) DEFAULT NULL,
  `user_ID_Pp_ID` varchar(255) DEFAULT NULL,
  `user_postacode` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `user_about` varchar(255) DEFAULT NULL,
  `user_shops` varchar(255) DEFAULT NULL,
  `User_work_shop` text NOT NULL,
  `user_likes` varchar(255) DEFAULT NULL,
  `user_following_shop` varchar(255) DEFAULT NULL,
  `user_favoraite_items` varchar(255) DEFAULT NULL,
  `user_rate` varchar(255) DEFAULT NULL,
  `user_access` varchar(255) DEFAULT NULL,
  `User_pimg` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `user_fname`, `user_lname`, `user_name`, `user_gender`, `user_country`, `user_phone_No`, `user_email`, `user_contact`, `user_home_No`, `user_ID_Pp_ID`, `user_postacode`, `user_password`, `user_type`, `user_about`, `user_shops`, `User_work_shop`, `user_likes`, `user_following_shop`, `user_favoraite_items`, `user_rate`, `user_access`, `User_pimg`) VALUES
(13, 'Adem', 'Heyar', 'AH Adem', 'M', 'Ethiopia', '0612231353', 'Ademheyar@Gmail.Com', 'Mailodi', 'None', '191', '123', '321', 'User', NULL, '2~[[20, 1], [1, 1]]', '[[\"1\", \"Test_Shop_Name\", \"test_shop_brand_name\", \"10\"]]', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Adem', 'Heyar', 'AH Adem2', 'M', 'Ethiopia', '276', 'Ademheyar@gmail.com', 'Pritoria', '2', '3', '1', '123', 'User', NULL, NULL, '[[3, Test_Shop_Name, test_shop_brand_name, 10]]]]]', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`);

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
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`Shop_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1141;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `Shop_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
