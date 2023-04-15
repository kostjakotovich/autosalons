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

-- Дамп структуры для таблица mariadb.user
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `roleID` int NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf32 COLLATE=utf32_latvian_ci;

-- Дамп данных таблицы mariadb.user: ~13 rows (приблизительно)
INSERT INTO `user` (`userID`, `username`, `email`, `password`, `roleID`) VALUES
	(20, '1', '1@1', '$2y$10$N85ZufKAKDMFpT0CQceABu2bv.C1zUtoylTYYYGEq52Y1KjYOrmHi', 0),
	(21, '123', '123@123', '$2y$10$NdWJGoBC8F4hldYbE3ZXM.R/ooy6GOfdOdMjEus730vIB2wasi8v6', 0),
	(22, '1', '1@1', '$2y$10$F4OQSsyl0ZCWdglhM5tv/uHthf/waRF5YtGW/MlYb4VfFvFlSFxE2', 0),
	(23, '1', '1@1', '$2y$10$t8eB3ArY/xoiXT3W/GeYr.aY1QcpoolbdpqeT5RzfAMjk.fO3C5yy', 0),
	(24, '1', '1@1', '$2y$10$qNzlHilzAzEYz65UXGT2aeTqdISyX.7/KiNiWrzCSUc7aLPZRrC3i', 0),
	(25, '23', '23@23', '$2y$10$kmsD5HpmO49nwqsGgerXU.0WzM6gZm3IijoJQRGOO4WyYXGa2PMUG', 0),
	(26, '1234', '1234@12', '$2y$10$uBh4efRokvC.9utkFAcR1u.anVwh7JNP.6wLzwppa//l2rczjVsSm', 0),
	(27, '31243', '234@243', '$2y$10$Nk.bouaCWhLSnmiVd9yZI.Mc2gXh399e7bdF5AUTKJjKjSV4tqvQG', 0),
	(28, '1245', '1245@1245', '$2y$10$WGJ3wtrjGyTbWWsqlnEftecld1OjclnptKM4Ab1F3p2myRDZ0XNt6', 0),
	(29, '12321', 'abc@23sf', '$2y$10$klACkhcmBooev43NsdJb3O7XD9AFwgpIUezpkUQ4xJtbHLLAiKMWe', 0),
	(30, '12', '12@12', '$2y$10$QHTHBOgm57QgfcROSUyOj.ihFwMOFh89nlQ33pd.9G/yGsSQ.7Eui', 0),
	(31, 'Ok', 'OK@Ok', '$2y$10$C3onxQQqMf/pIcxCG4OrG.0p4zYCzVbF1E9Of01xt0dWEg7PzRfpy', 0),
	(35, 'admin', 'admin@example.com', 'admin', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
