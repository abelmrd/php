-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.10.2-MariaDB-1:10.10.2+maria~ubu2204 - mariadb.org binary distribution
-- SO del servidor:              debian-linux-gnu
-- HeidiSQL Versión:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para database
CREATE DATABASE IF NOT EXISTS `database` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `database`;

-- Volcando estructura para tabla database.Productos
CREATE TABLE IF NOT EXISTS `Productos` (
  `ID_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `descripcion` varchar(150) NOT NULL DEFAULT '',
  `precio` float NOT NULL DEFAULT 0,
  `composicion` varchar(200) NOT NULL DEFAULT '0',
  `imagen` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla database.Productos: ~5 rows (aproximadamente)
INSERT INTO `Productos` (`ID_pedido`, `nombre`, `descripcion`, `precio`, `composicion`, `imagen`) VALUES
	(1, 'Cúrcuma', '400 Cápsulas 700 mg de cúrcuma + 2,1 mg pimienta', 24, 'Cúrcuma en polvo, cubierta de la cápsula (hidroxipropilmetilcelulosa), extracto de pimienta', '1.png'),
	(2, 'Multivitaminas', '120 Pastillas. Comprimido de disolución rápida', 9, 'Vitaminas A, B2, B6, B7, B9, B12, C, D, E, K y el zinc', '2.png'),
	(25, 'Colageno', 'Colágeno Marino Hidrolizado + Ácido hialurónico ', 18, 'Hidrolizado de colágeno, magnesio, ácido L-ascórbico, citrato de zinc, hialuronato de sodio', '3.png'),
	(26, 'Omega 3', 'Ácidos grasos omega 400 cápsulas', 28, '350mg de ácidos grasos Omega-3, 180mg de EPA, 120mg de DHA por cápsula', '4.png'),
	(29, 'Suplemento Zinc', '400 tabletas 25 mg de zinc por tableta', 14, 'Maltodextrina, Cápsula de origen vegetal (HPMC) ,Zinc (pilodato)', '5.png');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
