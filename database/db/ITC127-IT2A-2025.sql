-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 06:00 PM
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
-- Database: `itc127-it2a-2025`
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
('admin', '123456', 'ADMINISTRATOR', 'ACTIVE', 'admin', '02/12/2025'),
('technical', 'technical', 'TECHNICAL', 'ACTIVE', 'admin', '25/03/2025'),
('user', 'user', 'USER', 'ACTIVE', 'admin', '25/03/2025');

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
('12/03/2025', '08:59:58am', 'Delete', 'Accounts Management', 'admin', 'test1'),
('25/03/2025', '01:27:20pm', 'Delete', 'Ticket Management', 'user', '20250325132702'),
('25/03/2025', '02:03:30pm', 'Delete', 'Accounts Management', 'admin', 'test1'),
('25/03/2025', '02:05:12pm', 'Update', 'Accounts Management', 'admin', 'test1'),
('25/03/2025', '02:05:18pm', 'Delete', 'Accounts Management', 'admin', 'test1'),
('25/03/2025', '02:21:54pm', 'Delete', 'Ticket Management', 'user', '20250325132255'),
('25/03/2025', '02:26:36pm', 'Update', 'Equipment Management', 'technical', 'aaaaaa'),
('25/03/2025', '02:26:57pm', 'Delete', 'Equipment Management', 'technical', 'aaaaaa'),
('25/03/2025', '02:27:28pm', 'Delete', 'Equipment Management', 'technical', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `tbltickets`
--

CREATE TABLE `tbltickets` (
  `ticketnumber` varchar(50) NOT NULL,
  `problem` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'PENDING',
  `createdby` varchar(50) NOT NULL,
  `datecreated` varchar(20) NOT NULL,
  `assignedto` varchar(50) DEFAULT NULL,
  `dateassigned` varchar(20) DEFAULT NULL,
  `datecompleted` varchar(20) DEFAULT NULL,
  `approvedby` varchar(50) DEFAULT NULL,
  `dateapproved` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbltickets`
--

INSERT INTO `tbltickets` (`ticketnumber`, `problem`, `details`, `status`, `createdby`, `datecreated`, `assignedto`, `dateassigned`, `datecompleted`, `approvedby`, `dateapproved`) VALUES
('20250325142205', 'Hardware', 'errooorrr', 'PENDING', 'user', '25/03/2025', NULL, NULL, NULL, NULL, NULL);

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

--
-- Indexes for table `tbltickets`
--
ALTER TABLE `tbltickets`
  ADD PRIMARY KEY (`ticketnumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
