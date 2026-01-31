-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 02:50 PM
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
-- Database: `mycustomdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `evaluationrequests`
--

CREATE TABLE `evaluationrequests` (
  `ID` int(11) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `Details` text NOT NULL,
  `ContactMethod` enum('email','phone') NOT NULL,
  `PhotoPath` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluationrequests`
--

INSERT INTO `evaluationrequests` (`ID`, `UserEmail`, `Details`, `ContactMethod`, `PhotoPath`, `CreatedAt`) VALUES
(1, 'arsn2k', 'photo', 'phone', 'uploads/download.jpg', '2024-12-10 20:55:15'),
(2, 'arsn2k', 'here is some i found that lookes old\r\n', 'email', 'uploads/IMG_9854.JPG', '2024-12-11 14:32:21'),
(3, 'kimi', 'old canvas', 'email', 'uploads/IMG_9854.JPG', '2024-12-11 21:49:45'),
(4, 'arsn2k', 'yewe', 'phone', 'uploads/mtn.jpg', '2024-12-11 21:52:44');

-- --------------------------------------------------------

--
-- Table structure for table `systemuser`
--

CREATE TABLE `systemuser` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ResetToken` varchar(64) DEFAULT NULL,
  `ResetExpires` datetime DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `Role` enum('user','admin') DEFAULT 'user',
  `SecurityQuestion` varchar(255) NOT NULL,
  `SecurityAnswer` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL,
  `TwoFactorPin` varchar(6) DEFAULT NULL,
  `TwoFactorExpires` datetime DEFAULT NULL,
  `FailedAttempts` int(11) DEFAULT 0,
  `LockoutUntil` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `systemuser`
--

INSERT INTO `systemuser` (`ID`, `Name`, `Email`, `Phone`, `Username`, `Password`, `ResetToken`, `ResetExpires`, `CreatedAt`, `reset_token_hash`, `reset_token_expires_at`, `Role`, `SecurityQuestion`, `SecurityAnswer`, `is_verified`, `verification_token`, `TwoFactorPin`, `TwoFactorExpires`, `FailedAttempts`, `LockoutUntil`) VALUES
(1, 'John Doe', 'johndoe@example.com', '1234567890', 'johndoe', 'Test@1234', NULL, NULL, '2024-12-02 12:30:27', NULL, NULL, 'user', '', '', 0, NULL, NULL, NULL, 0, NULL),
(6, 'jacob', 'emailjack@gmail.com', '07471876167', 'jack', '$2y$10$f4V6OxB3i.VRi0fOOjqIuujTzsOQPVEo8WJJzv2LDrA0HLle8Otzu', NULL, NULL, '2024-12-10 18:46:32', NULL, NULL, 'user', '', '', 0, NULL, NULL, NULL, 0, NULL),
(8, 'chris', 'chrisikuzo@gmail.com', '08808088989', 'chris', '$2y$10$3cB4cdod1PnfzSBDfKoHaOIONYaySxvtvU7s3nqhMnc87i7O0aM8q', NULL, NULL, '2024-12-11 16:18:04', NULL, NULL, 'user', '', '', 0, NULL, NULL, NULL, 0, NULL),
(9, 'parfait', 'pardait@gmail.com', '09891306167', 'prft', '$2y$10$k/mdt7Ez86Pdau480gTm3uqfcJacl6VF4lea1NM/yrWFC6IyRhtLK', NULL, NULL, '2024-12-11 17:05:14', NULL, NULL, 'user', '', '', 0, NULL, NULL, NULL, 0, NULL),
(11, 'leila', 'leila@gmail.com', '8978798787', 'leila', '$2y$10$UO5OGFlsFASn2oXmMoY20OeMVF7LLvPcID91pl2.dlmXP6.RFNZEG', NULL, NULL, '2024-12-11 17:29:27', NULL, NULL, 'user', '', '', 0, NULL, NULL, NULL, 0, NULL),
(12, 'suzet', 'suzet@gmail.com', '883888', 'suzet', '$2y$10$T0WYAX1Pr9V3gwxl9UgMIeelXptGLIK8ot/v1TsfAGzcmENk8mtIq', NULL, NULL, '2024-12-11 19:47:01', NULL, NULL, 'user', '', '', 0, NULL, NULL, NULL, 0, NULL),
(13, 'kimi', 'kimi@gmail.com', '145356366', 'kimi', '$2y$10$IIy1W0MPIihsN.spviHbUOG2yzJZt4t6GtoWpdWfI6leJ4VRgS6vC', '88118b2544c678297f4436b908f15943', '2024-12-12 00:21:53', '2024-12-11 21:19:12', NULL, NULL, 'user', 'What is your mother’s maiden name?', '$2y$10$WfKSFZjI5k0wuc4Td.lHb.mQ0MNxi/23X4x8G53w9MC2iGsl6riRi', 0, NULL, '309993', '2024-12-12 06:29:27', 0, NULL),
(14, 'jacob', 'jacob@gmail.com', '674686484', 'jacob', '$2y$10$2qGxg0tJ6amL/2OH/cbqoe50lqxvnnKjKGOWKFfhbUnlfL96Nvbem', 'a4387a759074d899bc3dc09f372f7985', '2024-12-12 04:35:48', '2024-12-12 02:27:22', NULL, NULL, 'user', 'What is your mother’s maiden name?', '$2y$10$LElmjlfqq2TaPcseJAdyyunXv/F7bK1n3p9jSCdwgLey3TaVfDOYS', 1, NULL, NULL, NULL, 0, NULL),
(15, 'gedio', 'gidion@gmail.com', '07471306167', 'gedio', '$2y$10$w5ZDx/H6bK6.8E4z/9vp1.GWx775iaQgzChO8Mvm7WE13Sc0HTcdG', NULL, NULL, '2024-12-12 05:35:26', NULL, NULL, 'user', 'What is your mother’s maiden name?', '$2y$10$IdJd8DGj0pLiHEBslf0doesOCtJQhjrAYwCElG4.aU1JZCHPXaB9K', 0, NULL, '417103', '2024-12-12 06:41:39', 0, NULL),
(34, 'Arsene Intwali', 'arseneintwari2k@gmail.com', '07471306167', 'arsn2k', '$2y$10$sD2Ty9h5pxcoaOWwW5YOA.ZEQEcsg5S6RQffWkuSAsL29awH4bScW', NULL, NULL, '2024-12-12 07:44:00', NULL, NULL, 'user', 'What is your mother’s maiden name?', '$2y$10$EmIS77c9AZuOPd1cOPVf3ev2J5EAQU5UFrJpSRMTk2q0K37tTfOKi', 1, NULL, NULL, NULL, 0, NULL),
(35, 'peter', 'arseneplaystation4@gmail.com', '07471306167', 'peter', '$2y$10$Z58xbXHH06ajZEYuV4KEY.9trfs.WRc1Ysq01t03pB1wbt9iZLeYa', NULL, NULL, '2024-12-12 12:38:57', NULL, NULL, 'admin', 'What is your mother’s maiden name?', '$2y$10$B1P8AbbID1w0vLZGi1KeQO9UIyasjz7Ao3gfmWSOjPND3QDsZiXrq', 1, NULL, NULL, NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evaluationrequests`
--
ALTER TABLE `evaluationrequests`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `systemuser`
--
ALTER TABLE `systemuser`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD UNIQUE KEY `ResetToken` (`ResetToken`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluationrequests`
--
ALTER TABLE `evaluationrequests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `systemuser`
--
ALTER TABLE `systemuser`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
