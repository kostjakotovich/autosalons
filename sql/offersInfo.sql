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

-- Дамп структуры для таблица mariadb.offersinfo
CREATE TABLE IF NOT EXISTS `offersinfo` (
  `offersInfoID` int NOT NULL AUTO_INCREMENT,
  `color` varchar(10) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `yearOfManufacture` date DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `offersID` int DEFAULT NULL,
  PRIMARY KEY (`offersInfoID`),
  KEY `offersID` (`offersID`),
  CONSTRAINT `offersID` FOREIGN KEY (`offersID`) REFERENCES `offers` (`offerID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы mariadb.offersinfo: ~14 rows (приблизительно)
INSERT INTO `offersinfo` (`offersInfoID`, `color`, `price`, `yearOfManufacture`, `weight`, `offersID`) VALUES
	(15, 'выаыва', 23432, '2022-04-08', 12323, 17),
	(16, 'White', 22332, '2019-07-16', 2000, 18),
	(17, 'grn', 1223, '2022-04-08', 80, 22),
	(18, 'dffdfg', 2113, '2023-04-17', 1231, 23),
	(19, 'dffdfg', 2113, '2023-04-17', 1231, 23),
	(20, 'dsfsd', 2131, '2023-04-03', 1223, 25),
	(21, 'dsfsd', 2131, '2023-04-03', 1223, 25),
	(22, 'gre', 222, '2023-04-10', 23, 27),
	(23, 'yellow', 0, '2023-04-03', 30, 28),
	(24, 'qweqw', 213, '2023-04-12', 1232, 29),
	(25, '123asd', 21123, '2023-04-17', 123, 30),
	(26, 'cvbb', 0, '2023-04-02', 0, 31),
	(27, '423', 234324, '2023-04-05', 234, 32);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
