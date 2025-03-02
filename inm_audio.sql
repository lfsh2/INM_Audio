-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 07:12 AM
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
-- Database: `inm_audio`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `admin_account_id` int(11) NOT NULL,
  `profile_pic` longblob DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`admin_account_id`, `profile_pic`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin', 'admin@gmail.com', '$2y$10$0tyqlNGA/EKnKwVmCnrqkuTo1H7lB6JnGYbUooeb5vBIYp2BD9Ug6', '', '2025-02-19 06:38:42', '2025-02-25 19:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `created_at`) VALUES
(1, 1, '2025-02-22 15:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`, `image`) VALUES
(1, 'Vanilla Series', NULL),
(2, 'Stage Series', NULL),
(3, 'Prestige Series', NULL),
(4, 'Personalized Series', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likes_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likes_id`, `user_id`, `product_id`) VALUES
(1, 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_details_id` int(11) NOT NULL,
  `total_sales` decimal(10,2) DEFAULT 0.00,
  `total_sold` int(11) DEFAULT 0,
  `total_cancelled` int(11) DEFAULT 0,
  `total_completed` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `date_completed` date DEFAULT NULL,
  `date_returned` date DEFAULT NULL,
  `date_cancelled` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `placedorders`
--

CREATE TABLE `placedorders` (
  `placed_order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `payment_method` varchar(10) DEFAULT NULL,
  `date_placed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `totalSold` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `stock_quantity`, `image_url`, `totalSold`, `created_at`, `updated_at`) VALUES
(1, 1, 'INM1 Vanilla', 'Dual Low-Mid Driver Single Mid High Driver Quad Balanced Amature Bass 10-20khz tuned for musicality and immersion detailed sound', 8650.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740160051_904cb561d6d19c41b20f.jpg', 0, '2025-02-21 09:47:31', '2025-02-21 09:47:31'),
(2, 1, 'INM2 Vanilla Classic', 'Dual Low-Mid Driver Single Mid High Driver Quad Balanced Amature Bass 10-20khz tuned for musicality and immersion detailed sound', 8650.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740160153_1e3e578b2ed7493b5617.jpg', 0, '2025-02-21 09:49:13', '2025-02-21 09:49:13'),
(3, 1, 'INM3 Universal', 'Dual Low-Mid Driver Single Mid High Driver Quad Balanced Amature Bass 10-20khz tuned for musicality and immersion detailed sound', 8650.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740160205_69bfd06836aa5fb962a5.jpg', 0, '2025-02-21 09:50:05', '2025-02-21 09:50:05'),
(4, 1, 'INM4 Google Dino', 'Dual Low-Mid Driver Single Mid High Driver Quad Balanced Amature Bass 10-20khz tuned for musicality and immersion detailed sound', 8650.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740160260_28a83fc3cde7ea570f02.jpg', 0, '2025-02-21 09:51:00', '2025-02-21 09:51:00'),
(5, 1, 'INM1 Glittered', 'Dual Low-Mid Driver Single Mid High Driver Quad Balanced Amature Bass 10-20khz tuned for musicality and immersion detailed sound', 8650.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740160449_91b57fac7e3e7b2b858c.jpg', 0, '2025-02-21 09:54:09', '2025-02-21 09:54:09'),
(6, 1, 'INM1 Vanilla Module', 'Dual Low-Mid Driver Single Mid High Driver Quad Balanced Amature Bass 10-20khz tuned for musicality and immersion detailed sound', 8650.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740160492_0f11e77916d79cb05355.jpg', 0, '2025-02-21 09:54:52', '2025-02-21 09:54:52'),
(7, 1, 'INM1 Kintsugi', 'Dual Low-Mid Driver Single Mid High Driver Quad Balanced Amature Bass 10-20khz tuned for musicality and immersion detailed sound', 8650.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740160536_dd27b44a4eeb49e5f9e2.jpg', 0, '2025-02-21 09:55:36', '2025-02-21 09:55:36'),
(8, 2, 'INM1 Stage Blue and Red Galaxy', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 11000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740161389_eb6096b4ee3083ebc284.jpg', 0, '2025-02-21 10:09:49', '2025-02-21 10:09:49'),
(9, 2, 'INM2 Stage Blue', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 11000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166078_442dcf87041e1dc0354e.jpg', 0, '2025-02-21 11:27:58', '2025-02-21 11:27:58'),
(10, 2, 'INM4 Stage', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 24000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166129_959f46563abb99fc8fa5.jpg', 0, '2025-02-21 11:28:49', '2025-02-21 11:28:49'),
(11, 2, 'INM2 Stage', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 11000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166165_303159b85632f599ba9b.jpg', 0, '2025-02-21 11:29:25', '2025-02-21 11:29:25'),
(12, 2, 'INM2 Stage Musical', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 11000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166210_b5a4b23dd2fbf88ff25d.jpg', 0, '2025-02-21 11:30:10', '2025-02-21 11:30:10'),
(13, 2, '1964 Ears V6 Stage', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 24000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166286_f84037d079607c7cf52e.jpg', 0, '2025-02-21 11:31:26', '2025-02-21 11:31:26'),
(14, 2, 'INM4 Stage Stellar', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 24000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166325_d49b3139cfc70a15ebe7.jpg', 0, '2025-02-21 11:32:05', '2025-02-21 11:32:05'),
(15, 2, 'INM2 Stage Fender 74 Sunburst', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 11000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166375_640b15d9fc194780bf53.jpg', 0, '2025-02-21 11:32:55', '2025-02-21 11:32:55'),
(16, 2, 'Aural Definition 4 Pro stage', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 17000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166410_868debe8810c4bab8665.jpg', 0, '2025-02-21 11:33:30', '2025-02-21 11:33:30'),
(17, 2, 'INM3 Stage', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 17000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166451_dcedcf8304ca526b5a58.jpg', 0, '2025-02-21 11:34:11', '2025-02-21 11:34:11'),
(18, 2, 'INM1 Stage Black and White', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 11000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166493_e8c1ed9f94e4c2ae2adf.jpg', 0, '2025-02-21 11:34:53', '2025-02-21 11:34:53'),
(19, 2, 'INM2 Stage Chi Evora', 'Warm and rich tuning Full bodied lows with smooth midrange Detailed yet non-fatiguing highs, designed for long performance session', 11000.00, 10, 'http://localhost/INM_Audio/public/admin/uploads/1740166525_69c3c95471c581025b4c.jpg', 0, '2025-02-21 11:35:25', '2025-02-21 11:35:25'),
(20, 3, 'INM8 Prestige', 'Ultimate Precision, Pure Excellence', 55000.00, 5, 'http://localhost/INM_Audio/public/admin/uploads/1740403960_0ad21177f3ca89ce0177.jpg', 0, '2025-02-24 05:32:40', '2025-02-24 05:32:40'),
(21, 4, '3Tone Gradient', 'Personalized Vanilla Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740405025_a791544c5a8e713e3ced.jpg', 0, '2025-02-24 05:50:25', '2025-02-24 05:50:25'),
(22, 4, 'INM2 Cat Dog Personalized', 'INM2 personalized with the clear and bassy sound ', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740409928_969c1191ab42a46b4fa5.jpg', 0, '2025-02-24 07:12:08', '2025-02-24 07:12:08'),
(23, 4, 'Cosmic Ears CE6P', 'Personalized Stage Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410024_fbe1287ff18706e79f7d.jpg', 0, '2025-02-24 07:13:44', '2025-02-24 07:13:44'),
(24, 4, 'Crystal', 'Personalized Vanilla Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410051_7be5e48ffbb205b1021a.jpg', 0, '2025-02-24 07:14:11', '2025-02-24 07:14:11'),
(25, 4, 'Custom Colors', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410081_92950ac7c40fad03a63a.jpg', 0, '2025-02-24 07:14:41', '2025-02-24 07:14:41'),
(26, 4, 'Earhy Blue Opal', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410113_aebb659847ee7d90a7a3.jpg', 0, '2025-02-24 07:15:13', '2025-02-24 07:15:13'),
(27, 4, 'Emerald Splash', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410137_b855792415db0efc25d9.jpg', 0, '2025-02-24 07:15:37', '2025-02-24 07:15:37'),
(28, 4, 'EX S WW', 'Persona', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410159_61bda3a4d737697429b5.jpg', 0, '2025-02-24 07:15:59', '2025-02-24 07:15:59'),
(29, 4, 'Fathers Day Special', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410188_1853da77ea0320ac84d9.jpg', 0, '2025-02-24 07:16:28', '2025-02-24 07:16:28'),
(30, 4, 'Floral Style', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410221_df5a454ee1916ab89781.jpg', 0, '2025-02-24 07:17:01', '2025-02-24 07:17:01'),
(31, 4, 'Forged Carbon', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410245_e388bfba897464a1552f.jpg', 0, '2025-02-24 07:17:25', '2025-02-24 07:17:25'),
(32, 4, 'Galaxy', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410295_762f5708efc8f69d4eeb.jpg', 0, '2025-02-24 07:18:15', '2025-02-24 07:18:15'),
(33, 4, 'Glowing Dust', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410321_21d8beb8dac56260d906.jpg', 0, '2025-02-24 07:18:41', '2025-02-24 07:18:41'),
(34, 4, 'Goldish Copper', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410346_91a52ada345cb2590597.jpg', 0, '2025-02-24 07:19:06', '2025-02-24 07:19:06'),
(35, 4, 'Gorilla Ears GX-3B Reshell', 'pers', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410372_45b2240f83c7b9a1836d.jpg', 0, '2025-02-24 07:19:32', '2025-02-24 07:19:32'),
(36, 4, 'INM1 Purple Galaxy', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740410411_6c47b50b71386ef57421.jpg', 0, '2025-02-24 07:20:11', '2025-02-24 07:20:11'),
(37, 4, 'INM4 MLB', 'Personalized Stage Series ', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412137_b636e309f37580c8cdb8.jpg', 0, '2025-02-24 07:48:57', '2025-02-24 07:48:57'),
(38, 4, 'Kanji', 'Personali', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412168_c65900a539c3edcafb50.jpg', 0, '2025-02-24 07:49:28', '2025-02-24 07:49:28'),
(39, 4, 'Luminous Petals', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412244_f248fde879a8f400a67e.jpg', 0, '2025-02-24 07:50:44', '2025-02-24 07:50:44'),
(40, 4, 'Matrix Red', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412302_60e4a49c449206041240.jpg', 0, '2025-02-24 07:51:42', '2025-02-24 07:51:42'),
(41, 4, 'Nebula', 'Person', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412398_277ca402fad075cebe36.jpg', 0, '2025-02-24 07:53:18', '2025-02-24 07:53:18'),
(42, 4, 'Noble Audio K10', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412431_a6eff9ff77a6c03b118d.jpg', 0, '2025-02-24 07:53:51', '2025-02-24 07:53:51'),
(43, 4, 'Noble Kaiser 10S', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412460_d70c99bfff32abd2079b.jpg', 0, '2025-02-24 07:54:20', '2025-02-24 07:54:20'),
(44, 4, 'Phoenix Red', 'Personalized Stage Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412490_5f100f8abafd396e0790.jpg', 0, '2025-02-24 07:54:50', '2025-02-24 07:54:50'),
(45, 4, 'Purple Jazz', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412521_2c8c17b41cdf68a9e36f.jpg', 0, '2025-02-24 07:55:21', '2025-02-24 07:55:21'),
(46, 4, 'QDC Remini', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412575_7662a58411f9a3c993e2.jpg', 0, '2025-02-24 07:56:15', '2025-02-24 07:56:15'),
(47, 4, 'Random', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412707_5f6ac9fb4dfde8a59a03.jpg', 0, '2025-02-24 07:58:27', '2025-02-24 07:58:27'),
(48, 4, 'Smoked Black', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412733_bb8ad29774a593d5b849.jpg', 0, '2025-02-24 07:58:53', '2025-02-24 07:58:53'),
(49, 4, 'Sparkle Eye Candies', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412761_76b29f24b141a6e2137e.jpg', 0, '2025-02-24 07:59:21', '2025-02-24 07:59:21'),
(50, 4, 'Talitha Koum', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412790_314879339edb2fa58b53.jpg', 0, '2025-02-24 07:59:50', '2025-02-24 07:59:50'),
(51, 4, 'Triclasm', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412816_57749a40aafebda06e3c.jpg', 0, '2025-02-24 08:00:16', '2025-02-24 08:00:16'),
(52, 4, 'Ultimate Ears 5 Pro', 'Personalized Stage Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412851_64f159060c77da62c3d7.jpg', 0, '2025-02-24 08:00:51', '2025-02-24 08:00:51'),
(53, 4, 'UM3RC Modular', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412882_0cabcc6d0649c91a532d.jpg', 0, '2025-02-24 08:01:22', '2025-02-24 08:01:22'),
(54, 4, 'Westone 2', 'Personalized Series', 0.00, 0, 'http://localhost/INM_Audio/public/admin/uploads/1740412912_30c76bc6cef51d792490.jpg', 0, '2025-02-24 08:01:52', '2025-02-24 08:01:52');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `shipping_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `user_id` int(11) NOT NULL,
  `profile_pic` longblob DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `zipcode` int(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activation` varchar(255) DEFAULT NULL,
  `remember_token` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`user_id`, `profile_pic`, `firstname`, `lastname`, `email`, `phone_number`, `country`, `city_municipality`, `zipcode`, `address`, `username`, `password`, `activation`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Edishan', 'Tenorio', 'edishanleetenorio03@gmail.com', '09299503384', NULL, NULL, NULL, NULL, 'shan', '$2y$10$f5DXspE8WclpXvl5zqdrNupqK2hOvxZy8RhD6Uj.panQ69jkWx/I.', 'activated', NULL, '2025-02-19 07:27:42', '2025-02-19 07:27:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`admin_account_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likes_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`order_details_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `placedorders`
--
ALTER TABLE `placedorders`
  ADD PRIMARY KEY (`placed_order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `admin_account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `placedorders`
--
ALTER TABLE `placedorders`
  MODIFY `placed_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `placedorders`
--
ALTER TABLE `placedorders`
  ADD CONSTRAINT `placedorders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `placedorders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `shippings`
--
ALTER TABLE `shippings`
  ADD CONSTRAINT `shippings_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
