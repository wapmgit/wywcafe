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
  `idajuste` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `numajuste` int(5) DEFAULT NULL,
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
  `idregistro` int(5) NOT NULL AUTO_INCREMENT,
  `entrada` int(5) DEFAULT '0',
  `salida` int(5) DEFAULT '0',
  `idarticulo` int(5) DEFAULT NULL,
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
  `idarticulo` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `idcategoria` int(5) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `stock` float(9,3) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `unidad` varchar(8) DEFAULT '0',
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
  `iva` int(3) NOT NULL,
  `fraccion` float(6,2) DEFAULT '1.00',
  `comi` int(3) DEFAULT '0',
  `pcomision` float(9,3) DEFAULT '0.000',
  `vacio` int(1) DEFAULT '0',
  `mprima` int(1) DEFAULT '0',
  `nivelp` int(2) DEFAULT '0',
  `pesogr` float(9,3) DEFAULT '0.000',
  `origen` varchar(20) DEFAULT 'N',
  `sevende` int(2) DEFAULT '1',
  PRIMARY KEY (`idarticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.articulo: ~10 rows (aproximadamente)
DELETE FROM `articulo`;
INSERT INTO `articulo` (`idarticulo`, `idempresa`, `idcategoria`, `codigo`, `nombre`, `stock`, `descripcion`, `unidad`, `volumen`, `grados`, `clase`, `imagen`, `estado`, `utilidad`, `precio1`, `precio2`, `precio_t`, `util2`, `costo`, `costo_t`, `iva`, `fraccion`, `comi`, `pcomision`, `vacio`, `mprima`, `nivelp`, `pesogr`, `origen`, `sevende`) VALUES
	(1, 1, 2, '21345', 'CAFE AZUL', 4475.000, '.', 'UND', NULL, NULL, NULL, '', 'Activo', 10.00, 3.89, 3.89, 0.000, 10.00, 3.50, 805.000, 0, 1.00, NULL, NULL, NULL, 1, 0, 0.000, NULL, NULL),
	(11, 2, 4, '2314', 'CAFE 100 GR', 0.000, '.', 'UND', NULL, NULL, NULL, '', 'Activo', 20.00, 1.32, 1.38, 0.000, 25.00, 1.10, 137.500, 0, 1.00, 0, NULL, NULL, 0, 0, 100.000, NULL, 1),
	(13, 2, 4, '03132', 'CAFE 250 GR', 0.000, '.', 'UND', NULL, NULL, NULL, '', 'Activo', 20.00, 4.20, 4.38, 0.000, 25.00, 3.50, 437.500, 0, 1.00, 0, NULL, NULL, 0, 0, 250.000, NULL, 1),
	(14, 1, 2, '12123', 'CAFE 100 GR', 1293.000, '.', 'UND', NULL, NULL, NULL, '', 'Activo', 10.00, 1.11, 1.11, 0.000, 10.00, 1.00, 230.000, 0, 1.00, 0, NULL, NULL, NULL, 3, 100.000, NULL, 1),
	(15, 1, 2, '345345', 'CAFE TOSTADO', 391.000, '.', 'UND', NULL, NULL, NULL, '', 'Activo', 20.00, 2.00, 2.13, 0.000, 25.00, 1.60, 0.000, 0, 0.10, 0, NULL, NULL, 1, 1, 1.000, NULL, 1),
	(16, 1, 1, '3123', 'CAFE 250', 732.000, '.', 'UND', NULL, NULL, NULL, '', 'Activo', 10.00, 3.89, 3.89, 0.000, 10.00, 3.50, 805.000, 0, 1.00, 0, NULL, NULL, NULL, 3, 250.000, NULL, 1),
	(17, 1, 3, '0217844', 'CAFE MOLIDO', 6.000, '.', 'UND', NULL, NULL, NULL, '', 'Activo', 20.00, 4.00, 4.27, 0.000, 25.00, 3.20, 0.000, 0, 0.10, 0, NULL, NULL, 1, 2, 1.000, NULL, NULL),
	(18, 1, 2, '015427', 'CAFE AZUL CANJE', 120.000, '.', 'UND', NULL, NULL, NULL, '', 'Activo', 20.00, 4.38, 4.67, 0.000, 25.00, 3.50, 0.000, 0, 0.10, NULL, NULL, NULL, 1, 0, 0.000, NULL, NULL),
	(19, 1, 6, '5354', 'AFE PAQUETE 100GR', 0.000, '', 'kg', NULL, NULL, NULL, '', 'Activo', 10.00, 1.11, 1.11, 0.000, 10.00, 1.00, 0.000, 0, 1.00, 0, NULL, NULL, 0, 0, 100.000, NULL, 1),
	(20, 1, 5, '6889', 'CAFE GORMET', 0.000, '', 'UND', NULL, NULL, NULL, '', 'Activo', 10.00, 11.11, 11.11, 0.000, 10.00, 10.00, 0.000, 0, 1.00, 0, NULL, NULL, 0, 0, 1.000, NULL, 1);

-- Volcando estructura para tabla wcafedb.articulometas
CREATE TABLE IF NOT EXISTS `articulometas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmeta` int(5) DEFAULT NULL,
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
  `idmeta` int(5) DEFAULT NULL,
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
  `idbloque` int(8) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `responsable` varchar(20) DEFAULT NULL,
  `articulos` float(9,3) NOT NULL DEFAULT '0.000',
  `estatus` int(2) DEFAULT '0',
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idbloque`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.bloques: ~0 rows (aproximadamente)
DELETE FROM `bloques`;

-- Volcando estructura para tabla wcafedb.caja
CREATE TABLE IF NOT EXISTS `caja` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `telefonos` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.caja: ~0 rows (aproximadamente)
DELETE FROM `caja`;

-- Volcando estructura para tabla wcafedb.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcategoria` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `idempresa` int(2) DEFAULT NULL,
  `descripcion` varchar(50) NOT NULL,
  `condicion` int(2) NOT NULL,
  `servicio` int(1) DEFAULT '0',
  `licor` int(2) DEFAULT '0',
  `tactil` int(2) DEFAULT '0',
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.categoria: ~0 rows (aproximadamente)
DELETE FROM `categoria`;

-- Volcando estructura para tabla wcafedb.categoriaclientes
CREATE TABLE IF NOT EXISTS `categoriaclientes` (
  `idcategoria` int(2) DEFAULT NULL,
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
  `id_cliente` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) DEFAULT '1',
  `nombre` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `codpais` varchar(4) DEFAULT '+58',
  `telefono` varchar(12) NOT NULL,
  `status` varchar(3) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `idmunicipio` int(3) DEFAULT '0',
  `idsector` int(3) DEFAULT '0',
  `tipo_cliente` int(1) NOT NULL,
  `categoria` int(2) DEFAULT '1',
  `retencion` int(3) DEFAULT '0',
  `contacto` varchar(50) DEFAULT NULL,
  `tipo_precio` int(1) NOT NULL,
  `vendedor` int(5) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `licencia` varchar(20) DEFAULT 'S/N',
  `diascre` int(5) DEFAULT '0',
  `recargo` int(2) DEFAULT '1',
  `ruta` int(2) DEFAULT '1',
  `idbanco` char(1) DEFAULT 'C',
  `ultventa` date DEFAULT NULL,
  `facanterior` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.clientes: ~0 rows (aproximadamente)
DELETE FROM `clientes`;

-- Volcando estructura para tabla wcafedb.comision
CREATE TABLE IF NOT EXISTS `comision` (
  `id_comision` int(5) NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(5) DEFAULT NULL,
  `montoventas` float(9,3) DEFAULT NULL,
  `montocomision` float(9,3) DEFAULT NULL,
  `idmeta` int(5) DEFAULT '0',
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
  `idempresa` int(2) DEFAULT '1',
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
  `idrecibo` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `idcompra` int(8) NOT NULL DEFAULT '0',
  `idgasto` int(5) DEFAULT '0',
  `idtostador` int(2) DEFAULT '0',
  `idmaquina` int(2) DEFAULT '0',
  `monto` float(11,2) NOT NULL,
  `idpago` int(3) NOT NULL,
  `idbanco` varchar(15) NOT NULL,
  `id_banco` int(5) DEFAULT '0',
  `recibido` float(12,3) NOT NULL,
  `tasab` float(11,2) NOT NULL,
  `tasap` float(9,3) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `aux` varchar(15) NOT NULL,
  `fecha_comp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idrecibo`)
) ENGINE=InnoDB AUTO_INCREMENT=1686 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.comprobante: ~0 rows (aproximadamente)
DELETE FROM `comprobante`;

-- Volcando estructura para tabla wcafedb.ctascon
CREATE TABLE IF NOT EXISTS `ctascon` (
  `idcod` int(5) NOT NULL AUTO_INCREMENT,
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
  `idarticulo` int(5) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `costo` float(9,3) DEFAULT NULL,
  `cantidad` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.datacsv: ~0 rows (aproximadamente)
DELETE FROM `datacsv`;

-- Volcando estructura para tabla wcafedb.depmaquina
CREATE TABLE IF NOT EXISTS `depmaquina` (
  `iddep` int(2) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `nombre` varchar(20) DEFAULT NULL,
  `marca` varchar(30) DEFAULT NULL,
  `serie` varchar(20) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `tipo` int(2) DEFAULT NULL,
  `kg` float(9,3) DEFAULT '0.000',
  `pendiente` float(9,3) DEFAULT '0.000',
  PRIMARY KEY (`iddep`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.depmaquina: ~0 rows (aproximadamente)
DELETE FROM `depmaquina`;

-- Volcando estructura para tabla wcafedb.deposito
CREATE TABLE IF NOT EXISTS `deposito` (
  `id_deposito` int(3) NOT NULL AUTO_INCREMENT,
  `id_persona` int(5) DEFAULT NULL,
  `tipo_p` char(3) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `identificacion` varchar(20) DEFAULT NULL,
  `debe` int(5) DEFAULT '0',
  `debo` int(5) DEFAULT '0',
  PRIMARY KEY (`id_deposito`)
) ENGINE=InnoDB AUTO_INCREMENT=463 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.deposito: ~0 rows (aproximadamente)
DELETE FROM `deposito`;

-- Volcando estructura para tabla wcafedb.depvendedor
CREATE TABLE IF NOT EXISTS `depvendedor` (
  `id_deposito` int(3) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(30) DEFAULT NULL,
  `idvendedor` int(5) DEFAULT '0',
  PRIMARY KEY (`id_deposito`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.depvendedor: ~0 rows (aproximadamente)
DELETE FROM `depvendedor`;

-- Volcando estructura para tabla wcafedb.detalledeposito
CREATE TABLE IF NOT EXISTS `detalledeposito` (
  `iddetalle` int(5) NOT NULL AUTO_INCREMENT,
  `idregistro` int(5) DEFAULT NULL,
  `tipo` int(1) DEFAULT NULL,
  `tiporeg` int(1) DEFAULT NULL,
  `idarticulo` int(5) DEFAULT NULL,
  `cantidad` int(5) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalledeposito: ~0 rows (aproximadamente)
DELETE FROM `detalledeposito`;

-- Volcando estructura para tabla wcafedb.detalleimportar
CREATE TABLE IF NOT EXISTS `detalleimportar` (
  `iddetalle` int(8) NOT NULL AUTO_INCREMENT,
  `idarticulo` int(8) NOT NULL,
  `cantidad` int(5) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT '0.000',
  `precio_venta` float(11,2) NOT NULL,
  `descuento` float(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalleimportar: ~0 rows (aproximadamente)
DELETE FROM `detalleimportar`;

-- Volcando estructura para tabla wcafedb.detalle_ajuste
CREATE TABLE IF NOT EXISTS `detalle_ajuste` (
  `iddetalle_ajuste` int(5) NOT NULL AUTO_INCREMENT,
  `idajuste` int(8) NOT NULL,
  `idarticulo` int(8) NOT NULL,
  `tipo_ajuste` varchar(15) NOT NULL,
  `cantidad` float(9,3) NOT NULL,
  `costo` float(11,2) NOT NULL,
  `valorizado` float(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_ajuste`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

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
  `iddetalle_devolucion` int(8) NOT NULL AUTO_INCREMENT,
  `iddevolucion` int(8) NOT NULL,
  `idarticulo` int(8) NOT NULL,
  `cantidad` float(9,3) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT '0.000',
  `precio_venta` float(11,2) NOT NULL,
  `descuento` float(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_devolucion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_devolucion: ~0 rows (aproximadamente)
DELETE FROM `detalle_devolucion`;

-- Volcando estructura para tabla wcafedb.detalle_devolucioncompras
CREATE TABLE IF NOT EXISTS `detalle_devolucioncompras` (
  `iddetalle` int(5) NOT NULL AUTO_INCREMENT,
  `iddevolucion` int(5) NOT NULL,
  `codarticulo` int(5) DEFAULT NULL,
  `cantidad` float(9,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_devolucioncompras: ~0 rows (aproximadamente)
DELETE FROM `detalle_devolucioncompras`;

-- Volcando estructura para tabla wcafedb.detalle_ingreso
CREATE TABLE IF NOT EXISTS `detalle_ingreso` (
  `iddetalle_ingreso` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `idingreso` int(8) NOT NULL,
  `idarticulo` int(8) NOT NULL,
  `cantidad` float(11,2) NOT NULL,
  `precio_compra` float(11,2) NOT NULL,
  `precio_tasa` float(9,3) DEFAULT NULL,
  `precio_venta` float(11,2) NOT NULL,
  `subtotal` float(9,3) DEFAULT '0.000',
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle_ingreso`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_ingreso: ~0 rows (aproximadamente)
DELETE FROM `detalle_ingreso`;

-- Volcando estructura para tabla wcafedb.detalle_pedido
CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `iddetalle_venta` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `idventa` int(8) NOT NULL,
  `idarticulo` int(5) NOT NULL,
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
  `iddetalle` int(5) NOT NULL AUTO_INCREMENT,
  `idproduccion` int(5) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` float(9,3) DEFAULT NULL,
  `kgproduccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_produccion: ~0 rows (aproximadamente)
DELETE FROM `detalle_produccion`;

-- Volcando estructura para tabla wcafedb.detalle_traslado
CREATE TABLE IF NOT EXISTS `detalle_traslado` (
  `iddetalle` int(5) NOT NULL AUTO_INCREMENT,
  `idtraslado` int(5) DEFAULT NULL,
  `idarticulo` int(5) DEFAULT NULL,
  `cantidad` float(7,2) DEFAULT NULL,
  `precio` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`iddetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_traslado: ~0 rows (aproximadamente)
DELETE FROM `detalle_traslado`;

-- Volcando estructura para tabla wcafedb.detalle_venta
CREATE TABLE IF NOT EXISTS `detalle_venta` (
  `iddetalle_venta` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `idventa` int(8) NOT NULL,
  `idarticulo` int(5) NOT NULL,
  `costoarticulo` float(9,3) DEFAULT NULL,
  `cantidad` float(7,2) NOT NULL,
  `precio` float(9,3) DEFAULT '0.000',
  `precio_venta` float(11,2) NOT NULL,
  `descuento` float(7,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechahora` date DEFAULT NULL,
  `fecha_emi` date DEFAULT NULL,
  PRIMARY KEY (`iddetalle_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.detalle_venta: ~0 rows (aproximadamente)
DELETE FROM `detalle_venta`;

-- Volcando estructura para tabla wcafedb.detalle_ventaf
CREATE TABLE IF NOT EXISTS `detalle_ventaf` (
  `iddetalle_venta` int(8) NOT NULL AUTO_INCREMENT,
  `idventa` int(8) NOT NULL,
  `idarticulo` int(5) NOT NULL,
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
  `iddevolucion` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '0',
  `idventa` int(8) NOT NULL,
  `comprobante` varchar(15) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(20) NOT NULL,
  PRIMARY KEY (`iddevolucion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.devolucion: ~0 rows (aproximadamente)
DELETE FROM `devolucion`;

-- Volcando estructura para tabla wcafedb.devolucioncompras
CREATE TABLE IF NOT EXISTS `devolucioncompras` (
  `iddevolucion` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(1) DEFAULT NULL,
  `idcompra` int(5) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`iddevolucion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.devolucioncompras: ~0 rows (aproximadamente)
DELETE FROM `devolucioncompras`;

-- Volcando estructura para tabla wcafedb.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `idempresa` int(1) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `rif` varchar(20) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fechasistema` date DEFAULT NULL,
  `inicio` date DEFAULT NULL,
  `corre_iva` int(11) DEFAULT NULL,
  `corre_islr` int(11) DEFAULT NULL,
  `modop` int(2) DEFAULT '0' COMMENT 'calculapor venta en valor 0',
  `tc` double(15,4) DEFAULT NULL,
  `peso` double(9,3) DEFAULT NULL,
  `tasa_banco` double(15,4) DEFAULT NULL,
  `calc_util` int(2) DEFAULT '1',
  `ctapagos` varchar(200) DEFAULT NULL,
  `logo` varchar(80) DEFAULT 'ninguna.jpg',
  PRIMARY KEY (`idempresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.empresa: ~2 rows (aproximadamente)
DELETE FROM `empresa`;
INSERT INTO `empresa` (`idempresa`, `nombre`, `direccion`, `rif`, `telefono`, `fechasistema`, `inicio`, `corre_iva`, `corre_islr`, `modop`, `tc`, `peso`, `tasa_banco`, `calc_util`, `ctapagos`, `logo`) VALUES
	(1, 'W&W SYSTEMS', 'Santa cruz de mora Edo. Mérida', 'J-16604674', '04247163726', '2026-12-20', '2025-12-20', 1, 1, 0, 230.0000, 4000.000, 4.1600, 2, 'N° 0101-0000000-000000-0000 v16604674 wuilmer puerta', 'cruzcafe.png'),
	(2, 'CAFE LAS PALMAS', 'Calle el Paraiso, sector el Tabacal, Santa Cruz de Mora, Estado Merida', 'j-411718939', '04124656570', '2027-09-08', '2026-09-08', 1, 1, 0, 125.0000, 4500.000, 11.0000, 1, 'N° 0102-0000000-000000-0000 v16604674 PUERTA', 'ccafe.jpg');

-- Volcando estructura para tabla wcafedb.existencia
CREATE TABLE IF NOT EXISTS `existencia` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `id_almacen` int(5) DEFAULT NULL,
  `idarticulo` int(5) DEFAULT NULL,
  `existencia` float(9,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.existencia: ~0 rows (aproximadamente)
DELETE FROM `existencia`;

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
  `anulado` int(2) DEFAULT '0',
  PRIMARY KEY (`idForma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.formalibre: ~0 rows (aproximadamente)
DELETE FROM `formalibre`;

-- Volcando estructura para tabla wcafedb.gasto
CREATE TABLE IF NOT EXISTS `gasto` (
  `idgasto` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `numgasto` int(5) DEFAULT NULL,
  `idpersona` int(5) DEFAULT NULL,
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
  `estatus` int(2) DEFAULT '0',
  PRIMARY KEY (`idgasto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.gasto: ~0 rows (aproximadamente)
DELETE FROM `gasto`;

-- Volcando estructura para tabla wcafedb.ingreso
CREATE TABLE IF NOT EXISTS `ingreso` (
  `idingreso` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `idproveedor` int(8) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(20) NOT NULL,
  `num_comprobante` varchar(20) NOT NULL,
  `fecha_hora` date NOT NULL,
  `emision` date DEFAULT NULL,
  `impuesto` int(2) NOT NULL,
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
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `idarticulo` int(5) DEFAULT NULL,
  `cantidad` float(9,3) DEFAULT NULL,
  `exis_ant` float(9,3) DEFAULT '0.000',
  `costo` float(9,3) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `tipo` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.kardex: ~0 rows (aproximadamente)
DELETE FROM `kardex`;

-- Volcando estructura para tabla wcafedb.listbanco
CREATE TABLE IF NOT EXISTS `listbanco` (
  `idbanco` int(5) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefonos` varchar(20) DEFAULT NULL,
  `cuentaban` varchar(25) DEFAULT NULL,
  `tipocta` varchar(20) DEFAULT NULL,
  `titular` varchar(50) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `naturaleza` varchar(20) DEFAULT NULL,
  `moneda` int(3) DEFAULT '0',
  PRIMARY KEY (`idbanco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.listbanco: ~0 rows (aproximadamente)
DELETE FROM `listbanco`;

-- Volcando estructura para tabla wcafedb.metas
CREATE TABLE IF NOT EXISTS `metas` (
  `idmeta` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(40) DEFAULT NULL,
  `creado` date NOT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `estatus` int(2) DEFAULT '0',
  `cumplimiento` float(9,3) DEFAULT '0.000',
  `cntarticulos` int(11) DEFAULT NULL,
  `valormeta` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`idmeta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.metas: ~0 rows (aproximadamente)
DELETE FROM `metas`;

-- Volcando estructura para tabla wcafedb.metasvendedor
CREATE TABLE IF NOT EXISTS `metasvendedor` (
  `idmeta` int(5) NOT NULL AUTO_INCREMENT,
  `idvendedor` int(3) DEFAULT NULL,
  `metodo` int(2) DEFAULT '0',
  `descripcion` varchar(40) DEFAULT NULL,
  `creado` date NOT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `estatus` int(2) DEFAULT '0',
  `cumplimiento` float(9,3) DEFAULT '0.000',
  `cntarticulos` int(11) DEFAULT NULL,
  `particulos` int(3) DEFAULT NULL,
  `valormeta` float(9,3) DEFAULT NULL,
  `nclientes` int(11) DEFAULT NULL,
  `pnclientes` float(6,2) DEFAULT '0.00',
  `cobranza` float(9,3) DEFAULT NULL,
  `pcobranza` float(6,2) DEFAULT '0.00',
  `reactivar` int(3) DEFAULT NULL,
  `pactivar` int(2) DEFAULT '0',
  `preactivar` float(6,2) DEFAULT '0.00',
  `crecimiento` int(1) DEFAULT '0',
  `pcrecimiento` float(5,2) DEFAULT '0.00',
  `pcomision` int(11) DEFAULT '0',
  PRIMARY KEY (`idmeta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `idmoneda` int(2) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `codigo` varchar(5) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `tipo` int(2) DEFAULT NULL,
  `simbolo` char(4) DEFAULT NULL,
  PRIMARY KEY (`idmoneda`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

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
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(8) DEFAULT NULL,
  `deposito` int(3) DEFAULT NULL,
  `articulo` int(5) DEFAULT NULL,
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
  `id_mov` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `idcaja` int(11) DEFAULT NULL,
  `tipodoc` char(4) DEFAULT '0',
  `iddocumento` int(5) DEFAULT '0',
  `tipo_mov` text,
  `numero` varchar(20) DEFAULT NULL,
  `concepto` varchar(40) DEFAULT NULL,
  `tipo_per` char(2) DEFAULT NULL,
  `idbeneficiario` int(5) DEFAULT '0',
  `identificacion` varchar(20) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `monto` double(15,3) DEFAULT NULL,
  `tasadolar` double(15,3) DEFAULT NULL,
  `fecha_mov` datetime DEFAULT NULL,
  `estatus` int(3) DEFAULT '0',
  `user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_mov`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.mov_ban: ~49 rows (aproximadamente)
DELETE FROM `mov_ban`;
INSERT INTO `mov_ban` (`id_mov`, `idempresa`, `idcaja`, `tipodoc`, `iddocumento`, `tipo_mov`, `numero`, `concepto`, `tipo_per`, `idbeneficiario`, `identificacion`, `nombre`, `monto`, `tasadolar`, `fecha_mov`, `estatus`, `user`) VALUES
	(1, 2, 9, 'VENT', 27645, 'N/C', '9-NE00', 'Ingreso Ventas', 'C', 26, ' V152355919', 'JERRY LENIN MARQUEZ PICON (MAR', 4800.000, 0.000, '2025-11-27 12:03:08', 0, 'asistente'),
	(2, 2, 5, 'VENT', 27646, 'N/C', '5-NE00', 'Ingreso Ventas', 'C', 14, 'V119737296', 'JULIO CESAR MARQUINA VELAZCO (', 1000.000, 0.000, '2025-11-27 12:07:04', 0, 'asistente'),
	(3, 2, 9, 'VENT', 27647, 'N/C', '9-NE00', 'Ingreso Ventas', 'C', 14, 'V119737296', 'JULIO CESAR MARQUINA VELAZCO (', 8600.000, 0.000, '2025-11-27 12:07:04', 0, 'asistente'),
	(4, 1, 2, 'N/DA', 27648, 'N/C', '2-C4208', 'Cobranza N/D', 'C', 671, 'V234936782', 'CESAR AUGUSTO MORA MORA', 118.000, 0.000, '2025-11-27 12:08:26', 0, 'nks'),
	(5, 1, 3, 'VENT', 27649, 'N/C', '3-C17494', 'Cobranza Ventas', 'C', 671, 'V234936782', 'CESAR AUGUSTO MORA MORA', 5000.000, 1.250, '2025-11-27 00:00:00', 0, 'nks'),
	(6, 2, 4, 'VENT', 27650, 'N/C', '4-C17495', 'Cobranza Ventas', 'C', 26, ' V152355919', 'JERRY LENIN MARQUEZ PICON (MAR', 312.000, 1.560, '2025-11-27 00:00:00', 0, 'asistente'),
	(8, 1, 1, 'VENT', 27652, 'N/C', '1-NE00', 'Ingreso Ventas', 'C', 688, 'v1245783', 'MAICOL MORA', 125.000, 125.000, '2025-11-27 12:50:59', 0, 'nks'),
	(9, 1, 1, 'VENT', 27653, 'N/C', '1-NE00', 'Ingreso Ventas', 'C', 688, 'v1245783', 'MAICOL MORA', 125.000, 125.000, '2025-11-27 12:51:59', 0, 'nks'),
	(10, 2, 9, 'VENT', 27654, 'N/C', '9-NE00', 'Ingreso Ventas', 'C', 689, 'v18133135', 'MARIELA SERRANO', 5280.000, 26.400, '2025-11-27 12:57:13', 0, 'asistente'),
	(11, 2, 9, 'VENT', 27655, 'N/C', '9-C17503', 'Cobranza Ventas', 'C', 690, 'V2351354', 'JULIO QUINTERO', 480.000, 2.400, '2025-11-27 00:00:00', 0, 'asistente'),
	(12, 2, 5, 'VENT', 27656, 'N/C', '5-NE00', 'Ingreso Ventas', 'C', 689, 'v18133135', 'MARIELA SERRANO', 4800.000, 24.000, '2025-11-27 13:01:53', 0, 'asistente'),
	(13, 2, 9, 'VENT', 27657, 'N/C', '9-NE00', 'Ingreso Ventas', 'C', 690, 'V2351354', 'JULIO QUINTERO', 9600.000, 48.000, '2025-11-27 13:03:23', 0, 'asistente'),
	(14, 2, 4, 'VENT', 27658, 'N/C', '4-NE00', 'Ingreso Ventas', 'C', 690, 'V2351354', 'JULIO QUINTERO', 1920.000, 9.600, '2025-11-27 14:50:44', 0, 'asistente'),
	(15, 2, 5, 'VENT', 27659, 'N/C', '5-NE00', 'Ingreso Ventas', 'C', 690, 'V2351354', 'JULIO QUINTERO', 1440.000, 7.200, '2025-11-27 14:53:27', 0, 'asistente'),
	(16, 2, 6, 'VENT', 27660, 'N/C', '6-NE00', 'Ingreso Ventas', 'C', 690, 'V2351354', 'JULIO QUINTERO', 960.000, 4.800, '2025-11-27 14:57:38', 0, 'asistente'),
	(17, 2, 4, 'VENT', 27661, 'N/C', '4-NE00', 'Ingreso Ventas', 'C', 689, 'v18133135', 'MARIELA SERRANO', 480.000, 2.400, '2025-11-27 15:00:40', 0, 'asistente'),
	(18, 2, 4, 'VENT', 27662, 'N/C', '4-C17510', 'Cobranza Ventas', 'C', 689, 'v18133135', 'MARIELA SERRANO', 960.000, 4.800, '2025-11-27 00:00:00', 0, 'asistente'),
	(19, 2, 6, 'VENT', 27663, 'N/C', '6-C17514', 'Cobranza Ventas', 'C', 689, 'v18133135', 'MARIELA SERRANO', 480.000, 2.400, '2025-11-27 00:00:00', 0, 'asistente'),
	(20, 2, 4, 'VENT', 27664, 'N/C', '4-C17513', 'Cobranza Ventas', 'C', 689, 'v18133135', 'MARIELA SERRANO', 480.000, 2.400, '2025-11-27 00:00:00', 0, 'asistente'),
	(21, 2, 6, 'COMI', 185, 'N/D', '6-104', 'Egreso COMI', 'V', 10, 'V31893551', 'WILMER GUERRERO', 19.200, 0.000, '2025-11-27 15:21:51', 0, 'asistente'),
	(22, 2, 5, 'COMP', 1679, 'N/D', '5-664', 'Egreso Compras', 'P', 42, 'v98797987', 'GUAYU SITEMAS', 6250.000, 0.000, '2025-12-02 16:22:08', 0, 'Sucursal'),
	(23, 1, 1, 'VENT', 27665, 'N/C', '1-NE00', 'Ingreso Ventas', 'C', 688, 'v1245783', 'MAICOL MORA', 125.000, 125.000, '2025-12-02 16:25:58', 0, 'nks'),
	(24, 2, 4, 'VENT', 27666, 'N/C', '4-NE00', 'Ingreso Ventas', 'C', 690, 'V2351354', 'JULIO QUINTERO', 27000.000, 216.000, '2025-12-02 16:26:20', 0, 'Sucursal'),
	(25, 1, 1, '0', 0, 'N/C', '005 00000025', 'sfdgsdfg', 'C', 693, ' V1343213 ', ' LUIS AMORIN', 120.000, 4.160, '2025-12-02 00:00:00', 0, 'nks'),
	(26, 2, 10, 'VENT', 27667, 'N/C', '10-NE00', 'Ingreso Ventas', 'C', 694, 'V16524114', 'CARLOS ESTRADA', 240.000, 240.000, '2025-12-02 16:50:49', 0, 'Sucursal'),
	(27, 1, 1, '0', 0, 'N/D', '1 00000027', '4674567', 'C', 691, 'v21324353', 'JUAN ADRES PEÑA', 10.000, 4.160, '2025-12-02 00:00:00', 0, 'nks'),
	(28, 1, 2, 'VENT', 27668, 'N/C', '2-NE00', 'Ingreso Ventas', 'C', 688, 'v1245783', 'MAICOL MORA', 120.000, 120.000, '2026-01-05 11:57:49', 0, 'nks'),
	(29, 2, 4, 'VENT', 27669, 'N/C', '4-NE00', 'Ingreso Ventas', 'C', 689, 'v18133135', 'MARIELA SERRANO', 300.000, 2.400, '2026-01-05 11:59:39', 0, 'Sucursal'),
	(30, 2, 6, 'COMP', 1680, 'N/D', '6-763', 'Egreso COMP', 'P', 18, 'J501206708', 'CORPORACION R3, C.A', 10000.000, 80.000, '2026-01-05 00:00:00', 0, 'Sucursal'),
	(31, 2, 4, 'VENT', 27670, 'N/C', '4-NE00', 'Ingreso Ventas', 'C', 692, 'v13543543', 'LEOPOLDO CONTRERAS', 1350.000, 10.800, '2026-01-20 11:08:40', 0, 'Sucursal'),
	(32, 2, 5, 'VENT', 27671, 'N/C', '5-NE00', 'Ingreso Ventas', 'C', 692, 'v13543543', 'LEOPOLDO CONTRERAS', 1141.250, 9.130, '2026-01-20 12:34:17', 0, 'Sucursal'),
	(33, 1, 1, 'VENT', 27672, 'N/C', '1-NE00', 'Ingreso Ventas', 'C', 697, 'V131123', 'SUCURSAL EJIDO', 20.000, 20.000, '2026-01-21 11:18:01', 1, 'nks'),
	(34, 1, 2, 'VENT', 27673, 'N/C', '2-C1', 'Cobranza Ventas', 'C', 693, 'V1343213', 'LUIS AMORIN', 5.000, 5.000, '2026-01-22 00:00:00', 0, 'nks'),
	(35, 1, 8, 'VENT', 27674, 'N/C', '8-NE00', 'Ingreso Ventas', 'C', 693, 'V1343213', 'LUIS AMORIN', 1789.400, 7.780, '2026-01-22 17:08:20', 0, 'Caja'),
	(36, 1, 2, 'VENT', 27675, 'N/C', '2-NE00', 'Ingreso Ventas', 'C', 698, 'V16851654', 'YAMIL NOGUERA', 2.000, 2.000, '2026-01-22 17:09:32', 0, 'Caja'),
	(37, 1, 1, 'VENT', 27676, 'N/C', '1-NE00', 'Ingreso Ventas', 'C', 693, 'V1343213', 'LUIS AMORIN', 1.000, 1.000, '2026-01-23 08:58:35', 0, 'Caja'),
	(38, 1, 3, 'VENT', 27677, 'N/C', '3-NE00', 'Ingreso Ventas', 'C', 693, 'V1343213', 'LUIS AMORIN', 440.000, 0.110, '2026-01-23 08:58:35', 0, 'Caja'),
	(39, 1, 1, '0', 0, 'N/D', '1-1681', 'Egre. Produccion', 'T', 1, '', 'Julian quintero', 9.000, 9.000, '2026-01-23 00:00:00', 0, 'nks'),
	(40, 1, 1, '0', 0, 'N/D', '1-1682', 'Egre. Produccion', 'T', 1, '', 'Julian quintero', 18.000, 18.000, '2026-01-23 00:00:00', 0, 'nks'),
	(41, 1, 1, '0', 0, 'N/D', '1-1683', 'Egre. Produccion', 'T', 2, '', 'wuilmer', 5.000, 5.000, '2026-01-28 00:00:00', 0, 'nks'),
	(42, 1, 1, '0', 0, 'N/D', '2-1684', 'Egre. Produccion', 'M', 1, '', 'Tostadora Casht', 100.350, 100.350, '2026-01-28 00:00:00', 0, 'nks'),
	(43, 1, 1, '0', 0, 'N/D', '1-1685', 'Egre. Produccion', 'T', 1, '', 'Julian quintero', 40.000, 40.000, '2026-02-02 00:00:00', 0, 'nks'),
	(44, 1, 2, 'VENT', 27678, 'N/C', '2-NE00', 'Ingreso Ventas', 'C', 687, 'v16604674', 'WUILMER', 7.780, 7.780, '2026-02-13 11:43:58', 0, 'Caja'),
	(45, 1, 2, 'VENT', 27679, 'N/C', '2-NE00', 'Ingreso Ventas', 'C', 687, 'v16604674', 'WUILMER', 7.780, 7.780, '2026-02-13 17:43:20', 0, 'Caja'),
	(46, 1, 3, 'VENT', 27680, 'N/C', '3-NE00', 'Ingreso Ventas', 'C', 687, 'v16604674', 'WUILMER', 88880.000, 22.220, '2026-02-13 18:13:46', 0, 'Caja'),
	(47, 1, 1, 'VENT', 27681, 'N/C', '1-NE00', 'Ingreso Ventas', 'C', 687, 'v16604674', 'WUILMER', 22.220, 22.220, '2026-02-14 09:26:53', 0, 'Caja'),
	(48, 1, 1, 'VENT', 27682, 'N/C', '1-NE00', 'Ingreso Ventas', 'C', 1, '30788895', 'JESUS MORA ABASTO LA CASCADA', 35.550, 35.550, '2026-02-18 11:27:26', 0, 'Caja'),
	(49, 1, 3, 'VENT', 27684, 'N/C', '3-NE00', 'Ingreso Ventas', 'C', 1, '30788895', 'JESUS MORA ABASTO LA CASCADA', 133320.000, 33.330, '2026-02-18 12:06:51', 0, 'Caja'),
	(50, 1, 3, 'VENT', 27685, 'N/C', '3-NE00', 'Ingreso Ventas', 'C', 1, '30788895', 'JESUS MORA ABASTO LA CASCADA', 57720.000, 14.430, '2026-02-18 16:43:01', 0, 'Caja');

-- Volcando estructura para tabla wcafedb.mov_notas
CREATE TABLE IF NOT EXISTS `mov_notas` (
  `id_mov` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `tipodoc` varchar(5) DEFAULT NULL,
  `iddoc` int(5) DEFAULT NULL,
  `monto` float(9,3) DEFAULT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  PRIMARY KEY (`id_mov`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.mov_notas: ~0 rows (aproximadamente)
DELETE FROM `mov_notas`;

-- Volcando estructura para tabla wcafedb.mov_notasp
CREATE TABLE IF NOT EXISTS `mov_notasp` (
  `id_mov` int(5) NOT NULL AUTO_INCREMENT,
  `tipodoc` varchar(5) DEFAULT NULL,
  `iddoc` int(5) DEFAULT NULL,
  `monto` float(9,3) DEFAULT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  PRIMARY KEY (`id_mov`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `idnota` int(5) NOT NULL AUTO_INCREMENT,
  `numnota` int(5) DEFAULT NULL,
  `idempresa` int(2) DEFAULT '1',
  `tipo` int(2) DEFAULT NULL,
  `idcliente` int(5) DEFAULT NULL,
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
  `idnota` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `numnota` int(5) DEFAULT NULL,
  `tipo` int(2) DEFAULT NULL,
  `idcliente` int(5) DEFAULT NULL,
  `descripcion` varchar(20) DEFAULT NULL,
  `referencia` varchar(20) NOT NULL,
  `monto` float(9,3) NOT NULL,
  `fecha` date DEFAULT NULL,
  `pendiente` float(9,3) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idnota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `idpedido` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `origen` int(3) NOT NULL,
  `destino` int(3) NOT NULL,
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
  `idm` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT NULL,
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

-- Volcando estructura para tabla wcafedb.produccion
CREATE TABLE IF NOT EXISTS `produccion` (
  `idproduccion` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT NULL,
  `responsable` varchar(50) DEFAULT NULL,
  `encargado` varchar(50) DEFAULT NULL,
  `idmprima` int(11) DEFAULT NULL,
  `kgsubido` float(9,3) DEFAULT NULL,
  `kgmolidos` float(9,3) DEFAULT NULL,
  `reduccion` float(9,3) DEFAULT NULL,
  `idproductofinal` int(11) DEFAULT NULL,
  `tipoemp` int(2) DEFAULT NULL,
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
  `idproveedor` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `nombre` varchar(50) NOT NULL,
  `rif` varchar(15) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `contacto` varchar(80) DEFAULT NULL,
  `estatus` varchar(1) NOT NULL,
  `idbanco` char(1) DEFAULT 'P',
  `tpersona` int(2) DEFAULT '1',
  PRIMARY KEY (`idproveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.proveedor: ~0 rows (aproximadamente)
DELETE FROM `proveedor`;

-- Volcando estructura para tabla wcafedb.ptostado
CREATE TABLE IF NOT EXISTS `ptostado` (
  `idt` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `tostador` varchar(20) DEFAULT NULL,
  `idmaquina` int(2) DEFAULT '1',
  `cochas` int(3) DEFAULT NULL,
  `idmprima` int(3) DEFAULT NULL,
  `kgmprima` float(9,3) DEFAULT NULL,
  `kgtostado` float(9,3) DEFAULT NULL,
  `idproducto` int(3) DEFAULT NULL,
  `comision` int(3) DEFAULT NULL,
  `kgcomi` float(9,3) DEFAULT '0.000',
  `comima` int(3) DEFAULT NULL,
  `kgcomima` float(9,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `responsable` varchar(20) NOT NULL,
  `reduccion` float(9,3) DEFAULT NULL,
  PRIMARY KEY (`idt`,`responsable`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ptostado: ~0 rows (aproximadamente)
DELETE FROM `ptostado`;

-- Volcando estructura para tabla wcafedb.recibos
CREATE TABLE IF NOT EXISTS `recibos` (
  `idrecibo` int(10) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `idventa` int(10) NOT NULL,
  `idnota` int(5) DEFAULT '0',
  `tiporecibo` char(2) DEFAULT 'P',
  `monto` float(11,2) NOT NULL,
  `idpago` int(3) NOT NULL,
  `id_banco` int(5) DEFAULT NULL,
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
  `idempresa` int(2) DEFAULT '1',
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
  `id_recibo` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `id_comision` int(5) DEFAULT NULL,
  `monto` float(9,3) DEFAULT NULL,
  `idbanco` int(5) DEFAULT NULL,
  `recibido` float(9,3) DEFAULT NULL,
  `observacion` varchar(80) DEFAULT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `aux` float(9,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_recibo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.recibo_comision: ~0 rows (aproximadamente)
DELETE FROM `recibo_comision`;

-- Volcando estructura para tabla wcafedb.reglacomision
CREATE TABLE IF NOT EXISTS `reglacomision` (
  `idregla` int(11) NOT NULL AUTO_INCREMENT,
  `desde` int(3) DEFAULT NULL,
  `hasta` int(3) DEFAULT NULL,
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
  `deposito` int(5) DEFAULT NULL,
  `idarticulo` int(5) DEFAULT NULL,
  `debe` int(5) DEFAULT '0',
  `debo` int(5) DEFAULT '0',
  PRIMARY KEY (`idreg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.reg_deposito: ~0 rows (aproximadamente)
DELETE FROM `reg_deposito`;

-- Volcando estructura para tabla wcafedb.relacionnc
CREATE TABLE IF NOT EXISTS `relacionnc` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `idmov` int(5) DEFAULT NULL,
  `idnota` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.relacionnc: ~0 rows (aproximadamente)
DELETE FROM `relacionnc`;

-- Volcando estructura para tabla wcafedb.relacionncp
CREATE TABLE IF NOT EXISTS `relacionncp` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `idmov` int(5) DEFAULT NULL,
  `idnota` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.relacionncp: ~0 rows (aproximadamente)
DELETE FROM `relacionncp`;

-- Volcando estructura para tabla wcafedb.retenc
CREATE TABLE IF NOT EXISTS `retenc` (
  `codigo` int(3) NOT NULL AUTO_INCREMENT,
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
  `idretencion` int(5) NOT NULL AUTO_INCREMENT,
  `idingreso` int(5) DEFAULT '0',
  `idgasto` int(5) DEFAULT '0',
  `idproveedor` int(11) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `correlativo` int(11) DEFAULT '0',
  `retenc` int(5) DEFAULT NULL,
  `mfac` double(15,3) DEFAULT NULL,
  `mbase` float(10,3) DEFAULT NULL,
  `miva` float(9,3) DEFAULT NULL,
  `mexento` float(10,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `mret` float(9,3) DEFAULT NULL,
  `mretd` float(9,3) DEFAULT NULL,
  `anulada` int(2) DEFAULT '0',
  PRIMARY KEY (`idretencion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.retenciones: ~0 rows (aproximadamente)
DELETE FROM `retenciones`;

-- Volcando estructura para tabla wcafedb.retencionventas
CREATE TABLE IF NOT EXISTS `retencionventas` (
  `idret` int(5) NOT NULL AUTO_INCREMENT,
  `idfactura` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `comprobante` varchar(20) DEFAULT NULL,
  `pretencion` int(3) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.retencionventas: ~0 rows (aproximadamente)
DELETE FROM `retencionventas`;

-- Volcando estructura para tabla wcafedb.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `idrol` int(5) NOT NULL AUTO_INCREMENT,
  `iduser` int(5) DEFAULT NULL,
  `newproveedor` int(1) DEFAULT '0',
  `editproveedor` int(1) DEFAULT '0',
  `edoctap` int(1) DEFAULT '0',
  `newvendedor` int(1) DEFAULT '0',
  `editvendedor` int(1) DEFAULT '0',
  `actvendedor` int(1) DEFAULT '0',
  `newcliente` int(1) DEFAULT '0',
  `editcliente` int(1) DEFAULT '0',
  `edocta` int(1) DEFAULT '0',
  `actcliente` int(1) DEFAULT '0',
  `newarticulo` int(1) DEFAULT '0',
  `editarticulo` int(1) DEFAULT '0',
  `crearcompra` int(1) DEFAULT '0',
  `anularcompra` int(1) DEFAULT '0',
  `importarne` int(1) DEFAULT '0',
  `crearventa` int(1) DEFAULT '0',
  `anularventa` int(1) DEFAULT '0',
  `crearfl` int(1) DEFAULT '0',
  `anularfl` int(1) DEFAULT '0',
  `importarfl` int(1) DEFAULT '0',
  `crearfe` int(1) DEFAULT '0',
  `editarfe` int(1) DEFAULT '0',
  `anularfe` int(1) DEFAULT '0',
  `crearpedido` int(1) DEFAULT '0',
  `editpedido` int(1) DEFAULT '0',
  `anularpedido` int(1) DEFAULT '0',
  `importarpedido` int(1) DEFAULT '0',
  `crearajuste` int(1) DEFAULT '0',
  `abonarcxc` int(1) DEFAULT '0',
  `creargasto` int(1) DEFAULT '0',
  `anulargasto` int(1) DEFAULT '0',
  `abonarcxp` int(1) DEFAULT '0',
  `abonargasto` int(1) DEFAULT '0',
  `vacios` int(1) DEFAULT '0',
  `newdepvendedor` int(2) DEFAULT '0',
  `comision` int(1) DEFAULT '0',
  `pcomision` int(1) DEFAULT '0',
  `acttasa` int(1) DEFAULT '0',
  `actroles` int(1) DEFAULT '0',
  `rventas` int(1) DEFAULT '0',
  `ccaja` int(1) DEFAULT '0',
  `rdetallei` int(1) DEFAULT '0',
  `rcxc` int(1) DEFAULT '0',
  `rcompras` int(1) DEFAULT '0',
  `rdetallec` int(1) DEFAULT '0',
  `rcxp` int(1) DEFAULT '0',
  `rinventario` int(1) DEFAULT '0',
  `web` int(1) DEFAULT '0',
  `updatepass` int(2) DEFAULT '0',
  `newbanco` int(1) DEFAULT '0',
  `accesobanco` int(1) DEFAULT '0',
  `edoctabanco` int(1) DEFAULT '0',
  `metae` int(1) DEFAULT '0',
  `metav` int(1) DEFAULT '0',
  `lventas` int(1) DEFAULT '0',
  `lcompras` int(1) DEFAULT '0',
  `valorizado` int(1) DEFAULT '0',
  `listap` int(1) DEFAULT '0',
  `resumeng` int(1) DEFAULT '0',
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.roles: ~7 rows (aproximadamente)
DELETE FROM `roles`;
INSERT INTO `roles` (`idrol`, `iduser`, `newproveedor`, `editproveedor`, `edoctap`, `newvendedor`, `editvendedor`, `actvendedor`, `newcliente`, `editcliente`, `edocta`, `actcliente`, `newarticulo`, `editarticulo`, `crearcompra`, `anularcompra`, `importarne`, `crearventa`, `anularventa`, `crearfl`, `anularfl`, `importarfl`, `crearfe`, `editarfe`, `anularfe`, `crearpedido`, `editpedido`, `anularpedido`, `importarpedido`, `crearajuste`, `abonarcxc`, `creargasto`, `anulargasto`, `abonarcxp`, `abonargasto`, `vacios`, `newdepvendedor`, `comision`, `pcomision`, `acttasa`, `actroles`, `rventas`, `ccaja`, `rdetallei`, `rcxc`, `rcompras`, `rdetallec`, `rcxp`, `rinventario`, `web`, `updatepass`, `newbanco`, `accesobanco`, `edoctabanco`, `metae`, `metav`, `lventas`, `lcompras`, `valorizado`, `listap`, `resumeng`) VALUES
	(1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
	(2, 2, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 1, 0, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1),
	(3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0),
	(4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1),
	(5, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0),
	(6, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0),
	(7, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0);

-- Volcando estructura para tabla wcafedb.rutas
CREATE TABLE IF NOT EXISTS `rutas` (
  `idruta` int(5) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`idruta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.rutas: ~0 rows (aproximadamente)
DELETE FROM `rutas`;

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
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT '1',
  `nombre` varchar(50) DEFAULT NULL,
  `cedula` varchar(20) DEFAULT '0',
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `kg` float(9,3) DEFAULT '0.000',
  `pendiente` float(9,3) DEFAULT '0.000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.tostador: ~0 rows (aproximadamente)
DELETE FROM `tostador`;

-- Volcando estructura para tabla wcafedb.traslado
CREATE TABLE IF NOT EXISTS `traslado` (
  `idtraslado` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT NULL,
  `origen` int(3) NOT NULL,
  `destino` int(3) NOT NULL,
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
  `idempresa` int(2) DEFAULT '0',
  `vendedor` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla wcafedb.users: ~7 rows (aproximadamente)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `nivel`, `foto`, `idempresa`, `vendedor`) VALUES
	(1, 'nks', 'nks@gmail.com', '$2y$10$K9STkiqITEqr6/31ni7Oyu2cOOhJ79GfwsM5FPGjYKRmHLTlJq7ba', 'asRdoXcUXXkB18yxgWiq3lTRPEnXF5UDNW38zdcNOQX0qZj8EybW2bdfTiiS', '2024-07-27 04:30:00', '2024-07-27 20:47:33', 'A', 'avatar5.png', 1, NULL),
	(2, 'Caja', 'cajanks@gmail.com', '$2y$10$PWpJ9bXpM0jp2nu0EB/so.yIHU4fLKLLTfkZgvoHzP4Hdx2dVLOTq', 'yLECyoVdfyXLSCyjVzDbSBuDSiiUoTum80QjA4S515WWQzQZokTJ7fijCThF', '2017-11-03 00:19:14', '2026-01-21 17:42:30', 'L', 'avatar2.png', 1, 2),
	(3, 'Administracion', 'administracion@gmail.com', '$2y$10$3Pl0GLpeWsnib41vGXMi2OkdOyHJox.wOKkkgPRJhCfHCdbUpRGJq', 'g772fEghfc9yWUmusAmIBrkuzLQ97f8PUd7isEsURoMLKmJuqash8VjS5SaE', '2019-10-09 18:32:06', '2025-04-08 15:30:50', 'A', 'avatar04.png', 2, NULL),
	(4, 'caja', 'caja@gmail.com', '$2y$10$cjFlklnsNIWEqddFVVmU0u1Ah2CIy5gICUe4cqIB/s/KnhjDjP37.', 'hY2Lgixc7EpA0tISWF0B6OF3d1fd3VUEbKAmFxo3Por5b4KKbypovIMaSPnn', '2022-02-22 15:23:43', '2022-02-22 15:23:43', 'L', 'avatar.png', 2, 5),
	(5, 'caja2', 'caja2@gmail.com', '$2y$10$JOzRE41w7H/jlfLNqqEx3ecC7ux/k5W5T43dVj/F3dCGE30P.PR.e', '8jcvk8ShTr5Osgoxxww83GfdQnJgLFZB2I3G19iHrEygTE1Ti1G4DNvlCnQQ', '2022-02-22 15:27:31', '2022-02-22 15:27:31', 'L', 'avatar.png', 2, NULL),
	(6, 'caja3', 'caja3@gmail.com', '$2y$10$MSaBRLY5kzclGcd00JC4P.dp.GZsrzoA04GtL/7iT65WFISDRCN7a', 'Px82PfQkL2peyL1mlhVrTlTyYa1EtvBd1If5Ccgr6dygL2cHJ8xamACU9iyT', '2022-02-22 15:30:02', '2022-02-22 15:30:02', 'L', 'avatar.png', 2, NULL),
	(7, 'Gerencia', 'gerencia@gmail.com', '$2y$10$scZDUjKcvDgTPGf.GlC3sOJENmQ4YdV2dsJu3P.kkWFU4g9mbrj1G', 'QzXB0j0TFvhCkah8ZP32XedGA0AK9vdNsABaTkBaaM2GjHi1n4rgonszApEs', '2024-09-16 14:21:37', '2025-11-06 13:05:51', 'A', 'avatar3.png', 2, NULL);

-- Volcando estructura para tabla wcafedb.vendedores
CREATE TABLE IF NOT EXISTS `vendedores` (
  `idempresa` int(2) DEFAULT NULL,
  `id_vendedor` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `comision` int(3) DEFAULT '0',
  `cedula` varchar(20) DEFAULT NULL,
  `idbanco` char(1) DEFAULT 'V',
  `estatus` int(1) DEFAULT '1',
  PRIMARY KEY (`id_vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.vendedores: ~1 rows (aproximadamente)
DELETE FROM `vendedores`;
INSERT INTO `vendedores` (`idempresa`, `id_vendedor`, `nombre`, `telefono`, `direccion`, `comision`, `cedula`, `idbanco`, `estatus`) VALUES
	(1, 1, 'DIRECTO', '0000-0000000', 'SANTA CRUZ DE MORA', 0, 'v0000000', 'V', 1);

-- Volcando estructura para tabla wcafedb.venta
CREATE TABLE IF NOT EXISTS `venta` (
  `idventa` int(8) NOT NULL AUTO_INCREMENT,
  `idempresa` int(2) DEFAULT NULL,
  `idcliente` int(8) NOT NULL,
  `idvendedor` int(3) DEFAULT NULL,
  `pedido` int(1) DEFAULT '0',
  `tipo_comprobante` varchar(10) NOT NULL,
  `serie_comprobante` varchar(15) NOT NULL,
  `num_comprobante` int(10) NOT NULL,
  `forma` int(2) DEFAULT '0',
  `formato` int(2) DEFAULT '0',
  `tasa` float(9,4) DEFAULT '0.0000',
  `mcosto` float(9,3) DEFAULT '0.000',
  `mivaf` float(9,3) DEFAULT '0.000',
  `texe` float(9,3) DEFAULT '0.000',
  `total_venta` float(11,2) NOT NULL,
  `total_iva` float(9,3) DEFAULT '0.000',
  `mret` float(9,3) DEFAULT '0.000',
  `descuento` double(15,3) DEFAULT '0.000',
  `licor` int(2) DEFAULT '0',
  `total_pagar` float(9,3) DEFAULT '0.000',
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechahora` date DEFAULT NULL,
  `fecha_emi` date DEFAULT NULL,
  `fecha_fac` date DEFAULT NULL,
  `lastrecargo` date DEFAULT NULL,
  `impuesto` int(2) NOT NULL,
  `saldo` float(11,2) NOT NULL,
  `diascre` int(5) DEFAULT NULL,
  `estado` varchar(10) NOT NULL,
  `devolu` int(2) NOT NULL,
  `comision` double(8,3) DEFAULT '0.000',
  `montocomision` float(9,3) DEFAULT NULL,
  `idcomision` int(5) DEFAULT '0',
  `pweb` int(2) DEFAULT '0',
  `user` varchar(15) NOT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.venta: ~0 rows (aproximadamente)
DELETE FROM `venta`;

-- Volcando estructura para tabla wcafedb.ventaf
CREATE TABLE IF NOT EXISTS `ventaf` (
  `idventa` int(8) NOT NULL AUTO_INCREMENT,
  `idcliente` int(8) NOT NULL,
  `idvendedor` int(3) DEFAULT NULL,
  `pedido` int(8) DEFAULT '0',
  `tipo_comprobante` varchar(10) NOT NULL,
  `serie_comprobante` varchar(15) NOT NULL,
  `num_comprobante` int(10) NOT NULL,
  `forma` int(2) DEFAULT '0',
  `formato` int(2) DEFAULT '0',
  `tasa` float(9,4) DEFAULT '0.0000',
  `mcosto` float(9,3) DEFAULT '0.000',
  `mivaf` float(9,3) DEFAULT '0.000',
  `texe` float(9,3) DEFAULT '0.000',
  `total_venta` float(11,2) NOT NULL,
  `total_iva` float(9,3) DEFAULT '0.000',
  `mret` float(9,3) DEFAULT '0.000',
  `descuento` double(15,3) DEFAULT '0.000',
  `licor` int(2) DEFAULT '0',
  `total_pagar` float(9,3) DEFAULT '0.000',
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_emi` date DEFAULT NULL,
  `fecha_fac` date DEFAULT NULL,
  `impuesto` int(2) NOT NULL,
  `saldo` float(11,2) NOT NULL,
  `diascre` int(5) DEFAULT NULL,
  `estado` varchar(10) NOT NULL,
  `devolu` int(2) NOT NULL,
  `comision` double(8,3) DEFAULT '0.000',
  `montocomision` float(9,3) DEFAULT NULL,
  `idcomision` int(5) DEFAULT '0',
  `pweb` int(2) DEFAULT '0',
  `user` varchar(15) NOT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ventaf: ~0 rows (aproximadamente)
DELETE FROM `ventaf`;

-- Volcando estructura para tabla wcafedb.ventasexternas
CREATE TABLE IF NOT EXISTS `ventasexternas` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `rif` varchar(20) DEFAULT NULL,
  `cliente` int(5) DEFAULT NULL,
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
  `estatus` int(1) DEFAULT '0',
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla wcafedb.ventasexternas: ~0 rows (aproximadamente)
DELETE FROM `ventasexternas`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
