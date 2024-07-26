-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2024 at 12:24 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(5, 'admin1', 'admin1@gmail.com', '$2y$10$A0lBkyPaBGXpDDJpXCLKdeQdNQ7.7ZMJx.qAbCEPO3.17K5m4zINK', '2024-07-08 17:13:37'),
(7, 'admin2', 'yasmingargouri04@gmail.com', '$2y$10$Si6QKgj66T1i8EP3uy361ON.HOUoS7XksVH2c85po9.GTgHe5l65K', '2024-07-22 21:22:02');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cryptocoin`
--

INSERT INTO `cryptocoin` (`id`, `cid`, `user_id`, `url`, `image`, `name`, `symbol`, `decimal_value`, `coin_name`, `full_name`, `algorithm`, `proof_type`, `show_home`, `coin_position`, `premined_value`, `total_coins_freefloat`, `rank`, `sponsored`, `status`) VALUES
(1, 0, NULL, 'https://www.bitcoin.org', '../uploads/bitcoin.webp', 'Bitcoin', 'BTC', '8', 'bitcoin', 'Bitcoin', 'SHA-256', 'local_coin', NULL, 1, '0', '19000000', 1, '0', 0),
(2, 0, NULL, 'https://www.ethereum.org', '../uploads/ethereum.webp', 'Ethereum', 'ETH', '18', 'ethereum', 'Ethereum', 'Ethash', 'fiat_currency', NULL, 2, '0', '114000000', 2, '0', 0),
(3, 0, NULL, 'https://www.litecoin.org', '../uploads/litecoin.webp', 'Litecoin', 'LTC', '8', 'litecoin', 'Litecoin', 'Scrypt', 'local_coin', NULL, 3, '0', '84000000', 3, '0', 0),
(4, 0, NULL, 'https://www.vechain.org', '../uploads/vechain.webp', 'VeChain', 'VET', '18', 'vechain', 'VeChain', 'PoA', 'local_coin', NULL, 4, '0', '86712634466', 4, '0', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `lastName`, `email`, `password`, `two_factor_enabled`, `status`, `created_at`, `verification_token`, `is_active`, `two_factor_code`) VALUES
(34, 'aaaa', '', 'Raslendhifaoui1@gmail.com', '$2y$10$sXhy.dkP.IaIv.VdcgaLlu1UO1BKfw/1iVvtQq.E8nUPgciu7fzTi', 0, 'active', '2024-07-02 16:40:37', 'd2eaee2ce8c98e7f08a5434d4f202881', 0, '770246'),
(38, 'yassine', '', 'med.yassine.bouneb@proton.me', '$2y$10$.cnIM3/BS9ajmYVjpr2S0OScKyTrpnn3ra5mLEgpgYN0KoXK/G9cq', 0, 'inactive', '2024-07-07 19:33:19', '67363f400413d473eacadb55f50a3861', 1, ''),
(47, 'yasmin', '', 'yasmingargouri04@gmail.com', '$2y$10$S49hKQ/IF9lUX3q4SncdmO1RI.DMpVOx9WrjvqBNJyv2z8b6oxZbW', 1, 'active', '2024-07-13 13:06:44', '41e5dad77dcea5354cb10e58dcf6256426510c077a612f7f75ca493db63e2b9a', 0, '824987'),
(48, 'user', 'new', 'yasmingargouri04@gmail.com', '$2y$10$TjcfCtImMLcnqgv9Xi9FQejIUKqPJUiE5ZZeg1ZqTRviRorQZOKZG', 0, 'inactive', '2024-07-17 16:34:38', NULL, 1, '824987');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cryptocoin`
--
ALTER TABLE `cryptocoin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_symbol` (`symbol`);

--
-- Indexes for table `market`
--
ALTER TABLE `market`
  ADD PRIMARY KEY (`id`),
  ADD KEY `symbol` (`symbol`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cryptocoin`
--
ALTER TABLE `cryptocoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `market`
--
ALTER TABLE `market`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `market`
--
ALTER TABLE `market`
  ADD CONSTRAINT `market_ibfk_1` FOREIGN KEY (`symbol`) REFERENCES `cryptocoin` (`symbol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
