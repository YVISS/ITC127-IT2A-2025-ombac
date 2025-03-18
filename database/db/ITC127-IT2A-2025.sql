-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 18, 2025 at 04:42 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ITC127-IT2A-2025`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounts`
--

CREATE TABLE `tblaccounts` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblaccounts`
--

INSERT INTO `tblaccounts` (`username`, `password`, `usertype`, `status`, `createdby`, `datecreated`) VALUES
('admin', '123456', 'ADMINISTRATOR', 'ACTIVE', 'admin', '02/12/2025');

-- --------------------------------------------------------

--
-- Table structure for table `tblequipments`
--

CREATE TABLE `tblequipments` (
  `assetnumber` varchar(40) NOT NULL,
  `serialnumber` varchar(50) NOT NULL,
  `equipmenttype` varchar(50) NOT NULL,
  `manufacturer` varchar(50) NOT NULL,
  `yearmodel` varchar(100) NOT NULL,
  `description` varchar(50) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbllogs`
--

CREATE TABLE `tbllogs` (
  `datelog` varchar(20) NOT NULL,
  `timelog` varchar(20) NOT NULL,
  `action` varchar(10) NOT NULL,
  `module` varchar(50) NOT NULL,
  `performedby` varchar(50) NOT NULL,
  `performedto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllogs`
--

INSERT INTO `tbllogs` (`datelog`, `timelog`, `action`, `module`, `performedby`, `performedto`) VALUES
('12/03/2025', '08:00:29am', 'Update', 'Accounts Management', 'admin', 'test1'),
('12/03/2025', '08:34:59am', 'Update', 'Accounts Management', 'admin', 'test1'),
('12/03/2025', '08:35:02am', 'Delete', 'Accounts Management', 'admin', 'test1'),
('12/03/2025', '08:59:00am', 'Update', 'Accounts Management', 'admin', 'test1'),
('12/03/2025', '08:59:24am', 'Delete', 'Accounts Management', 'admin', 'test1'),
('12/03/2025', '08:59:49am', 'Update', 'Accounts Management', 'admin', 'test1'),
('12/03/2025', '08:59:58am', 'Delete', 'Accounts Management', 'admin', 'test1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tblequipments`
--
ALTER TABLE `tblequipments`
  ADD PRIMARY KEY (`assetnumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
