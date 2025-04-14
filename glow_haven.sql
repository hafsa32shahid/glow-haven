-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 06:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `glow&haven`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_shade` varchar(255) DEFAULT 'No Shade',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_type` enum('cosmetics','jewelry') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `product_name`, `product_price`, `product_image`, `product_shade`, `created_at`, `updated_at`, `product_type`) VALUES
(37, NULL, 23, 7, 'Maybelline New York Fit Me', 4500.00, 'cosm-categories/1/Maybelline New York Fit Me/light.jpg', 'Medium', '2025-02-08 16:23:43', '2025-02-08 16:24:14', ''),
(40, NULL, 6, 3, 'delicate marquise adjustable silver bracelet', 3600.00, 'jewelry-categories/2/delicate marquise adjustable silver bracelet/delicate marquise adjustable silver bracelet.jpg', NULL, '2025-02-08 17:19:11', '2025-02-10 09:24:02', 'jewelry'),
(41, NULL, 5, 4, 'multi-faceted statement bracelet', 4300.00, 'jewelry-categories/2/multi-faceted statement bracelet/multi-faceted statement bracelet.jpeg', NULL, '2025-02-09 11:09:26', '2025-02-09 12:50:00', 'jewelry'),
(43, NULL, 3, 1, 'pendant 2 zc hearts lux88-slvr-clear', 7600.00, 'jewelry-categories/3/pendant 2 zc hearts lux88-slvr-clear/pendant 2 zc hearts lux88-slvr-clear.jpg', NULL, '2025-02-10 10:54:52', '2025-02-10 10:54:52', 'jewelry'),
(44, NULL, 1, 2, 'earing ad zc round pearl eleg', 4900.00, 'jewelry-categories/1/earing ad zc round pearl eleg/earing ad zc round pearl eleg.jpg', NULL, '2025-02-10 10:56:10', '2025-02-10 10:56:10', 'jewelry'),
(80, 1, 28, 4, 'Callista Wonder Volume Mascara', 5600.00, 'cosm-categories/3/Callista Wonder Volume Mascara/Callista Wonder Volume Mascara.jpg', 'Default', '2025-02-21 16:19:26', '2025-02-21 16:19:36', 'cosmetics'),
(82, 2, 6, 4, 'delicate marquise adjustable silver bracelet', 3600.00, 'jewelry-categories/2/delicate marquise adjustable silver bracelet/delicate marquise adjustable silver bracelet.jpg', NULL, '2025-02-25 13:00:29', '2025-02-25 13:00:36', 'jewelry');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Hafsa shahid', 'haf33@gmail.com', 'hello how are you', '2025-02-21 06:38:01'),
(2, 'Laiba shafique', 'laib33@gmail.com', 'hello wonderfull', '2025-02-21 07:03:11'),
(3, 'Laiba shafique', 'laiba@gmail.com', 'hello', '2025-02-21 16:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `cosmetic_categ`
--

CREATE TABLE `cosmetic_categ` (
  `cosmet_id` int(11) NOT NULL,
  `cosmet_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cosmetic_categ`
--

INSERT INTO `cosmetic_categ` (`cosmet_id`, `cosmet_name`) VALUES
(1, 'Face'),
(2, 'Eyes'),
(8, 'Lips'),
(10, 'Nail'),
(11, 'Tools'),
(12, 'Body'),
(13, 'Skincare');

-- --------------------------------------------------------

--
-- Table structure for table `cosmet_products`
--

CREATE TABLE `cosmet_products` (
  `id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `has_shades` tinyint(1) NOT NULL DEFAULT 0,
  `product_image` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cosmet_products`
--

INSERT INTO `cosmet_products` (`id`, `subcategory_id`, `product_name`, `product_price`, `has_shades`, `product_image`, `stock`) VALUES
(1, 1, 'Essence I Love Flawless Skin Foundation', 4600.00, 1, 'cosm-categories/1/Essence I Love Flawless Skin Foundation/light.jpg', 20),
(2, 2, 'elf. Hydrating Camo Concealer', 3200.00, 1, 'cosm-categories/2/elf. Hydrating Camo Concealer/light.jpg', 20),
(6, 3, 'ST London Luminous Lashes Volume Mascara', 4600.00, 0, 'cosm-categories/3/ST London Luminous Lashes Volume Mascara/ST London Luminous Lashes Volume Mascara.jpg', 0),
(10, 3, 'NONIZ Black Long Lasting Waterproof Lengthening Mascara', 2300.00, 0, 'cosm-categories/3/NONIZ Black Long Lasting Waterproof Lengthening Mascara/NONIZ Black Long Lasting Waterproof Lengthening Mascara.jpg', 20),
(15, 4, 'Morphe Making You Blush Sculpting Powder', 3400.00, 1, 'cosm-categories/4/Morphe Making You Blush Sculpting Powder/light.jpg', 20),
(22, 4, 'Pupa Milano Extreme Blush Duo Dual Effect Comp Blush', 200.00, 1, 'cosm-categories/4/Pupa Milano Extreme Blush Duo Dual Effect Comp Blush/medium.jpg', 0),
(23, 1, 'Maybelline New York Fit Me', 4500.00, 1, 'cosm-categories/1/Maybelline New York Fit Me/light.jpg', 10),
(24, 2, 'Shiseido Synchro Skin Self-Refreshing Concealer', 3400.00, 1, 'cosm-categories/2/Shiseido Synchro Skin Self-Refreshing Concealer/light.jpg', 10),
(27, 2, 'Nars Radiant Creamy Concealer', 4000.00, 0, 'cosm-categories/2/Nars Radiant Creamy Concealer/light.jpg', 10),
(28, 3, 'Callista Wonder Volume Mascara', 5600.00, 0, 'cosm-categories/3/Callista Wonder Volume Mascara/Callista Wonder Volume Mascara.jpg', 10),
(29, 1, 'Mac Studio Fix Fluid SPF 15', 5000.00, 1, 'cosm-categories/1/Mac Studio Fix Fluid SPF 15/light.jpg', 10),
(30, 5, 'Callista Shine Bestie Liquid Highlighter', 3400.00, 1, 'cosm-categories/5/Callista Shine Bestie Liquid Highlighter/light.jpg', 30),
(31, 6, 'Wet n Wild NEW! Prime Focus Impossible Primer', 3400.00, 1, 'cosm-categories/6/Wet n Wild NEW! Prime Focus Impossible Primer/Wet n Wild NEW! Prime Focus Impossible Primer.jpg', 20),
(32, 6, 'Make up Forever Step 1 Radiant Primer-Blue', 2000.00, 0, 'cosm-categories/6/Make up Forever Step 1 Radiant Primer-Blue/Make up Forever Step 1 Radiant Primer-Blue.png', 10),
(33, 5, 'LA Girl Strobe Lite Strobing Powder', 3000.00, 1, 'cosm-categories/5/LA Girl Strobe Lite Strobing Powder/light.webp', 30),
(34, 16, 'Rivaj UK Pink Magic Lip Balm', 200.00, 0, 'cosm-categories/16/Rivaj UK Pink Magic Lip Balm/Rivaj UK Pink Magic Lip Balm.jpg', 30),
(36, 6, 'The Balm Time Balm Face Primer Travel Size', 4500.00, 0, 'cosm-categories/6/The Balm Time Balm Face Primer Travel Size/The Balm Time Balm Face Primer Travel Size.webp', 30),
(37, 28, 'Revolution Skincare Superfruit Extract - Antioxidant Rich Serum & Primer', 1000.00, 0, 'cosm-categories/28/Revolution Skincare Superfruit Extract - Antioxidant Rich Serum & Primer/Revolution Skincare Superfruit Extract - Antioxidant Rich Serum & Primer.jpg', 25),
(38, 14, 'Pierre Cardin Paris Retro Matte Lipstick', 1500.00, 1, 'cosm-categories/14/Pierre Cardin Paris Retro Matte Lipstick/light.jpg', 30),
(39, 14, 'Wet n Wild Mega Last High-Shine Lip Color', 2000.00, 1, 'cosm-categories/14/Wet n Wild Mega Last High-Shine Lip Color/light.jpg', 25),
(40, 14, 'Maybelline Color Sensational Creamy Matte Lipstick', 2300.00, 1, 'cosm-categories/14/Maybelline Color Sensational Creamy Matte Lipstick/light.webp', 10),
(41, 15, 'elf Lip Plumping Gloss', 500.00, 1, 'cosm-categories/15/elf Lip Plumping Gloss/light.jpg', 20),
(42, 15, 'Huda Beauty Lip Strobe', 2300.00, 1, 'cosm-categories/15/Huda Beauty Lip Strobe/light.jpg', 25),
(43, 15, 'Lurella Lip Gloss', 3000.00, 1, 'cosm-categories/15/Lurella Lip Gloss/light.jpg', 25),
(45, 4, 'Dermacol Duo Blusher', 3000.00, 1, 'cosm-categories/4/Dermacol Duo Blusher/light.jpg', 10),
(46, 4, 'Laura Mercier Blush Color Infusion', 2000.00, 1, 'cosm-categories/4/Laura Mercier Blush Color Infusion/light.png', 25),
(47, 5, 'SH Star Show Pressed Highlighter', 1000.00, 1, 'cosm-categories/5/SH Star Show Pressed Highlighter/medium.png', 25),
(48, 7, 'MUICIN 2 In 1 3D Contour & Highlighter Stick', 2900.00, 1, 'cosm-categories/7/MUICIN 2 In 1 3D Contour & Highlighter Stick/light.jpg', 25),
(49, 7, 'MUICIN 2 In 1 3D Contour & Highlighter Stick', 2500.00, 1, 'cosm-categories/7/MUICIN 2 In 1 3D Contour & Highlighter Stick/light.jpg', 25),
(50, 8, 'Rude Too Much Drama 18 Eyeshadow Palette', 2000.00, 0, 'cosm-categories/8/Rude Too Much Drama 18 Eyeshadow Palette/Rude Too Much Drama 18 Eyeshadow Palette.jpg', 30),
(51, 8, 'Rude Manga Anime 35 Eyeshadow Palette - Book 2', 3400.00, 0, 'cosm-categories/8/Rude Manga Anime 35 Eyeshadow Palette - Book 2/Rude Manga Anime 35 Eyeshadow Palette - Book 2.webp', 30),
(52, 8, 'Rude Leopardina 12 Eyeshadows + 4 Highlighters', 2600.00, 0, 'cosm-categories/8/Rude Leopardina 12 Eyeshadows + 4 Highlighters/Rude Leopardina 12 Eyeshadows + 4 Highlighters.webp', 30),
(53, 9, 'Essence Lash Princess Liner Black', 300.00, 1, 'cosm-categories/9/Essence Lash Princess Liner Black/Essence Lash Princess Liner Black.jpg', 30),
(54, 9, 'Bourjois Repack Liner Feutre Ultra Black', 500.00, 0, 'cosm-categories/9/Bourjois Repack Liner Feutre Ultra Black/Bourjois Repack Liner Feutre Ultra Black.jpg', 25),
(55, 9, 'Wet n Wild Megaliner Liquid Eyeliner', 900.00, 0, 'cosm-categories/9/Wet n Wild Megaliner Liquid Eyeliner/Wet n Wild Megaliner Liquid Eyeliner.jpg', 25),
(56, 12, 'Rimmel Brow Pro Micro Precision Pen', 2300.00, 1, 'cosm-categories/12/Rimmel Brow Pro Micro Precision Pen/light.jpg', 25),
(57, 12, 'Wet n Wild Ultimate Brow Retractable', 780.00, 1, 'cosm-categories/12/Wet n Wild Ultimate Brow Retractable/light.jpg', 25),
(58, 12, 'Anastasia Dipbrow® Pomade', 400.00, 1, 'cosm-categories/12/Anastasia Dipbrow® Pomade/medium.webp', 30),
(59, 13, 'Moonrosh New York Procyon Eyelashes', 500.00, 1, 'cosm-categories/13/Moonrosh New York Procyon Eyelashes/Moonrosh New York Procyon Eyelashes.jpg', 30),
(60, 13, 'Zhoosh 8 Dandelion', 660.00, 1, 'cosm-categories/13/Zhoosh 8 Dandelion/Zhoosh 8 Dandelion.png', 25),
(61, 18, 'Max Factor Color Elixir Lip Liner', 1400.00, 1, 'cosm-categories/18/Max Factor Color Elixir Lip Liner/light.jpeg', 30),
(62, 18, 'Rimmel 1000 Kisses Lipliner', 800.00, 1, 'cosm-categories/18/Rimmel 1000 Kisses Lipliner/light.jpg', 25),
(63, 18, 'Rimmel Lipliner Lasting Finish', 890.00, 1, 'cosm-categories/18/Rimmel Lipliner Lasting Finish/light.jpeg', 30),
(64, 19, 'LA Colors Metal Nail Polish', 560.00, 1, 'cosm-categories/19/LA Colors Metal Nail Polish/light.jpeg', 30),
(65, 19, 'Pastel Cosmetics Nail Polish', 800.00, 1, 'cosm-categories/19/Pastel Cosmetics Nail Polish/light.webp', 30),
(66, 19, 'Pastel Cosmetics Nude Matte Nail Polish', 900.00, 1, 'cosm-categories/19/Pastel Cosmetics Nude Matte Nail Polish/medium.webp', 30),
(67, 20, 'First Choice Deluxe Toe Nail Clipper-41000', 700.00, 0, 'cosm-categories/20/First Choice Deluxe Toe Nail Clipper-41000/First Choice Deluxe Toe Nail Clipper-41000.jpeg', 30),
(68, 20, 'First Choice Deluxe Toe Nail Clipper-41000', 700.00, 0, 'cosm-categories/20/First Choice Deluxe Toe Nail Clipper-41000/Excellent Nail Buffer Shiner.jpg', 30),
(69, 20, 'Excellent Professional Scissors (Razor Edge)', 500.00, 0, 'cosm-categories/20/Excellent Professional Scissors (Razor Edge)/Excellent Professional Scissors (Razor Edge).jpg', 30),
(70, 21, 'Morphe Y6 Pro Flat Buffer', 800.00, 0, 'cosm-categories/21/Morphe Y6 Pro Flat Buffer/Morphe Y6 Pro Flat Buffer.jpg', 30),
(71, 21, 'MUICIN Kabuki Foundation Makeup Brush', 560.00, 0, 'cosm-categories/21/MUICIN Kabuki Foundation Makeup Brush/MUICIN Kabuki Foundation Makeup Brush.jpg', 30),
(72, 21, 'Lurella Neon Brush sets - Uranium', 500.00, 0, 'cosm-categories/21/Lurella Neon Brush sets - Uranium/Lurella Neon Brush sets - Uranium.jpg', 30),
(73, 22, 'elf Blending Sponge Duo', 400.00, 0, 'cosm-categories/22/elf Blending Sponge Duo/elf Blending Sponge Duo.png', 25),
(74, 22, 'Wet n Wild Hourglass Makeup Sponge', 900.00, 1, 'cosm-categories/22/Wet n Wild Hourglass Makeup Sponge/Wet n Wild Hourglass Makeup Sponge.jpg', 30),
(75, 22, 'BBA By Suleman Flat Tear Drop Blender', 700.00, 1, 'cosm-categories/22/BBA By Suleman Flat Tear Drop Blender/BBA By Suleman Flat Tear Drop Blender.jpg', 25),
(76, 23, 'BBA By Suleman Flat Tear Drop Blender', 1100.00, 0, 'cosm-categories/23/BBA By Suleman Flat Tear Drop Blender/Makari Golden Large Bag.webp', 30),
(77, 23, 'The Balm Clean and Green Travel Kit 5Pcs', 1200.00, 0, 'cosm-categories/23/The Balm Clean and Green Travel Kit 5Pcs/The Balm Clean and Green Travel Kit 5Pcs.jpg', 30),
(78, 24, 'Bath And Body Works Champagne Body Lotion 236ml', 1500.00, 0, 'cosm-categories/24/Bath And Body Works Champagne Body Lotion 236ml/Bath And Body Works Champagne Body Lotion 236ml.jpg', 25),
(79, 24, 'Bath And Body Works Eucalyptus Tea Moisturizing Body Lotion 192ml', 500.00, 1, 'cosm-categories/24/Bath And Body Works Eucalyptus Tea Moisturizing Body Lotion 192ml/Bath And Body Works Eucalyptus Tea Moisturizing Body Lotion 192ml.jpg', 30),
(80, 25, 'Safeguard Body Wash Lemon Fresh 400ml', 2500.00, 0, 'cosm-categories/25/Safeguard Body Wash Lemon Fresh 400ml/Safeguard Body Wash Lemon Fresh 400ml.jpg', 30),
(81, 25, 'St Ives Pink lemon & Mandarin Orange Body Wash 473ml', 340.00, 0, 'cosm-categories/25/St Ives Pink lemon & Mandarin Orange Body Wash 473ml/St Ives Pink lemon & Mandarin Orange Body Wash 473ml.jpg', 25),
(82, 26, 'Makari Extreme Argan & Carrot Botanical Body Oil 125ml', 400.00, 0, 'cosm-categories/26/Makari Extreme Argan & Carrot Botanical Body Oil 125ml/Makari Extreme Argan & Carrot Botanical Body Oil 125ml.webp', 25),
(83, 27, 'Estee Lauder Nutritious Super-Pomegranate Moisturizer 200ml', 1000.00, 0, 'cosm-categories/27/Estee Lauder Nutritious Super-Pomegranate Moisturizer 200ml/Estee Lauder Nutritious Super-Pomegranate Moisturizer 200ml.jpg', 30),
(84, 27, 'Mario Badescu Facial Spray With Aloe Vera Sage & Orange Blossom 118ml', 1200.00, 0, 'cosm-categories/27/Mario Badescu Facial Spray With Aloe Vera Sage & Orange Blossom 118ml/Mario Badescu Facial Spray With Aloe Vera Sage & Orange Blossom 118ml.webp', 25),
(85, 1, 'CeraVe Itch Relief Moisturizing Lotion for Dry and Itchy Skin Unscented 237ml', 1400.00, 0, 'cosm-categories/1/CeraVe Itch Relief Moisturizing Lotion for Dry and Itchy Skin Unscented 237ml/CeraVe Itch Relief Moisturizing Lotion for Dry and Itchy Skin Unscented 237ml.jpg', 30),
(86, 28, 'Pierre Cardin Paris Vitamin C Serum 30ml', 1500.00, 0, 'cosm-categories/28/Pierre Cardin Paris Vitamin C Serum 30ml/Pierre Cardin Paris Vitamin C Serum 30ml.jpg', 25),
(87, 28, 'Swisscode Bionic Recovering Complex 30ml', 1400.00, 0, 'cosm-categories/28/Swisscode Bionic Recovering Complex 30ml/Swisscode Bionic Recovering Complex 30ml.jpg', 25),
(88, 29, 'Ponds Sheet Mask Orange Nectar Hyaluronic Acid', 400.00, 0, 'cosm-categories/29/Ponds Sheet Mask Orange Nectar Hyaluronic Acid/Ponds Sheet Mask Orange Nectar Hyaluronic Acid.jpg', 25),
(89, 29, 'Purederm Relax Soothing Mud Sheet Mask', 300.00, 0, 'cosm-categories/29/Purederm Relax Soothing Mud Sheet Mask/Purederm Relax Soothing Mud Sheet Mask.png', 30),
(90, 29, 'Garnier Skin Active Hydra Bomb Sakura Tissue Face Mask Hydrating & Glow Boosting', 400.00, 0, 'cosm-categories/29/Garnier Skin Active Hydra Bomb Sakura Tissue Face Mask Hydrating & Glow Boosting/Garnier Skin Active Hydra Bomb Sakura Tissue Face Mask Hydrating & Glow Boosting.jpg', 25),
(91, 30, 'elf Pure Skin Cleanser', 1200.00, 0, 'cosm-categories/30/elf Pure Skin Cleanser/elf Pure Skin Cleanser.jpg', 30),
(92, 30, 'Redfinch Deep Cleanser 170g', 400.00, 0, 'cosm-categories/30/Redfinch Deep Cleanser 170g/Redfinch Deep Cleanser 170g.jpg', 25),
(93, 30, 'Derma Shine Brightening Deep Cleanser Orange 200g', 400.00, 0, 'cosm-categories/30/Derma Shine Brightening Deep Cleanser Orange 200g/Derma Shine Brightening Deep Cleanser Orange 200g.webp', 30),
(94, 30, 'Derma Shine Skin Polisher 200g', 900.00, 0, 'cosm-categories/30/Derma Shine Skin Polisher 200g/Derma Shine Skin Polisher 200g.webp', 30),
(95, 31, 'MUICIN Natural Extract Lily Toner 200ml', 1500.00, 0, 'cosm-categories/31/MUICIN Natural Extract Lily Toner 200ml/MUICIN Natural Extract Lily Toner 200ml.jpg', 30),
(96, 31, 'Revolution Skincare Revolution Skincare Hyaluronic Tonic', 2300.00, 0, 'cosm-categories/31/Revolution Skincare Revolution Skincare Hyaluronic Tonic/Revolution Skincare Revolution Skincare Hyaluronic Tonic.jpg', 25),
(98, 31, 'COSRX AHA 7 Whitehead Power Liquid 100ml', 1500.00, 0, 'cosm-categories/31/COSRX AHA 7 Whitehead Power Liquid 100ml/COSRX AHA 7 Whitehead Power Liquid 100ml.jpg', 25),
(99, 32, 'Himalaya Herbal Gentle Exfoliating Apricot Daily Scrub 150ml', 2400.00, 0, 'cosm-categories/32/Himalaya Herbal Gentle Exfoliating Apricot Daily Scrub 150ml/Himalaya Herbal Gentle Exfoliating Apricot Daily Scrub 150ml.jpg', 30),
(100, 32, 'Kielhs Clearly Corrective Brightening & Exfoliating Daily Cleanser30ml', 790.00, 0, 'cosm-categories/32/Kielhs Clearly Corrective Brightening & Exfoliating Daily Cleanser30ml/Kielhs Clearly Corrective Brightening & Exfoliating Daily Cleanser30ml.jpg', 30),
(101, 32, 'Saffron Skin Polisher 200g', 4500.00, 0, 'cosm-categories/32/Saffron Skin Polisher 200g/Saffron Skin Polisher 200g.jpg', 25),
(102, 33, 'Garnier Bright Complete Vitamin C Super UV Matte SPF 50 30ml', 2000.00, 0, 'cosm-categories/33/Garnier Bright Complete Vitamin C Super UV Matte SPF 50 30ml/Garnier Bright Complete Vitamin C Super UV Matte SPF 50 30ml.jpg', 30),
(103, 33, 'MUICIN Sunblock Defence Face & Body SPF-100 40ml', 3400.00, 0, 'cosm-categories/33/MUICIN Sunblock Defence Face & Body SPF-100 40ml/MUICIN Sunblock Defence Face & Body SPF-100 40ml.png', 30),
(104, 33, 'Cle De Peau Beaute 50 UV Protective Cream Tinted Broad Spectrum SPF 50+ Sunscreen', 4300.00, 0, 'cosm-categories/33/Cle De Peau Beaute 50 UV Protective Cream Tinted Broad Spectrum SPF 50+ Sunscreen/Cle De Peau Beaute 50 UV Protective Cream Tinted Broad Spectrum SPF 50+ Sunscreen.jpg', 25),
(105, 34, 'Essence Mattifying Compact Powder 11', 700.00, 0, 'cosm-categories/34/Essence Mattifying Compact Powder 11/Essence Mattifying Compact Powder 11.jpg', 30),
(106, 34, 'Kylie Pressed Illuminating Powder', 800.00, 0, 'cosm-categories/34/Kylie Pressed Illuminating Powder/Kylie Pressed Illuminating Powder.jpg', 25),
(107, 34, 'Color Studio Compact Power MATT High Defination', 800.00, 0, 'cosm-categories/34/Color Studio Compact Power MATT High Defination/Color Studio Compact Power MATT High Defination.jpg', 30);

-- --------------------------------------------------------

--
-- Table structure for table `cosm_subcategories`
--

CREATE TABLE `cosm_subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `disc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cosm_subcategories`
--

INSERT INTO `cosm_subcategories` (`id`, `category_id`, `subcategory_name`, `disc`) VALUES
(1, 1, 'Foundation', 'Foundation is a makeup essential that evens out skin tone and provides a smooth base for other products. It comes in various forms like liquid, cream, and powder, offering different coverage levels to suit individual needs. By concealing imperfections, it'),
(2, 1, 'concealer', 'Concealer is a versatile makeup product used to hide blemishes, dark circles, and other imperfections. It provides targeted coverage and works well for brightening specific areas of the face. Available in liquid, cream, and stick forms, concealer blends s'),
(3, 2, 'Maskara', 'Mascara enhances the beauty of your eyes by adding volume, length, and definition to your lashes. Designed to uplift your look, it comes in various shades and formulations for everyday wear or dramatic effects. From waterproof to curling and volumizing, m'),
(4, 1, 'Blush', 'Blush adds a natural flush of color to your cheeks, giving your face a healthy, radiant glow. Available in various shades and textures, it enhances your complexion and defines your cheekbones effortlessly. Whether you prefer a subtle tint or a bold pop of'),
(5, 1, 'Highlighter', 'Enhance your natural beauty with our silky, ultra-blendable highlighter that delivers a luminous glow. Perfect for accentuating cheekbones, brow bones, and the bridge of your nose, this long-lasting formula provides a radiant finish that complements all s'),
(6, 1, 'Primer', 'Create the perfect canvas for your makeup with our lightweight, smoothing primer. Designed to minimize pores, control shine, and extend the wear of your foundation, this primer leaves your skin feeling silky-soft and hydrated. Suitable for all skin types,'),
(7, 1, 'Contour products', 'Enhance your natural beauty with our premium contour products, designed to define and sculpt your features effortlessly. From soft, blendable powders to creamy sticks, our collection offers everything you need for a flawless, chiseled look. Perfect for al'),
(8, 2, 'Eyeshadow', 'Eyeshadow is a must-have in every makeup collection, allowing you to create endless looks, from soft and natural to bold and dramatic. Our eyeshadow collection features highly pigmented shades in matte, shimmer, and metallic finishes, ensuring smooth appl'),
(9, 2, 'Eyeliner', 'Eyeliner is the ultimate tool for defining and enhancing your eyes with precision. Whether you prefer a classic black wing, a bold graphic look, or a soft smoky effect, our eyeliner collection offers a variety of options, including liquid, gel, and pencil'),
(12, 2, 'Eyebrow Products', 'Eyebrow products are essential for shaping, defining, and enhancing your natural brows. Whether you prefer a bold, structured look or a soft, natural finish, our collection includes brow pencils, powders, gels, and pomades to suit every style. Designed for precision and long-lasting wear, our eyebrow products help you achieve perfectly groomed brows with ease. From filling in sparse areas to creating a flawless arch, enhance your beauty with effortlessly sculpted brows.'),
(13, 2, 'False Eyelashes', 'Enhance your natural beauty with our premium false eyelashes! Designed for comfort and a flawless look, these lightweight and reusable lashes add volume, length, and definition to your eyes. Perfect for everyday glam or special occasions, our lashes blend seamlessly with your natural lashes for a stunning, effortless finish. Easy to apply and remove, they’re the ultimate beauty essential for a captivating gaze'),
(14, 8, 'Lipstick', 'Add a pop of color to your look with our luxurious lipstick! Infused with nourishing ingredients, it glides on smoothly for a rich, long-lasting finish. Whether you prefer bold, vibrant shades or soft, natural tones, our lipstick provides intense pigmentation and a comfortable, non-drying feel. Perfect for any occasion, it keeps your lips hydrated and beautifully defined all day long.'),
(15, 8, 'Lip Gloss', 'Get glossy, luscious lips with our ultra-hydrating lip gloss! Designed for a non-sticky, high-shine finish, it glides on smoothly to enhance your natural beauty. Infused with nourishing ingredients, it keeps your lips soft, moisturized, and plump. Wear it alone for a subtle glow or layer it over lipstick for added shine and dimension. Perfect for any occasion, our lip gloss gives you the perfect touch of glamour.'),
(16, 8, 'Lip Balm', 'Keep your lips soft and nourished with our moisturizing lip balm! Enriched with hydrating ingredients, it soothes dry, chapped lips while providing long-lasting moisture. Its lightweight, non-greasy formula glides on smoothly, leaving your lips feeling smooth, supple, and naturally healthy. Perfect for daily use, our lip balm is your go-to essential for soft, kissable lips'),
(18, 8, 'Lip Liner', 'Define and perfect your lips with our precision lip liner! Designed for smooth application, this long-lasting formula enhances your natural lip shape while preventing lipstick from feathering or smudging. Whether you’re creating a bold, dramatic look or a soft, natural outline, our lip liner glides on effortlessly for a flawless finish. Wear it alone or pair it with your favorite lipstick for the perfect pout'),
(19, 10, 'Nail Polish', 'Elevate your nail game with our high-quality nail polish! Designed for a smooth application, rich pigmentation, and long-lasting wear, our formula ensures a flawless finish that resists chipping. Whether you prefer bold, classic, or trendy shades, our collection has the perfect color for every occasion.'),
(20, 10, 'Nail Tools', 'Get salon-perfect nails with our premium nail tools! 💅✨ Designed for precision, they ensure effortless grooming and shaping. Made from high-quality materials for durability and comfort. Perfect for both at-home and professional use.'),
(21, 11, 'Brushes', 'Enhance your nail artistry with our high-quality nail brushes! Designed for precision, these brushes ensure smooth polish application, intricate nail art, and effortless detailing. Made with soft yet durable bristles, they provide ultimate control for both beginners and professionals. Whether you\'re creating fine lines, gradients, or bold designs, our brushes help you achieve a flawless finish every time.'),
(22, 11, 'Sponges', 'Create stunning ombré and gradient nail designs with our premium nail art sponges! 🎨✨ Designed for smooth blending and effortless application, these soft, high-quality sponges help achieve flawless nail effects. Perfect for beginners and professionals, they ensure even color distribution and a salon-quality finish. Elevate your nail art game with ease.'),
(23, 11, 'Makeup Bags', 'Keep your beauty essentials organized with our elegant makeup bags! 💄✨ Designed for convenience and style, these bags offer ample storage for cosmetics, brushes, and skincare. Made from high-quality, durable materials, they are perfect for travel or daily use. Stay organized and glam on the go. '),
(24, 12, 'Body Lotion', 'Pamper your skin with our luxurious body lotion! 🌿✨ Infused with moisturizing ingredients, it deeply hydrates, leaving your skin soft, smooth, and radiant. Its lightweight, non-greasy formula absorbs quickly, providing long-lasting nourishment. Perfect for daily use to keep your skin glowing and healthy.'),
(25, 12, 'Body Wash', 'Indulge in a luxurious shower experience with our body wash! 🚿✨ Formulated to cleanse, hydrate, and refresh, it gently removes impurities while leaving your skin soft and nourished. Infused with skin-loving ingredients, it provides a rich lather and a lasting, refreshing scent. Perfect for daily use to keep your skin feeling fresh and revitalized.'),
(26, 12, 'Body Oil', 'Give your skin a radiant glow with our luxurious body oil! ✨💖 Enriched with nourishing ingredients, it deeply hydrates, softens, and enhances your skin’s natural beauty. The lightweight, non-greasy formula absorbs quickly, leaving a silky-smooth finish. Perfect for daily hydration and a healthy, luminous glow.'),
(27, 13, 'Moisturizers', 'Keep your skin soft, smooth, and hydrated with our nourishing moisturizer! ✨💖 Infused with skin-loving ingredients, it locks in moisture for long-lasting hydration and a healthy glow. The lightweight, non-greasy formula absorbs quickly, making it perfect for daily use. Say hello to radiant, refreshed skin.'),
(28, 13, 'Face Serum', 'Revitalize your skin with our powerful face serum! ✨💖 Packed with nourishing ingredients, it deeply hydrates, brightens, and smooths for a radiant complexion. The lightweight, fast-absorbing formula penetrates deeply to target fine lines, dullness, and uneven texture. Perfect for a healthy, youthful glow.'),
(29, 13, 'Face Mask', 'Give your skin a boost with our hydrating face mask! ✨💖 Formulated to deeply cleanse, hydrate, and refresh, it leaves your skin feeling soft, smooth, and radiant. Infused with skin-loving ingredients, it helps to detoxify and restore your natural glow. Perfect for a spa-like experience at home.'),
(30, 13, 'Cleansers', 'Refresh your skin with our deep-cleansing facial cleanser! ✨💖 Designed to remove dirt, oil, and impurities, it leaves your skin feeling clean, soft, and balanced. Infused with nourishing ingredients, it hydrates while maintaining your skin’s natural moisture. Perfect for daily use to achieve a fresh and radiant glow.'),
(31, 13, 'Toners', 'Balance and revitalize your skin with our gentle toner! ✨💖 Designed to remove excess oil, tighten pores, and restore hydration, it leaves your skin feeling fresh and smooth. Infused with nourishing ingredients, it preps your skin for better absorption of serums and moisturizers. Perfect for a healthy, glowing complexion.'),
(32, 13, 'Exfoliators', 'Reveal radiant skin with our exfoliator! ✨💖 Formulated to remove dead skin cells, unclog pores, and smooth texture, it leaves your skin fresh and glowing. Infused with nourishing ingredients, it hydrates while providing a deep yet gentle cleanse. Perfect for achieving a soft, healthy complexion.'),
(33, 13, 'Sunscreen', 'Shield your skin from harmful UV rays with our broad-spectrum sunscreen! ☀️✨ Designed for daily wear, it provides powerful protection while keeping your skin hydrated and nourished. The lightweight, non-greasy formula absorbs quickly, leaving a smooth, matte finish. Perfect for all skin types to maintain a healthy, glowing complexion.'),
(34, 1, 'Setting Powder', 'Lock in your makeup and stay shine-free all day with our lightweight, translucent setting powder. Designed to blur imperfections, control oil, and provide a smooth, airbrushed finish, this powder ensures your makeup stays fresh and flawless for hours.');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type` enum('cosmetics','jewelry') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `product_type`, `created_at`) VALUES
(10, 2, 33, 'cosmetics', '2025-02-15 13:32:58'),
(12, 2, 34, 'cosmetics', '2025-02-20 07:19:02'),
(13, 2, 10, 'jewelry', '2025-02-21 10:53:06'),
(14, 2, 6, 'jewelry', '2025-02-21 11:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `jewelery_categories`
--

CREATE TABLE `jewelery_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jewelery_categories`
--

INSERT INTO `jewelery_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Earrings', '\"Crafted with a blend of contemporary and traditional styles, these hoop earrings are designed for versatility. Featuring fine detailing and a sleek finish, they exude effortless charm. Whether paired with casual attire or formal wear, these earrings elevate your look instantly.\"', '2025-02-01 17:43:05'),
(2, 'Bracelete', 'Add a touch of luxury to your wrist with this gold-plated chain bracelet, featuring a timeless link design. Its high-quality craftsmanship ensures durability, while its classic aesthetic makes it suitable for any occasion. Pair it with matching jewelry for a polished look.', '2025-02-01 17:45:19'),
(3, 'Necklace', 'Simplicity at its best, this minimalist necklace is designed for everyday elegance. Its sleek and clean design makes it versatile and suitable for both work and casual outings. An essential piece for your jewelry collection.', '2025-02-01 17:48:53'),
(4, 'Rings', 'Discover our exquisite collection of rings, crafted to perfection for every occasion. From timeless classics to modern designs, our rings are made with high-quality materials, including sterling silver, gold, and precious gemstones. Whether you\'re looking for a statement piece or a subtle everyday ring, our collection offers something unique for everyone. Elevate your style with rings that shine with elegance and sophistication.', '2025-02-17 15:02:40'),
(6, 'Anklets', 'Anklets are the perfect accessory to add a touch of elegance and charm to your look. Crafted with intricate designs and high-quality materials, our anklets are designed to complement any style, from traditional to modern. Whether you prefer delicate chains, beaded patterns, or statement pieces, our collection offers a variety of options to suit your taste. Perfect for everyday wear or special occasions, these anklets enhance your beauty with a subtle yet stylish touch. Explore our collection and find the perfect anklet to complete your jewelry collection.', '2025-02-19 08:34:40'),
(7, 'Brooches', 'Brooches are timeless accessories that add elegance and sophistication to any outfit. Whether you prefer classic, vintage, or modern designs, our collection offers a variety of beautifully crafted brooches to suit your style. Made with high-quality materials and intricate detailing, these statement pieces are perfect for enhancing dresses, scarves, or even handbags. From floral motifs to sparkling gemstones, our brooches are designed to make a lasting impression. Elevate your look with a touch of charm and elegance from our exclusive brooch collection.', '2025-02-19 08:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `jewelry_products`
--

CREATE TABLE `jewelry_products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jewelry_products`
--

INSERT INTO `jewelry_products` (`id`, `category_id`, `product_name`, `product_price`, `description`, `product_image`, `created_at`, `updated_at`, `stock`) VALUES
(1, 1, 'earing ad zc round pearl eleg', 4900.00, NULL, 'jewelry-categories/1/earing ad zc round pearl eleg/earing ad zc round pearl eleg.jpg', '2025-02-03 18:02:49', '2025-02-20 06:28:39', 0),
(3, 3, 'pendant 2 zc hearts lux88-slvr-clear', 7600.00, NULL, 'jewelry-categories/3/pendant 2 zc hearts lux88-slvr-clear/pendant 2 zc hearts lux88-slvr-clear.jpg', '2025-02-05 09:34:27', '2025-02-08 12:06:41', 10),
(4, 1, 'claw shaped fancy xircon silver earrings', 5000.00, NULL, 'jewelry-categories/1/claw shaped fancy xircon silver earrings/claw shaped fancy xircon silver earrings.jpg', '2025-02-08 16:55:25', '2025-02-13 16:36:50', 9),
(5, 2, 'multi-faceted statement bracelet', 4300.00, NULL, 'jewelry-categories/2/multi-faceted statement bracelet/multi-faceted statement bracelet.jpeg', '2025-02-08 16:55:52', '2025-02-13 16:24:17', 20),
(6, 2, 'delicate marquise adjustable silver bracelet', 3600.00, NULL, 'jewelry-categories/2/delicate marquise adjustable silver bracelet/delicate marquise adjustable silver bracelet.jpg', '2025-02-08 16:56:18', '2025-02-08 16:56:18', 0),
(7, 1, 'chic long leaves gold earrings', 3000.00, NULL, 'jewelry-categories/1/chic long leaves gold earrings/chic long leaves gold earrings.jpg', '2025-02-14 18:13:28', '2025-02-14 18:13:28', 0),
(8, 4, 'extravagant emerald cut halo silver ring', 6500.00, NULL, 'jewelry-categories/4/extravagant emerald cut halo silver ring/extravagant emerald cut halo silver ring.jpg', '2025-02-17 15:09:00', '2025-02-17 15:09:00', 0),
(9, 3, 'gorgeous floral pearl silver pendant', 3000.00, NULL, 'jewelry-categories/3/gorgeous floral pearl silver pendant/gorgeous floral pearl silver pendant.jpg', '2025-02-17 19:25:01', '2025-02-17 19:25:01', 0),
(10, 6, 'Golden Ethnic Anklets Pair', 4900.00, NULL, 'jewelry-categories/6/Golden Ethnic Anklets Pair/Golden Ethnic Anklets Pair.png', '2025-02-19 18:45:16', '2025-02-19 18:45:16', 0),
(11, 3, 'simple silver bar pendant', 3000.00, NULL, 'jewelry-categories/3/simple silver bar pendant/simple silver bar pendant.jpg', '2025-02-25 16:45:09', '2025-02-25 16:45:09', 0),
(12, 3, 'enchanting blue drop pendant', 4000.00, NULL, 'jewelry-categories/3/enchanting blue drop pendant/enchanting blue drop pendant.jpg', '2025-02-25 16:45:29', '2025-02-25 16:45:29', 0),
(13, 3, 'magnetizing mono-strand square zircon necklace', 3000.00, NULL, 'jewelry-categories/3/magnetizing mono-strand square zircon necklace/magnetizing mono-strand square zircon necklace.jpeg', '2025-02-25 16:45:49', '2025-02-25 16:45:49', 0),
(14, 2, 'linear cluster set tennis bracelet', 2800.00, NULL, 'jewelry-categories/2/linear cluster set tennis bracelet/linear cluster set tennis bracelet.jpeg', '2025-02-25 16:46:24', '2025-02-25 16:46:24', 0),
(15, 2, 'stunning green oval solitaire wreath bracelet', 3000.00, NULL, 'jewelry-categories/2/stunning green oval solitaire wreath bracelet/stunning green oval solitaire wreath bracelet.jpg', '2025-02-25 16:46:46', '2025-02-25 16:46:46', 0),
(16, 2, 'slim zircon paved bangle', 2300.00, NULL, 'jewelry-categories/2/slim zircon paved bangle/slim zircon paved bangle.jpeg', '2025-02-25 16:47:19', '2025-02-25 16:47:19', 0),
(17, 4, 'bright firework gold ring', 3300.00, NULL, 'jewelry-categories/4/bright firework gold ring/bright firework gold ring.jpg', '2025-02-25 16:48:05', '2025-02-25 16:48:05', 0),
(18, 4, 'delicate pearl gold ring', 4400.00, NULL, 'jewelry-categories/4/delicate pearl gold ring/delicate pearl gold ring.jpg', '2025-02-25 16:48:27', '2025-02-25 16:48:27', 0),
(19, 4, 'ring baguet zircon band silver', 2200.00, NULL, 'jewelry-categories/4/ring baguet zircon band silver/ring baguet zircon band silver.jpg', '2025-02-25 16:48:46', '2025-02-25 16:48:46', 0),
(21, 4, 'tri-shank solitaire ring', 2300.00, NULL, 'jewelry-categories/4/tri-shank solitaire ring/tri-shank solitaire ring.jpg', '2025-02-25 16:50:26', '2025-02-25 16:50:26', 0),
(22, 6, 'Statement Ethnic Indian Anklets', 3400.00, NULL, 'jewelry-categories/6/Statement Ethnic Indian Anklets/Statement Ethnic Indian Anklets.png', '2025-02-25 16:51:19', '2025-02-25 16:51:19', 0),
(23, 7, 'Floral Brooch', 600.00, NULL, 'jewelry-categories/7/Floral Brooch/Floral Brooch.jpeg', '2025-02-25 16:52:01', '2025-02-25 16:52:01', 0),
(24, 7, 'Rose Brooch', 500.00, NULL, 'jewelry-categories/7/Rose Brooch/Rose Brooch.jpeg', '2025-02-25 16:52:27', '2025-02-25 16:52:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `work_phone` varchar(20) NOT NULL,
  `cell_no` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `category` varchar(50) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `o_status` varchar(50) NOT NULL DEFAULT 'order placed',
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `address`, `email`, `work_phone`, `cell_no`, `dob`, `category`, `order_date`, `o_status`, `total_price`) VALUES
(4, 2, 'Hafsa shahid', 'shah faisal colony no 1', 'haf33@gmail.com', '3245671', '1298542', '2005-07-30', 'Individual', '2025-02-12 07:28:40', 'Shipped', 0.00),
(5, 1, 'Laiba shafique', 'shahfaisal colony no2', 'laiba@gmail.com', '3245671', '1298542', '2006-07-12', 'Individual', '2025-02-12 07:36:57', 'Delivered', 22000.00),
(6, 2, 'Hafsa shahid', 'shahfaisal colony no3', 'haf33@gmail.com', '3245671', '1298542', '2005-07-30', 'Individual', '2025-02-13 05:56:37', 'Delivered', 0.00),
(7, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2007-07-09', 'Individual', '2025-02-13 06:02:28', 'order placed', 0.00),
(8, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2005-07-30', 'Individual', '2025-02-13 06:07:21', 'order placed', 0.00),
(9, 2, 'Hafsa shahid', 'shahfaisal colony no3', 'haf33@gmail.com', '3245671', '1298542', '2005-07-30', 'Individual', '2025-02-13 07:24:58', 'Delivered', 0.00),
(10, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2005-07-30', 'Individual', '2025-02-13 07:31:56', 'order placed', 0.00),
(11, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2006-06-13', 'Individual', '2025-02-13 07:46:03', 'order placed', 4300.00),
(12, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2006-06-13', 'Individual', '2025-02-13 07:46:30', 'order placed', 4300.00),
(13, 2, 'Hafsa shahid', 'shah faisal colony no 1', 'haf33@gmail.com', '3245671', '1298542', '2003-07-13', 'Individual', '2025-02-13 07:50:53', 'order placed', 5600.00),
(14, 2, 'Hafsa shahid', 'shah faisal colony no 1', 'haf33@gmail.com', '3245671', '1298542', '2003-07-13', 'Individual', '2025-02-13 07:51:35', 'order placed', 0.00),
(15, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2005-07-30', 'Individual', '2025-02-13 16:00:52', 'order placed', 14700.00),
(16, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2005-06-06', 'Individual', '2025-02-13 16:36:50', 'order placed', 5000.00),
(17, 2, 'Hafsa shahid', 'shah faisal colony no 1', 'haf33@gmail.com', '3245671', '1298542', '2005-06-13', 'Individual', '2025-02-13 16:38:22', 'order placed', 17000.00),
(18, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2005-07-20', 'Individual', '2025-02-20 06:28:39', 'order placed', 49000.00),
(19, 2, 'Hafsa shahid', 'shahfaisal colony no4', 'haf33@gmail.com', '3245671', '1298542', '2005-07-20', 'Individual', '2025-02-20 06:30:18', 'order placed', 4000.00),
(20, 2, 'shahid zubair', 'Vf Hwyhjg', 'haf33@gmail.com', '3245671', '111', '0001-11-11', 'Individual', '2025-02-22 13:29:42', 'order placed', 38600.00),
(21, 3, 'Nida', 'shahfaisal colony no4', 'nida@gmail.com', '3245671', '1298542', '2004-02-25', 'Individual', '2025-02-25 06:23:22', 'order placed', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type` enum('cosmetics','jewelry') NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_type`, `quantity`, `price`, `product_name`) VALUES
(1, 4, 1, '', 1, 4600.00, 'Essence I Love Flawless Skin Foundation'),
(2, 5, 24, '', 8, 3400.00, 'Shiseido Synchro Skin Self-Refreshing Concealer'),
(3, 5, 6, '', 1, 4600.00, 'ST London Luminous Lashes Volume Mascara'),
(4, 6, 10, '', 1, 2300.00, 'NONIZ Black Long Lasting Waterproof Lengthening Mascara'),
(5, 7, 2, '', 1, 3200.00, 'elf. Hydrating Camo Concealer'),
(6, 8, 27, '', 1, 4000.00, 'Nars Radiant Creamy Concealer'),
(7, 9, 24, '', 1, 3400.00, 'Shiseido Synchro Skin Self-Refreshing Concealer'),
(8, 9, 23, '', 1, 4500.00, 'Maybelline New York Fit Me'),
(9, 9, 29, 'cosmetics', 1, 5000.00, 'Mac Studio Fix Fluid SPF 15'),
(10, 9, 22, 'cosmetics', 1, 200.00, 'Pupa Milano Extreme Blush Duo Dual Effect Comp Blush'),
(11, 10, 6, 'jewelry', 1, 3600.00, 'delicate marquise adjustable silver bracelet'),
(12, 12, 5, 'jewelry', 1, 4300.00, 'multi-faceted statement bracelet'),
(13, 13, 28, 'cosmetics', 1, 5600.00, 'Callista Wonder Volume Mascara'),
(14, 15, 1, 'jewelry', 3, 4900.00, 'earing ad zc round pearl eleg'),
(15, 16, 4, 'jewelry', 1, 5000.00, 'claw shaped fancy xircon silver earrings'),
(16, 17, 24, 'cosmetics', 5, 3400.00, 'Shiseido Synchro Skin Self-Refreshing Concealer'),
(17, 18, 1, 'jewelry', 10, 4900.00, 'earing ad zc round pearl eleg'),
(18, 19, 34, 'cosmetics', 20, 200.00, 'Rivaj UK Pink Magic Lip Balm'),
(19, 20, 6, 'jewelry', 6, 3600.00, 'delicate marquise adjustable silver bracelet'),
(20, 20, 24, 'cosmetics', 5, 3400.00, 'Shiseido Synchro Skin Self-Refreshing Concealer'),
(21, 21, 22, 'cosmetics', 1, 200.00, 'Pupa Milano Extreme Blush Duo Dual Effect Comp Blush');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `reviews` text DEFAULT NULL,
  `category` enum('cosmetics','jewelry') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `full_name`, `email`, `rating`, `reviews`, `category`, `created_at`) VALUES
(1, 2, 0, 'Hafsa', 'haf33@gmail.com', 3, '0', 'cosmetics', '2025-02-02 19:37:54'),
(3, 10, 0, 'Rabia', 'rabi33@gmail.com', 4, '0', 'cosmetics', '2025-02-03 16:56:26'),
(11, 10, 0, 'Rabia', 'rabi33@gmail.com', 3, '0', 'cosmetics', '2025-02-05 07:45:09'),
(12, 10, 0, 'Alisha', 'alisha33@gmail.com', 3, '0', 'cosmetics', '2025-02-05 07:50:20'),
(13, 22, 0, 'Hafsa', 'haf33@gmail.com', 4, '0', 'cosmetics', '2025-02-05 07:54:34'),
(14, 24, 0, 'Rani ', 'rani3@gmail.com', 5, '0', 'cosmetics', '2025-02-08 16:34:59'),
(15, 24, 0, 'Hafsa', 'haf33@gmail.com', 4, '0', 'cosmetics', '2025-02-08 16:38:53'),
(16, 28, 0, 'Hafsa', 'haf33@gmail.com', 5, '', 'cosmetics', '2025-02-08 16:41:38'),
(17, 6, 2, 'Hafsa', 'haf33@gmail.com', 4, 'excellent', 'cosmetics', '2025-02-12 17:42:53'),
(18, 1, 2, 'Hafsa', 'haf33@gmail.com', 4, 'amazing product', 'cosmetics', '2025-02-13 15:56:58'),
(20, 29, 2, 'Rabia', 'fgy@gmail.com', 5, 'amazing product', 'cosmetics', '2025-02-13 17:05:15'),
(24, 27, 2, 'Hafsa', 'haf33@gmail.com', 4, 'excellent product', 'cosmetics', '2025-02-13 18:01:39'),
(25, 5, 2, 'Hafsa', 'haf33@gmail.com', 4, 'good product ', 'jewelry', '2025-02-13 18:22:28'),
(26, 4, 2, 'Hafsa', 'haf33@gmail.com', 4, 'excellent', 'jewelry', '2025-02-13 18:42:14'),
(27, 10, 2, 'Hafsa', 'haf33@gmail.com', 4, 'excellent', 'cosmetics', '2025-02-13 18:44:58'),
(28, 3, 2, 'Rabia', 'rabi33@gmail.com', 4, 'amazing product', 'jewelry', '2025-02-14 06:11:01'),
(29, 6, 2, 'Hafsa', 'haf33@gmail.com', 3, 'very good', 'cosmetics', '2025-02-14 06:17:32'),
(30, 6, 2, 'Alisha', 'alisha33@gmail.com', 4, 'zabardast', 'cosmetics', '2025-02-14 06:19:32'),
(31, 6, 2, 'fari', 'fari@gmail.com', 3, 'very good', 'cosmetics', '2025-02-14 06:21:15'),
(32, 6, 2, 'alina', 'alina@gmail.com', 4, 'zabardast', 'cosmetics', '2025-02-14 06:23:34'),
(33, 7, 2, 'Hafsa', 'haf33@gmail.com', 4, 'wonderfull product', 'jewelry', '2025-02-21 10:23:49'),
(34, 15, 2, 'Hafsa', 'haf33@gmail.com', 4, 'excellent', 'cosmetics', '2025-02-21 10:35:12'),
(35, 10, 2, 'Rabia', 'rabi33@gmail.com', 4, 'excellent', 'cosmetics', '2025-02-21 10:36:04'),
(36, 10, 2, 'Hafsa', 'haf33@gmail.com', 4, 'excellent', 'cosmetics', '2025-02-21 10:41:45'),
(37, 10, 2, 'Rabia', 'haf33@gmail.com', 4, 'very good product', 'cosmetics', '2025-02-21 10:48:27'),
(38, 10, 2, 'Rabia', 'rabi33@gmail.com', 4, 'excellent', 'cosmetics', '2025-02-21 10:53:49'),
(39, 10, 2, 'Rabia', 'haf33@gmail.com', 4, 'zabardast', 'jewelry', '2025-02-21 11:05:14'),
(40, 28, 2, 'Alisha', 'alisha33@gmail.com', 4, 'very good', 'cosmetics', '2025-02-21 11:07:29'),
(41, 104, 2, 'Rabia', 'rabi33@gmail.com', 4, 'very good product', 'cosmetics', '2025-02-25 16:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `shades`
--

CREATE TABLE `shades` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `shade_name` varchar(255) NOT NULL,
  `shade_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shades`
--

INSERT INTO `shades` (`id`, `product_id`, `shade_name`, `shade_image`) VALUES
(1, 1, 'light', 'cosm-categories/1/Essence I Love Flawless Skin Foundation/shades/light.jpg'),
(2, 1, 'medium', 'cosm-categories/1/Essence I Love Flawless Skin Foundation/shades/medium.jpg'),
(3, 1, 'dark', 'cosm-categories/1/Essence I Love Flawless Skin Foundation/shades/dark.jpg'),
(4, 2, 'light', 'cosm-categories/2/elf. Hydrating Camo Concealer/shades/light.jpg'),
(5, 2, 'medium', 'cosm-categories/2/elf. Hydrating Camo Concealer/shades/medium.jpg'),
(6, 2, 'dark', 'cosm-categories/2/elf. Hydrating Camo Concealer/shades/dark.jpg'),
(15, 15, 'light', 'cosm-categories/4/Morphe Making You Blush Sculpting Powder/shades/light.jpg'),
(16, 15, 'Medium', 'cosm-categories/4/Morphe Making You Blush Sculpting Powder/shades/medium.jpg'),
(17, 15, 'Dark', 'cosm-categories/4/Morphe Making You Blush Sculpting Powder/shades/dark.jpg'),
(18, 22, 'light', 'cosm-categories/4/Pupa Milano Extreme Blush Duo Dual Effect Comp Blush/shades/light.jpg'),
(19, 22, 'Medium', 'cosm-categories/4/Pupa Milano Extreme Blush Duo Dual Effect Comp Blush/shades/medium.jpg'),
(20, 22, 'dark', 'cosm-categories/4/Pupa Milano Extreme Blush Duo Dual Effect Comp Blush/shades/dark.jpg'),
(21, 23, 'Light', 'cosm-categories/1/Maybelline New York Fit Me/shades/light.jpg'),
(22, 23, 'Medium', 'cosm-categories/1/Maybelline New York Fit Me/shades/medium.jpg'),
(23, 23, 'Dark', 'cosm-categories/1/Maybelline New York Fit Me/shades/dark.jpg'),
(24, 24, 'light', 'cosm-categories/2/Shiseido Synchro Skin Self-Refreshing Concealer/shades/light.jpg'),
(25, 24, 'Medium', 'cosm-categories/2/Shiseido Synchro Skin Self-Refreshing Concealer/shades/medium.jpg'),
(26, 24, 'Dark', 'cosm-categories/Shiseido Synchro Skin Self-Refreshing Concealer/shades/dark.jpg'),
(30, 27, 'Light', 'cosm-categories/2/Nars Radiant Creamy Concealer/shades/light.jpg'),
(31, 27, 'Medium', 'cosm-categories/2/Nars Radiant Creamy Concealer/shades/medium.jpg'),
(32, 27, 'Dark', 'cosm-categories/2/Nars Radiant Creamy Concealer/shades/dark.jpg'),
(33, 29, 'Light', 'cosm-categories/1/Mac Studio Fix Fluid SPF 15/shades/light.jpg'),
(34, 29, 'Medium', 'cosm-categories/1/Mac Studio Fix Fluid SPF 15/shades/medium.jpg'),
(35, 29, 'Dark', 'cosm-categories/1/Mac Studio Fix Fluid SPF 15/shades/dark.jpg'),
(36, 30, 'light', 'cosm-categories/5/Callista Shine Bestie Liquid Highlighter/shades/light.jpg'),
(37, 30, 'Medium', 'cosm-categories/5/Callista Shine Bestie Liquid Highlighter/shades/medium.jpg'),
(38, 30, 'Dark', 'cosm-categories/5/Callista Shine Bestie Liquid Highlighter/shades/dark.jpg'),
(39, 33, 'Light', 'cosm-categories/5/LA Girl Strobe Lite Strobing Powder/shades/light.webp'),
(40, 33, 'Medium', 'cosm-categories/5/LA Girl Strobe Lite Strobing Powder/shades/medium.jpg'),
(41, 33, 'Drak', 'cosm-categories/5/LA Girl Strobe Lite Strobing Powder/shades/dark.jpg'),
(42, 38, 'Light', 'cosm-categories/14/Pierre Cardin Paris Retro Matte Lipstick/shades/light.jpg'),
(43, 38, 'Medium', 'cosm-categories/14/Pierre Cardin Paris Retro Matte Lipstick/shades/medium.jpg'),
(44, 38, 'Dark', 'cosm-categories/14/Pierre Cardin Paris Retro Matte Lipstick/shades/dark.jpg'),
(45, 39, 'Light', 'cosm-categories/14/Wet n Wild Mega Last High-Shine Lip Color/shades/light.jpg'),
(46, 39, 'Medium', 'cosm-categories/14/Wet n Wild Mega Last High-Shine Lip Color/shades/medium.jpg'),
(47, 39, 'Dark', 'cosm-categories/14/Wet n Wild Mega Last High-Shine Lip Color/shades/dark.jpg'),
(48, 40, 'Medium', 'cosm-categories/14/Maybelline Color Sensational Creamy Matte Lipstick/shades/medium.webp'),
(49, 40, 'Light', 'cosm-categories/14/Maybelline Color Sensational Creamy Matte Lipstick/shades/light.webp'),
(50, 40, 'Dark', 'cosm-categories/14/Maybelline Color Sensational Creamy Matte Lipstick/shades/dark.webp'),
(51, 42, 'Light', 'cosm-categories/15/Huda Beauty Lip Strobe/shades/light.jpg'),
(52, 42, 'Medium', 'cosm-categories/15/Huda Beauty Lip Strobe/shades/medium.jpg'),
(53, 42, 'Dark', 'cosm-categories/15/Huda Beauty Lip Strobe/shades/dark.jpg'),
(54, 43, 'Light', 'cosm-categories/15/Lurella Lip Gloss/shades/light.jpg'),
(55, 43, 'Medium', 'cosm-categories/15/Lurella Lip Gloss/shades/medium.jpg'),
(56, 43, 'Dark', 'cosm-categories/15/Lurella Lip Gloss/shades/dark.jpg'),
(60, 45, 'Light', 'cosm-categories/4/Dermacol Duo Blusher/shades/light.jpg'),
(61, 45, 'Medium', 'cosm-categories/4/Dermacol Duo Blusher/shades/medium.jpg'),
(62, 45, 'Dark', 'cosm-categories/4/Dermacol Duo Blusher/shades/dark.jpg'),
(63, 46, 'Light', 'cosm-categories/4/Laura Mercier Blush Color Infusion/shades/light.png'),
(64, 46, 'Medium', 'cosm-categories/4/Laura Mercier Blush Color Infusion/shades/medium.png'),
(65, 46, 'Dark', 'cosm-categories/4/Laura Mercier Blush Color Infusion/shades/dark.png'),
(66, 47, 'Medium', 'cosm-categories/5/SH Star Show Pressed Highlighter/shades/medium.png'),
(67, 47, 'Dark', 'cosm-categories/5/SH Star Show Pressed Highlighter/shades/dark.png'),
(68, 56, 'Light', 'cosm-categories/12/Rimmel Brow Pro Micro Precision Pen/shades/light.jpg'),
(69, 56, 'Medium', 'cosm-categories/12/Rimmel Brow Pro Micro Precision Pen/shades/medium.jpeg'),
(70, 56, 'Dark', 'cosm-categories/12/Rimmel Brow Pro Micro Precision Pen/shades/dark.jpeg'),
(71, 57, 'Light', 'cosm-categories/12/Wet n Wild Ultimate Brow Retractable/shades/light.jpg'),
(72, 57, 'Medium', 'cosm-categories/12/Wet n Wild Ultimate Brow Retractable/shades/medium.jpg'),
(73, 57, 'dark', 'cosm-categories/12/Wet n Wild Ultimate Brow Retractable/shades/dark.webp'),
(74, 58, 'Medium', 'cosm-categories/12/Anastasia Dipbrow® Pomade/shades/medium.webp'),
(75, 58, 'Light', 'cosm-categories/12/Anastasia Dipbrow® Pomade/shades/light.webp'),
(76, 61, 'Light', 'cosm-categories/18/Max Factor Color Elixir Lip Liner/shades/light.jpeg'),
(77, 61, 'Medium', 'cosm-categories/18/Max Factor Color Elixir Lip Liner/shades/medium.jpeg'),
(78, 61, 'dark', 'cosm-categories/18/Max Factor Color Elixir Lip Liner/shades/dark.jpg'),
(79, 62, 'Light', 'cosm-categories/18/Rimmel 1000 Kisses Lipliner/shades/light.jpg'),
(80, 62, 'Medium', 'cosm-categories/18/Rimmel 1000 Kisses Lipliner/shades/medium.jpg'),
(81, 62, 'dark', 'cosm-categories/18/Rimmel 1000 Kisses Lipliner/shades/dark.png'),
(82, 63, 'Light', 'cosm-categories/18/Rimmel Lipliner Lasting Finish/shades/light.jpeg'),
(83, 63, 'Medium', 'cosm-categories/18/Rimmel Lipliner Lasting Finish/shades/medium.jpeg'),
(84, 63, 'dark', 'cosm-categories/18/Rimmel Lipliner Lasting Finish/shades/dark.jpeg'),
(85, 64, 'Light', 'cosm-categories/19/LA Colors Metal Nail Polish/shades/light.jpeg'),
(86, 64, 'Medium', 'cosm-categories/19/LA Colors Metal Nail Polish/shades/medium.jpeg'),
(87, 64, 'dark', 'cosm-categories/19/LA Colors Metal Nail Polish/shades/dark.jpeg'),
(88, 65, 'Light', 'cosm-categories/19/Pastel Cosmetics Nail Polish/shades/light.webp'),
(89, 65, 'Medium', 'cosm-categories/19/Pastel Cosmetics Nail Polish/shades/medium.jpg'),
(90, 65, 'dark', 'cosm-categories/19/Pastel Cosmetics Nail Polish/shades/dark.jpg'),
(91, 66, 'dark', 'cosm-categories/19/Pastel Cosmetics Nude Matte Nail Polish/shades/dark.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','client') NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `gender`, `date_of_birth`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Laiba shafiq', 'laiba@gmail.com', 'laib33@3', 'female', '2006-06-09', '2025-02-09 16:20:20', '2025-02-09 16:20:20', 'client'),
(2, 'Hafsa', 'haf33@gmail.com', 'Hafsa$44', 'female', '2005-07-30', '2025-02-10 16:19:08', '2025-02-24 18:09:32', 'admin'),
(3, 'Nida', 'nida@gmail.com', 'nida@44@', 'female', '2005-07-22', '2025-02-22 13:03:21', '2025-02-22 13:03:21', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cosmetic_categ`
--
ALTER TABLE `cosmetic_categ`
  ADD PRIMARY KEY (`cosmet_id`);

--
-- Indexes for table `cosmet_products`
--
ALTER TABLE `cosmet_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `cosm_subcategories`
--
ALTER TABLE `cosm_subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jewelery_categories`
--
ALTER TABLE `jewelery_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jewelry_products`
--
ALTER TABLE `jewelry_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shades`
--
ALTER TABLE `shades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cosmetic_categ`
--
ALTER TABLE `cosmetic_categ`
  MODIFY `cosmet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cosmet_products`
--
ALTER TABLE `cosmet_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `cosm_subcategories`
--
ALTER TABLE `cosm_subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jewelery_categories`
--
ALTER TABLE `jewelery_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jewelry_products`
--
ALTER TABLE `jewelry_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `shades`
--
ALTER TABLE `shades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cosmet_products`
--
ALTER TABLE `cosmet_products`
  ADD CONSTRAINT `cosmet_products_ibfk_1` FOREIGN KEY (`subcategory_id`) REFERENCES `cosm_subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cosm_subcategories`
--
ALTER TABLE `cosm_subcategories`
  ADD CONSTRAINT `cosm_subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `cosmetic_categ` (`cosmet_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `jewelry_products`
--
ALTER TABLE `jewelry_products`
  ADD CONSTRAINT `jewelry_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `jewelery_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `shades`
--
ALTER TABLE `shades`
  ADD CONSTRAINT `shades_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `cosmet_products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
