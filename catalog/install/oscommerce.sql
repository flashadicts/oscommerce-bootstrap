-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2014 at 12:47 AM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adv_direct`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_recorder`
--

DROP TABLE IF EXISTS `action_recorder`;
CREATE TABLE IF NOT EXISTS `action_recorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `success` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_action_recorder_module` (`module`),
  KEY `idx_action_recorder_user_id` (`user_id`),
  KEY `idx_action_recorder_identifier` (`identifier`),
  KEY `idx_action_recorder_date_added` (`date_added`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=77 ;

--
-- Dumping data for table `action_recorder`
--

INSERT INTO `action_recorder` (`id`, `module`, `user_id`, `user_name`, `identifier`, `success`, `date_added`) VALUES
(1, 'ar_admin_login', 0, 'admin', '127.0.0.1', '0', '2014-01-29 16:36:32'),
(2, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-29 16:36:36'),
(3, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-30 11:19:40'),
(4, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-30 13:38:02'),
(5, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-30 15:14:29'),
(6, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-30 16:11:19'),
(7, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-30 17:35:12'),
(8, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-31 09:29:20'),
(9, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-31 11:09:38'),
(10, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-31 13:14:17'),
(11, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-31 14:16:45'),
(12, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-01-31 15:33:29'),
(13, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-03 17:06:01'),
(14, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-04 14:19:52'),
(15, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-04 17:27:43'),
(16, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-07 15:06:19'),
(17, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-07 16:59:08'),
(18, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-11 14:05:02'),
(19, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-11 16:22:35'),
(20, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-12 14:15:12'),
(21, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-12 14:58:41'),
(22, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-12 16:11:04'),
(23, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-13 08:44:47'),
(24, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-14 15:42:30'),
(25, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-14 16:48:36'),
(26, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-14 17:20:10'),
(27, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-17 13:25:34'),
(28, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-17 15:00:16'),
(29, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-17 15:29:13'),
(30, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-17 17:21:19'),
(31, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-18 09:38:08'),
(32, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-18 10:16:45'),
(33, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-18 11:27:13'),
(34, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-18 15:09:15'),
(35, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-18 17:16:37'),
(36, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-19 09:05:02'),
(37, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-19 16:32:22'),
(38, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-20 10:01:14'),
(39, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-20 11:01:33'),
(40, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-20 13:24:14'),
(41, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-02-20 14:35:21'),
(42, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-04-16 13:38:53'),
(43, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-04-16 15:22:46'),
(44, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-04-17 16:28:53'),
(45, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-04-24 16:56:39'),
(46, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-04-29 15:46:14'),
(47, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-04-29 16:51:38'),
(48, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-04-30 12:24:45'),
(49, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-04-30 16:58:36'),
(50, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-01 16:52:27'),
(51, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-02 14:43:31'),
(52, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-02 15:20:40'),
(53, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-02 16:50:13'),
(54, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-05 17:21:41'),
(55, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-08 11:54:41'),
(56, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-08 14:45:58'),
(57, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-12 13:56:47'),
(58, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-12 14:47:35'),
(59, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-12 15:57:07'),
(60, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-12 17:25:29'),
(61, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-13 10:24:01'),
(62, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-13 13:56:01'),
(63, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-13 14:34:40'),
(64, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-13 15:33:10'),
(65, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-14 09:16:15'),
(66, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-14 10:26:48'),
(67, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-14 11:22:03'),
(68, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-14 14:08:34'),
(69, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-14 14:54:17'),
(70, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-14 15:40:02'),
(71, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-14 16:20:04'),
(72, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-27 13:33:53'),
(73, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-27 15:26:29'),
(74, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-28 13:29:56'),
(75, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-05-28 14:29:15'),
(76, 'ar_admin_login', 1, 'admin', '127.0.0.1', '1', '2014-06-05 10:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `address_book`
--

DROP TABLE IF EXISTS `address_book`;
CREATE TABLE IF NOT EXISTS `address_book` (
  `address_book_id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL,
  `entry_gender` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entry_lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entry_street_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entry_suburb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entry_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entry_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_country_id` int(11) NOT NULL DEFAULT '0',
  `entry_zone_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`address_book_id`),
  KEY `idx_address_book_customers_id` (`customers_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `address_format`
--

DROP TABLE IF EXISTS `address_format`;
CREATE TABLE IF NOT EXISTS `address_format` (
  `address_format_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_format` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `address_summary` varchar(48) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`address_format_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `address_format`
--

INSERT INTO `address_format` (`address_format_id`, `address_format`, `address_summary`) VALUES
(1, '$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country', '$city / $country'),
(2, '$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country', '$city, $state / $country'),
(3, '$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country', '$state / $country'),
(4, '$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country'),
(5, '$firstname $lastname$cr$streets$cr$postcode $city$cr$country', '$city / $country');

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
CREATE TABLE IF NOT EXISTS `administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `user_name`, `user_password`) VALUES
(1, 'admin', '$P$DQVzTE0Ap8DPgGYUizyXtwpU/3fICg/');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE IF NOT EXISTS `banners` (
  `banners_id` int(11) NOT NULL AUTO_INCREMENT,
  `banners_title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `banners_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `banners_image` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `banners_group` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `banners_html_text` text COLLATE utf8_unicode_ci,
  `expires_impressions` int(7) DEFAULT '0',
  `expires_date` datetime DEFAULT NULL,
  `date_scheduled` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_status_change` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`banners_id`),
  KEY `idx_banners_group` (`banners_group`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`banners_id`, `banners_title`, `banners_url`, `banners_image`, `banners_group`, `banners_html_text`, `expires_impressions`, `expires_date`, `date_scheduled`, `date_added`, `date_status_change`, `status`) VALUES
(1, 'osCommerce', 'http://www.oscommerce.com', 'banners/oscommerce.gif', 'footer', '', 0, NULL, NULL, '2014-01-29 16:35:21', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `banners_history`
--

DROP TABLE IF EXISTS `banners_history`;
CREATE TABLE IF NOT EXISTS `banners_history` (
  `banners_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `banners_id` int(11) NOT NULL,
  `banners_shown` int(5) NOT NULL DEFAULT '0',
  `banners_clicked` int(5) NOT NULL DEFAULT '0',
  `banners_history_date` datetime NOT NULL,
  PRIMARY KEY (`banners_history_id`),
  KEY `idx_banners_history_banners_id` (`banners_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `banners_history`
--

INSERT INTO `banners_history` (`banners_history_id`, `banners_id`, `banners_shown`, `banners_clicked`, `banners_history_date`) VALUES
(1, 1, 1, 0, '2014-01-29 16:49:40'),
(2, 1, 27, 0, '2014-01-30 11:23:49'),
(3, 1, 57, 0, '2014-01-31 09:08:48'),
(4, 1, 24, 0, '2014-02-03 15:56:21'),
(5, 1, 69, 0, '2014-02-04 11:43:08'),
(6, 1, 11, 0, '2014-02-07 11:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(3) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `categories_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`categories_id`),
  KEY `idx_categories_parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_image`, `parent_id`, `sort_order`, `date_added`, `last_modified`, `categories_status`) VALUES
(1, 'computers-category.png', 0, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(2, 'laptops-category.png', 0, 1, '2014-01-29 16:35:21', '2014-02-18 15:19:46', 1),
(3, 'monitors-category.png', 0, 2, '2014-01-29 16:35:21', '2014-02-12 14:58:49', 1),
(4, 'subcategory_graphic_cards.gif', 1, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(5, 'subcategory_printers.gif', 1, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(6, 'subcategory_monitors.gif', 1, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(7, 'subcategory_speakers.gif', 1, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(8, 'subcategory_keyboards.gif', 1, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(9, 'subcategory_mice.gif', 1, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(10, 'subcategory_action.gif', 3, 0, '2014-01-29 16:35:21', NULL, 1),
(11, 'subcategory_science_fiction.gif', 3, 0, '2014-01-29 16:35:21', NULL, 1),
(12, 'subcategory_comedy.gif', 3, 0, '2014-01-29 16:35:21', NULL, 1),
(13, 'subcategory_cartoons.gif', 3, 0, '2014-01-29 16:35:21', NULL, 1),
(14, 'subcategory_thriller.gif', 3, 0, '2014-01-29 16:35:21', NULL, 1),
(15, 'subcategory_drama.gif', 3, 0, '2014-01-29 16:35:21', NULL, 1),
(16, 'subcategory_memory.gif', 1, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(17, 'subcategory_cdrom_drives.gif', 1, 0, '2014-01-29 16:35:21', '2014-02-20 14:39:44', 1),
(18, 'subcategory_simulation.gif', 2, 0, '2014-01-29 16:35:21', NULL, 1),
(19, 'subcategory_action_games.gif', 2, 0, '2014-01-29 16:35:21', NULL, 1),
(20, 'subcategory_strategy.gif', 2, 0, '2014-01-29 16:35:21', NULL, 1),
(21, 'software-category.png', 0, 4, '2014-01-29 16:35:21', '2014-02-12 14:19:52', 1),
(24, 'accessories-category.png', 0, 4, '2014-02-12 14:18:18', NULL, 1),
(25, 'pc-parts-category.png', 0, 3, '2014-02-12 14:20:30', '2014-02-12 14:58:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories_description`
--

DROP TABLE IF EXISTS `categories_description`;
CREATE TABLE IF NOT EXISTS `categories_description` (
  `categories_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `categories_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`categories_id`,`language_id`),
  KEY `idx_categories_name` (`categories_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories_description`
--

INSERT INTO `categories_description` (`categories_id`, `language_id`, `categories_name`) VALUES
(1, 1, 'Computers'),
(2, 1, 'laptops /Tablets'),
(3, 1, 'Monitors'),
(4, 1, 'Graphics Cards'),
(5, 1, 'Printers'),
(6, 1, 'Monitors'),
(7, 1, 'Speakers'),
(8, 1, 'Keyboards'),
(9, 1, 'Mice'),
(10, 1, 'Action'),
(11, 1, 'Science Fiction'),
(12, 1, 'Comedy'),
(13, 1, 'Cartoons'),
(14, 1, 'Thriller'),
(15, 1, 'Drama'),
(16, 1, 'Memory'),
(17, 1, 'CDROM Drives'),
(18, 1, 'Simulation'),
(19, 1, 'Action'),
(20, 1, 'Strategy'),
(21, 1, 'Software'),
(24, 1, 'Peripherals'),
(25, 1, 'PC Parts');

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
CREATE TABLE IF NOT EXISTS `configuration` (
  `configuration_id` int(11) NOT NULL AUTO_INCREMENT,
  `configuration_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `configuration_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `configuration_value` text COLLATE utf8_unicode_ci NOT NULL,
  `configuration_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `configuration_group_id` int(11) NOT NULL,
  `sort_order` int(5) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `use_function` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `set_function` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`configuration_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=480 ;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES
(1, 'Store Name', 'STORE_NAME', 'Advantage Direct', 'The name of my store', 1, 1, NULL, '2014-01-29 16:35:21', NULL, NULL),
(2, 'Store Owner', 'STORE_OWNER', 'Advantage Computers Ltd', 'The name of my store owner', 1, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(3, 'E-Mail Address', 'STORE_OWNER_EMAIL_ADDRESS', 'craig@advantage.co.nz', 'The e-mail address of my store owner', 1, 3, NULL, '2014-01-29 16:35:21', NULL, NULL),
(4, 'E-Mail From', 'EMAIL_FROM', '"Advantage Computers Ltd" <craig@advantage.co.nz>', 'The e-mail address used in (sent) e-mails', 1, 4, NULL, '2014-01-29 16:35:21', NULL, NULL),
(5, 'Country', 'STORE_COUNTRY', '153', 'The country my store is located in <br /><br /><strong>Note: Please remember to update the store zone.</strong>', 1, 6, '2014-02-18 10:17:47', '2014-01-29 16:35:21', 'tep_get_country_name', 'tep_cfg_pull_down_country_list('),
(6, 'Zone', 'STORE_ZONE', '', 'The zone my store is located in', 1, 7, '2014-02-18 10:17:54', '2014-01-29 16:35:21', 'tep_cfg_get_zone_name', 'tep_cfg_pull_down_zone_list('),
(7, 'Expected Sort Order', 'EXPECTED_PRODUCTS_SORT', 'desc', 'This is the sort order used in the expected products box.', 1, 8, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''asc'', ''desc''), '),
(8, 'Expected Sort Field', 'EXPECTED_PRODUCTS_FIELD', 'date_expected', 'The column to sort by in the expected products box.', 1, 9, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''products_name'', ''date_expected''), '),
(9, 'Switch To Default Language Currency', 'USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 'Automatically switch to the language''s currency when it is changed', 1, 10, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(10, 'Send Extra Order Emails To', 'SEND_EXTRA_ORDER_EMAILS_TO', '', 'Send extra order emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', 1, 11, NULL, '2014-01-29 16:35:21', NULL, NULL),
(11, 'Use Search-Engine Safe URLs', 'SEARCH_ENGINE_FRIENDLY_URLS', 'false', 'Use search-engine safe urls for all site links', 1, 12, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(12, 'Display Cart After Adding Product', 'DISPLAY_CART', 'true', 'Display the shopping cart after adding a product (or return back to their origin)', 1, 14, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(13, 'Allow Guest To Tell A Friend', 'ALLOW_GUEST_TO_TELL_A_FRIEND', 'false', 'Allow guests to tell a friend about a product', 1, 15, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(14, 'Default Search Operator', 'ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 'Default search operators', 1, 17, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''and'', ''or''), '),
(15, 'Store Address and Phone', 'STORE_NAME_ADDRESS', 'Advantage Direct<br />46-48 Grey Street<br />Palmerston North 4410', 'This is the Store Name, Address and Phone used on printable documents and displayed online', 1, 18, '2014-05-14 11:49:01', '2014-01-29 16:35:21', NULL, ''),
(16, 'Show Category Counts', 'SHOW_COUNTS', 'true', 'Count recursively how many products are in each category', 1, 19, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(17, 'Tax Decimal Places', 'TAX_DECIMAL_PLACES', '0', 'Pad the tax value this amount of decimal places', 1, 20, NULL, '2014-01-29 16:35:21', NULL, NULL),
(18, 'Display Prices with Tax Default', 'DISPLAY_PRICE_WITH_TAX_DEFAULT', 'false', 'By default, display prices with tax included (true) or add the tax at the end (false)', 1, 21, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(19, 'First Name', 'ENTRY_FIRST_NAME_MIN_LENGTH', '2', 'Minimum length of first name', 2, 1, NULL, '2014-01-29 16:35:21', NULL, NULL),
(20, 'Last Name', 'ENTRY_LAST_NAME_MIN_LENGTH', '2', 'Minimum length of last name', 2, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(21, 'Date of Birth', 'ENTRY_DOB_MIN_LENGTH', '10', 'Minimum length of date of birth', 2, 3, NULL, '2014-01-29 16:35:21', NULL, NULL),
(22, 'E-Mail Address', 'ENTRY_EMAIL_ADDRESS_MIN_LENGTH', '6', 'Minimum length of e-mail address', 2, 4, NULL, '2014-01-29 16:35:21', NULL, NULL),
(23, 'Street Address', 'ENTRY_STREET_ADDRESS_MIN_LENGTH', '5', 'Minimum length of street address', 2, 5, NULL, '2014-01-29 16:35:21', NULL, NULL),
(24, 'Company', 'ENTRY_COMPANY_MIN_LENGTH', '2', 'Minimum length of company name', 2, 6, NULL, '2014-01-29 16:35:21', NULL, NULL),
(25, 'Post Code', 'ENTRY_POSTCODE_MIN_LENGTH', '4', 'Minimum length of post code', 2, 7, NULL, '2014-01-29 16:35:21', NULL, NULL),
(26, 'City', 'ENTRY_CITY_MIN_LENGTH', '3', 'Minimum length of city', 2, 8, NULL, '2014-01-29 16:35:21', NULL, NULL),
(27, 'State', 'ENTRY_STATE_MIN_LENGTH', '2', 'Minimum length of state', 2, 9, NULL, '2014-01-29 16:35:21', NULL, NULL),
(28, 'Telephone Number', 'ENTRY_TELEPHONE_MIN_LENGTH', '3', 'Minimum length of telephone number', 2, 10, NULL, '2014-01-29 16:35:21', NULL, NULL),
(29, 'Password', 'ENTRY_PASSWORD_MIN_LENGTH', '5', 'Minimum length of password', 2, 11, NULL, '2014-01-29 16:35:21', NULL, NULL),
(30, 'Credit Card Owner Name', 'CC_OWNER_MIN_LENGTH', '3', 'Minimum length of credit card owner name', 2, 12, NULL, '2014-01-29 16:35:21', NULL, NULL),
(31, 'Credit Card Number', 'CC_NUMBER_MIN_LENGTH', '10', 'Minimum length of credit card number', 2, 13, NULL, '2014-01-29 16:35:21', NULL, NULL),
(32, 'Review Text', 'REVIEW_TEXT_MIN_LENGTH', '50', 'Minimum length of review text', 2, 14, NULL, '2014-01-29 16:35:21', NULL, NULL),
(33, 'Best Sellers', 'MIN_DISPLAY_BESTSELLERS', '1', 'Minimum number of best sellers to display', 2, 15, NULL, '2014-01-29 16:35:21', NULL, NULL),
(34, 'Also Purchased', 'MIN_DISPLAY_ALSO_PURCHASED', '1', 'Minimum number of products to display in the ''This Customer Also Purchased'' box', 2, 16, NULL, '2014-01-29 16:35:21', NULL, NULL),
(35, 'Address Book Entries', 'MAX_ADDRESS_BOOK_ENTRIES', '5', 'Maximum address book entries a customer is allowed to have', 3, 1, NULL, '2014-01-29 16:35:21', NULL, NULL),
(36, 'Search Results', 'MAX_DISPLAY_SEARCH_RESULTS', '6', 'Amount of products to list', 3, 2, '2014-04-17 16:29:00', '2014-01-29 16:35:21', NULL, NULL),
(37, 'Page Links', 'MAX_DISPLAY_PAGE_LINKS', '5', 'Number of ''number'' links use for page-sets', 3, 3, NULL, '2014-01-29 16:35:21', NULL, NULL),
(38, 'Special Products', 'MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 'Maximum number of products on special to display', 3, 4, NULL, '2014-01-29 16:35:21', NULL, NULL),
(39, 'New Products Module', 'MAX_DISPLAY_NEW_PRODUCTS', '6', 'Maximum number of new products to display in a category', 3, 5, '2014-02-20 10:32:23', '2014-01-29 16:35:21', NULL, NULL),
(40, 'Products Expected', 'MAX_DISPLAY_UPCOMING_PRODUCTS', '10', 'Maximum number of products expected to display', 3, 6, NULL, '2014-01-29 16:35:21', NULL, NULL),
(41, 'Manufacturers List', 'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST', '0', 'Used in manufacturers box; when the number of manufacturers exceeds this number, a drop-down list will be displayed instead of the default list', 3, 7, NULL, '2014-01-29 16:35:21', NULL, NULL),
(42, 'Manufacturers Select Size', 'MAX_MANUFACTURERS_LIST', '1', 'Used in manufacturers box; when this value is ''1'' the classic drop-down list will be used for the manufacturers box. Otherwise, a list-box with the specified number of rows will be displayed.', 3, 7, NULL, '2014-01-29 16:35:21', NULL, NULL),
(43, 'Length of Manufacturers Name', 'MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15', 'Used in manufacturers box; maximum length of manufacturers name to display', 3, 8, NULL, '2014-01-29 16:35:21', NULL, NULL),
(44, 'New Reviews', 'MAX_DISPLAY_NEW_REVIEWS', '6', 'Maximum number of new reviews to display', 3, 9, NULL, '2014-01-29 16:35:21', NULL, NULL),
(45, 'Selection of Random Reviews', 'MAX_RANDOM_SELECT_REVIEWS', '10', 'How many records to select from to choose one random product review', 3, 10, NULL, '2014-01-29 16:35:21', NULL, NULL),
(46, 'Selection of Random New Products', 'MAX_RANDOM_SELECT_NEW', '10', 'How many records to select from to choose one random new product to display', 3, 11, NULL, '2014-01-29 16:35:21', NULL, NULL),
(47, 'Selection of Products on Special', 'MAX_RANDOM_SELECT_SPECIALS', '10', 'How many records to select from to choose one random product special to display', 3, 12, NULL, '2014-01-29 16:35:21', NULL, NULL),
(48, 'Categories To List Per Row', 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3', 'How many categories to list per row', 3, 13, NULL, '2014-01-29 16:35:21', NULL, NULL),
(49, 'New Products Listing', 'MAX_DISPLAY_PRODUCTS_NEW', '10', 'Maximum number of new products to display in new products page', 3, 14, NULL, '2014-01-29 16:35:21', NULL, NULL),
(50, 'Best Sellers', 'MAX_DISPLAY_BESTSELLERS', '6', 'Maximum number of best sellers to display', 3, 15, NULL, '2014-01-29 16:35:21', NULL, NULL),
(51, 'Also Purchased', 'MAX_DISPLAY_ALSO_PURCHASED', '6', 'Maximum number of products to display in the ''This Customer Also Purchased'' box', 3, 16, NULL, '2014-01-29 16:35:21', NULL, NULL),
(52, 'Customer Order History Box', 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6', 'Maximum number of products to display in the customer order history box', 3, 17, NULL, '2014-01-29 16:35:21', NULL, NULL),
(53, 'Order History', 'MAX_DISPLAY_ORDER_HISTORY', '10', 'Maximum number of orders to display in the order history page', 3, 18, NULL, '2014-01-29 16:35:21', NULL, NULL),
(54, 'Product Quantities In Shopping Cart', 'MAX_QTY_IN_CART', '99', 'Maximum number of product quantities that can be added to the shopping cart (0 for no limit)', 3, 19, NULL, '2014-01-29 16:35:21', NULL, NULL),
(55, 'Small Image Width', 'SMALL_IMAGE_WIDTH', '135', 'The pixel width of small images', 4, 1, '2014-05-28 13:31:08', '2014-01-29 16:35:21', NULL, NULL),
(56, 'Small Image Height', 'SMALL_IMAGE_HEIGHT', '', 'The pixel height of small images', 4, 2, '2014-02-17 15:31:56', '2014-01-29 16:35:21', NULL, NULL),
(57, 'Heading Image Width', 'HEADING_IMAGE_WIDTH', '57', 'The pixel width of heading images', 4, 3, NULL, '2014-01-29 16:35:21', NULL, NULL),
(58, 'Heading Image Height', 'HEADING_IMAGE_HEIGHT', '40', 'The pixel height of heading images', 4, 4, NULL, '2014-01-29 16:35:21', NULL, NULL),
(59, 'Subcategory Image Width', 'SUBCATEGORY_IMAGE_WIDTH', '100', 'The pixel width of subcategory images', 4, 5, NULL, '2014-01-29 16:35:21', NULL, NULL),
(60, 'Subcategory Image Height', 'SUBCATEGORY_IMAGE_HEIGHT', '57', 'The pixel height of subcategory images', 4, 6, NULL, '2014-01-29 16:35:21', NULL, NULL),
(61, 'Calculate Image Size', 'CONFIG_CALCULATE_IMAGE_SIZE', 'false', 'Calculate the size of images?', 4, 7, '2014-05-01 16:52:37', '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(62, 'Image Required', 'IMAGE_REQUIRED', 'true', 'Enable to display broken images. Good for development.', 4, 8, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(63, 'Gender', 'ACCOUNT_GENDER', 'true', 'Display gender in the customers account', 5, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(64, 'Date of Birth', 'ACCOUNT_DOB', 'true', 'Display date of birth in the customers account', 5, 2, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(65, 'Company', 'ACCOUNT_COMPANY', 'true', 'Display company in the customers account', 5, 3, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(66, 'Suburb', 'ACCOUNT_SUBURB', 'true', 'Display suburb in the customers account', 5, 4, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(67, 'State', 'ACCOUNT_STATE', 'true', 'Display state in the customers account', 5, 5, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(68, 'Installed Modules', 'MODULE_PAYMENT_INSTALLED', 'cod.php', 'List of payment module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: cod.php;paypal_express.php)', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(69, 'Installed Modules', 'MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_shipping.php;ot_tax.php;ot_total.php', 'List of order_total module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)', 6, 0, '2014-02-12 16:27:16', '2014-01-29 16:35:21', NULL, NULL),
(70, 'Installed Modules', 'MODULE_SHIPPING_INSTALLED', 'flat.php', 'List of shipping module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ups.php;flat.php;item.php)', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(71, 'Installed Modules', 'MODULE_ACTION_RECORDER_INSTALLED', 'ar_admin_login.php;ar_contact_us.php;ar_reset_password.php;ar_tell_a_friend.php', 'List of action recorder module filenames separated by a semi-colon. This is automatically updated. No need to edit.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(72, 'Installed Modules', 'MODULE_SOCIAL_BOOKMARKS_INSTALLED', 'sb_email.php;sb_google_plus_share.php;sb_facebook.php;sb_twitter.php;sb_pinterest.php', 'List of social bookmark module filenames separated by a semi-colon. This is automatically updated. No need to edit.', 6, 0, '2014-01-30 11:19:53', '2014-01-29 16:35:21', NULL, NULL),
(73, 'Enable Cash On Delivery Module', 'MODULE_PAYMENT_COD_STATUS', 'True', 'Do you want to accept Cash On Delevery payments?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(74, 'Payment Zone', 'MODULE_PAYMENT_COD_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', 6, 2, NULL, '2014-01-29 16:35:21', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes('),
(75, 'Sort order of display.', 'MODULE_PAYMENT_COD_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(76, 'Set Order Status', 'MODULE_PAYMENT_COD_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', 6, 0, NULL, '2014-01-29 16:35:21', 'tep_get_order_status_name', 'tep_cfg_pull_down_order_statuses('),
(77, 'Enable Flat Shipping', 'MODULE_SHIPPING_FLAT_STATUS', 'True', 'Do you want to offer flat rate shipping?', 6, 0, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(78, 'Shipping Cost', 'MODULE_SHIPPING_FLAT_COST', '5.00', 'The shipping cost for all orders using this shipping method.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(79, 'Tax Class', 'MODULE_SHIPPING_FLAT_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', 6, 0, NULL, '2014-01-29 16:35:21', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes('),
(80, 'Shipping Zone', 'MODULE_SHIPPING_FLAT_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', 6, 0, NULL, '2014-01-29 16:35:21', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes('),
(81, 'Sort Order', 'MODULE_SHIPPING_FLAT_SORT_ORDER', '0', 'Sort order of display.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(82, 'Default Currency', 'DEFAULT_CURRENCY', 'NZD', 'Default Currency', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(83, 'Default Language', 'DEFAULT_LANGUAGE', 'en', 'Default Language', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(84, 'Default Order Status For New Orders', 'DEFAULT_ORDERS_STATUS_ID', '1', 'When a new order is created, this order status will be assigned to it.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(85, 'Display Shipping', 'MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true', 'Do you want to display the order shipping cost?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(86, 'Sort Order', 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '2', 'Sort order of display.', 6, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(87, 'Allow Free Shipping', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false', 'Do you want to allow free shipping?', 6, 3, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(88, 'Free Shipping For Orders Over', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50', 'Provide free shipping for orders over the set amount.', 6, 4, NULL, '2014-01-29 16:35:21', 'currencies->format', NULL),
(89, 'Provide Free Shipping For Orders Made', 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national', 'Provide free shipping for orders sent to the set destination.', 6, 5, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''national'', ''international'', ''both''), '),
(90, 'Display Sub-Total', 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', 'Do you want to display the order sub-total cost?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(91, 'Sort Order', 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '1', 'Sort order of display.', 6, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(92, 'Display Tax', 'MODULE_ORDER_TOTAL_TAX_STATUS', 'true', 'Do you want to display the order tax value?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(93, 'Sort Order', 'MODULE_ORDER_TOTAL_TAX_SORT_ORDER', '3', 'Sort order of display.', 6, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(94, 'Display Total', 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true', 'Do you want to display the total order value?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(95, 'Sort Order', 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '4', 'Sort order of display.', 6, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(96, 'Minimum Minutes Per E-Mail', 'MODULE_ACTION_RECORDER_CONTACT_US_EMAIL_MINUTES', '15', 'Minimum number of minutes to allow 1 e-mail to be sent (eg, 15 for 1 e-mail every 15 minutes)', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(97, 'Minimum Minutes Per E-Mail', 'MODULE_ACTION_RECORDER_TELL_A_FRIEND_EMAIL_MINUTES', '15', 'Minimum number of minutes to allow 1 e-mail to be sent (eg, 15 for 1 e-mail every 15 minutes)', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(98, 'Allowed Minutes', 'MODULE_ACTION_RECORDER_ADMIN_LOGIN_MINUTES', '5', 'Number of minutes to allow login attempts to occur.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(99, 'Allowed Attempts', 'MODULE_ACTION_RECORDER_ADMIN_LOGIN_ATTEMPTS', '3', 'Number of login attempts to allow within the specified period.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(100, 'Allowed Minutes', 'MODULE_ACTION_RECORDER_RESET_PASSWORD_MINUTES', '5', 'Number of minutes to allow password resets to occur.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(101, 'Allowed Attempts', 'MODULE_ACTION_RECORDER_RESET_PASSWORD_ATTEMPTS', '1', 'Number of password reset attempts to allow within the specified period.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(102, 'Enable E-Mail Module', 'MODULE_SOCIAL_BOOKMARKS_EMAIL_STATUS', 'True', 'Do you want to allow products to be shared through e-mail?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(103, 'Sort Order', 'MODULE_SOCIAL_BOOKMARKS_EMAIL_SORT_ORDER', '10', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(104, 'Enable Google+ Share Module', 'MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_STATUS', 'True', 'Do you want to allow products to be shared through Google+?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(105, 'Annotation', 'MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_ANNOTATION', 'None', 'The annotation to display next to the button.', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''Inline'', ''Bubble'', ''Vertical-Bubble'', ''None''), '),
(106, 'Width', 'MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_WIDTH', '', 'The maximum width of the button.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(107, 'Height', 'MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_HEIGHT', '15', 'Sets the height of the button.', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''15'', ''20'', ''24'', ''60''), '),
(108, 'Alignment', 'MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_ALIGN', 'Left', 'The alignment of the button assets.', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''Left'', ''Right''), '),
(109, 'Sort Order', 'MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_SORT_ORDER', '20', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(110, 'Enable Facebook Module', 'MODULE_SOCIAL_BOOKMARKS_FACEBOOK_STATUS', 'True', 'Do you want to allow products to be shared through Facebook?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(111, 'Sort Order', 'MODULE_SOCIAL_BOOKMARKS_FACEBOOK_SORT_ORDER', '30', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(112, 'Enable Twitter Module', 'MODULE_SOCIAL_BOOKMARKS_TWITTER_STATUS', 'True', 'Do you want to allow products to be shared through Twitter?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(113, 'Sort Order', 'MODULE_SOCIAL_BOOKMARKS_TWITTER_SORT_ORDER', '40', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(114, 'Enable Pinterest Module', 'MODULE_SOCIAL_BOOKMARKS_PINTEREST_STATUS', 'True', 'Do you want to allow Pinterest Button?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(115, 'Layout Position', 'MODULE_SOCIAL_BOOKMARKS_PINTEREST_BUTTON_COUNT_POSITION', 'None', 'Horizontal or Vertical or None', 6, 2, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''Horizontal'', ''Vertical'', ''None''), '),
(116, 'Sort Order', 'MODULE_SOCIAL_BOOKMARKS_PINTEREST_SORT_ORDER', '50', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(117, 'Country of Origin', 'SHIPPING_ORIGIN_COUNTRY', '223', 'Select the country of origin to be used in shipping quotes.', 7, 1, NULL, '2014-01-29 16:35:21', 'tep_get_country_name', 'tep_cfg_pull_down_country_list('),
(118, 'Postal Code', 'SHIPPING_ORIGIN_ZIP', 'NONE', 'Enter the Postal Code (ZIP) of the Store to be used in shipping quotes.', 7, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(119, 'Enter the Maximum Package Weight you will ship', 'SHIPPING_MAX_WEIGHT', '50', 'Carriers have a max weight limit for a single package. This is a common one for all.', 7, 3, NULL, '2014-01-29 16:35:21', NULL, NULL),
(120, 'Package Tare weight.', 'SHIPPING_BOX_WEIGHT', '3', 'What is the weight of typical packaging of small to medium packages?', 7, 4, NULL, '2014-01-29 16:35:21', NULL, NULL),
(121, 'Larger packages - percentage increase.', 'SHIPPING_BOX_PADDING', '10', 'For 10% enter 10', 7, 5, NULL, '2014-01-29 16:35:21', NULL, NULL),
(122, 'Display Product Image', 'PRODUCT_LIST_IMAGE', '1', 'Do you want to display the Product Image?', 8, 1, NULL, '2014-01-29 16:35:21', NULL, NULL),
(123, 'Display Product Manufacturer Name', 'PRODUCT_LIST_MANUFACTURER', '1', 'Do you want to display the Product Manufacturer Name?', 8, 2, '2014-04-17 16:51:46', '2014-01-29 16:35:21', NULL, NULL),
(124, 'Display Product Model', 'PRODUCT_LIST_MODEL', '1', 'Do you want to display the Product Model?', 8, 3, '2014-04-17 16:51:54', '2014-01-29 16:35:21', NULL, NULL),
(125, 'Display Product Name', 'PRODUCT_LIST_NAME', '2', 'Do you want to display the Product Name?', 8, 4, NULL, '2014-01-29 16:35:21', NULL, NULL),
(126, 'Display Product Price', 'PRODUCT_LIST_PRICE', '3', 'Do you want to display the Product Price', 8, 5, NULL, '2014-01-29 16:35:21', NULL, NULL),
(127, 'Display Product Quantity', 'PRODUCT_LIST_QUANTITY', '1', 'Do you want to display the Product Quantity?', 8, 6, '2014-04-17 16:52:16', '2014-01-29 16:35:21', NULL, NULL),
(128, 'Display Product Weight', 'PRODUCT_LIST_WEIGHT', '0', 'Do you want to display the Product Weight?', 8, 7, NULL, '2014-01-29 16:35:21', NULL, NULL),
(129, 'Display Buy Now column', 'PRODUCT_LIST_BUY_NOW', '4', 'Do you want to display the Buy Now column?', 8, 8, NULL, '2014-01-29 16:35:21', NULL, NULL),
(130, 'Display Category/Manufacturer Filter (0=disable; 1=enable)', 'PRODUCT_LIST_FILTER', '1', 'Do you want to display the Category/Manufacturer Filter?', 8, 9, NULL, '2014-01-29 16:35:21', NULL, NULL),
(131, 'Location of Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', 'PREV_NEXT_BAR_LOCATION', '3', 'Sets the location of the Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', 8, 10, '2014-04-16 15:23:43', '2014-01-29 16:35:21', NULL, NULL),
(132, 'Check stock level', 'STOCK_CHECK', 'true', 'Check to see if sufficent stock is available', 9, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(133, 'Subtract stock', 'STOCK_LIMITED', 'true', 'Subtract product in stock by product orders', 9, 2, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(134, 'Allow Checkout', 'STOCK_ALLOW_CHECKOUT', 'true', 'Allow customer to checkout even if there is insufficient stock', 9, 3, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(135, 'Mark product out of stock', 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***', 'Display something on screen so customer can see which product has insufficient stock', 9, 4, NULL, '2014-01-29 16:35:21', NULL, NULL),
(136, 'Stock Re-order level', 'STOCK_REORDER_LEVEL', '5', 'Define when stock needs to be re-ordered', 9, 5, NULL, '2014-01-29 16:35:21', NULL, NULL),
(137, 'Store Page Parse Time', 'STORE_PAGE_PARSE_TIME', 'false', 'Store the time it takes to parse a page', 10, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(138, 'Log Destination', 'STORE_PAGE_PARSE_TIME_LOG', '/var/log/www/tep/page_parse_time.log', 'Directory and filename of the page parse time log', 10, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(139, 'Log Date Format', 'STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S', 'The date format', 10, 3, NULL, '2014-01-29 16:35:21', NULL, NULL),
(140, 'Display The Page Parse Time', 'DISPLAY_PAGE_PARSE_TIME', 'true', 'Display the page parse time (store page parse time must be enabled)', 10, 4, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(141, 'Store Database Queries', 'STORE_DB_TRANSACTIONS', 'false', 'Store the database queries in the page parse time log', 10, 5, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(142, 'Use Cache', 'USE_CACHE', 'true', 'Use caching features', 11, 1, '2014-02-18 11:38:49', '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(143, 'Cache Directory', 'DIR_FS_CACHE', 'C:/Program Files (x86)/EasyPHP-DevServer-14.1VC11/data/localweb/projects/advdirect/includes/cache/', 'The directory where the cached files are saved', 11, 2, '2014-02-18 11:39:02', '2014-01-29 16:35:21', NULL, NULL),
(144, 'E-Mail Transport Method', 'EMAIL_TRANSPORT', 'sendmail', 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.', 12, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''sendmail'', ''smtp''),'),
(145, 'E-Mail Linefeeds', 'EMAIL_LINEFEED', 'LF', 'Defines the character sequence used to separate mail headers.', 12, 2, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''LF'', ''CRLF''),'),
(146, 'Use MIME HTML When Sending Emails', 'EMAIL_USE_HTML', 'false', 'Send e-mails in HTML format', 12, 3, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''),'),
(147, 'Verify E-Mail Addresses Through DNS', 'ENTRY_EMAIL_ADDRESS_CHECK', 'false', 'Verify e-mail address through a DNS server', 12, 4, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(148, 'Send E-Mails', 'SEND_EMAILS', 'true', 'Send out e-mails', 12, 5, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(149, 'Enable download', 'DOWNLOAD_ENABLED', 'false', 'Enable the products download functions.', 13, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(150, 'Download by redirect', 'DOWNLOAD_BY_REDIRECT', 'false', 'Use browser redirection for download. Disable on non-Unix systems.', 13, 2, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(151, 'Expiry delay (days)', 'DOWNLOAD_MAX_DAYS', '7', 'Set number of days before the download link expires. 0 means no limit.', 13, 3, NULL, '2014-01-29 16:35:21', NULL, ''),
(152, 'Maximum number of downloads', 'DOWNLOAD_MAX_COUNT', '5', 'Set the maximum number of downloads. 0 means no download authorized.', 13, 4, NULL, '2014-01-29 16:35:21', NULL, ''),
(153, 'Enable GZip Compression', 'GZIP_COMPRESSION', 'false', 'Enable HTTP GZip compression.', 14, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(154, 'Compression Level', 'GZIP_LEVEL', '5', 'Use this compression level 0-9 (0 = minimum, 9 = maximum).', 14, 2, NULL, '2014-01-29 16:35:21', NULL, NULL),
(155, 'Session Directory', 'SESSION_WRITE_DIRECTORY', 'C:/Program Files (x86)/EasyPHP-DevServer-14.1VC11/data/localweb/projects/advdirect/includes/work/', 'If sessions are file based, store them in this directory.', 15, 1, NULL, '2014-01-29 16:35:21', NULL, NULL),
(156, 'Force Cookie Use', 'SESSION_FORCE_COOKIE_USE', 'False', 'Force the use of sessions when cookies are only enabled.', 15, 2, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(157, 'Check SSL Session ID', 'SESSION_CHECK_SSL_SESSION_ID', 'False', 'Validate the SSL_SESSION_ID on every secure HTTPS page request.', 15, 3, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(158, 'Check User Agent', 'SESSION_CHECK_USER_AGENT', 'False', 'Validate the clients browser user agent on every page request.', 15, 4, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(159, 'Check IP Address', 'SESSION_CHECK_IP_ADDRESS', 'False', 'Validate the clients IP address on every page request.', 15, 5, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(160, 'Prevent Spider Sessions', 'SESSION_BLOCK_SPIDERS', 'True', 'Prevent known spiders from starting a session.', 15, 6, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(161, 'Recreate Session', 'SESSION_RECREATE', 'True', 'Recreate the session to generate a new session ID when the customer logs on or creates an account (PHP >=4.1 needed).', 15, 7, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(162, 'Last Update Check Time', 'LAST_UPDATE_CHECK_TIME', '', 'Last time a check for new versions of osCommerce was run', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(179, 'Installed Modules', 'MODULE_HEADER_TAGS_INSTALLED', 'ht_manufacturer_title.php;ht_category_title.php;ht_product_title.php;ht_canonical.php;ht_robot_noindex.php', 'List of header tag module filenames separated by a semi-colon. This is automatically updated. No need to edit.', 6, 0, '2014-01-30 11:19:50', '2014-01-29 16:35:21', NULL, NULL),
(180, 'Enable Category Title Module', 'MODULE_HEADER_TAGS_CATEGORY_TITLE_STATUS', 'True', 'Do you want to allow category titles to be added to the page title?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(181, 'Sort Order', 'MODULE_HEADER_TAGS_CATEGORY_TITLE_SORT_ORDER', '200', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(182, 'Enable Manufacturer Title Module', 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_STATUS', 'True', 'Do you want to allow manufacturer titles to be added to the page title?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(183, 'Sort Order', 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_SORT_ORDER', '100', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(184, 'Enable Product Title Module', 'MODULE_HEADER_TAGS_PRODUCT_TITLE_STATUS', 'True', 'Do you want to allow product titles to be added to the page title?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(185, 'Sort Order', 'MODULE_HEADER_TAGS_PRODUCT_TITLE_SORT_ORDER', '300', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(186, 'Enable Canonical Module', 'MODULE_HEADER_TAGS_CANONICAL_STATUS', 'True', 'Do you want to enable the Canonical module?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(187, 'Sort Order', 'MODULE_HEADER_TAGS_CANONICAL_SORT_ORDER', '400', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(188, 'Enable Robot NoIndex Module', 'MODULE_HEADER_TAGS_ROBOT_NOINDEX_STATUS', 'True', 'Do you want to enable the Robot NoIndex module?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(189, 'Pages', 'MODULE_HEADER_TAGS_ROBOT_NOINDEX_PAGES', 'account.php;account_edit.php;account_history.php;account_history_info.php;account_newsletters.php;account_notifications.php;account_password.php;address_book.php;address_book_process.php;checkout_confirmation.php;checkout_payment.php;checkout_payment_address.php;checkout_process.php;checkout_shipping.php;checkout_shipping_address.php;checkout_success.php;cookie_usage.php;create_account.php;create_account_success.php;login.php;logoff.php;password_forgotten.php;password_reset.php;product_reviews_write.php;shopping_cart.php;ssl_check.php;tell_a_friend.php', 'The pages to add the meta robot noindex tag to.', 6, 0, NULL, '2014-01-29 16:35:21', 'ht_robot_noindex_show_pages', 'ht_robot_noindex_edit_pages('),
(190, 'Sort Order', 'MODULE_HEADER_TAGS_ROBOT_NOINDEX_SORT_ORDER', '500', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(191, 'Installed Modules', 'MODULE_ADMIN_DASHBOARD_INSTALLED', 'd_total_revenue.php;d_total_customers.php;d_orders.php;d_customers.php;d_admin_logins.php;d_security_checks.php;d_latest_news.php;d_latest_addons.php;d_partner_news.php;d_version_check.php;d_reviews.php', 'List of Administration Tool Dashboard module filenames separated by a semi-colon. This is automatically updated. No need to edit.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(192, 'Enable Administrator Logins Module', 'MODULE_ADMIN_DASHBOARD_ADMIN_LOGINS_STATUS', 'True', 'Do you want to show the latest administrator logins on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(193, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_ADMIN_LOGINS_SORT_ORDER', '500', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(194, 'Enable Customers Module', 'MODULE_ADMIN_DASHBOARD_CUSTOMERS_STATUS', 'True', 'Do you want to show the newest customers on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(195, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_CUSTOMERS_SORT_ORDER', '400', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(196, 'Enable Latest Add-Ons Module', 'MODULE_ADMIN_DASHBOARD_LATEST_ADDONS_STATUS', 'True', 'Do you want to show the latest osCommerce Add-Ons on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(197, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_LATEST_ADDONS_SORT_ORDER', '800', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(198, 'Enable Latest News Module', 'MODULE_ADMIN_DASHBOARD_LATEST_NEWS_STATUS', 'True', 'Do you want to show the latest osCommerce News on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(199, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_LATEST_NEWS_SORT_ORDER', '700', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(200, 'Enable Orders Module', 'MODULE_ADMIN_DASHBOARD_ORDERS_STATUS', 'True', 'Do you want to show the latest orders on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(201, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_ORDERS_SORT_ORDER', '300', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(202, 'Enable Security Checks Module', 'MODULE_ADMIN_DASHBOARD_SECURITY_CHECKS_STATUS', 'True', 'Do you want to run the security checks for this installation?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(203, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_SECURITY_CHECKS_SORT_ORDER', '600', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(204, 'Enable Total Customers Module', 'MODULE_ADMIN_DASHBOARD_TOTAL_CUSTOMERS_STATUS', 'True', 'Do you want to show the total customers chart on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(205, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_TOTAL_CUSTOMERS_SORT_ORDER', '200', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(206, 'Enable Total Revenue Module', 'MODULE_ADMIN_DASHBOARD_TOTAL_REVENUE_STATUS', 'True', 'Do you want to show the total revenue chart on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(207, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_TOTAL_REVENUE_SORT_ORDER', '100', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(208, 'Enable Version Check Module', 'MODULE_ADMIN_DASHBOARD_VERSION_CHECK_STATUS', 'True', 'Do you want to show the version check results on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(209, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_VERSION_CHECK_SORT_ORDER', '900', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(210, 'Enable Latest Reviews Module', 'MODULE_ADMIN_DASHBOARD_REVIEWS_STATUS', 'True', 'Do you want to show the latest reviews on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(211, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_REVIEWS_SORT_ORDER', '1000', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(212, 'Enable Partner News Module', 'MODULE_ADMIN_DASHBOARD_PARTNER_NEWS_STATUS', 'True', 'Do you want to show the latest osCommerce Partner News on the dashboard?', 6, 1, NULL, '2014-01-29 16:35:21', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(213, 'Sort Order', 'MODULE_ADMIN_DASHBOARD_PARTNER_NEWS_SORT_ORDER', '820', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(214, 'Installed Modules', 'MODULE_BOXES_INSTALLED', 'bm_information.php;bm_manufacturer_info.php;bm_free_shipping.php;bm_scrolling_specials.php', 'List of box module filenames separated by a semi-colon. This is automatically updated. No need to edit.', 6, 0, '2014-05-08 15:00:13', '2014-01-29 16:35:21', NULL, NULL),
(446, 'Show Reviews Tab', 'SPECIFICATIONS_REVIEWS_TAB', 'True', 'Show the Reviews tab', 1610, 50, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(445, 'Show Name in Accessories Tab', 'SPECIFICATIONS_ACCESSORIES_NAME', 'True', 'Show the name of the product in the Accessories (Cross-sell) tab', 1610, 45, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(383, 'Scroller Direction', 'SCROLL_DIRECTION', 'up', 'Change Scroller Direction (up, down)', 6, 2, NULL, '2014-02-11 14:05:41', NULL, NULL),
(384, 'Scroller Height', 'SCROLL_HEIGHT', '260', 'Change Scroller Height, default: 260 px', 6, 3, NULL, '2014-02-11 14:05:41', NULL, NULL),
(385, 'Scroller Speed', 'SCROLL_SPEED', '2', 'Change Scroller Speed, default: 2', 6, 4, NULL, '2014-02-11 14:05:41', NULL, NULL),
(386, 'Scroller Delay', 'SCROLL_DELAY', '20', 'Change Scroller Delay, default: 20', 6, 5, NULL, '2014-02-11 14:05:41', NULL, NULL),
(387, 'Description Length', 'SCROLL_DESC', '20', 'Display part of products description, default: 50 (0 = No description)', 6, 6, NULL, '2014-02-11 14:05:41', NULL, NULL),
(453, 'Show More', 'SPECIFICATIONS_SHOW_MORE', 'False', 'More products in the Comparison table?', 1610, 107, '2011-01-05 16:47:19', '2009-06-18 12:07:30', NULL, NULL),
(454, 'Show Empty Products', 'SPECIFICATIONS_PRODUCTS_NO_SPEC', 'True', 'Show products that have no specification data', 1610, 110, '2010-02-19 18:59:06', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(452, 'Minimum Spec Comparison', 'SPECIFICATIONS_MINIMUM_COMPARISON', '2', 'The minimum number of products having specifications needed to have the Comparison page show up for a Category', 1610, 105, '2009-07-19 19:52:33', '2009-06-18 12:07:30', NULL, NULL),
(451, '<b>Products Comparison Page</b>', 'SPECIFICATIONS_COMPARISON_HEAD', 'Subhead', 'Products Comparison page', 1610, 100, '2009-08-25 10:03:37', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''Subhead''), '),
(449, 'Show Friend Tab', 'SPECIFICATIONS_FRIEND_TAB', 'True', 'Show the Tell a Friend tab', 1610, 65, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(450, 'Show Documents Tab', 'DOCUMENTS_SHOW_PRODUCT_INFO', 'True', 'Show the More Info (Documents download) tab', 1610, 70, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(448, 'Show Question Tab', 'SPECIFICATIONS_QUESTION_TAB', 'True', 'Show the Ask a Question tab', 1610, 60, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(397, 'Enable Free Shipping Module', 'MODULE_BOXES_FREE_SHIPPING_STATUS', 'True', 'Do you want to add the module to your shop?', 6, 1, NULL, '2014-02-11 16:29:38', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(398, 'Content Placement', 'MODULE_BOXES_FREE_SHIPPING_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', 6, 1, NULL, '2014-02-11 16:29:38', NULL, 'tep_cfg_select_option(array(''Left Column'', ''Right Column''), '),
(399, 'Sort Order', 'MODULE_BOXES_FREE_SHIPPING_SORT_ORDER', '1020', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-02-11 16:29:38', NULL, NULL),
(400, 'Display in pages.', 'MODULE_BOXES_FREE_SHIPPING_DISPLAY_PAGES', 'all', 'select pages where this box should be displayed. ', 6, 0, NULL, '2014-02-11 16:29:38', NULL, 'tep_cfg_select_pages('),
(401, 'Information page.', 'MODULE_BOXES_FREE_SHIPPING_INFO_PAGE', '9', 'Enter information page to point to.', 6, 1, NULL, '2014-02-11 16:29:38', NULL, NULL),
(402, 'Facebook', 'Address', 'http://www.facebook.com/advantagedirect', 'Web address to facebook page', 17, 0, '2014-02-14 15:50:40', '2014-02-14 00:00:00', NULL, NULL),
(447, 'Max Reviews in Tab', 'SPECIFICATIONS_MAX_REVIEWS', '3', 'The maxmum number of reviews that can show in the Reviews tab', 1610, 55, '2009-09-09 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
(403, 'Twitter', 'Address', 'http://www.twitter.com', 'Web address to facebook page', 17, 0, '2014-02-14 00:00:00', '2014-02-14 00:00:00', NULL, NULL),
(404, 'Youtube', 'Address', 'http://www.youtube.co.nz', 'Web address to facebook page', 17, 0, '2014-02-14 00:00:00', '2014-02-14 00:00:00', NULL, NULL),
(405, 'Pinterest', 'Address', 'http://www.pinterest.com', 'Web address to facebook page', 17, 0, '2014-02-14 00:00:00', '2014-02-14 00:00:00', NULL, NULL),
(407, 'Tab Categories', 'MAX_DISPLAY_TAB_CATEGORIES', '6', 'How many categories to display on the front tab area', 3, 0, NULL, '0000-00-00 00:00:00', NULL, NULL),
(408, 'Display Featured Products', 'FEATURED_PRODUCTS_DISPLAY', 'true', 'Set to true or false in order to display featured.', 18, 1, '2014-02-20 11:18:04', '2014-02-20 11:18:04', NULL, 'tep_cfg_select_option(array(''true'', ''false''),'),
(409, 'Maximum Display of Featured', 'MAX_DISPLAY_FEATURED_PRODUCTS', '6', 'This is the maximum amount of items to display on the front page.', 18, 2, '2014-02-20 11:18:04', '2014-02-20 11:18:04', NULL, NULL),
(410, 'Include Sub Categories When Displaying Featured Products', 'FEATURED_PRODUCTS_SUB_CATEGORIES', 'true', 'Set to true or false in order to display featured including sub categories.', 18, 3, '2014-02-20 11:18:04', '2014-02-20 11:18:04', NULL, 'tep_cfg_select_option(array(''true'', ''false''),'),
(411, 'Specials Only When Displaying Featured Products', 'FEATURED_PRODUCTS_SPECIALS_ONLY', 'false', 'Set to true or false in order to display only on special featured products.', 18, 4, '2014-02-20 11:18:04', '2014-02-20 11:18:04', NULL, 'tep_cfg_select_option(array(''true'', ''false''),'),
(426, 'Display in pages.', 'MODULE_BOXES_MANUFACTURER_INFO_DISPLAY_PAGES', 'all', 'select pages where this box should be displayed. ', 6, 0, NULL, '2014-04-30 12:25:00', NULL, 'tep_cfg_select_pages('),
(425, 'Sort Order', 'MODULE_BOXES_MANUFACTURER_INFO_SORT_ORDER', '1011', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-04-30 12:25:00', NULL, NULL),
(424, 'Content Placement', 'MODULE_BOXES_MANUFACTURER_INFO_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', 6, 1, NULL, '2014-04-30 12:25:00', NULL, 'tep_cfg_select_option(array(''Left Column'', ''Right Column''), '),
(423, 'Enable Manufacturer Info Module', 'MODULE_BOXES_MANUFACTURER_INFO_STATUS', 'True', 'Do you want to add the module to your shop?', 6, 1, NULL, '2014-04-30 12:25:00', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(416, 'Enable SmartSuggest?', 'SMARTSUGGEST_ENABLED', 'true', 'Enable SmartSuggest? This is a global setting and will turn them off completely.', 19, 0, '2014-04-16 13:54:06', '2014-04-16 13:54:06', NULL, 'tep_cfg_select_option(array(''true'', ''false''),'),
(417, 'Enable customers searched keywords record?', 'SMARTSUGGEST_RECORD_KEYWORDS', 'true', 'Record customers searched keywords. Use them for SmartSuggest sorting and result, or for your own marketing analyze.', 19, 1, '2014-04-16 13:54:06', '2014-04-16 13:54:06', NULL, 'tep_cfg_select_option(array(''true'', ''false''),'),
(418, 'Suggest results type', 'SMARTSUGGEST_RESULT', 'Product Names', 'Suggesting results moethod. Either giving a list of full product names or simply the searched keywords from database.', 19, 2, '2014-04-16 13:54:06', '2014-04-16 13:54:06', NULL, 'tep_cfg_select_option(array(''Product Names'', ''Searched Keywords''),'),
(419, 'Suggest product results sort order', 'SMARTSUGGEST_PRODUCTS_SORT', 'Product Names', 'When suggesting results moethod is choosen to be product, sort the results by product names alphabetically or by most searched count.', 19, 3, '2014-04-16 13:54:06', '2014-04-16 13:54:06', NULL, 'tep_cfg_select_option(array(''Product Names'', ''Searched Keywords''),'),
(420, 'Number of suggestions', 'SMARTSUGGEST_LIMIT', '10', 'Maximum number of result suggestions.', 19, 4, '2014-04-16 13:54:06', '2014-04-16 13:54:06', NULL, ''),
(421, 'Mark search char as strong', 'SMARTSUGGEST_MARK_SEARCH_CHAR', 'true', 'Mark the actuall search char strong in suggest results..', 19, 5, '2014-04-16 13:54:06', '2014-04-16 13:54:06', NULL, 'tep_cfg_select_option(array(''products'', ''keywords''),'),
(422, 'Uninstall SmartSuggest', 'SMARTSUGGEST_UNINSTALL', 'false', 'This will delete all of the entries in the configuration table and customers searched keywords for SmartSuggest', 19, 6, '2014-04-16 13:54:06', '2014-04-16 13:54:06', 'tep_uninstall_smartsuggest', 'tep_cfg_select_option(array(''uninstall'', ''false''),'),
(436, 'Sort Order', 'MODULE_BOXES_INFORMATION_SORT_ORDER', '1010', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-05-08 14:51:58', NULL, NULL),
(435, 'Display in pages.', 'MODULE_BOXES_INFORMATION_DISPLAY_PAGES', 'information.php;', 'select pages where this box should be displayed. ', 6, 0, NULL, '2014-05-08 14:51:58', NULL, 'tep_cfg_select_pages('),
(433, 'Enable Information Module', 'MODULE_BOXES_INFORMATION_STATUS', 'True', 'Do you want to add the module to your shop?', 6, 1, NULL, '2014-05-08 14:51:58', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(434, 'Content Placement', 'MODULE_BOXES_INFORMATION_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', 6, 1, NULL, '2014-05-08 14:51:58', NULL, 'tep_cfg_select_option(array(''Left Column'', ''Right Column''), '),
(260, 'Installed Template Block Groups', 'TEMPLATE_BLOCK_GROUPS', 'boxes;header_tags', 'This is automatically updated. No need to edit.', 6, 0, NULL, '2014-01-29 16:35:21', NULL, NULL),
(261, 'Security Check Extended Last Run', 'MODULE_SECURITY_CHECK_EXTENDED_LAST_RUN_DATETIME', '1390966717', 'The date and time the last extended security check was performed.', 6, NULL, NULL, '2014-01-29 16:38:08', NULL, NULL);
INSERT INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES
(262, 'Enable SEO URLs 5?', 'USU5_ENABLED', 'false', 'Turn Seo Urls 5 on', 16, 1, '2014-02-20 10:08:14', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(263, 'Enable the cache?', 'USU5_CACHE_ON', 'false', 'Turn the cache system on', 16, 2, '2014-02-18 16:21:33', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(264, 'Enable multi language support?', 'USU5_MULTI_LANGUAGE_SEO_SUPPORT', 'false', 'Enable the multi language functionality', 16, 3, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(265, 'Output W3C valid URLs?', 'USU5_USE_W3C_VALID', 'true', 'This setting will output W3C valid URLs.', 16, 4, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(266, 'Select your chosen cache system?', 'USU5_CACHE_SYSTEM', 'file', 'Choose from the 4 available caching strategies.', 16, 5, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''mysql'', ''file'',''sqlite'',''memcache''), '),
(267, 'Set the number of days to store the cache.', 'USU5_CACHE_DAYS', '7', 'Set the number of days you wish to retain cached data, after this the cache will auto reset.', 16, 6, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, NULL),
(268, 'Choose the uri format', 'USU5_URLS_TYPE', 'rewrite', '<b>Choose USU5 URL format:</b>', 16, 7, '2014-01-30 11:33:21', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''standard'',''path_standard'',''rewrite'',''path_rewrite'',), '),
(269, 'Choose how your product link text is made up', 'USU5_PRODUCTS_LINK_TEXT_ORDER', 'pm', 'Product link text can be made up of:<br /><b>p</b> = product name<br /><b>c</b> = category name<br /><b>b</b> = manufacturer (brand)<br /><b>m</b> = model<br />e.g. <b>bp</b> (brand/product)', 16, 8, '2014-02-18 16:23:13', '2014-01-30 11:30:10', NULL, NULL),
(270, 'Filter Short Words', 'USU5_FILTER_SHORT_WORDS', '2', '<b>This setting will filter words.</b><br>1 = Remove words of 1 letter<br>2 = Remove words of 2 letters or less<br>3 = Remove words of 3 letters or less<br>', 16, 9, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''1'',''2'',''3'',), '),
(271, 'Add category parent to beginning of category uris?', 'USU5_ADD_CAT_PARENT', 'true', 'This setting will add the category parent name to the beginning of the category URLs (i.e. - parent-category-c-1.html).', 16, 10, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(272, 'Remove all non-alphanumeric characters?', 'USU5_REMOVE_ALL_SPEC_CHARS', 'true', 'This will remove all non-letters and non-numbers. If your language has special characters then you will need to use the character conversion system.', 16, 11, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(273, 'Add cPath to product URLs?', 'USU5_ADD_CPATH_TO_PRODUCT_URLS', 'true', 'This setting will append the cPath to the end of product URLs (i.e. - some-product-p-1.html?cPath=xx).', 16, 12, '2014-02-18 16:23:26', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(274, 'Enter special character conversions. <b>(Better to use the file based character conversions)</b>', 'USU5_CHAR_CONVERT_SET', '', 'This setting will convert characters.<br><br>The format <b>MUST</b> be in the form: <b>char=>conv,char2=>conv2</b>', 16, 13, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, NULL),
(275, 'Turn performance reporting on true/false.', 'USU5_OUPUT_PERFORMANCE', 'false', '<span style="color: red;">Performance reporting should not be set to ON on a live site</span><br>It is for reporting re: performance and queries and shows at the bottom of your site.', 16, 14, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(276, 'Turn variable reporting on true/false.', 'USU5_DEBUG_OUPUT_VARS', 'false', '<span style="color: red;">Variable reporting should not be set to ON on a live site</span><br>It is for reporting the contents of USU classes and shows unformatted at the bottom of your site.', 16, 15, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(277, 'Force www.mysite.com/ when www.mysite.com/index.php', 'USU5_HOME_PAGE_REDIRECT', 'false', 'Force a redirect to www.mysite.com/ when www.mysite.com/index.php', 16, 16, '2014-01-30 11:30:10', '2014-01-30 11:30:10', NULL, 'tep_cfg_select_option(array(''true'', ''false''), '),
(278, 'Reset USU5 Cache', 'USU5_RESET_CACHE', 'false', 'This will reset the cache data for USU5', 16, 17, '2014-02-18 16:20:48', '2014-01-30 11:30:10', 'tep_reset_cache_data_usu5', 'tep_cfg_select_option(array(''reset'', ''false''), '),
(464, 'Spec Combo Model', 'SPECIFICATIONS_COMBO_MODEL', '0', 'Show the Model number in a special combo box (0 = No, 1-9 = Sort Order)', 1610, 160, '2010-02-16 19:43:00', '2009-06-18 12:07:30', NULL, NULL),
(463, 'Spec Combo Price', 'SPECIFICATIONS_COMBO_PRICE', '0', 'Show the Price in a special combo box (0 = No, 1-9 = Sort Order)', 1610, 155, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
(282, 'display in pages.', 'MODULE_BOXES_INFORMATION_DISPLAY_PAGES', 'information.php;', 'select pages where this box should be displayed. ', 6, 0, NULL, '0000-00-00 00:00:00', NULL, 'tep_cfg_select_pages('),
(437, '<b>Products Info Page</b>', 'SPECIFICATIONS_PRODUCTS_HEAD', 'Subhead', 'Products Info page', 1610, 5, '2009-08-25 10:03:37', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''Subhead''), '),
(438, 'Minimum Spec Products', 'SPECIFICATIONS_MINIMUM_PRODUCTS', '1', 'The minimum number of specifications needed to have the Specifications box show up on the Product Info page', 1610, 10, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
(439, 'Show Specification Name', 'SPECIFICATIONS_SHOW_NAME_PRODUCTS', 'True', 'Show the name of the specification in the box', 1610, 15, '2009-12-03 14:40:32', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(440, 'Show Spec Box Title', 'SPECIFICATIONS_SHOW_TITLE_PRODUCTS', 'True', 'Show the title above the Specifications box', 1610, 20, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(441, 'Spec Box Frame Style', 'SPECIFICATIONS_BOX_FRAME_STYLE', 'Tabs', 'Show the Specifications in a standard box (Stock), a simple outline box (Simple), no box (Plain), or a tabbed content box (Tabs)', 1610, 25, '2009-08-13 21:28:59', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''Stock'',''Simple'',''Plain'',''Tabs''), '),
(442, 'Show Accessories Tab', 'SPECIFICATIONS_ACCESSORIES_TAB', 'False', 'Show the Accessories (Cross-sell) tab', 1610, 30, '2009-12-27 22:36:15', '2009-09-09 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(443, 'Mouseover in Accessories Tab', 'SPECIFICATIONS_ACCESSORIES_MOUSEOVER', 'True', 'Change the border color on mouseover in the Accessories (Cross-sell) tab', 1610, 35, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(444, 'Show Image in Accessories Tab', 'SPECIFICATIONS_ACCESSORIES_IMAGE', 'True', 'Show the products image in the Accessories (Cross-sell) tab', 1610, 40, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(294, 'Use CKEditor', 'USE_CKEDITOR_ADMIN_TEXTAREA', 'true', 'Use CKEditor for WYSIWYG editing of textarea fields in admin', 1, 99, NULL, '2014-01-30 13:38:00', NULL, 'tep_cfg_select_option(array(''true'', ''false''),'),
(462, 'Spec Combo Weight', 'SPECIFICATIONS_COMBO_WEIGHT', '0', 'Show the Weight in a special combo box (0 = No, 1-9 = Sort Order)', 1610, 150, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
(460, 'Comparison Box Style', 'SPECIFICATIONS_COMPARISON_STYLE', 'Simple', 'Show the Specifications in a standard box (Stock), a simple outline box (Simple), or no box (Plain)', 1610, 140, '2009-07-18 22:11:04', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''Stock'', ''Simple'', ''Plain''), '),
(459, 'Comparison Suffix in Header', 'SPECIFICATIONS_COMP_SUFFIX', 'True', 'Show the Suffix in the Comparison table header (Otherwise in each field)', 1610, 135, '2009-07-18 22:11:04', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(458, 'Comparison in Index', 'SPECIFICATIONS_BOX_COMP_INDEX', 'False', 'Show the Comparison table instead of the Products list in the Index page ', 1610, 130, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(457, 'Show Comparison', 'SPECIFICATIONS_BOX_COMPARISON', 'True', 'Show the Comparison table in a separate page', 1610, 125, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(456, 'Comparison Row in Table', 'SPECIFICATIONS_COMP_TABLE_ROW', 'both', 'Show a link to the Comparison in the Products list on the Index page ', 1610, 120, '2009-06-26 18:24:00', '2009-06-26 12:07:30', NULL, 'tep_cfg_select_option(array(''top'', ''bottom'', ''both'', ''none''), '),
(455, 'Comparison Link in Index', 'SPECIFICATIONS_COMP_LINK', 'True', 'Show a link to the Comparison table on the Index page ', 1610, 115, '0000-00-00 00:00:00', '2009-06-26 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(376, 'Enable Scrolling Specials Module', 'MODULE_BOXES_SCROLLING_SPECIALS_STATUS', 'True', 'Do you want to add the module to your shop?', 6, 1, NULL, '2014-02-07 17:04:20', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(377, 'Content Placement', 'MODULE_BOXES_SCROLLING_SPECIALS_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', 6, 1, NULL, '2014-02-07 17:04:20', NULL, 'tep_cfg_select_option(array(''Left Column'', ''Right Column''), '),
(378, 'Sort Order', 'MODULE_BOXES_SCROLLING_SPECIALS_SORT_ORDER', '1030', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2014-02-07 17:04:20', NULL, NULL),
(379, 'Display in pages.', 'MODULE_BOXES_SCROLLING_SPECIALS_DISPLAY_PAGES', 'all', 'select pages where this box should be displayed. ', 6, 0, NULL, '2014-02-07 17:04:20', NULL, 'tep_cfg_select_pages('),
(461, 'Spec Combo Manufacturer', 'SPECIFICATIONS_COMBO_MFR', '0', 'Show the Manufacturer in a special combo box (0 = No, 1-9 = Sort Order)', 1610, 145, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
(465, 'Spec Combo Image', 'SPECIFICATIONS_COMBO_IMAGE', '1', 'Show the Image in a special combo box (0 = No, 1-9 = Sort Order)', 1610, 165, '2009-06-18 15:31:10', '2009-06-18 12:07:30', NULL, NULL),
(466, 'Spec Combo Name', 'SPECIFICATIONS_COMBO_NAME', '2', 'Show the Name in a special combo box (0 = No, 1-9 = Sort Order)', 1610, 170, '2010-02-16 19:42:51', '2009-06-18 12:07:30', NULL, NULL),
(467, 'Spec Combo Buy Now', 'SPECIFICATIONS_COMBO_BUY_NOW', '0', 'Show the Buy Now in a special combo box (0 = No, 1-9 = Sort Order)', 1610, 175, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
(468, '<b>Products Filters</b>', 'SPECIFICATIONS_FILTERS_HEAD', 'Subhead', 'Products Filters', 1610, 200, '2009-08-25 10:03:37', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''Subhead''), '),
(469, 'Show Filters Module', 'SPECIFICATIONS_FILTERS_MODULE', 'False', 'Show the Filters module in the center column (main part of the page)', 1610, 205, '2009-12-05 15:02:11', '2009-09-09 09:09:09', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(470, 'Filters Module Frame Style', 'SPECIFICATIONS_FILTERS_FRAME_STYLE', 'Stock', 'Show the Filters in a standard box (Stock), a simple outline box (Simple), or no box (Plain)', 1610, 215, '2009-08-13 21:28:59', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''Stock'', ''Simple'', ''Plain''), '),
(471, 'Filter Subcategories', 'SPECIFICATIONS_FILTER_SUBCATEGORIES', 'True', 'Include subcategories in the filter results', 1610, 225, '2009-08-12 15:16:55', '2009-06-18 12:07:30', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(472, 'Filter No Result', 'SPECIFICATIONS_FILTER_NO_RESULT', 'grey', 'What to show for a filter that would return no result.', 1610, 235, '2009-08-23 22:00:43', '2009-07-15 19:15:14', NULL, 'tep_cfg_select_option(array(''none'', ''grey'', ''normal''), '),
(473, 'Filter Show Breadcrumb', 'SPECIFICATIONS_FILTER_BREADCRUMB', 'True', 'Show currently applied filters in the Breadcrumb trail with option to remove', 1610, 240, '2009-07-15 19:15:07', '2009-07-15 19:15:14', NULL, 'tep_cfg_select_option(array(''True'', ''False''), '),
(474, 'Filter Image Width', 'SPECIFICATIONS_FILTER_IMAGE_WIDTH', '20', 'Set the width of the images displayed as filters in the filter box.', 1610, 245, '2009-07-15 18:46:21', '2009-07-15 18:46:30', NULL, NULL),
(475, 'Filter Image Height', 'SPECIFICATIONS_FILTER_IMAGE_HEIGHT', '20', 'Set the height of the images displayed as filters in the filter box.', 1610, 250, '2009-07-15 18:46:37', '2009-07-15 18:46:45', NULL, NULL),
(476, 'Get All Image', 'SPECIFICATIONS_GET_ALL_IMAGE', 'get_all.gif', 'Set the name of the image to display for the all products image filter.', 1610, 255, '2010-07-15 18:46:37', '2010-07-15 18:46:45', NULL, NULL),
(477, '<b>Products Feeders</b>', 'SPECIFICATIONS_FEEDERS_HEAD', 'Subhead', 'Products Feeders', 1610, 300, '2010-10-25 10:03:37', '2010-10-25 12:07:30', NULL, 'tep_cfg_select_option(array(''Subhead''), '),
(478, 'Product Info Image Width', 'PROD_INFO_IMAGE_WIDTH', '290', 'The pixel width of product info images', 4, 1, '2014-05-27 13:49:48', '2014-01-29 16:35:21', NULL, NULL),
(479, 'Product Info Image Height', 'PROD_INFO_IMAGE_HEIGHT', '', 'The pixel height of product info images', 4, 1, '2014-05-27 13:49:56', '2014-01-29 16:35:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `configuration_group`
--

DROP TABLE IF EXISTS `configuration_group`;
CREATE TABLE IF NOT EXISTS `configuration_group` (
  `configuration_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `configuration_group_title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `configuration_group_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(5) DEFAULT NULL,
  `visible` int(1) DEFAULT '1',
  PRIMARY KEY (`configuration_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1611 ;

--
-- Dumping data for table `configuration_group`
--

INSERT INTO `configuration_group` (`configuration_group_id`, `configuration_group_title`, `configuration_group_description`, `sort_order`, `visible`) VALUES
(1, 'My Store', 'General information about my store', 1, 1),
(2, 'Minimum Values', 'The minimum values for functions / data', 2, 1),
(3, 'Maximum Values', 'The maximum values for functions / data', 3, 1),
(4, 'Images', 'Image parameters', 4, 1),
(5, 'Customer Details', 'Customer account configuration', 5, 1),
(6, 'Module Options', 'Hidden from configuration', 6, 0),
(7, 'Shipping/Packaging', 'Shipping options available at my store', 7, 1),
(8, 'Product Listing', 'Product Listing    configuration options', 8, 1),
(9, 'Stock', 'Stock configuration options', 9, 1),
(10, 'Logging', 'Logging configuration options', 10, 1),
(11, 'Cache', 'Caching configuration options', 11, 1),
(12, 'E-Mail Options', 'General setting for E-Mail transport and HTML E-Mails', 12, 1),
(13, 'Download', 'Downloadable products options', 13, 1),
(14, 'GZip Compression', 'GZip compression options', 14, 1),
(15, 'Sessions', 'Session options', 15, 1),
(16, 'Seo Urls 5', 'Options for ULTIMATE Seo Urls 5 by FWR Media', 16, 1),
(17, 'Social Media', 'Links to our social media sites', 17, 1),
(18, 'Featured', 'Featured Products Display', 18, 1),
(19, 'SmartSuggest', 'Options for SmartSuggest by fuR', 19, 1),
(1610, 'Products Specifications', 'Products Specifications configuration options', 1610, 1);

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

DROP TABLE IF EXISTS `counter`;
CREATE TABLE IF NOT EXISTS `counter` (
  `startdate` char(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `counter` int(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `counter`
--

INSERT INTO `counter` (`startdate`, `counter`) VALUES
('20140129', 2198);

-- --------------------------------------------------------

--
-- Table structure for table `counter_history`
--

DROP TABLE IF EXISTS `counter_history`;
CREATE TABLE IF NOT EXISTS `counter_history` (
  `month` char(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `counter` int(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `countries_id` int(11) NOT NULL AUTO_INCREMENT,
  `countries_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `countries_iso_code_2` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `countries_iso_code_3` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `address_format_id` int(11) NOT NULL,
  PRIMARY KEY (`countries_id`),
  KEY `IDX_COUNTRIES_NAME` (`countries_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=240 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countries_id`, `countries_name`, `countries_iso_code_2`, `countries_iso_code_3`, `address_format_id`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', 1),
(2, 'Albania', 'AL', 'ALB', 1),
(3, 'Algeria', 'DZ', 'DZA', 1),
(4, 'American Samoa', 'AS', 'ASM', 1),
(5, 'Andorra', 'AD', 'AND', 1),
(6, 'Angola', 'AO', 'AGO', 1),
(7, 'Anguilla', 'AI', 'AIA', 1),
(8, 'Antarctica', 'AQ', 'ATA', 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', 1),
(10, 'Argentina', 'AR', 'ARG', 1),
(11, 'Armenia', 'AM', 'ARM', 1),
(12, 'Aruba', 'AW', 'ABW', 1),
(13, 'Australia', 'AU', 'AUS', 1),
(14, 'Austria', 'AT', 'AUT', 5),
(15, 'Azerbaijan', 'AZ', 'AZE', 1),
(16, 'Bahamas', 'BS', 'BHS', 1),
(17, 'Bahrain', 'BH', 'BHR', 1),
(18, 'Bangladesh', 'BD', 'BGD', 1),
(19, 'Barbados', 'BB', 'BRB', 1),
(20, 'Belarus', 'BY', 'BLR', 1),
(21, 'Belgium', 'BE', 'BEL', 1),
(22, 'Belize', 'BZ', 'BLZ', 1),
(23, 'Benin', 'BJ', 'BEN', 1),
(24, 'Bermuda', 'BM', 'BMU', 1),
(25, 'Bhutan', 'BT', 'BTN', 1),
(26, 'Bolivia', 'BO', 'BOL', 1),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', 1),
(28, 'Botswana', 'BW', 'BWA', 1),
(29, 'Bouvet Island', 'BV', 'BVT', 1),
(30, 'Brazil', 'BR', 'BRA', 1),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', 1),
(33, 'Bulgaria', 'BG', 'BGR', 1),
(34, 'Burkina Faso', 'BF', 'BFA', 1),
(35, 'Burundi', 'BI', 'BDI', 1),
(36, 'Cambodia', 'KH', 'KHM', 1),
(37, 'Cameroon', 'CM', 'CMR', 1),
(38, 'Canada', 'CA', 'CAN', 1),
(39, 'Cape Verde', 'CV', 'CPV', 1),
(40, 'Cayman Islands', 'KY', 'CYM', 1),
(41, 'Central African Republic', 'CF', 'CAF', 1),
(42, 'Chad', 'TD', 'TCD', 1),
(43, 'Chile', 'CL', 'CHL', 1),
(44, 'China', 'CN', 'CHN', 1),
(45, 'Christmas Island', 'CX', 'CXR', 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1),
(47, 'Colombia', 'CO', 'COL', 1),
(48, 'Comoros', 'KM', 'COM', 1),
(49, 'Congo', 'CG', 'COG', 1),
(50, 'Cook Islands', 'CK', 'COK', 1),
(51, 'Costa Rica', 'CR', 'CRI', 1),
(52, 'Cote D''Ivoire', 'CI', 'CIV', 1),
(53, 'Croatia', 'HR', 'HRV', 1),
(54, 'Cuba', 'CU', 'CUB', 1),
(55, 'Cyprus', 'CY', 'CYP', 1),
(56, 'Czech Republic', 'CZ', 'CZE', 1),
(57, 'Denmark', 'DK', 'DNK', 1),
(58, 'Djibouti', 'DJ', 'DJI', 1),
(59, 'Dominica', 'DM', 'DMA', 1),
(60, 'Dominican Republic', 'DO', 'DOM', 1),
(61, 'East Timor', 'TP', 'TMP', 1),
(62, 'Ecuador', 'EC', 'ECU', 1),
(63, 'Egypt', 'EG', 'EGY', 1),
(64, 'El Salvador', 'SV', 'SLV', 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', 1),
(66, 'Eritrea', 'ER', 'ERI', 1),
(67, 'Estonia', 'EE', 'EST', 1),
(68, 'Ethiopia', 'ET', 'ETH', 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1),
(70, 'Faroe Islands', 'FO', 'FRO', 1),
(71, 'Fiji', 'FJ', 'FJI', 1),
(72, 'Finland', 'FI', 'FIN', 1),
(73, 'France', 'FR', 'FRA', 1),
(74, 'France, Metropolitan', 'FX', 'FXX', 1),
(75, 'French Guiana', 'GF', 'GUF', 1),
(76, 'French Polynesia', 'PF', 'PYF', 1),
(77, 'French Southern Territories', 'TF', 'ATF', 1),
(78, 'Gabon', 'GA', 'GAB', 1),
(79, 'Gambia', 'GM', 'GMB', 1),
(80, 'Georgia', 'GE', 'GEO', 1),
(81, 'Germany', 'DE', 'DEU', 5),
(82, 'Ghana', 'GH', 'GHA', 1),
(83, 'Gibraltar', 'GI', 'GIB', 1),
(84, 'Greece', 'GR', 'GRC', 1),
(85, 'Greenland', 'GL', 'GRL', 1),
(86, 'Grenada', 'GD', 'GRD', 1),
(87, 'Guadeloupe', 'GP', 'GLP', 1),
(88, 'Guam', 'GU', 'GUM', 1),
(89, 'Guatemala', 'GT', 'GTM', 1),
(90, 'Guinea', 'GN', 'GIN', 1),
(91, 'Guinea-bissau', 'GW', 'GNB', 1),
(92, 'Guyana', 'GY', 'GUY', 1),
(93, 'Haiti', 'HT', 'HTI', 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1),
(95, 'Honduras', 'HN', 'HND', 1),
(96, 'Hong Kong', 'HK', 'HKG', 1),
(97, 'Hungary', 'HU', 'HUN', 1),
(98, 'Iceland', 'IS', 'ISL', 1),
(99, 'India', 'IN', 'IND', 1),
(100, 'Indonesia', 'ID', 'IDN', 1),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1),
(102, 'Iraq', 'IQ', 'IRQ', 1),
(103, 'Ireland', 'IE', 'IRL', 1),
(104, 'Israel', 'IL', 'ISR', 1),
(105, 'Italy', 'IT', 'ITA', 1),
(106, 'Jamaica', 'JM', 'JAM', 1),
(107, 'Japan', 'JP', 'JPN', 1),
(108, 'Jordan', 'JO', 'JOR', 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', 1),
(110, 'Kenya', 'KE', 'KEN', 1),
(111, 'Kiribati', 'KI', 'KIR', 1),
(112, 'Korea, Democratic People''s Republic of', 'KP', 'PRK', 1),
(113, 'Korea, Republic of', 'KR', 'KOR', 1),
(114, 'Kuwait', 'KW', 'KWT', 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', 1),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO', 1),
(117, 'Latvia', 'LV', 'LVA', 1),
(118, 'Lebanon', 'LB', 'LBN', 1),
(119, 'Lesotho', 'LS', 'LSO', 1),
(120, 'Liberia', 'LR', 'LBR', 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1),
(122, 'Liechtenstein', 'LI', 'LIE', 1),
(123, 'Lithuania', 'LT', 'LTU', 1),
(124, 'Luxembourg', 'LU', 'LUX', 1),
(125, 'Macau', 'MO', 'MAC', 1),
(126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD', 1),
(127, 'Madagascar', 'MG', 'MDG', 1),
(128, 'Malawi', 'MW', 'MWI', 1),
(129, 'Malaysia', 'MY', 'MYS', 1),
(130, 'Maldives', 'MV', 'MDV', 1),
(131, 'Mali', 'ML', 'MLI', 1),
(132, 'Malta', 'MT', 'MLT', 1),
(133, 'Marshall Islands', 'MH', 'MHL', 1),
(134, 'Martinique', 'MQ', 'MTQ', 1),
(135, 'Mauritania', 'MR', 'MRT', 1),
(136, 'Mauritius', 'MU', 'MUS', 1),
(137, 'Mayotte', 'YT', 'MYT', 1),
(138, 'Mexico', 'MX', 'MEX', 1),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', 1),
(141, 'Monaco', 'MC', 'MCO', 1),
(142, 'Mongolia', 'MN', 'MNG', 1),
(143, 'Montserrat', 'MS', 'MSR', 1),
(144, 'Morocco', 'MA', 'MAR', 1),
(145, 'Mozambique', 'MZ', 'MOZ', 1),
(146, 'Myanmar', 'MM', 'MMR', 1),
(147, 'Namibia', 'NA', 'NAM', 1),
(148, 'Nauru', 'NR', 'NRU', 1),
(149, 'Nepal', 'NP', 'NPL', 1),
(150, 'Netherlands', 'NL', 'NLD', 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', 1),
(152, 'New Caledonia', 'NC', 'NCL', 1),
(153, 'New Zealand', 'NZ', 'NZL', 1),
(154, 'Nicaragua', 'NI', 'NIC', 1),
(155, 'Niger', 'NE', 'NER', 1),
(156, 'Nigeria', 'NG', 'NGA', 1),
(157, 'Niue', 'NU', 'NIU', 1),
(158, 'Norfolk Island', 'NF', 'NFK', 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', 1),
(160, 'Norway', 'NO', 'NOR', 1),
(161, 'Oman', 'OM', 'OMN', 1),
(162, 'Pakistan', 'PK', 'PAK', 1),
(163, 'Palau', 'PW', 'PLW', 1),
(164, 'Panama', 'PA', 'PAN', 1),
(165, 'Papua New Guinea', 'PG', 'PNG', 1),
(166, 'Paraguay', 'PY', 'PRY', 1),
(167, 'Peru', 'PE', 'PER', 1),
(168, 'Philippines', 'PH', 'PHL', 1),
(169, 'Pitcairn', 'PN', 'PCN', 1),
(170, 'Poland', 'PL', 'POL', 1),
(171, 'Portugal', 'PT', 'PRT', 1),
(172, 'Puerto Rico', 'PR', 'PRI', 1),
(173, 'Qatar', 'QA', 'QAT', 1),
(174, 'Reunion', 'RE', 'REU', 1),
(175, 'Romania', 'RO', 'ROM', 1),
(176, 'Russian Federation', 'RU', 'RUS', 1),
(177, 'Rwanda', 'RW', 'RWA', 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1),
(179, 'Saint Lucia', 'LC', 'LCA', 1),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 1),
(181, 'Samoa', 'WS', 'WSM', 1),
(182, 'San Marino', 'SM', 'SMR', 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', 1),
(184, 'Saudi Arabia', 'SA', 'SAU', 1),
(185, 'Senegal', 'SN', 'SEN', 1),
(186, 'Seychelles', 'SC', 'SYC', 1),
(187, 'Sierra Leone', 'SL', 'SLE', 1),
(188, 'Singapore', 'SG', 'SGP', 4),
(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK', 1),
(190, 'Slovenia', 'SI', 'SVN', 1),
(191, 'Solomon Islands', 'SB', 'SLB', 1),
(192, 'Somalia', 'SO', 'SOM', 1),
(193, 'South Africa', 'ZA', 'ZAF', 1),
(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', 1),
(195, 'Spain', 'ES', 'ESP', 3),
(196, 'Sri Lanka', 'LK', 'LKA', 1),
(197, 'St. Helena', 'SH', 'SHN', 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1),
(199, 'Sudan', 'SD', 'SDN', 1),
(200, 'Suriname', 'SR', 'SUR', 1),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', 1),
(202, 'Swaziland', 'SZ', 'SWZ', 1),
(203, 'Sweden', 'SE', 'SWE', 1),
(204, 'Switzerland', 'CH', 'CHE', 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', 1),
(206, 'Taiwan', 'TW', 'TWN', 1),
(207, 'Tajikistan', 'TJ', 'TJK', 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1),
(209, 'Thailand', 'TH', 'THA', 1),
(210, 'Togo', 'TG', 'TGO', 1),
(211, 'Tokelau', 'TK', 'TKL', 1),
(212, 'Tonga', 'TO', 'TON', 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', 1),
(214, 'Tunisia', 'TN', 'TUN', 1),
(215, 'Turkey', 'TR', 'TUR', 1),
(216, 'Turkmenistan', 'TM', 'TKM', 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', 1),
(218, 'Tuvalu', 'TV', 'TUV', 1),
(219, 'Uganda', 'UG', 'UGA', 1),
(220, 'Ukraine', 'UA', 'UKR', 1),
(221, 'United Arab Emirates', 'AE', 'ARE', 1),
(222, 'United Kingdom', 'GB', 'GBR', 1),
(223, 'United States', 'US', 'USA', 2),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', 1),
(225, 'Uruguay', 'UY', 'URY', 1),
(226, 'Uzbekistan', 'UZ', 'UZB', 1),
(227, 'Vanuatu', 'VU', 'VUT', 1),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', 1),
(229, 'Venezuela', 'VE', 'VEN', 1),
(230, 'Viet Nam', 'VN', 'VNM', 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1),
(234, 'Western Sahara', 'EH', 'ESH', 1),
(235, 'Yemen', 'YE', 'YEM', 1),
(236, 'Yugoslavia', 'YU', 'YUG', 1),
(237, 'Zaire', 'ZR', 'ZAR', 1),
(238, 'Zambia', 'ZM', 'ZMB', 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `currencies_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `code` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `symbol_left` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol_right` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decimal_point` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thousands_point` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decimal_places` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` float(13,8) DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`currencies_id`),
  KEY `idx_currencies_code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currencies_id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_point`, `thousands_point`, `decimal_places`, `value`, `last_updated`) VALUES
(3, 'New Zealand Dollar', 'NZD', '$', '', '.', ',', '2', 1.00000000, '2014-01-30 11:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customers_id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_gender` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customers_firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_dob` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `customers_email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_default_address_id` int(11) DEFAULT NULL,
  `customers_telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customers_password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `customers_newsletter` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customers_group_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `customers_group_ra` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `customers_payment_allowed` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customers_shipment_allowed` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customers_order_total_allowed` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customers_specific_taxes_exempt` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_company_tax_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`customers_id`),
  KEY `idx_customers_email_address` (`customers_email_address`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers_basket`
--

DROP TABLE IF EXISTS `customers_basket`;
CREATE TABLE IF NOT EXISTS `customers_basket` (
  `customers_basket_id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL,
  `products_id` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `customers_basket_quantity` int(2) NOT NULL,
  `final_price` decimal(15,4) DEFAULT NULL,
  `customers_basket_date_added` char(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`customers_basket_id`),
  KEY `idx_customers_basket_customers_id` (`customers_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers_basket_attributes`
--

DROP TABLE IF EXISTS `customers_basket_attributes`;
CREATE TABLE IF NOT EXISTS `customers_basket_attributes` (
  `customers_basket_attributes_id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL,
  `products_id` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `products_options_id` int(11) NOT NULL,
  `products_options_value_id` int(11) NOT NULL,
  PRIMARY KEY (`customers_basket_attributes_id`),
  KEY `idx_customers_basket_att_customers_id` (`customers_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers_groups`
--

DROP TABLE IF EXISTS `customers_groups`;
CREATE TABLE IF NOT EXISTS `customers_groups` (
  `customers_group_id` smallint(5) unsigned NOT NULL,
  `customers_group_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customers_group_show_tax` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `customers_group_tax_exempt` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `group_payment_allowed` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_shipment_allowed` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_order_total_allowed` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_specific_taxes_exempt` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`customers_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers_groups`
--

INSERT INTO `customers_groups` (`customers_group_id`, `customers_group_name`, `customers_group_show_tax`, `customers_group_tax_exempt`, `group_payment_allowed`, `group_shipment_allowed`, `group_order_total_allowed`, `group_specific_taxes_exempt`) VALUES
(0, 'Retail', '1', '0', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `customers_info`
--

DROP TABLE IF EXISTS `customers_info`;
CREATE TABLE IF NOT EXISTS `customers_info` (
  `customers_info_id` int(11) NOT NULL,
  `customers_info_date_of_last_logon` datetime DEFAULT NULL,
  `customers_info_number_of_logons` int(5) DEFAULT NULL,
  `customers_info_date_account_created` datetime DEFAULT NULL,
  `customers_info_date_account_last_modified` datetime DEFAULT NULL,
  `global_product_notifications` int(1) DEFAULT '0',
  `password_reset_key` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_date` datetime DEFAULT NULL,
  PRIMARY KEY (`customers_info_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers_wishlist`
--

DROP TABLE IF EXISTS `customers_wishlist`;
CREATE TABLE IF NOT EXISTS `customers_wishlist` (
  `products_id` tinytext NOT NULL,
  `customers_id` int(13) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers_wishlist_attributes`
--

DROP TABLE IF EXISTS `customers_wishlist_attributes`;
CREATE TABLE IF NOT EXISTS `customers_wishlist_attributes` (
  `customers_wishlist_attributes_id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL DEFAULT '0',
  `products_id` tinytext NOT NULL,
  `products_options_id` int(11) NOT NULL DEFAULT '0',
  `products_options_value_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customers_wishlist_attributes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `define_content`
--

DROP TABLE IF EXISTS `define_content`;
CREATE TABLE IF NOT EXISTS `define_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(50) NOT NULL,
  `page_url` varchar(50) NOT NULL,
  `page_content` text NOT NULL,
  `status` enum('yes','no') NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '1',
  `created_date` date NOT NULL,
  `login_view` enum('yes','no') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `define_content`
--

INSERT INTO `define_content` (`id`, `page_title`, `page_url`, `page_content`, `status`, `language_id`, `created_date`, `login_view`) VALUES
(1, 'Shipping & Returns', 'shipping-returns', '<p><span>Enter Shipping Information Here.&nbsp;</span></p>', 'yes', 1, '2013-02-28', 'no'),
(2, 'Privacy Notice', 'privacy-notice', '<p><span>Enter privacy Notice Here.</span></p>', 'yes', 1, '2013-02-28', 'no'),
(3, 'Conditions of Use', 'conditions-of-use', '<p><span>Enter Conditions of Use Here.</span></p>', 'yes', 1, '2013-02-28', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `featured`
--

DROP TABLE IF EXISTS `featured`;
CREATE TABLE IF NOT EXISTS `featured` (
  `featured_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL DEFAULT '0',
  `featured_date_added` datetime DEFAULT NULL,
  `featured_last_modified` datetime DEFAULT NULL,
  `expires_date` datetime DEFAULT NULL,
  `date_status_change` datetime DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  PRIMARY KEY (`featured_id`),
  KEY `idx_products_id` (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `featured`
--

INSERT INTO `featured` (`featured_id`, `products_id`, `featured_date_added`, `featured_last_modified`, `expires_date`, `date_status_change`, `status`) VALUES
(1, 8, '2014-02-20 11:19:42', '2014-02-20 11:20:25', '2014-02-28 00:00:00', '2014-03-13 16:50:03', 0),
(2, 27, '2014-02-20 11:20:17', NULL, '2014-02-28 00:00:00', '2014-03-13 16:50:03', 0),
(3, 20, '2014-02-20 11:20:35', NULL, '2014-02-28 00:00:00', '2014-03-13 16:50:03', 0),
(4, 3, '2014-02-20 11:32:22', NULL, '2014-02-28 00:00:00', '2014-03-13 16:50:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `featured_video`
--

DROP TABLE IF EXISTS `featured_video`;
CREATE TABLE IF NOT EXISTS `featured_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_name` text NOT NULL,
  `video_url` text NOT NULL,
  `created_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `geo_zones`
--

DROP TABLE IF EXISTS `geo_zones`;
CREATE TABLE IF NOT EXISTS `geo_zones` (
  `geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `geo_zone_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `geo_zone_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`geo_zone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `geo_zones`
--

INSERT INTO `geo_zones` (`geo_zone_id`, `geo_zone_name`, `geo_zone_description`, `last_modified`, `date_added`) VALUES
(2, 'New Zealand', 'New Zealand', NULL, '2014-01-30 11:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
CREATE TABLE IF NOT EXISTS `information` (
  `information_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `information_group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `information_title` varchar(255) NOT NULL DEFAULT '',
  `information_description` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `visible` enum('1','0') NOT NULL DEFAULT '1',
  `language_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`information_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`information_id`, `information_group_id`, `information_title`, `information_description`, `parent_id`, `sort_order`, `visible`, `language_id`) VALUES
(1, 2, 'HEADING_TITLE', '<p>Welcome to our store, your one stop shop for all your needs.</p>', 0, 1, '1', 1),
(2, 2, 'TEXT_GREETING_PERSONAL', 'Welcome back <span class="greetUser">%s!</span> Would you like to see which <a href="%s"><u>new products</u></a> are available to purchase?', 0, 2, '1', 1),
(3, 2, 'TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s, please <a href="%s"><u>log yourself in</u></a> with your account information.</small>', 0, 3, '1', 1),
(4, 2, 'TEXT_GREETING_GUEST', 'Welcome <span class="greetUser">Guest!</span> Would you like to <a href="%s"><u>log yourself in</u></a>? Or would you prefer to <a href="%s"><u>create an account</u></a>?', 0, 4, '1', 1),
(5, 2, 'TEXT_MAIN', '<p>Can&#39;t find something? Ask us!</p>', 0, 5, '1', 1),
(6, 1, 'Returns Policy', '', 0, 1, '1', 1),
(10, 1, 'Online Store Usage Policy', '', 0, 5, '1', 1),
(7, 1, 'Payment Methods', '', 0, 2, '1', 1),
(8, 1, 'Contact Us', '', 0, 3, '1', 1),
(9, 1, 'Free Shipping', '', 0, 4, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `information_group`
--

DROP TABLE IF EXISTS `information_group`;
CREATE TABLE IF NOT EXISTS `information_group` (
  `information_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `information_group_title` varchar(64) NOT NULL DEFAULT '',
  `information_group_description` varchar(255) NOT NULL DEFAULT '',
  `sort_order` int(5) DEFAULT NULL,
  `visible` int(1) DEFAULT '1',
  `locked` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`information_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `information_group`
--

INSERT INTO `information_group` (`information_group_id`, `information_group_title`, `information_group_description`, `sort_order`, `visible`, `locked`) VALUES
(1, 'Information pages', 'Information pages', 1, 1, ''),
(2, 'Welcome message', 'Welcome message', 2, 1, 'information_title, sort_order, parent_id, visible');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `languages_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `directory` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(3) DEFAULT NULL,
  PRIMARY KEY (`languages_id`),
  KEY `IDX_LANGUAGES_NAME` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`languages_id`, `name`, `code`, `image`, `directory`, `sort_order`) VALUES
(1, 'English', 'en', 'icon.gif', 'english', 1);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

DROP TABLE IF EXISTS `manufacturers`;
CREATE TABLE IF NOT EXISTS `manufacturers` (
  `manufacturers_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturers_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturers_image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`manufacturers_id`),
  KEY `IDX_MANUFACTURERS_NAME` (`manufacturers_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturers_id`, `manufacturers_name`, `manufacturers_image`, `date_added`, `last_modified`) VALUES
(1, 'Matrox', 'manufacturer_matrox.gif', '2014-01-29 16:35:21', NULL),
(2, 'Microsoft', 'manufacturer_microsoft.gif', '2014-01-29 16:35:21', NULL),
(3, 'Warner', 'manufacturer_warner.gif', '2014-01-29 16:35:21', NULL),
(4, 'Fox', 'manufacturers/manufacturer_fox.gif', '2014-01-29 16:35:21', '2014-01-30 14:21:30'),
(5, 'Logitech', 'manufacturer_logitech.gif', '2014-01-29 16:35:21', NULL),
(6, 'Canon', 'manufacturers/manufacturer_canon.gif', '2014-01-29 16:35:21', '2014-01-30 14:02:24'),
(7, 'Sierra', 'manufacturer_sierra.gif', '2014-01-29 16:35:21', NULL),
(8, 'GT Interactive', 'manufacturer_gt_interactive.gif', '2014-01-29 16:35:21', NULL),
(9, 'Hewlett Packard', 'manufacturer_hewlett_packard.gif', '2014-01-29 16:35:21', NULL),
(10, 'Samsung', 'manufacturer_samsung.png', '2014-01-29 16:35:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers_info`
--

DROP TABLE IF EXISTS `manufacturers_info`;
CREATE TABLE IF NOT EXISTS `manufacturers_info` (
  `manufacturers_id` int(11) NOT NULL,
  `languages_id` int(11) NOT NULL,
  `manufacturers_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_clicked` int(5) NOT NULL DEFAULT '0',
  `date_last_click` datetime DEFAULT NULL,
  PRIMARY KEY (`manufacturers_id`,`languages_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `manufacturers_info`
--

INSERT INTO `manufacturers_info` (`manufacturers_id`, `languages_id`, `manufacturers_url`, `url_clicked`, `date_last_click`) VALUES
(1, 1, 'http://www.matrox.com', 0, NULL),
(2, 1, 'http://www.microsoft.com', 0, NULL),
(3, 1, 'http://www.warner.com', 1, '2014-04-30 12:44:32'),
(4, 1, 'http://www.fox.com', 0, NULL),
(5, 1, 'http://www.logitech.com', 0, NULL),
(6, 1, 'http://www.canon.com', 0, NULL),
(7, 1, 'http://www.sierra.com', 0, NULL),
(8, 1, 'http://www.infogrames.com', 0, NULL),
(9, 1, 'http://www.hewlettpackard.com', 0, NULL),
(10, 1, 'http://www.samsung.com', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE IF NOT EXISTS `newsletters` (
  `newsletters_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_sent` datetime DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `locked` int(1) DEFAULT '0',
  `send_to_customer_groups` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`newsletters_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `orders_id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL,
  `customers_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customers_street_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_suburb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customers_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customers_country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_address_format_id` int(5) NOT NULL,
  `delivery_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_street_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_suburb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_address_format_id` int(5) NOT NULL,
  `billing_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_street_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_suburb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_address_format_id` int(5) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cc_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_owner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_expires` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `date_purchased` datetime DEFAULT NULL,
  `orders_status` int(5) NOT NULL,
  `orders_date_finished` datetime DEFAULT NULL,
  `currency` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_value` decimal(14,6) DEFAULT NULL,
  PRIMARY KEY (`orders_id`),
  KEY `idx_orders_customers_id` (`customers_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1002 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

DROP TABLE IF EXISTS `orders_products`;
CREATE TABLE IF NOT EXISTS `orders_products` (
  `orders_products_id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `products_model` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `products_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `products_price` decimal(15,4) NOT NULL,
  `final_price` decimal(15,4) NOT NULL,
  `products_tax` decimal(7,4) NOT NULL,
  `products_quantity` int(2) NOT NULL,
  PRIMARY KEY (`orders_products_id`),
  KEY `idx_orders_products_orders_id` (`orders_id`),
  KEY `idx_orders_products_products_id` (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products_attributes`
--

DROP TABLE IF EXISTS `orders_products_attributes`;
CREATE TABLE IF NOT EXISTS `orders_products_attributes` (
  `orders_products_attributes_id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NOT NULL,
  `orders_products_id` int(11) NOT NULL,
  `products_options` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `products_options_values` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `options_values_price` decimal(15,4) NOT NULL,
  `price_prefix` char(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`orders_products_attributes_id`),
  KEY `idx_orders_products_att_orders_id` (`orders_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products_download`
--

DROP TABLE IF EXISTS `orders_products_download`;
CREATE TABLE IF NOT EXISTS `orders_products_download` (
  `orders_products_download_id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NOT NULL DEFAULT '0',
  `orders_products_id` int(11) NOT NULL DEFAULT '0',
  `orders_products_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `download_maxdays` int(2) NOT NULL DEFAULT '0',
  `download_count` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`orders_products_download_id`),
  KEY `idx_orders_products_download_orders_id` (`orders_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_status`
--

DROP TABLE IF EXISTS `orders_status`;
CREATE TABLE IF NOT EXISTS `orders_status` (
  `orders_status_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `orders_status_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `public_flag` int(11) DEFAULT '1',
  `downloads_flag` int(11) DEFAULT '0',
  PRIMARY KEY (`orders_status_id`,`language_id`),
  KEY `idx_orders_status_name` (`orders_status_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders_status`
--

INSERT INTO `orders_status` (`orders_status_id`, `language_id`, `orders_status_name`, `public_flag`, `downloads_flag`) VALUES
(1, 1, 'Pending', 1, 0),
(2, 1, 'Processing', 1, 1),
(3, 1, 'Delivered', 1, 1),
(4, 1, 'PayPal [Transactions]', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders_status_history`
--

DROP TABLE IF EXISTS `orders_status_history`;
CREATE TABLE IF NOT EXISTS `orders_status_history` (
  `orders_status_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NOT NULL,
  `orders_status_id` int(5) NOT NULL,
  `date_added` datetime NOT NULL,
  `customer_notified` int(1) DEFAULT '0',
  `comments` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`orders_status_history_id`),
  KEY `idx_orders_status_history_orders_id` (`orders_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_total`
--

DROP TABLE IF EXISTS `orders_total`;
CREATE TABLE IF NOT EXISTS `orders_total` (
  `orders_total_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(15,4) NOT NULL,
  `class` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`orders_total_id`),
  KEY `idx_orders_total_orders_id` (`orders_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `pages_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `page_type` char(1) DEFAULT NULL,
  PRIMARY KEY (`pages_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pages_id`, `sort_order`, `status`, `page_type`) VALUES
(1, 0, 1, '1'),
(2, 1, 1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `pages_description`
--

DROP TABLE IF EXISTS `pages_description`;
CREATE TABLE IF NOT EXISTS `pages_description` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pages_id` int(11) DEFAULT NULL,
  `pages_title` varchar(64) NOT NULL DEFAULT '',
  `pages_html_text` text,
  `intorext` char(1) DEFAULT NULL,
  `externallink` varchar(255) DEFAULT NULL,
  `link_target` char(1) DEFAULT NULL,
  `language_id` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `pages_description`
--

INSERT INTO `pages_description` (`id`, `pages_id`, `pages_title`, `pages_html_text`, `intorext`, `externallink`, `link_target`, `language_id`) VALUES
(1, 1, 'Index', 'Index page for English pages...This text can be changed from the admin section...', '0', '', '0', 1),
(2, 1, 'Index', 'Index page for Deutsch pages...This text can be changed from the admin section...', '0', '', '0', 2),
(3, 1, 'Index', 'Index page for Espanol pages...This text can be changed from the admin section...', '0', '', '0', 3),
(4, 2, 'Contact Us', 'Contact Page for English pages..This text can be changed from admin section.', '0', '', '0', 1),
(5, 2, 'Contact Us', 'Contact Page for Deutsch pages..This text can be changed from admin section.', '0', '', '0', 2),
(6, 2, 'Contact Us', 'Contact Page for Espanol pages..This text can be changed from admin section.', '0', '', '0', 3);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `products_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_quantity` int(4) NOT NULL,
  `products_model` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `products_image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `products_price` decimal(15,4) NOT NULL,
  `products_date_added` datetime NOT NULL,
  `products_last_modified` datetime DEFAULT NULL,
  `products_date_available` datetime DEFAULT NULL,
  `products_weight` decimal(5,2) NOT NULL,
  `products_status` tinyint(1) NOT NULL,
  `products_tax_class_id` int(11) NOT NULL,
  `manufacturers_id` int(11) DEFAULT NULL,
  `products_ordered` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`products_id`),
  KEY `idx_products_model` (`products_model`),
  KEY `idx_products_date_added` (`products_date_added`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`products_id`, `products_quantity`, `products_model`, `products_image`, `products_price`, `products_date_added`, `products_last_modified`, `products_date_available`, `products_weight`, `products_status`, `products_tax_class_id`, `manufacturers_id`, `products_ordered`) VALUES
(1, 32, 'MG200MMS', 'matrox/mg200mms.gif', '299.9900', '2014-01-29 16:35:21', '2014-05-13 14:54:22', NULL, '23.00', 1, 1, 1, 0),
(2, 32, 'MG400-32MB', 'matrox/mg400-32mb.gif', '499.9900', '2014-01-29 16:35:21', NULL, NULL, '23.00', 1, 1, 1, 0),
(3, -3, 'MSIMPRO', 'microsoft/msimpro.gif', '49.9900', '2014-01-29 16:35:21', '2014-04-24 16:57:52', NULL, '7.00', 1, 1, 2, 5),
(4, 13, 'DVD-RPMK', 'dvd/replacement_killers.gif', '42.0000', '2014-01-29 16:35:21', NULL, NULL, '23.00', 1, 1, 2, 0),
(5, 15, 'DVD-BLDRNDC', 'dvd/blade_runner.gif', '35.9900', '2014-01-29 16:35:21', '2014-05-27 14:15:48', NULL, '7.00', 1, 1, 3, 2),
(6, 9, 'DVD-MATR', 'dvd/the_matrix.gif', '39.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 1),
(7, 10, 'DVD-YGEM', 'dvd/youve_got_mail.gif', '34.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 0),
(8, 10, 'DVD-ABUG', 'dvd/a_bugs_life.gif', '35.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 0),
(9, 10, 'DVD-UNSG', 'dvd/under_siege.gif', '29.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 0),
(10, 10, 'DVD-UNSG2', 'dvd/under_siege2.gif', '29.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 0),
(11, 10, 'DVD-FDBL', 'dvd/fire_down_below.gif', '29.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 0),
(12, 10, 'DVD-DHWV', '/products/492555.jpg', '39.9900', '2014-01-29 16:35:21', '2014-05-14 14:18:06', NULL, '7.00', 1, 1, 4, 0),
(13, 10, 'DVD-LTWP', 'dvd/lethal_weapon.gif', '34.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 0),
(14, 10, 'DVD-REDC', 'dvd/red_corner.gif', '32.0000', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 0),
(15, 10, 'DVD-FRAN', 'dvd/frantic.gif', '35.0000', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 3, 0),
(16, 10, 'DVD-CUFI', 'dvd/courage_under_fire.gif', '38.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 4, 0),
(17, 10, 'DVD-SPEED', 'dvd/speed.jpg', '39.9900', '2014-01-29 16:35:21', '2014-05-27 13:53:06', NULL, '7.00', 1, 1, 4, 0),
(18, 10, 'DVD-SPEED2', 'dvd/speed_2.gif', '42.0000', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 4, 0),
(19, 10, 'DVD-TSAB', 'dvd/theres_something_about_mary.gif', '49.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 4, 0),
(20, 10, 'DVD-BELOVED', 'dvd/beloved.gif', '54.9900', '2014-01-29 16:35:21', '2014-05-13 16:26:52', NULL, '7.00', 1, 1, 3, 0),
(21, 16, 'PC-SWAT3', 'sierra/swat_3.gif', '79.9900', '2014-01-29 16:35:21', NULL, NULL, '7.00', 1, 1, 7, 0),
(22, 13, 'PC-UNTM', 'gt_interactive/unreal_tournament.gif', '89.9900', '2014-01-29 16:35:21', '2014-01-30 13:39:10', NULL, '7.00', 1, 1, 8, 0),
(23, 16, 'PC-TWOF', 'gt_interactive/wheel_of_time.gif', '99.9900', '2014-01-29 16:35:21', NULL, NULL, '10.00', 1, 1, 8, 0),
(24, 17, 'PC-DISC', 'gt_interactive/disciples.gif', '90.0000', '2014-01-29 16:35:21', NULL, NULL, '8.00', 1, 1, 8, 0),
(25, 16, 'MSINTKB', 'microsoft/intkeyboardps2.gif', '69.9900', '2014-01-29 16:35:21', NULL, NULL, '8.00', 1, 1, 2, 0),
(26, 10, 'MSIMEXP', 'microsoft/imexplorer.gif', '64.9500', '2014-01-29 16:35:21', '2014-05-02 14:46:43', NULL, '8.00', 1, 1, 2, 0),
(27, 8, 'HPLJ1100XI', 'hewlett_packard/lj1100xi.gif', '499.9900', '2014-01-29 16:35:21', NULL, NULL, '45.00', 1, 1, 9, 0),
(28, 100, 'GT-P1000', 'samsung/galaxy_tab.gif', '749.9900', '2014-01-29 16:35:21', NULL, NULL, '1.00', 1, 1, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_attributes`
--

DROP TABLE IF EXISTS `products_attributes`;
CREATE TABLE IF NOT EXISTS `products_attributes` (
  `products_attributes_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `options_id` int(11) NOT NULL,
  `options_values_id` int(11) NOT NULL,
  `options_values_price` decimal(15,4) NOT NULL,
  `price_prefix` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `attributes_hide_from_groups` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '@',
  PRIMARY KEY (`products_attributes_id`),
  KEY `idx_products_attributes_products_id` (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `products_attributes`
--

INSERT INTO `products_attributes` (`products_attributes_id`, `products_id`, `options_id`, `options_values_id`, `options_values_price`, `price_prefix`, `attributes_hide_from_groups`) VALUES
(1, 1, 4, 1, '0.0000', '+', '@'),
(2, 1, 4, 2, '50.0000', '+', '@'),
(3, 1, 4, 3, '70.0000', '+', '@'),
(4, 1, 3, 5, '0.0000', '+', '@'),
(5, 1, 3, 6, '100.0000', '+', '@'),
(6, 2, 4, 3, '10.0000', '-', '@'),
(7, 2, 4, 4, '0.0000', '+', '@'),
(8, 2, 3, 6, '0.0000', '+', '@'),
(9, 2, 3, 7, '120.0000', '+', '@'),
(10, 26, 3, 8, '0.0000', '+', '@'),
(11, 26, 3, 9, '6.0000', '+', '@'),
(26, 22, 5, 10, '0.0000', '+', '@'),
(27, 22, 5, 13, '0.0000', '+', '@');

-- --------------------------------------------------------

--
-- Table structure for table `products_attributes_download`
--

DROP TABLE IF EXISTS `products_attributes_download`;
CREATE TABLE IF NOT EXISTS `products_attributes_download` (
  `products_attributes_id` int(11) NOT NULL,
  `products_attributes_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `products_attributes_maxdays` int(2) DEFAULT '0',
  `products_attributes_maxcount` int(2) DEFAULT '0',
  PRIMARY KEY (`products_attributes_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_attributes_download`
--

INSERT INTO `products_attributes_download` (`products_attributes_id`, `products_attributes_filename`, `products_attributes_maxdays`, `products_attributes_maxcount`) VALUES
(26, 'unreal.zip', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `products_attributes_groups`
--

DROP TABLE IF EXISTS `products_attributes_groups`;
CREATE TABLE IF NOT EXISTS `products_attributes_groups` (
  `products_attributes_id` int(11) NOT NULL DEFAULT '0',
  `customers_group_id` smallint(5) NOT NULL DEFAULT '0',
  `options_values_price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `price_prefix` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `products_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customers_group_id`,`products_attributes_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_description`
--

DROP TABLE IF EXISTS `products_description`;
CREATE TABLE IF NOT EXISTS `products_description` (
  `products_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL DEFAULT '1',
  `products_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `products_description` text COLLATE utf8_unicode_ci,
  `products_specification` text COLLATE utf8_unicode_ci,
  `products_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `products_viewed` int(5) DEFAULT '0',
  PRIMARY KEY (`products_id`,`language_id`),
  KEY `products_name` (`products_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `products_description`
--

INSERT INTO `products_description` (`products_id`, `language_id`, `products_name`, `products_description`, `products_specification`, `products_url`, `products_viewed`) VALUES
(1, 1, 'Matrox G200 MMS', '<p>Reinforcing its position as a multi-monitor trailblazer, Matrox Graphics Inc. has once again developed the most flexible and highly advanced solution in the industry. Introducing the new Matrox G200 Multi-Monitor Series; the first graphics card ever to support up to four DVI digital flat panel displays on a single 8&quot; PCI board.<br />\r\n<br />\r\nWith continuing demand for digital flat panels in the financial workplace, the Matrox G200 MMS is the ultimate in flexible solutions. The Matrox G200 MMS also supports the new digital video interface (DVI) created by the Digital Display Working Group (DDWG) designed to ease the adoption of digital flat panels. Other configurations include composite video capture ability and onboard TV tuner, making the Matrox G200 MMS the complete solution for business needs.<br />\r\n<br />\r\nBased on the award-winning MGA-G200 graphics chip, the Matrox G200 Multi-Monitor Series provides superior 2D/3D graphics acceleration to meet the demanding needs of business applications such as real-time stock quotes (Versus), live video feeds (Reuters &amp; Bloombergs), multiple windows applications, word processing, spreadsheets and CAD.</p>', '<h2>GENERAL</h2>\r\n\r\n<ul>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Packaged Quantity</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">1</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Bus Type</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">PCI</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Graphics Engine</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">2 GPUs - Matrox MGA G200</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">RAMDAC</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">250 MHz MHz</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Max Resolution</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">1920 x 1200 at 70 Hz</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Max Monitors Supported</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">4</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Interfaces</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">2 x VGA - 15 pin HD D-Sub (HD-15)</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Manufacturer</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">HP</div>\r\n	</li>\r\n</ul>\r\n\r\n<h2>MEMORY</h2>\r\n\r\n<ul>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Size</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">32 MB</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Technology</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">SGRAM</div>\r\n	</li>\r\n</ul>\r\n\r\n<h2>VIDEO OUTPUT</h2>\r\n\r\n<ul>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Colors Max Resolution (external)</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">16-bit (64K colors)</div>\r\n	</li>\r\n</ul>\r\n\r\n<h2>MISCELLANEOUS</h2>\r\n\r\n<ul>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Software Included</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">Drivers &amp; Utilities</div>\r\n	</li>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Localization</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">Asia Pacific, Europe</div>\r\n	</li>\r\n</ul>\r\n\r\n<h2>GENERAL</h2>\r\n\r\n<ul>\r\n	<li>\r\n	<div class="col-3" style="box-sizing: border-box; float: left; margin-left: 0px; width: 270px; position: relative;">Manufacturer</div>\r\n\r\n	<div class="col-5" style="box-sizing: border-box; float: left; margin-left: 30px; width: 470px; position: relative; color: rgb(0, 0, 0);">HP</div>\r\n	</li>\r\n</ul>', 'www.matrox.com/mga/products/g200_mms/home.cfm', 45),
(2, 1, 'Matrox G400 32MB', '<strong>Dramatically Different High Performance Graphics</strong><br /><br />Introducing the Millennium G400 Series - a dramatically different, high performance graphics experience. Armed with the industry''s fastest graphics chip, the Millennium G400 Series takes explosive acceleration two steps further by adding unprecedented image quality, along with the most versatile display options for all your 3D, 2D and DVD applications. As the most powerful and innovative tools in your PC''s arsenal, the Millennium G400 Series will not only change the way you see graphics, but will revolutionize the way you use your computer.<br /><br /><strong>Key features:</strong><ul><li>New Matrox G400 256-bit DualBus graphics chip</li><li>Explosive 3D, 2D and DVD performance</li><li>DualHead Display</li><li>Superior DVD and TV output</li><li>3D Environment-Mapped Bump Mapping</li><li>Vibrant Color Quality rendering </li><li>UltraSharp DAC of up to 360 MHz</li><li>3D Rendering Array Processor</li><li>Support for 16 or 32 MB of memory</li></ul>', '', 'www.matrox.com/mga/products/mill_g400/home.htm', 1),
(3, 1, 'Microsoft IntelliMouse Pro', '<p>Every element of IntelliMouse Pro - from its unique arched shape to the texture of the rubber grip around its base - is the product of extensive customer and ergonomic research. Microsoft&#39;s popular wheel control, which now allows zooming and universal scrolling functions, gives IntelliMouse Pro outstanding comfort and efficiency.</p>', '', 'www.microsoft.com/hardware/mouse/intellimouse.asp', 22),
(4, 1, 'The Replacement Killers', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).<br />Languages: English, Deutsch.<br />Subtitles: English, Deutsch, Spanish.<br />Audio: Dolby Surround 5.1.<br />Picture Format: 16:9 Wide-Screen.<br />Length: (approx) 80 minutes.<br />Other: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', 'www.replacement-killers.com', 4),
(5, 1, 'Blade Runner - Director''s Cut', '<p>Regional Code: 2 (Japan, Europe, Middle East, South Africa).<br />\r\nLanguages: English, Deutsch.<br />\r\nSubtitles: English, Deutsch, Spanish.<br />\r\nAudio: Dolby Surround 5.1.<br />\r\nPicture Format: 16:9 Wide-Screen.<br />\r\nLength: (approx) 112 minutes.<br />\r\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).</p>', '', 'www.bladerunner.com', 53),
(6, 1, 'The Matrix', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch.\r<br />\nAudio: Dolby Surround.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 131 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Making Of.', '', 'www.thematrix.com', 13),
(7, 1, 'You''ve Got Mail', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch, Spanish.\r<br />\nSubtitles: English, Deutsch, Spanish, French, Nordic, Polish.\r<br />\nAudio: Dolby Digital 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 115 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', 'www.youvegotmail.com', 2),
(8, 1, 'A Bug''s Life', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Digital 5.1 / Dobly Surround Stereo.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 91 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', 'www.abugslife.com', 2),
(9, 1, 'Under Siege', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 98 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 1),
(10, 1, 'Under Siege 2 - Dark Territory', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 98 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 0),
(11, 1, 'Fire Down Below', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 100 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 1),
(12, 1, 'Die Hard With A Vengeance', '<p>Regional Code: 2 (Japan, Europe, Middle East, South Africa).<br />\r\nLanguages: English, Deutsch.<br />\r\nSubtitles: English, Deutsch, Spanish.<br />\r\nAudio: Dolby Surround 5.1.<br />\r\nPicture Format: 16:9 Wide-Screen.<br />\r\nLength: (approx) 122 minutes.<br />\r\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).</p>', '', '', 69),
(13, 1, 'Lethal Weapon', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 100 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 1),
(14, 1, 'Red Corner', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 117 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 0),
(15, 1, 'Frantic', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 115 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 0),
(16, 1, 'Courage Under Fire', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 112 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 28),
(17, 1, 'Speed', '<p>A group of people in a&nbsp;Los Angeles&nbsp;skyscraper enter an elevator and a bomb explodes, destroying the elevator cables and dropping the elevator several stories before the emergency brakes engage, trapping the people inside it. The&nbsp;SWAT&nbsp;team of the&nbsp;Los Angeles Police Department&nbsp;arrive at the scene where they learn a terrorist is holding the group hostage in the elevator and threatens to blow up the elevator&#39;s emergency brakes if he does not receive a ransom soon. Lieutenant &quot;Mac&quot; McMahon (Joe Morton) orders Officers Jack Traven (Keanu Reeves) and Harry Temple (Jeff Daniels) to investigate the bomb, who attach a hook from a crane to the top of the elevator car in case the bomb goes off. The bomber hears Jack and Harry and sets off the bomb before the ransom time, forcing Jack and Harry to help everyone escape the elevator. Jack and Harry encounter the bomber, (Dennis Hopper) hiding in a freight elevator, and the bomber takes Harry hostage. After Jack shoots Harry in the leg, the bomber lets Harry go, while the bomber flees the scene.</p>', '<p>Regional Code: 2 (Japan, Europe, Middle East, South Africa).<br />\r\nLanguages: English, Deutsch.<br />\r\nSubtitles: English, Deutsch, Spanish.<br />\r\nAudio: Dolby Surround 5.1.<br />\r\nPicture Format: 16:9 Wide-Screen.<br />\r\nLength: (approx) 112 minutes.<br />\r\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).</p>', '', 19),
(18, 1, 'Speed 2: Cruise Control', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 120 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 2),
(19, 1, 'There''s Something About Mary', 'Regional Code: 2 (Japan, Europe, Middle East, South Africa).\r<br />\nLanguages: English, Deutsch.\r<br />\nSubtitles: English, Deutsch, Spanish.\r<br />\nAudio: Dolby Surround 5.1.\r<br />\nPicture Format: 16:9 Wide-Screen.\r<br />\nLength: (approx) 114 minutes.\r<br />\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).', '', '', 10),
(20, 1, 'Beloved', '<p>Regional Code: 2 (Japan, Europe, Middle East, South Africa).<br />\r\nLanguages: English, Deutsch.<br />\r\nSubtitles: English, Deutsch, Spanish.<br />\r\nAudio: Dolby Surround 5.1.<br />\r\nPicture Format: 16:9 Wide-Screen.<br />\r\nLength: (approx) 164 minutes.<br />\r\nOther: Interactive Menus, Chapter Selection, Subtitles (more languages).</p>', '<p>specifications</p>', '', 118),
(21, 1, 'SWAT 3: Close Quarters Battle', '<strong>Windows 95/98</strong><br /><br />211 in progress with shots fired. Officer down. Armed suspects with hostages. Respond Code 3! Los Angles, 2005, In the next seven days, representatives from every nation around the world will converge on Las Angles to witness the signing of the United Nations Nuclear Abolishment Treaty. The protection of these dignitaries falls on the shoulders of one organization, LAPD SWAT. As part of this elite tactical organization, you and your team have the weapons and all the training necessary to protect, to serve, and "When needed" to use deadly force to keep the peace. It takes more than weapons to make it through each mission. Your arsenal includes C2 charges, flashbangs, tactical grenades. opti-Wand mini-video cameras, and other devices critical to meeting your objectives and keeping your men free of injury. Uncompromised Duty, Honor and Valor!', '', 'www.swat3.com', 1),
(22, 1, 'Unreal Tournament', '<p>From the creators of the best-selling Unreal, comes Unreal Tournament. A new kind of single player experience. A ruthless multiplayer revolution.<br />\r\n<br />\r\nThis stand-alone game showcases completely new team-based gameplay, groundbreaking multi-faceted single player action or dynamic multi-player mayhem. It&#39;s a fight to the finish for the title of Unreal Grand Master in the gladiatorial arena. A single player experience like no other! Guide your team of &#39;bots&#39; (virtual teamates) against the hardest criminals in the galaxy for the ultimate title - the Unreal Grand Master.</p>', '', 'www.unrealtournament.net', 5),
(23, 1, 'The Wheel Of Time', 'The world in which The Wheel of Time takes place is lifted directly out of Jordan''s pages; it''s huge and consists of many different environments. How you navigate the world will depend largely on which game - single player or multipayer - you''re playing. The single player experience, with a few exceptions, will see Elayna traversing the world mainly by foot (with a couple notable exceptions). In the multiplayer experience, your character will have more access to travel via Ter''angreal, Portal Stones, and the Ways. However you move around, though, you''ll quickly discover that means of locomotion can easily become the least of the your worries...<br /><br />During your travels, you quickly discover that four locations are crucial to your success in the game. Not surprisingly, these locations are the homes of The Wheel of Time''s main characters. Some of these places are ripped directly from the pages of Jordan''s books, made flesh with Legend''s unparalleled pixel-pushing ways. Other places are specific to the game, conceived and executed with the intent of expanding this game world even further. Either way, they provide a backdrop for some of the most intense first person action and strategy you''ll have this year.', '', 'www.wheeloftime.com', 2),
(24, 1, 'Disciples: Sacred Lands', 'A new age is dawning...<br /><br />Enter the realm of the Sacred Lands, where the dawn of a New Age has set in motion the most momentous of wars. As the prophecies long foretold, four races now clash with swords and sorcery in a desperate bid to control the destiny of their gods. Take on the quest as a champion of the Empire, the Mountain Clans, the Legions of the Damned, or the Undead Hordes and test your faith in battles of brute force, spellbinding magic and acts of guile. Slay demons, vanquish giants and combat merciless forces of the dead and undead. But to ensure the salvation of your god, the hero within must evolve.<br /><br />The day of reckoning has come... and only the chosen will survive.', '', '', 1),
(25, 1, 'Microsoft Internet Keyboard PS/2', 'The Internet Keyboard has 10 Hot Keys on a comfortable standard keyboard design that also includes a detachable palm rest. The Hot Keys allow you to browse the web, or check e-mail directly from your keyboard. The IntelliType Pro software also allows you to customize your hot keys - make the Internet Keyboard work the way you want it to!', '', '', 2),
(26, 1, 'Microsoft IntelliMouse Explorer', '<p>Microsoft introduces its most advanced mouse, the IntelliMouse Explorer! IntelliMouse Explorer features a sleek design, an industrial-silver finish, a glowing red underside and taillight, creating a style and look unlike any other mouse. IntelliMouse Explorer combines the accuracy and reliability of Microsoft IntelliEye optical tracking technology, the convenience of two new customizable function buttons, the efficiency of the scrolling wheel and the comfort of expert ergonomic design. All these great features make this the best mouse for the PC!</p>', '', 'www.microsoft.com/hardware/mouse/explorer.asp', 6),
(27, 1, 'Hewlett Packard LaserJet 1100Xi', 'HP has always set the pace in laser printing technology. The new generation HP LaserJet 1100 series sets another impressive pace, delivering a stunning 8 pages per minute print speed. The 600 dpi print resolution with HP''s Resolution Enhancement technology (REt) makes every document more professional.<br /><br />Enhanced print speed and laser quality results are just the beginning. With 2MB standard memory, HP LaserJet 1100xi users will be able to print increasingly complex pages. Memory can be increased to 18MB to tackle even more complex documents with ease. The HP LaserJet 1100xi supports key operating systems including Windows 3.1, 3.11, 95, 98, NT 4.0, OS/2 and DOS. Network compatibility available via the optional HP JetDirect External Print Servers.<br /><br />HP LaserJet 1100xi also features The Document Builder for the Web Era from Trellix Corp. (featuring software to create Web documents).', '', 'www.pandi.hp.com/pandi-db/prodinfo.main?product=laserjet1100', 3),
(28, 1, 'Samsung Galaxy Tab', '<p>Powered by a Cortex A8 1.0GHz application processor, the Samsung GALAXY Tab is designed to deliver high performance whenever and wherever you are. At the same time, HD video contents are supported by a wide range of multimedia formats (DivX, XviD, MPEG4, H.263, H.264 and more), which maximizes the joy of entertainment.</p><p>With 3G HSPA connectivity, 802.11n Wi-Fi, and Bluetooth 3.0, the Samsung GALAXY Tab enhances users'' mobile communication on a whole new level. Video conferencing and push email on the large 7-inch display make communication more smooth and efficient. For voice telephony, the Samsung GALAXY Tab turns out to be a perfect speakerphone on the desk, or a mobile phone on the move via Bluetooth headset.</p>', '', 'http://galaxytab.samsungmobile.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_extra_fields`
--

DROP TABLE IF EXISTS `products_extra_fields`;
CREATE TABLE IF NOT EXISTS `products_extra_fields` (
  `products_extra_fields_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_extra_fields_name` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `products_extra_fields_order` int(3) NOT NULL DEFAULT '0',
  `products_extra_fields_status` tinyint(1) NOT NULL DEFAULT '1',
  `languages_id` int(11) NOT NULL DEFAULT '0',
  `category_id` text COLLATE latin1_general_ci NOT NULL,
  `google_only` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`products_extra_fields_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `products_extra_fields`
--

INSERT INTO `products_extra_fields` (`products_extra_fields_id`, `products_extra_fields_name`, `products_extra_fields_order`, `products_extra_fields_status`, `languages_id`, `category_id`, `google_only`) VALUES
(1, 'Supplier Code', 99, 1, 0, 'all', '0'),
(2, 'Warranty', 0, 1, 0, 'all', '0');

-- --------------------------------------------------------

--
-- Table structure for table `products_groups`
--

DROP TABLE IF EXISTS `products_groups`;
CREATE TABLE IF NOT EXISTS `products_groups` (
  `customers_group_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `customers_group_price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `products_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customers_group_id`,`products_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

DROP TABLE IF EXISTS `products_images`;
CREATE TABLE IF NOT EXISTS `products_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `htmlcontent` text COLLATE utf8_unicode_ci,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products_images_prodid` (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `products_images`
--

INSERT INTO `products_images` (`id`, `products_id`, `image`, `htmlcontent`, `sort_order`) VALUES
(1, 28, 'samsung/galaxy_tab_1.jpg', NULL, 1),
(2, 28, 'samsung/galaxy_tab_2.jpg', NULL, 2),
(3, 28, 'samsung/galaxy_tab_3.jpg', NULL, 3),
(4, 28, 'samsung/galaxy_tab_4.jpg', '<object type="application/x-shockwave-flash" width="640" height="385" data="http://www.youtube.com/v/tAbsmHMAhrQ?fs=1&amp;autoplay=1"><param name="movie" value="http://www.youtube.com/v/tAbsmHMAhrQ?fs=1&amp;autoplay=1" /><param name="allowFullScreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="wmode" value="transparent" /></object>', 4),
(5, 5, '17111.jpg', '', 1),
(6, 5, 'office-365-promo.jpg', '', 2),
(7, 12, '520477.jpg', '', 1),
(8, 12, '520476.jpg', '', 2),
(9, 5, 'speed_11.jpg', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `products_notifications`
--

DROP TABLE IF EXISTS `products_notifications`;
CREATE TABLE IF NOT EXISTS `products_notifications` (
  `products_id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`products_id`,`customers_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_options`
--

DROP TABLE IF EXISTS `products_options`;
CREATE TABLE IF NOT EXISTS `products_options` (
  `products_options_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `products_options_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`products_options_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_options`
--

INSERT INTO `products_options` (`products_options_id`, `language_id`, `products_options_name`) VALUES
(1, 1, 'Color'),
(2, 1, 'Size'),
(3, 1, 'Model'),
(4, 1, 'Memory'),
(5, 1, 'Version');

-- --------------------------------------------------------

--
-- Table structure for table `products_options_values`
--

DROP TABLE IF EXISTS `products_options_values`;
CREATE TABLE IF NOT EXISTS `products_options_values` (
  `products_options_values_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `products_options_values_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`products_options_values_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_options_values`
--

INSERT INTO `products_options_values` (`products_options_values_id`, `language_id`, `products_options_values_name`) VALUES
(1, 1, '4 mb'),
(2, 1, '8 mb'),
(3, 1, '16 mb'),
(4, 1, '32 mb'),
(5, 1, 'Value'),
(6, 1, 'Premium'),
(7, 1, 'Deluxe'),
(8, 1, 'PS/2'),
(9, 1, 'USB'),
(10, 1, 'Download: Windows - English'),
(13, 1, 'Box: Windows - English');

-- --------------------------------------------------------

--
-- Table structure for table `products_options_values_to_products_options`
--

DROP TABLE IF EXISTS `products_options_values_to_products_options`;
CREATE TABLE IF NOT EXISTS `products_options_values_to_products_options` (
  `products_options_values_to_products_options_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_options_id` int(11) NOT NULL,
  `products_options_values_id` int(11) NOT NULL,
  PRIMARY KEY (`products_options_values_to_products_options_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `products_options_values_to_products_options`
--

INSERT INTO `products_options_values_to_products_options` (`products_options_values_to_products_options_id`, `products_options_id`, `products_options_values_id`) VALUES
(1, 4, 1),
(2, 4, 2),
(3, 4, 3),
(4, 4, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8),
(9, 3, 9),
(10, 5, 10),
(13, 5, 13);

-- --------------------------------------------------------

--
-- Table structure for table `products_to_categories`
--

DROP TABLE IF EXISTS `products_to_categories`;
CREATE TABLE IF NOT EXISTS `products_to_categories` (
  `products_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  PRIMARY KEY (`products_id`,`categories_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_to_categories`
--

INSERT INTO `products_to_categories` (`products_id`, `categories_id`) VALUES
(1, 4),
(2, 4),
(3, 9),
(4, 15),
(5, 11),
(6, 15),
(7, 12),
(8, 13),
(9, 15),
(10, 15),
(11, 15),
(12, 15),
(13, 10),
(14, 15),
(15, 14),
(16, 15),
(17, 10),
(18, 15),
(19, 12),
(20, 15),
(21, 18),
(22, 19),
(23, 20),
(24, 20),
(25, 8),
(26, 9),
(27, 5),
(28, 21);

-- --------------------------------------------------------

--
-- Table structure for table `products_to_products_extra_fields`
--

DROP TABLE IF EXISTS `products_to_products_extra_fields`;
CREATE TABLE IF NOT EXISTS `products_to_products_extra_fields` (
  `products_id` int(11) NOT NULL DEFAULT '0',
  `products_extra_fields_id` int(11) NOT NULL DEFAULT '0',
  `products_extra_fields_value` text,
  PRIMARY KEY (`products_id`,`products_extra_fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_to_products_extra_fields`
--

INSERT INTO `products_to_products_extra_fields` (`products_id`, `products_extra_fields_id`, `products_extra_fields_value`) VALUES
(1, 2, '3 Year NBD Warranty'),
(20, 2, '3 Year NBD Warranty'),
(20, 1, 'BELOVED2345'),
(17, 2, '1 Year Return to Base');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `reviews_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `customers_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reviews_rating` int(1) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `reviews_status` tinyint(1) NOT NULL DEFAULT '0',
  `reviews_read` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reviews_id`),
  KEY `idx_reviews_products_id` (`products_id`),
  KEY `idx_reviews_customers_id` (`customers_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviews_id`, `products_id`, `customers_id`, `customers_name`, `reviews_rating`, `date_added`, `last_modified`, `reviews_status`, `reviews_read`) VALUES
(1, 19, 0, 'John Doe', 5, '2014-01-29 16:35:21', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews_description`
--

DROP TABLE IF EXISTS `reviews_description`;
CREATE TABLE IF NOT EXISTS `reviews_description` (
  `reviews_id` int(11) NOT NULL,
  `languages_id` int(11) NOT NULL,
  `reviews_text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`reviews_id`,`languages_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reviews_description`
--

INSERT INTO `reviews_description` (`reviews_id`, `languages_id`, `reviews_text`) VALUES
(1, 1, 'This has to be one of the funniest movies released for 1999!');

-- --------------------------------------------------------

--
-- Table structure for table `searched_keywords`
--

DROP TABLE IF EXISTS `searched_keywords`;
CREATE TABLE IF NOT EXISTS `searched_keywords` (
  `searched_keywords_id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(128) NOT NULL,
  `number_of_results` int(3) NOT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `ip` varchar(15) NOT NULL,
  `pages` varchar(64) NOT NULL DEFAULT '1',
  `products_ids` varchar(128) DEFAULT NULL,
  `orders_id` int(11) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`searched_keywords_id`),
  KEY `keywords` (`keywords`),
  KEY `customers_id` (`customers_id`),
  KEY `ip` (`ip`),
  KEY `date_added` (`date_added`),
  KEY `number_of_results` (`number_of_results`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `searched_keywords`
--

INSERT INTO `searched_keywords` (`searched_keywords_id`, `keywords`, `number_of_results`, `customers_id`, `ip`, `pages`, `products_ids`, `orders_id`, `date_added`) VALUES
(1, 'mouse', 2, NULL, '127.0.0.1', '1', NULL, NULL, '2014-04-16 13:54:16'),
(2, 'speed', 3, NULL, '127.0.0.1', '1', NULL, NULL, '2014-04-16 13:55:17'),
(3, 'dvd/speed_2.gifSpeed 2: Cruise Control', 0, NULL, '127.0.0.1', '1', NULL, NULL, '2014-04-16 14:19:14'),
(4, 'Speed 2: Cruise Control', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-04-16 14:32:20'),
(5, 'Microsoft IntelliMouse Pro', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-04-16 14:34:34'),
(6, 'Beloved', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-04-30 12:23:47'),
(7, 'There\\''s Something About Mary', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-02 16:50:46'),
(8, 'mary', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-02 16:50:59'),
(9, 'You\\''ve Got Mail', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-08 11:32:33'),
(10, 'comedy', 0, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-08 11:45:30'),
(11, 'game', 2, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-08 11:45:38'),
(12, 'the', 28, NULL, '127.0.0.1', '1,2,1', NULL, NULL, '2014-05-08 11:45:47'),
(13, 'microsoft mouse', 2, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-12 16:10:16'),
(14, 'Matrox G200 MMS', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-13 14:47:42'),
(15, 'Beloved', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-13 16:27:07'),
(16, 'beloved', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-13 17:28:25'),
(17, 'mouse', 2, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-13 17:28:41'),
(18, 'Speed 2: Cruise Control', 1, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-27 13:31:00'),
(19, 'Speed', 3, NULL, '127.0.0.1', '1', NULL, NULL, '2014-05-27 13:31:13');

-- --------------------------------------------------------

--
-- Table structure for table `sec_directory_whitelist`
--

DROP TABLE IF EXISTS `sec_directory_whitelist`;
CREATE TABLE IF NOT EXISTS `sec_directory_whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `sec_directory_whitelist`
--

INSERT INTO `sec_directory_whitelist` (`id`, `directory`) VALUES
(1, 'admin/backups'),
(2, 'admin/images/graphs'),
(3, 'images'),
(4, 'images/banners'),
(5, 'images/dvd'),
(6, 'images/gt_interactive'),
(7, 'images/hewlett_packard'),
(8, 'images/matrox'),
(9, 'images/microsoft'),
(10, 'images/samsung'),
(11, 'images/sierra'),
(12, 'includes/work'),
(13, 'pub');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `sesskey` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `expiry` int(11) unsigned NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`sesskey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`sesskey`, `expiry`, `value`) VALUES
('ver9cqik3gqgd6qvludmkh0pb3', 1399009999, 'sessiontoken|s:32:"b3f057dc1df4f2fafb83b08473d5a53b";display_prices_with_tax|s:4:"true";cart|O:12:"shoppingCart":5:{s:8:"contents";a:0:{}s:5:"total";i:0;s:6:"weight";i:0;s:6:"cartID";s:5:"09912";s:12:"content_type";b:0;}language|s:7:"english";languages_id|s:1:"1";currency|s:3:"NZD";navigation|O:17:"navigationHistory":2:{s:4:"path";a:1:{i:0;a:4:{s:4:"page";s:9:"index.php";s:4:"mode";s:6:"NONSSL";s:3:"get";a:0:{}s:4:"post";a:0:{}}}s:8:"snapshot";a:0:{}}new_products_id_in_cart|i:20;searched_keywords_id|i:8;'),
('k93uqi87sa8phtkq4vn9blmqn2', 1399007855, 'language|s:7:"english";languages_id|s:1:"1";admin|a:2:{s:2:"id";s:1:"1";s:8:"username";s:5:"admin";}'),
('oidjpr7abpr9e8k8ppdhpfego3', 1400042652, 'language|s:7:"english";languages_id|s:1:"1";admin|a:2:{s:2:"id";s:1:"1";s:8:"username";s:5:"admin";}'),
('b0v4erv581fi9ugi3nsnl54mg6', 1400044187, 'sessiontoken|s:32:"9527e33a5edeef75cb194d0f7f3ceb21";display_prices_with_tax|s:5:"false";cart|O:12:"shoppingCart":5:{s:8:"contents";a:0:{}s:5:"total";i:0;s:6:"weight";i:0;s:6:"cartID";N;s:12:"content_type";b:0;}language|s:7:"english";languages_id|s:1:"1";currency|s:3:"NZD";navigation|O:17:"navigationHistory":2:{s:4:"path";a:1:{i:0;a:4:{s:4:"page";s:16:"product_info.php";s:4:"mode";s:6:"NONSSL";s:3:"get";a:1:{s:11:"products_id";s:2:"12";}s:4:"post";a:0:{}}}s:8:"snapshot";a:0:{}}'),
('dq1anpos7sk2n52ikvnu12nkd4', 1401922372, 'language|s:7:"english";languages_id|s:1:"1";admin|a:2:{s:2:"id";s:1:"1";s:8:"username";s:5:"admin";}'),
('0ki7rjbvv6b31gf9t7m4bh04t5', 1401922336, 'sessiontoken|s:32:"89e1a3cef9bb66f3318f1275066b2216";display_prices_with_tax|s:5:"false";cart|O:12:"shoppingCart":5:{s:8:"contents";a:0:{}s:5:"total";i:0;s:6:"weight";i:0;s:6:"cartID";N;s:12:"content_type";b:0;}language|s:7:"english";languages_id|s:1:"1";currency|s:3:"NZD";navigation|O:17:"navigationHistory":2:{s:4:"path";a:1:{i:0;a:4:{s:4:"page";s:9:"index.php";s:4:"mode";s:6:"NONSSL";s:3:"get";a:0:{}s:4:"post";a:0:{}}}s:8:"snapshot";a:0:{}}');

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

DROP TABLE IF EXISTS `slideshow`;
CREATE TABLE IF NOT EXISTS `slideshow` (
  `slideshow_id` int(11) NOT NULL AUTO_INCREMENT,
  `slideshow_name` varchar(255) NOT NULL DEFAULT '',
  `slideshow_description` text NOT NULL,
  `slideshow_image` varchar(255) DEFAULT NULL,
  `slideshow_url` tinytext NOT NULL,
  `slideshow_addtocart` varchar(32) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`slideshow_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`slideshow_id`, `slideshow_name`, `slideshow_description`, `slideshow_image`, `slideshow_url`, `slideshow_addtocart`, `date_added`, `last_modified`) VALUES
(1, 'Dell UltraSharp U2412M 24" IPS Monitor', '<p>$399 inc GST</p>', 'slideshow/389636.jpg', '', '12', '2014-02-14 16:16:01', NULL),
(2, 'Speed (Movie)', '<p>$39.99 Inc GST</p>', 'slideshow/17.jpg', '', '17', '2014-02-14 16:18:04', '2014-02-14 17:22:45'),
(3, 'Office 365 Promo', '<p>$25 Prezzy Card</p>', 'slideshow/office-365-promo.jpg', 'payment-methods-i-7.html', '', '2014-02-14 16:19:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `specials`
--

DROP TABLE IF EXISTS `specials`;
CREATE TABLE IF NOT EXISTS `specials` (
  `specials_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `specials_new_products_price` decimal(15,4) NOT NULL,
  `specials_date_added` datetime DEFAULT NULL,
  `specials_last_modified` datetime DEFAULT NULL,
  `expires_date` datetime DEFAULT NULL,
  `date_status_change` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `customers_group_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`specials_id`),
  KEY `idx_specials_products_id` (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `specials`
--

INSERT INTO `specials` (`specials_id`, `products_id`, `specials_new_products_price`, `specials_date_added`, `specials_last_modified`, `expires_date`, `date_status_change`, `status`, `customers_group_id`) VALUES
(1, 3, '39.9900', '2014-01-29 16:35:21', NULL, NULL, NULL, 1, 0),
(2, 5, '30.0000', '2014-01-29 16:35:21', NULL, NULL, NULL, 1, 0),
(3, 6, '30.0000', '2014-01-29 16:35:21', NULL, NULL, NULL, 1, 0),
(4, 16, '29.9900', '2014-01-29 16:35:21', NULL, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `specials_retail_prices`
--

DROP TABLE IF EXISTS `specials_retail_prices`;
CREATE TABLE IF NOT EXISTS `specials_retail_prices` (
  `products_id` int(11) NOT NULL DEFAULT '0',
  `specials_new_products_price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `status` tinyint(4) DEFAULT NULL,
  `customers_group_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`products_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specials_retail_prices`
--

INSERT INTO `specials_retail_prices` (`products_id`, `specials_new_products_price`, `status`, `customers_group_id`) VALUES
(3, '39.9900', 1, 0),
(5, '30.0000', 1, 0),
(6, '30.0000', 1, 0),
(16, '29.9900', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tax_class`
--

DROP TABLE IF EXISTS `tax_class`;
CREATE TABLE IF NOT EXISTS `tax_class` (
  `tax_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_class_title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `tax_class_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`tax_class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tax_class`
--

INSERT INTO `tax_class` (`tax_class_id`, `tax_class_title`, `tax_class_description`, `last_modified`, `date_added`) VALUES
(1, 'GST', 'Goods and Services Tax', '2014-01-30 11:22:06', '2014-01-29 16:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

DROP TABLE IF EXISTS `tax_rates`;
CREATE TABLE IF NOT EXISTS `tax_rates` (
  `tax_rates_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_zone_id` int(11) NOT NULL,
  `tax_class_id` int(11) NOT NULL,
  `tax_priority` int(5) DEFAULT '1',
  `tax_rate` decimal(7,4) NOT NULL,
  `tax_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`tax_rates_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`tax_rates_id`, `tax_zone_id`, `tax_class_id`, `tax_priority`, `tax_rate`, `tax_description`, `last_modified`, `date_added`) VALUES
(1, 2, 1, 1, '15.0000', 'GST 15.0%', '2014-01-30 11:23:14', '2014-01-29 16:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `usu_cache`
--

DROP TABLE IF EXISTS `usu_cache`;
CREATE TABLE IF NOT EXISTS `usu_cache` (
  `cache_name` varchar(64) NOT NULL,
  `cache_data` mediumtext NOT NULL,
  `cache_date` datetime NOT NULL,
  UNIQUE KEY `cache_name` (`cache_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `whos_online`
--

DROP TABLE IF EXISTS `whos_online`;
CREATE TABLE IF NOT EXISTS `whos_online` (
  `customer_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `time_entry` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `time_last_click` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `last_page_url` text COLLATE utf8_unicode_ci NOT NULL,
  KEY `idx_whos_online_session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `whos_online`
--

INSERT INTO `whos_online` (`customer_id`, `full_name`, `session_id`, `ip_address`, `time_entry`, `time_last_click`, `last_page_url`) VALUES
(0, 'Guest', '0ki7rjbvv6b31gf9t7m4bh04t5', '127.0.0.1', '1401920716', '1401920896', '/projects/advdirect/index.php');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
CREATE TABLE IF NOT EXISTS `zones` (
  `zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_country_id` int(11) NOT NULL,
  `zone_code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `zone_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`zone_id`),
  KEY `idx_zones_country_id` (`zone_country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=182 ;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`zone_id`, `zone_country_id`, `zone_code`, `zone_name`) VALUES
(1, 223, 'AL', 'Alabama'),
(2, 223, 'AK', 'Alaska'),
(3, 223, 'AS', 'American Samoa'),
(4, 223, 'AZ', 'Arizona'),
(5, 223, 'AR', 'Arkansas'),
(6, 223, 'AF', 'Armed Forces Africa'),
(7, 223, 'AA', 'Armed Forces Americas'),
(8, 223, 'AC', 'Armed Forces Canada'),
(9, 223, 'AE', 'Armed Forces Europe'),
(10, 223, 'AM', 'Armed Forces Middle East'),
(11, 223, 'AP', 'Armed Forces Pacific'),
(12, 223, 'CA', 'California'),
(13, 223, 'CO', 'Colorado'),
(14, 223, 'CT', 'Connecticut'),
(15, 223, 'DE', 'Delaware'),
(16, 223, 'DC', 'District of Columbia'),
(17, 223, 'FM', 'Federated States Of Micronesia'),
(18, 223, 'FL', 'Florida'),
(19, 223, 'GA', 'Georgia'),
(20, 223, 'GU', 'Guam'),
(21, 223, 'HI', 'Hawaii'),
(22, 223, 'ID', 'Idaho'),
(23, 223, 'IL', 'Illinois'),
(24, 223, 'IN', 'Indiana'),
(25, 223, 'IA', 'Iowa'),
(26, 223, 'KS', 'Kansas'),
(27, 223, 'KY', 'Kentucky'),
(28, 223, 'LA', 'Louisiana'),
(29, 223, 'ME', 'Maine'),
(30, 223, 'MH', 'Marshall Islands'),
(31, 223, 'MD', 'Maryland'),
(32, 223, 'MA', 'Massachusetts'),
(33, 223, 'MI', 'Michigan'),
(34, 223, 'MN', 'Minnesota'),
(35, 223, 'MS', 'Mississippi'),
(36, 223, 'MO', 'Missouri'),
(37, 223, 'MT', 'Montana'),
(38, 223, 'NE', 'Nebraska'),
(39, 223, 'NV', 'Nevada'),
(40, 223, 'NH', 'New Hampshire'),
(41, 223, 'NJ', 'New Jersey'),
(42, 223, 'NM', 'New Mexico'),
(43, 223, 'NY', 'New York'),
(44, 223, 'NC', 'North Carolina'),
(45, 223, 'ND', 'North Dakota'),
(46, 223, 'MP', 'Northern Mariana Islands'),
(47, 223, 'OH', 'Ohio'),
(48, 223, 'OK', 'Oklahoma'),
(49, 223, 'OR', 'Oregon'),
(50, 223, 'PW', 'Palau'),
(51, 223, 'PA', 'Pennsylvania'),
(52, 223, 'PR', 'Puerto Rico'),
(53, 223, 'RI', 'Rhode Island'),
(54, 223, 'SC', 'South Carolina'),
(55, 223, 'SD', 'South Dakota'),
(56, 223, 'TN', 'Tennessee'),
(57, 223, 'TX', 'Texas'),
(58, 223, 'UT', 'Utah'),
(59, 223, 'VT', 'Vermont'),
(60, 223, 'VI', 'Virgin Islands'),
(61, 223, 'VA', 'Virginia'),
(62, 223, 'WA', 'Washington'),
(63, 223, 'WV', 'West Virginia'),
(64, 223, 'WI', 'Wisconsin'),
(65, 223, 'WY', 'Wyoming'),
(66, 38, 'AB', 'Alberta'),
(67, 38, 'BC', 'British Columbia'),
(68, 38, 'MB', 'Manitoba'),
(69, 38, 'NF', 'Newfoundland'),
(70, 38, 'NB', 'New Brunswick'),
(71, 38, 'NS', 'Nova Scotia'),
(72, 38, 'NT', 'Northwest Territories'),
(73, 38, 'NU', 'Nunavut'),
(74, 38, 'ON', 'Ontario'),
(75, 38, 'PE', 'Prince Edward Island'),
(76, 38, 'QC', 'Quebec'),
(77, 38, 'SK', 'Saskatchewan'),
(78, 38, 'YT', 'Yukon Territory'),
(79, 81, 'NDS', 'Niedersachsen'),
(80, 81, 'BAW', 'Baden-Württemberg'),
(81, 81, 'BAY', 'Bayern'),
(82, 81, 'BER', 'Berlin'),
(83, 81, 'BRG', 'Brandenburg'),
(84, 81, 'BRE', 'Bremen'),
(85, 81, 'HAM', 'Hamburg'),
(86, 81, 'HES', 'Hessen'),
(87, 81, 'MEC', 'Mecklenburg-Vorpommern'),
(88, 81, 'NRW', 'Nordrhein-Westfalen'),
(89, 81, 'RHE', 'Rheinland-Pfalz'),
(90, 81, 'SAR', 'Saarland'),
(91, 81, 'SAS', 'Sachsen'),
(92, 81, 'SAC', 'Sachsen-Anhalt'),
(93, 81, 'SCN', 'Schleswig-Holstein'),
(94, 81, 'THE', 'Thüringen'),
(95, 14, 'WI', 'Wien'),
(96, 14, 'NO', 'Niederösterreich'),
(97, 14, 'OO', 'Oberösterreich'),
(98, 14, 'SB', 'Salzburg'),
(99, 14, 'KN', 'Kärnten'),
(100, 14, 'ST', 'Steiermark'),
(101, 14, 'TI', 'Tirol'),
(102, 14, 'BL', 'Burgenland'),
(103, 14, 'VB', 'Voralberg'),
(104, 204, 'AG', 'Aargau'),
(105, 204, 'AI', 'Appenzell Innerrhoden'),
(106, 204, 'AR', 'Appenzell Ausserrhoden'),
(107, 204, 'BE', 'Bern'),
(108, 204, 'BL', 'Basel-Landschaft'),
(109, 204, 'BS', 'Basel-Stadt'),
(110, 204, 'FR', 'Freiburg'),
(111, 204, 'GE', 'Genf'),
(112, 204, 'GL', 'Glarus'),
(113, 204, 'JU', 'Graubünden'),
(114, 204, 'JU', 'Jura'),
(115, 204, 'LU', 'Luzern'),
(116, 204, 'NE', 'Neuenburg'),
(117, 204, 'NW', 'Nidwalden'),
(118, 204, 'OW', 'Obwalden'),
(119, 204, 'SG', 'St. Gallen'),
(120, 204, 'SH', 'Schaffhausen'),
(121, 204, 'SO', 'Solothurn'),
(122, 204, 'SZ', 'Schwyz'),
(123, 204, 'TG', 'Thurgau'),
(124, 204, 'TI', 'Tessin'),
(125, 204, 'UR', 'Uri'),
(126, 204, 'VD', 'Waadt'),
(127, 204, 'VS', 'Wallis'),
(128, 204, 'ZG', 'Zug'),
(129, 204, 'ZH', 'Zürich'),
(130, 195, 'A Coruña', 'A Coruña'),
(131, 195, 'Alava', 'Alava'),
(132, 195, 'Albacete', 'Albacete'),
(133, 195, 'Alicante', 'Alicante'),
(134, 195, 'Almeria', 'Almeria'),
(135, 195, 'Asturias', 'Asturias'),
(136, 195, 'Avila', 'Avila'),
(137, 195, 'Badajoz', 'Badajoz'),
(138, 195, 'Baleares', 'Baleares'),
(139, 195, 'Barcelona', 'Barcelona'),
(140, 195, 'Burgos', 'Burgos'),
(141, 195, 'Caceres', 'Caceres'),
(142, 195, 'Cadiz', 'Cadiz'),
(143, 195, 'Cantabria', 'Cantabria'),
(144, 195, 'Castellon', 'Castellon'),
(145, 195, 'Ceuta', 'Ceuta'),
(146, 195, 'Ciudad Real', 'Ciudad Real'),
(147, 195, 'Cordoba', 'Cordoba'),
(148, 195, 'Cuenca', 'Cuenca'),
(149, 195, 'Girona', 'Girona'),
(150, 195, 'Granada', 'Granada'),
(151, 195, 'Guadalajara', 'Guadalajara'),
(152, 195, 'Guipuzcoa', 'Guipuzcoa'),
(153, 195, 'Huelva', 'Huelva'),
(154, 195, 'Huesca', 'Huesca'),
(155, 195, 'Jaen', 'Jaen'),
(156, 195, 'La Rioja', 'La Rioja'),
(157, 195, 'Las Palmas', 'Las Palmas'),
(158, 195, 'Leon', 'Leon'),
(159, 195, 'Lleida', 'Lleida'),
(160, 195, 'Lugo', 'Lugo'),
(161, 195, 'Madrid', 'Madrid'),
(162, 195, 'Malaga', 'Malaga'),
(163, 195, 'Melilla', 'Melilla'),
(164, 195, 'Murcia', 'Murcia'),
(165, 195, 'Navarra', 'Navarra'),
(166, 195, 'Ourense', 'Ourense'),
(167, 195, 'Palencia', 'Palencia'),
(168, 195, 'Pontevedra', 'Pontevedra'),
(169, 195, 'Salamanca', 'Salamanca'),
(170, 195, 'Santa Cruz de Tenerife', 'Santa Cruz de Tenerife'),
(171, 195, 'Segovia', 'Segovia'),
(172, 195, 'Sevilla', 'Sevilla'),
(173, 195, 'Soria', 'Soria'),
(174, 195, 'Tarragona', 'Tarragona'),
(175, 195, 'Teruel', 'Teruel'),
(176, 195, 'Toledo', 'Toledo'),
(177, 195, 'Valencia', 'Valencia'),
(178, 195, 'Valladolid', 'Valladolid'),
(179, 195, 'Vizcaya', 'Vizcaya'),
(180, 195, 'Zamora', 'Zamora'),
(181, 195, 'Zaragoza', 'Zaragoza');

-- --------------------------------------------------------

--
-- Table structure for table `zones_to_geo_zones`
--

DROP TABLE IF EXISTS `zones_to_geo_zones`;
CREATE TABLE IF NOT EXISTS `zones_to_geo_zones` (
  `association_id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_country_id` int(11) NOT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `geo_zone_id` int(11) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`association_id`),
  KEY `idx_zones_to_geo_zones_country_id` (`zone_country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `zones_to_geo_zones`
--

INSERT INTO `zones_to_geo_zones` (`association_id`, `zone_country_id`, `zone_id`, `geo_zone_id`, `last_modified`, `date_added`) VALUES
(2, 153, 0, 2, NULL, '2014-01-30 11:22:58');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
