-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2016 at 11:07 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crudproducts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `admin_pass`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `tree_path` varchar(200) NOT NULL,
  `tree_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_name`, `parent_id`, `tree_path`, `tree_name`) VALUES
(1, 'Mobile', 0, '1', 'Mobile'),
(2, 'Computer', 0, '2', 'Computer'),
(3, 'Auto Mobile', 0, '3', 'Auto Mobile'),
(4, 'Desktop', 2, '2/4', 'Computer>>Desktop'),
(5, 'Laptop', 2, '2/5', 'Computer>>Laptop'),
(6, 'Ram', 4, '2/4/6', 'Computer>>Desktop>>Ram'),
(7, 'Mother Board', 4, '2/4/7', 'Computer>>Desktop>>Mother Board'),
(8, 'I/O Ports', 7, '2/4/7/8', 'Computer>>Desktop>>Mother Board>>I/O Ports'),
(9, '4 Wheeler', 3, '3/9', 'Auto Mobile>>4 Wheeler'),
(10, '2 Wheeler', 3, '3/10', 'Auto Mobile>>2 Wheeler'),
(11, 'Maruti', 9, '3/9/11', 'Auto Mobile>>4 Wheeler>>Maruti'),
(12, 'Bikes', 10, '3/10/12', 'Auto Mobile>>2 Wheeler>>Bikes'),
(13, 'Airtel', 1, '1/13', 'Mobile>>Airtel');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` blob NOT NULL,
  `image` blob NOT NULL,
  `cat_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
