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

-- Дамп данных таблицы mariadb.notifications: ~18 rows (приблизительно)
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

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
