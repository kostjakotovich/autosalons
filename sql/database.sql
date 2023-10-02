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
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` blob,
  PRIMARY KEY (`colorID`),
  KEY `offerID` (`offerID`),
  CONSTRAINT `car_colors_ibfk_1` FOREIGN KEY (`offerID`) REFERENCES `offers` (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.car_colors: ~3 rows (приблизительно)
DELETE FROM `car_colors`;
INSERT INTO `car_colors` (`colorID`, `offerID`, `color`, `image`) VALUES
	(1, 55, 'somple', NULL),
	(3, 1, 'dfw', NULL),
	(4, 64, 'fghfg', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f4a756a757473752d4b616973656e2d536561736f6e2d322d476f6a6f2d76732d546f6a692d72656d617463682d696e2d7468652d6d616e67612d312e77656270);

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
  PRIMARY KEY (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.offers: ~2 rows (приблизительно)
DELETE FROM `offers`;
INSERT INTO `offers` (`offerID`, `type`, `manufacturer`) VALUES
	(1, 'fgd', 'dfg'),
	(55, 'simple model', 's1mle manuf.'),
	(64, 'rtrfh', 'gfhfg');

-- Дамп структуры для таблица mariadb.offersinfo
CREATE TABLE IF NOT EXISTS `offersinfo` (
  `offersInfoID` int NOT NULL AUTO_INCREMENT,
  `price` float DEFAULT NULL,
  `yearOfManufacture` date DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `offersID` int DEFAULT NULL,
  PRIMARY KEY (`offersInfoID`),
  KEY `offersID` (`offersID`),
  CONSTRAINT `offersID` FOREIGN KEY (`offersID`) REFERENCES `offers` (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.offersinfo: ~2 rows (приблизительно)
DELETE FROM `offersinfo`;
INSERT INTO `offersinfo` (`offersInfoID`, `price`, `yearOfManufacture`, `weight`, `offersID`) VALUES
	(1, NULL, NULL, NULL, 1),
	(48, 232, '2023-09-10', 232, 55),
	(49, 53434, '2023-09-11', 345, 64);

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
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.order: ~1 rows (приблизительно)
DELETE FROM `order`;
INSERT INTO `order` (`orderID`, `orderDate`, `name`, `surname`, `telephone`, `status`, `orderUserID`, `orderOfferID`) VALUES
	(140, '2023-09-26', 'rty', 'try', '45645', 'In progress', 1, 64);

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
