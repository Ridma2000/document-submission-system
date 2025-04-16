-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 06:50 PM
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
-- Database: `doc_sub`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliation`
--

CREATE TABLE `affiliation` (
  `AffiliationID` int(11) NOT NULL,
  `AffiliationName` varchar(50) NOT NULL,
  `HeadOfAffiliation` varchar(25) NOT NULL,
  `LastUpdatedBy` varchar(25) NOT NULL,
  `LastUpdatedTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LastUpdatedLocation` varchar(50) NOT NULL,
  `ContactNo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `affiliation`
--

INSERT INTO `affiliation` (`AffiliationID`, `AffiliationName`, `HeadOfAffiliation`, `LastUpdatedBy`, `LastUpdatedTime`, `LastUpdatedLocation`, `ContactNo`) VALUES
(1, 'Faculty of Science', 'Upul Sonnadara', 'Admin', '2025-02-21 08:54:58', '', 701234567),
(2, 'Department of Physics', 'Chandana Jayarathne', 'Admin', '2025-02-21 08:54:35', '', 701234544),
(3, 'Department of Chemistry', 'W.R.M.De Silva', 'Admin', '2025-02-21 08:45:02', '', 701234555),
(4, 'Department of Zoology', 'D.K.Weerakoon', 'Admin', '2025-02-21 08:46:37', '', 711345624),
(5, 'Department of Statistics', 'R. A. B. Abeygunawardhane', 'Admin', '2025-02-21 08:51:21', '', 776575877),
(6, 'Department of mathematics', 'S. N. N. Perera', 'Admin', '2025-02-21 08:49:58', '', 701234789),
(7, 'Department of Plant Science', 'H.S.Kathriarachchi', 'Admin', '2025-02-21 08:54:09', '', 726545678),
(8, 'Department of Nuclear Science', 'J. Jeyasugiththan', 'Admin', '2025-02-21 08:53:59', '', 774536543);

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `AuditLogID` int(11) NOT NULL,
  `DocumentID` int(11) NOT NULL,
  `ReviewerID` int(11) NOT NULL,
  `AuditStateID` int(11) UNSIGNED NOT NULL,
  `LastUpdatedTime` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Remarks` text NOT NULL,
  `LastUpdatedBy` varchar(50) NOT NULL,
  `LastUpdatedLocation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`AuditLogID`, `DocumentID`, `ReviewerID`, `AuditStateID`, `LastUpdatedTime`, `Remarks`, `LastUpdatedBy`, `LastUpdatedLocation`) VALUES
(8, 10, 1437731433, 2, '2025-02-19 06:53:07', 'I approve', '1437731433', '::1'),
(9, 11, 1437731433, 2, '2025-02-20 03:54:33', 'I approve', '1437731433', '::1'),
(10, 11, 1437731431, 4, '2025-02-20 03:56:11', 'plz check the reasons', '1437731431', '::1'),
(11, 11, 1437731433, 2, '2025-02-20 03:56:51', 'yes dates are correct', '1437731433', '::1'),
(12, 11, 1437731431, 2, '2025-02-20 03:58:15', 'i approve', '1437731431', '::1'),
(13, 11, 1437731427, 3, '2025-02-20 03:59:16', 'cannot give permission ', '1437731427', '::1'),
(14, 12, 1437731433, 2, '2025-02-21 02:55:55', 'i approve', '1437731433', '::1'),
(15, 12, 1437731431, 4, '2025-02-21 02:56:43', 'check the reasons', '1437731431', '::1'),
(16, 12, 1437731433, 3, '2025-02-21 02:57:34', 'i reject', '1437731433', '::1'),
(17, 13, 1437731433, 2, '2025-02-21 04:22:22', 'xcv', '1437731433', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `audit_state`
--

CREATE TABLE `audit_state` (
  `AuditStateID` int(11) UNSIGNED NOT NULL,
  `AuditState` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_state`
--

INSERT INTO `audit_state` (`AuditStateID`, `AuditState`) VALUES
(2, 'Approved'),
(3, 'Rejected'),
(4, 'Partially approved');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `DocumentID` int(11) NOT NULL,
  `DocTypeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `SubmittedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `DocumentStatusID` int(11) NOT NULL,
  `DocumentHierarchyID` int(11) NOT NULL,
  `document_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`DocumentID`, `DocTypeID`, `UserID`, `SubmittedAt`, `DocumentStatusID`, `DocumentHierarchyID`, `document_description`) VALUES
(10, 17, 1437731425, '2025-02-19 06:51:23', 1, 40, 'Please grant me permission for this letter'),
(11, 18, 1437731425, '2025-02-20 03:53:07', 3, 45, 'Please grant me a leave on Feb 25'),
(12, 18, 1437731425, '2025-02-21 02:54:30', 3, 43, 'Please excuse me on Feb 28'),
(13, 18, 1437731425, '2025-02-21 04:19:07', 1, 44, 'zzzz');

-- --------------------------------------------------------

--
-- Table structure for table `documents_types`
--

CREATE TABLE `documents_types` (
  `DocTypeID` int(11) NOT NULL,
  `DocTypeName` varchar(100) NOT NULL,
  `LastUpdatedBy` varchar(50) DEFAULT NULL,
  `LastUpdatedTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LastUpdatedLocation` varchar(50) NOT NULL,
  `Description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents_types`
--

INSERT INTO `documents_types` (`DocTypeID`, `DocTypeName`, `LastUpdatedBy`, `LastUpdatedTime`, `LastUpdatedLocation`, `Description`) VALUES
(17, 'Hostel permission', 'Admin', '2025-02-19 12:19:20', '::1', 'This is a permission letter for students'),
(18, 'Student Leaving (Physics Department)', 'Admin', '2025-02-20 09:19:37', '::1', 'This is student leaving form'),
(21, 'my doc', 'Admin', '2025-02-21 09:45:10', '::1', 'This is check document');

-- --------------------------------------------------------

--
-- Table structure for table `document_hierarchy`
--

CREATE TABLE `document_hierarchy` (
  `DocumentHierarchyID` int(11) NOT NULL,
  `DocumentTypeID` int(11) NOT NULL,
  `UserTypeID` int(11) NOT NULL,
  `LastUpdatedBy` varchar(25) DEFAULT NULL,
  `LastUpdatedTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LastUpdatedLocation` varchar(50) NOT NULL,
  `OrderID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_hierarchy`
--

INSERT INTO `document_hierarchy` (`DocumentHierarchyID`, `DocumentTypeID`, `UserTypeID`, `LastUpdatedBy`, `LastUpdatedTime`, `LastUpdatedLocation`, `OrderID`) VALUES
(39, 17, 2, 'Admin', '2025-02-19 12:19:20', '::1', 1),
(40, 17, 9, 'Admin', '2025-02-19 12:19:20', '::1', 2),
(41, 17, 15, 'Admin', '2025-02-19 12:19:20', '::1', 3),
(42, 17, 134, 'Admin', '2025-02-19 12:19:20', '::1', 4),
(43, 18, 2, 'Admin', '2025-02-20 09:19:37', '::1', 1),
(44, 18, 5, 'Admin', '2025-02-20 09:19:37', '::1', 2),
(45, 18, 9, 'Admin', '2025-02-20 09:19:37', '::1', 3),
(46, 18, 15, 'Admin', '2025-02-20 09:19:37', '::1', 4),
(54, 21, 2, 'Admin', '2025-02-21 09:45:10', '::1', 1),
(55, 21, 5, 'Admin', '2025-02-21 09:45:10', '::1', 2),
(56, 21, 15, 'Admin', '2025-02-21 09:45:10', '::1', 3),
(57, 21, 134, 'Admin', '2025-02-21 09:45:10', '::1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `document_state`
--

CREATE TABLE `document_state` (
  `DocumentStatusID` int(11) NOT NULL,
  `DocumentStatus` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_state`
--

INSERT INTO `document_state` (`DocumentStatusID`, `DocumentStatus`) VALUES
(1, 'Submitted'),
(2, 'Approved'),
(3, 'Rejected'),
(4, 'ApprovedParti');

-- --------------------------------------------------------

--
-- Table structure for table `document_versions`
--

CREATE TABLE `document_versions` (
  `VersionID` int(11) NOT NULL,
  `DocumentID` int(11) NOT NULL,
  `DocTypeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `SubmittedAt` datetime NOT NULL,
  `DocumentStatusID` int(11) NOT NULL,
  `DocumentHierarchyID` int(11) NOT NULL,
  `FilePath` varchar(250) NOT NULL,
  `ChangeSummary` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_versions`
--

INSERT INTO `document_versions` (`VersionID`, `DocumentID`, `DocTypeID`, `UserID`, `SubmittedAt`, `DocumentStatusID`, `DocumentHierarchyID`, `FilePath`, `ChangeSummary`) VALUES
(10, 10, 17, 1437731425, '2025-02-19 12:21:23', 1, 39, 'uploads/1739967683_3ea300e27303c39aa5cf.pdf', 'Please grant me permission for this letter'),
(11, 11, 18, 1437731425, '2025-02-20 09:23:07', 1, 43, 'uploads/1740043387_034da031ec683a6f471c.pdf', 'Please grant me a leave on Feb 25'),
(12, 12, 18, 1437731425, '2025-02-21 08:24:30', 1, 43, 'uploads/1740126270_3e13ff9e4717870cd6eb.pdf', 'Please excuse me on Feb 28'),
(13, 13, 18, 1437731425, '2025-02-21 09:49:07', 1, 43, 'uploads/1740131347_09dd157b331d32324572.pdf', 'zzzz');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `UserTypesID` int(11) DEFAULT NULL,
  `CreatedTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NameWithInitial` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `designation` varchar(20) DEFAULT NULL,
  `AffiliationID` int(11) DEFAULT NULL,
  `CreatedLocation` varchar(50) NOT NULL,
  `CreatedBy` varchar(25) NOT NULL,
  `LastUpdatedTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LastUpdatedLocation` varchar(50) DEFAULT NULL,
  `LastUpdatedBy` varchar(25) DEFAULT NULL,
  `StreetAddress` varchar(40) NOT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `PostalCode` smallint(10) UNSIGNED NOT NULL,
  `contact_number` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Role` enum('Admin','User') NOT NULL,
  `status` enum('Active','Deactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `UserName`, `email`, `password`, `UserTypesID`, `CreatedTime`, `NameWithInitial`, `name`, `LastName`, `designation`, `AffiliationID`, `CreatedLocation`, `CreatedBy`, `LastUpdatedTime`, `LastUpdatedLocation`, `LastUpdatedBy`, `StreetAddress`, `City`, `State`, `PostalCode`, `contact_number`, `Role`, `status`) VALUES
(1437731416, 'kasun123', 'ridma@gmail.com', '$2b$12$poYC1.rgWqtOzCKnEp1mre2zd/lZxY1/oglkp89Ph7b.1Ym5Gx.n.\n', 15, '2025-02-20 10:00:18', 'C. Perera', 'Chandana', 'Perera', 'Head', 1, '', '', '2025-02-20 10:00:18', NULL, NULL, '13', 'Kaluara', 'Colombo ', 12566, '0734640459', 'User', 'Active'),
(1437731425, 'Janani123', 'jananiAmara@gmail.com', '$2y$10$M2yB66F75NA4QbN/HA0Gq.eQd1xXxGu3HhMJdv18Whls5vTS2e9dy', 1, '2025-02-20 09:46:11', 'J.Amarathunga', 'Janani', 'Amarathunga', 'Dimo', 1, '', '', '2025-02-20 09:46:11', NULL, NULL, '25/1,StationRoad,Warakapola', 'Warakapola', 'Sabaragamuwa', 65535, '0714427666', 'User', 'Active'),
(1437731426, 'Thivanka111', 'thivanka@gmal.com', '$2y$10$8PtYi3NzrFUmM8y/W5K4Z.B7OX7Hvx0unzeThJVEbtfW18AXUb062', 145, '2025-02-19 11:39:51', 'T.Wimalasooriya', 'Thivanka', 'Wimalaooriya', 'Admin', 1, '', '', '2025-02-19 11:39:51', NULL, NULL, '25/1,StationRoad,Warakapola', 'Warakapola', 'Sabaragamuwa', 65535, '0746780912', 'Admin', 'Active'),
(1437731427, 'Poorna122', 'poornaliyanage@gmail.com', '$2y$10$EM6yg7najRumltaNHDSKh.Pr5ojC0m6VMLtSvH8KrbUNjz8OElu36', 9, '2025-02-21 09:12:53', 'T.Poorna', 'Tharindu', 'Poorna', 'Lecture', 2, '', '', '2025-02-21 09:12:53', NULL, NULL, '777', 'Kaluthara', 'Kaluthara south', 65535, '0711447777', 'User', 'Active'),
(1437731428, 'iwanth777', 'iwanthiabeysinghe@gmail.com', '$2y$10$4obwn2sdSu1jF9pXSAUVsuBiiukCugqnB7MyVcBUzjwQiTm6Jt4J2', 6, '2025-02-21 09:04:19', 'A.M.I.Abeysinghe', 'Iwanthi', 'Abeysinghe', 'Course coordinator', 2, '', '', '2025-02-21 09:04:19', NULL, NULL, '05', 'Weligalla', 'Poojapitiya', 65535, '0781393858', 'User', 'Active'),
(1437731429, 'hasala123', 'hasala@gmail.com', '$2y$10$rHMu8w7bl37FN37s3KYMu.kPfq591TqjSdOc9ascTNVrcpEu94Qgu', 134, '2025-02-19 11:53:43', 'H.Weerathunga', 'Hasala', 'Weerathunga', 'Dean', 1, '', '', '2025-02-19 11:53:43', NULL, NULL, '12', 'Kottawa', 'Kottawa North', 12400, '0758963214', 'User', 'Active'),
(1437731430, 'rishmika123', 'rishmika@gmail.com', '$2y$10$8bR.LyYKEDJoWkR0mNFsYOcIZYjj9cbYBTpkjlA6hrdENnrPO./rO', 60, '2025-02-19 11:58:35', 'R.Perera', 'Rishmika', 'Perera', 'ITU admin', 1, '', '', '2025-02-19 11:58:35', NULL, NULL, '17/196', 'Digamadulla', 'Weerawila', 56781, '0762568672', 'User', 'Active'),
(1437731431, 'chandana123', 'chand@gmail.com', '$2y$10$qoubZjYISU2wAKL8VrMHkeeSunfT4OBhyfZYDGA35Mekg5DfpmPeK', 5, '2025-02-21 09:47:08', 'C.Perera', 'Chandana', 'Perera', 'Assistance Lecture', 2, '', '', '2025-02-21 09:47:08', NULL, NULL, '220', 'Seram place', 'Colombo 10', 65535, '0752253872', 'User', 'Active'),
(1437731432, 'kasun155', 'ridma111@gmail.com', '$2y$10$duN5PVu/H/mTLKHoSxXCTeDPHGcELjIxXfCL83dv4xPNWZ7mgQaqu', 15, '2025-02-19 12:05:21', 'K. Kalhara', 'Kasun', 'Kalhar', 'Department Head', 2, '', '', '2025-02-19 12:05:21', NULL, NULL, '85/6', 'Marathugoda', 'Kandy', 22110, '0718184748', 'User', 'Active'),
(1437731433, 'hemal111', 'hemal111@gmail.com', '$2y$10$QL1h6KZQnBN0mAqA/bGDXeM0tPcOHN4UqWXMv3T0i5G631MIpqSSy', 2, '2025-02-20 10:00:23', 'H.Himal', 'Himantha', 'Himal', 'Demo', 2, '', '', '2025-02-20 10:00:23', NULL, NULL, '20', 'Anuradhapura', 'Anuradhapura new town', 20200, '0456874126', 'User', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `UserTypeID` int(11) NOT NULL,
  `UserTypeName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`UserTypeID`, `UserTypeName`) VALUES
(1, 'Student'),
(2, 'Demonstrator'),
(5, 'Assistance Lecturer'),
(6, 'Course Coordinator'),
(9, 'Lecturer'),
(15, 'Department Head'),
(60, 'ITU Admin'),
(130, 'Deans Office'),
(134, 'Dean'),
(136, 'Registrar'),
(138, 'Examination Branch (SCR) (Registration)'),
(140, 'Examination Branch (SCR) (Exams)'),
(144, 'VC'),
(145, 'Admin'),
(150, 'Super Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliation`
--
ALTER TABLE `affiliation`
  ADD PRIMARY KEY (`AffiliationID`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`AuditLogID`),
  ADD KEY `DocumentID` (`DocumentID`),
  ADD KEY `ApproverID` (`ReviewerID`),
  ADD KEY `AuditStateID` (`AuditStateID`);

--
-- Indexes for table `audit_state`
--
ALTER TABLE `audit_state`
  ADD PRIMARY KEY (`AuditStateID`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`DocumentID`),
  ADD KEY `DocTypeID` (`DocTypeID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `DocumentHierarchyID` (`DocumentHierarchyID`),
  ADD KEY `DocumentStatusID` (`DocumentStatusID`);

--
-- Indexes for table `documents_types`
--
ALTER TABLE `documents_types`
  ADD PRIMARY KEY (`DocTypeID`);

--
-- Indexes for table `document_hierarchy`
--
ALTER TABLE `document_hierarchy`
  ADD PRIMARY KEY (`DocumentHierarchyID`),
  ADD KEY `DocumentTypeID` (`DocumentTypeID`),
  ADD KEY `UserTypeID` (`UserTypeID`);

--
-- Indexes for table `document_state`
--
ALTER TABLE `document_state`
  ADD PRIMARY KEY (`DocumentStatusID`);

--
-- Indexes for table `document_versions`
--
ALTER TABLE `document_versions`
  ADD PRIMARY KEY (`VersionID`),
  ADD KEY `DocumentID` (`DocumentID`),
  ADD KEY `DocTypeID` (`DocTypeID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `DocumentHierarchyID` (`DocumentHierarchyID`),
  ADD KEY `DocumentStatusID` (`DocumentStatusID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`email`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD KEY `RoleID` (`UserTypesID`),
  ADD KEY `AffiliationID` (`AffiliationID`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`UserTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliation`
--
ALTER TABLE `affiliation`
  MODIFY `AffiliationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `AuditLogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `audit_state`
--
ALTER TABLE `audit_state`
  MODIFY `AuditStateID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `DocumentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `documents_types`
--
ALTER TABLE `documents_types`
  MODIFY `DocTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `document_hierarchy`
--
ALTER TABLE `document_hierarchy`
  MODIFY `DocumentHierarchyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `document_state`
--
ALTER TABLE `document_state`
  MODIFY `DocumentStatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `document_versions`
--
ALTER TABLE `document_versions`
  MODIFY `VersionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1437731436;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `UserTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`DocumentID`) REFERENCES `documents` (`DocumentID`),
  ADD CONSTRAINT `audit_log_ibfk_2` FOREIGN KEY (`ReviewerID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `audit_log_ibfk_3` FOREIGN KEY (`AuditStateID`) REFERENCES `audit_state` (`AuditStateID`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`DocTypeID`) REFERENCES `documents_types` (`DocTypeID`),
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `documents_ibfk_3` FOREIGN KEY (`DocumentHierarchyID`) REFERENCES `document_hierarchy` (`DocumentHierarchyID`),
  ADD CONSTRAINT `documents_ibfk_4` FOREIGN KEY (`DocumentStatusID`) REFERENCES `document_state` (`DocumentStatusID`);

--
-- Constraints for table `document_hierarchy`
--
ALTER TABLE `document_hierarchy`
  ADD CONSTRAINT `document_hierarchy_ibfk_1` FOREIGN KEY (`DocumentTypeID`) REFERENCES `documents_types` (`DocTypeID`),
  ADD CONSTRAINT `document_hierarchy_ibfk_2` FOREIGN KEY (`UserTypeID`) REFERENCES `user_type` (`UserTypeID`);

--
-- Constraints for table `document_versions`
--
ALTER TABLE `document_versions`
  ADD CONSTRAINT `document_versions_ibfk_1` FOREIGN KEY (`DocumentID`) REFERENCES `documents` (`DocumentID`),
  ADD CONSTRAINT `document_versions_ibfk_2` FOREIGN KEY (`DocTypeID`) REFERENCES `documents_types` (`DocTypeID`),
  ADD CONSTRAINT `document_versions_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `document_versions_ibfk_4` FOREIGN KEY (`DocumentHierarchyID`) REFERENCES `document_hierarchy` (`DocumentHierarchyID`),
  ADD CONSTRAINT `document_versions_ibfk_5` FOREIGN KEY (`DocumentStatusID`) REFERENCES `document_state` (`DocumentStatusID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`AffiliationID`) REFERENCES `affiliation` (`AffiliationID`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`UserTypesID`) REFERENCES `user_type` (`UserTypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
