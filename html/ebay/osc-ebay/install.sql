-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 17, 2011 at 11:50 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `oscmax'
--

-- --------------------------------------------------------

--
-- Table structure for table `ebay`
--

CREATE TABLE IF NOT EXISTS `ebay_shipping` (
  `ID` int(11) NOT NULL,
  `shiptype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vendor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vendorname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ebay`
--

INSERT INTO `ebay_shipping` (`ID`, `shiptype`, `vendor`, `description`, `vendorname`) VALUES
(1, 'customcode', '', 'Ebay Placeholder value', '');

-- --------------------------------------------------------

--
-- Table structure for table `ebay_description`
--

CREATE TABLE IF NOT EXISTS `ebay_description` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `text2parse` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ebay_description`
--

INSERT INTO `ebay_description` (`ID`, `text2parse`) VALUES
(1, 'The free listing tool. List your items fast and easy and manage your active items.');

-- --------------------------------------------------------

--
-- Table structure for table `ebay_settings`
--

CREATE TABLE IF NOT EXISTS `ebay_settings` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `last_update` date NOT NULL,
  `last_sync` date NOT NULL,
  `last_kron` date NOT NULL,
  `products_inserted` int(11) NOT NULL,
  `products_syncd` int(11) NOT NULL,
  `sync_mode` enum('EBAY_AUTHORITY','SMART_SYNC','OSC_AUTHORITY') NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ebay_settings`
--

INSERT INTO `ebay_settings` (`ID`, `last_update`, `last_sync`, `last_kron`, `products_inserted`, `products_syncd`, `sync_mode`) VALUES
(1, '2011-10-22', '2011-10-22', '2011-10-22', 0, 0, 'EBAY_AUTHORITY');

INSERT INTO `admin_files` (`admin_files_id`, `admin_files_name`, `admin_files_is_boxes`, `admin_files_to_boxes`, `admin_groups_id`) VALUES(null, 'ebay.php', 0, 131, 1),

INSERT INTO `configuration_group` (`configuration_group_id`, `configuration_group_title`, `configuration_group_description`, `sort_order`, `visible`) VALUES(90, 'eBay', 'Ebay specific configuration', 315, 1),

-- --------------------------------------------------------

--
-- New fields in database 
--
ALTER TABLE `products` ADD `last_ebay_quantity` INT NOT NULL;
ALTER TABLE `products` ADD `Ebay_id` INT NOT NULL ; 


