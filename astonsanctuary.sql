-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2019 at 09:34 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `astonsanctuary`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoptions`
--

CREATE TABLE `adoptions` (
  `adoptionID` int(11) NOT NULL,
  `userID` int(10) NOT NULL COMMENT 'ID used by requester',
  `petID` int(10) NOT NULL COMMENT 'ID of Pet in question',
  `dateRequested` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date Request was made',
  `status` varchar(1) NOT NULL DEFAULT 'u' COMMENT 'Status of Approval: U = Unapproved, A = Approved, D = Denied'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adoptions`
--

INSERT INTO `adoptions` (`adoptionID`, `userID`, `petID`, `dateRequested`, `status`) VALUES
(1, 5, 10, '2019-02-13 05:53:36', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `petID` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `dateRescued` datetime DEFAULT CURRENT_TIMESTAMP,
  `species` varchar(20) DEFAULT NULL,
  `subspecies` varchar(50) DEFAULT NULL,
  `temperment` varchar(50) DEFAULT NULL,
  `description` varchar(1500) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT '0',
  `picture` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`petID`, `name`, `dob`, `dateRescued`, `species`, `subspecies`, `temperment`, `description`, `availability`, `picture`) VALUES
(9, 'Dougal', '2013-11-24', '2019-02-13 03:13:32', 'Dog', 'Chinese Crested ', 'Friendly', 'Endlessly Loving and a great lap dog for adults and kids alike', 1, 'images/25497350_1777575488920128_322944850_n_1550027612.jpg'),
(10, 'Scrat', '2011-01-01', '2019-02-13 03:29:18', 'Squirrel', 'Grey', 'Scatterbrained', 'Dopey Squirrel', 1, 'images/ice_age_1550028558.jpg'),
(11, 'Ginger', '2013-01-01', '2019-02-13 03:30:33', 'Cat', 'Ginger Cat', 'Shy', 'Ginger is an abandoned cat with some issues towards other animals outdoor', 0, 'images/cat_1550028633.jpg'),
(12, 'Bambi', '2015-01-01', '2019-02-13 03:31:00', 'Deer', '', 'Skittish', 'A nervous baby deer', 0, 'images/deer_1550028660.jpg'),
(13, 'Goldilocks', '2017-01-01', '2019-02-13 03:31:37', 'Fish', 'Goldfish', 'Fishlike', 'It\'s a fish', 0, 'images/download_1550028697.jpeg'),
(14, 'Simon', '2013-05-01', '2019-02-13 03:32:11', 'Horse', '', 'Aggressive', 'A wild Stallion with a quick temper', 0, 'images/horse_1550028731.jpeg'),
(15, 'Bruce', '2010-01-01', '2019-02-13 03:32:50', 'Lion', '', 'Tame', 'Ex Circus Lion looking for a couch to sleep on', 0, 'images/lion_1550028770.jpg'),
(16, 'Glen', '2011-01-03', '2019-02-13 03:33:47', 'Dog', '', 'Snarly', 'Easily spooks and becomes aggressive, good dog experience needed', 0, 'images/retriever_1550028827.jpg'),
(17, 'Sid', '1995-05-23', '2019-02-13 03:34:29', 'Sloth', 'Three toed', 'Quick', 'Deceptively fast, Sid requires a careful watch', 0, 'images/sloth_1550028869.jpg'),
(18, 'Red', '2017-03-05', '2019-02-13 03:35:05', 'Squirrel', 'Red Squirell', 'Cheeky', 'Squirrel with an uncanny ability to understand your fears and desires', 0, 'images/squirrel_1550028905.jpg'),
(19, 'Cloud', '2018-08-01', '2019-02-13 03:35:49', 'Dog', 'Irish Wolfhound', 'Energetic', 'Young Puppy looking for a large house and a loving family', 0, 'images/whitedog_1550028949.jpeg'),
(20, 'Dora', '1865-05-02', '2019-02-13 03:36:26', 'Dog', '', 'Wooden', 'Barely Moves, doesn\'t require feeding', 0, 'images/yorkie_1550028986.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(10) NOT NULL COMMENT 'Unique User Number for System use',
  `username` varchar(50) NOT NULL COMMENT 'User Selected Username',
  `password` varchar(10000) NOT NULL COMMENT 'User Password',
  `name` varchar(50) DEFAULT NULL COMMENT 'User Real Name',
  `dob` date DEFAULT NULL COMMENT 'User Date of Birth',
  `address` varchar(150) DEFAULT NULL COMMENT 'User Home Address',
  `bio` varchar(500) DEFAULT NULL COMMENT 'Information about the User',
  `tele` varchar(15) DEFAULT NULL COMMENT 'User Telephone Number',
  `picture` varchar(500) DEFAULT NULL COMMENT 'Directory where User image stored',
  `staff` tinyint(1) DEFAULT '0' COMMENT '1 if user is a staff member'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `name`, `dob`, `address`, `bio`, `tele`, `picture`, `staff`) VALUES
(1, 'test', '$2y$10$/ME7qhqQG1vNe6euLndq5OkYDZnY8nI9Y/.ciy6JNaaoWBbFCiK42', 'Jake Perolta', '1995-12-01', '1, 1 Avenue Road', 'I once held a rat', '3305888000', 'images/ice_age_1550025503.jpg', 0),
(3, 'admin', '$2y$10$t696.EfTRDbe3uSa8Ya/Hu012oe4WmyZ1YsKdYC7/rv/cybdK1UvO', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(5, 'test2', '$2y$10$e9k0PC6xG.p4E9ll5YW4self1XRAMf8bY.SfqWOvtg/dEE0nxghhG', 'Fred w', '1998-12-08', '1 empire state', 'Lots of experience with animals', '12341234123', 'images/freddiew_1550039350.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoptions`
--
ALTER TABLE `adoptions`
  ADD PRIMARY KEY (`adoptionID`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `petID` (`petID`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`petID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `users` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoptions`
--
ALTER TABLE `adoptions`
  MODIFY `adoptionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `petID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique User Number for System use', AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoptions`
--
ALTER TABLE `adoptions`
  ADD CONSTRAINT `adoptions_ibfk_1` FOREIGN KEY (`petID`) REFERENCES `pets` (`petID`),
  ADD CONSTRAINT `adoptions_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
