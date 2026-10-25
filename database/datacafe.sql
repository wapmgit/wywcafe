-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para wcafedb
CREATE DATABASE IF NOT EXISTS `wcafedb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `wcafedb`;

-- Volcando estructura para tabla wcafedb.ajuste
CREATE TABLE IF NOT EXISTS `ajuste` (
  `idajuste` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `numajuste` int(11) DEFAULT NULL,
  `concepto` varchar(80) NOT NULL,
  `responsable` varchar(30) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `monto` float(11,2) NOT NULL,
  PRIMARY KEY (`idajuste`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ajuste: ~0 rows (aproximadamente)
DELETE FROM `ajuste`;

-- Volcando estructura para tabla wcafedb.almacenvacios
CREATE TABLE IF NOT EXISTS `almacenvacios` (
  `idregistro` int(11) NOT NULL AUTO_INCREMENT,
  `entrada` int(11) DEFAULT '0',
  `salida` int(11) DEFAULT '0',
  `idarticulo` int(11) DEFAULT NULL,
  `concepto` varchar(50) DEFAULT NULL,
  `responsable` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idregistro`)
) ENGINE=InnoDB AUTO_INCREMENT=4342 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.almacenvacios: ~0 rows (aproximadamente)
DELETE FROM `almacenvacios`;

-- Volcando estructura para tabla wcafedb.apartado
CREATE TABLE IF NOT EXISTS `apartado` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `idvendedor` int(11) DEFAULT NULL,
  `tipo_comprobante` varchar(10) NOT NULL,
  `serie_comprobante` varchar(15) NOT NULL,
  `num_comprobante` int(11) NOT NULL,
  `flibre` int(11) DEFAULT '0',
  `control` varchar(10) DEFAULT NULL,
  `tasa` float(9,3) DEFAULT '0.000',
  `total_venta` float(11,2) NOT NULL,
  `base` float(9,3) DEFAULT '0.000',
  `total_iva` float(9,3) DEFAULT '0.000',
  `texe` float(9,3) DEFAULT '0.000',
  `descuento` double(15,3) DEFAULT '0.000',
  `dias` int(11) DEFAULT '0',
  `incremento` int(11) DEFAULT '0',
  `total_pagar` float(9,3) DEFAULT '0.000',
  `recargo` float(9,3) DEFAULT '0.000',
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_emi` date DEFAULT NULL,
  `impuesto` int(11) NOT NULL,
  `saldo` float(11,2) NOT NULL,
  `obs` varchar(80) DEFAULT NULL,
  `mret` float(9,3) DEFAULT '0.000',
  `estado` varchar(10) NOT NULL,
  `devolu` int(11) NOT NULL,
  `comision` double(8,3) DEFAULT '0.000',
  `montocomision` float(9,3) DEFAULT NULL,
  `idcomision` int(11) DEFAULT '0',
  `user` varchar(15) NOT NULL,
  `impor` int(11) DEFAULT '0',
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.apartado: ~0 rows (aproximadamente)
DELETE FROM `apartado`;

-- Volcando estructura para tabla wcafedb.articulo
CREATE TABLE IF NOT EXISTS `articulo` (
  `idarticulo` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `stock` float(9,3) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `unidad` varchar(8) DEFAULT '0',
  `usap` int(11) DEFAULT '0',
  `volumen` float(9,3) DEFAULT '0.000',
  `grados` float(9,3) DEFAULT '0.000',
  `clase` varchar(15) DEFAULT 'N/A',
  `imagen` varchar(50) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `utilidad` float(7,2) NOT NULL,
  `precio1` float(11,2) NOT NULL,
  `precio2` float(11,2) NOT NULL,
  `precio_t` float(9,3) DEFAULT '0.000',
  `util2` float(7,2) NOT NULL,
  `costo` float(11,2) NOT NULL,
  `costo_t` float(9,3) DEFAULT '0.000',
  `iva` int(11) NOT NULL,
  `fraccion` float(6,2) DEFAULT '1.00',
  `comi` int(11) DEFAULT '0',
  `pcomision` float(9,3) DEFAULT '0.000',
  `vacio` int(11) DEFAULT '0',
  `mprima` int(11) DEFAULT '0',
  `nivelp` int(11) DEFAULT '0',
  `pesogr` float(9,3) DEFAULT '0.000',
  `origen` varchar(20) DEFAULT 'N',
  `sevende` int(11) DEFAULT '1',
  PRIMARY KEY (`idarticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.articulo: ~18 rows (aproximadamente)
DELETE FROM `articulo`;
INSERT INTO `articulo` (`idarticulo`, `idempresa`, `idcategoria`, `codigo`, `nombre`, `stock`, `descripcion`, `unidad`, `usap`, `volumen`, `grados`, `clase`, `imagen`, `estado`, `utilidad`, `precio1`, `precio2`, `precio_t`, `util2`, `costo`, `costo_t`, `iva`, `fraccion`, `comi`, `pcomision`, `vacio`, `mprima`, `nivelp`, `pesogr`, `origen`, `sevende`) VALUES
	(1, 1, 2, '21345', 'CAFE AZUL', 0.000, '.', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 10.00, 3.89, 3.89, 0.000, 10.00, 3.50, 805.000, 0, 1.00, NULL, NULL, NULL, 1, 0, 0.000, NULL, 0),
	(11, 2, 4, '2314', 'CAFE 100 GR', 0.000, '.', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 20.00, 1.32, 1.38, 0.000, 25.00, 1.10, 137.500, 0, 1.00, 0, NULL, NULL, 0, 0, 100.000, NULL, 1),
	(13, 2, 4, '03132', 'CAFE 250 GR', 0.000, '.', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 20.00, 4.20, 4.38, 0.000, 25.00, 3.50, 437.500, 0, 1.00, 0, NULL, NULL, 0, 0, 250.000, NULL, 1),
	(14, 1, 2, '12123', 'CAFE 100 GR', 0.000, '.', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 10.00, 1.11, 1.11, 0.000, 10.00, 1.00, 230.000, 0, 1.00, 0, NULL, NULL, 0, 3, 100.000, NULL, 1),
	(15, 1, 2, '345345', 'CAFE TOSTADO', 0.000, '.', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 20.00, 2.00, 2.13, 0.000, 25.00, 1.60, 0.000, 0, 0.10, 0, NULL, NULL, 1, 1, 1.000, NULL, 1),
	(16, 1, 1, '3123', 'CAFE 250', 0.000, '.', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 10.00, 3.89, 3.89, 0.000, 10.00, 3.50, 805.000, 0, 1.00, 0, NULL, NULL, 0, 3, 250.000, NULL, 1),
	(17, 1, 3, '0217844', 'CAFE MOLIDO', 0.000, '.', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 20.00, 4.00, 4.27, 0.000, 25.00, 3.20, 0.000, 0, 0.10, 0, NULL, NULL, 1, 2, 1.000, NULL, 0),
	(18, 1, 2, '015427', 'CAFE AZUL CANJE', 0.000, '.', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 20.00, 4.38, 4.67, 0.000, 25.00, 3.50, 0.000, 0, 0.10, NULL, NULL, NULL, 1, 0, 0.000, NULL, 0),
	(19, 1, 6, '5354', 'AFE PAQUETE 100GR', 0.000, '', 'kg', 0, NULL, NULL, NULL, '', 'Activo', 10.00, 1.11, 1.11, 0.000, 10.00, 1.00, 0.000, 0, 1.00, 0, NULL, NULL, 0, 0, 100.000, NULL, 1),
	(20, 1, 5, '6889', 'CAFE GORMET', 0.000, '', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 10.00, 11.11, 11.11, 0.000, 10.00, 10.00, 0.000, 0, 1.00, 0, NULL, NULL, 0, 0, 1.000, NULL, 1),
	(21, 2, 5, '0001', 'CAFE AZUL', 0.000, '', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 10.00, 5.17, 5.17, 0.000, 10.00, 5.80, 5104.000, 0, 1.00, NULL, NULL, NULL, 1, 0, 0.000, NULL, 0),
	(22, 2, 6, 'C001', 'CAFE TOSTADO', 0.000, '', 'kg', 0, NULL, NULL, NULL, '', 'Activo', 20.00, 6.60, 6.60, 0.000, 20.00, 5.50, 0.000, 0, 0.01, 0, NULL, NULL, 1, 1, 1.000, NULL, 1),
	(23, 2, 5, 'C002', 'CAFE MOLIDO', 0.000, '', 'KG', 0, NULL, NULL, NULL, '', 'Activo', 20.00, 6.24, 6.24, 0.000, 20.00, 5.20, 0.000, 0, 1.00, NULL, NULL, NULL, 1, 2, 1000.000, NULL, 1),
	(24, 2, 6, 'C003', 'CAFE 100GR', 0.000, '', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 32.30, 1.30, 1.00, 0.000, 12.00, 0.88, 0.000, 0, 1.00, NULL, NULL, NULL, 0, 3, 100.000, NULL, 1),
	(25, 2, 6, 'C004', 'CAFE 200GR', 0.000, '', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 32.69, 2.60, 2.00, 0.000, 12.50, 1.75, 0.000, 0, 1.00, NULL, NULL, NULL, 0, 3, 200.000, NULL, 1),
	(26, 2, 6, 'C005', 'CAFE 500GR', 0.000, '', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 32.61, 6.50, 5.00, 0.000, 12.40, 4.38, 0.000, 0, 1.00, NULL, NULL, NULL, 0, 3, 500.000, NULL, 1),
	(27, 2, 6, '007', 'CAFE TOSTADO EN GRANO', 0.000, '', 'kg', 0, NULL, NULL, NULL, '', 'Activo', 57.00, 15.00, 13.20, 0.000, 15.00, 9.50, 0.000, 0, 1.00, 0, NULL, NULL, 0, 0, 1.000, NULL, 1),
	(28, 2, 5, '002', 'CAFE AZUL PAPA', 0.000, '', 'UND', 0, NULL, NULL, NULL, '', 'Activo', 10.00, 6.58, 7.18, 0.000, 20.00, 5.98, 0.000, 0, 1.00, NULL, NULL, NULL, 1, 0, 0.000, NULL, 1);

-- Volcando estructura para tabla wcafedb.articulometas
CREATE TABLE IF NOT EXISTS `articulometas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmeta` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `valor` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.articulometas: ~0 rows (aproximadamente)
DELETE FROM `articulometas`;

-- Volcando estructura para tabla wcafedb.articulometasvendedor
CREATE TABLE IF NOT EXISTS `articulometasvendedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmeta` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `valor` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1919 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.articulometasvendedor: ~0 rows (aproximadamente)
DELETE FROM `articulometasvendedor`;

-- Volcando estructura para tabla wcafedb.bancos
CREATE TABLE IF NOT EXISTS `bancos` (
  `idbanco` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `cuentaban` varchar(25) DEFAULT NULL,
  `tipocta` varchar(20) DEFAULT NULL,
  `titular` varchar(50) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idbanco`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.bancos: ~0 rows (aproximadamente)
DELETE FROM `bancos`;

-- Volcando estructura para tabla wcafedb.bloques
CREATE TABLE IF NOT EXISTS `bloques` (
  `idbloque` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `responsable` varchar(20) DEFAULT NULL,
  `articulos` float(9,3) NOT NULL DEFAULT '0.000',
  `estatus` int(11) DEFAULT '0',
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idbloque`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.bloques: ~0 rows (aproximadamente)
DELETE FROM `bloques`;

-- Volcando estructura para tabla wcafedb.caja
CREATE TABLE IF NOT EXISTS `caja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `telefonos` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.caja: ~0 rows (aproximadamente)
DELETE FROM `caja`;

-- Volcando estructura para tabla wcafedb.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `idempresa` int(11) DEFAULT NULL,
  `descripcion` varchar(50) NOT NULL,
  `condicion` int(11) NOT NULL,
  `servicio` int(11) DEFAULT '0',
  `licor` int(11) DEFAULT '0',
  `tactil` int(11) DEFAULT '0',
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.categoria: ~2 rows (aproximadamente)
DELETE FROM `categoria`;
INSERT INTO `categoria` (`idcategoria`, `nombre`, `idempresa`, `descripcion`, `condicion`, `servicio`, `licor`, `tactil`) VALUES
	(5, 'PRODUCCION', 2, 'ARTICULOS PRODUCCION', 1, 0, NULL, NULL),
	(6, 'CAFE', 2, 'CEFE ', 1, 0, NULL, 1);

-- Volcando estructura para tabla wcafedb.categoriaclientes
CREATE TABLE IF NOT EXISTS `categoriaclientes` (
  `idcategoria` int(11) DEFAULT NULL,
  `nombrecategoria` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.categoriaclientes: ~12 rows (aproximadamente)
DELETE FROM `categoriaclientes`;
INSERT INTO `categoriaclientes` (`idcategoria`, `nombrecategoria`) VALUES
	(1, 'Licoreria'),
	(2, 'Abasto'),
	(3, 'Bodega'),
	(4, 'Kiosco'),
	(5, 'Cafetin'),
	(6, 'Restaurant'),
	(7, 'Eventual'),
	(8, 'Hotel'),
	(9, 'Panaderia'),
	(10, 'Farmacia'),
	(11, 'Fruteria'),
	(12, 'Centro Recreacional');

-- Volcando estructura para tabla wcafedb.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `nombre` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `codpais` varchar(4) DEFAULT '+58',
  `telefono` varchar(12) NOT NULL,
  `status` varchar(3) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `idmunicipio` int(11) DEFAULT '0',
  `idsector` int(11) DEFAULT '0',
  `tipo_cliente` int(11) NOT NULL,
  `categoria` int(11) DEFAULT '1',
  `retencion` int(11) DEFAULT '0',
  `contacto` varchar(50) DEFAULT NULL,
  `tipo_precio` int(11) NOT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `licencia` varchar(20) DEFAULT 'S/N',
  `diascre` int(11) DEFAULT '0',
  `recargo` int(11) DEFAULT '1',
  `ruta` int(11) DEFAULT '1',
  `idbanco` char(1) DEFAULT 'C',
  `ultventa` date DEFAULT NULL,
  `facanterior` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.clientes: ~22 rows (aproximadamente)
DELETE FROM `clientes`;
INSERT INTO `clientes` (`id_cliente`, `idempresa`, `nombre`, `cedula`, `codpais`, `telefono`, `status`, `direccion`, `idmunicipio`, `idsector`, `tipo_cliente`, `categoria`, `retencion`, `contacto`, `tipo_precio`, `vendedor`, `creado`, `licencia`, `diascre`, `recargo`, `ruta`, `idbanco`, `ultventa`, `facanterior`) VALUES
	(1, 2, 'ABASTO EL TRIGAL', 'V-08036260', '+58', '0414-53107', 'A', 'VISTA ALEGRE', 199, 592, 0, 2, 0, 'EDGAR CONTRERAS', 1, 6, '2026-10-13', NULL, 15, 1, 8, 'C', NULL, NULL),
	(2, 2, 'FRUTERIA VISTA ALEGRE', 'V-16019134', '+58', '0416-04113', 'A', 'VISTA ALEGRE', 199, 592, 0, 3, 0, 'PABLO ZERPA', 1, 6, '2026-10-13', NULL, 15, 1, 8, 'C', NULL, NULL),
	(3, 2, 'PEKIN 2013', 'E-5875964', '+58', '4120693370', 'A', 'PUERTO RICO', 181, 523, 0, 2, 0, 'JENNY', 1, 7, '2026-10-14', NULL, 8, 1, 7, 'C', NULL, NULL),
	(4, 2, 'GANADERIA EL SAMAN', 'v-14447853', '+58', '424744935', 'A', 'PUERTO RICO', 181, 523, 0, 3, 0, 'JENNY BELANDRIA', 1, 7, '2026-10-14', NULL, 15, 1, 7, 'C', NULL, NULL),
	(5, 2, 'BODEGON SEGOVIA', '1', '+58', '1', 'A', 'LA PLAYA', 196, 582, 0, 2, 0, 'MARLY SEGOVIA', 1, 7, '2026-10-14', NULL, 15, 1, 9, 'C', NULL, NULL),
	(6, 2, 'MONTSERRAT J-21 FERNANDO MEDINA', '2', '+58', '2', 'A', 'LA PLAYA', 196, 582, 0, 3, 0, 'FERNANDO MEDINA', 1, 7, '2026-10-14', NULL, 15, 1, 9, 'C', '2026-10-22', NULL),
	(7, 2, 'MONTSERRAT J-21 ELIAGNYS VIVAS', '3', '+58', '3', 'A', 'LA PLAYA', 196, 582, 0, 3, 0, 'ELIAGNY VIVAS', 1, 7, '2026-10-14', NULL, 15, 1, 9, 'C', '2026-10-22', NULL),
	(8, 2, 'ABASTO MI JARDIN', '10', '+58', '4147241509', 'A', 'SECTOR LAS ACACIAS TOVAR', 199, 594, 0, 2, 0, 'ENDER ', 1, 7, '2026-10-18', NULL, 15, 1, 8, 'C', '2026-10-22', NULL),
	(9, 2, 'LA SCALA', '69', '+58', '0', 'A', 'TOVAR SECTOR EL PUENTE', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-19', NULL, 1, 1, 8, 'C', '2026-10-19', NULL),
	(10, 2, 'LUIS EDGLIS ZEA', '68', '+58', '4264268103', 'A', 'EL COROZO', 0, 0, 0, 1, 0, NULL, 2, 7, '2026-10-19', NULL, 15, 0, 8, 'C', '2026-10-19', NULL),
	(11, 2, 'PEKIN 2008', '9', '+58', '5', 'A', 'AVENIDA CRISTOBAL MENDOZA TOVAR', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-19', NULL, 1, 1, 8, 'C', '2026-10-19', NULL),
	(12, 2, 'AMOR A DIOS', '6', '+58', '6', 'A', 'EL ANIS', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-19', NULL, 15, 1, 13, 'C', '2026-10-19', NULL),
	(13, 2, 'BETANIA PEREIRA', '90', '+58', '565', 'A', 'ARENAL SANTA CRUZ', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-21', NULL, 15, 0, 7, 'C', '2026-10-22', NULL),
	(14, 2, 'BODEGA CARMANIA', '00', '+58', 'S', 'A', 'PUERTO RICO', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-22', NULL, 15, 1, 8, 'C', '2026-10-22', NULL),
	(15, 2, 'FRUTERIA LA VILLA', '', '+58', '48', 'A', 'VILLA SOCORRO', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-22', NULL, 15, 1, 8, 'C', '2026-10-22', NULL),
	(16, 2, 'DIEGO MAYA', 'V-27933755', '+58', '55', 'A', 'PAIVA', 0, 0, 0, 1, 0, NULL, 1, 6, '2026-10-22', NULL, 15, 1, 14, 'C', '2026-10-22', NULL),
	(17, 2, 'JOHANA VENDEDORA', 'V10', '+58', '4', 'A', 'MERIDA', 0, 0, 0, 1, 0, NULL, 1, 6, '2026-10-22', NULL, 15, 1, 14, 'C', '2026-10-22', NULL),
	(18, 2, 'LJY FERNANDEZ', 'V0', '+58', '0', 'A', 'LA VEGA', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-22', NULL, 15, 0, 8, 'C', '2026-10-22', NULL),
	(19, 2, 'MENDEZ PANADERIA', 'V1', '+58', '5', 'A', 'LA PLAZA TOVAR', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-22', NULL, 15, 1, 8, 'C', '2026-10-22', NULL),
	(20, 2, 'BODEGA LA LAGUNA', '7', '+58', '0', 'A', 'EL RINCON DE LA LAGUNA', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-22', NULL, 15, 1, 8, 'C', '2026-10-22', NULL),
	(21, 2, 'BODEGA LA VILLA', 'V2', '+58', '34', 'A', 'BAILADORES', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-22', NULL, 15, 1, 9, 'C', '2026-10-22', NULL),
	(22, 2, 'LA MODERNA', 'V3', '+58', '', 'A', 'EL PENON', 0, 0, 0, 1, 0, NULL, 1, 7, '2026-10-22', NULL, 15, 1, 8, 'C', '2026-10-22', NULL);

-- Volcando estructura para tabla wcafedb.comision
CREATE TABLE IF NOT EXISTS `comision` (
  `id_comision` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) DEFAULT NULL,
  `montoventas` float(9,3) DEFAULT NULL,
  `montocomision` float(9,3) DEFAULT NULL,
  `idmeta` int(11) DEFAULT '0',
  `mtometa` float(9,3) DEFAULT '0.000',
  `pendiente` float(9,3) DEFAULT '0.000',
  `fecha` date DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_comision`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.comision: ~0 rows (aproximadamente)
DELETE FROM `comision`;

-- Volcando estructura para tabla wcafedb.comisiones
CREATE TABLE IF NOT EXISTS `comisiones` (
  `id_comision` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) DEFAULT NULL,
  `montoventas` float(9,3) DEFAULT NULL,
  `montocomision` float(9,3) DEFAULT NULL,
  `pendiente` float(9,3) DEFAULT '0.000',
  `fecha` date DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_comision`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.comisiones: ~0 rows (aproximadamente)
DELETE FROM `comisiones`;

-- Volcando estructura para tabla wcafedb.compras
CREATE TABLE IF NOT EXISTS `compras` (
  `idcompra` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idproveedor` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(20) NOT NULL,
  `num_comprobante` varchar(20) NOT NULL,
  `fecha_hora` date NOT NULL,
  `emision` date DEFAULT NULL,
  `impuesto` int(11) NOT NULL,
  `total` float(11,2) NOT NULL,
  `base` float(9,3) DEFAULT NULL,
  `miva` float(9,3) DEFAULT NULL,
  `exento` float(9,3) DEFAULT NULL,
  `saldo` float(11,2) NOT NULL,
  `retenido` float(9,3) DEFAULT '0.000',
  `condicion` varchar(15) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT '0',
  `tasa` float(9,3) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idcompra`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.compras: ~0 rows (aproximadamente)
DELETE FROM `compras`;

-- Volcando estructura para tabla wcafedb.comprobante
CREATE TABLE IF NOT EXISTS `comprobante` (
  `idrecibo` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idcompra` int(11) NOT NULL DEFAULT '0',
  `idgasto` int(11) DEFAULT '0',
  `idtostador` int(11) DEFAULT '0',
  `idmaquina` int(11) DEFAULT '0',
  `monto` float(11,2) NOT NULL,
  `idpago` int(11) NOT NULL,
  `idbanco` varchar(15) NOT NULL,
  `id_banco` int(11) DEFAULT '0',
  `recibido` float(12,3) NOT NULL,
  `tasab` float(11,2) NOT NULL,
  `tasap` float(9,3) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `aux` varchar(15) NOT NULL,
  `fecha_comp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idrecibo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.comprobante: ~0 rows (aproximadamente)
DELETE FROM `comprobante`;

-- Volcando estructura para tabla wcafedb.ctascon
CREATE TABLE IF NOT EXISTS `ctascon` (
  `idcod` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) CHARACTER SET utf8 NOT NULL,
  `descrip` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tipo` double(2,0) NOT NULL DEFAULT '0',
  `inactiva` double(1,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `idcod` (`idcod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ctascon: ~0 rows (aproximadamente)
DELETE FROM `ctascon`;

-- Volcando estructura para tabla wcafedb.datacsv
CREATE TABLE IF NOT EXISTS `datacsv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idarticulo` int(11) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `costo` float(9,3) DEFAULT NULL,
  `cantidad` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.datacsv: ~0 rows (aproximadamente)
DELETE FROM `datacsv`;

-- Volcando estructura para tabla wcafedb.depmaquina
CREATE TABLE IF NOT EXISTS `depmaquina` (
  `iddep` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `nombre` varchar(20) DEFAULT NULL,
  `marca` varchar(30) DEFAULT NULL,
  `serie` varchar(20) DEFAULT NULL,
  `capacidad` int(11) DEFAULT '0',
  `tipo` int(11) DEFAULT '0',
  `kg` float(9,3) DEFAULT '0.000',
  `pendiente` float(9,3) DEFAULT '0.000',
  PRIMARY KEY (`iddep`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.depmaquina: ~0 rows (aproximadamente)
DELETE FROM `depmaquina`;

-- Volcando estructura para tabla wcafedb.deposito
CREATE TABLE IF NOT EXISTS `deposito` (
  `id_deposito` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) DEFAULT NULL,
  `tipo_p` char(3) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `identificacion` varchar(20) DEFAULT NULL,
  `debe` int(11) DEFAULT '0',
  `debo` int(11) DEFAULT '0',
  PRIMARY KEY (`id_deposito`)
) ENGINE=InnoDB AUTO_INCREMENT=463 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.deposito: ~0 rows (aproximadamente)
DELETE FROM `deposito`;

-- Volcando estructura para tabla wcafedb.depvendedor
CREATE TABLE IF NOT EXISTS `depvendedor` (
  `id_deposito` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(30) DEFAULT NULL,
  `idvendedor` int(11) DEFAULT '0',
  PRIMARY KEY (`id_deposito`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.depvendedor: ~2 rows (aproximadamente)
DELETE FROM `depvendedor`;
INSERT INTO `depvendedor` (`id_deposito`, `idempresa`, `nombre`, `descripcion`, `idvendedor`) VALUES
	(6, 2, 'Principal', 'tabacal', 6),
	(7, 2, 'AGYA', 'MOVIL', 7);

-- Volcando estructura para tabla wcafedb.detalledeposito
CREATE TABLE IF NOT EXISTS `detalledeposito` (
  `iddetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idregistro` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `tiporeg` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=4401 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalledeposito: ~0 rows (aproximadamente)
DELETE FROM `detalledeposito`;

-- Volcando estructura para tabla wcafedb.detalleimportar
CREATE TABLE IF NOT EXISTS `detalleimportar` (
  `iddetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT '0.000',
  `precio_venta` float(11,2) NOT NULL,
  `descuento` float(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalleimportar: ~0 rows (aproximadamente)
DELETE FROM `detalleimportar`;

-- Volcando estructura para tabla wcafedb.detalle_ajuste
CREATE TABLE IF NOT EXISTS `detalle_ajuste` (
  `iddetalle_ajuste` int(11) NOT NULL AUTO_INCREMENT,
  `idajuste` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `tipo_ajuste` varchar(15) NOT NULL,
  `cantidad` float(9,3) NOT NULL,
  `costo` float(11,2) NOT NULL,
  `valorizado` float(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_ajuste`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_ajuste: ~0 rows (aproximadamente)
DELETE FROM `detalle_ajuste`;

-- Volcando estructura para tabla wcafedb.detalle_apartado
CREATE TABLE IF NOT EXISTS `detalle_apartado` (
  `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT NULL,
  `cantidad` float(7,2) NOT NULL,
  `precio_venta` float(11,3) NOT NULL,
  `descuento` float(7,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_emi` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_apartado: ~0 rows (aproximadamente)
DELETE FROM `detalle_apartado`;

-- Volcando estructura para tabla wcafedb.detalle_bloque
CREATE TABLE IF NOT EXISTS `detalle_bloque` (
  `iddetallebloque` int(11) NOT NULL AUTO_INCREMENT,
  `idbloque` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddetallebloque`)
) ENGINE=InnoDB AUTO_INCREMENT=318 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_bloque: ~0 rows (aproximadamente)
DELETE FROM `detalle_bloque`;

-- Volcando estructura para tabla wcafedb.detalle_compras
CREATE TABLE IF NOT EXISTS `detalle_compras` (
  `iddetalle_compra` int(11) NOT NULL AUTO_INCREMENT,
  `idcompra` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` float(11,2) NOT NULL,
  `precio_compra` float(11,2) NOT NULL,
  `precio_tasa` float(9,3) DEFAULT NULL,
  `precio_venta` float(11,2) DEFAULT NULL,
  `subtotal` float(9,3) DEFAULT '0.000',
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_compras: ~0 rows (aproximadamente)
DELETE FROM `detalle_compras`;

-- Volcando estructura para tabla wcafedb.detalle_devolucion
CREATE TABLE IF NOT EXISTS `detalle_devolucion` (
  `iddetalle_devolucion` int(11) NOT NULL AUTO_INCREMENT,
  `iddevolucion` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` float(9,3) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT '0.000',
  `precio_venta` float(11,2) NOT NULL,
  `descuento` float(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_devolucion`)
) ENGINE=InnoDB AUTO_INCREMENT=4454 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_devolucion: ~0 rows (aproximadamente)
DELETE FROM `detalle_devolucion`;

-- Volcando estructura para tabla wcafedb.detalle_devolucioncompras
CREATE TABLE IF NOT EXISTS `detalle_devolucioncompras` (
  `iddetalle` int(11) NOT NULL AUTO_INCREMENT,
  `iddevolucion` int(11) NOT NULL,
  `codarticulo` int(11) DEFAULT NULL,
  `cantidad` float(9,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_devolucioncompras: ~0 rows (aproximadamente)
DELETE FROM `detalle_devolucioncompras`;

-- Volcando estructura para tabla wcafedb.detalle_ingreso
CREATE TABLE IF NOT EXISTS `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` float(11,2) NOT NULL,
  `precio_compra` float(11,2) NOT NULL,
  `precio_tasa` float(9,3) DEFAULT NULL,
  `precio_venta` float(11,2) NOT NULL,
  `subtotal` float(9,3) DEFAULT '0.000',
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle_ingreso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_ingreso: ~0 rows (aproximadamente)
DELETE FROM `detalle_ingreso`;

-- Volcando estructura para tabla wcafedb.detalle_pedido
CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT NULL,
  `cantidad` float(7,2) NOT NULL,
  `precio_venta` float(11,2) NOT NULL,
  `preciof` float(9,3) DEFAULT NULL,
  `descuento` float(7,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_emi` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=47239 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_pedido: ~0 rows (aproximadamente)
DELETE FROM `detalle_pedido`;

-- Volcando estructura para tabla wcafedb.detalle_produccion
CREATE TABLE IF NOT EXISTS `detalle_produccion` (
  `iddetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idproduccion` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` float(9,3) DEFAULT NULL,
  `kgproduccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_produccion: ~0 rows (aproximadamente)
DELETE FROM `detalle_produccion`;

-- Volcando estructura para tabla wcafedb.detalle_traslado
CREATE TABLE IF NOT EXISTS `detalle_traslado` (
  `iddetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idtraslado` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` float(7,2) DEFAULT NULL,
  `precio` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_traslado: ~0 rows (aproximadamente)
DELETE FROM `detalle_traslado`;

-- Volcando estructura para tabla wcafedb.detalle_venta
CREATE TABLE IF NOT EXISTS `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT NULL,
  `cantidad` float(7,2) NOT NULL,
  `unidad` varchar(8) DEFAULT 'UND',
  `cntgrp` int(11) DEFAULT '1',
  `tprecio` varchar(5) DEFAULT 'P1',
  `precio` float(9,3) DEFAULT '0.000',
  `precio_venta` float(11,2) NOT NULL,
  `descuento` float(7,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechahora` date DEFAULT NULL,
  `fecha_emi` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_venta: ~0 rows (aproximadamente)
DELETE FROM `detalle_venta`;

-- Volcando estructura para tabla wcafedb.detalle_ventaf
CREATE TABLE IF NOT EXISTS `detalle_ventaf` (
  `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT NULL,
  `cantidad` float(7,2) NOT NULL,
  `precio_venta` float(11,2) NOT NULL,
  `descuento` float(7,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_emi` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=20289 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_ventaf: ~0 rows (aproximadamente)
DELETE FROM `detalle_ventaf`;

-- Volcando estructura para tabla wcafedb.devolucion
CREATE TABLE IF NOT EXISTS `devolucion` (
  `iddevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '0',
  `idventa` int(11) NOT NULL,
  `comprobante` varchar(15) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(20) NOT NULL,
  PRIMARY KEY (`iddevolucion`)
) ENGINE=InnoDB AUTO_INCREMENT=1491 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.devolucion: ~0 rows (aproximadamente)
DELETE FROM `devolucion`;

-- Volcando estructura para tabla wcafedb.devolucioncompras
CREATE TABLE IF NOT EXISTS `devolucioncompras` (
  `iddevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT NULL,
  `idcompra` int(11) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`iddevolucion`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.devolucioncompras: ~0 rows (aproximadamente)
DELETE FROM `devolucioncompras`;

-- Volcando estructura para tabla wcafedb.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `idempresa` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `rif` varchar(20) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fechasistema` date DEFAULT NULL,
  `inicio` date DEFAULT NULL,
  `corre_iva` int(11) DEFAULT NULL,
  `corre_islr` int(11) DEFAULT NULL,
  `modop` int(11) DEFAULT '0' COMMENT 'calculapor venta en valor 0',
  `tc` double(15,4) DEFAULT NULL,
  `peso` double(9,3) DEFAULT NULL,
  `tasa_banco` double(15,4) DEFAULT NULL,
  `calc_util` int(11) DEFAULT '1',
  `ctapagos` varchar(200) DEFAULT NULL,
  `logo` varchar(80) DEFAULT 'ninguna.jpg',
  PRIMARY KEY (`idempresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.empresa: ~2 rows (aproximadamente)
DELETE FROM `empresa`;
INSERT INTO `empresa` (`idempresa`, `nombre`, `direccion`, `rif`, `telefono`, `fechasistema`, `inicio`, `corre_iva`, `corre_islr`, `modop`, `tc`, `peso`, `tasa_banco`, `calc_util`, `ctapagos`, `logo`) VALUES
	(1, 'W&W SYSTEMS', 'Santa cruz de mora Edo. Mérida', 'J-16604674', '04247163726', '2026-12-20', '2025-12-20', 1, 1, 0, 230.0000, 4000.000, 4.1600, 2, 'N° 0101-0000000-000000-0000 v16604674 wuilmer puerta', 'cruzcafe.png'),
	(2, 'CAFE LAS PALMAS', 'Calle el Paraiso, sector el Tabacal, Santa Cruz de Mora, Estado Merida', 'j-411718939', '04124656570', '2027-09-08', '2026-09-08', 1, 1, 0, 880.0000, 4500.000, 11.0000, 1, 'N° 0102-0000000-000000-0000 v16604674 PUERTA', 'ccafe.jpg');

-- Volcando estructura para tabla wcafedb.existencia
CREATE TABLE IF NOT EXISTS `existencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `id_almacen` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `existencia` float(9,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.existencia: ~11 rows (aproximadamente)
DELETE FROM `existencia`;
INSERT INTO `existencia` (`id`, `idempresa`, `id_almacen`, `idarticulo`, `existencia`) VALUES
	(34, 2, 6, 21, 0.00),
	(36, 2, 6, 23, 0.00),
	(37, 2, 6, 24, 0.00),
	(38, 2, 6, 25, 0.00),
	(39, 2, 6, 26, 0.00),
	(40, 2, 6, 27, 0.00),
	(41, 2, 6, 28, 0.00),
	(42, 2, 7, 24, 0.00),
	(43, 2, 7, 25, 0.00),
	(44, 2, 7, 26, 0.00),
	(45, 2, 7, 23, 0.00);

-- Volcando estructura para tabla wcafedb.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla wcafedb.failed_jobs: ~0 rows (aproximadamente)
DELETE FROM `failed_jobs`;

-- Volcando estructura para tabla wcafedb.formalibre
CREATE TABLE IF NOT EXISTS `formalibre` (
  `idForma` int(11) NOT NULL AUTO_INCREMENT,
  `idventa` int(11) DEFAULT NULL,
  `nrocontrol` int(11) DEFAULT NULL,
  `anulado` int(11) DEFAULT '0',
  PRIMARY KEY (`idForma`)
) ENGINE=InnoDB AUTO_INCREMENT=986 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.formalibre: ~0 rows (aproximadamente)
DELETE FROM `formalibre`;

-- Volcando estructura para tabla wcafedb.gasto
CREATE TABLE IF NOT EXISTS `gasto` (
  `idgasto` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `numgasto` int(11) DEFAULT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `control` varchar(20) DEFAULT '00-00',
  `descripcion` varchar(100) DEFAULT NULL,
  `monto` float(9,3) DEFAULT NULL,
  `base` float(9,3) DEFAULT '0.000',
  `iva` float(9,3) DEFAULT '0.000',
  `exento` float(9,3) DEFAULT '0.000',
  `tasa` float(9,3) DEFAULT '0.000',
  `saldo` float(9,3) DEFAULT NULL,
  `retenido` int(11) DEFAULT '0',
  `fecha` date DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  PRIMARY KEY (`idgasto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.gasto: ~0 rows (aproximadamente)
DELETE FROM `gasto`;

-- Volcando estructura para tabla wcafedb.ingreso
CREATE TABLE IF NOT EXISTS `ingreso` (
  `idingreso` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idproveedor` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(20) NOT NULL,
  `num_comprobante` varchar(20) NOT NULL,
  `fecha_hora` date NOT NULL,
  `emision` date DEFAULT NULL,
  `impuesto` int(11) NOT NULL,
  `total` float(11,2) NOT NULL,
  `base` float(9,3) DEFAULT NULL,
  `miva` float(9,3) DEFAULT NULL,
  `exento` float(9,3) DEFAULT NULL,
  `isaea` float(9,3) DEFAULT '0.000',
  `saldo` float(11,2) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT '0',
  `tasa` float(9,3) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `retenido` float(9,3) DEFAULT '0.000',
  PRIMARY KEY (`idingreso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ingreso: ~0 rows (aproximadamente)
DELETE FROM `ingreso`;

-- Volcando estructura para tabla wcafedb.kardex
CREATE TABLE IF NOT EXISTS `kardex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `iddoc` int(11) DEFAULT '0',
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` float(9,3) DEFAULT NULL,
  `exis_ant` float(9,3) DEFAULT '0.000',
  `costo` float(9,3) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.kardex: ~0 rows (aproximadamente)
DELETE FROM `kardex`;

-- Volcando estructura para tabla wcafedb.listbanco
CREATE TABLE IF NOT EXISTS `listbanco` (
  `idbanco` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefonos` varchar(20) DEFAULT NULL,
  `cuentaban` varchar(25) DEFAULT NULL,
  `tipocta` varchar(20) DEFAULT NULL,
  `titular` varchar(50) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `naturaleza` varchar(20) DEFAULT NULL,
  `moneda` int(11) DEFAULT '0',
  PRIMARY KEY (`idbanco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.listbanco: ~0 rows (aproximadamente)
DELETE FROM `listbanco`;

-- Volcando estructura para tabla wcafedb.metas
CREATE TABLE IF NOT EXISTS `metas` (
  `idmeta` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(40) DEFAULT NULL,
  `creado` date NOT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  `cumplimiento` float(9,3) DEFAULT '0.000',
  `cntarticulos` int(11) DEFAULT NULL,
  `valormeta` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`idmeta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.metas: ~0 rows (aproximadamente)
DELETE FROM `metas`;

-- Volcando estructura para tabla wcafedb.metasvendedor
CREATE TABLE IF NOT EXISTS `metasvendedor` (
  `idmeta` int(11) NOT NULL AUTO_INCREMENT,
  `idvendedor` int(11) DEFAULT NULL,
  `metodo` int(11) DEFAULT '0',
  `descripcion` varchar(40) DEFAULT NULL,
  `creado` date NOT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  `cumplimiento` float(9,3) DEFAULT '0.000',
  `cntarticulos` int(11) DEFAULT NULL,
  `particulos` int(11) DEFAULT NULL,
  `valormeta` float(9,3) DEFAULT NULL,
  `nclientes` int(11) DEFAULT NULL,
  `pnclientes` float(6,2) DEFAULT '0.00',
  `cobranza` float(9,3) DEFAULT NULL,
  `pcobranza` float(6,2) DEFAULT '0.00',
  `reactivar` int(11) DEFAULT NULL,
  `pactivar` int(11) DEFAULT '0',
  `preactivar` float(6,2) DEFAULT '0.00',
  `crecimiento` int(11) DEFAULT '0',
  `pcrecimiento` float(5,2) DEFAULT '0.00',
  `pcomision` int(11) DEFAULT '0',
  PRIMARY KEY (`idmeta`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.metasvendedor: ~0 rows (aproximadamente)
DELETE FROM `metasvendedor`;

-- Volcando estructura para tabla wcafedb.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla wcafedb.migrations: ~2 rows (aproximadamente)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('2014_10_12_000000_create_users_table', 1),
	('2014_10_12_100000_create_password_resets_table', 1);

-- Volcando estructura para tabla wcafedb.monedas
CREATE TABLE IF NOT EXISTS `monedas` (
  `idmoneda` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `codigo` varchar(5) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `simbolo` char(4) DEFAULT NULL,
  PRIMARY KEY (`idmoneda`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.monedas: ~6 rows (aproximadamente)
DELETE FROM `monedas`;
INSERT INTO `monedas` (`idmoneda`, `idempresa`, `codigo`, `nombre`, `tipo`, `simbolo`) VALUES
	(1, 1, '005', 'Dolares Efect.', 0, '$'),
	(2, 1, '004', 'Dolares Transf.', 0, '$'),
	(3, 1, '003', 'Pesos', 2, 'Ps'),
	(4, 2, '001', 'Bolivares Efect.', 1, 'Bs'),
	(5, 2, '003', 'Provincial', 1, 'Bs'),
	(6, 2, '005', 'Dolares efectivo', 0, '$');

-- Volcando estructura para tabla wcafedb.movimientos
CREATE TABLE IF NOT EXISTS `movimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(8) DEFAULT NULL,
  `deposito` int(11) DEFAULT NULL,
  `articulo` int(11) DEFAULT NULL,
  `exisant` float(9,3) DEFAULT NULL,
  `cnt` float(9,3) DEFAULT '0.000',
  `existmov` float(9,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.movimientos: ~0 rows (aproximadamente)
DELETE FROM `movimientos`;

-- Volcando estructura para tabla wcafedb.mov_ban
CREATE TABLE IF NOT EXISTS `mov_ban` (
  `id_mov` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idcaja` int(11) DEFAULT NULL,
  `tipodoc` char(4) DEFAULT '0',
  `iddocumento` int(11) DEFAULT '0',
  `tipo_mov` text,
  `numero` varchar(20) DEFAULT NULL,
  `concepto` varchar(40) DEFAULT NULL,
  `tipo_per` char(2) DEFAULT NULL,
  `idbeneficiario` int(11) DEFAULT '0',
  `identificacion` varchar(20) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `monto` double(15,3) DEFAULT NULL,
  `tasadolar` double(15,3) DEFAULT NULL,
  `fecha_mov` datetime DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  `user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_mov`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.mov_ban: ~0 rows (aproximadamente)
DELETE FROM `mov_ban`;

-- Volcando estructura para tabla wcafedb.mov_notas
CREATE TABLE IF NOT EXISTS `mov_notas` (
  `id_mov` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `tipodoc` varchar(5) DEFAULT NULL,
  `iddoc` int(11) DEFAULT NULL,
  `monto` float(9,3) DEFAULT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  PRIMARY KEY (`id_mov`)
) ENGINE=InnoDB AUTO_INCREMENT=4322 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.mov_notas: ~0 rows (aproximadamente)
DELETE FROM `mov_notas`;

-- Volcando estructura para tabla wcafedb.mov_notasp
CREATE TABLE IF NOT EXISTS `mov_notasp` (
  `id_mov` int(11) NOT NULL AUTO_INCREMENT,
  `tipodoc` varchar(5) DEFAULT NULL,
  `iddoc` int(11) DEFAULT NULL,
  `monto` float(9,3) DEFAULT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  PRIMARY KEY (`id_mov`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.mov_notasp: ~0 rows (aproximadamente)
DELETE FROM `mov_notasp`;

-- Volcando estructura para tabla wcafedb.municipios
CREATE TABLE IF NOT EXISTS `municipios` (
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla wcafedb.municipios: ~24 rows (aproximadamente)
DELETE FROM `municipios`;
INSERT INTO `municipios` (`id_municipio`, `id_estado`, `municipio`) VALUES
	(0, 0, 'No Asignado'),
	(179, 13, 'Alberto Adriani'),
	(180, 13, 'Andrés Bello'),
	(181, 13, 'Antonio Pinto Salinas'),
	(182, 13, 'Aricagua'),
	(183, 13, 'Arzobispo Chacón'),
	(184, 13, 'Campo Elías'),
	(185, 13, 'Caracciolo Parra Olmedo'),
	(186, 13, 'Cardenal Quintero'),
	(187, 13, 'Guaraque'),
	(188, 13, 'Julio César Salas'),
	(189, 13, 'Justo Briceño'),
	(190, 13, 'Libertador'),
	(191, 13, 'Miranda'),
	(192, 13, 'Obispo Ramos de Lora'),
	(193, 13, 'Padre Noguera'),
	(194, 13, 'Pueblo Llano'),
	(195, 13, 'Rangel'),
	(196, 13, 'Rivas Dávila'),
	(197, 13, 'Santos Marquina'),
	(198, 13, 'Sucre'),
	(199, 13, 'Tovar'),
	(200, 13, 'Tulio Febres Cordero'),
	(201, 13, 'Zea');

-- Volcando estructura para tabla wcafedb.notasadm
CREATE TABLE IF NOT EXISTS `notasadm` (
  `idnota` int(11) NOT NULL AUTO_INCREMENT,
  `numnota` int(11) DEFAULT NULL,
  `idempresa` int(11) DEFAULT '1',
  `tipo` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `descripcion` varchar(20) DEFAULT NULL,
  `referencia` varchar(20) NOT NULL,
  `monto` float(9,3) NOT NULL,
  `fecha` date DEFAULT NULL,
  `pendiente` float(9,3) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idnota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.notasadm: ~0 rows (aproximadamente)
DELETE FROM `notasadm`;

-- Volcando estructura para tabla wcafedb.notasadmp
CREATE TABLE IF NOT EXISTS `notasadmp` (
  `idnota` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `numnota` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `descripcion` varchar(20) DEFAULT NULL,
  `referencia` varchar(20) NOT NULL,
  `monto` float(9,3) NOT NULL,
  `fecha` date DEFAULT NULL,
  `pendiente` float(9,3) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idnota`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.notasadmp: ~0 rows (aproximadamente)
DELETE FROM `notasadmp`;

-- Volcando estructura para tabla wcafedb.parroquias
CREATE TABLE IF NOT EXISTS `parroquias` (
  `id_parroquia` int(11) NOT NULL AUTO_INCREMENT,
  `idmunicipio` int(11) NOT NULL,
  `parroquia` varchar(250) NOT NULL,
  PRIMARY KEY (`id_parroquia`),
  KEY `id_municipio` (`idmunicipio`)
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla wcafedb.parroquias: ~87 rows (aproximadamente)
DELETE FROM `parroquias`;
INSERT INTO `parroquias` (`id_parroquia`, `idmunicipio`, `parroquia`) VALUES
	(0, 0, 'No Asignado'),
	(515, 179, 'Presidente Betancourt'),
	(516, 179, 'Presidente Páez'),
	(517, 179, 'Presidente Rómulo Gallegos'),
	(518, 179, 'Gabriel Picón González'),
	(519, 179, 'Héctor Amable Mora'),
	(520, 179, 'José Nucete Sardi'),
	(521, 179, 'Pulido Méndez'),
	(522, 180, 'La Azulita'),
	(523, 181, 'Santa Cruz de Mora'),
	(524, 181, 'Mesa Bolívar'),
	(525, 181, 'Mesa de Las Palmas'),
	(526, 182, 'Aricagua'),
	(527, 182, 'San Antonio'),
	(528, 183, 'Canagua'),
	(529, 183, 'Capurí'),
	(530, 183, 'Chacantá'),
	(531, 183, 'El Molino'),
	(532, 183, 'Guaimaral'),
	(533, 183, 'Mucutuy'),
	(534, 183, 'Mucuchachí'),
	(535, 184, 'Fernández Peña'),
	(536, 184, 'Matriz'),
	(537, 184, 'Montalbán'),
	(538, 184, 'Acequias'),
	(539, 184, 'Jají'),
	(540, 184, 'La Mesa'),
	(541, 184, 'San José del Sur'),
	(542, 185, 'Tucaní'),
	(543, 185, 'Florencio Ramírez'),
	(544, 186, 'Santo Domingo'),
	(545, 186, 'Las Piedras'),
	(546, 187, 'Guaraque'),
	(547, 187, 'Mesa de Quintero'),
	(548, 187, 'Río Negro'),
	(549, 188, 'Arapuey'),
	(550, 188, 'Palmira'),
	(551, 189, 'San Cristóbal de Torondoy'),
	(552, 189, 'Torondoy'),
	(553, 190, 'Antonio Spinetti Dini'),
	(554, 190, 'Arias'),
	(555, 190, 'Caracciolo Parra Pérez'),
	(556, 190, 'Domingo Peña'),
	(557, 190, 'El Llano'),
	(558, 190, 'Gonzalo Picón Febres'),
	(559, 190, 'Jacinto Plaza'),
	(560, 190, 'Juan Rodríguez Suárez'),
	(561, 190, 'Lasso de la Vega'),
	(562, 190, 'Mariano Picón Salas'),
	(563, 190, 'Milla'),
	(564, 190, 'Osuna Rodríguez'),
	(565, 190, 'Sagrario'),
	(566, 190, 'El Morro'),
	(567, 190, 'Los Nevados'),
	(568, 191, 'Andrés Eloy Blanco'),
	(569, 191, 'La Venta'),
	(570, 191, 'Piñango'),
	(571, 191, 'Timotes'),
	(572, 192, 'Eloy Paredes'),
	(573, 192, 'San Rafael de Alcázar'),
	(574, 192, 'Santa Elena de Arenales'),
	(575, 193, 'Santa María de Caparo'),
	(576, 194, 'Pueblo Llano'),
	(577, 195, 'Cacute'),
	(578, 195, 'La Toma'),
	(579, 195, 'Mucuchíes'),
	(580, 195, 'Mucurubá'),
	(581, 195, 'San Rafael'),
	(582, 196, 'Gerónimo Maldonado'),
	(583, 196, 'Bailadores'),
	(584, 197, 'Tabay'),
	(585, 198, 'Chiguará'),
	(586, 198, 'Estánquez'),
	(587, 198, 'Lagunillas'),
	(588, 198, 'La Trampa'),
	(589, 198, 'Pueblo Nuevo del Sur'),
	(590, 198, 'San Juan'),
	(591, 199, 'El Amparo'),
	(592, 199, 'El Llano'),
	(593, 199, 'San Francisco'),
	(594, 199, 'Tovar'),
	(595, 200, 'Independencia'),
	(596, 200, 'María de la Concepción Palacios Blanco'),
	(597, 200, 'Nueva Bolivia'),
	(598, 200, 'Santa Apolonia'),
	(599, 201, 'Caño El Tigre'),
	(600, 201, 'Zea');

-- Volcando estructura para tabla wcafedb.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla wcafedb.password_resets: ~0 rows (aproximadamente)
DELETE FROM `password_resets`;

-- Volcando estructura para tabla wcafedb.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `idpedido` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `concepto` varchar(50) NOT NULL,
  `responsable` varchar(30) NOT NULL,
  `total_pedido` float(11,2) NOT NULL,
  `fecha` date DEFAULT NULL,
  `user` varchar(15) NOT NULL,
  PRIMARY KEY (`idpedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.pedidos: ~0 rows (aproximadamente)
DELETE FROM `pedidos`;

-- Volcando estructura para tabla wcafedb.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla wcafedb.personal_access_tokens: ~0 rows (aproximadamente)
DELETE FROM `personal_access_tokens`;

-- Volcando estructura para tabla wcafedb.pmolida
CREATE TABLE IF NOT EXISTS `pmolida` (
  `idm` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT NULL,
  `responsable` varchar(80) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `kgmprima` float(9,3) DEFAULT NULL,
  `tipo` int(11) DEFAULT '0' COMMENT 'empaquetado',
  `producto` int(11) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `tkilos` float(9,3) DEFAULT NULL,
  `reduccionm` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`idm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.pmolida: ~0 rows (aproximadamente)
DELETE FROM `pmolida`;

-- Volcando estructura para tabla wcafedb.presentacion
CREATE TABLE IF NOT EXISTS `presentacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idarticulo` int(11) DEFAULT NULL,
  `descripcion` varchar(10) DEFAULT NULL,
  `cantidad` int(11) DEFAULT '0',
  `costo` float(9,3) DEFAULT '0.000',
  `utilidad` float(9,3) DEFAULT '0.000',
  `preciov` float(9,3) DEFAULT '0.000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.presentacion: ~0 rows (aproximadamente)
DELETE FROM `presentacion`;

-- Volcando estructura para tabla wcafedb.produccion
CREATE TABLE IF NOT EXISTS `produccion` (
  `idproduccion` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT NULL,
  `responsable` varchar(50) DEFAULT NULL,
  `encargado` varchar(50) DEFAULT NULL,
  `idmprima` int(11) DEFAULT NULL,
  `kgsubido` float(9,3) DEFAULT NULL,
  `kgmolidos` float(9,3) DEFAULT NULL,
  `reduccion` float(9,3) DEFAULT NULL,
  `idproductofinal` int(11) DEFAULT NULL,
  `tipoemp` int(11) DEFAULT NULL,
  `kgempa` float(9,3) DEFAULT NULL,
  `kgdif` float(9,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idproduccion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.produccion: ~0 rows (aproximadamente)
DELETE FROM `produccion`;

-- Volcando estructura para tabla wcafedb.proveedor
CREATE TABLE IF NOT EXISTS `proveedor` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `nombre` varchar(50) NOT NULL,
  `rif` varchar(15) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `contacto` varchar(80) DEFAULT NULL,
  `estatus` varchar(1) NOT NULL,
  `idbanco` char(1) DEFAULT 'P',
  `tpersona` int(11) DEFAULT '1',
  PRIMARY KEY (`idproveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.proveedor: ~1 rows (aproximadamente)
DELETE FROM `proveedor`;
INSERT INTO `proveedor` (`idproveedor`, `idempresa`, `nombre`, `rif`, `direccion`, `telefono`, `contacto`, `estatus`, `idbanco`, `tpersona`) VALUES
	(1, 2, 'ASPROCAFE', 'J-412100726', 'CALLE EL PARAISO SECTOR EL TABACAL', '04166749157', 'JHONNY CONTRERAS', 'A', 'P', 1);

-- Volcando estructura para tabla wcafedb.ptostado
CREATE TABLE IF NOT EXISTS `ptostado` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `tostador` varchar(20) DEFAULT NULL,
  `idmaquina` int(11) DEFAULT '1',
  `cochas` int(11) DEFAULT NULL,
  `idmprima` int(11) DEFAULT NULL,
  `kgmprima` float(9,3) DEFAULT NULL,
  `kgtostado` float(9,3) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `comision` int(11) DEFAULT NULL,
  `kgcomi` float(9,3) DEFAULT '0.000',
  `comima` int(11) DEFAULT NULL,
  `kgcomima` float(9,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `responsable` varchar(20) NOT NULL,
  `reduccion` float(9,3) DEFAULT NULL,
  `devolu` int(11) DEFAULT '0',
  PRIMARY KEY (`idt`,`responsable`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ptostado: ~0 rows (aproximadamente)
DELETE FROM `ptostado`;

-- Volcando estructura para tabla wcafedb.recibos
CREATE TABLE IF NOT EXISTS `recibos` (
  `idrecibo` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `idventa` int(11) NOT NULL,
  `idnota` int(11) DEFAULT '0',
  `tiporecibo` char(2) DEFAULT 'P',
  `monto` float(11,2) NOT NULL,
  `idpago` int(11) NOT NULL,
  `id_banco` int(11) DEFAULT NULL,
  `idbanco` varchar(18) DEFAULT NULL,
  `recibido` float(11,2) NOT NULL,
  `tasab` float(11,2) NOT NULL,
  `tasap` float(11,2) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `aux` float(9,3) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuario` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idrecibo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.recibos: ~0 rows (aproximadamente)
DELETE FROM `recibos`;

-- Volcando estructura para tabla wcafedb.reciboscomision
CREATE TABLE IF NOT EXISTS `reciboscomision` (
  `id_recibo` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `id_comision` int(11) DEFAULT NULL,
  `monto` float(9,3) DEFAULT NULL,
  `observacion` varchar(80) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_recibo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.reciboscomision: ~0 rows (aproximadamente)
DELETE FROM `reciboscomision`;

-- Volcando estructura para tabla wcafedb.recibo_comision
CREATE TABLE IF NOT EXISTS `recibo_comision` (
  `id_recibo` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `id_comision` int(11) DEFAULT NULL,
  `monto` float(9,3) DEFAULT NULL,
  `idbanco` int(11) DEFAULT NULL,
  `recibido` float(9,3) DEFAULT NULL,
  `observacion` varchar(80) DEFAULT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `aux` float(9,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_recibo`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.recibo_comision: ~0 rows (aproximadamente)
DELETE FROM `recibo_comision`;

-- Volcando estructura para tabla wcafedb.reglacomision
CREATE TABLE IF NOT EXISTS `reglacomision` (
  `idregla` int(11) NOT NULL AUTO_INCREMENT,
  `desde` int(11) DEFAULT NULL,
  `hasta` int(11) DEFAULT NULL,
  `porcentaje` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`idregla`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.reglacomision: ~4 rows (aproximadamente)
DELETE FROM `reglacomision`;
INSERT INTO `reglacomision` (`idregla`, `desde`, `hasta`, `porcentaje`) VALUES
	(1, 1, 8, 100.000),
	(2, 9, 22, 100.000),
	(3, 23, 30, 100.000),
	(4, 31, 1000, 100.000);

-- Volcando estructura para tabla wcafedb.reg_deposito
CREATE TABLE IF NOT EXISTS `reg_deposito` (
  `idreg` int(11) NOT NULL AUTO_INCREMENT,
  `deposito` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `debe` int(11) DEFAULT '0',
  `debo` int(11) DEFAULT '0',
  PRIMARY KEY (`idreg`)
) ENGINE=InnoDB AUTO_INCREMENT=680 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.reg_deposito: ~0 rows (aproximadamente)
DELETE FROM `reg_deposito`;

-- Volcando estructura para tabla wcafedb.relacionnc
CREATE TABLE IF NOT EXISTS `relacionnc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmov` int(11) DEFAULT NULL,
  `idnota` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4510 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.relacionnc: ~0 rows (aproximadamente)
DELETE FROM `relacionnc`;

-- Volcando estructura para tabla wcafedb.relacionncp
CREATE TABLE IF NOT EXISTS `relacionncp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmov` int(11) DEFAULT NULL,
  `idnota` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.relacionncp: ~0 rows (aproximadamente)
DELETE FROM `relacionncp`;

-- Volcando estructura para tabla wcafedb.retenc
CREATE TABLE IF NOT EXISTS `retenc` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `codtrib` varchar(20) DEFAULT '',
  `descrip` varchar(80) DEFAULT '',
  `beneficiar` double(2,0) NOT NULL DEFAULT '0',
  `base` double(20,7) NOT NULL DEFAULT '0.0000000',
  `ret` double(20,7) NOT NULL DEFAULT '0.0000000',
  `sustraend` double(20,7) NOT NULL DEFAULT '0.0000000',
  `superior` double(20,7) NOT NULL DEFAULT '0.0000000',
  `afiva` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla wcafedb.retenc: ~89 rows (aproximadamente)
DELETE FROM `retenc`;
INSERT INTO `retenc` (`codigo`, `codtrib`, `descrip`, `beneficiar`, `base`, `ret`, `sustraend`, `superior`, `afiva`) VALUES
	(1, '001', 'HONORARIOS, SUELDOS Y SALARIOS', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 1),
	(2, '002', '(PNR)-Honorarios Profesionales No Mercantiles', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(3, '003', '(PNNR)-Honorarios Profesionales No Mercantiles', 4, 90.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(4, '004', '(PJD)-Honorarios Profesionales No Mercantiles', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(5, '005', '(PJND)-Honorarios Profesionales No Mercantiles', 2, 90.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(6, '006', '(PNR)-Honorarios Profesionales Mancomunados No Mercantiles', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(7, '007', '(PNNR)-Honorarios Profesionales Mancomunados No Mercantiles', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(8, '008', '(PJD)-Honorarios Profesionales Mancomunados No Mercantiles', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(9, '055', '(PJND)-Honorarios Profesionales Mancomunados No Mercantiles', 2, 100.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(10, '010', '(PNR)-Honorarios Profesionales pagados a Jinetes, Veterinarios, Preparadores o E', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(11, '011', '(PNNR)-Honorarios Profesionales pagados a Jinetes, Veterinarios, Preparadores o', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(12, '012', '(PNR)-Honorarios Profesionales pagados por Clínicas, Hospitales, Centros de Salu', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(13, '013', '(PNNR)-Honorarios Profesionales pagados por Clínicas, Hospitales, Centros de Sal', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(14, '014', '(PNR)-Comisiones pagadas por la venta de bienes inmuebles', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(15, '015', '(PNNR)-Comisiones pagadas por la venta de bienes inmuebles', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(16, '016', '(PJD)-Comisiones pagadas por la venta de bienes inmuebles', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(17, '017', '(PJND)Comisiones pagadas por la venta de bienes inmuebles', 2, 100.0000000, 5.0000000, 0.0000000, 0.0100000, 0),
	(18, '018', '(PNR)-Cualquier otra Comisión distintas a Remuneraciones accesorias de los sueld', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(19, '019', '(PNNR)-Cualquier otra Comisión distintas a Remuneraciones accesorias de los suel', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(20, '020', '(PJD)-Cualquier otra Comisión distintas a Remuneraciones accesorias de los sueld', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(21, '021', '(PJND)-Cualquier otra Comisión distintas a Remuneraciones accesorias de los suel', 2, 100.0000000, 5.0000000, 0.0000000, 0.0100000, 0),
	(22, '022', '(PNNR)-Intereses de Capitales tomados en préstamo e invertidos en la producción', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(23, '023', '(PJND)-Intereses de Capitales tomados en préstamo e invertidos en la producción', 2, 100.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(24, '024', '(PJND)-Intereses provenientes de prestamos y otros creditos pagaderos a instituc', 2, 100.0000000, 4.9500000, 0.0000000, 0.0100000, 0),
	(25, '025', '(PNR)-Intereses pagados por las personas jurídicas o comunidades a cualquier otr', 4, 100.0000000, 3.0000000, 0.0000000, 0.0000000, 0),
	(26, '026', '(PNNR)-Intereses pagados por las personas jurídicas o comunidades a cualquier ot', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(27, '027', '(PJD)-Intereses pagados por las personas jurídicas o comunidades a cualquier otr', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(28, '028', '(PJND)-Intereses pagados por las personas jurídicas o comunidades a cualquier ot', 4, 100.0000000, 15.0000000, 0.0000000, 0.0000000, 0),
	(29, '029', '(PJND)-Enriquecimientos Netos de las Agencias Internacionales cuando el pagador', 2, 100.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(30, '030', '(PNNR)-Enriquecimientos Netos de Gastos de Transporte conformados por fletes pag', 4, 100.0000000, 15.0000000, 0.0000000, 0.0000000, 0),
	(31, '031', '(PJND)-Enriquecimientos Netos de Gastos de Transporte conformados por fletes pag', 2, 100.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(32, '032', '(PNNR)-Enriquecimientos Netos de Exhibición de Películas, Cine o la Televisión', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(33, '033', '(PJND)-Enriquecimientos Netos de Exhibición de Películas, Cine o la Televisión', 2, 100.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(34, '034', '(PNNR)-Enriquecimientos obtenidos por concepto de regalías y demás participacion', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(35, '035', '(PJND)-Enriquecimientos obtenidos por concepto de regalías y demás participacion', 4, 100.0000000, 15.0000000, 0.0000000, 0.0000000, 0),
	(36, '036', '(PNNR)-Enriquecimientos obtenidos por las Remuneraciones, Honorarios y pagos aná', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(37, '037', '(PJND)-Enriquecimientos obtenidos por las Remuneraciones, Honorarios y pagos aná', 2, 100.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(38, '038', '(PNNR)-Enriquecimientos obtenidos por Servicios Tecnológicos utilizados en el pa', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(39, '039', '(PJND)-Enriquecimientos obtenidos por Servicios Tecnológicos utilizados en el pa', 2, 100.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(40, '040', '(PJND)-Enriquecimientos Netos derivados de las Primas de Seguros y Reaseguros', 2, 100.0000000, 10.0000000, 0.0000000, 0.0100000, 0),
	(41, '041', '(PNR)-Ganancias Obtenidas por Juegos y Apuestas', 3, 100.0000000, 34.0000000, 2125.0000000, 70833.3300000, 0),
	(42, '042', '(PNNR)-Ganancias Obtenidas por Juegos y Apuestas', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(43, '043', '(PJD)-Ganancias Obtenidas por Juegos y Apuestas', 1, 100.0000000, 34.0000000, 0.0000000, 25.0000000, 0),
	(44, '044', '(PJND)-Ganancias Obtenidas por Juegos y Apuestas', 2, 100.0000000, 34.0000000, 0.0000000, 0.0100000, 0),
	(45, '045', '(PNR)-Ganancias Obtenidas por Premios de Loterías y de Hipódromos', 3, 100.0000000, 16.0000000, 2125.0000000, 70833.3300000, 0),
	(46, '046', '(PNNR)-Ganancias Obtenidas por Premios de Loterías y de Hipódromos', 4, 100.0000000, 16.0000000, 0.0000000, 0.0000000, 0),
	(47, '047', '(PJD)-Ganancias Obtenidas por Premios de Loterías y de Hipódromos', 1, 100.0000000, 16.0000000, 0.0000000, 25.0000000, 0),
	(48, '048', '(PJND)-Ganancias Obtenidas por Premios de Loterías y de Hipódromos', 2, 100.0000000, 16.0000000, 0.0000000, 0.0100000, 0),
	(49, '049', '(PNR)-Pagos a Propietarios de Animales de Carrera por concepto de Premios', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(50, '050', '(PNNR)-Pagos a Propietarios de Animales de Carrera por concepto de Premios', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(51, '051', '(PJD)-Pagos a Propietarios de Animales de Carrera por concepto de Premios', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(52, '052', '(PJND)-Pagos a Propietarios de Animales de Carrera por concepto de Premios', 2, 100.0000000, 5.0000000, 0.0000000, 0.0100000, 0),
	(53, '053', '(PNR)-Pagos a Empresas Contratistas o Subcontratistas domiciliadas o no en el pa', 3, 100.0000000, 1.0000000, 2125.0000000, 70833.3300000, 0),
	(54, '054', '(PNNR)-Pagos a Empresas Contratistas o Subcontratistas domiciliadas o no en el p', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(55, '055', '(PJD)-Pagos a Empresas Contratistas o Subcontratistas domiciliadas o no en el pa', 1, 100.0000000, 2.0000000, 0.0000000, 25.0000000, 0),
	(56, '056', '(PJND)-Pagos a Empresas Contratistas o Subcontratistas domiciliadas o no en el p', 2, 100.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(57, '057', '(PNR)-Pagos de los Arrendadores de bienes inmuebles situados en el pais', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(58, '058', '(PNNR)-Pagos de los Arrendadores de bienes inmuebles situados en el pais', 4, 90.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(59, '059', '(PJD)-Pagos de los Arrendadores de bienes inmuebles situados en el pais', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(60, '060', '(PJND)-Pagos de los Arrendadores de bienes inmuebles situados en el pais', 2, 90.0000000, 15.0000000, 0.0000000, 0.0100000, 0),
	(61, '061', '(PNR)-Cánones de Arrendamientos de Bienes Muebles situados en el país', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(62, '062', '(PNNR)-Cánones de Arrendamientos de Bienes Muebles situados en el país', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(63, '063', '(PJD)-Cánones de Arrendamientos de Bienes Muebles situados en el país', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(64, '064', '(PJND)-Cánones de Arrendamientos de Bienes Muebles situados en el país', 2, 100.0000000, 5.0000000, 0.0000000, 0.0100000, 0),
	(65, '065', '(PNR)-Pagos de las Empresas Emisoras de Tarjetas de Crédito o Consumo por la Ven', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(66, '066', '(PNNR)-Pagos de las Empresas Emisoras de Tarjetas de Crédito o Consumo por la Ve', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(67, '067', '(PJD)-Pagos de las Empresas Emisoras de Tarjetas de Crédito o Consumo por la Ven', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(68, '068', '(PJND)-Pagos de las Empresas Emisoras de Tarjetas de Crédito o Consumo por la Ve', 2, 100.0000000, 5.0000000, 0.0000000, 0.0100000, 0),
	(69, '069', '(PNR)-Pagos de las Empresas Emisoras de Tarjetas de Crédito por la venta de gaso', 3, 100.0000000, 1.0000000, 2125.0000000, 70833.3300000, 0),
	(70, '070', '(PJD)-Pagos de las Empresas Emisoras de Tarjetas de Crédito por la venta de gaso', 1, 100.0000000, 1.0000000, 0.0000000, 25.0000000, 0),
	(71, '071', '(PNR)-Pagos por Gastos de Transporte conformados por Fletes', 3, 100.0000000, 1.0000000, 708.3300000, 70833.3300000, 0),
	(72, '072', '(PJD)-Pagos por Gastos de Transporte conformados por Fletes', 1, 100.0000000, 3.0000000, 0.0000000, 25.0000000, 0),
	(73, '073', '(PNR)-Pagos de las Empresas de Seguro, las Sociedades de Corretaje de Seguros y', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(74, '074', '(PJD)-Pagos de las Empresas de Seguro, las Sociedades de Corretaje de Seguros y', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(75, '075', '(PNR)-Pagos de las Empresas de Seguro a sus Contratistas por la Reparación de Da', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(76, '076', '(PJD)-Pagos de las Empresas de Seguro a sus Contratistas por la Reparación de Da', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(77, '077', '(PNR)-Pagos de las Empresas de Seguros a Clínicas, Hospitales y/o Centros de Sal', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(78, '078', '(PJD)-Pagos de las Empresas de Seguros a Clínicas, Hospitales y/o Centros de Sal', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(79, '079', '(PNR)-Cantidades que se paguen por adquisición de Fondos de Comercio situados en', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(80, '080', '(PNNR)-Cantidades que se paguen por adquisición de Fondos de Comercio situados e', 4, 100.0000000, 34.0000000, 0.0000000, 0.0000000, 0),
	(81, '081', '(PJD)-Cantidades que se paguen por adquisición de Fondos de Comercio situados en', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(82, '082', '(PJND)-Cantidades que se paguen por adquisición de Fondos de Comercio situados e', 2, 100.0000000, 5.0000000, 0.0000000, 0.0100000, 0),
	(83, '083', '(PNR)-Pagos por Servicios de Publicidad y Propaganda y la Cesión de la Venta de', 3, 100.0000000, 3.0000000, 2125.0000000, 70833.3300000, 0),
	(84, '084', '(PJD)-Pagos por Servicios de Publicidad y Propaganda y la Cesión de la Venta de', 1, 100.0000000, 5.0000000, 0.0000000, 25.0000000, 0),
	(85, '085', '(PJND)-Pagos por Servicios de Publicidad y Propaganda y la Cesión de la Venta de', 2, 100.0000000, 5.0000000, 0.0000000, 0.0100000, 0),
	(86, '086', '(PJD)-Pagos por Servicios de Publicidad y Propaganda y la Cesión de la Venta de', 1, 100.0000000, 3.0000000, 0.0000000, 25.0000000, 0),
	(87, '', 'RETENCION 100% DEL IVA A PROVEEDORES', 1, 100.0000000, 100.0000000, 0.0000000, 0.0000000, 1),
	(88, '', 'RETENCION 75% DEL IVA A PROVEEDORES', 1, 100.0000000, 75.0000000, 0.0000000, 0.0000000, 1),
	(89, '', 'PRESTACION DE SERVICIO ALCALDIA', 1, 100.0000000, 1.0000000, 0.0000000, 0.0000000, 0);

-- Volcando estructura para tabla wcafedb.retenciones
CREATE TABLE IF NOT EXISTS `retenciones` (
  `idretencion` int(11) NOT NULL AUTO_INCREMENT,
  `idingreso` int(11) DEFAULT '0',
  `idgasto` int(11) DEFAULT '0',
  `idproveedor` int(11) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `correlativo` int(11) DEFAULT '0',
  `retenc` int(11) DEFAULT NULL,
  `mfac` double(15,3) DEFAULT NULL,
  `mbase` float(10,3) DEFAULT NULL,
  `miva` float(9,3) DEFAULT NULL,
  `mexento` float(10,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `mret` float(9,3) DEFAULT NULL,
  `mretd` float(9,3) DEFAULT NULL,
  `anulada` int(11) DEFAULT '0',
  PRIMARY KEY (`idretencion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.retenciones: ~0 rows (aproximadamente)
DELETE FROM `retenciones`;

-- Volcando estructura para tabla wcafedb.retencionventas
CREATE TABLE IF NOT EXISTS `retencionventas` (
  `idret` int(11) NOT NULL AUTO_INCREMENT,
  `idfactura` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `comprobante` varchar(20) DEFAULT NULL,
  `pretencion` int(11) DEFAULT NULL,
  `impuesto` float(9,3) DEFAULT NULL,
  `mretbs` float(9,3) DEFAULT NULL,
  `mretd` float(9,3) DEFAULT NULL,
  `mfactura` double(15,3) DEFAULT NULL,
  `tasa` float(9,3) DEFAULT NULL,
  `fecharegistro` date DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `mes` int(11) DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idret`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.retencionventas: ~0 rows (aproximadamente)
DELETE FROM `retencionventas`;

-- Volcando estructura para tabla wcafedb.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) DEFAULT NULL,
  `newproveedor` int(11) DEFAULT '0',
  `editproveedor` int(11) DEFAULT '0',
  `edoctap` int(11) DEFAULT '0',
  `newvendedor` int(11) DEFAULT '0',
  `editvendedor` int(11) DEFAULT '0',
  `actvendedor` int(11) DEFAULT '0',
  `newcliente` int(11) DEFAULT '0',
  `editcliente` int(11) DEFAULT '0',
  `edocta` int(11) DEFAULT '0',
  `actcliente` int(11) DEFAULT '0',
  `newarticulo` int(11) DEFAULT '0',
  `editarticulo` int(11) DEFAULT '0',
  `crearcompra` int(11) DEFAULT '0',
  `anularcompra` int(11) DEFAULT '0',
  `importarne` int(11) DEFAULT '0',
  `crearventa` int(11) DEFAULT '0',
  `anularventa` int(11) DEFAULT '0',
  `cambiarprecioventa` int(11) DEFAULT '0',
  `crearfl` int(11) DEFAULT '0',
  `anularfl` int(11) DEFAULT '0',
  `importarfl` int(11) DEFAULT '0',
  `crearfe` int(11) DEFAULT '0',
  `editarfe` int(11) DEFAULT '0',
  `anularfe` int(11) DEFAULT '0',
  `crearpedido` int(11) DEFAULT '0',
  `editpedido` int(11) DEFAULT '0',
  `anularpedido` int(11) DEFAULT '0',
  `importarpedido` int(11) DEFAULT '0',
  `crearajuste` int(11) DEFAULT '0',
  `abonarcxc` int(11) DEFAULT '0',
  `creargasto` int(11) DEFAULT '0',
  `anulargasto` int(11) DEFAULT '0',
  `abonarcxp` int(11) DEFAULT '0',
  `abonargasto` int(11) DEFAULT '0',
  `vacios` int(11) DEFAULT '0',
  `newdepvendedor` int(11) DEFAULT '0',
  `comision` int(11) DEFAULT '0',
  `pcomision` int(11) DEFAULT '0',
  `acttasa` int(11) DEFAULT '0',
  `actroles` int(11) DEFAULT '0',
  `rventas` int(11) DEFAULT '0',
  `ccaja` int(11) DEFAULT '0',
  `rdetallei` int(11) DEFAULT '0',
  `rcxc` int(11) DEFAULT '0',
  `rcompras` int(11) DEFAULT '0',
  `rdetallec` int(11) DEFAULT '0',
  `rcxp` int(11) DEFAULT '0',
  `rinventario` int(11) DEFAULT '0',
  `web` int(11) DEFAULT '0',
  `updatepass` int(11) DEFAULT '0',
  `newbanco` int(11) DEFAULT '0',
  `accesobanco` int(11) DEFAULT '0',
  `edoctabanco` int(11) DEFAULT '0',
  `metae` int(11) DEFAULT '0',
  `metav` int(11) DEFAULT '0',
  `lventas` int(11) DEFAULT '0',
  `lcompras` int(11) DEFAULT '0',
  `valorizado` int(11) DEFAULT '0',
  `listap` int(11) DEFAULT '0',
  `resumeng` int(11) DEFAULT '0',
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.roles: ~7 rows (aproximadamente)
DELETE FROM `roles`;
INSERT INTO `roles` (`idrol`, `iduser`, `newproveedor`, `editproveedor`, `edoctap`, `newvendedor`, `editvendedor`, `actvendedor`, `newcliente`, `editcliente`, `edocta`, `actcliente`, `newarticulo`, `editarticulo`, `crearcompra`, `anularcompra`, `importarne`, `crearventa`, `anularventa`, `cambiarprecioventa`, `crearfl`, `anularfl`, `importarfl`, `crearfe`, `editarfe`, `anularfe`, `crearpedido`, `editpedido`, `anularpedido`, `importarpedido`, `crearajuste`, `abonarcxc`, `creargasto`, `anulargasto`, `abonarcxp`, `abonargasto`, `vacios`, `newdepvendedor`, `comision`, `pcomision`, `acttasa`, `actroles`, `rventas`, `ccaja`, `rdetallei`, `rcxc`, `rcompras`, `rdetallec`, `rcxp`, `rinventario`, `web`, `updatepass`, `newbanco`, `accesobanco`, `edoctabanco`, `metae`, `metav`, `lventas`, `lcompras`, `valorizado`, `listap`, `resumeng`) VALUES
	(1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
	(2, 2, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 1, 0, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1),
	(3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0),
	(4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
	(5, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0),
	(6, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0),
	(7, 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1);

-- Volcando estructura para tabla wcafedb.rutas
CREATE TABLE IF NOT EXISTS `rutas` (
  `idruta` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`idruta`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.rutas: ~5 rows (aproximadamente)
DELETE FROM `rutas`;
INSERT INTO `rutas` (`idruta`, `idempresa`, `nombre`, `descripcion`) VALUES
	(7, 2, 'SANTA CRUZ', 'SANTA CRUZ'),
	(8, 2, 'TOVAR', ''),
	(9, 2, 'BAILADORES', ''),
	(13, 2, 'EL ANIS / LAS PALMAS', ''),
	(14, 2, 'VENDEDORES', 'VENDEDORES');

-- Volcando estructura para tabla wcafedb.seriales
CREATE TABLE IF NOT EXISTS `seriales` (
  `idserial` int(11) NOT NULL AUTO_INCREMENT,
  `idcompra` int(11) DEFAULT '0',
  `idarticulo` int(11) DEFAULT NULL,
  `chasis` varchar(40) DEFAULT NULL,
  `motor` varchar(40) DEFAULT NULL,
  `placa` varchar(8) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `año` varchar(4) DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  `idventa` int(11) DEFAULT '0',
  `idapartado` int(11) DEFAULT '0',
  `iddetalleventa` int(11) DEFAULT '0',
  PRIMARY KEY (`idserial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.seriales: ~0 rows (aproximadamente)
DELETE FROM `seriales`;

-- Volcando estructura para tabla wcafedb.sistema
CREATE TABLE IF NOT EXISTS `sistema` (
  `idempresa` int(11) DEFAULT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechavence` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.sistema: ~2 rows (aproximadamente)
DELETE FROM `sistema`;
INSERT INTO `sistema` (`idempresa`, `fechainicio`, `fechavence`) VALUES
	(1, '2026-09-08', '2027-09-08'),
	(2, '2026-09-08', '2027-09-08');

-- Volcando estructura para tabla wcafedb.tostador
CREATE TABLE IF NOT EXISTS `tostador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `nombre` varchar(50) DEFAULT NULL,
  `cedula` varchar(20) DEFAULT '0',
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `kg` float(9,3) DEFAULT '0.000',
  `pendiente` float(9,3) DEFAULT '0.000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.tostador: ~2 rows (aproximadamente)
DELETE FROM `tostador`;
INSERT INTO `tostador` (`id`, `idempresa`, `nombre`, `cedula`, `telefono`, `direccion`, `kg`, `pendiente`) VALUES
	(2, 2, 'Wolfang Medina', '20828317', '0412155285', 'tabacal', 0.000, 0.000),
	(3, 2, 'Wuilmer Galindez', '1357898', '04125896378', 'el peñon', 0.000, 0.000);

-- Volcando estructura para tabla wcafedb.traslado
CREATE TABLE IF NOT EXISTS `traslado` (
  `idtraslado` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `concepto` varchar(50) NOT NULL,
  `responsable` varchar(30) NOT NULL,
  `total_traslado` float(11,2) NOT NULL,
  `fecha` date DEFAULT NULL,
  `user` varchar(15) NOT NULL,
  PRIMARY KEY (`idtraslado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.traslado: ~0 rows (aproximadamente)
DELETE FROM `traslado`;

-- Volcando estructura para tabla wcafedb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nivel` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idempresa` int(11) DEFAULT '0',
  `vendedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla wcafedb.users: ~7 rows (aproximadamente)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `nivel`, `foto`, `idempresa`, `vendedor`) VALUES
	(1, 'nks', 'nks@gmail.com', '$2y$10$K9STkiqITEqr6/31ni7Oyu2cOOhJ79GfwsM5FPGjYKRmHLTlJq7ba', 'uItAssbl2PZhkbg7D4OLP39q3TEAO5B47cBCdyszT45CGBzM41OQjO6T3YGJ', '2024-07-27 04:30:00', '2024-07-27 20:47:33', 'A', 'avatar5.png', 1, NULL),
	(2, 'Caja', 'cajanks@gmail.com', '$2y$10$M0q8eUguW/a5tHUwUx/ZHed9PS.7x/pTSYmVBXwllqVKRhljcxp9y', 'yLECyoVdfyXLSCyjVzDbSBuDSiiUoTum80QjA4S515WWQzQZokTJ7fijCThF', '2017-11-03 00:19:14', '2026-10-21 17:43:25', 'L', 'avatar2.png', 1, 2),
	(3, 'Administracion', 'administracion@gmail.com', '$2y$10$PHW0urRtUi9C7lJ7Ks3/3euKCuuI4O64ODlwAzHffDR3hkZEMA1hC', 'ioyj7QcyWQr3JsuVbWsWXQFAkuSEu0Z9lU9aNpfdo9Q7OWJRBwCszWWWggOQ', '2019-10-09 18:32:06', '2026-09-08 12:03:31', 'A', 'avatar04.png', 2, NULL),
	(4, 'caja', 'caja@gmail.com', '$2y$10$qb81uQn8OH4SFCtK6nXTdOWDDU9lPHi2r3GINtRXDEgznoaVl43Da', 'EN372SBSPaTCsuYr1xSxccoPrTVJSOSvTybwroeVi91Em7s5SpAzKq5qFiNG', '2022-02-22 15:23:43', '2026-10-21 17:55:25', 'L', 'avatar.png', 2, 7),
	(5, 'caja2', 'caja2@gmail.com', '$2y$10$JOzRE41w7H/jlfLNqqEx3ecC7ux/k5W5T43dVj/F3dCGE30P.PR.e', '8jcvk8ShTr5Osgoxxww83GfdQnJgLFZB2I3G19iHrEygTE1Ti1G4DNvlCnQQ', '2022-02-22 15:27:31', '2022-02-22 15:27:31', 'L', 'avatar.png', 2, NULL),
	(6, 'caja3', 'caja3@gmail.com', '$2y$10$MSaBRLY5kzclGcd00JC4P.dp.GZsrzoA04GtL/7iT65WFISDRCN7a', 'Px82PfQkL2peyL1mlhVrTlTyYa1EtvBd1If5Ccgr6dygL2cHJ8xamACU9iyT', '2022-02-22 15:30:02', '2022-02-22 15:30:02', 'L', 'avatar.png', 2, NULL),
	(7, 'Gerencia', 'gerencia@gmail.com', '$2y$10$Oj2laBLvOYGy0fMGLucmUOndbHix/f4RpmNcQA.u.w0caYXgdiDvS', 'QzXB0j0TFvhCkah8ZP32XedGA0AK9vdNsABaTkBaaM2GjHi1n4rgonszApEs', '2024-09-16 14:21:37', '2026-09-08 12:04:33', 'A', 'avatar3.png', 2, NULL);

-- Volcando estructura para tabla wcafedb.vendedores
CREATE TABLE IF NOT EXISTS `vendedores` (
  `idempresa` int(11) DEFAULT NULL,
  `id_vendedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `comision` int(11) DEFAULT '0',
  `cedula` varchar(20) DEFAULT NULL,
  `idbanco` char(1) DEFAULT 'V',
  `estatus` int(11) DEFAULT '1',
  PRIMARY KEY (`id_vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.vendedores: ~3 rows (aproximadamente)
DELETE FROM `vendedores`;
INSERT INTO `vendedores` (`idempresa`, `id_vendedor`, `nombre`, `telefono`, `direccion`, `comision`, `cedula`, `idbanco`, `estatus`) VALUES
	(1, 1, 'DIRECTO', '0000-0000000', 'SANTA CRUZ DE MORA', 0, 'v0000000', 'V', 1),
	(2, 6, 'DIRECTO', '000000000', 'SANTA CRUZ DE MORA', 0, 'V00000001', 'V', 1),
	(2, 7, 'TANIA LOPEZ', '04166749157', 'SANTA MARTA', 0, 'V-10903454', 'V', 1);

-- Volcando estructura para tabla wcafedb.venta
CREATE TABLE IF NOT EXISTS `venta` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT NULL,
  `idcliente` int(11) NOT NULL,
  `idvendedor` int(11) DEFAULT NULL,
  `pedido` int(11) DEFAULT '0',
  `tipo_comprobante` varchar(10) NOT NULL,
  `serie_comprobante` varchar(15) NOT NULL,
  `num_comprobante` int(11) NOT NULL,
  `forma` int(11) DEFAULT '0',
  `formato` int(11) DEFAULT '0',
  `tasa` float(9,4) DEFAULT '0.0000',
  `mcosto` float(9,3) DEFAULT '0.000',
  `mivaf` float(9,3) DEFAULT '0.000',
  `texe` float(9,3) DEFAULT '0.000',
  `total_venta` float(11,2) NOT NULL,
  `total_iva` float(9,3) DEFAULT '0.000',
  `mret` float(9,3) DEFAULT '0.000',
  `descuento` double(15,3) DEFAULT '0.000',
  `licor` int(11) DEFAULT '0',
  `total_pagar` float(9,3) DEFAULT '0.000',
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechahora` date DEFAULT NULL,
  `fecha_emi` date DEFAULT NULL,
  `fecha_fac` date DEFAULT NULL,
  `lastrecargo` date DEFAULT NULL,
  `impuesto` int(11) NOT NULL,
  `saldo` float(11,2) NOT NULL,
  `diascre` int(11) DEFAULT NULL,
  `estado` varchar(10) NOT NULL,
  `devolu` int(11) NOT NULL,
  `comision` double(8,3) DEFAULT '0.000',
  `montocomision` float(9,3) DEFAULT NULL,
  `idcomision` int(11) DEFAULT '0',
  `pweb` int(11) DEFAULT '0',
  `user` varchar(15) NOT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.venta: ~0 rows (aproximadamente)
DELETE FROM `venta`;

-- Volcando estructura para tabla wcafedb.ventaf
CREATE TABLE IF NOT EXISTS `ventaf` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `idvendedor` int(11) DEFAULT NULL,
  `pedido` int(11) DEFAULT '0',
  `tipo_comprobante` varchar(10) NOT NULL,
  `serie_comprobante` varchar(15) NOT NULL,
  `num_comprobante` int(11) NOT NULL,
  `forma` int(11) DEFAULT '0',
  `formato` int(11) DEFAULT '0',
  `tasa` float(9,4) DEFAULT '0.0000',
  `mcosto` float(9,3) DEFAULT '0.000',
  `mivaf` float(9,3) DEFAULT '0.000',
  `texe` float(9,3) DEFAULT '0.000',
  `total_venta` float(11,2) NOT NULL,
  `total_iva` float(9,3) DEFAULT '0.000',
  `mret` float(9,3) DEFAULT '0.000',
  `descuento` double(15,3) DEFAULT '0.000',
  `licor` int(11) DEFAULT '0',
  `total_pagar` float(9,3) DEFAULT '0.000',
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_emi` date DEFAULT NULL,
  `fecha_fac` date DEFAULT NULL,
  `impuesto` int(11) NOT NULL,
  `saldo` float(11,2) NOT NULL,
  `diascre` int(11) DEFAULT NULL,
  `estado` varchar(10) NOT NULL,
  `devolu` int(11) NOT NULL,
  `comision` double(8,3) DEFAULT '0.000',
  `montocomision` float(9,3) DEFAULT NULL,
  `idcomision` int(11) DEFAULT '0',
  `pweb` int(11) DEFAULT '0',
  `user` varchar(15) NOT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB AUTO_INCREMENT=7642 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ventaf: ~0 rows (aproximadamente)
DELETE FROM `ventaf`;

-- Volcando estructura para tabla wcafedb.ventasexternas
CREATE TABLE IF NOT EXISTS `ventasexternas` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `rif` varchar(20) DEFAULT NULL,
  `cliente` int(11) DEFAULT NULL,
  `serie` varchar(5) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT 'FAC',
  `factura` varchar(20) DEFAULT NULL,
  `control` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `totalventa` float(9,3) DEFAULT NULL,
  `base` float(9,3) DEFAULT NULL,
  `iva` float(9,3) DEFAULT NULL,
  `exento` float(9,3) DEFAULT NULL,
  `usuario` varchar(25) DEFAULT NULL,
  `fechareg` date DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ventasexternas: ~0 rows (aproximadamente)
DELETE FROM `ventasexternas`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
