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
  `color_price` float DEFAULT NULL,
  PRIMARY KEY (`colorID`),
  KEY `offerID` (`offerID`),
  CONSTRAINT `car_colors_ibfk_1` FOREIGN KEY (`offerID`) REFERENCES `offers` (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.car_colors: ~4 rows (приблизительно)
DELETE FROM `car_colors`;
INSERT INTO `car_colors` (`colorID`, `offerID`, `color`, `image`, `color_price`) VALUES
	(13, 65, 'yellow', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f4a756a757473752d4b616973656e2d536561736f6e2d322d476f6a6f2d76732d546f6a692d72656d617463682d696e2d7468652d6d616e67612d312e77656270, NULL),
	(14, 65, 'white', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f616236373631366430303030623237333366353630363530633538333434343439386332313466302e6a7067, NULL),
	(17, 65, 'jlbnh ,j', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f594541542d303030315f5f53746f72652d5468656d655f5f42616e6e65725f4d6f62696c652d30312e676966, NULL),
	(18, 65, 'cat', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f6b6f746e617374756c652e706e67, NULL),
	(20, 65, 'color price', NULL, 200),
	(24, 65, 'ryan gosling', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f6d617872657364656661756c74202831292e6a7067, 150),
	(25, 65, 'yeat ', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f353030783530302e6a7067, 0),
	(26, 65, 'color ye', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f646f6d696e6f6c696c2e6a7067, 0);

-- Дамп структуры для таблица mariadb.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `commentID` int NOT NULL AUTO_INCREMENT,
  `comment` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=296 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

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

-- Дамп структуры для таблица mariadb.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`notification_id`),
  KEY `userID` (`userID`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы mariadb.notifications: ~12 rows (приблизительно)
DELETE FROM `notifications`;
INSERT INTO `notifications` (`notification_id`, `userID`, `message`, `created_at`, `is_read`) VALUES
	(22, 56, 'You have successfully registered! If you need <a href=\'infoPage.php\'>Help</a>, please visit the Help section.', '2023-10-05 16:56:59', 1),
	(23, 56, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-05 18:12:34', 1),
	(30, 1, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-14 16:50:28', 1),
	(31, 1, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-14 17:01:27', 1),
	(32, 1, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-14 17:53:29', 1),
	(33, 1, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-14 17:56:10', 1),
	(34, 1, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-14 18:05:53', 1),
	(35, 1, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-14 18:14:58', 1),
	(36, 1, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-14 18:21:36', 1),
	(37, 1, 'Your order has been successfully completed! Please wait while our staff contacts You.', '2023-10-14 18:27:58', 1),
	(38, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a>.', '2023-10-15 09:40:18', 1),
	(39, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-10-15 15:14:22', 1),
	(40, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-10-15 17:55:21', 1),
	(41, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-10-17 14:37:13', 1),
	(42, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-10-17 14:39:02', 1),
	(43, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-10-23 21:11:42', 1),
	(44, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-10-30 20:39:35', 1),
	(45, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-10-30 20:45:05', 0);

-- Дамп структуры для таблица mariadb.offers
CREATE TABLE IF NOT EXISTS `offers` (
  `offerID` int NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_latvian_ci DEFAULT NULL,
  `manufacturer` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_latvian_ci DEFAULT NULL,
  PRIMARY KEY (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.offers: ~3 rows (приблизительно)
DELETE FROM `offers`;
INSERT INTO `offers` (`offerID`, `type`, `manufacturer`) VALUES
	(1, 'fgd', 'dfg'),
	(55, 'simple model', 's1mle manuf.'),
	(64, 'rtrfh', 'gfhfg'),
	(65, 'YEAT', 'BMW');

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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.offersinfo: ~2 rows (приблизительно)
DELETE FROM `offersinfo`;
INSERT INTO `offersinfo` (`offersInfoID`, `price`, `yearOfManufacture`, `weight`, `offersID`) VALUES
	(1, NULL, NULL, NULL, 1),
	(48, 232, '2023-09-10', 232, 55),
	(49, 53434, '2023-09-11', 345, 64),
	(50, 23112, '2023-10-09', 123, 65);

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
  `colorID` int DEFAULT NULL,
  PRIMARY KEY (`orderID`),
  KEY `orderUserID` (`orderUserID`) USING BTREE,
  KEY `orderOfferID` (`orderOfferID`),
  KEY `orderColorID` (`colorID`),
  CONSTRAINT `orderColorID` FOREIGN KEY (`colorID`) REFERENCES `car_colors` (`colorID`),
  CONSTRAINT `orderOfferID` FOREIGN KEY (`orderOfferID`) REFERENCES `offers` (`offerID`),
  CONSTRAINT `orderUserID` FOREIGN KEY (`orderUserID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.order: ~2 rows (приблизительно)
DELETE FROM `order`;
INSERT INTO `order` (`orderID`, `orderDate`, `name`, `surname`, `telephone`, `status`, `orderUserID`, `orderOfferID`, `colorID`) VALUES
	(147, '2023-10-03', 'Kostja', 'Kotovich', '234234', 'Done', 1, 65, 14),
	(186, '2023-10-24', '5urty', 'tyu', '+371 654456546', 'Done', 1, 65, 14),
	(187, '2023-10-30', 'Kostja', 'Kotovich', '55675675', 'Done', 1, 65, 26),
	(188, '2023-10-30', 'fghfghfgh', 'fghfgh', '456456456', 'New', 1, 65, 24);

-- Дамп структуры для таблица mariadb.user
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `picture` blob,
  `roleID` int NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.user: ~6 rows (приблизительно)
DELETE FROM `user`;
INSERT INTO `user` (`userID`, `username`, `email`, `password`, `picture`, `roleID`) VALUES
	(1, 'stuff', 'stuff@example.com', 'stuff', _binary 0x696d672f6176617461722f796561742e676966, 1),
	(44, '1', '1@1.com', '$2y$10$zlYMd1if0vP.Pl76EmQKuujalvXg2FT.lxmRnF52IuGqjZeDwoISK', NULL, 0),
	(46, 'konstantins', 'konstantins@gmail.com', '$2y$10$56e9Nl1IXJWYOcKYrgKncOAT4p99/PYH1UtvPgHjPKSUgJmZbQ58O', NULL, 0),
	(48, 'Konstantins Kotovich', 'kostja@gmail.com', '$2y$10$t80eqpaNFAky2CFIe8B5MO/AVwBujCBKrX90U6ysi5xh4GgzJVXfa', NULL, 0),
	(50, '1234', '1234@1234.com', '$2y$10$wMepL4xJFeGY2BU4RbGx2e6jC5mCKkp7KEqHA.GZab9RQcC2JrLzS', _binary 0x696d672f6176617461722f64656661756c742e706e67, 0),
	(55, '123', '123@123.com', '$2y$10$oE58rfPWoGKcZB61cyQW5O0UtqxGMvmj4qMF5YhAoXAb2EPAFl.Ni', _binary 0x696d672f6176617461722f64656661756c742e706e67, 0),
	(56, '12345', '12345@a.com', '$2y$10$WvxQcssDA7WqShLuc.i6WuFKe8iBnAXGabtziroIlPzHOaPldvDIm', _binary 0x696d672f6176617461722f64656661756c742e706e67, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
