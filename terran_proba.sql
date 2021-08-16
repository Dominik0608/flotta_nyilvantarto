-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3307
-- Létrehozás ideje: 2021. Aug 16. 16:15
-- Kiszolgáló verziója: 10.4.13-MariaDB
-- PHP verzió: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `terran_proba`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `admin`, `status`) VALUES
(1, 'Admin', 'admin@admin.hu', '$2y$10$qTfQlTDdE6GaBGzFg3aeSOLYM33d7gL7C7xUBNnSIadgcMU1gAXbC', '1232', 1, 1),
(4, 'User', 'user@user.hu', '$2y$10$5BkAuolX21KYpMk3ht3LjOqdz.87vYYzKJLQMxa4bUmx7UhnGmELy', '123456', 0, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `brand` varchar(30) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `plate` varchar(10) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `year` smallint(4) NOT NULL,
  `mileage` mediumint(9) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user` smallint(6) NOT NULL DEFAULT -1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `vehicles`
--

INSERT INTO `vehicles` (`id`, `brand`, `plate`, `year`, `mileage`, `status`, `user`) VALUES
(9, 'teszt', 'plateteszt', 1111, 123555, 0, 1),
(3, 'Második', '123', 1233, 123, 1, 1),
(4, 'aa', '123', 1233, 123422, 0, 2),
(5, 'bbb', 'qew', 312, 123, 1, 1),
(6, 'a', 'a', 1233, 123, 1, 1),
(8, 'Második', '123', 1233, 123, 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
