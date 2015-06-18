-- phpMyAdmin SQL Dump
-- version 4.2.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2014 at 10:09 PM
-- Server version: 5.6.17
-- PHP Version: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Nogollas_UAT`
--

-- --------------------------------------------------------

--
-- Table structure for table `Categorys`
--

CREATE TABLE IF NOT EXISTS `Categorys` (
  `CategoryID` int(1) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `SubCategory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Categorys`
--

INSERT INTO `Categorys` (`CategoryID`, `Category`, `SubCategory`) VALUES
(0, 'Category', 'SubCategory'),
(1, 'MEN', 'Top'),
(2, 'MEN', 'SHOES'),
(3, 'MEN', 'PANTS'),
(4, 'WOMEN', 'TOP'),
(5, 'WOMEN', 'DRESS'),
(6, 'WOMEN', 'ACCESSORIES');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE IF NOT EXISTS `Customer` (
`CustomerID` int(8) NOT NULL,
  `DateCreated` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `DateUpdated` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `DateDeleted` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `LastUpdateBy` int(8) NOT NULL,
  `UserName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `EmailVerified` int(1) NOT NULL,
  `Gender` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `Birthday` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Role` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Rating` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ErrorMessage`
--

CREATE TABLE IF NOT EXISTS `ErrorMessage` (
  `ErrorID` int(1) NOT NULL,
  `ErrorType` varchar(255) NOT NULL,
  `ErrorMessage` varchar(255) NOT NULL,
  `ErrorMessageValue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ErrorMessage`
--

INSERT INTO `ErrorMessage` (`ErrorID`, `ErrorType`, `ErrorMessage`, `ErrorMessageValue`) VALUES
(1, 'PASS', 'ItemAdded', 'Item Published.'),
(2, 'PASS', 'NotifiedBuyer', 'Buyer Notified.'),
(3, 'PASS', 'ItemReserved', 'Item Reserved.'),
(4, 'PASS', 'RatingSubmitted', 'Thank You. Your Rating has been Submitted.'),
(5, 'PASS', 'MailSentToFriend', 'Thank You. An Email has been sent to your friend.'),
(6, 'PASS', 'RemovePostedItem', 'Item has been removed from Posting.'),
(7, 'PASS', 'UpdatedNogollasPicks', 'Nogollas Picks Updated.'),
(8, 'PASS', 'TransactionCancelled', 'Transaction Cancelled.'),
(9, 'PASS', 'ItemReleasedForSale', 'Item Released For Sale.'),
(10, 'PASS', 'ItemSold', 'Item Sold.'),
(11, 'PASS', 'AccountUpdated', 'Account Updated.'),
(12, 'FAIL', 'ImageSizeExceeded', 'Error: Image size exceeded. Please change to a smaller file size'),
(13, 'FAIL', 'ImageNotSupported', 'Error: Image not supported. Please upload a valid image that contains .jpg or .gif.'),
(14, 'FAIL', 'FileNameExist', 'Error: Filename exist. Please change another filename'),
(15, 'FAIL', 'UpdateAccountFail', 'Error: Unable to update user account as system received no input value from user.'),
(16, 'FAIL', 'MailFailToSent', 'Error: Fail to send mail. Please contact Nogollas Administrator.');

-- --------------------------------------------------------

--
-- Table structure for table `Item`
--

CREATE TABLE IF NOT EXISTS `Item` (
`ItemID` int(8) NOT NULL,
  `DateCreated` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `DateUpdated` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `DateDeleted` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `LastUpdateBy` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `ItemName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ItemSize` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `ItemDescription` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `ItemPrice` decimal(4,2) NOT NULL,
  `ItemCondition` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ItemDelivery` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ItemSellingMode` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ItemCategory` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ItemInstructionForBuyer` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `ItemRemarks` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `ItemSeller` int(8) DEFAULT NULL,
  `ItemBuyer` int(8) DEFAULT NULL,
  `ItemStatus` int(1) NOT NULL,
  `ItemNotify` int(1) NOT NULL,
  `ItemImageFileName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NogollasCategory` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `NogollasPicks` int(1) NOT NULL,
  `RateItem` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20000000 ;

-- --------------------------------------------------------

--
-- Table structure for table `ItemEmail`
--

CREATE TABLE IF NOT EXISTS `ItemEmail` (
`SendEmailID` int(11) NOT NULL,
  `DateCreated` varchar(25) NOT NULL,
  `LastUpdateBy` varchar(255) NOT NULL,
  `DateUpdated` varchar(255) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `ReferAFriendEmail` varchar(255) NOT NULL,
  `SenderID` int(11) NOT NULL,
  `SendEmail` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ItemStatuss`
--

CREATE TABLE IF NOT EXISTS `ItemStatuss` (
  `ItemStatus` int(1) NOT NULL,
  `ItemStatusValue` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ItemStatuss`
--

INSERT INTO `ItemStatuss` (`ItemStatus`, `ItemStatusValue`) VALUES
(1, 'AVAILABLE'),
(2, 'RESERVED'),
(3, 'CLOSED DEAL'),
(4, 'POST REMOVED'),
(5, 'NOTIFIED');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Categorys`
--
ALTER TABLE `Categorys`
 ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
 ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `ErrorMessage`
--
ALTER TABLE `ErrorMessage`
 ADD PRIMARY KEY (`ErrorID`);

--
-- Indexes for table `Item`
--
ALTER TABLE `Item`
 ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `ItemEmail`
--
ALTER TABLE `ItemEmail`
 ADD PRIMARY KEY (`SendEmailID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
MODIFY `CustomerID` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Item`
--
ALTER TABLE `Item`
MODIFY `ItemID` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20000000;
--
-- AUTO_INCREMENT for table `ItemEmail`
--
ALTER TABLE `ItemEmail`
MODIFY `SendEmailID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
