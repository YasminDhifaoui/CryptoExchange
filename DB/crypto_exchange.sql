-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2024 at 06:56 PM
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
(5, 'admin1', 'admin1@gmail.com', '$2y$10$A0lBkyPaBGXpDDJpXCLKdeQdNQ7.7ZMJx.qAbCEPO3.17K5m4zINK', '2024-07-08 17:13:37'),
(7, 'admin2', 'yasmingargouri04@gmail.com', '$2y$10$Si6QKgj66T1i8EP3uy361ON.HOUoS7XksVH2c85po9.GTgHe5l65K', '2024-07-22 21:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `currency_symbol` varchar(100) NOT NULL,
  `balance` double(19,8) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`id`, `user_id`, `currency_id`, `currency_symbol`, `balance`, `date`, `note`) VALUES
(6, 38, 1, 'BTC', 1000.00000000, '2024-08-12 14:20:55', 'first credit'),
(7, 38, 4, 'VET', 2000.00000000, '2024-08-12 14:22:55', 'second credit');

-- --------------------------------------------------------

--
-- Table structure for table `cryptocoin`
--

CREATE TABLE `cryptocoin` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `user_id` varchar(55) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `symbol` varchar(100) NOT NULL,
  `decimal_value` varchar(55) DEFAULT NULL,
  `coin_name` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `algorithm` varchar(100) DEFAULT NULL,
  `proof_type` varchar(100) DEFAULT NULL,
  `show_home` int(11) DEFAULT 0,
  `coin_position` int(11) DEFAULT 0,
  `premined_value` varchar(100) DEFAULT NULL,
  `total_coins_freefloat` varchar(100) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `sponsored` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cryptocoin`
--

INSERT INTO `cryptocoin` (`id`, `cid`, `user_id`, `url`, `image`, `name`, `symbol`, `decimal_value`, `coin_name`, `full_name`, `algorithm`, `proof_type`, `show_home`, `coin_position`, `premined_value`, `total_coins_freefloat`, `rank`, `sponsored`, `status`) VALUES
(1, 0, NULL, 'https://www.bitcoin.org', '../uploads/cryptocurrencies/Bitcoin_image.webp', 'Bitcoin', 'BTC', '8', 'bitcoin', 'Bitcoin', 'SHA-256', 'crypto', 0, 1, '0', '19000000', 1, '0', 1),
(2, 0, NULL, 'https://www.ethereum.org', '../uploads/cryptocurrencies/Ethereum_image.webp', 'Ethereum', 'ETH', '18', 'ethereum', 'Ethereum', 'Ethash', 'crypto', NULL, 2, '0', '114000000', 2, '0', 0),
(3, 0, NULL, 'https://www.litecoin.org', '../uploads/cryptocurrencies/Litecoin_image.webp', 'Litecoin', 'LTC', '8', 'litecoin', 'Litecoin', 'Scrypt', 'crypto', NULL, 3, '0', '84000000', 3, '0', 0),
(4, 0, NULL, 'https://www.vechain.org', '../uploads/cryptocurrencies/VeChain_image.webp', 'VeChain', 'VET', '18', 'vechain', 'VeChain', 'PoA', 'crypto', NULL, 4, '0', '86712634466', 4, '0', 1),
(13, 0, NULL, NULL, '../uploads/cryptocurrencies/USD_image.webp', 'USD', 'USD', '3.01', 'Dollar', 'Dollar', NULL, 'fiat', 1, 0, NULL, NULL, 99, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `currency_symbol` varchar(100) NOT NULL COMMENT 'This will store the coin symbol for crypto deposits or currency symbol for fiat deposits',
  `amount` double(19,8) NOT NULL,
  `method_id` varchar(50) NOT NULL,
  `fees_amount` double(19,8) NOT NULL,
  `comment` mediumtext DEFAULT NULL,
  `deposit_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=Pending, 1=Gas Fee Sent, 2=User to Admin Transfer, 3=Deposit Success, 4=Cancel',
  `deposit_type` enum('crypto','fiat') NOT NULL COMMENT 'crypto or fiat deposit',
  `payment_gateway` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `user_id`, `currency_id`, `currency_symbol`, `amount`, `method_id`, `fees_amount`, `comment`, `deposit_date`, `status`, `deposit_type`, `payment_gateway`) VALUES
(99, 47, NULL, 'FIAT', 2222.00000000, '1', 0.00000000, NULL, '2024-08-21 13:18:41', 0, 'crypto', ''),
(100, 47, NULL, 'FIAT', 2000.00000000, '1', 0.00000000, NULL, '2024-08-21 13:26:52', 0, 'crypto', 'bank_transfer'),
(101, 47, NULL, 'FIAT', 0.00000000, '1', 0.00000000, NULL, '2024-08-21 13:29:36', 0, 'crypto', 'paypal'),
(102, 47, NULL, 'BTC', 4.00000000, '1', 0.00000000, NULL, '2024-08-21 13:34:16', 0, 'crypto', 'paypal'),
(103, 47, NULL, 'USD', 4.00000000, '1', 0.00000000, NULL, '2024-08-21 13:38:10', 0, 'crypto', 'paypal'),
(104, 47, NULL, 'BTC', 11.00000000, '1', 0.00000000, NULL, '2024-08-21 13:43:48', 0, 'crypto', 'paypal'),
(105, 47, NULL, 'VET', 777777777.00000000, '1', 0.00000000, NULL, '2024-08-21 13:44:41', 0, 'crypto', 'crypto_wallet'),
(106, 47, NULL, 'FIAT', 0.00000000, '1', 0.00000000, NULL, '2024-08-21 13:44:55', 0, 'crypto', 'paypal'),
(107, 47, NULL, 'FIAT', 99.00000000, '1', 0.00000000, NULL, '2024-08-21 13:45:18', 0, 'crypto', 'paypal'),
(108, 47, NULL, 'BTC', 33.00000000, '1', 0.00000000, NULL, '2024-08-21 14:09:02', 0, 'crypto', 'paypal'),
(109, 47, NULL, 'USD', 5.00000000, '1', 0.00000000, NULL, '2024-08-21 14:09:38', 0, 'crypto', 'paypal');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_methods`
--

CREATE TABLE `deposit_methods` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit_methods`
--

INSERT INTO `deposit_methods` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `market`
--

CREATE TABLE `market` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `symbol` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `market`
--

INSERT INTO `market` (`id`, `name`, `full_name`, `symbol`, `status`) VALUES
(1, 'Coinbase', 'Coinbase Global', 'BTC', 1),
(2, 'Binance', 'Binance Exchange', 'ETH', 1),
(3, 'Kraken', 'Kraken Exchange', 'LTC', 1),
(4, 'Bittrex', 'Bittrex International', 'LTC', 0),
(5, 'KuCoin', 'KuCoin Exchange', 'VET', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `status`, `created_at`) VALUES
(1, 47, 'Your verification request has been accepted.', 'read', '2024-08-10 12:40:52'),
(2, 34, 'Your verification request has been refused.', 'read', '2024-08-10 12:59:00'),
(3, 34, 'Your verification request has been refused.', 'read', '2024-08-10 13:04:10'),
(4, 34, 'Your verification request has been accepted.', 'read', '2024-08-12 12:07:58');

-- --------------------------------------------------------

--
-- Table structure for table `pair_coin`
--

CREATE TABLE `pair_coin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `market_name` varchar(100) NOT NULL,
  `cryptocoin_name` varchar(100) NOT NULL,
  `initial_price` decimal(18,8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pair_coin`
--

INSERT INTO `pair_coin` (`id`, `name`, `fullname`, `market_name`, `cryptocoin_name`, `initial_price`, `status`) VALUES
(1, 'zz', 'zzz', 'Coinbase', 'VeChain', 1.20000000, 1),
(2, 'BTC/USD', 'Bitcoin/US Dollar', 'Binance', 'Bitcoin', 30000.00000000, 1),
(3, 'ETH/USD', 'Ethereum/US Dollar', 'Coinbase', 'VeChain', 2000.00000000, 0),
(4, 'LTC/BTC', 'Litecoin/Bitcoin', 'Binance', 'Litecoin', 0.00500000, 1);

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
(34, 'aaaa', '', 'Raslendhifaoui1@gmail.com', '$2y$10$sXhy.dkP.IaIv.VdcgaLlu1UO1BKfw/1iVvtQq.E8nUPgciu7fzTi', 1, 'active', '2024-07-02 16:40:37', 'd2eaee2ce8c98e7f08a5434d4f202881', 0, '299114'),
(38, 'yassine', '', 'med.yassine.bouneb@proton.me', '$2y$10$.cnIM3/BS9ajmYVjpr2S0OScKyTrpnn3ra5mLEgpgYN0KoXK/G9cq', 0, 'inactive', '2024-07-07 19:33:19', '67363f400413d473eacadb55f50a3861', 1, ''),
(47, 'yasmin', '', 'yasmingargouri04@gmail.com', '$2y$10$HE6fu3K1rZcQkHcOMQJR9.Ps/DPdr8EoqOpznYTyiT61zD/QNr9i6', 1, 'active', '2024-07-13 13:06:44', '41e5dad77dcea5354cb10e58dcf6256426510c077a612f7f75ca493db63e2b9a', 0, '338953'),
(49, 'ahmed', '', 'midou.jrad2001@gmail.com', '$2y$10$dAqYtVUMeM3mALglNnveKusErvMDqZ6waavM68hvUBjNM3.xnNNiC', 1, 'active', '2024-08-08 12:03:52', '9c45c191dc7d20ad76bbcc823f52014d29e83c004afd9567ac840600a9b53d53', 0, '952954');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `log_id` int(11) NOT NULL,
  `log_type` varchar(50) NOT NULL COMMENT '"acc_update = User Account Update, login=User Login info, deposit=User Deposit info, transfer=User Transfer info, withdraw=User Withdraw info, open_order="',
  `access_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_agent` varchar(300) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`log_id`, `log_type`, `access_time`, `user_agent`, `user_email`, `ip`) VALUES
(1, 'login', '2024-08-21 17:02:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'yasmingargouri04@gmail.com', '::1'),
(2, 'login', '2024-08-21 17:08:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'yasmingargouri04@gmail.com', '::1'),
(3, 'login', '2024-08-21 17:15:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'yasmingargouri04@gmail.com', '::1'),
(4, 'login', '2024-08-21 17:21:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'yasmingargouri04@gmail.com', '0.0.0.0'),
(5, 'login', '2024-08-21 17:31:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'yasmingargouri04@gmail.com', '0.0.0.0'),
(6, 'login', '2024-08-21 17:33:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'yasmingargouri04@gmail.com', '127.0.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

CREATE TABLE `verifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cin` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `cinpic` varchar(255) NOT NULL,
  `verif_status` varchar(50) NOT NULL DEFAULT 'not verified',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verifications`
--

INSERT INTO `verifications` (`id`, `user_id`, `cin`, `first_name`, `last_name`, `cinpic`, `verif_status`, `created_at`) VALUES
(1, 34, '0011223344', 'ras', 'len', '34_cin.jpg', 'Accepted', '2024-08-10 11:49:34'),
(2, 34, '0011223344', 'ras', 'l', '34_cin.jpg', 'Accepted', '2024-08-10 12:11:20'),
(3, 34, '0011223344', 'aa', 'aa', '34_cin.jpg', 'Accepted', '2024-08-10 12:16:29'),
(4, 34, '00', '00', '00', '34_cin.jpg', 'Accepted', '2024-08-10 12:23:28'),
(5, 34, 'bb', 'bb', 'bb', '34_cin.jpg', 'Accepted', '2024-08-10 12:25:59'),
(6, 34, 'bb', 'bb', 'bb', '34_cin.jpg', 'Accepted', '2024-08-10 12:35:43'),
(7, 47, '1111111111', 'yas', 'min', '47_cin.jpg', 'Accepted', '2024-08-10 12:38:06'),
(8, 34, '00', 'ras', 'len', '34_cin.jpg', 'Accepted', '2024-08-10 12:58:26'),
(9, 34, 'bb', 'vv', 'vv', '34_cin.jpg', 'Accepted', '2024-08-10 13:04:03'),
(10, 34, '0011223344', 'ras', 'len', '34_cin.jpg', 'Accepted', '2024-08-12 12:07:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idUser` (`user_id`),
  ADD KEY `fk_idcrypto` (`currency_id`);

--
-- Indexes for table `cryptocoin`
--
ALTER TABLE `cryptocoin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_symbol` (`symbol`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_currency_id` (`currency_id`);

--
-- Indexes for table `deposit_methods`
--
ALTER TABLE `deposit_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `market`
--
ALTER TABLE `market`
  ADD PRIMARY KEY (`id`),
  ADD KEY `symbol` (`symbol`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pair_coin`
--
ALTER TABLE `pair_coin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cryptocoin`
--
ALTER TABLE `cryptocoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `deposit_methods`
--
ALTER TABLE `deposit_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `market`
--
ALTER TABLE `market`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pair_coin`
--
ALTER TABLE `pair_coin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balance`
--
ALTER TABLE `balance`
  ADD CONSTRAINT `fk_idUser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_idcrypto` FOREIGN KEY (`currency_id`) REFERENCES `cryptocoin` (`id`);

--
-- Constraints for table `deposit`
--
ALTER TABLE `deposit`
  ADD CONSTRAINT `fk_currency_id` FOREIGN KEY (`currency_id`) REFERENCES `cryptocoin` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `market`
--
ALTER TABLE `market`
  ADD CONSTRAINT `market_ibfk_1` FOREIGN KEY (`symbol`) REFERENCES `cryptocoin` (`symbol`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `verifications`
--
ALTER TABLE `verifications`
  ADD CONSTRAINT `verifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
