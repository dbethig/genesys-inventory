-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 23, 2020 at 11:38 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `genesys`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `char__id` int(11) NOT NULL,
  `char__user_id` int(11) NOT NULL,
  `char__name` varchar(255) NOT NULL,
  `char__characteristic_brawn` int(1) NOT NULL,
  `char__characteristic_agility` int(1) NOT NULL,
  `char__characteristic_intellect` int(1) NOT NULL,
  `char__characteristic_cunning` int(1) NOT NULL,
  `char__characteristic_willpower` int(1) NOT NULL,
  `char__characteristic_presence` int(1) NOT NULL,
  `char__soak` int(3) NOT NULL,
  `char__enc_total` int(5) NOT NULL,
  `char__enc_curr` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `containers`
--

CREATE TABLE `containers` (
  `cont__id` int(11) NOT NULL,
  `cont__inv_id` int(11) NOT NULL,
  `cont__name` varchar(255) NOT NULL,
  `cont__desc` varchar(255) DEFAULT NULL,
  `cont__capacity` int(5) DEFAULT NULL,
  `cont__enc` tinyint(1) DEFAULT NULL,
  `cont__worn` tinyint(1) NOT NULL DEFAULT '0',
  `cont__order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `inv__id` int(11) NOT NULL,
  `inv__char_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_items`
--

CREATE TABLE `inv_items` (
  `item__id` int(11) NOT NULL,
  `item__container_id` int(11) NOT NULL,
  `item__name` varchar(255) NOT NULL,
  `item__type_id` int(11) NOT NULL,
  `item__desc` varchar(255) DEFAULT NULL,
  `item__enc` int(5) NOT NULL DEFAULT '0',
  `item__enc_total` float NOT NULL DEFAULT '0.2',
  `item__enc_total_cust` tinyint(4) DEFAULT NULL,
  `item__qty` int(11) NOT NULL DEFAULT '1',
  `item__cost` int(11) DEFAULT NULL,
  `item__cost_total` int(11) DEFAULT NULL,
  `item__cost_total_cust` tinyint(4) DEFAULT NULL,
  `item__condition` varchar(255) DEFAULT NULL,
  `item__notes` varchar(255) DEFAULT NULL,
  `item__damage` tinyint(10) DEFAULT NULL,
  `item__damage_add` tinyint(10) DEFAULT NULL,
  `item__damage_ability` tinyint(10) DEFAULT NULL,
  `item__crit` int(2) DEFAULT NULL,
  `item__range` varchar(255) DEFAULT NULL,
  `item__defence` int(2) DEFAULT NULL,
  `item__soak` int(2) DEFAULT NULL,
  `item__hp_total` int(2) DEFAULT NULL,
  `item__hp_current` tinyint(10) DEFAULT NULL,
  `item__rarity` int(2) DEFAULT NULL,
  `item__skill` varchar(255) DEFAULT NULL,
  `item__special` varchar(255) DEFAULT NULL,
  `item__craftsmanship` varchar(255) DEFAULT NULL,
  `item__material` varchar(255) DEFAULT NULL,
  `item__carried` tinyint(4) DEFAULT NULL,
  `item__inc` tinyint(4) DEFAULT NULL,
  `item__packed` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_attr`
--

CREATE TABLE `item_attr` (
  `attr__id` int(11) NOT NULL,
  `attr__name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE `item_types` (
  `type__id` int(11) NOT NULL,
  `type__name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `type_details`
--

CREATE TABLE `type_details` (
  `tdetails__id` int(11) NOT NULL,
  `tdetails__type_id` int(11) NOT NULL,
  `tdetails__attr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user__id` int(11) NOT NULL,
  `user__uid` varchar(50) NOT NULL,
  `user__pwd` longtext NOT NULL,
  `user__fname` varchar(50) NOT NULL,
  `user__sname` varchar(50) NOT NULL,
  `user__email` varchar(255) NOT NULL,
  `user__last_signed_in` timestamp NULL DEFAULT NULL,
  `user__created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user__last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`char__id`),
  ADD KEY `char__user_id` (`char__user_id`);

--
-- Indexes for table `containers`
--
ALTER TABLE `containers`
  ADD PRIMARY KEY (`cont__id`),
  ADD KEY `containers__inv_id` (`cont__inv_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`inv__id`),
  ADD KEY `inv__char_id` (`inv__char_id`);

--
-- Indexes for table `inv_items`
--
ALTER TABLE `inv_items`
  ADD PRIMARY KEY (`item__id`),
  ADD KEY `items__container_id` (`item__container_id`);

--
-- Indexes for table `item_attr`
--
ALTER TABLE `item_attr`
  ADD PRIMARY KEY (`attr__id`);

--
-- Indexes for table `item_types`
--
ALTER TABLE `item_types`
  ADD PRIMARY KEY (`type__id`);

--
-- Indexes for table `type_details`
--
ALTER TABLE `type_details`
  ADD PRIMARY KEY (`tdetails__id`),
  ADD KEY `tdetails__type_id` (`tdetails__type_id`),
  ADD KEY `tdetails__attr_id` (`tdetails__attr_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user__id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `char__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `containers`
--
ALTER TABLE `containers`
  MODIFY `cont__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `inv__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_items`
--
ALTER TABLE `inv_items`
  MODIFY `item__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_attr`
--
ALTER TABLE `item_attr`
  MODIFY `attr__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `type__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_details`
--
ALTER TABLE `type_details`
  MODIFY `tdetails__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user__id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
