-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2016 at 05:54 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `parking_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `lot_by_day`
--

CREATE TABLE IF NOT EXISTS `lot_by_day` (
  `Date` date NOT NULL,
  `Lot_ID` int(11) NOT NULL,
  `M_Available` int(4) NOT NULL,
  `E_Available` int(4) NOT NULL,
  `R_Available` int(4) NOT NULL,
  `D_Available` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lot_by_day`
--

INSERT INTO `lot_by_day` (`Date`, `Lot_ID`, `M_Available`, `E_Available`, `R_Available`, `D_Available`) VALUES
('2016-09-07', 1, 20, 10, 20, 10),
('2016-09-07', 2, 10, 10, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `parking_lot`
--

CREATE TABLE IF NOT EXISTS `parking_lot` (
  `Lot_ID` int(11) NOT NULL,
  `Lot_Name` varchar(40) NOT NULL,
  `City` varchar(15) NOT NULL,
  `Street_Name` varchar(15) NOT NULL,
  `Building_Number` int(4) NOT NULL,
  `Location_Details` varchar(40) NOT NULL,
  `M_Total` int(4) NOT NULL,
  `E_Total` int(4) NOT NULL,
  `R_Total` int(4) NOT NULL,
  `D_Total` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking_lot`
--

INSERT INTO `parking_lot` (`Lot_ID`, `Lot_Name`, `City`, `Street_Name`, `Building_Number`, `Location_Details`, `M_Total`, `E_Total`, `R_Total`, `D_Total`) VALUES
(1, 'Ariela''s Lot', 'Jerusalem', 'Trumpeldor', 12, 'Behind thee bakery', 20, 10, 20, 10),
(2, 'Benj''ys Lot', 'Afula', 'Perry', 3, '', 10, 10, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `parking_type`
--

CREATE TABLE IF NOT EXISTS `parking_type` (
  `Type_ID` char(1) NOT NULL,
  `Description` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking_type`
--

INSERT INTO `parking_type` (`Type_ID`, `Description`) VALUES
('E', 'emergency'),
('M', 'motorcycle'),
('R', 'regular'),
('D', 'something');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `Rsrv_Date` date NOT NULL,
  `Rsrv_UserID` int(11) NOT NULL,
  `Rsrv_ParkingLotID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`Rsrv_Date`, `Rsrv_UserID`, `Rsrv_ParkingLotID`) VALUES
('2016-09-07', 3, 1),
('2016-09-07', 4, 1),
('2016-09-07', 5, 1),
('2016-09-07', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `User_ID` int(11) NOT NULL,
  `User_Name` varchar(50) NOT NULL,
  `User_Email` varchar(30) NOT NULL,
  `User_Password` varchar(30) NOT NULL,
  `User_ParkingType` char(1) NOT NULL,
  `User_License` int(6) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `User_Name`, `User_Email`, `User_Password`, `User_ParkingType`, `User_License`, `admin`) VALUES
(3, 'Ariela Epstein', 'ariela@gmail.com', 'power1', 'R', 1234, 1),
(4, 'sheldon', 'sheldon@gmail.com', 'stealth1', 'M', 3456, 0),
(5, 'Benjy', 'benjy@gmail.com', 'groove', 'M', 2378, 0),
(6, 'ari', 'ariela.epstein@gmail.com', 'tgpp848', 'M', 2314, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lot_by_day`
--
ALTER TABLE `lot_by_day`
  ADD PRIMARY KEY (`Date`,`Lot_ID`), ADD KEY `Lot_ID` (`Lot_ID`);

--
-- Indexes for table `parking_lot`
--
ALTER TABLE `parking_lot`
  ADD PRIMARY KEY (`Lot_ID`), ADD UNIQUE KEY `Lot_Name` (`Lot_Name`);

--
-- Indexes for table `parking_type`
--
ALTER TABLE `parking_type`
  ADD PRIMARY KEY (`Type_ID`), ADD UNIQUE KEY `Description` (`Description`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Rsrv_Date`,`Rsrv_UserID`,`Rsrv_ParkingLotID`), ADD KEY `Rsrv_ParkingLotID` (`Rsrv_ParkingLotID`), ADD KEY `Rsrv_UserID` (`Rsrv_UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`), ADD UNIQUE KEY `User_Email` (`User_Email`), ADD KEY `User_ParkingType` (`User_ParkingType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parking_lot`
--
ALTER TABLE `parking_lot`
  MODIFY `Lot_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `lot_by_day`
--
ALTER TABLE `lot_by_day`
ADD CONSTRAINT `lot_by_day_ibfk_1` FOREIGN KEY (`Lot_ID`) REFERENCES `parking_lot` (`Lot_ID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`Rsrv_Date`) REFERENCES `lot_by_day` (`Date`),
ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`Rsrv_ParkingLotID`) REFERENCES `lot_by_day` (`Lot_ID`),
ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`Rsrv_UserID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`User_ParkingType`) REFERENCES `parking_type` (`Type_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
