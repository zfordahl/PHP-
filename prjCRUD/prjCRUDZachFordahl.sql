-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2023 at 08:57 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `departmentstoredatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentId` int NOT NULL,
  `departmentType` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentId`, `departmentType`) VALUES
(1, 'Bath'),
(2, 'Kitchen'),
(3, 'Bathroom'),
(4, 'Bedroom');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeId` int NOT NULL,
  `firstName` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastName` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `departmentId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeId`, `firstName`, `lastName`, `age`, `dateOfBirth`, `startDate`, `departmentId`) VALUES
(1, 'Michael', '', 59, '1967-01-20', '2000-06-19', 1),
(2, 'John', 'Fritz', 36, '1986-09-14', '2020-07-21', 2),
(3, 'Liz', 'Tabor', 47, '1970-03-23', '2015-01-19', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productId` int NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `productWebpage` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `manufacturer` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `manufacturerWebpage` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `departmentId` int DEFAULT NULL,
  `OnHandQty` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productId`, `productName`, `price`, `color`, `productWebpage`, `manufacturer`, `manufacturerWebpage`, `departmentId`, `OnHandQty`) VALUES
(1, 'Bath towel', 5.75, 'Black', 'http://MyStore.com/bathtowel.php', 'Cannon', 'http://cannonhomes.com/', 1, 75),
(2, 'Wash cloth', 0.99, 'White', 'http://MyStore.com/washcloth.php', '', 'http://cannonhomes.com/', 1, 225),
(3, 'Shower curtain', 11.99, 'White', 'http://MyStore.com/showercurtain.php', 'LinenSpa', 'http://linenspa.com/', 1, 73),
(4, 'Pantry Organizer', 3.99, 'Clear', 'http://MyStore.com/pantryorganizer.php', 'InterDesign', 'http://www.interdesignusa.com/', 2, 52),
(5, 'Storage Jar', 5.99, 'Clear', 'http://MyStore.com/storagejar.php', 'InterDesign', 'http://www.interdesignusa.com/', 2, 18),
(6, 'Firm pillow', 12.99, 'White', 'http://MyStore.com/firmpillow.php', 'InterDesign', 'http://www.interdesignusa.com/', 2, 24),
(7, 'Comforter', 34.99, '', 'http://MyStore.com/comforter.php', 'Cannon', 'http://cannonhomes.com/', 3, 12),
(8, 'Rollaway bed', 249.99, 'Black', 'http://MyStore.com/rollawaybed.php', 'LinenSpa', 'http://linenspa.com/', 3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentId`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeId`),
  ADD KEY `departmentId` (`departmentId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `departmentId` (`departmentId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`departmentId`) REFERENCES `department` (`departmentId`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`departmentId`) REFERENCES `department` (`departmentId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
