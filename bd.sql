-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para petmatch
CREATE DATABASE IF NOT EXISTS `petmatch` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `petmatch`;

-- Volcando estructura para tabla petmatch.mensaje
CREATE TABLE IF NOT EXISTS `mensaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenido` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `emisor_id` int(11) NOT NULL,
  `receptor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emisor_id` (`emisor_id`),
  KEY `receptor_id` (`receptor_id`),
  CONSTRAINT `mensaje_ibfk_1` FOREIGN KEY (`emisor_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `mensaje_ibfk_2` FOREIGN KEY (`receptor_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla petmatch.mensaje: ~0 rows (aproximadamente)

-- Volcando estructura para tabla petmatch.publicacion
CREATE TABLE IF NOT EXISTS `publicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_aceptacion` date DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla petmatch.publicacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla petmatch.solicitud
CREATE TABLE IF NOT EXISTS `solicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_solicitud` date NOT NULL,
  `fecha_aceptacion` date DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla petmatch.solicitud: ~0 rows (aproximadamente)

-- Volcando estructura para tabla petmatch.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_user` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `Rango` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla petmatch.usuarios: ~6 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `name_user`, `pass`, `Rango`) VALUES
	(1, 'Aldo', '$2y$10$0Jal/tSs3zcUhQ30ntuPeeVlpNxa0ahu0kZicQurXris0kMGkF0Tu', 'user'),
	(2, 'juan', '$2y$10$tDMCL0DTbQ24cvjQQyfE0OS0yHuP0wfXQfL3hORt5gowA/mYAeBty', 'admin'),
	(3, 'manuel', '$2y$10$dG7ckAqHOH1B73FJgZwnGekYpBGI/rKhAMo0uBwE0mek/HBQtwU0O', 'user'),
	(4, 'thanos', '$2y$10$7qGUBcZx.jYvn1dc6bnTpeA.EeqUf78JEDrCNGHx4uOBQSQC6rrEm', 'admin'),
	(5, 'mama', '$2y$10$lQRGNDyIfVd.CxUPczXiZOgaeJZFmX1m3oz1TABON1Vm9FxJjyQdq', 'admin'),
	(6, 'gabo', '$2y$10$A2Lv0EvtvR5UqQEkOckQhu4JfTkHMNHIERH1GxJ0/8wQPEDdQe4uy', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
