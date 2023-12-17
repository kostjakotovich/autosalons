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
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` blob,
  `color_price` float DEFAULT NULL,
  PRIMARY KEY (`colorID`),
  KEY `offerID` (`offerID`),
  CONSTRAINT `car_colors_ibfk_1` FOREIGN KEY (`offerID`) REFERENCES `offers` (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.car_colors: ~7 rows (приблизительно)
DELETE FROM `car_colors`;
INSERT INTO `car_colors` (`colorID`, `offerID`, `color`, `image`, `color_price`) VALUES
	(27, 66, 'Black', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f424d572d58352d504e472d5472616e73706172656e742d496d6167652e706e67, 0),
	(28, 67, 'White', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f63353337333266372d616331382d343330632d396430322d6537363033356135396366622e77656270, 0),
	(29, 68, 'White', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f616d672e706e67, 0),
	(30, 70, 'Red', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f666572726172692e706e67, 200),
	(31, 71, 'White', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f5465736c612d4d6f64656c2d582d504e472d49736f6c617465642d5069632e706e67, 0),
	(32, 72, 'White', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f6c616d626f726768696e692e706e67, 0),
	(34, 66, 'White', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f626d7778352e706e67, 250),
	(35, 73, 'White', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f323031382d617564692d61362d7072656d69756d2d32302d746673692d33322d77686974652e706e67, 0),
	(36, 73, 'Black', _binary 0x2e2e2f6175746f73616c6f6e732f696d672f506f72746164612d417564692d41362e706e67, 150);

-- Дамп структуры для таблица mariadb.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `commentID` int NOT NULL AUTO_INCREMENT,
  `comment` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

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
	(289, '', 48, '2023-05-03'),
	(296, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur velit est sapiente neque voluptatibus officia nostrum aut molestias modi deleniti, itaque, architecto autem tenetur cupiditate eveniet. Velit atque fugit quas.', 55, '2023-12-13');

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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
	(45, 1, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-10-30 20:45:05', 1),
	(46, 55, 'Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href=\'profile.php\'>here</a> in the \'My Orders\' tab..', '2023-11-05 20:40:35', 1);

-- Дамп структуры для таблица mariadb.offers
CREATE TABLE IF NOT EXISTS `offers` (
  `offerID` int NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_latvian_ci DEFAULT NULL,
  `manufacturer` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_latvian_ci DEFAULT NULL,
  PRIMARY KEY (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.offers: ~3 rows (приблизительно)
DELETE FROM `offers`;
INSERT INTO `offers` (`offerID`, `type`, `manufacturer`) VALUES
	(66, 'X5', 'BMW'),
	(67, 'Model Y', 'Tesla'),
	(68, 'AMG', 'Mercedes-Benz'),
	(70, 'F430', 'Ferrari'),
	(71, 'Model X', 'Tesla'),
	(72, 'Aventador', 'Lamborghini'),
	(73, 'A6', 'Audi');

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.offersinfo: ~2 rows (приблизительно)
DELETE FROM `offersinfo`;
INSERT INTO `offersinfo` (`offersInfoID`, `price`, `yearOfManufacture`, `weight`, `offersID`) VALUES
	(51, 29000, '2017-02-16', 2000, 66),
	(52, 30000, '2019-01-25', 2100, 67),
	(53, 35000, '2018-06-12', 2300, 68),
	(54, 45000, '2014-05-13', 1700, 70),
	(55, 60000, '2023-12-15', 2000, 71),
	(56, 100000, '2021-06-17', 1600, 72),
	(57, 15000, '2018-06-06', 2000, 73);

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
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_latvian_ci;

-- Дамп данных таблицы mariadb.order: ~0 rows (приблизительно)
DELETE FROM `order`;

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
	(1, 'stuff', 'stuff@example.com', 'stuff', _binary 0x696d672f6176617461722f68756d61737072696b6f6c2e706e67, 1),
	(44, '1', '1@1.com', '$2y$10$zlYMd1if0vP.Pl76EmQKuujalvXg2FT.lxmRnF52IuGqjZeDwoISK', NULL, 0),
	(46, 'konstantins', 'konstantins@gmail.com', '$2y$10$56e9Nl1IXJWYOcKYrgKncOAT4p99/PYH1UtvPgHjPKSUgJmZbQ58O', NULL, 0),
	(48, 'Konstantins Kotovich', 'kostja@gmail.com', '$2y$10$t80eqpaNFAky2CFIe8B5MO/AVwBujCBKrX90U6ysi5xh4GgzJVXfa', NULL, 0),
	(50, '1234', '1234@1234.com', '$2y$10$wMepL4xJFeGY2BU4RbGx2e6jC5mCKkp7KEqHA.GZab9RQcC2JrLzS', _binary 0x696d672f6176617461722f64656661756c742e706e67, 0),
	(55, '123', '123@123.com', '$2y$10$BTJNbFdTqAD5QD22PGRnO.htfW6imQ6Y9IzkNKQ7bbyDPAMuj9N1e', _binary 0x696d672f6176617461722f68756d61737072696b6f6c2e706e67, 0),
	(56, '12345', '12345@a.com', '$2y$10$WvxQcssDA7WqShLuc.i6WuFKe8iBnAXGabtziroIlPzHOaPldvDIm', _binary 0x696d672f6176617461722f64656661756c742e706e67, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
