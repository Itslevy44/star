-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 11:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `Star`

-- --------------------------------------------------------

-- Table structure for table `admins`
CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  admin_name varchar(255) NOT NULL,
  `admin_email` varchar(60) NOT NULL,
  `admin_pass` varchar(60) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `admins`
INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_pass`, `role`) VALUES
(1, 'Levy', 'kiprotichlevy0@gmail.com', 'metadrop24', 1);

-- --------------------------------------------------------

-- Table structure for table `machines`
CREATE TABLE `machines` (
  `machine_id` int(255) NOT NULL AUTO_INCREMENT,
  `machine_name` varchar(200) NOT NULL,
  `machine_price` int(255) NOT NULL,
  `machine_des` varchar(250) NOT NULL,
  `machine_type` varchar(200) NOT NULL,
  `machine_revenue` int(255) NOT NULL,
  `machine_duration` int(200) NOT NULL,
  `machine_status` varchar(200) NOT NULL,
  PRIMARY KEY (`machine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `machines`
INSERT INTO `machines` (`machine_id`, `machine_name`, `machine_price`, `machine_des`, `machine_type`, `machine_revenue`, `machine_duration`, `machine_status`) VALUES
(1, 'Starter miner', 500, 'Low performance mining machine.', 'regular', 600, 30, 'active'),
(2, 'Basic miner', 1000, 'Medium performance mining machine.', 'regular', 1200, 30, 'active'),
(3, 'Advanced miner', 2500, 'High performance mining machine.', 'regular', 3000, 30, 'active'),
(4, 'Pro miner', 4500, 'High performance mining machine.', 'regular', 5100, 30, 'active'),
(5, 'Elite miner', 10000, 'Premium performance mining machine.', 'regular', 12000, 30, 'active'),
(6, 'Advanced Lock Machine 1', 20000, 'Lock for 50 days to earn your reward.', 'advanced', 25000, 50, 'active'),
(7, 'Advanced Lock Machine 2', 40000, 'Lock for 50 days to earn your reward.', 'advanced', 50000, 50, 'active'),
(8, 'Advanced Lock Machine 3', 100000, 'Lock for 50 days to earn your reward.', 'advanced', 130000, 50, 'active');

-- --------------------------------------------------------

-- Table structure for table `users`
CREATE TABLE `users` (
  `user_id` int(6) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_phoneno` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `users`
INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_phoneno`, `created_at`, `modified_at`) VALUES
(1, 'Vincent', 'vincentkoech95@gmail.com', '11223344', '0701246798', '2023-08-21 13:38:23', '2023-08-21 13:38:23'),
(2, 'Mary', 'marywangechi01@gmail.com', '091827', '0111246798', '2023-08-21 13:38:23', '2024-08-21 13:38:23'),
(3, 'Anntonette', 'wanguikoi@gmail.com', 'qwerty01234', '0716847323', '2023-08-21 18:56:24', '2023-08-21 18:56:24'),
(4, 'Levy', 'kiprotichlevy0@gmail.com', '123987', '0795959596', '2023-12-01 11:20:17', '2023-12-01 11:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance`(
    `user_id` int(11) NOT NULL,
    `transaction_id` int(11) NOT NULL,
    `balance_id` int(11) NOT NULL,
    `account_balance` int(11) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`user_id`, `transaction_id`, `balance_id`,`account_balance`) VALUES
(1, '001', '001', '500');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit`(
    `Transaction_id` int(11) NOT NULL,
    `user_id` varchar(255) NOT NULL,
    `balance_id` int(11) NOT NULL,
    `Amount` varchar(11) NOT NULL,
    `MpesaCode` varchar(100) NOT NULL,
    `TransactionDate` date DEFAULT current_date(),
    `PhoneNumber` varchar(11) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`Transaction_id`, `user_id`, `balance_id`, `Amount`, `MpesaCode`, `TransactionDate`, `PhoneNumber`) 
VALUES (1, '001', '001', 500, 'SK72WV42MQ', '2024-11-07', '0796174057');


-- --------------------------------------------------------
-- Table structure for table `withdrawal_requests`

CREATE TABLE `withdrawal_requests` (
    `WithdrawalID` int(11) NOT NULL,
    `Amount` int(11) NOT NULL,
    `Phone` varchar(11) NOT NULL,
    `WithdrawalRequestID` varchar(255) NOT NULL,
    `request_date` date DEFAULT current_date()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `withdrawal_requests`

INSERT INTO `withdrawal_requests` (`WithdrawalID`, `Amount`, `Phone`, `WithdrawalRequestID`, `request_date`)
VALUES (1, 500, '0796174057', '002', '2024-11-07');

-- --------------------------------------------------------

-- Indexes for table `withdrawal_requests`

ALTER TABLE `withdrawal_requests`
  ADD PRIMARY KEY (`WithdrawalID`);

-- AUTO_INCREMENT for table `withdrawal_requests`

ALTER TABLE `withdrawal_requests`
  MODIFY `WithdrawalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--

ALTER TABLE `balance`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `deposit`
--

ALTER TABLE `deposit`
  ADD PRIMARY KEY (`Transaction_id`);

--
-- AUTO_INCREMENT for table `balance`
--

ALTER TABLE `balance`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- ------------------------------------------------
--
--
-- AUTO_INCREMENT for table `deposit`
--

ALTER TABLE `deposit`
  MODIFY `Transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- ------------------------------------------------
--
-- Ensure proper indexes
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `machines`
  MODIFY `machine_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `users`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

COMMIT;
