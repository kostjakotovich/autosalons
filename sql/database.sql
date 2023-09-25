-- --------------------------------------------------------
-- Хост:                         localhost
-- Версия сервера:               8.0.30 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных mariadb
CREATE DATABASE IF NOT EXISTS `mariadb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mariadb`;

-- Дамп структуры для таблица mariadb.car_colors
CREATE TABLE IF NOT EXISTS `car_colors` (
  `colorID` int NOT NULL AUTO_INCREMENT,
  `offerID` int DEFAULT NULL,
  `color` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`colorID`),
  KEY `offerID` (`offerID`),
  CONSTRAINT `car_colors_ibfk_1` FOREIGN KEY (`offerID`) REFERENCES `offers` (`offerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы mariadb.car_colors: ~0 rows (приблизительно)
DELETE FROM `car_colors`;

-- Дамп структуры для таблица mariadb.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `commentID` int NOT NULL AUTO_INCREMENT,
  `comment` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=290 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.comments: ~8 rows (приблизительно)
DELETE FROM `comments`;
INSERT INTO `comments` (`commentID`, `comment`, `userID`, `date`) VALUES
	(252, 'Thanks!', 46, '2023-04-30'),
	(253, 'Very good!', 46, '2023-04-30'),
	(284, '', 48, '2023-05-03'),
	(285, '', 48, '2023-05-03'),
	(286, '', 48, '2023-05-03'),
	(287, '', 48, '2023-05-03'),
	(288, '', 48, '2023-05-03'),
	(289, '', 48, '2023-05-03');

-- Дамп структуры для таблица mariadb.offers
CREATE TABLE IF NOT EXISTS `offers` (
  `offerID` int NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_latvian_ci DEFAULT NULL,
  `manufacturer` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_latvian_ci DEFAULT NULL,
  `image` blob,
  PRIMARY KEY (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.offers: ~10 rows (приблизительно)
DELETE FROM `offers`;
INSERT INTO `offers` (`offerID`, `type`, `manufacturer`, `image`) VALUES
	(41, 'X5', 'BMW', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f58354d6f64656c496d6167652e6a7067),
	(42, 'Model Y', 'Tesla', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f63353337333266372d616331382d343330632d396430322d6537363033356135396366622e77656270),
	(44, 'Elantra', 'Hyundai', _binary 0x2e2e2f6175746f73616c6f6e732f696d672fd0b8d0b7d0bed0b1d180d0b0d0b6d0b5d0bdd0b8d0b55f323032332d30342d32395f3136353130353632372e706e67),
	(45, 'Arteon', 'Volkswagen', _binary 0x2e2e2f6175746f73616c6f6e732f696d672fd0b8d0b7d0bed0b1d180d0b0d0b6d0b5d0bdd0b8d0b55f323032332d30342d32395f3136353631383032372e706e67),
	(46, 'Kona', 'Hyundai', _binary 0x2e2e2f6175746f73616c6f6e732f696d672fd0b8d0b7d0bed0b1d180d0b0d0b6d0b5d0bdd0b8d0b55f323032332d30342d32395f3136353731393039312e706e67),
	(47, 'A6', 'Audi', _binary 0x2e2e2f6175746f73616c6f6e732f696d672fd0b8d0b7d0bed0b1d180d0b0d0b6d0b5d0bdd0b8d0b55f323032332d30342d32395f3136353834393530332e706e67),
	(48, 'i8', 'BMW', _binary 0x2e2e2f6175746f73616c6f6e732f696d672fd0b8d0b7d0bed0b1d180d0b0d0b6d0b5d0bdd0b8d0b55f323032332d30342d32395f3136353934393233322e706e67),
	(49, 'Aventador', 'Lamborghini', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f6c616d626f726768696e692e706e67),
	(50, 'G63 AMG', 'Mercedes-Benz', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f616d672e706e67),
	(51, 'F430', 'Ferrari', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f666572726172692e706e67);

-- Дамп структуры для таблица mariadb.offersinfo
CREATE TABLE IF NOT EXISTS `offersinfo` (
  `offersInfoID` int NOT NULL AUTO_INCREMENT,
  `color` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `price` float DEFAULT NULL,
  `yearOfManufacture` date DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `offersID` int DEFAULT NULL,
  PRIMARY KEY (`offersInfoID`),
  KEY `offersID` (`offersID`),
  CONSTRAINT `offersID` FOREIGN KEY (`offersID`) REFERENCES `offers` (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.offersinfo: ~10 rows (приблизительно)
DELETE FROM `offersinfo`;
INSERT INTO `offersinfo` (`offersInfoID`, `color`, `price`, `yearOfManufacture`, `weight`, `offersID`) VALUES
	(36, 'white', 20000, '2012-04-04', 2000, 41),
	(37, 'white', 2300, '2014-04-09', 2100, 42),
	(39, 'Red', 20950, '2020-04-06', 1800, 44),
	(40, 'Grey', 43000, '2018-01-10', 2000, 45),
	(41, 'White', 16000, '2021-02-17', 2400, 46),
	(42, 'Black', 19000, '2022-01-18', 1900, 47),
	(43, 'grey', 40000, '2022-01-01', 2000, 48),
	(44, 'white', 250000, '2011-05-01', 1500, 49),
	(45, 'White', 300000, '2015-05-12', 4100, 50),
	(46, 'Red', 135000, '2004-05-05', 1500, 51);

-- Дамп структуры для таблица mariadb.order
CREATE TABLE IF NOT EXISTS `order` (
  `orderID` int NOT NULL AUTO_INCREMENT,
  `orderDate` date DEFAULT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `surname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `orderUserID` int DEFAULT NULL,
  `orderOfferID` int DEFAULT NULL,
  PRIMARY KEY (`orderID`),
  KEY `orderUserID` (`orderUserID`) USING BTREE,
  KEY `orderOfferID` (`orderOfferID`),
  CONSTRAINT `orderOfferID` FOREIGN KEY (`orderOfferID`) REFERENCES `offers` (`offerID`),
  CONSTRAINT `orderUserID` FOREIGN KEY (`orderUserID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.order: ~4 rows (приблизительно)
DELETE FROM `order`;
INSERT INTO `order` (`orderID`, `orderDate`, `name`, `surname`, `telephone`, `status`, `orderUserID`, `orderOfferID`) VALUES
	(132, '2023-05-01', 'Kostja', 'hvj', 'ghj', 'In progress', 45, 41),
	(133, '2023-05-01', 'Kos', 'Kot', '2040', 'Done', 1, 44),
	(134, '2023-05-02', 'Nmae', 'sur', '342324', 'Done', 1, 41),
	(137, '2023-05-03', 'Kostja', 'Kotovich', '3424323', 'Done', 48, 42);

-- Дамп структуры для таблица mariadb.user
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `roleID` int NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.user: ~2 rows (приблизительно)
DELETE FROM `user`;
INSERT INTO `user` (`userID`, `username`, `email`, `password`, `roleID`) VALUES
	(1, 'stuff', 'stuff@example.com', 'stuff', 1),
	(44, '1', '1@1.com', '$2y$10$zlYMd1if0vP.Pl76EmQKuujalvXg2FT.lxmRnF52IuGqjZeDwoISK', 0),
	(45, '123', '123@123.com', '$2y$10$zNVx6xzwBUYP198yEKHHPu9qaDoay44yloejXQOJ.BS/uKc1F82AC', 0),
	(46, 'konstantins', 'konstantins@gmail.com', '$2y$10$56e9Nl1IXJWYOcKYrgKncOAT4p99/PYH1UtvPgHjPKSUgJmZbQ58O', 0),
	(48, 'Konstantins Kotovich', 'kostja@gmail.com', '$2y$10$t80eqpaNFAky2CFIe8B5MO/AVwBujCBKrX90U6ysi5xh4GgzJVXfa', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
