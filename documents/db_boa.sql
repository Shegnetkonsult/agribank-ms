-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 07, 2024 at 06:22 PM
-- Server version: 8.0.39-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_boa`
--

-- --------------------------------------------------------

--
-- Table structure for table `Accounts`
--

CREATE TABLE `Accounts` (
  `AccountId` int NOT NULL,
  `UserID` int NOT NULL,
  `AccountNumber` varchar(20) NOT NULL,
  `AccountType` enum('Savings','Current') NOT NULL,
  `Balance` decimal(15,2) DEFAULT '0.00',
  `DateCreated` datetime DEFAULT CURRENT_TIMESTAMP,
  `Status` enum('Active','Inactive','Closed') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `AuditLogs`
--

CREATE TABLE `AuditLogs` (
  `LogId` int NOT NULL,
  `UserId` int NOT NULL,
  `Action` varchar(30) NOT NULL,
  `Timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `IP_Address` varchar(25) NOT NULL,
  `Description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Loans`
--

CREATE TABLE `Loans` (
  `LoanId` int NOT NULL,
  `UserId` int NOT NULL,
  `LoanType` enum('Farm Startup','Expansion') NOT NULL,
  `Amount` decimal(15,2) NOT NULL,
  `InterestRate` float NOT NULL,
  `Status` enum('Pending','Approved','Rejected','Active','Paid','Defaulted') DEFAULT 'Pending',
  `Approved_At` datetime DEFAULT NULL,
  `Due_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Transactions`
--

CREATE TABLE `Transactions` (
  `TransactionsId` int NOT NULL,
  `AccountID` int NOT NULL,
  `TransactionType` enum('Deposit','Withdrawal','Transfer','Loan Payment') NOT NULL,
  `Amount` decimal(15,2) NOT NULL,
  `Date` datetime DEFAULT CURRENT_TIMESTAMP,
  `Status` enum('Pending','Completed','Failed') DEFAULT 'Completed',
  `Description` varchar(255) DEFAULT NULL,
  `Balance_Before` decimal(15,2) DEFAULT NULL,
  `Balance_After` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TwoFactorAuthCodes`
--

CREATE TABLE `TwoFactorAuthCodes` (
  `CodeID` int NOT NULL,
  `UserID` int NOT NULL,
  `Code` varchar(6) NOT NULL,
  `ExpirationTime` timestamp NOT NULL,
  `IsUsed` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserId` int NOT NULL,
  `Username` varchar(20) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `NationalID` varchar(20) NOT NULL,
  `Passport` longblob,
  `Address` text NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Role` int NOT NULL,
  `Created_At` datetime DEFAULT CURRENT_TIMESTAMP,
  `Status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Accounts`
--
ALTER TABLE `Accounts`
  ADD PRIMARY KEY (`AccountId`),
  ADD UNIQUE KEY `AccountNumber` (`AccountNumber`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `AuditLogs`
--
ALTER TABLE `AuditLogs`
  ADD PRIMARY KEY (`LogId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `Loans`
--
ALTER TABLE `Loans`
  ADD PRIMARY KEY (`LoanId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`TransactionsId`),
  ADD KEY `AccountID` (`AccountID`);

--
-- Indexes for table `TwoFactorAuthCodes`
--
ALTER TABLE `TwoFactorAuthCodes`
  ADD PRIMARY KEY (`CodeID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `NationalID` (`NationalID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Accounts`
--
ALTER TABLE `Accounts`
  MODIFY `AccountId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AuditLogs`
--
ALTER TABLE `AuditLogs`
  MODIFY `LogId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Loans`
--
ALTER TABLE `Loans`
  MODIFY `LoanId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Transactions`
--
ALTER TABLE `Transactions`
  MODIFY `TransactionsId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TwoFactorAuthCodes`
--
ALTER TABLE `TwoFactorAuthCodes`
  MODIFY `CodeID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserId` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Accounts`
--
ALTER TABLE `Accounts`
  ADD CONSTRAINT `Accounts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserId`);

--
-- Constraints for table `AuditLogs`
--
ALTER TABLE `AuditLogs`
  ADD CONSTRAINT `AuditLogs_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`);

--
-- Constraints for table `Loans`
--
ALTER TABLE `Loans`
  ADD CONSTRAINT `Loans_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`);

--
-- Constraints for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD CONSTRAINT `Transactions_ibfk_1` FOREIGN KEY (`AccountID`) REFERENCES `Accounts` (`AccountId`);

--
-- Constraints for table `TwoFactorAuthCodes`
--
ALTER TABLE `TwoFactorAuthCodes`
  ADD CONSTRAINT `TwoFactorAuthCodes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
