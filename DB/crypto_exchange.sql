-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2024 at 09:10 PM
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
-- Database: `crypto_exchange`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(5, 'admin', 'admin@gmail.com', '$2y$10$A0lBkyPaBGXpDDJpXCLKdeQdNQ7.7ZMJx.qAbCEPO3.17K5m4zINK', '2024-07-08 17:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `CurrencyID` int(11) NOT NULL,
  `CurrencyName` varchar(255) NOT NULL,
  `CurrencySymbol` varchar(10) NOT NULL,
  `BlockchainNetwork` varchar(255) NOT NULL,
  `DecimalPlaces` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`CurrencyID`, `CurrencyName`, `CurrencySymbol`, `BlockchainNetwork`, `DecimalPlaces`) VALUES
(1, 'Bitcoin', 'BTC', 'Bitcoin', 8),
(2, 'Ethereum', 'ETH', 'Ethereum', 18),
(3, 'Litecoin', 'LTC', 'Litecoin', 8),
(4, 'Ripple', 'XRP', 'Ripple', 6),
(5, 'Cardano', 'ADA', 'Cardano', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_enabled` tinyint(1) DEFAULT 0,
  `status` varchar(20) DEFAULT 'inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_token` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `two_factor_code` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `lastName`, `email`, `password`, `two_factor_enabled`, `status`, `created_at`, `verification_token`, `is_active`, `two_factor_code`) VALUES
(34, 'aaaa', '', 'Raslendhifaoui1@gmail.com', '$2y$10$sXhy.dkP.IaIv.VdcgaLlu1UO1BKfw/1iVvtQq.E8nUPgciu7fzTi', 0, 'active', '2024-07-02 16:40:37', 'd2eaee2ce8c98e7f08a5434d4f202881', 0, '770246'),
(35, 'bbbb', '', 'user@gmail.com', '$2y$10$.z4ELwu65s1F5HGGQV0oSeF7tDnVs.Zv4MTt/0SxZKEToM0RfjuXi', 0, 'active', '2024-07-04 21:31:03', '91dc3a01c28b15b3eae0462344d10292', 0, '696314'),
(38, 'yassine', '', 'med.yassine.bouneb@proton.me', '$2y$10$.cnIM3/BS9ajmYVjpr2S0OScKyTrpnn3ra5mLEgpgYN0KoXK/G9cq', 0, 'inactive', '2024-07-07 19:33:19', '67363f400413d473eacadb55f50a3861', 1, ''),
(47, 'yasmin', '', 'yasmingargouri04@gmail.com', '$2y$10$S49hKQ/IF9lUX3q4SncdmO1RI.DMpVOx9WrjvqBNJyv2z8b6oxZbW', 1, 'active', '2024-07-13 13:06:44', '41e5dad77dcea5354cb10e58dcf6256426510c077a612f7f75ca493db63e2b9a', 0, '255781');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `WalletID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `WalletName` varchar(255) DEFAULT NULL,
  `Address` varchar(255) NOT NULL,
  `PublicKey` varchar(255) NOT NULL,
  `EncryptedPrivateKey` text NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `CurrencyID` int(11) DEFAULT NULL,
  `Balance` decimal(20,8) DEFAULT 0.00000000,
  `TwoFAEnabled` tinyint(1) DEFAULT 0,
  `TwoFASecret` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`WalletID`, `UserID`, `WalletName`, `Address`, `PublicKey`, `EncryptedPrivateKey`, `PasswordHash`, `CreationDate`, `CurrencyID`, `Balance`, `TwoFAEnabled`, `TwoFASecret`) VALUES
(1, 34, 'first wallet', '11223344aazzeerr', '1234azer', '1234', '123', '2024-07-04 20:55:19', 1, 0.00000000, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`CurrencyID`),
  ADD UNIQUE KEY `CurrencyName` (`CurrencyName`),
  ADD UNIQUE KEY `CurrencySymbol` (`CurrencySymbol`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`WalletID`),
  ADD UNIQUE KEY `Address` (`Address`),
  ADD UNIQUE KEY `PublicKey` (`PublicKey`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `CurrencyID` (`CurrencyID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `CurrencyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `WalletID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wallets_ibfk_2` FOREIGN KEY (`CurrencyID`) REFERENCES `currency` (`CurrencyID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
