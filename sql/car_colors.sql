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

-- Дамп данных таблицы mariadb.car_colors: ~8 rows (приблизительно)
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

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
