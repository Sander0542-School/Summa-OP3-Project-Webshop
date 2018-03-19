-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 19 mrt 2018 om 16:37
-- Serverversie: 10.1.26-MariaDB
-- PHP-versie: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_webshop`
--
CREATE DATABASE IF NOT EXISTS `web_webshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_webshop`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `street` varchar(50) NOT NULL,
  `houseNumber` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceEach` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `ordertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `actionPrice` int(11) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `colors` set('Zwart','Groen','Roze','Wit') NOT NULL,
  `imagePath` varchar(250) NOT NULL,
  `model` enum('Dames','Heren','Dames/Lage Instap') NOT NULL,
  `modelYear` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `price`, `actionPrice`, `description`, `colors`, `imagePath`, `model`, `modelYear`) VALUES
(1, 'Diva Plus Transportfiets\r\n', 'Batavus', 799, 679, NULL, 'Groen,Roze,Wit', '/assets/images/Diva Plus Transportfiets.jpg', 'Dames/Lage Instap', 2018),
(2, 'Wayz\r\n', 'Batavus', 799, 669, NULL, 'Groen', '/assets/images/Wayz.jpg', 'Dames', 2018),
(3, 'Esprit C\r\n', 'Gazelle', 449, 359, NULL, 'Zwart', '/assets/images/Esprit C.jpg', 'Heren', 2018),
(4, 'Orange C7+ HMB\r\n', 'Gazelle', 2549, 1986, NULL, 'Zwart', '/assets/images/Orange C7+ HMB.png', 'Dames', 2018);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

--
-- Indexen voor tabel `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_orderDetails_orders` (`orderID`),
  ADD KEY `foreign_orderDetails_products` (`productID`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_orders_customers` (`customerID`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `foreign_orderDetails_orders` FOREIGN KEY (`orderID`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `foreign_orderDetails_products` FOREIGN KEY (`productID`) REFERENCES `products` (`id`);

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `foreign_orders_customers` FOREIGN KEY (`customerID`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
