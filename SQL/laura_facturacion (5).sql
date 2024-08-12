-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-01-2023 a las 19:29:51
-- Versión del servidor: 10.9.2-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `laura_facturacion`
--
CREATE DATABASE IF NOT EXISTS `laura_facturacion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci;
USE `laura_facturacion`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `created_at`, `updated_at`) VALUES
(0, 'Sin categoría', '2021-09-13 15:59:27', '2021-09-13 23:59:11'),
(1, 'Bebé', '2021-07-23 17:00:15', '2021-07-24 00:59:59'),
(2, 'Hogar', '2021-07-23 17:00:15', '2021-07-24 00:59:59'),
(3, 'Infantil', '2021-12-13 15:20:38', '2021-12-13 22:20:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `identificacion` varchar(12) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_tipo_identificacion` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `razon` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre_comercial` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_ubicacion` int(11) NOT NULL,
  `otras_senas` varchar(160) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `telefono` int(20) NOT NULL,
  `cod_pais` int(11) NOT NULL,
  `correo` varchar(160) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_eliminacion` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_cliente`),
  KEY `fk_clientes_cod_pais` (`cod_pais`),
  KEY `fk_clientes_tipo_identificaciones` (`id_tipo_identificacion`),
  KEY `fk_empresas` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_empresa`, `identificacion`, `id_tipo_identificacion`, `razon`, `nombre_comercial`, `id_ubicacion`, `otras_senas`, `telefono`, `cod_pais`, `correo`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `estado`) VALUES
(1, 1, '3102007223', '02', 'Corporacion De Supermercados Unidos Sociedad De Responsabilidad Limitada', 'Walmart', 1654, 'De RITEVE El Coyol, 600m oeste.', 99999925, 52, 'walmart.cr@einvoicing.signature-cloud.com', '2022-02-01 09:07:32', '2022-02-01 09:08:47', NULL, 1),
(2, 1, '402590885', '01', 'Alejandro Webb Solano', 'Creaciones Alejo', 4907, 'De la Escuela Mora y Cañas, 150m oeste y 75m sur. Casa blanca de alto.', 123456, 52, 'prueba0905@gmail.com', '2022-04-24 21:30:22', '2022-09-19 23:59:58', NULL, 1),
(3, 1, '3101112585', '02', 'Zona Franca Puntarenas S.A.', 'Zona Franca Puntarenas S.A.', 5059, 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 26632412, 52, 'smoraga@zonafrancapuntarenas.com', '2022-09-15 03:59:28', '2022-09-15 03:59:28', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `clientes_inactivos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `clientes_inactivos` (
`id_cliente` int(11)
,`id_empresa` int(11)
,`identificacion` varchar(12)
,`id_tipo_identificacion` varchar(2)
,`tipo_identificacion` varchar(25)
,`razon` varchar(100)
,`nombre` varchar(100)
,`nombre_comercial` varchar(80)
,`id_ubicacion` int(11)
,`cod_provincia` int(8)
,`provincia` varchar(10)
,`cod_canton` int(8)
,`canton` varchar(19)
,`cod_distrito` int(6)
,`distrito` varchar(28)
,`cod_barrio` int(5)
,`barrio` varchar(47)
,`otras_senas` varchar(160)
,`codigo_telefono` varchar(10)
,`telefono` int(20)
,`cod_pais` int(11)
,`correo` varchar(160)
,`fecha_creacion` datetime
,`fecha_modificacion` datetime
,`fecha_eliminacion` datetime
,`estado` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `clientes_view`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `clientes_view` (
`id_cliente` int(11)
,`id_empresa` int(11)
,`identificacion` varchar(12)
,`id_tipo_identificacion` varchar(2)
,`tipo_identificacion` varchar(25)
,`razon` varchar(100)
,`nombre` varchar(100)
,`nombre_comercial` varchar(80)
,`id_ubicacion` int(11)
,`cod_provincia` int(8)
,`provincia` varchar(10)
,`cod_canton` int(8)
,`canton` varchar(19)
,`cod_distrito` int(6)
,`distrito` varchar(28)
,`cod_barrio` int(5)
,`barrio` varchar(47)
,`otras_senas` varchar(160)
,`codigo_telefono` varchar(10)
,`telefono` int(20)
,`cod_pais` int(11)
,`correo` varchar(160)
,`fecha_creacion` datetime
,`fecha_modificacion` datetime
,`fecha_eliminacion` datetime
,`estado` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consecutivos`
--

CREATE TABLE IF NOT EXISTS `consecutivos` (
  `id_consecutivo` int(11) NOT NULL AUTO_INCREMENT,
  `ambiente` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_documento` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `consecutivo` int(11) NOT NULL,
  PRIMARY KEY (`id_consecutivo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `consecutivos`
--

INSERT INTO `consecutivos` (`id_consecutivo`, `ambiente`, `tipo_documento`, `consecutivo`) VALUES
(1, 'stag', '01', 87),
(2, 'prod', '01', 264),
(3, 'stag', '04', 158),
(4, 'prod', '04', 1),
(5, 'stag', '02', 2),
(6, 'prod', '02', 2),
(7, 'stag', '03', 35),
(8, 'prod', '03', 66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE IF NOT EXISTS `documentos` (
  `id_documento` int(11) NOT NULL AUTO_INCREMENT,
  `consecutivo` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_documento` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `codigo_seguridad` int(8) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `emisor_cedula` varchar(12) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emisor_nombre` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emisor_tipo` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emisor_comercial` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emisor_id_provincia` varchar(1) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emisor_id_canton` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emisor_id_distrito` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emisor_id_barrio` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `emisor_otras_senas` varchar(160) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emisor_cod` int(3) NOT NULL,
  `emisor_telefono` int(20) NOT NULL,
  `emisor_correo` varchar(60) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `receptor_nombre` varchar(80) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_cedula` varchar(12) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_tipo` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_comercial` varchar(80) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_id_provincia` varchar(1) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_id_canton` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_id_distrito` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_id_barrio` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_otras_senas` varchar(160) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `receptor_cod` int(3) DEFAULT NULL,
  `receptor_telefono` int(20) DEFAULT NULL,
  `receptor_correo` varchar(60) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `condicion_venta` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `plazo_credito` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `medio_pago` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `moneda` varchar(3) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_cambio` decimal(18,2) NOT NULL,
  `servicios_gravados` decimal(18,5) NOT NULL,
  `servicios_exentos` decimal(18,5) NOT NULL,
  `servicios_exonerados` decimal(18,5) NOT NULL,
  `mercancias_gravadas` decimal(18,5) NOT NULL,
  `mercancias_exentas` decimal(18,5) NOT NULL,
  `mercancias_exoneradas` decimal(18,5) NOT NULL,
  `total_gravado` decimal(18,5) NOT NULL,
  `total_exento` decimal(18,5) NOT NULL,
  `total_exonerado` decimal(18,5) NOT NULL,
  `total_venta` decimal(18,5) NOT NULL,
  `total_descuentos` decimal(18,5) NOT NULL,
  `total_venta_neta` decimal(18,5) NOT NULL,
  `total_impuestos` decimal(18,5) NOT NULL,
  `total_comprobante` decimal(18,5) NOT NULL,
  `notas` varchar(500) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL DEFAULT 1,
  `id_caja` int(11) NOT NULL DEFAULT 1,
  `id_sucursal` int(11) NOT NULL DEFAULT 1,
  `envio_atv` int(1) NOT NULL,
  `valido_atv` int(1) NOT NULL DEFAULT 0,
  `detalle_atv` varchar(500) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `correo_enviado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_correo` datetime DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `fecha_valido` datetime DEFAULT NULL,
  PRIMARY KEY (`id_documento`),
  UNIQUE KEY `clave` (`clave`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id_documento`, `consecutivo`, `tipo_documento`, `clave`, `codigo_seguridad`, `fecha`, `emisor_cedula`, `emisor_nombre`, `emisor_tipo`, `emisor_comercial`, `emisor_id_provincia`, `emisor_id_canton`, `emisor_id_distrito`, `emisor_id_barrio`, `emisor_otras_senas`, `emisor_cod`, `emisor_telefono`, `emisor_correo`, `receptor_nombre`, `receptor_cedula`, `receptor_tipo`, `receptor_comercial`, `receptor_id_provincia`, `receptor_id_canton`, `receptor_id_distrito`, `receptor_id_barrio`, `receptor_otras_senas`, `receptor_cod`, `receptor_telefono`, `receptor_correo`, `condicion_venta`, `plazo_credito`, `medio_pago`, `moneda`, `tipo_cambio`, `servicios_gravados`, `servicios_exentos`, `servicios_exonerados`, `mercancias_gravadas`, `mercancias_exentas`, `mercancias_exoneradas`, `total_gravado`, `total_exento`, `total_exonerado`, `total_venta`, `total_descuentos`, `total_venta_neta`, `total_impuestos`, `total_comprobante`, `notas`, `id_usuario`, `id_empresa`, `id_caja`, `id_sucursal`, `envio_atv`, `valido_atv`, `detalle_atv`, `correo_enviado`, `fecha_correo`, `fecha_envio`, `fecha_valido`) VALUES
(1, '00100002010000000187', '01', '50614122100010244007700100002010000000187195243816', 95243816, '2021-12-14 09:41:20', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(2, '00100002010000000188', '01', '50614122100010244007700100002010000000188140368197', 40368197, '2021-12-14 09:53:33', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(3, '00100002010000000189', '01', '50614122100010244007700100002010000000189159301628', 59301628, '2021-12-14 09:53:50', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(4, '00100002010000000190', '01', '50614122100010244007700100002010000000190106574983', 6574983, '2021-12-14 09:55:49', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(5, '00100002010000000191', '01', '50614122100010244007700100002010000000191120631458', 20631458, '2021-12-14 09:57:46', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(6, '00100002010000000192', '01', '50614122100010244007700100002010000000192109271468', 9271468, '2021-12-14 10:06:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(7, '00100002010000000193', '01', '50614122100010244007700100002010000000193143695072', 43695072, '2021-12-14 10:12:04', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(8, '00100002010000000194', '01', '50614122100010244007700100002010000000194161429835', 61429835, '2021-12-14 10:16:31', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(9, '00100002010000000195', '01', '50614122100010244007700100002010000000195113465708', 13465708, '2021-12-14 10:17:45', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(10, '00100002010000000196', '01', '50614122100010244007700100002010000000196109814257', 9814257, '2021-12-14 10:18:12', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(11, '00100002010000000197', '01', '50614122100010244007700100002010000000197191048672', 91048672, '2021-12-14 10:19:09', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(12, '00100002010000000198', '01', '50614122100010244007700100002010000000198117205369', 17205369, '2021-12-14 10:20:39', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(13, '00100002010000000199', '01', '50614122100010244007700100002010000000199169218347', 69218347, '2021-12-14 10:28:03', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(14, '00100002010000000200', '01', '50614122100010244007700100002010000000200121670895', 21670895, '2021-12-14 10:30:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(15, '00100002010000000201', '01', '50614122100010244007700100002010000000201159768402', 59768402, '2021-12-14 10:31:59', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(16, '00100002010000000202', '01', '50614122100010244007700100002010000000202171586209', 71586209, '2021-12-14 10:33:35', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(17, '00100002010000000203', '01', '50614122100010244007700100002010000000203172360541', 72360541, '2021-12-14 10:38:05', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '0.00000', '0.00000', '124188.00000', '3725.64000', '120462.36000', '15660.11000', '136122.47000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(18, '00100002010000000204', '01', '50614122100010244007700100002010000000204152813607', 52813607, '2021-12-14 10:41:50', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '165728.00000', '0.00000', '0.00000', '165728.00000', '0.00000', '0.00000', '165728.00000', '4971.84000', '160756.16000', '20898.30000', '181654.46000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(19, '00100002010000000205', '01', '50614122100010244007700100002010000000205136948027', 36948027, '2021-12-14 10:44:02', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '100912.00000', '0.00000', '0.00000', '100912.00000', '0.00000', '0.00000', '100912.00000', '3027.36000', '97884.64000', '12725.00000', '110609.64000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(20, '00100002010000000206', '01', '50614122100010244007700100002010000000206113648952', 13648952, '2021-12-14 10:51:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '2835.06000', '91666.94000', '11916.70000', '103583.64000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(21, '00100002010000000207', '01', '50614122100010244007700100002010000000207103975864', 3975864, '2021-12-14 11:09:34', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '2835.06000', '91666.94000', '11916.70000', '103583.64000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(22, '00100002010000000208', '01', '50614122100010244007700100002010000000208138519642', 38519642, '2021-12-14 11:12:21', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '2835.06000', '91666.94000', '11916.70000', '103583.64000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(23, '00100002010000000209', '01', '50614122100010244007700100002010000000209132568497', 32568497, '2021-12-14 11:13:12', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '2835.06000', '91666.94000', '11916.70000', '103583.64000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(24, '00100002010000000210', '01', '50614122100010244007700100002010000000210109831475', 9831475, '2021-12-14 11:14:03', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '0.00000', '0.00000', '94502.00000', '2835.06000', '91666.94000', '11916.70000', '103583.64000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(25, '00100002010000000211', '01', '50614122100010244007700100002010000000211121507386', 21507386, '2021-12-14 11:44:16', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '52338.00000', '0.00000', '0.00000', '52338.00000', '0.00000', '0.00000', '52338.00000', '1579.14000', '50758.86000', '6598.66000', '57357.51000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(26, '00100002010000000212', '01', '50614122100010244007700100002010000000212137054691', 37054691, '2021-12-14 11:49:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '0.00000', '8459.00000', '253.77000', '8205.23000', '1066.68000', '9271.91000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(27, '00100002010000000213', '01', '50614122100010244007700100002010000000213162459031', 62459031, '2021-12-14 11:51:36', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '8459.00000', '1099.67000', '9558.67000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(28, '00100002010000000214', '01', '50614122100010244007700100002010000000214185041937', 85041937, '2021-12-14 12:03:25', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '22560.00000', '0.00000', '0.00000', '22560.00000', '0.00000', '0.00000', '22560.00000', '676.80000', '21883.20000', '2844.82000', '24728.02000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(29, '00100002010000000215', '01', '50614122100010244007700100002010000000215131297846', 31297846, '2021-12-14 12:05:11', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.29000', '4896.29000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(30, '00100002010000000216', '01', '50614122100010244007700100002010000000216185412769', 85412769, '2021-12-14 12:25:43', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '27072.00000', '0.00000', '0.00000', '27072.00000', '0.00000', '0.00000', '27072.00000', '812.16000', '26259.84000', '3413.78000', '29673.62000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(31, '00100002010000000217', '01', '50614122100010244007700100002010000000217154209716', 54209716, '2021-12-14 12:40:57', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(32, '00100002010000000218', '01', '50614122100010244007700100002010000000218187239601', 87239601, '2021-12-14 12:44:46', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(33, '00100002010000000219', '01', '50614122100010244007700100002010000000219142913658', 42913658, '2021-12-14 12:47:23', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(34, '00100002010000000220', '01', '50614122100010244007700100002010000000220163574028', 63574028, '2021-12-14 12:50:47', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(35, '00100002010000000221', '01', '50614122100010244007700100002010000000221180142697', 80142697, '2021-12-14 12:51:29', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(36, '00100002010000000222', '01', '50614122100010244007700100002010000000222193467812', 93467812, '2021-12-14 12:53:55', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(37, '00100002010000000223', '01', '50614122100010244007700100002010000000223151279480', 51279480, '2021-12-14 12:55:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(38, '00100002010000000224', '01', '50614122100010244007700100002010000000224182419576', 82419576, '2021-12-14 12:56:15', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(39, '00100002010000000225', '01', '50614122100010244007700100002010000000225170692845', 70692845, '2021-12-14 12:59:32', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '0.00000', '0.00000', '6768.00000', '203.04000', '6564.96000', '853.44000', '7418.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(40, '00100002010000000226', '01', '50614122100010244007700100002010000000226119647250', 19647250, '2021-12-14 14:02:18', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '27072.00000', '0.00000', '0.00000', '27072.00000', '0.00000', '0.00000', '27072.00000', '0.00000', '27072.00000', '3519.36000', '30591.36000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(41, '00100002010000000227', '01', '50614122100010244007700100002010000000227165249780', 65249780, '2021-12-14 14:39:51', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(42, '00100002010000000228', '01', '50614122100010244007700100002010000000228106213975', 6213975, '2021-12-14 15:50:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '1.00', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(43, '00100002010000000004', '01', '50629122100010244007700100002010000000004115069237', 15069237, '2021-12-29 12:36:16', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(44, '00100002010000000005', '01', '50629122100010244007700100002010000000005181450269', 81450269, '2021-12-29 12:42:24', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(45, '00100002010000000006', '01', '50629122100010244007700100002010000000006194837562', 94837562, '2021-12-29 12:44:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(46, '00100002010000000007', '01', '50629122100010244007700100002010000000007159130267', 59130267, '2021-12-29 12:46:52', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(47, '00100002010000000009', '01', '50629122100010244007700100002010000000009161795240', 61795240, '2021-12-29 12:49:57', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(48, '00100002010000000010', '01', '50629122100010244007700100002010000000010115362497', 15362497, '2021-12-29 12:50:16', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(49, '00100002010000000011', '01', '50629122100010244007700100002010000000011125743691', 25743691, '2021-12-29 12:52:10', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(50, '00100002010000000012', '01', '50629122100010244007700100002010000000012148307125', 48307125, '2021-12-29 12:57:36', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(51, '00100002010000000013', '01', '50629122100010244007700100002010000000013125697138', 25697138, '2021-12-29 13:00:17', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(52, '00100002010000000014', '01', '50629122100010244007700100002010000000014161428075', 61428075, '2021-12-29 13:02:30', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(53, '00100002010000000015', '01', '50629122100010244007700100002010000000015101346987', 1346987, '2021-12-29 14:41:24', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '04', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '14890.58000', '0.00000', '0.00000', '14890.58000', '0.00000', '0.00000', '14890.58000', '0.00000', '14890.58000', '1935.78000', '16826.36000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(54, '00100002010000000016', '01', '50629122100010244007700100002010000000016112964785', 12964785, '2021-12-29 14:45:14', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '04', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '14890.58000', '0.00000', '0.00000', '14890.58000', '0.00000', '0.00000', '14890.58000', '0.00000', '14890.58000', '1935.78000', '16826.36000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(55, '00100002010000000017', '01', '50629122100010244007700100002010000000017178521403', 78521403, '2021-12-29 14:49:06', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '01', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '5098.00000', '0.00000', '0.00000', '5098.00000', '0.00000', '0.00000', '5098.00000', '0.00000', '5098.00000', '662.74000', '5760.74000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(56, '00100002010000000018', '01', '50630122100010244007700100002010000000018152037164', 52037164, '2021-12-29 21:28:35', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '03', 'CRC', '638.94', '0.00000', '0.00000', '0.00000', '5098.00000', '0.00000', '0.00000', '5098.00000', '0.00000', '0.00000', '5098.00000', '0.00000', '5098.00000', '662.74000', '5760.74000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(57, '00100002040000000000', '04', '50631122100010244007700100002040000000000151078642', 51078642, '2021-12-30 19:56:49', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '03', 'CRC', '638.75', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(58, '00100002040000000000', '04', '50631122100010244007700100002040000000000171963428', 71963428, '2021-12-30 20:17:56', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.75', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(59, '00100002040000000001', '04', '50631122100010244007700100002040000000001117043856', 17043856, '2021-12-30 20:22:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.75', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(60, '00100002040000000002', '04', '50631122100010244007700100002040000000002190261475', 90261475, '2021-12-30 20:23:52', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.75', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(61, '00100002040000000003', '04', '50631122100010244007700100002040000000003197501248', 97501248, '2021-12-31 10:16:23', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '639.06', '0.00000', '0.00000', '0.00000', '4896.29000', '0.00000', '0.00000', '4896.29000', '0.00000', '0.00000', '4896.29000', '0.00000', '4896.29000', '636.52000', '5532.81000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(62, '00100002040000000004', '04', '50601012200010244007700100002040000000004127354608', 27354608, '2022-01-01 00:46:12', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '639.06', '0.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '0.00000', '2549.00000', '0.00000', '2549.00000', '331.37000', '2880.37000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(63, '00100002010000000003', '01', '50601012200010244007700100002010000000003179813425', 79813425, '2022-01-01 00:48:38', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '639.06', '0.00000', '0.00000', '0.00000', '99539.48000', '0.00000', '0.00000', '99539.48000', '0.00000', '0.00000', '99539.48000', '0.00000', '99539.48000', '12940.13000', '112479.61000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(64, '00100002040000000005', '04', '50605012200010244007700100002040000000005171325068', 71325068, '2022-01-05 14:37:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '9353.75000', '0.00000', '0.00000', '9353.75000', '0.00000', '0.00000', '9353.75000', '0.00000', '9353.75000', '1215.99000', '10569.74000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(65, '00100002040000000006', '04', '50605012200010244007700100002040000000006132510948', 32510948, '2022-01-05 15:12:26', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '4333.00000', '129.99000', '4203.01000', '546.39000', '4749.40000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(66, '00100002040000000007', '04', '50605012200010244007700100002040000000007103825176', 3825176, '2022-01-05 15:18:15', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '67.68000', '2188.32000', '284.48000', '2472.80000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(67, '00100002010000000004', '01', '50605012200010244007700100002010000000004182415639', 82415639, '2022-01-05 15:21:39', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '03', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(68, '00100002040000000008', '04', '50605012200010244007700100002040000000008127105893', 27105893, '2022-01-05 15:27:57', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '03', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(69, '00100002010000000005', '01', '50605012200010244007700100002010000000005113709548', 13709548, '2022-01-05 15:30:34', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '03', 'CRC', '638.47', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(70, '00100002040000000009', '04', '50605012200010244007700100002040000000009163042718', 63042718, '2022-01-05 15:33:57', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '6589.00000', '0.00000', '0.00000', '6589.00000', '0.00000', '0.00000', '6589.00000', '0.00000', '6589.00000', '856.57000', '7445.57000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(71, '00100002040000000010', '04', '50605012200010244007700100002040000000010131085724', 31085724, '2022-01-05 16:29:48', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '67.68000', '2188.32000', '284.48000', '2472.80000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(72, '00100002040000000011', '04', '50605012200010244007700100002040000000011190645712', 90645712, '2022-01-05 16:31:52', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '1128.00000', '0.00000', '0.00000', '1128.00000', '0.00000', '0.00000', '1128.00000', '0.00000', '1128.00000', '146.64000', '1274.64000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL);
INSERT INTO `documentos` (`id_documento`, `consecutivo`, `tipo_documento`, `clave`, `codigo_seguridad`, `fecha`, `emisor_cedula`, `emisor_nombre`, `emisor_tipo`, `emisor_comercial`, `emisor_id_provincia`, `emisor_id_canton`, `emisor_id_distrito`, `emisor_id_barrio`, `emisor_otras_senas`, `emisor_cod`, `emisor_telefono`, `emisor_correo`, `receptor_nombre`, `receptor_cedula`, `receptor_tipo`, `receptor_comercial`, `receptor_id_provincia`, `receptor_id_canton`, `receptor_id_distrito`, `receptor_id_barrio`, `receptor_otras_senas`, `receptor_cod`, `receptor_telefono`, `receptor_correo`, `condicion_venta`, `plazo_credito`, `medio_pago`, `moneda`, `tipo_cambio`, `servicios_gravados`, `servicios_exentos`, `servicios_exonerados`, `mercancias_gravadas`, `mercancias_exentas`, `mercancias_exoneradas`, `total_gravado`, `total_exento`, `total_exonerado`, `total_venta`, `total_descuentos`, `total_venta_neta`, `total_impuestos`, `total_comprobante`, `notas`, `id_usuario`, `id_empresa`, `id_caja`, `id_sucursal`, `envio_atv`, `valido_atv`, `detalle_atv`, `correo_enviado`, `fecha_correo`, `fecha_envio`, `fecha_valido`) VALUES
(73, '00100002040000000012', '04', '50606012200010244007700100002040000000012164125803', 64125803, '2022-01-05 20:06:00', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(74, '00100002040000000013', '04', '50606012200010244007700100002040000000013165412907', 65412907, '2022-01-05 20:32:41', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '638.47', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(75, '00100002040000000014', '04', '50606012200010244007700100002040000000014149013726', 49013726, '2022-01-05 20:46:22', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '01', 'CRC', '638.47', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 0, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(76, '00100002010000000007', '01', '50621012200010244007700100002010000000007137142085', 37142085, '2022-01-20 19:04:54', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '03', 'CRC', '629.68', '0.00000', '0.00000', '0.00000', '100554.00000', '0.00000', '0.00000', '100554.00000', '0.00000', '0.00000', '100554.00000', '3016.62000', '97537.38000', '12679.86000', '110217.24000', '', 1, 1, 0, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-20 20:05:01', '2022-01-30 20:42:47'),
(77, '00100002010000000008', '01', '50621012200010244007700100002010000000008127984065', 27984065, '2022-01-20 19:09:31', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '629.68', '0.00000', '0.00000', '0.00000', '74556.00000', '0.00000', '0.00000', '74556.00000', '0.00000', '0.00000', '74556.00000', '2236.68000', '72319.32000', '9401.52000', '81720.84000', '', 1, 1, 0, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-20 20:09:37', '2022-01-20 20:09:37'),
(78, '00100002010000000009', '01', '50621012200010244007700100002010000000009150139846', 50139846, '2022-01-20 19:18:12', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '03', 'CRC', '629.68', '0.00000', '0.00000', '0.00000', '43330.00000', '0.00000', '0.00000', '43330.00000', '0.00000', '0.00000', '43330.00000', '0.00000', '43330.00000', '5632.90000', '48962.90000', '', 1, 1, 0, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-20 20:18:27', '2022-01-20 20:18:27'),
(79, '00100002010000000010', '01', '50621012200010244007700100002010000000010170831246', 70831246, '2022-01-20 19:33:44', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JP Network', '116640506', '01', 'JP Network', '6', '1', '1', '3', 'De la escuela Mora y Cañas, 150m oeste y 75m sur.', 506, 70391069, 'chepelcr@outlook.com', '01', '0', '03', 'CRC', '629.68', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 0, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-20 20:33:52', '2022-01-20 20:33:52'),
(80, '00100002010000000012', '01', '50623012200010244007700100002010000000012119705864', 19705864, '2022-01-23 12:39:56', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JOHNNY', '107430845', '01', 'JOHNNY', '1', '4', '3', '3', 'Diagonal a la Pulperia Colonial', 506, 87087973, 'johnny.campos@gmail.com', '01', '0', '03', 'CRC', '633.17', '0.00000', '0.00000', '0.00000', '45130.00000', '0.00000', '0.00000', '45130.00000', '0.00000', '0.00000', '45130.00000', '0.00000', '45130.00000', '5866.90000', '50996.90000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-23 13:40:04', '2022-01-30 12:19:40'),
(81, '00100004010000000001', '01', '50623012200010244007700100004010000000001178934652', 78934652, '2022-01-23 12:43:44', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JOHNNY', '107430845', '01', 'JOHNNY', '1', '4', '3', '3', 'Diagonal a la Pulperia Colonial', 506, 87087973, 'johnny.campos@gmail.com', '01', '0', '03', 'CRC', '633.17', '0.00000', '0.00000', '0.00000', '48558.00000', '0.00000', '0.00000', '48558.00000', '0.00000', '0.00000', '48558.00000', '0.00000', '48558.00000', '6312.54000', '54870.54000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-23 13:43:50', '2022-01-23 13:43:50'),
(82, '00100004010000000002', '01', '50624012200010244007700100004010000000002115829364', 15829364, '2022-01-23 19:16:16', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Modas Laura', '102440077', '01', 'Modas Laura', '6', '1', '1', '3', 'Entrada al Vikings.', 506, 89890512, 'vilmacorella@yahoo.com', '01', '0', '04', 'CRC', '633.17', '0.00000', '0.00000', '0.00000', '19946.00000', '0.00000', '0.00000', '19946.00000', '0.00000', '0.00000', '19946.00000', '0.00000', '19946.00000', '2592.98000', '22538.98000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-23 20:16:25', '2022-01-23 20:16:25'),
(83, '00100004040000000001', '04', '50624012200010244007700100004040000000001107943285', 7943285, '2022-01-24 10:27:00', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '633.17', '0.00000', '0.00000', '0.00000', '482753.00000', '0.00000', '0.00000', '482753.00000', '0.00000', '0.00000', '482753.00000', '14482.59000', '468270.41000', '60875.15000', '529145.56000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-24 11:27:07', '2022-01-24 11:27:07'),
(84, '00100004010000000003', '01', '50624012200010244007700100004010000000003182095361', 82095361, '2022-01-24 10:39:42', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '31020072231', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '633.17', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-24 11:39:49', '2022-01-31 10:35:38'),
(85, '00100004040000000002', '04', '50625012200010244007700100004040000000002128397456', 28397456, '2022-01-24 18:54:09', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '03', 'CRC', '633.17', '0.00000', '0.00000', '0.00000', '16918.00000', '0.00000', '0.00000', '16918.00000', '0.00000', '0.00000', '16918.00000', '845.90000', '16072.10000', '2089.37000', '18161.47000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-24 19:54:18', '2022-01-24 19:54:18'),
(86, '00100004010000000004', '01', '50628012200010244007700100004010000000004116803742', 16803742, '2022-01-28 06:28:34', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '31020072231', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '03', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '33850.00000', '0.00000', '0.00000', '33850.00000', '0.00000', '0.00000', '33850.00000', '1015.50000', '32834.50000', '4268.49000', '37102.99000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 07:28:42', '2022-01-28 07:28:42'),
(87, '00100004010000000005', '01', '50628012200010244007700100004010000000005134981652', 34981652, '2022-01-28 06:45:44', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '31020072231', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '11280.00000', '0.00000', '0.00000', '11280.00000', '0.00000', '0.00000', '11280.00000', '0.00000', '11280.00000', '1466.40000', '12746.40000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 07:45:50', '2022-01-28 07:45:50'),
(88, '00100004010000000006', '01', '50628012200010244007700100004010000000006103698512', 3698512, '2022-01-28 06:54:25', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '31020072231', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(89, '00100004010000000007', '01', '50628012200010244007700100004010000000007124097813', 24097813, '2022-01-28 07:00:42', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '31020072231', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 08:00:48', '2022-01-28 08:00:48'),
(90, '00100004010000000008', '01', '50628012200010244007700100004010000000008110293568', 10293568, '2022-01-28 07:03:45', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '31020072231', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 08:03:51', '2022-01-28 08:03:51'),
(91, '00100004010000000004', '01', '50628012200010244007700100004010000000004150172683', 50172683, '2022-01-28 10:29:10', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'JOHNNY', '107430845', '01', 'JOHNNY', '1', '4', '3', '3', 'Diagonal a la Pulperia Colonial', 506, 87087970, 'johnny.campos@gmail.com', '01', '0', '04', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '67.68000', '2188.32000', '284.48000', '2472.80000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 11:29:16', '2022-01-28 11:29:16'),
(92, '00100004010000000006', '01', '50628012200010244007700100004010000000006130625849', 30625849, '2022-01-28 10:36:21', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '31020072231', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '67.68000', '2188.32000', '284.48000', '2472.80000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 11:36:27', '2022-01-28 11:36:27'),
(93, '00100004010000000007', '01', '50628012200010244007700100004010000000007189164702', 89164702, '2022-01-28 10:41:43', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '31020072231', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 11:41:50', '2022-01-28 11:41:50'),
(94, '00100004010000000010', '01', '50628012200010244007700100004010000000010187231604', 87231604, '2022-01-28 10:52:42', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 11:52:49', '2022-01-28 11:52:49'),
(95, '00100004030000000009', '03', '50628012200010244007700100004030000000009109827153', 9827153, '2022-01-28 11:05:36', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(96, '00100004030000000011', '03', '50628012200010244007700100004030000000011147092836', 47092836, '2022-01-28 11:08:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(97, '00100004030000000012', '03', '50628012200010244007700100004030000000012174301268', 74301268, '2022-01-28 11:10:29', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(98, '00100004030000000014', '03', '50628012200010244007700100004030000000014156479812', 56479812, '2022-01-28 11:11:33', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(99, '00100004030000000015', '03', '50628012200010244007700100004030000000015156179402', 56179402, '2022-01-28 11:17:50', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(100, '00100004030000000016', '03', '50628012200010244007700100004030000000016112354798', 12354798, '2022-01-28 11:18:39', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(101, '00100004030000000017', '03', '50628012200010244007700100004030000000017142065187', 42065187, '2022-01-28 11:20:23', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 12:20:30', '2022-01-28 12:20:30'),
(102, '00100004030000000018', '03', '50628012200010244007700100004030000000018170549183', 70549183, '2022-01-28 11:27:26', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 12:27:33', '2022-01-28 12:27:33'),
(103, '00100004030000000019', '03', '50628012200010244007700100004030000000019174398206', 74398206, '2022-01-28 11:30:34', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 12:30:40', '2022-01-28 12:30:40'),
(104, '00100004030000000021', '03', '50628012200010244007700100004030000000021189241350', 89241350, '2022-01-28 12:15:01', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 13:15:17', '2022-01-28 13:15:17'),
(105, '00100004020000000001', '02', '50628012200010244007700100004020000000001189403752', 89403752, '2022-01-28 12:16:45', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 13:16:51', '2022-01-28 13:16:51'),
(106, '00100004040000000002', '04', '50628012200010244007700100004040000000002113527496', 13527496, '2022-01-28 12:19:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.70', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 13:19:27', '2022-01-28 13:19:27'),
(107, '00500001030000000022', '03', '50628012200010244007700500001030000000022116390875', 16390875, '2022-01-28 15:50:26', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 16:50:33', '2022-01-28 16:50:33'),
(108, '00500001030000000023', '03', '50628012200010244007700500001030000000023168403927', 68403927, '2022-01-28 16:01:47', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL),
(109, '00500001030000000025', '03', '50628012200010244007700500001030000000025121698057', 21698057, '2022-01-28 16:03:02', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 17:03:09', '2022-01-28 17:03:09'),
(110, '00500001030000000026', '03', '50628012200010244007700500001030000000026190285376', 90285376, '2022-01-28 16:04:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 17:04:34', '2022-01-28 17:04:34'),
(111, '00500001030000000027', '03', '50628012200010244007700500001030000000027146875923', 46875923, '2022-01-28 16:13:02', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '2247.79000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '2247.79000', '0.00000', '0.00000', '2247.79000', '0.00000', '2247.79000', '292.21000', '2540.00000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 17:13:08', '2022-01-28 17:13:08'),
(112, '00500001030000000028', '03', '50628012200010244007700500001030000000028185397261', 85397261, '2022-01-28 16:16:02', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 17:16:08', '2022-01-28 17:16:08'),
(113, '00500001030000000029', '03', '50629012200010244007700500001030000000029140593768', 40593768, '2022-01-28 18:07:29', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.70', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-28 19:07:36', '2022-01-28 19:07:36'),
(114, '00500001040000000003', '04', '50629012200010244007700500001040000000003124156039', 24156039, '2022-01-29 10:26:45', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '638.97', '1345.13000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.13000', '0.00000', '0.00000', '1345.13000', '0.00000', '1345.13000', '174.87000', '1520.00000', '', 4, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-29 11:26:53', '2022-01-29 11:26:53'),
(115, '00500001010000000011', '01', '50630012200010244007700500001010000000011189650127', 89650127, '2022-01-29 22:35:36', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '638.97', '0.00000', '0.00000', '0.00000', '11280.00000', '0.00000', '0.00000', '11280.00000', '0.00000', '0.00000', '11280.00000', '0.00000', '11280.00000', '1466.40000', '12746.40000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-29 23:35:51', '2022-01-29 23:35:51'),
(116, '00500001010000000013', '01', '50630012200010244007700500001010000000013131407698', 31407698, '2022-01-29 22:41:15', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '638.97', '0.00000', '0.00000', '0.00000', '4514.00000', '0.00000', '0.00000', '4514.00000', '0.00000', '0.00000', '4514.00000', '0.00000', '4514.00000', '586.82000', '5100.82000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-01-29 23:41:21', '2022-01-29 23:41:21'),
(117, '00500001010000000014', '01', '50630012200010244007700500001010000000014115478260', 15478260, '2022-01-29 22:55:03', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '638.97', '0.00000', '0.00000', '0.00000', '4514.00000', '0.00000', '0.00000', '4514.00000', '0.00000', '0.00000', '4514.00000', '0.00000', '4514.00000', '586.82000', '5100.82000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-29 23:55:10', '2022-01-29 23:55:10'),
(118, '00500001040000000004', '04', '50630012200010244007700500001040000000004156432781', 56432781, '2022-01-29 23:07:01', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '638.97', '0.00000', '0.00000', '0.00000', '17116.00000', '0.00000', '0.00000', '17116.00000', '0.00000', '0.00000', '17116.00000', '0.00000', '17116.00000', '2225.08000', '19341.08000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-30 00:07:07', '2022-01-30 00:07:07'),
(119, '00500001010000000015', '01', '50630012200010244007700500001010000000015160735149', 60735149, '2022-01-29 23:09:23', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '638.97', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-30 00:09:29', '2022-01-30 00:09:29'),
(120, '00500001010000000016', '01', '50630012200010244007700500001010000000016146931752', 46931752, '2022-01-29 23:12:29', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De Riteve El Coyol, 600m Oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '638.97', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '2256.00000', '293.28000', '2549.28000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-01-30 00:12:35', '2022-01-30 00:12:35'),
(121, '00500001040000000005', '04', '50601022200010244007700500001040000000005142560981', 42560981, '2022-02-01 06:50:40', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '0.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '8459.00000', '1099.67000', '9558.67000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 07:50:46', '2022-02-01 10:19:55'),
(122, '00500001040000000006', '04', '50601022200010244007700500001040000000006157018936', 57018936, '2022-02-01 06:58:10', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 07:58:16', '2022-02-01 10:40:12'),
(123, '01000001040000000007', '04', '50601022200010244007701000001040000000007118539246', 18539246, '2022-02-01 06:59:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 07:59:35', '2022-02-01 07:59:35'),
(124, '01000001040000000008', '04', '50601022200010244007701000001040000000008131849072', 31849072, '2022-02-01 07:01:43', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 08:01:49', '2022-02-01 08:01:49'),
(125, '01000001010000000017', '01', '50601022200010244007701000001010000000017113582049', 13582049, '2022-02-01 09:09:53', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.05', '0.00000', '0.00000', '0.00000', '56866.00000', '0.00000', '0.00000', '56866.00000', '0.00000', '0.00000', '56866.00000', '0.00000', '56866.00000', '7392.58000', '64258.58000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 10:10:01', '2022-02-01 10:10:01'),
(126, '01000001040000000009', '04', '50601022200010244007701000001040000000009115794082', 15794082, '2022-02-01 09:13:36', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 10:13:42', '2022-02-01 10:13:42'),
(127, '01000001010000000018', '01', '50601022200010244007701000001010000000018137521408', 37521408, '2022-02-01 09:15:27', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.05', '0.00000', '0.00000', '0.00000', '1500.00000', '0.00000', '0.00000', '1500.00000', '0.00000', '0.00000', '1500.00000', '0.00000', '1500.00000', '195.00000', '1695.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 10:15:34', '2022-02-01 10:15:34'),
(128, '01000001040000000010', '04', '50601022200010244007701000001040000000010170519346', 70519346, '2022-02-01 09:20:24', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 10:20:31', '2022-02-01 10:20:31'),
(129, '01000001040000000011', '04', '50601022200010244007701000001040000000011170623159', 70623159, '2022-02-01 09:23:38', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 10:23:44', '2022-02-01 10:23:44'),
(130, '01000001040000000012', '04', '50601022200010244007701000001040000000012172018639', 72018639, '2022-02-01 09:31:22', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '0.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '0.00000', '8459.00000', '0.00000', '8459.00000', '1099.67000', '9558.67000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 10:31:29', '2022-02-01 10:31:29'),
(131, '01000001040000000013', '04', '50601022200010244007701000001040000000013180963724', 80963724, '2022-02-01 09:35:09', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 10:35:15', '2022-02-01 10:35:15'),
(132, '01000001040000000014', '04', '50601022200010244007701000001040000000014174906218', 74906218, '2022-02-01 09:36:54', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 10:37:00', '2022-02-01 10:37:00'),
(133, '01000001040000000015', '04', '50601022200010244007701000001040000000015119687340', 19687340, '2022-02-01 11:57:41', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '147.34000', '4764.15000', '619.34000', '5383.50000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 12:57:48', '2022-02-01 12:58:16'),
(134, '01000001040000000016', '04', '50601022200010244007701000001040000000016194163207', 94163207, '2022-02-01 11:59:15', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '147.34000', '4764.15000', '619.34000', '5383.50000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 12:59:21', '2022-02-01 12:59:21'),
(135, '01000001040000000017', '04', '50601022200010244007701000001040000000017196253471', 96253471, '2022-02-01 12:00:11', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '0.00000', '0.00000', '0.00000', '4514.00000', '0.00000', '0.00000', '4514.00000', '0.00000', '0.00000', '4514.00000', '225.70000', '4288.30000', '557.48000', '4845.78000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 13:00:18', '2022-02-01 13:00:18'),
(136, '01000001040000000018', '04', '50601022200010244007701000001040000000018149573286', 49573286, '2022-02-01 12:02:54', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '0.00000', '0.00000', '0.00000', '33840.00000', '0.00000', '0.00000', '33840.00000', '0.00000', '0.00000', '33840.00000', '1015.20000', '32824.80000', '4267.22000', '37092.02000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 13:03:00', '2022-02-01 13:03:00'),
(137, '01000001040000000019', '04', '50601022200010244007701000001040000000019171065384', 71065384, '2022-02-01 12:03:57', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '147.34000', '4764.15000', '619.34000', '5383.50000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 13:04:03', '2022-02-01 13:04:03'),
(138, '01000001010000000023', '01', '50601022200010244007701000001010000000023178659034', 78659034, '2022-02-01 12:08:15', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 13:08:23', '2022-02-01 13:08:23'),
(139, '01000001030000000032', '03', '50601022200010244007701000001030000000032167298514', 67298514, '2022-02-01 12:09:36', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.05', '4911.50000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.50000', '0.00000', '0.00000', '4911.50000', '0.00000', '4911.50000', '638.50000', '5549.99000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 13:09:42', '2022-02-01 13:09:42'),
(140, '01000001040000000020', '04', '50601022200010244007701000001040000000020149610258', 49610258, '2022-02-01 14:44:25', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4912.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4912.00000', '0.00000', '0.00000', '4912.00000', '148.00000', '4765.00000', '620.00000', '5384.00000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 15:44:31', '2022-02-01 15:44:31'),
(141, '01000001040000000021', '04', '50601022200010244007701000001040000000021160385197', 60385197, '2022-02-01 14:56:47', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '4911.00000', '638.00000', '5549.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 15:56:53', '2022-02-01 15:56:53'),
(142, '01000001040000000022', '04', '50601022200010244007701000001040000000022112063587', 12063587, '2022-02-01 14:57:29', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '4', '2', '2', '5', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.05', '4911.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '0.00000', '4911.00000', '147.00000', '4764.00000', '619.00000', '5383.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-01 15:57:36', '2022-02-01 15:57:36'),
(143, '01000001040000000023', '04', '50611022200010244007701000001040000000023194502176', 94502176, '2022-02-11 15:56:58', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.19', '4911.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '4911.00000', '638.00000', '5549.00000', '', 1, 1, 1, 1, 0, 0, NULL, 1, '2022-04-23 13:55:55', NULL, NULL);
INSERT INTO `documentos` (`id_documento`, `consecutivo`, `tipo_documento`, `clave`, `codigo_seguridad`, `fecha`, `emisor_cedula`, `emisor_nombre`, `emisor_tipo`, `emisor_comercial`, `emisor_id_provincia`, `emisor_id_canton`, `emisor_id_distrito`, `emisor_id_barrio`, `emisor_otras_senas`, `emisor_cod`, `emisor_telefono`, `emisor_correo`, `receptor_nombre`, `receptor_cedula`, `receptor_tipo`, `receptor_comercial`, `receptor_id_provincia`, `receptor_id_canton`, `receptor_id_distrito`, `receptor_id_barrio`, `receptor_otras_senas`, `receptor_cod`, `receptor_telefono`, `receptor_correo`, `condicion_venta`, `plazo_credito`, `medio_pago`, `moneda`, `tipo_cambio`, `servicios_gravados`, `servicios_exentos`, `servicios_exonerados`, `mercancias_gravadas`, `mercancias_exentas`, `mercancias_exoneradas`, `total_gravado`, `total_exento`, `total_exonerado`, `total_venta`, `total_descuentos`, `total_venta_neta`, `total_impuestos`, `total_comprobante`, `notas`, `id_usuario`, `id_empresa`, `id_caja`, `id_sucursal`, `envio_atv`, `valido_atv`, `detalle_atv`, `correo_enviado`, `fecha_correo`, `fecha_envio`, `fecha_valido`) VALUES
(144, '01000001040000000024', '04', '50611022200010244007701000001040000000024172586149', 72586149, '2022-02-11 15:58:49', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.19', '4911.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '4911.00000', '638.00000', '5549.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-11 16:58:55', '2022-02-13 07:18:22'),
(145, '01000001040000000025', '04', '50611022200010244007701000001040000000025145278369', 45278369, '2022-02-11 16:04:05', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.19', '4911.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '4911.00000', '638.00000', '5549.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-04-23 13:55:55', '2022-02-11 17:04:11', '2022-02-13 11:18:05'),
(146, '01000001040000000026', '04', '50611022200010244007701000001040000000026151379804', 51379804, '2022-02-11 16:12:31', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.19', '4911.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '4911.00000', '638.00000', '5549.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-04-23 13:55:55', '2022-02-11 17:12:37', NULL),
(147, '01000001040000000027', '04', '50611022200010244007701000001040000000027159642018', 59642018, '2022-02-11 16:25:05', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '640.19', '4911.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '0.00000', '4911.00000', '0.00000', '4911.00000', '638.00000', '5549.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-04-23 13:55:55', '2022-02-11 17:25:12', NULL),
(148, '01000001010000000024', '01', '50611022200010244007701000001010000000024194352718', 94352718, '2022-02-11 16:51:16', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '640.19', '0.00000', '0.00000', '0.00000', '178332.00000', '0.00000', '0.00000', '178332.00000', '0.00000', '0.00000', '178332.00000', '5350.00000', '172982.00000', '22488.00000', '195470.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-04-23 13:55:55', '2022-02-11 17:51:24', NULL),
(149, '00100007040000000028', '04', '50613022200010244007700100007040000000028176231490', 76231490, '2022-02-13 07:08:31', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '638.63', '1345.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1345.00000', '0.00000', '0.00000', '1345.00000', '40.00000', '1305.00000', '170.00000', '1475.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-04-23 13:55:55', '2022-02-13 08:08:37', NULL),
(150, '00100007010000000025', '01', '50613022200010244007700100007010000000025158634021', 58634021, '2022-02-13 15:07:56', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '638.63', '0.00000', '0.00000', '0.00000', '178332.00000', '0.00000', '0.00000', '178332.00000', '0.00000', '0.00000', '178332.00000', '5350.00000', '172982.00000', '22488.00000', '195470.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-04-23 13:55:55', '2022-02-13 16:08:04', NULL),
(151, '00100007040000000029', '04', '50622042200010244007700100007040000000029115376480', 15376480, '2022-04-22 11:34:37', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '655.10', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, NULL, 1, '2022-05-14 03:04:04', '2022-04-22 13:34:46', '2022-04-22 17:29:20'),
(152, '00100007040000000030', '04', '50623042200010244007700100007040000000030115907624', 15907624, '2022-04-23 14:37:09', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 3, NULL, 1, '2022-04-23 22:37:24', '2022-04-23 16:37:14', '2022-04-23 16:37:14'),
(153, '00100007040000000031', '04', '50623042200010244007700100007040000000031149308765', 49308765, '2022-04-23 14:39:27', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios', 1, '2022-04-23 22:39:42', '2022-04-23 16:39:31', '2022-04-23 16:39:31'),
(154, '00100007010000000026', '01', '50624042200010244007700100007010000000026173012485', 73012485, '2022-04-23 18:13:55', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios\n\ncodigo, mensaje, fila, columna\n-16, \"\"El archivo XML, fue enviado a la Dirección General de Tributación de manera extemporánea; con base en lo estipulado en el artículo 9 y 15 ambos de la resolución 48-2016\"\", 0, 0\n', 1, '2022-04-25 02:49:10', '2022-04-23 20:14:00', '2022-04-23 20:17:02'),
(155, '00100007010000000028', '01', '50624042200010244007700100007010000000028198264375', 98264375, '2022-04-24 11:23:10', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '658.99', '0.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '0.00000', '0.00000', '2256.00000', '68.00000', '2188.00000', '284.00000', '2472.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios', 1, '2022-04-25 03:20:59', '2022-04-24 13:23:15', '2022-04-24 13:23:15'),
(156, '00100007040000000038', '04', '50625042200010244007700100007040000000038185067249', 85067249, '2022-04-24 18:41:17', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios\n\ncodigo, mensaje, fila, columna\n-16, \"\"El archivo XML, fue enviado a la Dirección General de Tributación de manera extemporánea; con base en lo estipulado en el artículo 9 y 15 ambos de la resolución 48-2016\"\", 0, 0\n', 1, '2022-04-25 02:41:34', '2022-04-24 20:41:22', '2022-04-24 20:41:22'),
(157, '00100007010000000029', '01', '50625042200010244007700100007010000000029157149302', 57149302, '2022-04-24 18:47:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '658.99', '0.00000', '0.00000', '0.00000', '33840.00000', '0.00000', '0.00000', '33840.00000', '0.00000', '0.00000', '33840.00000', '1015.00000', '32825.00000', '4267.00000', '37092.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios\n\ncodigo, mensaje, fila, columna\n-16, \"\"El archivo XML, fue enviado a la Dirección General de Tributación de manera extemporánea; con base en lo estipulado en el artículo 9 y 15 ambos de la resolución 48-2016\"\", 0, 0\n', 1, '2022-04-25 02:47:35', '2022-04-24 20:47:24', '2022-04-24 20:47:24'),
(158, '00100007030000000033', '03', '50625042200010244007700100007030000000033114856327', 14856327, '2022-04-24 19:10:31', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '658.99', '0.00000', '0.00000', '0.00000', '33840.00000', '0.00000', '0.00000', '33840.00000', '0.00000', '0.00000', '33840.00000', '1015.00000', '32825.00000', '4267.00000', '37092.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios\n\ncodigo, mensaje, fila, columna\n-16, \"\"El archivo XML, fue enviado a la Dirección General de Tributación de manera extemporánea; con base en lo estipulado en el artículo 9 y 15 ambos de la resolución 48-2016\"\", 0, 0\n', 1, '2022-04-25 03:11:02', '2022-04-24 21:10:36', '2022-04-24 21:10:56'),
(159, '00100007040000000039', '04', '50625042200010244007700100007040000000039146297305', 46297305, '2022-04-24 21:33:33', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '47.00000', '1503.00000', '195.00000', '1698.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios\n\ncodigo, mensaje, fila, columna\n-16, \"\"El archivo XML, fue enviado a la Dirección General de Tributación de manera extemporánea; con base en lo estipulado en el artículo 9 y 15 ambos de la resolución 48-2016\"\", 0, 0\n', 1, '2022-04-25 05:35:21', '2022-04-24 23:33:37', '2022-04-24 23:35:13'),
(160, '00100009040000000040', '04', '50625042200010244007700100009040000000040198520461', 98520461, '2022-04-24 21:55:17', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios\n\ncodigo, mensaje, fila, columna\n-16, \"\"El archivo XML, fue enviado a la Dirección General de Tributación de manera extemporánea; con base en lo estipulado en el artículo 9 y 15 ambos de la resolución 48-2016\"\", 0, 0\n', 1, '2022-04-25 05:56:05', '2022-04-24 23:55:22', '2022-04-24 23:55:59'),
(161, '00100009040000000041', '04', '50625042200010244007700100009040000000041148370526', 48370526, '2022-04-24 22:47:06', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios\n\ncodigo, mensaje, fila, columna\n-16, \"\"El archivo XML, fue enviado a la Dirección General de Tributación de manera extemporánea; con base en lo estipulado en el artículo 9 y 15 ambos de la resolución 48-2016\"\", 0, 0\n', 1, '2022-06-07 18:53:29', '2022-04-25 00:47:10', '2022-04-25 00:47:10'),
(162, '00100009040000000042', '04', '50625042200010244007700100009040000000042137184025', 37184025, '2022-04-24 23:56:32', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios\n\ncodigo, mensaje, fila, columna\n-16, \"\"El archivo XML, fue enviado a la Dirección General de Tributación de manera extemporánea; con base en lo estipulado en el artículo 9 y 15 ambos de la resolución 48-2016\"\", 0, 0\n', 1, '2022-04-25 07:56:48', '2022-04-25 01:56:37', '2022-04-25 01:56:37'),
(163, '00100009040000000043', '04', '50625042200010244007700100009040000000043131205794', 31205794, '2022-04-25 11:02:44', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '658.99', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios', 1, '2022-06-10 03:08:52', '2022-04-25 13:02:49', '2022-04-25 13:02:49'),
(164, '00100009040000000083', '04', '50618072200010244007700100009040000000083106914835', 6914835, '2022-07-18 12:19:50', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '675.25', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(165, '00100009040000000084', '04', '50618072200010244007700100009040000000084174520381', 74520381, '2022-07-18 15:55:46', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '675.25', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(166, '00100009040000000085', '04', '50618072200010244007700100009040000000085123895746', 23895746, '2022-07-18 15:57:24', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '675.25', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(167, '00100009040000000086', '04', '50618072200010244007700100009040000000086170295863', 70295863, '2022-07-18 15:58:45', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '675.25', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(168, '00100009040000000088', '04', '50619072200010244007700100009040000000088181073265', 81073265, '2022-07-18 16:17:39', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '0.00', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(169, '00100009040000000089', '04', '50619072200010244007700100009040000000089143958702', 43958702, '2022-07-18 16:20:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '0.00', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(170, '00100009040000000090', '04', '50618072200010244007700100009040000000090165801297', 65801297, '2022-07-18 16:40:44', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '0.00', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(171, '00100009040000000094', '04', '50619072200010244007700100009040000000094158469031', 58469031, '2022-07-19 09:50:38', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(172, '00100009040000000095', '04', '50619072200010244007700100009040000000095160432597', 60432597, '2022-07-19 09:54:31', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '51996.00000', '0.00000', '0.00000', '0.00000', '51996.00000', '0.00000', '51996.00000', '1560.00000', '48876.00000', '6557.00000', '56993.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(173, '00100009040000000096', '04', '50619072200010244007700100009040000000096103971465', 3971465, '2022-07-19 09:56:00', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(174, '00100009040000000097', '04', '50619072200010244007700100009040000000097113957468', 13957468, '2022-07-19 09:56:18', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '43330.00000', '0.00000', '0.00000', '0.00000', '43330.00000', '0.00000', '43330.00000', '2167.00000', '38996.00000', '5351.00000', '46514.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(175, '00100009040000000099', '04', '50619072200010244007700100009040000000099171409863', 71409863, '2022-07-19 22:06:04', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(176, '00100009040000000101', '04', '50619072200010244007700100009040000000101109265741', 9265741, '2022-07-19 22:13:10', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4336.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4336.00000', '198.00000', '4005.00000', '830.00000', '7221.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(177, '00100009040000000112', '04', '50619072200010244007700100009040000000112107618594', 7618594, '2022-07-19 22:27:33', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '43333.00000', '0.00000', '0.00000', '0.00000', '43330.00000', '0.00000', '43333.00000', '1300.00000', '40732.00000', '5464.00000', '84586.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(178, '00100009040000000114', '04', '50619072200010244007700100009040000000114178204691', 78204691, '2022-07-19 22:29:29', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4336.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4336.00000', '0.00000', '4336.00000', '563.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(179, '00100009040000000115', '04', '50619072200010244007700100009040000000115161032794', 61032794, '2022-07-19 22:35:23', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4336.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4336.00000', '0.00000', '4336.00000', '563.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(180, '00100009040000000116', '04', '50619072200010244007700100009040000000116120749136', 20749136, '2022-07-19 22:38:47', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(181, '00100009040000000117', '04', '50619072200010244007700100009040000000117141920635', 41920635, '2022-07-19 22:39:10', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4336.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4336.00000', '0.00000', '4336.00000', '563.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(182, '00100009040000000118', '04', '50619072200010244007700100009040000000118173815620', 73815620, '2022-07-19 22:40:49', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4336.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4336.00000', '0.00000', '4336.00000', '563.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(183, '00100009040000000119', '04', '50619072200010244007700100009040000000119116358290', 16358290, '2022-07-19 22:42:26', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4336.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4336.00000', '0.00000', '4336.00000', '856.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(184, '00100009040000000120', '04', '50619072200010244007700100009040000000120193268075', 93268075, '2022-07-19 22:42:53', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4336.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4336.00000', '0.00000', '4336.00000', '856.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(185, '00100009040000000132', '04', '50619072200010244007700100009040000000132139108457', 39108457, '2022-07-19 23:13:57', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '0.00000', '4333.00000', '563.00000', '4896.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(186, '00100009040000000133', '04', '50619072200010244007700100009040000000133105913846', 5913846, '2022-07-19 23:14:55', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '674.39', '0.00000', '0.00000', '0.00000', '57224.00000', '0.00000', '0.00000', '0.00000', '34664.00000', '0.00000', '57224.00000', '1717.00000', '55507.00000', '7216.00000', '62723.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(187, '00100009040000000134', '04', '50620072200010244007700100009040000000134196351427', 96351427, '2022-07-20 18:33:51', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '672.55', '0.00000', '0.00000', '0.00000', '57224.00000', '0.00000', '0.00000', '0.00000', '34664.00000', '0.00000', '57224.00000', '1717.00000', '55507.00000', '7216.00000', '62723.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(188, '00100009040000000135', '04', '50620072200010244007700100009040000000135173685214', 73685214, '2022-07-20 18:34:31', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '672.55', '0.00000', '0.00000', '0.00000', '6589.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '6589.00000', '0.00000', '6589.00000', '856.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(189, '00100009040000000136', '04', '50620072200010244007700100009040000000136172613849', 72613849, '2022-07-20 18:35:49', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '672.55', '0.00000', '0.00000', '0.00000', '6589.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '6589.00000', '0.00000', '6589.00000', '856.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(190, '00100009040000000137', '04', '50620072200010244007700100009040000000137170189543', 70189543, '2022-07-20 18:36:30', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '672.55', '0.00000', '0.00000', '0.00000', '6589.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '6589.00000', '0.00000', '6589.00000', '856.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(191, '00100009040000000138', '04', '50620072200010244007700100009040000000138136190872', 36190872, '2022-07-20 18:36:38', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '672.55', '0.00000', '0.00000', '0.00000', '6589.00000', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '6589.00000', '0.00000', '6589.00000', '856.00000', '7445.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(192, '00100009010000000040', '01', '50616092200010244007700100009010000000040170138956', 70138956, '2022-09-16 14:23:21', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(193, '00100009010000000041', '01', '50616092200010244007700100009010000000041113720489', 13720489, '2022-09-16 14:24:22', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(194, '00100009010000000042', '01', '50616092200010244007700100009010000000042136780942', 36780942, '2022-09-16 14:24:55', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(195, '00100009010000000043', '01', '50616092200010244007700100009010000000043139847150', 39847150, '2022-09-16 14:34:30', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(196, '00100009010000000044', '01', '50616092200010244007700100009010000000044152689704', 52689704, '2022-09-16 14:38:41', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(197, '00100009010000000045', '01', '50616092200010244007700100009010000000045179058136', 79058136, '2022-09-16 14:39:04', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(198, '00100009010000000046', '01', '50616092200010244007700100009010000000046146370921', 46370921, '2022-09-16 14:40:14', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(199, '00100009010000000047', '01', '50616092200010244007700100009010000000047114697308', 14697308, '2022-09-16 14:42:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(200, '00100009010000000048', '01', '50616092200010244007700100009010000000048121740653', 21740653, '2022-09-16 14:44:55', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(201, '00100009010000000049', '01', '50616092200010244007700100009010000000049145197208', 45197208, '2022-09-16 14:45:21', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(202, '00100009010000000050', '01', '50616092200010244007700100009010000000050104139286', 4139286, '2022-09-16 14:54:11', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(203, '00100009010000000051', '01', '50616092200010244007700100009010000000051156187324', 56187324, '2022-09-16 15:04:52', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(204, '00100009010000000052', '01', '50616092200010244007700100009010000000052132715089', 32715089, '2022-09-16 15:11:23', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(205, '00100009010000000053', '01', '50616092200010244007700100009010000000053159620483', 59620483, '2022-09-16 18:45:48', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(206, '00100009010000000054', '01', '50616092200010244007700100009010000000054141859367', 41859367, '2022-09-16 18:58:39', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 0, NULL, 0, NULL, '2022-09-16 12:58:42', NULL),
(207, '00100009010000000055', '01', '50616092200010244007700100009010000000055154671289', 54671289, '2022-09-16 19:23:47', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-09-16 19:24:01', '2022-09-16 13:23:51', NULL),
(208, '00100009010000000056', '01', '50616092200010244007700100009010000000056192103865', 92103865, '2022-09-16 19:26:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-1, \"\"cvc-datatype-valid.1.2.1: \'2020-03-30\' is not a valid value for \'dateTime\'.\"\", 71, 84\n\n]', 1, '2022-09-16 19:26:42', '2022-09-16 13:26:32', '2022-09-16 13:26:32'),
(209, '00100009010000000058', '01', '50616092200010244007700100009010000000058138705192', 38705192, '2022-09-16 19:32:37', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-09-16 19:32:52', '2022-09-16 13:32:42', NULL),
(210, '00100009040000000146', '04', '50616092200010244007700100009040000000146140623587', 40623587, '2022-09-16 19:41:12', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-09-16 19:41:29', '2022-09-16 13:41:19', NULL),
(211, '00100009040000000147', '04', '50616092200010244007700100009040000000147146309152', 46309152, '2022-09-16 19:45:01', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-09-16 19:45:16', '2022-09-16 13:45:06', NULL),
(212, '00100009010000000059', '01', '50616092200010244007700100009010000000059181402576', 81402576, '2022-09-16 19:57:14', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '5005.00000', '38500.00000', '', 1, 1, 1, 1, 1, 0, NULL, 1, '2022-09-16 19:57:30', '2022-09-16 13:57:19', NULL);
INSERT INTO `documentos` (`id_documento`, `consecutivo`, `tipo_documento`, `clave`, `codigo_seguridad`, `fecha`, `emisor_cedula`, `emisor_nombre`, `emisor_tipo`, `emisor_comercial`, `emisor_id_provincia`, `emisor_id_canton`, `emisor_id_distrito`, `emisor_id_barrio`, `emisor_otras_senas`, `emisor_cod`, `emisor_telefono`, `emisor_correo`, `receptor_nombre`, `receptor_cedula`, `receptor_tipo`, `receptor_comercial`, `receptor_id_provincia`, `receptor_id_canton`, `receptor_id_distrito`, `receptor_id_barrio`, `receptor_otras_senas`, `receptor_cod`, `receptor_telefono`, `receptor_correo`, `condicion_venta`, `plazo_credito`, `medio_pago`, `moneda`, `tipo_cambio`, `servicios_gravados`, `servicios_exentos`, `servicios_exonerados`, `mercancias_gravadas`, `mercancias_exentas`, `mercancias_exoneradas`, `total_gravado`, `total_exento`, `total_exonerado`, `total_venta`, `total_descuentos`, `total_venta_neta`, `total_impuestos`, `total_comprobante`, `notas`, `id_usuario`, `id_empresa`, `id_caja`, `id_sucursal`, `envio_atv`, `valido_atv`, `detalle_atv`, `correo_enviado`, `fecha_correo`, `fecha_envio`, `fecha_valido`) VALUES
(213, '00100009010000000060', '01', '50616092200010244007700100009010000000060104761598', 4761598, '2022-09-16 20:06:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '5005.00000', '38500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-54, \"\"El monto total de impuestos no coincide con la suma de los campos denominados \'Monto del Impuesto\'\"\", 0, 0\n-55, \"\"El monto total del comprobante no coincide con la suma del total de venta neta, total de impuestos, total de otros cargos menos el total de iva devuelto (43505)\"\", 0, 0\n\n]', 1, '2022-09-16 20:06:34', '2022-09-16 14:06:23', '2022-09-16 14:06:23'),
(214, '00100009010000000061', '01', '50616092200010244007700100009010000000061172053496', 72053496, '2022-09-16 20:08:37', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '5005.00000', '38500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-54, \"\"El monto total de impuestos no coincide con la suma de los campos denominados \'Monto del Impuesto\'\"\", 0, 0\n-55, \"\"El monto total del comprobante no coincide con la suma del total de venta neta, total de impuestos, total de otros cargos menos el total de iva devuelto (43505)\"\", 0, 0\n\n]', 1, '2022-09-16 20:08:52', '2022-09-16 14:08:41', '2022-09-16 14:08:41'),
(215, '00100009010000000062', '01', '50616092200010244007700100009010000000062108296315', 8296315, '2022-09-16 20:11:48', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '629.34', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-16 20:12:02', '2022-09-16 14:11:52', '2022-09-16 14:11:52'),
(216, '00100009010000000063', '01', '50618092200010244007700100009010000000063123146587', 23146587, '2022-09-18 06:30:26', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '627.34', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-18 06:30:41', '2022-09-18 00:30:30', '2022-09-18 00:30:30'),
(217, '00100009010000000068', '01', '50618092200010244007700100009010000000068137580619', 37580619, '2022-09-18 10:49:20', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '627.34', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-111, \"\"El monto total de servicios gravados no coincide con la suma los servicios que estan gravados (1550).\"\", 0, 0\n-111, \"\"El monto total de mercancias gravadas no coincide con la suma los mercancias que estan gravadas (0).\"\", 0, 0\n\n]', 1, '2022-09-18 10:49:35', '2022-09-18 04:49:24', '2022-09-18 04:49:24'),
(218, '00100009010000000069', '01', '50618092200010244007700100009010000000069176412958', 76412958, '2022-09-18 10:57:23', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '627.34', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-18 10:57:37', '2022-09-18 04:57:27', '2022-09-18 04:57:27'),
(219, '00100009010000000070', '01', '50618092200010244007700100009010000000070136289015', 36289015, '2022-09-18 11:16:28', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '627.34', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-18 11:16:41', '2022-09-18 05:16:31', '2022-09-18 05:16:31'),
(220, '00100009030000000034', '03', '50618092200010244007700100009030000000034164230157', 64230157, '2022-09-18 11:21:50', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '627.34', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-18 11:22:03', '2022-09-18 05:21:54', '2022-09-18 05:21:54'),
(221, '00100009010000000072', '01', '50618092200010244007700100009010000000072173465092', 73465092, '2022-09-18 15:46:06', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '627.34', '1550.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '5883.00000', '0.00000', '0.00000', '5883.00000', '0.00000', '5883.00000', '765.00000', '6648.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-18 15:46:21', '2022-09-18 09:46:10', '2022-09-18 09:46:10'),
(222, '00100009040000000149', '04', '50618092200010244007700100009040000000149127951384', 27951384, '2022-09-18 20:29:53', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '627.34', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '4333.00000', '217.00000', '4116.00000', '535.00000', '4651.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-18 20:30:17', '2022-09-18 14:29:58', '2022-09-18 14:29:58'),
(223, '00100009040000000150', '04', '50618092200010244007700100009040000000150150679128', 50679128, '2022-09-18 20:36:59', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '627.34', '0.00000', '0.00000', '0.00000', '32945.00000', '0.00000', '0.00000', '32945.00000', '0.00000', '0.00000', '32945.00000', '0.00000', '32945.00000', '4282.00000', '37227.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-18 20:37:13', '2022-09-18 14:37:03', '2022-09-18 14:37:03'),
(224, '00100009040000000151', '04', '50619092200010244007700100009040000000151173041265', 73041265, '2022-09-19 12:05:01', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '627.34', '0.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '4333.00000', '0.00000', '0.00000', '4333.00000', '130.00000', '4203.00000', '546.00000', '4749.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-19 12:05:20', '2022-09-19 06:05:05', '2022-09-19 06:05:05'),
(225, '00100009040000000152', '04', '50620092200010244007700100009040000000152190618273', 90618273, '2022-09-20 08:44:06', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '627.34', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-20 08:44:22', '2022-09-20 02:44:10', '2022-09-20 02:44:10'),
(226, '00100009040000000153', '04', '50620092200010244007700100009040000000153110384976', 10384976, '2022-09-20 08:47:58', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '627.34', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-20 08:48:13', '2022-09-20 02:48:02', '2022-09-20 02:48:02'),
(227, '00100009040000000154', '04', '50620092200010244007700100009040000000154163852190', 63852190, '2022-09-20 16:34:59', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '627.34', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL),
(228, '00100009010000000073', '01', '50623092200010244007700100009010000000073174659028', 74659028, '2022-09-23 17:33:11', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '631.55', '0.00000', '0.00000', '0.00000', '5500.00000', '0.00000', '0.00000', '5500.00000', '0.00000', '0.00000', '5500.00000', '0.00000', '5500.00000', '715.00000', '6215.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-23 17:33:27', '2022-09-23 11:33:15', '2022-09-23 11:33:15'),
(229, '00100009010000000074', '01', '50623092200010244007700100009010000000074194805312', 94805312, '2022-09-23 18:46:16', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '631.55', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '5500.00000', '0.00000', '0.00000', '5500.00000', '5500.00000', '0.00000', '5500.00000', '0.00000', '5500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-1, \"\"cvc-datatype-valid.1.2.1: \'\' is not a valid value for \'integer\'.\"\", 72, 69\n\n]', 1, '2022-09-23 18:46:32', '2022-09-23 12:46:21', '2022-09-23 12:46:21'),
(230, '00100009010000000075', '01', '50623092200010244007700100009010000000075198425167', 98425167, '2022-09-23 18:49:49', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '631.55', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-1, \"\"cvc-datatype-valid.1.2.1: \'\' is not a valid value for \'integer\'.\"\", 72, 69\n\n]', 1, '2022-09-23 18:50:02', '2022-09-23 12:49:53', '2022-09-23 12:49:53'),
(231, '00100009010000000076', '01', '50623092200010244007700100009010000000076106197854', 6197854, '2022-09-23 19:00:53', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '631.55', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-1, \"\"cvc-datatype-valid.1.2.1: \'\' is not a valid value for \'integer\'.\"\", 72, 69\n\n]', 1, '2022-09-23 19:01:08', '2022-09-23 13:00:58', '2022-09-23 13:00:58'),
(232, '00100009010000000078', '01', '50623092200010244007700100009010000000078192647183', 92647183, '2022-09-23 19:03:20', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '631.55', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-1, \"\"cvc-datatype-valid.1.2.1: \'\' is not a valid value for \'integer\'.\"\", 72, 69\n\n]', 1, '2022-09-23 19:03:34', '2022-09-23 13:03:24', '2022-09-23 13:03:24'),
(233, '00100009010000000079', '01', '50623092200010244007700100009010000000079101893765', 1893765, '2022-09-23 19:07:37', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '631.55', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '5500.00000', '0.00000', '0.00000', '5500.00000', '5500.00000', '0.00000', '5500.00000', '0.00000', '5500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-1, \"\"cvc-datatype-valid.1.2.1: \'\' is not a valid value for \'integer\'.\"\", 72, 69\n\n]', 1, '2022-09-23 19:07:52', '2022-09-23 13:07:42', '2022-09-23 13:07:42'),
(234, '00100009010000000080', '01', '50623092200010244007700100009010000000080169327158', 69327158, '2022-09-23 19:11:50', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '631.55', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 3, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.\n\nEl comprobante electrónico tiene los siguientes errores: \n[\ncodigo, mensaje, fila, columna\n-1, \"\"cvc-datatype-valid.1.2.1: \'\' is not a valid value for \'integer\'.\"\", 72, 69\n\n]', 1, '2022-09-23 19:12:04', '2022-09-23 13:11:54', '2022-09-23 13:11:54'),
(235, '00100009010000000083', '01', '50623092200010244007700100009010000000083163974052', 63974052, '2022-09-23 19:31:50', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '631.55', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-23 19:32:05', '2022-09-23 13:31:54', '2022-09-23 13:31:54'),
(236, '00100009010000000084', '01', '50624092200010244007700100009010000000084114375986', 14375986, '2022-09-24 06:30:06', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Zona Franca Puntarenas S.A.', '3101112585', '02', 'Zona Franca Puntarenas S.A.', '6', '1', '8', '1', 'Parque Industrial Zona Franca Puntarenas, Santa Rosa de Barranca', 506, 26632412, 'smoraga@zonafrancapuntarenas.com', '01', '0', '04', 'CRC', '634.43', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '38500.00000', '0.00000', '0.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000', '0.00000', '38500.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-24 06:30:21', '2022-09-24 00:30:10', '2022-09-24 00:30:10'),
(237, '00100009010000000086', '01', '50625092200010244007700100009010000000086160534712', 60534712, '2022-09-25 14:27:10', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', 'Walmart', '3102007223', '02', 'Walmart', '2', '1', '2', '19', 'De RITEVE El Coyol, 600m oeste.', 506, 99999925, 'walmart.cr@einvoicing.signature-cloud.com', '01', '0', '04', 'CRC', '634.43', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-09-25 14:27:24', '2022-09-25 08:27:14', '2022-09-25 08:27:14'),
(238, '00100010040000000156', '04', '50629092200010244007700100010040000000156156034872', 56034872, '2022-09-29 21:32:30', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '628.19', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-10-02 13:33:21', '2022-10-02 07:33:12', '2022-10-02 07:33:12'),
(239, '00100010040000000157', '04', '50613102200010244007700100010040000000157153128409', 53128409, '2022-10-13 12:06:19', '102440077', 'CORELLA ARTAVIA VILMA', '01', 'Modas Laura', '1', '1', '6', '14', 'Barrio El Cocal', 506, 89890512, 'vilmacorella@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01', '0', '04', 'CRC', '622.37', '1550.00000', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '0.00000', '1550.00000', '0.00000', '1550.00000', '202.00000', '1752.00000', '', 1, 1, 1, 1, 1, 1, 'Este comprobante fue aceptado en el ambiente de pruebas, por lo cual no tiene validez para fines tributarios.', 1, '2022-10-13 12:06:37', '2022-10-13 06:06:24', '2022-10-13 06:06:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_descuentos`
--

CREATE TABLE IF NOT EXISTS `documentos_descuentos` (
  `id_descuento` int(11) NOT NULL AUTO_INCREMENT,
  `id_detalle` int(11) NOT NULL,
  `monto` double(12,2) NOT NULL,
  `motivo` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_descuento`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `documentos_descuentos`
--

INSERT INTO `documentos_descuentos` (`id_descuento`, `id_detalle`, `monto`, `motivo`) VALUES
(1, 1, 2165.76, 'Centralización'),
(2, 2, 1559.88, 'Centralización'),
(3, 3, 2165.76, 'Centralización'),
(4, 4, 1559.88, 'Centralización'),
(5, 5, 2165.76, 'Centralización'),
(6, 6, 1559.88, 'Centralización'),
(7, 7, 2165.76, 'Centralización'),
(8, 8, 1559.88, 'Centralización'),
(9, 9, 2165.76, 'Centralización'),
(10, 10, 1559.88, 'Centralización'),
(11, 11, 2165.76, 'Centralización'),
(12, 12, 1559.88, 'Centralización'),
(13, 13, 2165.76, 'Centralización'),
(14, 14, 1559.88, 'Centralización'),
(15, 15, 2165.76, 'Centralización'),
(16, 16, 1559.88, 'Centralización'),
(17, 17, 2165.76, 'Centralización'),
(18, 18, 1559.88, 'Centralización'),
(19, 19, 2165.76, 'Centralización'),
(20, 20, 1559.88, 'Centralización'),
(21, 21, 2165.76, 'Centralización'),
(22, 22, 1559.88, 'Centralización'),
(23, 23, 2165.76, 'Centralización'),
(24, 24, 1559.88, 'Centralización'),
(25, 25, 2165.76, 'Centralización'),
(26, 26, 1559.88, 'Centralización'),
(27, 27, 2165.76, 'Centralización'),
(28, 28, 1559.88, 'Centralización'),
(29, 29, 2165.76, 'Centralización'),
(30, 30, 1559.88, 'Centralización'),
(31, 31, 2165.76, 'Centralización'),
(32, 32, 1559.88, 'Centralización'),
(33, 33, 1559.88, 'Centralización'),
(34, 34, 2165.76, 'Centralización'),
(35, 35, 812.16, 'Centralización'),
(36, 36, 4159.68, 'Centralización'),
(37, 37, 947.52, 'Centralización'),
(38, 38, 2079.84, 'Centralización'),
(39, 39, 1015.20, 'Centralización'),
(40, 40, 1819.86, 'Centralización'),
(41, 41, 1015.20, 'Centralización'),
(42, 42, 1819.86, 'Centralización'),
(43, 43, 1015.20, 'Centralización'),
(44, 44, 1819.86, 'Centralización'),
(45, 45, 1015.20, 'Centralización'),
(46, 46, 1819.86, 'Centralización'),
(47, 47, 1015.20, 'Centralización'),
(48, 48, 1819.86, 'Centralización'),
(49, 49, 22.50, 'Centralización'),
(50, 50, 1556.64, 'Descuento de sistema'),
(51, 51, 253.77, 'Centralización'),
(52, 52, 0.00, 'Descuento de sistema'),
(53, 53, 676.80, 'Centralización'),
(54, 54, 0.00, ''),
(55, 55, 812.16, 'Centralización'),
(56, 56, 203.04, 'Centralización'),
(57, 57, 203.04, 'Centralización'),
(58, 58, 203.04, 'Centralización'),
(59, 59, 203.04, 'Centralización'),
(60, 60, 203.04, 'Centralización'),
(61, 61, 203.04, 'Centralización'),
(62, 62, 203.04, 'Centralización'),
(63, 63, 203.04, 'Centralización'),
(64, 64, 203.04, 'Centralización'),
(65, 65, 0.00, ''),
(66, 66, 0.00, ''),
(67, 67, 0.00, ''),
(68, 68, 0.00, ''),
(69, 69, 0.00, ''),
(70, 70, 0.00, ''),
(71, 71, 0.00, ''),
(72, 72, 0.00, ''),
(73, 73, 0.00, ''),
(74, 74, 0.00, ''),
(75, 75, 0.00, ''),
(76, 76, 0.00, ''),
(77, 77, 0.00, ''),
(78, 78, 0.00, ''),
(79, 79, 0.00, ''),
(80, 80, 0.00, ''),
(81, 81, 0.00, ''),
(82, 82, 0.00, ''),
(83, 83, 0.00, ''),
(84, 84, 0.00, ''),
(85, 85, 0.00, ''),
(86, 86, 0.00, ''),
(87, 87, 0.00, ''),
(88, 88, 0.00, ''),
(89, 89, 0.00, ''),
(90, 90, 0.00, ''),
(91, 91, 0.00, ''),
(92, 92, 0.00, ''),
(93, 93, 0.00, ''),
(94, 94, 0.00, ''),
(95, 95, 0.00, ''),
(96, 96, 0.00, ''),
(97, 97, 0.00, ''),
(98, 98, 0.00, ''),
(99, 99, 0.00, ''),
(100, 100, 0.00, ''),
(101, 101, 0.00, ''),
(102, 102, 0.00, ''),
(103, 103, 0.00, ''),
(104, 104, 0.00, ''),
(105, 105, 0.00, ''),
(106, 106, 129.99, ''),
(107, 107, 67.68, 'Descuento de sistema'),
(108, 108, 0.00, 'Descuento de sistema'),
(109, 109, 0.00, 'Descuento de sistema'),
(110, 110, 0.00, 'Descuento de sistema'),
(111, 111, 0.00, 'Descuento de sistema'),
(112, 112, 0.00, 'Descuento de sistema'),
(113, 113, 67.68, 'Descuento de sistema'),
(114, 114, 0.00, 'Descuento de sistema'),
(115, 115, 0.00, 'Descuento de sistema'),
(116, 116, 0.00, 'Descuento de sistema'),
(117, 117, 0.00, 'Descuento de sistema'),
(118, 118, 676.80, 'Descuento de sistema'),
(119, 119, 1559.88, 'Descuento de sistema'),
(120, 120, 0.00, 'Descuento de sistema'),
(121, 121, 0.00, 'Descuento de sistema'),
(122, 122, 0.00, 'Descuento de sistema'),
(123, 123, 0.00, 'Descuento de sistema'),
(124, 124, 0.00, 'Descuento de sistema'),
(125, 125, 0.00, 'Descuento de sistema'),
(126, 126, 0.00, 'Descuento de sistema'),
(127, 127, 0.00, 'Descuento de sistema'),
(128, 128, 13128.99, 'Descuento de sistema'),
(129, 129, 1353.60, 'Descuento de sistema'),
(130, 130, 845.90, 'Descuento de sistema'),
(131, 131, 338.40, 'Descuento de sistema'),
(132, 132, 677.10, 'Descuento de sistema'),
(133, 133, 0.00, 'Descuento de sistema'),
(134, 134, 0.00, 'Descuento de sistema'),
(135, 135, 0.00, 'Descuento de sistema'),
(136, 136, 0.00, 'Descuento de sistema'),
(137, 137, 67.68, 'Descuento de sistema'),
(138, 138, 67.68, 'Descuento de sistema'),
(139, 139, 0.00, 'Descuento de sistema'),
(140, 140, 0.00, 'Descuento de sistema'),
(141, 141, 0.00, 'Descuento de sistema'),
(142, 142, 0.00, 'Descuento de sistema'),
(143, 143, 0.00, 'Descuento de sistema'),
(144, 144, 0.00, 'Descuento de sistema'),
(145, 145, 0.00, 'Descuento de sistema'),
(146, 146, 0.00, 'Descuento de sistema'),
(147, 147, 0.00, 'Descuento de sistema'),
(148, 148, 0.00, 'Descuento de sistema'),
(149, 149, 0.00, 'Descuento de sistema'),
(150, 150, 0.00, 'Descuento de sistema'),
(151, 151, 0.00, 'Descuento de sistema'),
(152, 152, 0.00, 'Descuento de sistema'),
(153, 153, 0.00, 'Descuento de sistema'),
(154, 154, 0.00, 'Descuento de sistema'),
(155, 155, 0.00, 'Descuento de sistema'),
(156, 156, 0.00, 'Descuento de sistema'),
(157, 157, 0.00, 'Descuento de sistema'),
(158, 158, 0.00, 'Descuento de sistema'),
(159, 159, 0.00, 'Descuento de sistema'),
(160, 160, 0.00, 'Descuento de sistema'),
(161, 161, 0.00, 'Descuento de sistema'),
(162, 162, 0.00, 'Descuento de sistema'),
(163, 163, 0.00, 'Descuento de sistema'),
(164, 164, 0.00, 'Descuento de sistema'),
(165, 165, 0.00, 'Descuento de sistema'),
(166, 166, 0.00, 'Descuento de sistema'),
(167, 167, 0.00, 'Descuento de sistema'),
(168, 168, 0.00, 'Descuento de sistema'),
(169, 169, 0.00, 'Descuento de sistema'),
(170, 170, 0.00, 'Descuento de sistema'),
(171, 171, 0.00, 'Descuento de sistema'),
(172, 172, 0.00, 'Descuento de sistema'),
(173, 173, 0.00, 'Descuento de sistema'),
(174, 174, 0.00, 'Descuento de sistema'),
(175, 175, 0.00, 'Descuento de sistema'),
(176, 176, 0.00, 'Descuento de sistema'),
(177, 177, 0.00, 'Descuento de sistema'),
(178, 178, 0.00, 'Descuento de sistema'),
(179, 179, 0.00, 'Descuento de sistema'),
(180, 180, 147.34, 'Descuento de sistema'),
(181, 181, 147.34, 'Descuento de sistema'),
(182, 182, 225.70, 'Descuento de sistema'),
(183, 183, 1015.20, 'Descuento de sistema'),
(184, 184, 147.34, 'Descuento de sistema'),
(185, 185, 0.00, 'Descuento de sistema'),
(186, 186, 0.00, 'Descuento de sistema'),
(187, 187, 148.00, 'Descuento de sistema'),
(188, 188, 0.00, 'Descuento de sistema'),
(189, 189, 147.00, 'Descuento de sistema'),
(190, 190, 0.00, 'Descuento de sistema'),
(191, 191, 0.00, 'Descuento de sistema'),
(192, 192, 0.00, 'Descuento de sistema'),
(193, 193, 0.00, 'Descuento de sistema'),
(194, 194, 0.00, 'Descuento de sistema'),
(195, 195, 1560.00, 'Descuento de sistema'),
(196, 196, 3790.00, 'Descuento de sistema'),
(197, 197, 40.00, 'Descuento de sistema'),
(198, 198, 3790.00, 'Descuento de sistema'),
(199, 199, 1560.00, 'Descuento de sistema'),
(200, 200, 0.00, 'Descuento de sistema'),
(201, 201, 0.00, 'Descuento de sistema'),
(202, 202, 0.00, 'Descuento de sistema'),
(203, 203, 0.00, 'Descuento de sistema'),
(204, 204, 68.00, 'Descuento de sistema'),
(205, 205, 0.00, 'Descuento de sistema'),
(206, 206, 1015.00, 'Descuento de sistema'),
(207, 207, 1015.00, 'Descuento de sistema'),
(208, 208, 47.00, 'Descuento de sistema'),
(209, 209, 0.00, 'Descuento de sistema'),
(210, 210, 0.00, 'Descuento de sistema'),
(211, 211, 0.00, 'Descuento de sistema'),
(212, 212, 0.00, 'Descuento de sistema'),
(213, 219, 2167.00, 'Descuento de sistema'),
(214, 221, 130.00, 'Centralizacion'),
(215, 231, 1040.00, 'Descuento de sistema'),
(216, 232, 1040.00, 'Descuento de sistema'),
(217, 271, 130.00, 'Centralización');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_detalles`
--

CREATE TABLE IF NOT EXISTS `documentos_detalles` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_documento` int(11) NOT NULL,
  `linea` int(3) NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `codigo_venta` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL DEFAULT '0',
  `cantidad` decimal(16,3) NOT NULL,
  `unidad_medida` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `detalle` varchar(160) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `precio_unidad` decimal(18,5) NOT NULL,
  `monto_total` decimal(18,5) NOT NULL,
  `sub_total` decimal(18,5) NOT NULL,
  `impuesto_neto` decimal(18,5) DEFAULT NULL,
  `total_linea` decimal(18,5) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_documento` (`id_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `documentos_detalles`
--

INSERT INTO `documentos_detalles` (`id_detalle`, `id_documento`, `linea`, `codigo`, `codigo_venta`, `cantidad`, `unidad_medida`, `detalle`, `precio_unidad`, `monto_total`, `sub_total`, `impuesto_neto`, `total_linea`) VALUES
(1, 1, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(2, 1, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(3, 2, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(4, 2, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(5, 3, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(6, 3, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(7, 4, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(8, 4, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(9, 5, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(10, 5, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(11, 6, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(12, 6, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(13, 7, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(14, 7, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(15, 8, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(16, 8, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(17, 9, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(18, 9, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(19, 10, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(20, 10, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(21, 11, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(22, 11, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(23, 12, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(24, 12, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(25, 13, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(26, 13, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(27, 14, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(28, 14, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(29, 15, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(30, 15, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(31, 16, 1, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(32, 16, 2, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(33, 17, 1, '2718000000100', '0', '12.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(34, 17, 2, '2718000000100', '0', '32.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '72192.00000', '70026.24000', '9103.41000', '79129.65000'),
(35, 18, 1, '2718000000100', '0', '12.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '27072.00000', '26259.84000', '3413.78000', '29673.62000'),
(36, 18, 2, '2718000000100', '0', '32.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '138656.00000', '134496.32000', '17484.52000', '151980.84000'),
(37, 19, 1, '2718000000100', '0', '14.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '31584.00000', '30636.48000', '3982.74000', '34619.22000'),
(38, 19, 2, '2718000000100', '0', '16.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '69328.00000', '67248.16000', '8742.26000', '75990.42000'),
(39, 20, 1, '2718000000100', '0', '15.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '33840.00000', '32824.80000', '4267.22000', '37092.02000'),
(40, 20, 2, '2718000000100', '0', '14.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '60662.00000', '58842.14000', '7649.48000', '66491.62000'),
(41, 21, 1, '2718000000100', '0', '15.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '33840.00000', '32824.80000', '4267.22000', '37092.02000'),
(42, 21, 2, '2718000000100', '0', '14.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '60662.00000', '58842.14000', '7649.48000', '66491.62000'),
(43, 22, 1, '2718000000100', '0', '15.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '33840.00000', '32824.80000', '4267.22000', '37092.02000'),
(44, 22, 2, '2718000000100', '0', '14.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '60662.00000', '58842.14000', '7649.48000', '66491.62000'),
(45, 23, 1, '2718000000100', '0', '15.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '33840.00000', '32824.80000', '4267.22000', '37092.02000'),
(46, 23, 2, '2718000000100', '0', '14.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '60662.00000', '58842.14000', '7649.48000', '66491.62000'),
(47, 24, 1, '2718000000100', '0', '15.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '33840.00000', '32824.80000', '4267.22000', '37092.02000'),
(48, 24, 2, '2718000000100', '0', '14.000', '', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '60662.00000', '58842.14000', '7649.48000', '66491.62000'),
(49, 25, 1, '2718000000100', '0', '1.000', '', 'Almohada #2', '450.00000', '450.00000', '427.50000', '55.58000', '483.07000'),
(50, 25, 2, '2718000000100', '0', '23.000', '', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '51888.00000', '50331.36000', '6543.08000', '56874.44000'),
(51, 26, 1, '2718000000100', '0', '1.000', 'Unid ', 'ALMOH INF LAURA S-COL 60X40CM :: 6', '8459.00000', '8459.00000', '8205.23000', '1066.68000', '9271.91000'),
(52, 27, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOH INF LAURA S-COL 60X40CM :: 6', '8459.00000', '8459.00000', '8459.00000', '1099.67000', '9558.67000'),
(53, 28, 1, '2718000000100', '0', '10.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '22560.00000', '21883.20000', '2844.82000', '24728.02000'),
(54, 29, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '563.29000', '4896.29000'),
(55, 30, 1, '2718000000100', '0', '12.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '27072.00000', '26259.84000', '3413.78000', '29673.62000'),
(56, 31, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(57, 32, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(58, 33, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(59, 34, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(60, 35, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(61, 36, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(62, 37, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(63, 38, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(64, 39, 1, '2718000000100', '0', '3.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '6768.00000', '6564.96000', '853.44000', '7418.40000'),
(65, 40, 1, '2718000000100', '0', '12.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '27072.00000', '27072.00000', '3519.36000', '30591.36000'),
(66, 41, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(67, 42, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(68, 43, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(69, 43, 2, '', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(70, 44, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(71, 44, 2, '', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(72, 45, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(73, 45, 2, '', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(74, 46, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(75, 46, 2, '', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(76, 47, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(77, 47, 2, '', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(78, 48, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(79, 48, 2, '', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(80, 49, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(81, 49, 2, '', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(82, 50, 1, '1', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(83, 50, 2, '1', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(84, 51, 1, '1', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(85, 51, 2, '1', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(86, 52, 1, '1', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(87, 52, 2, '1', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(88, 53, 1, '1', '0', '2.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '5098.00000', '5098.00000', '662.74000', '5760.74000'),
(89, 53, 2, '1', '0', '2.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4896.29000', '9792.58000', '9792.58000', '1273.04000', '11065.62000'),
(90, 53, 3, '1', '0', '0.000', '', '', '0.00000', '0.00000', '0.00000', '0.00000', '0.00000'),
(91, 54, 1, '2718000000100', '0', '2.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '5098.00000', '5098.00000', '662.74000', '5760.74000'),
(92, 54, 2, '2718000000100', '0', '2.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4896.29000', '9792.58000', '9792.58000', '1273.04000', '11065.62000'),
(93, 55, 1, '2718000000100', '0', '2.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '5098.00000', '5098.00000', '662.74000', '5760.74000'),
(94, 56, 1, '2718000000100', '0', '2.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '5098.00000', '5098.00000', '662.74000', '5760.74000'),
(95, 57, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(96, 58, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(97, 59, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(98, 60, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(99, 61, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4896.29000', '4896.29000', '4896.29000', '636.52000', '5532.81000'),
(100, 62, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2549.00000', '2549.00000', '331.37000', '2880.37000'),
(101, 63, 1, '2718000000100', '0', '12.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4896.29000', '58755.48000', '58755.48000', '7638.21000', '66393.69000'),
(102, 63, 2, '2718000000100', '0', '16.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '40784.00000', '40784.00000', '5301.92000', '46085.92000'),
(103, 64, 1, '2714001010100', '0', '1.000', 'Unid', 'FUNDA BEBE CUADRADA BLANCA DOCOMA :: 3', '3124.45000', '2765.00000', '2765.00000', '359.45000', '3124.45000'),
(104, 64, 2, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4896.29000', '4333.00000', '4333.00000', '563.29000', '4896.29000'),
(105, 64, 3, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2549.00000', '2255.75000', '2255.75000', '293.25000', '2549.00000'),
(106, 65, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4203.01000', '546.39000', '4749.40000'),
(107, 66, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2188.32000', '284.48000', '2472.80000'),
(108, 67, 1, '2718000000100', '0', '1.000', 'Cm ', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(109, 68, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(110, 69, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(111, 70, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '563.29000', '4896.29000'),
(112, 70, 2, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(113, 71, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2188.32000', '284.48000', '2472.80000'),
(114, 72, 1, '2718000000100', '0', '0.500', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '1128.00000', '1128.00000', '146.64000', '1274.64000'),
(115, 73, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(116, 74, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(117, 75, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(118, 77, 1, '2718000000100', '0', '10.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '22560.00000', '21883.20000', '2844.82000', '24728.02000'),
(119, 77, 2, '2718000000100', '0', '12.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.12000', '6556.70000', '56992.82000'),
(120, 78, 1, '2718000000100', '0', '10.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '43330.00000', '43330.00000', '5632.90000', '48962.90000'),
(121, 79, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(122, 80, 1, '2718000000100', '0', '10.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '22560.00000', '22560.00000', '2932.80000', '25492.80000'),
(123, 80, 2, '2718000000100', '0', '5.000', 'Unid', 'ALMOHADA Y FUNDA AMARILLA', '4514.00000', '22570.00000', '22570.00000', '2934.10000', '25504.10000'),
(124, 81, 1, '2718000000100', '0', '10.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '22560.00000', '22560.00000', '2932.80000', '25492.80000'),
(125, 81, 2, '2718000000100', '0', '6.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '25998.00000', '25998.00000', '3379.74000', '29377.74000'),
(126, 82, 1, '2718000000100', '0', '2.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '8666.00000', '8666.00000', '1126.58000', '9792.58000'),
(127, 82, 2, '2718000000100', '0', '5.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '11280.00000', '11280.00000', '1466.40000', '12746.40000'),
(128, 83, 1, '2718000000100', '0', '101.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '437633.00000', '424504.01000', '55185.52000', '479689.53000'),
(129, 83, 2, '2718000000100', '0', '20.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '45120.00000', '43766.40000', '5689.63000', '49456.03000'),
(130, 85, 1, '2718000000100', '0', '2.000', 'Unid', 'ALMOH INF LAURA S-COL 60X40CM :: 6', '8459.00000', '16918.00000', '16072.10000', '2089.37000', '18161.47000'),
(131, 86, 1, '2718000000100', '0', '5.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '11280.00000', '10941.60000', '1422.41000', '12364.01000'),
(132, 86, 2, '2718000000100', '0', '5.000', 'Unid', 'ALMOHADA Y FUNDA AMARILLA', '4514.00000', '22570.00000', '21892.90000', '2846.08000', '24738.98000'),
(133, 87, 1, '2718000000100', '0', '5.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '11280.00000', '11280.00000', '1466.40000', '12746.40000'),
(134, 88, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(135, 89, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(136, 90, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(137, 91, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2188.32000', '284.48000', '2472.80000'),
(138, 92, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2188.32000', '284.48000', '2472.80000'),
(139, 93, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(140, 94, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(141, 95, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(142, 96, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(143, 97, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(144, 98, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(145, 99, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(146, 100, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(147, 101, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(148, 102, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(149, 103, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(150, 104, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(151, 105, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(152, 106, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(153, 107, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(154, 108, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(155, 109, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(156, 110, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(157, 111, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '2247.78761', '2247.79000', '2247.79000', '292.21000', '2540.00000'),
(158, 112, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(159, 113, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(160, 114, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.13000', '1345.13000', '1345.13000', '174.87000', '1520.00000'),
(161, 115, 1, '2718000000100', '0', '5.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '11280.00000', '11280.00000', '1466.40000', '12746.40000'),
(162, 116, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA AMARILLA', '4514.00000', '4514.00000', '4514.00000', '586.82000', '5100.82000'),
(163, 117, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA AMARILLA', '4514.00000', '4514.00000', '4514.00000', '586.82000', '5100.82000'),
(164, 118, 1, '2718000000100', '0', '1.000', 'Unid', 'FUNDA INDIVID GR SURT COL DOCOM :: 15', '17116.00000', '17116.00000', '17116.00000', '2225.08000', '19341.08000'),
(165, 119, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(166, 120, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2256.00000', '293.28000', '2549.28000'),
(167, 121, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOH INF LAURA S-COL 60X40CM :: 6', '8459.00000', '8459.00000', '8459.00000', '1099.67000', '9558.67000'),
(168, 122, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(169, 123, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(170, 124, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(171, 125, 1, '2718000000100', '0', '10.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '43330.00000', '43330.00000', '5632.90000', '48962.90000'),
(172, 125, 2, '2718000000100', '0', '6.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '13536.00000', '13536.00000', '1759.68000', '15295.68000'),
(173, 126, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(174, 127, 1, '2714099009900', '0', '1.000', 'Unid', 'DELANTAL CARNICERO SURTIDO COLOR ARMY', '1500.00000', '1500.00000', '1500.00000', '195.00000', '1695.00000'),
(175, 128, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(176, 129, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(177, 130, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOH INF LAURA S-COL 60X40CM :: 6', '8459.00000', '8459.00000', '8459.00000', '1099.67000', '9558.67000'),
(178, 131, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(179, 132, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(180, 133, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4764.15000', '619.34000', '5383.50000'),
(181, 134, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4764.15000', '619.34000', '5383.50000'),
(182, 135, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA AMARILLA', '4514.00000', '4514.00000', '4288.30000', '557.48000', '4845.78000'),
(183, 136, 1, '2718000000100', '0', '15.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '33840.00000', '32824.80000', '4267.22000', '37092.02000'),
(184, 137, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4764.15000', '619.34000', '5383.50000'),
(185, 138, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(186, 139, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.50000', '4911.50000', '638.50000', '5549.99000'),
(187, 140, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4912.00000', '4765.00000', '620.00000', '5384.00000'),
(188, 141, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.00000', '4911.00000', '4911.00000', '638.00000', '5549.00000'),
(189, 142, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.00000', '4764.00000', '619.00000', '5383.00000'),
(190, 143, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.00000', '4911.00000', '638.00000', '5549.00000'),
(191, 144, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.00000', '4911.00000', '638.00000', '5549.00000'),
(192, 145, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.00000', '4911.00000', '638.00000', '5549.00000'),
(193, 146, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.00000', '4911.00000', '638.00000', '5549.00000'),
(194, 147, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '4911.50000', '4911.00000', '4911.00000', '638.00000', '5549.00000'),
(195, 148, 1, '2718000000100', '0', '12.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.00000', '6557.00000', '56993.00000'),
(196, 148, 2, '2718000000100', '0', '56.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '126336.00000', '122546.00000', '15931.00000', '138477.00000'),
(197, 149, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1345.00000', '1345.00000', '1305.00000', '170.00000', '1475.00000'),
(198, 150, 1, '2718000000100', '0', '56.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '126336.00000', '122546.00000', '15931.00000', '138477.00000'),
(199, 150, 2, '2718000000100', '0', '12.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '50436.00000', '6557.00000', '56993.00000'),
(200, 151, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(201, 152, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(202, 153, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(203, 154, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(204, 155, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '2256.00000', '2188.00000', '284.00000', '2472.00000'),
(205, 156, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(206, 157, 1, '2718000000100', '0', '15.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '33840.00000', '32825.00000', '4267.00000', '37092.00000'),
(207, 158, 1, '2718000000100', '0', '15.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '33840.00000', '32825.00000', '4267.00000', '37092.00000'),
(208, 159, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1503.00000', '195.00000', '1698.00000'),
(209, 160, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(210, 161, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(211, 162, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(212, 163, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(213, 168, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(214, 169, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(215, 170, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(216, 171, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(217, 172, 1, '2718000000100', '0', '12.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '51996.00000', '48876.00000', '0.00000', '56993.00000'),
(218, 173, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(219, 174, 1, '2718000000100', '0', '10.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '43330.00000', '38996.00000', '0.00000', '46514.00000'),
(220, 175, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(221, 176, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4073.00000', '0.00000', '4749.00000'),
(222, 177, 0, '2718000000100', '0', '10.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '43330.00000', '42030.00000', '0.00000', '47494.00000'),
(223, 178, 0, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(224, 179, 0, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(225, 180, 0, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(226, 181, 0, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(227, 182, 0, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(228, 183, 0, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(229, 184, 0, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(230, 185, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(231, 186, 1, '2718000000100', '0', '8.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '34664.00000', '33624.00000', '0.00000', '37995.00000'),
(232, 187, 1, '2718000000100', '0', '8.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '34664.00000', '33624.00000', '0.00000', '37995.00000'),
(233, 188, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(234, 189, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(235, 190, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(236, 191, 1, '2718000000100', '0', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '0.00000', '4896.00000'),
(237, 192, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(238, 193, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(239, 194, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(240, 195, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(241, 196, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(242, 197, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(243, 198, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(244, 199, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(245, 200, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(246, 201, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(247, 202, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(248, 203, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(249, 204, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(250, 205, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(251, 206, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(252, 207, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(253, 208, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(254, 209, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(255, 210, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(256, 211, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(257, 212, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(258, 213, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(259, 214, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(260, 215, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(261, 216, 1, '2718000000100', '0', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(262, 217, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(263, 218, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(264, 219, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(265, 220, 1, '2718000000100', '0', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(266, 221, 1, '2718000000100', '7441119600652', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4333.00000', '563.00000', '4896.00000'),
(267, 221, 2, '2718000000100', '001', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(268, 222, 1, '2718000000100', '7441119600652', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4116.00000', '535.00000', '4651.00000'),
(269, 223, 1, '2718000000100', '7441119600652', '5.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '21665.00000', '21665.00000', '2816.00000', '24481.00000'),
(270, 223, 2, '2718000000100', '7441119600768', '5.000', 'Unid', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', '2256.00000', '11280.00000', '11280.00000', '1466.00000', '12746.00000'),
(271, 224, 1, '2718000000100', '7441119600652', '1.000', 'Unid', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', '4333.00000', '4333.00000', '4203.00000', '546.00000', '4749.00000'),
(272, 225, 1, '2718000000100', '001', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(273, 226, 1, '2718000000100', '001', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(274, 227, 1, '2718000000100', '001', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(275, 228, 1, '2718000000100', '74411414414', '1.000', 'Unid', 'Bandera', '5500.00000', '5500.00000', '5500.00000', '715.00000', '6215.00000'),
(276, 229, 1, '2718000000100', '74411414414', '1.000', 'Unid', 'Bandera', '5500.00000', '5500.00000', '5500.00000', '0.00000', '5500.00000'),
(277, 230, 1, '2718000000100', '74411414414', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(278, 231, 1, '2718000000100', '74411414414', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(279, 232, 1, '2718000000100', '74411414414', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(280, 233, 1, '2718000000100', '74411414414', '1.000', 'Unid', 'Bandera', '5500.00000', '5500.00000', '5500.00000', '0.00000', '5500.00000'),
(281, 234, 1, '2718000000100', '74411414414', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(282, 235, 1, '2718000000100', '74411414414', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(283, 236, 1, '2718000000100', '74411414414', '7.000', 'Unid', 'Bandera', '5500.00000', '38500.00000', '38500.00000', '0.00000', '38500.00000'),
(284, 237, 1, '2718000000100', '001', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(285, 238, 1, '2718000000100', '001', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000'),
(286, 239, 1, '2718000000100', '001', '1.000', 'Cm', 'Descuento por pronto pago', '1550.00000', '1550.00000', '1550.00000', '202.00000', '1752.00000');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentos_diarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `documentos_diarios` (
`id_documento` int(11)
,`consecutivo` varchar(20)
,`tipo_documento` varchar(2)
,`clave` varchar(50)
,`codigo_seguridad` int(8)
,`fecha` datetime
,`emisor_cedula` varchar(12)
,`emisor_nombre` varchar(80)
,`emisor_tipo` varchar(2)
,`emisor_comercial` varchar(80)
,`emisor_id_provincia` varchar(1)
,`emisor_id_canton` varchar(2)
,`emisor_id_distrito` varchar(2)
,`emisor_id_barrio` varchar(2)
,`emisor_otras_senas` varchar(160)
,`emisor_cod` int(3)
,`emisor_telefono` int(20)
,`emisor_correo` varchar(60)
,`receptor_nombre` varchar(80)
,`receptor_cedula` varchar(12)
,`receptor_tipo` varchar(2)
,`receptor_comercial` varchar(80)
,`receptor_id_provincia` varchar(1)
,`receptor_id_canton` varchar(2)
,`receptor_id_distrito` varchar(2)
,`receptor_id_barrio` varchar(2)
,`receptor_otras_senas` varchar(160)
,`receptor_cod` int(3)
,`receptor_telefono` int(20)
,`receptor_correo` varchar(60)
,`condicion_venta` varchar(2)
,`plazo_credito` varchar(10)
,`medio_pago` varchar(2)
,`moneda` varchar(3)
,`tipo_cambio` decimal(18,2)
,`servicios_gravados` decimal(18,5)
,`servicios_exentos` decimal(18,5)
,`servicios_exonerados` decimal(18,5)
,`mercancias_gravadas` decimal(18,5)
,`mercancias_exentas` decimal(18,5)
,`mercancias_exoneradas` decimal(18,5)
,`total_gravado` decimal(18,5)
,`total_exento` decimal(18,5)
,`total_exonerado` decimal(18,5)
,`total_venta` decimal(18,5)
,`total_descuentos` decimal(18,5)
,`total_venta_neta` decimal(18,5)
,`total_impuestos` decimal(18,5)
,`total_comprobante` decimal(18,5)
,`notas` varchar(500)
,`id_usuario` int(11)
,`id_empresa` int(11)
,`envio_atv` int(1)
,`valido_atv` int(1)
,`detalle_atv` varchar(500)
,`correo_enviado` tinyint(1)
,`fecha_correo` datetime
,`fecha_envio` datetime
,`fecha_valido` datetime
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_impuestos`
--

CREATE TABLE IF NOT EXISTS `documentos_impuestos` (
  `id_impuesto` int(11) NOT NULL AUTO_INCREMENT,
  `id_detalle` int(11) NOT NULL,
  `codigo` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `codigo_tarifa` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tarifa` decimal(4,2) NOT NULL,
  `monto` double(18,5) NOT NULL,
  `tipo_documento_exoneracion` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `numero_documento_exoneracion` varchar(40) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `nombre_institucion_exoneracion` varchar(160) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha_emision_exoneracion` datetime DEFAULT NULL,
  `porcentaje_exoneracion` int(3) DEFAULT NULL,
  `monto_exoneracion` double(18,5) DEFAULT NULL,
  PRIMARY KEY (`id_impuesto`)
) ENGINE=InnoDB AUTO_INCREMENT=271 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `documentos_impuestos`
--

INSERT INTO `documentos_impuestos` (`id_impuesto`, `id_detalle`, `codigo`, `codigo_tarifa`, `tarifa`, `monto`, `tipo_documento_exoneracion`, `numero_documento_exoneracion`, `nombre_institucion_exoneracion`, `fecha_emision_exoneracion`, `porcentaje_exoneracion`, `monto_exoneracion`) VALUES
(1, 1, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 11, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 12, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 13, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 14, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 15, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 16, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 17, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 18, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 19, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 20, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 21, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 22, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 23, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 24, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 25, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 26, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 27, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 28, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 29, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 30, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 31, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 32, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 33, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 34, '01', '08', '13.00', 9103.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 35, '01', '08', '13.00', 3413.78000, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 36, '01', '08', '13.00', 17484.52000, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 37, '01', '08', '13.00', 3982.74000, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 38, '01', '08', '13.00', 8742.26000, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 39, '01', '08', '13.00', 4267.22000, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 40, '01', '08', '13.00', 7649.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 41, '01', '08', '13.00', 4267.22000, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 42, '01', '08', '13.00', 7649.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 43, '01', '08', '13.00', 4267.22000, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 44, '01', '08', '13.00', 7649.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 45, '01', '08', '13.00', 4267.22000, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 46, '01', '08', '13.00', 7649.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 47, '01', '08', '13.00', 4267.22000, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 48, '01', '08', '13.00', 7649.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 49, '01', '08', '13.00', 55.58000, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 50, '01', '08', '13.00', 6543.08000, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 51, '01', '08', '13.00', 1066.68000, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 52, '01', '08', '13.00', 1099.67000, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 53, '01', '08', '13.00', 2844.82000, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 54, '01', '08', '13.00', 563.29000, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 55, '01', '08', '13.00', 3413.78000, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 56, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 57, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 58, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 59, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 60, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 61, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 62, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 63, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 64, '01', '08', '13.00', 853.44000, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 65, '01', '08', '13.00', 3519.36000, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 66, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 67, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 68, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 69, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 70, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 71, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 72, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 73, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 74, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 75, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 76, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 77, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 78, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 79, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 80, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 81, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 82, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 83, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 84, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 85, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 86, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 87, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 88, '01', '08', '13.00', 662.74000, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 89, '01', '08', '13.00', 1273.04000, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 90, '01', '08', '0.00', 0.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 91, '01', '08', '13.00', 662.74000, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 92, '01', '08', '13.00', 1273.04000, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 93, '01', '08', '13.00', 662.74000, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 94, '01', '08', '13.00', 662.74000, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 95, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 96, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 97, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 98, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 99, '01', '08', '13.00', 636.52000, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 100, '01', '08', '13.00', 331.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 101, '01', '08', '13.00', 7638.21000, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 102, '01', '08', '13.00', 5301.92000, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 103, '01', '08', '13.00', 359.45000, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 104, '01', '08', '13.00', 563.29000, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 105, '01', '08', '13.00', 293.25000, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 106, '01', '08', '13.00', 546.39000, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 107, '01', '08', '13.00', 284.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 108, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 109, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 110, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 111, '01', '08', '13.00', 563.29000, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 112, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 113, '01', '08', '13.00', 284.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 114, '01', '08', '13.00', 146.64000, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 115, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 116, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 117, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 118, '01', '08', '13.00', 2844.82000, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 119, '01', '08', '13.00', 6556.70000, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 120, '01', '08', '13.00', 5632.90000, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 121, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 122, '01', '08', '13.00', 2932.80000, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 123, '01', '08', '13.00', 2934.10000, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 124, '01', '08', '13.00', 2932.80000, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 125, '01', '08', '13.00', 3379.74000, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 126, '01', '08', '13.00', 1126.58000, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 127, '01', '08', '13.00', 1466.40000, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 128, '01', '08', '13.00', 55185.52000, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 129, '01', '08', '13.00', 5689.63000, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 130, '01', '08', '13.00', 2089.37000, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 131, '01', '08', '13.00', 1422.41000, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 132, '01', '08', '13.00', 2846.08000, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 133, '01', '08', '13.00', 1466.40000, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 134, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 135, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 136, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 137, '01', '08', '13.00', 284.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 138, '01', '08', '13.00', 284.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 139, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 140, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 141, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 142, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 143, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 144, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 145, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 146, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 147, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 148, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 149, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 150, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 151, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 152, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(153, 153, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 154, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 155, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 156, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 157, '01', '08', '13.00', 292.21000, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 158, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 159, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 160, '01', '08', '13.00', 174.87000, NULL, NULL, NULL, NULL, NULL, NULL),
(161, 161, '01', '08', '13.00', 1466.40000, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 162, '01', '08', '13.00', 586.82000, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 163, '01', '08', '13.00', 586.82000, NULL, NULL, NULL, NULL, NULL, NULL),
(164, 164, '01', '08', '13.00', 2225.08000, NULL, NULL, NULL, NULL, NULL, NULL),
(165, 165, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(166, 166, '01', '08', '13.00', 293.28000, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 167, '01', '08', '13.00', 1099.67000, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 168, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(169, 169, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 170, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 171, '01', '08', '13.00', 5632.90000, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 172, '01', '08', '13.00', 1759.68000, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 173, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 174, '01', '08', '13.00', 195.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 175, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 176, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(177, 177, '01', '08', '13.00', 1099.67000, NULL, NULL, NULL, NULL, NULL, NULL),
(178, 178, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 179, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 180, '01', '08', '13.00', 619.34000, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 181, '01', '08', '13.00', 619.34000, NULL, NULL, NULL, NULL, NULL, NULL),
(182, 182, '01', '08', '13.00', 557.48000, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 183, '01', '08', '13.00', 4267.22000, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 184, '01', '08', '13.00', 619.34000, NULL, NULL, NULL, NULL, NULL, NULL),
(185, 185, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(186, 186, '01', '08', '13.00', 638.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(187, 187, '01', '08', '13.00', 620.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(188, 188, '01', '08', '13.00', 638.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(189, 189, '01', '08', '13.00', 619.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(190, 190, '01', '08', '13.00', 638.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 191, '01', '08', '13.00', 638.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(192, 192, '01', '08', '13.00', 638.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(193, 193, '01', '08', '13.00', 638.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 194, '01', '08', '13.00', 638.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 195, '01', '08', '13.00', 6557.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 196, '01', '08', '13.00', 15931.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 197, '01', '08', '13.00', 170.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 198, '01', '08', '13.00', 15931.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 199, '01', '08', '13.00', 6557.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 200, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(201, 201, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(202, 202, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(203, 203, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(204, 204, '01', '08', '13.00', 284.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(205, 205, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(206, 206, '01', '08', '13.00', 4267.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(207, 207, '01', '08', '13.00', 4267.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(208, 208, '01', '08', '13.00', 195.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(209, 209, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 210, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 211, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 212, '01', '08', '13.00', 202.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(213, 214, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(214, 215, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(215, 216, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 217, '01', '08', '13.00', 6557.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(217, 218, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 219, '01', '08', '13.00', 5351.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(219, 220, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(220, 221, '01', '08', '13.00', 546.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(221, 228, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(222, 229, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(223, 230, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(224, 231, '01', '08', '13.00', 4371.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(225, 232, '01', '08', '13.00', 4371.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(226, 233, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(227, 234, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(228, 235, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(229, 236, '01', '08', '13.00', 563.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(230, 239, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(231, 240, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(232, 241, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(233, 242, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(234, 243, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(235, 244, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(236, 245, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(237, 246, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(238, 247, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(239, 248, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(240, 249, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(241, 250, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(242, 251, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(243, 252, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(244, 253, '01', '08', '13.00', 0.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(245, 261, '01', '08', '13.00', 5005.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(246, 262, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 263, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(248, 264, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(249, 265, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(250, 266, '01', '08', '13.00', 563.29000, NULL, NULL, NULL, NULL, NULL, NULL),
(251, 267, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 268, '01', '08', '13.00', 535.08000, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 269, '01', '08', '13.00', 2816.45000, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 270, '01', '08', '13.00', 1466.40000, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 271, '01', '08', '13.00', 546.39000, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 272, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(257, 273, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(258, 274, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(259, 275, '01', '08', '13.00', 715.00000, NULL, NULL, NULL, NULL, NULL, NULL),
(260, 276, '01', '08', '13.00', 715.00000, '03', '9635', NULL, NULL, NULL, 715.00000),
(261, 277, '01', '08', '13.00', 5005.00000, '03', '9635', NULL, NULL, NULL, 5005.00000),
(262, 278, '01', '08', '13.00', 5005.00000, '03', '', NULL, NULL, NULL, 5005.00000),
(263, 279, '01', '08', '13.00', 5005.00000, '03', '', NULL, NULL, NULL, 5005.00000),
(264, 280, '01', '08', '13.00', 715.00000, '03', '9635', NULL, NULL, NULL, 715.00000),
(265, 281, '01', '08', '13.00', 5005.00000, '03', '9635', NULL, NULL, NULL, 5005.00000),
(266, 282, '01', '08', '13.00', 5005.00000, '03', '9635', 'Dirección General de Hacienda', '2020-03-30 00:00:00', 13, 5005.00000),
(267, 283, '01', '08', '13.00', 5005.00000, '03', '9635', 'Ministerio de Hacienda', '2018-12-04 00:00:00', 13, 5005.00000),
(268, 284, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(269, 285, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL),
(270, 286, '01', '08', '13.00', 201.50000, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentos_mes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `documentos_mes` (
`id_documento` int(11)
,`consecutivo` varchar(20)
,`tipo_documento` varchar(2)
,`clave` varchar(50)
,`codigo_seguridad` int(8)
,`fecha` datetime
,`emisor_cedula` varchar(12)
,`emisor_nombre` varchar(80)
,`emisor_tipo` varchar(2)
,`emisor_comercial` varchar(80)
,`emisor_id_provincia` varchar(1)
,`emisor_id_canton` varchar(2)
,`emisor_id_distrito` varchar(2)
,`emisor_id_barrio` varchar(2)
,`emisor_otras_senas` varchar(160)
,`emisor_cod` int(3)
,`emisor_telefono` int(20)
,`emisor_correo` varchar(60)
,`receptor_nombre` varchar(80)
,`receptor_cedula` varchar(12)
,`receptor_tipo` varchar(2)
,`receptor_comercial` varchar(80)
,`receptor_id_provincia` varchar(1)
,`receptor_id_canton` varchar(2)
,`receptor_id_distrito` varchar(2)
,`receptor_id_barrio` varchar(2)
,`receptor_otras_senas` varchar(160)
,`receptor_cod` int(3)
,`receptor_telefono` int(20)
,`receptor_correo` varchar(60)
,`condicion_venta` varchar(2)
,`plazo_credito` varchar(10)
,`medio_pago` varchar(2)
,`moneda` varchar(3)
,`tipo_cambio` decimal(18,2)
,`servicios_gravados` decimal(18,5)
,`servicios_exentos` decimal(18,5)
,`servicios_exonerados` decimal(18,5)
,`mercancias_gravadas` decimal(18,5)
,`mercancias_exentas` decimal(18,5)
,`mercancias_exoneradas` decimal(18,5)
,`total_gravado` decimal(18,5)
,`total_exento` decimal(18,5)
,`total_exonerado` decimal(18,5)
,`total_venta` decimal(18,5)
,`total_descuentos` decimal(18,5)
,`total_venta_neta` decimal(18,5)
,`total_impuestos` decimal(18,5)
,`total_comprobante` decimal(18,5)
,`notas` varchar(500)
,`id_usuario` int(11)
,`id_empresa` int(11)
,`envio_atv` int(1)
,`valido_atv` int(1)
,`detalle_atv` varchar(500)
,`correo_enviado` tinyint(1)
,`fecha_correo` datetime
,`fecha_envio` datetime
,`fecha_valido` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentos_mes_anterior`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `documentos_mes_anterior` (
`id_documento` int(11)
,`consecutivo` varchar(20)
,`tipo_documento` varchar(2)
,`clave` varchar(50)
,`codigo_seguridad` int(8)
,`fecha` datetime
,`emisor_cedula` varchar(12)
,`emisor_nombre` varchar(80)
,`emisor_tipo` varchar(2)
,`emisor_comercial` varchar(80)
,`emisor_id_provincia` varchar(1)
,`emisor_id_canton` varchar(2)
,`emisor_id_distrito` varchar(2)
,`emisor_id_barrio` varchar(2)
,`emisor_otras_senas` varchar(160)
,`emisor_cod` int(3)
,`emisor_telefono` int(20)
,`emisor_correo` varchar(60)
,`receptor_nombre` varchar(80)
,`receptor_cedula` varchar(12)
,`receptor_tipo` varchar(2)
,`receptor_comercial` varchar(80)
,`receptor_id_provincia` varchar(1)
,`receptor_id_canton` varchar(2)
,`receptor_id_distrito` varchar(2)
,`receptor_id_barrio` varchar(2)
,`receptor_otras_senas` varchar(160)
,`receptor_cod` int(3)
,`receptor_telefono` int(20)
,`receptor_correo` varchar(60)
,`condicion_venta` varchar(2)
,`plazo_credito` varchar(10)
,`medio_pago` varchar(2)
,`moneda` varchar(3)
,`tipo_cambio` decimal(18,2)
,`servicios_gravados` decimal(18,5)
,`servicios_exentos` decimal(18,5)
,`servicios_exonerados` decimal(18,5)
,`mercancias_gravadas` decimal(18,5)
,`mercancias_exentas` decimal(18,5)
,`mercancias_exoneradas` decimal(18,5)
,`total_gravado` decimal(18,5)
,`total_exento` decimal(18,5)
,`total_exonerado` decimal(18,5)
,`total_venta` decimal(18,5)
,`total_descuentos` decimal(18,5)
,`total_venta_neta` decimal(18,5)
,`total_impuestos` decimal(18,5)
,`total_comprobante` decimal(18,5)
,`notas` varchar(500)
,`id_usuario` int(11)
,`id_empresa` int(11)
,`envio_atv` int(1)
,`valido_atv` int(1)
,`detalle_atv` varchar(500)
,`correo_enviado` tinyint(1)
,`fecha_correo` datetime
,`fecha_envio` datetime
,`fecha_valido` datetime
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_otros`
--

CREATE TABLE IF NOT EXISTS `documentos_otros` (
  `id_documento_otro` int(11) NOT NULL AUTO_INCREMENT,
  `id_documento` int(11) NOT NULL,
  `codigo` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `valor` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_documento_otro`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `documentos_otros`
--

INSERT INTO `documentos_otros` (`id_documento_otro`, `id_documento`, `codigo`, `valor`, `fecha_creacion`) VALUES
(1, 154, 'WMNumeroVendedor', '019596262', '2022-04-23 18:13:55'),
(2, 154, 'WMNumeroOrden', '2900671410', '2022-04-23 18:13:55'),
(3, 154, 'WMEnviarGLN', '7407001010251', '2022-04-23 18:13:55'),
(4, 155, 'WMNumeroVendedor', '019596262', '2022-04-24 11:23:10'),
(5, 155, 'WMNumeroOrden', '2900671414', '2022-04-24 11:23:10'),
(6, 155, 'WMEnviarGLN', '7407001010251', '2022-04-24 11:23:10'),
(7, 157, 'WMNumeroVendedor', '019596262', '2022-04-24 18:47:19'),
(8, 157, 'WMNumeroOrden', '2900679605', '2022-04-24 18:47:19'),
(9, 157, 'WMEnviarGLN', '7407001010251', '2022-04-24 18:47:19'),
(10, 217, 'WMNumeroVendedor', '019596262', '2022-09-18 10:49:21'),
(11, 217, 'WMNumeroOrden', '2645201200', '2022-09-18 10:49:21'),
(12, 217, 'WMEnviarGLN', '', '2022-09-18 10:49:21'),
(13, 218, 'WMNumeroVendedor', '019596262', '2022-09-18 10:57:23'),
(14, 218, 'WMNumeroOrden', '2645201200', '2022-09-18 10:57:23'),
(15, 218, 'WMEnviarGLN', '', '2022-09-18 10:57:23'),
(16, 219, 'WMNumeroVendedor', '019596262', '2022-09-18 11:16:28'),
(17, 219, 'WMNumeroOrden', '2645201200', '2022-09-18 11:16:28'),
(18, 219, 'WMEnviarGLN', '', '2022-09-18 11:16:28'),
(19, 221, 'WMNumeroVendedor', '019596221', '2022-09-18 15:46:06'),
(20, 221, 'WMNumeroOrden', '8524152145', '2022-09-18 15:46:07'),
(21, 221, 'WMEnviarGLN', '7407001010251', '2022-09-18 15:46:07'),
(22, 237, 'WMNumeroVendedor', '019596221', '2022-09-25 14:27:11'),
(23, 237, 'WMNumeroOrden', '2222000010', '2022-09-25 14:27:11'),
(24, 237, 'WMEnviarGLN', '7407001010251', '2022-09-25 14:27:11');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentos_proceso`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `documentos_proceso` (
`id_documento` int(11)
,`consecutivo` varchar(20)
,`tipo_documento` varchar(2)
,`clave` varchar(50)
,`codigo_seguridad` int(8)
,`fecha` datetime
,`emisor_cedula` varchar(12)
,`emisor_nombre` varchar(80)
,`emisor_tipo` varchar(2)
,`emisor_comercial` varchar(80)
,`emisor_id_provincia` varchar(1)
,`emisor_id_canton` varchar(2)
,`emisor_id_distrito` varchar(2)
,`emisor_id_barrio` varchar(2)
,`emisor_otras_senas` varchar(160)
,`emisor_cod` int(3)
,`emisor_telefono` int(20)
,`emisor_correo` varchar(60)
,`receptor_nombre` varchar(80)
,`receptor_cedula` varchar(12)
,`receptor_tipo` varchar(2)
,`receptor_comercial` varchar(80)
,`receptor_id_provincia` varchar(1)
,`receptor_id_canton` varchar(2)
,`receptor_id_distrito` varchar(2)
,`receptor_id_barrio` varchar(2)
,`receptor_otras_senas` varchar(160)
,`receptor_cod` int(3)
,`receptor_telefono` int(20)
,`receptor_correo` varchar(60)
,`condicion_venta` varchar(2)
,`plazo_credito` varchar(10)
,`medio_pago` varchar(2)
,`moneda` varchar(3)
,`tipo_cambio` decimal(18,2)
,`servicios_gravados` decimal(18,5)
,`servicios_exentos` decimal(18,5)
,`servicios_exonerados` decimal(18,5)
,`mercancias_gravadas` decimal(18,5)
,`mercancias_exentas` decimal(18,5)
,`mercancias_exoneradas` decimal(18,5)
,`total_gravado` decimal(18,5)
,`total_exento` decimal(18,5)
,`total_exonerado` decimal(18,5)
,`total_venta` decimal(18,5)
,`total_descuentos` decimal(18,5)
,`total_venta_neta` decimal(18,5)
,`total_impuestos` decimal(18,5)
,`total_comprobante` decimal(18,5)
,`notas` varchar(500)
,`id_usuario` int(11)
,`id_empresa` int(11)
,`id_caja` int(11)
,`id_sucursal` int(11)
,`envio_atv` int(1)
,`valido_atv` int(1)
,`detalle_atv` varchar(500)
,`correo_enviado` tinyint(1)
,`fecha_correo` datetime
,`fecha_envio` datetime
,`fecha_valido` datetime
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_referencias`
--

CREATE TABLE IF NOT EXISTS `documentos_referencias` (
  `id_referencia` int(11) NOT NULL AUTO_INCREMENT,
  `id_documento` int(11) NOT NULL,
  `referencia_tipo_documento` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `referencia_clave` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `referencia_fecha` datetime NOT NULL,
  `referencia_codigo` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `referencia_razon` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_referencia`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `documentos_referencias`
--

INSERT INTO `documentos_referencias` (`id_referencia`, `id_documento`, `referencia_tipo_documento`, `referencia_clave`, `referencia_fecha`, `referencia_codigo`, `referencia_razon`, `fecha_creacion`) VALUES
(1, 112, '01', '50628012200010244007700100004010000000004116803742', '2022-01-28 00:00:00', '99', 'Descuento PP', '2022-01-28 16:16:02'),
(2, 113, '01', '50628012200010244007700100004010000000010187231604', '2022-01-28 00:00:00', '99', 'Descuento PP', '2022-01-28 18:07:29'),
(3, 139, '01', '50601022200010244007701000001010000000023178659034', '2022-02-01 00:00:00', '01', 'Error de emision.', '2022-02-01 12:09:36'),
(4, 158, '01', '50625042200010244007700100007010000000029157149302', '2022-04-25 00:00:00', '01', 'Error de facturacion', '2022-04-24 19:10:31'),
(5, 220, '01', '50618092200010244007700100009010000000069176412958', '2022-09-18 00:00:00', '01', 'Otros', '2022-09-18 11:21:50');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentos_semana`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `documentos_semana` (
`id_documento` int(11)
,`consecutivo` varchar(20)
,`tipo_documento` varchar(2)
,`clave` varchar(50)
,`codigo_seguridad` int(8)
,`fecha` datetime
,`emisor_cedula` varchar(12)
,`emisor_nombre` varchar(80)
,`emisor_tipo` varchar(2)
,`emisor_comercial` varchar(80)
,`emisor_id_provincia` varchar(1)
,`emisor_id_canton` varchar(2)
,`emisor_id_distrito` varchar(2)
,`emisor_id_barrio` varchar(2)
,`emisor_otras_senas` varchar(160)
,`emisor_cod` int(3)
,`emisor_telefono` int(20)
,`emisor_correo` varchar(60)
,`receptor_nombre` varchar(80)
,`receptor_cedula` varchar(12)
,`receptor_tipo` varchar(2)
,`receptor_comercial` varchar(80)
,`receptor_id_provincia` varchar(1)
,`receptor_id_canton` varchar(2)
,`receptor_id_distrito` varchar(2)
,`receptor_id_barrio` varchar(2)
,`receptor_otras_senas` varchar(160)
,`receptor_cod` int(3)
,`receptor_telefono` int(20)
,`receptor_correo` varchar(60)
,`condicion_venta` varchar(2)
,`plazo_credito` varchar(10)
,`medio_pago` varchar(2)
,`moneda` varchar(3)
,`tipo_cambio` decimal(18,2)
,`servicios_gravados` decimal(18,5)
,`servicios_exentos` decimal(18,5)
,`servicios_exonerados` decimal(18,5)
,`mercancias_gravadas` decimal(18,5)
,`mercancias_exentas` decimal(18,5)
,`mercancias_exoneradas` decimal(18,5)
,`total_gravado` decimal(18,5)
,`total_exento` decimal(18,5)
,`total_exonerado` decimal(18,5)
,`total_venta` decimal(18,5)
,`total_descuentos` decimal(18,5)
,`total_venta_neta` decimal(18,5)
,`total_impuestos` decimal(18,5)
,`total_comprobante` decimal(18,5)
,`notas` varchar(500)
,`id_usuario` int(11)
,`id_empresa` int(11)
,`envio_atv` int(1)
,`valido_atv` int(1)
,`detalle_atv` varchar(500)
,`correo_enviado` tinyint(1)
,`fecha_correo` datetime
,`fecha_envio` datetime
,`fecha_valido` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentos_semanal`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `documentos_semanal` (
`id_documento` int(11)
,`consecutivo` varchar(20)
,`tipo_documento` varchar(2)
,`clave` varchar(50)
,`codigo_seguridad` int(8)
,`fecha` datetime
,`emisor_cedula` varchar(12)
,`emisor_nombre` varchar(80)
,`emisor_tipo` varchar(2)
,`emisor_comercial` varchar(80)
,`emisor_id_provincia` varchar(1)
,`emisor_id_canton` varchar(2)
,`emisor_id_distrito` varchar(2)
,`emisor_id_barrio` varchar(2)
,`emisor_otras_senas` varchar(160)
,`emisor_cod` int(3)
,`emisor_telefono` int(20)
,`emisor_correo` varchar(60)
,`receptor_nombre` varchar(80)
,`receptor_cedula` varchar(12)
,`receptor_tipo` varchar(2)
,`receptor_comercial` varchar(80)
,`receptor_id_provincia` varchar(1)
,`receptor_id_canton` varchar(2)
,`receptor_id_distrito` varchar(2)
,`receptor_id_barrio` varchar(2)
,`receptor_otras_senas` varchar(160)
,`receptor_cod` int(3)
,`receptor_telefono` int(20)
,`receptor_correo` varchar(60)
,`condicion_venta` varchar(2)
,`plazo_credito` varchar(10)
,`medio_pago` varchar(2)
,`moneda` varchar(3)
,`tipo_cambio` decimal(18,2)
,`servicios_gravados` decimal(18,5)
,`servicios_exentos` decimal(18,5)
,`servicios_exonerados` decimal(18,5)
,`mercancias_gravadas` decimal(18,5)
,`mercancias_exentas` decimal(18,5)
,`mercancias_exoneradas` decimal(18,5)
,`total_gravado` decimal(18,5)
,`total_exento` decimal(18,5)
,`total_exonerado` decimal(18,5)
,`total_venta` decimal(18,5)
,`total_descuentos` decimal(18,5)
,`total_venta_neta` decimal(18,5)
,`total_impuestos` decimal(18,5)
,`total_comprobante` decimal(18,5)
,`notas` varchar(500)
,`id_usuario` int(11)
,`id_empresa` int(11)
,`envio_atv` int(1)
,`valido_atv` int(1)
,`detalle_atv` varchar(500)
,`correo_enviado` tinyint(1)
,`fecha_correo` datetime
,`fecha_envio` datetime
,`fecha_valido` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentos_semana_anterior`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `documentos_semana_anterior` (
`id_documento` int(11)
,`consecutivo` varchar(20)
,`tipo_documento` varchar(2)
,`clave` varchar(50)
,`codigo_seguridad` int(8)
,`fecha` datetime
,`emisor_cedula` varchar(12)
,`emisor_nombre` varchar(80)
,`emisor_tipo` varchar(2)
,`emisor_comercial` varchar(80)
,`emisor_id_provincia` varchar(1)
,`emisor_id_canton` varchar(2)
,`emisor_id_distrito` varchar(2)
,`emisor_id_barrio` varchar(2)
,`emisor_otras_senas` varchar(160)
,`emisor_cod` int(3)
,`emisor_telefono` int(20)
,`emisor_correo` varchar(60)
,`receptor_nombre` varchar(80)
,`receptor_cedula` varchar(12)
,`receptor_tipo` varchar(2)
,`receptor_comercial` varchar(80)
,`receptor_id_provincia` varchar(1)
,`receptor_id_canton` varchar(2)
,`receptor_id_distrito` varchar(2)
,`receptor_id_barrio` varchar(2)
,`receptor_otras_senas` varchar(160)
,`receptor_cod` int(3)
,`receptor_telefono` int(20)
,`receptor_correo` varchar(60)
,`condicion_venta` varchar(2)
,`plazo_credito` varchar(10)
,`medio_pago` varchar(2)
,`moneda` varchar(3)
,`tipo_cambio` decimal(18,2)
,`servicios_gravados` decimal(18,5)
,`servicios_exentos` decimal(18,5)
,`servicios_exonerados` decimal(18,5)
,`mercancias_gravadas` decimal(18,5)
,`mercancias_exentas` decimal(18,5)
,`mercancias_exoneradas` decimal(18,5)
,`total_gravado` decimal(18,5)
,`total_exento` decimal(18,5)
,`total_exonerado` decimal(18,5)
,`total_venta` decimal(18,5)
,`total_descuentos` decimal(18,5)
,`total_venta_neta` decimal(18,5)
,`total_impuestos` decimal(18,5)
,`total_comprobante` decimal(18,5)
,`notas` varchar(500)
,`id_usuario` int(11)
,`id_empresa` int(11)
,`envio_atv` int(1)
,`valido_atv` int(1)
,`detalle_atv` varchar(500)
,`correo_enviado` tinyint(1)
,`fecha_correo` datetime
,`fecha_envio` datetime
,`fecha_valido` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentos_view`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `documentos_view` (
`id_documento` int(11)
,`consecutivo` varchar(20)
,`tipo_documento` varchar(2)
,`clave` varchar(50)
,`codigo_seguridad` int(8)
,`fecha` datetime
,`emisor_cedula` varchar(12)
,`emisor_nombre` varchar(80)
,`emisor_tipo` varchar(2)
,`emisor_comercial` varchar(80)
,`emisor_id_provincia` varchar(1)
,`emisor_id_canton` varchar(2)
,`emisor_id_distrito` varchar(2)
,`emisor_id_barrio` varchar(2)
,`emisor_otras_senas` varchar(160)
,`emisor_cod` int(3)
,`emisor_telefono` int(20)
,`emisor_correo` varchar(60)
,`receptor_nombre` varchar(80)
,`receptor_cedula` varchar(12)
,`receptor_tipo` varchar(2)
,`receptor_comercial` varchar(80)
,`receptor_id_provincia` varchar(1)
,`receptor_id_canton` varchar(2)
,`receptor_id_distrito` varchar(2)
,`receptor_id_barrio` varchar(2)
,`receptor_otras_senas` varchar(160)
,`receptor_cod` int(3)
,`receptor_telefono` int(20)
,`receptor_correo` varchar(60)
,`condicion_venta` varchar(2)
,`plazo_credito` varchar(10)
,`medio_pago` varchar(2)
,`moneda` varchar(3)
,`tipo_cambio` decimal(18,2)
,`servicios_gravados` decimal(18,5)
,`servicios_exentos` decimal(18,5)
,`servicios_exonerados` decimal(18,5)
,`mercancias_gravadas` decimal(18,5)
,`mercancias_exentas` decimal(18,5)
,`mercancias_exoneradas` decimal(18,5)
,`total_gravado` decimal(18,5)
,`total_exento` decimal(18,5)
,`total_exonerado` decimal(18,5)
,`total_venta` decimal(18,5)
,`total_descuentos` decimal(18,5)
,`total_venta_neta` decimal(18,5)
,`total_impuestos` decimal(18,5)
,`total_comprobante` decimal(18,5)
,`notas` varchar(500)
,`id_usuario` int(11)
,`id_empresa` int(11)
,`envio_atv` int(1)
,`valido_atv` int(1)
,`detalle_atv` varchar(500)
,`correo_enviado` tinyint(1)
,`fecha_correo` datetime
,`fecha_envio` datetime
,`fecha_valido` datetime
,`dias_emitido` int(7)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `empresas_view`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `empresas_view` (
`id_empresa` int(11)
,`identificacion` varchar(12)
,`id_tipo_identificacion` varchar(2)
,`tipo_identificacion` varchar(25)
,`razon` varchar(100)
,`nombre` varchar(100)
,`nombre_comercial` varchar(80)
,`cod_actividad` int(11)
,`id_ubicacion` int(11)
,`cod_provincia` int(8)
,`cod_canton` int(8)
,`cod_distrito` int(6)
,`cod_barrio` int(5)
,`provincia` varchar(10)
,`canton` varchar(19)
,`distrito` varchar(28)
,`barrio` varchar(47)
,`otras_senas` varchar(160)
,`telefono` int(20)
,`cod_pais` int(3)
,`codigo_telefono` varchar(10)
,`nombre_pais` varchar(250)
,`correo` varchar(160)
,`estado` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(15) NOT NULL AUTO_INCREMENT,
  `id_unidad` int(15) NOT NULL,
  `unidad_empaque` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `codigo_cabys` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `codigo_venta` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `codigo_interno` varchar(250) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `impuesto` int(11) NOT NULL,
  `descuento` double(10,2) NOT NULL DEFAULT 0.00,
  `porcentaje_descuento` int(11) NOT NULL DEFAULT 0,
  `valor_unitario` double(10,2) NOT NULL,
  `valor_impuesto` double(10,2) NOT NULL,
  `valor_total` double(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_eliminacion` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_empresa` (`id_empresa`),
  KEY `fk_unidad` (`id_unidad`),
  KEY `fk_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_unidad`, `unidad_empaque`, `id_categoria`, `id_empresa`, `codigo_cabys`, `codigo_venta`, `codigo_interno`, `descripcion`, `impuesto`, `descuento`, `porcentaje_descuento`, `valor_unitario`, `valor_impuesto`, `valor_total`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `estado`) VALUES
(3, 85, 6, 3, 1, '2718000000100', '17441119600437', '2202849', 'ALMOH INF LAURA S-COL 60X40CM :: 6', 13, 0.00, 0, 8459.00, 1099.67, 9558.67, '2021-12-13 15:23:10', '2022-01-27 16:45:26', NULL, 1),
(4, 85, 3, 1, 1, '2718000000100', '7441119600768', '2647973', 'ALMOHADA BEBE SENCILLA ESTAMPADA DOCOMA :: 3', 13, 0.00, 0, 500.00, 65.00, 565.00, '2021-12-13 15:51:29', '2022-09-24 17:03:20', NULL, 1),
(5, 85, 3, 1, 1, '2718000000100', '7441119600652', '2645516', 'ALMOHADA Y FUNDA BEBE COLORES SURTIDOS DOCOMA :: 3', 13, 0.00, 0, 4333.00, 563.29, 4896.29, '2021-12-13 15:53:32', '2022-01-30 11:33:32', NULL, 1),
(6, 85, 1, 2, 1, '2714099009900', '17441119600444', '2022659', 'DELANTAL CARNICERO SURTIDO COLOR ARMY', 13, 0.00, 0, 1500.00, 195.00, 1695.00, '2021-12-13 15:56:21', '2021-12-13 15:56:21', NULL, 1),
(7, 3, 1, 0, 1, '2718000000100', '001', '001', 'Descuento por pronto pago', 13, 0.00, 0, 1550.00, 201.50, 1751.50, '2021-12-13 15:57:22', '2022-02-13 17:08:13', NULL, 1),
(8, 85, 3, 1, 1, '2714001010100', '7441119600157', '2645628', 'FUNDA BEBE CUADRADA AMARILLA DOCOMA :: 3', 13, 0.00, 0, 2765.00, 359.45, 3124.45, '2021-12-13 16:36:03', '2021-12-13 16:36:03', NULL, 1),
(9, 85, 3, 1, 1, '2714001010100', '7441119600164', '2648015', 'FUNDA BEBE CUADRADA BLANCA DOCOMA :: 3', 13, 0.00, 0, 2765.00, 359.45, 3124.45, '2021-12-13 16:37:25', '2022-01-27 16:31:51', NULL, 1),
(10, 85, 3, 1, 1, '2714001010100', '7441119600171', '2645649', 'FUNDA BEBE CUADRADA CELESTE DOCOMA :: 3', 13, 0.00, 0, 2765.00, 359.45, 3124.45, '2021-12-13 16:38:46', '2021-12-13 16:38:46', NULL, 1),
(11, 85, 3, 1, 1, '2714001010100', '7441119600188', '2645635', 'FUNDA BEBE CUADRADA ROSADA DOCOMA :: 3', 13, 0.00, 0, 2765.00, 359.45, 3124.45, '2021-12-13 16:39:44', '2022-01-27 10:42:46', NULL, 1),
(12, 85, 15, 2, 1, '2718000000100', '17441119600505', '2210395', 'FUNDA INDIVID GR SURT COL DOCOM :: 15', 13, 0.00, 0, 17116.00, 2225.08, 19341.08, '2021-12-13 16:41:25', '2022-01-27 16:30:08', NULL, 1),
(13, 85, 18, 2, 1, '2718000000100', '17441119600697', '2210388', 'FUNDA INDIVIDUAL BLANCA :: 18', 13, 0.00, 0, 20540.00, 2670.20, 23210.20, '2021-12-13 16:42:15', '2022-01-27 10:43:51', NULL, 1),
(14, 85, 3, 1, 1, '2718000000100', '1447451547414', '2145141', 'ALMOHADA Y FUNDA AMARILLA', 13, 0.00, 0, 4514.00, 586.82, 5100.82, '2021-12-15 09:54:34', '2022-01-26 19:11:26', NULL, 1),
(15, 85, 1, 0, 1, '2718000000100', '74411414414', '251414', 'Bandera', 13, 0.00, 0, 5500.00, 715.00, 6215.00, '2022-01-28 18:02:49', '2022-09-15 02:53:11', NULL, 1),
(16, 85, 2, 0, 1, '2718000000100', '7441141414', '2414141', 'Prueba 2', 13, 0.00, 0, 2550.00, 331.50, 2881.50, '2022-01-28 18:04:04', '2022-01-28 18:05:31', '2022-01-29 01:05:31', 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_inactivos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `productos_inactivos` (
`id_producto` int(15)
,`id_unidad` int(15)
,`unidad_empaque` int(11)
,`id_categoria` int(11)
,`nombre_categoria` varchar(50)
,`simbolo_unidad` varchar(10)
,`nombre_unidad` varchar(30)
,`id_empresa` int(11)
,`codigo_cabys` varchar(15)
,`codigo_venta` varchar(15)
,`codigo_interno` varchar(250)
,`descripcion` varchar(100)
,`impuesto` int(11)
,`valor_unitario` double(10,2)
,`valor_impuesto` double(10,2)
,`valor_total` double(10,2)
,`descuento` double(10,2)
,`porcentaje_descuento` int(11)
,`fecha_creacion` datetime
,`fecha_modificacion` datetime
,`fecha_eliminacion` datetime
,`estado` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_view`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `productos_view` (
`id_producto` int(15)
,`id_unidad` int(15)
,`unidad_empaque` int(11)
,`id_categoria` int(11)
,`nombre_categoria` varchar(50)
,`simbolo_unidad` varchar(10)
,`nombre_unidad` varchar(30)
,`id_empresa` int(11)
,`codigo_cabys` varchar(15)
,`codigo_venta` varchar(15)
,`codigo_interno` varchar(250)
,`descripcion` varchar(100)
,`impuesto` int(11)
,`valor_unitario` double(10,2)
,`valor_impuesto` double(10,2)
,`valor_total` double(10,2)
,`descuento` double(10,2)
,`porcentaje_descuento` int(11)
,`fecha_creacion` datetime
,`fecha_modificacion` datetime
,`fecha_eliminacion` datetime
,`estado` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `reporte_dia`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `reporte_dia` (
`fecha_documento` date
,`codigo` varchar(20)
,`codigo_venta` varchar(15)
,`unidades` decimal(38,3)
,`unidad_medida` varchar(15)
,`detalle` varchar(160)
,`precio_unidad` decimal(18,5)
,`valor_neto` decimal(40,5)
,`valor_subtotal` decimal(40,5)
,`valor_impuestos` decimal(40,5)
,`valor_total` decimal(40,5)
,`dias_emitido` int(7)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `reporte_diario`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `reporte_diario` (
`fecha_documento` date
,`codigo` varchar(20)
,`codigo_venta` varchar(15)
,`unidades` decimal(38,3)
,`unidad_medida` varchar(15)
,`detalle` varchar(160)
,`precio_unidad` decimal(18,5)
,`valor_neto` decimal(40,5)
,`valor_subtotal` decimal(40,5)
,`valor_impuestos` decimal(40,5)
,`valor_total` decimal(40,5)
,`dias_emitido` int(7)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `reporte_meses`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `reporte_meses` (
`fecha_documento` varchar(7)
,`codigo` varchar(20)
,`codigo_venta` varchar(15)
,`unidades` decimal(60,3)
,`unidad_medida` varchar(15)
,`detalle` varchar(160)
,`precio_unidad` decimal(18,5)
,`valor_neto` decimal(62,5)
,`valor_subtotal` decimal(62,5)
,`valor_impuestos` decimal(62,5)
,`valor_total` decimal(62,5)
,`dias_emitido` int(7)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `reporte_mes_actual`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `reporte_mes_actual` (
`fecha_documento` varchar(7)
,`codigo` varchar(20)
,`codigo_venta` varchar(15)
,`unidades` decimal(60,3)
,`unidad_medida` varchar(15)
,`detalle` varchar(160)
,`precio_unidad` decimal(18,5)
,`valor_neto` decimal(62,5)
,`valor_subtotal` decimal(62,5)
,`valor_impuestos` decimal(62,5)
,`valor_total` decimal(62,5)
,`dias_emitido` int(7)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `reporte_semana`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `reporte_semana` (
`fecha_documento` date
,`codigo` varchar(20)
,`codigo_venta` varchar(15)
,`unidades` decimal(38,3)
,`unidad_medida` varchar(15)
,`detalle` varchar(160)
,`precio_unidad` decimal(18,5)
,`valor_neto` decimal(40,5)
,`valor_subtotal` decimal(40,5)
,`valor_impuestos` decimal(40,5)
,`valor_total` decimal(40,5)
,`dias_emitido` int(7)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifa_impuestos`
--

CREATE TABLE IF NOT EXISTS `tarifa_impuestos` (
  `id_tarifa` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `porcentaje` int(11) NOT NULL,
  `tipo_tarifa` varchar(1) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_eliminacion` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_tarifa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tarifa_impuestos`
--

INSERT INTO `tarifa_impuestos` (`id_tarifa`, `descripcion`, `porcentaje`, `tipo_tarifa`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `estado`) VALUES
('01', 'Tarifa 0% (Exento)', 0, 'E', '2022-05-11 14:52:01', '2022-05-22 16:29:12', '2022-05-11 22:48:47', 1),
('02', 'Tarifa 1% (Reducida)', 1, 'R', '2022-05-11 14:52:01', '2022-05-22 16:30:07', '2022-05-11 22:48:47', 1),
('03', 'Tarifa 2% (Reducida)', 2, 'R', '2022-05-11 14:52:01', '2022-05-22 16:30:13', '2022-05-11 22:48:47', 1),
('04', 'Tarifa 4% (Reducida)', 4, 'R', '2022-05-11 14:52:01', '2022-05-22 16:30:19', '2022-05-11 22:48:47', 1),
('05', 'Transitorio 0%', 0, 'T', '2022-05-11 14:52:01', '2022-05-22 16:29:27', '2022-05-11 22:48:47', 1),
('06', 'Transitorio 4%', 4, 'T', '2022-05-11 14:52:01', '2022-05-22 16:29:29', '2022-05-11 22:48:47', 1),
('07', 'Transitorio 8%', 8, 'T', '2022-05-11 14:52:01', '2022-05-22 16:29:31', '2022-05-11 22:48:47', 1),
('08', 'Tarifa 13% (General)', 13, 'G', '2022-05-11 14:52:01', '2022-05-22 16:30:41', '2022-05-11 22:48:47', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_documentos`
--

CREATE TABLE IF NOT EXISTS `tipos_documentos` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_documento` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_documento` varchar(1) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_eliminacion` datetime DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tipos_documentos`
--

INSERT INTO `tipos_documentos` (`id_tipo`, `id_tipo_documento`, `descripcion`, `tipo_documento`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `estado`) VALUES
(1, '01', 'Factura electrónica ', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(2, '02', 'Nota de débito electrónica', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(3, '03', 'Nota de crédito electrónica ', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(4, '04', 'Tiquete electrónico', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(5, '05', 'Nota de despacho', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(6, '06', 'Contrato', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(7, '07', 'Procedimiento', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(8, '08', 'Comprobante emitido en contingencia', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(9, '09', 'Devolución mercadería', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(10, '10', 'Sustituye factura rechazada por el Ministerio \r\nde Hacienda', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(11, '11', 'Sustituye factura rechazada por el Receptor \r\ndel comprobante', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(12, '12', 'Sustituye Factura de exportación', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(13, '13', 'Facturación mes vencido', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(14, '14', 'Comprobante aportado por contribuyente \r\ndel Régimen de Tributación Simplificado', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(15, '15', 'Sustituye una Factura electrónica de \r\nCompra', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(16, '99', 'Otros', 'R', '2021-12-13 09:56:07', '2022-05-08 14:51:30', NULL, 1),
(17, '01', 'Factura electrónica', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1),
(18, '02', 'Nota de débito electrónica', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1),
(19, '03', 'Nota de crédito electrónica ', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1),
(20, '04', 'Tiquete electrónico', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1),
(21, '05', 'Confirmación de aceptación del comprobante electrónico', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1),
(22, '06', 'Confirmación de aceptación parcial del comprobante electrónico', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1),
(23, '07', 'Confirmación de rechazo del comprobante electrónico', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1),
(24, '08', 'Factura electrónica de compras', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1),
(25, '09', 'Factura electrónica de exportación', 'E', '2022-05-08 14:49:57', '2022-05-08 14:51:30', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_exoneracion`
--

CREATE TABLE IF NOT EXISTS `tipos_exoneracion` (
  `codigo_exoneracion` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`codigo_exoneracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tipos_exoneracion`
--

INSERT INTO `tipos_exoneracion` (`codigo_exoneracion`, `descripcion`, `fecha_creacion`, `estado`) VALUES
('01', 'Compras autorizadas', '2022-09-15 00:15:12', 1),
('02', 'Ventas exentas a diplomáticos', '2022-09-15 00:15:12', 1),
('03', 'Autorizado por Ley especial', '2022-09-15 00:15:12', 1),
('04', 'Exenciones Dirección General de Hacienda', '2022-09-15 00:15:12', 1),
('05', 'Transitorio V', '2022-09-15 00:15:12', 1),
('06', 'Transitorio IX', '2022-09-15 00:15:12', 1),
('07', 'Transitorio XVII', '2022-09-15 00:15:12', 1),
('99', 'Otros', '2022-09-15 00:15:12', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_impuestos`
--

CREATE TABLE IF NOT EXISTS `tipos_impuestos` (
  `id_impuesto` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `porcentaje` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_eliminacion` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_impuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tipos_impuestos`
--

INSERT INTO `tipos_impuestos` (`id_impuesto`, `descripcion`, `porcentaje`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `estado`) VALUES
('01', 'Impuesto al Valor Agregado', NULL, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('02', 'Impuesto Selectivo de Consumo', 10, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('03', 'Impuesto Único a los Combustibles', 10, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('04', 'Impuesto específico de Bebidas Alcohólicas', 10, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('05', 'Impuesto Específico sobre las bebidas envasadas sin \r\ncontenido alcohólico y jabones de tocador', 10, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('06', 'Impuesto a los Productos de Tabaco ', 10, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('07', 'IVA (cálculo especial)', NULL, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('08', 'IVA Régimen de Bienes Usados (Factor)', NULL, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('12', 'Impuesto Específico al Cemento', 10, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1),
('99', 'Otros', 0, '2022-05-11 14:32:03', '2022-05-11 14:32:03', '2022-05-11 22:18:46', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_referencia`
--

CREATE TABLE IF NOT EXISTS `tipos_referencia` (
  `id_codigo` varchar(2) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_referencia` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tipos_referencia`
--

INSERT INTO `tipos_referencia` (`id_codigo`, `tipo_referencia`, `fecha_creacion`, `estado`) VALUES
('01', 'Anula documento de referencia', '2022-01-28 12:07:59', 1),
('02', 'Corrige texto de documento de referencia', '2022-01-28 12:07:59', 1),
('03', 'Corrige monto', '2022-01-28 12:07:59', 1),
('04', 'Referencia a otro documento', '2022-01-28 12:07:59', 1),
('05', 'Sustituye comprobante provisional por contigencia', '2022-01-28 12:07:59', 1),
('99', 'Otros', '2022-01-28 12:07:59', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cambio_historico`
--

CREATE TABLE IF NOT EXISTS `tipo_cambio_historico` (
  `id_tipo_cambio` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_cambio` double(12,2) NOT NULL,
  `fecha_cambio` date NOT NULL DEFAULT current_timestamp(),
  `codigo_indicador` varchar(9) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cod_pais` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo_cambio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_cambio_historico`
--

INSERT INTO `tipo_cambio_historico` (`id_tipo_cambio`, `tipo_cambio`, `fecha_cambio`, `codigo_indicador`, `cod_pais`) VALUES
(1, 1.00, '2022-04-24', '0', 52),
(2, 569.49, '2023-01-22', '318', 66),
(3, 562.88, '2023-01-22', '317', 66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_medida`
--

CREATE TABLE IF NOT EXISTS `unidades_medida` (
  `id_unidad` int(11) NOT NULL,
  `simbolo` varchar(10) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `descripcion` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_unidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `unidades_medida`
--

INSERT INTO `unidades_medida` (`id_unidad`, `simbolo`, `descripcion`) VALUES
(1, 'Al', 'Alquiler de uso habitacional '),
(2, 'Alc', 'Alquiler de uso comercial '),
(3, 'Cm', 'Comisiones '),
(4, 'I', 'Intereses '),
(5, 'Os', 'Otro tipo de servicio '),
(6, 'Sp', 'Servicios Profesionales '),
(7, 'Spe', 'Servicios personales '),
(8, 'St', 'Servicios técnicos '),
(9, '1', 'uno (índice de refracción) '),
(10, '\'', 'minuto '),
(11, '\'\'', 'segundo '),
(12, '°C', 'grado Celsius '),
(13, '1/m', '1 por metro '),
(14, 'A', 'Ampere '),
(15, 'A/m', 'ampere por metro '),
(16, 'A/m^2', 'ampere por metro cuadrado '),
(17, 'B', 'bel '),
(18, 'Bq', 'Becquerel '),
(19, 'C', 'coulomb '),
(20, 'C/kg', 'coulomb por kilogramo '),
(21, 'C/m^2', 'coulomb por metro cuadrado '),
(22, 'C/m^3', 'coulomb por metro cúbico '),
(23, 'cd', 'Candela '),
(24, 'cd/m^2', 'candela por metro cuadrado '),
(25, 'cm', 'centímetro '),
(26, 'd', 'día '),
(27, 'eV', 'electronvolt '),
(28, 'F', 'farad '),
(29, 'F/m', 'farad por metro '),
(30, 'g', 'Gramo '),
(31, 'Gal', 'Galón '),
(32, 'Gy', 'gray '),
(33, 'Gy/s', 'gray por segundo '),
(34, 'H', 'henry '),
(35, 'h', 'hora '),
(36, 'H/m', 'henry por metro '),
(37, 'Hz', 'hertz '),
(38, 'J', 'Joule '),
(39, 'J/(kg*K)', 'joule por kilogramo kelvin '),
(40, 'J/(mol*K)', 'joule por mol kelvin '),
(41, 'J/K', 'joule por kelvin '),
(42, 'J/kg', 'joule por kilogramo '),
(43, 'J/m^3', 'joule por metro cúbico '),
(44, 'J/mol', 'joule por mol '),
(45, 'K', 'Kelvin '),
(46, 'kat', 'katal '),
(47, 'kat/m^3', 'katal por metro cúbico '),
(48, 'kg', 'Kilogramo '),
(49, 'kg/m^3', 'kilogramo por metro cúbico '),
(50, 'Km', 'Kilometro '),
(51, 'Kw', 'kilovatios '),
(52, 'L', 'litro '),
(53, 'lm', 'lumen '),
(54, 'ln', 'pulgada '),
(55, 'lx', 'lux '),
(56, 'm', 'Metro '),
(57, 'm/s', 'metro por segundo '),
(58, 'm/s^2', 'metro por segundo cuadrado '),
(59, 'm^2', 'metro cuadrado '),
(60, 'm^3', 'metro cúbico '),
(61, 'min', 'minuto '),
(62, 'mL', 'mililitro '),
(63, 'mm', 'Milímetro '),
(64, 'mol', 'Mol '),
(65, 'mol/m^3', 'mol por metro cúbico '),
(66, 'N', 'newton '),
(67, 'N/m', 'newton por metro '),
(68, 'N?m', 'newton metro '),
(69, 'Np', 'neper '),
(70, '°', 'grado '),
(71, 'Oz', 'Onzas '),
(72, 'Pa', 'pascal '),
(73, 'Pa*s', 'pascal segundo '),
(74, 'rad', 'radián '),
(75, 'rad/s', 'radián por segundo '),
(76, 'rad/s^2', 'radián por segundo cuadrado '),
(77, 's', 'Segundo '),
(78, 'S', 'siemens '),
(79, 'sr', 'estereorradián '),
(80, 'Sv', 'sievert '),
(81, 'T', 'tesla '),
(82, 't', 'tonelada '),
(83, 'u', 'unidad de masa atómica unifica'),
(84, 'ua', 'unidad astronómica '),
(85, 'Unid', 'Unidad '),
(86, 'V', 'volt '),
(87, 'V/m', 'volt por metro '),
(88, 'W', 'Watt '),
(89, 'W/(m*K)', 'watt por metro kevin '),
(90, 'W/(m^2*sr)', 'watt por metro cuadrado estere'),
(91, 'W/m?', 'watt por metro cuadrado '),
(92, 'W/sr', 'watt por estereorradián '),
(93, 'Wb', 'weber '),
(94, 'Ω', 'ohm '),
(95, 'Otros', 'Se debe indicar la descripción');

-- --------------------------------------------------------

--
-- Estructura para la vista `clientes_inactivos`
--
DROP TABLE IF EXISTS `clientes_inactivos`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `clientes_inactivos`  AS SELECT `clientes`.`id_cliente` AS `id_cliente`, `clientes`.`id_empresa` AS `id_empresa`, `clientes`.`identificacion` AS `identificacion`, `clientes`.`id_tipo_identificacion` AS `id_tipo_identificacion`, `laura_seguridad`.`tipos_identificaciones`.`tipo_identificacion` AS `tipo_identificacion`, `clientes`.`razon` AS `razon`, `clientes`.`razon` AS `nombre`, `clientes`.`nombre_comercial` AS `nombre_comercial`, `clientes`.`id_ubicacion` AS `id_ubicacion`, `laura_seguridad`.`ubicaciones`.`cod_provincia` AS `cod_provincia`, `laura_seguridad`.`ubicaciones`.`provincia` AS `provincia`, `laura_seguridad`.`ubicaciones`.`cod_canton` AS `cod_canton`, `laura_seguridad`.`ubicaciones`.`canton` AS `canton`, `laura_seguridad`.`ubicaciones`.`cod_distrito` AS `cod_distrito`, `laura_seguridad`.`ubicaciones`.`distrito` AS `distrito`, `laura_seguridad`.`ubicaciones`.`cod_barrio` AS `cod_barrio`, `laura_seguridad`.`ubicaciones`.`barrio` AS `barrio`, `clientes`.`otras_senas` AS `otras_senas`, `laura_seguridad`.`codigos_paises`.`codigo_telefono` AS `codigo_telefono`, `clientes`.`telefono` AS `telefono`, `clientes`.`cod_pais` AS `cod_pais`, `clientes`.`correo` AS `correo`, `clientes`.`fecha_creacion` AS `fecha_creacion`, `clientes`.`fecha_modificacion` AS `fecha_modificacion`, `clientes`.`fecha_eliminacion` AS `fecha_eliminacion`, `clientes`.`estado` AS `estado` FROM (((`clientes` join `laura_seguridad`.`tipos_identificaciones` on(`laura_seguridad`.`tipos_identificaciones`.`id_tipo_identificacion` = `clientes`.`id_tipo_identificacion`)) join `laura_seguridad`.`codigos_paises` on(`laura_seguridad`.`codigos_paises`.`cod_pais` = `clientes`.`cod_pais`)) join `laura_seguridad`.`ubicaciones` on(`clientes`.`id_ubicacion` = `laura_seguridad`.`ubicaciones`.`id_ubicacion`)) WHERE `clientes`.`estado` = 0 ORDER BY `clientes`.`razon` ASC  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `clientes_view`
--
DROP TABLE IF EXISTS `clientes_view`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clientes_view`  AS SELECT `clientes`.`id_cliente` AS `id_cliente`, `clientes`.`id_empresa` AS `id_empresa`, `clientes`.`identificacion` AS `identificacion`, `clientes`.`id_tipo_identificacion` AS `id_tipo_identificacion`, `laura_seguridad`.`tipos_identificaciones`.`tipo_identificacion` AS `tipo_identificacion`, `clientes`.`razon` AS `razon`, `clientes`.`razon` AS `nombre`, `clientes`.`nombre_comercial` AS `nombre_comercial`, `clientes`.`id_ubicacion` AS `id_ubicacion`, `laura_seguridad`.`ubicaciones`.`cod_provincia` AS `cod_provincia`, `laura_seguridad`.`ubicaciones`.`provincia` AS `provincia`, `laura_seguridad`.`ubicaciones`.`cod_canton` AS `cod_canton`, `laura_seguridad`.`ubicaciones`.`canton` AS `canton`, `laura_seguridad`.`ubicaciones`.`cod_distrito` AS `cod_distrito`, `laura_seguridad`.`ubicaciones`.`distrito` AS `distrito`, `laura_seguridad`.`ubicaciones`.`cod_barrio` AS `cod_barrio`, `laura_seguridad`.`ubicaciones`.`barrio` AS `barrio`, `clientes`.`otras_senas` AS `otras_senas`, `laura_seguridad`.`codigos_paises`.`codigo_telefono` AS `codigo_telefono`, `clientes`.`telefono` AS `telefono`, `clientes`.`cod_pais` AS `cod_pais`, `clientes`.`correo` AS `correo`, `clientes`.`fecha_creacion` AS `fecha_creacion`, `clientes`.`fecha_modificacion` AS `fecha_modificacion`, `clientes`.`fecha_eliminacion` AS `fecha_eliminacion`, `clientes`.`estado` AS `estado` FROM (((`clientes` join `laura_seguridad`.`tipos_identificaciones` on(`laura_seguridad`.`tipos_identificaciones`.`id_tipo_identificacion` = `clientes`.`id_tipo_identificacion`)) join `laura_seguridad`.`codigos_paises` on(`laura_seguridad`.`codigos_paises`.`cod_pais` = `clientes`.`cod_pais`)) join `laura_seguridad`.`ubicaciones` on(`clientes`.`id_ubicacion` = `laura_seguridad`.`ubicaciones`.`id_ubicacion`)) ORDER BY `clientes`.`razon` ASC  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `documentos_diarios`
--
DROP TABLE IF EXISTS `documentos_diarios`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `documentos_diarios`  AS SELECT `documentos_view`.`id_documento` AS `id_documento`, `documentos_view`.`consecutivo` AS `consecutivo`, `documentos_view`.`tipo_documento` AS `tipo_documento`, `documentos_view`.`clave` AS `clave`, `documentos_view`.`codigo_seguridad` AS `codigo_seguridad`, `documentos_view`.`fecha` AS `fecha`, `documentos_view`.`emisor_cedula` AS `emisor_cedula`, `documentos_view`.`emisor_nombre` AS `emisor_nombre`, `documentos_view`.`emisor_tipo` AS `emisor_tipo`, `documentos_view`.`emisor_comercial` AS `emisor_comercial`, `documentos_view`.`emisor_id_provincia` AS `emisor_id_provincia`, `documentos_view`.`emisor_id_canton` AS `emisor_id_canton`, `documentos_view`.`emisor_id_distrito` AS `emisor_id_distrito`, `documentos_view`.`emisor_id_barrio` AS `emisor_id_barrio`, `documentos_view`.`emisor_otras_senas` AS `emisor_otras_senas`, `documentos_view`.`emisor_cod` AS `emisor_cod`, `documentos_view`.`emisor_telefono` AS `emisor_telefono`, `documentos_view`.`emisor_correo` AS `emisor_correo`, `documentos_view`.`receptor_nombre` AS `receptor_nombre`, `documentos_view`.`receptor_cedula` AS `receptor_cedula`, `documentos_view`.`receptor_tipo` AS `receptor_tipo`, `documentos_view`.`receptor_comercial` AS `receptor_comercial`, `documentos_view`.`receptor_id_provincia` AS `receptor_id_provincia`, `documentos_view`.`receptor_id_canton` AS `receptor_id_canton`, `documentos_view`.`receptor_id_distrito` AS `receptor_id_distrito`, `documentos_view`.`receptor_id_barrio` AS `receptor_id_barrio`, `documentos_view`.`receptor_otras_senas` AS `receptor_otras_senas`, `documentos_view`.`receptor_cod` AS `receptor_cod`, `documentos_view`.`receptor_telefono` AS `receptor_telefono`, `documentos_view`.`receptor_correo` AS `receptor_correo`, `documentos_view`.`condicion_venta` AS `condicion_venta`, `documentos_view`.`plazo_credito` AS `plazo_credito`, `documentos_view`.`medio_pago` AS `medio_pago`, `documentos_view`.`moneda` AS `moneda`, `documentos_view`.`tipo_cambio` AS `tipo_cambio`, `documentos_view`.`servicios_gravados` AS `servicios_gravados`, `documentos_view`.`servicios_exentos` AS `servicios_exentos`, `documentos_view`.`servicios_exonerados` AS `servicios_exonerados`, `documentos_view`.`mercancias_gravadas` AS `mercancias_gravadas`, `documentos_view`.`mercancias_exentas` AS `mercancias_exentas`, `documentos_view`.`mercancias_exoneradas` AS `mercancias_exoneradas`, `documentos_view`.`total_gravado` AS `total_gravado`, `documentos_view`.`total_exento` AS `total_exento`, `documentos_view`.`total_exonerado` AS `total_exonerado`, `documentos_view`.`total_venta` AS `total_venta`, `documentos_view`.`total_descuentos` AS `total_descuentos`, `documentos_view`.`total_venta_neta` AS `total_venta_neta`, `documentos_view`.`total_impuestos` AS `total_impuestos`, `documentos_view`.`total_comprobante` AS `total_comprobante`, `documentos_view`.`notas` AS `notas`, `documentos_view`.`id_usuario` AS `id_usuario`, `documentos_view`.`id_empresa` AS `id_empresa`, `documentos_view`.`envio_atv` AS `envio_atv`, `documentos_view`.`valido_atv` AS `valido_atv`, `documentos_view`.`detalle_atv` AS `detalle_atv`, `documentos_view`.`correo_enviado` AS `correo_enviado`, `documentos_view`.`fecha_correo` AS `fecha_correo`, `documentos_view`.`fecha_envio` AS `fecha_envio`, `documentos_view`.`fecha_valido` AS `fecha_valido` FROM `documentos_view` WHERE `documentos_view`.`dias_emitido` = 00  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `documentos_mes`
--
DROP TABLE IF EXISTS `documentos_mes`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `documentos_mes`  AS SELECT `documentos`.`id_documento` AS `id_documento`, `documentos`.`consecutivo` AS `consecutivo`, `documentos`.`tipo_documento` AS `tipo_documento`, `documentos`.`clave` AS `clave`, `documentos`.`codigo_seguridad` AS `codigo_seguridad`, `documentos`.`fecha` AS `fecha`, `documentos`.`emisor_cedula` AS `emisor_cedula`, `documentos`.`emisor_nombre` AS `emisor_nombre`, `documentos`.`emisor_tipo` AS `emisor_tipo`, `documentos`.`emisor_comercial` AS `emisor_comercial`, `documentos`.`emisor_id_provincia` AS `emisor_id_provincia`, `documentos`.`emisor_id_canton` AS `emisor_id_canton`, `documentos`.`emisor_id_distrito` AS `emisor_id_distrito`, `documentos`.`emisor_id_barrio` AS `emisor_id_barrio`, `documentos`.`emisor_otras_senas` AS `emisor_otras_senas`, `documentos`.`emisor_cod` AS `emisor_cod`, `documentos`.`emisor_telefono` AS `emisor_telefono`, `documentos`.`emisor_correo` AS `emisor_correo`, `documentos`.`receptor_nombre` AS `receptor_nombre`, `documentos`.`receptor_cedula` AS `receptor_cedula`, `documentos`.`receptor_tipo` AS `receptor_tipo`, `documentos`.`receptor_comercial` AS `receptor_comercial`, `documentos`.`receptor_id_provincia` AS `receptor_id_provincia`, `documentos`.`receptor_id_canton` AS `receptor_id_canton`, `documentos`.`receptor_id_distrito` AS `receptor_id_distrito`, `documentos`.`receptor_id_barrio` AS `receptor_id_barrio`, `documentos`.`receptor_otras_senas` AS `receptor_otras_senas`, `documentos`.`receptor_cod` AS `receptor_cod`, `documentos`.`receptor_telefono` AS `receptor_telefono`, `documentos`.`receptor_correo` AS `receptor_correo`, `documentos`.`condicion_venta` AS `condicion_venta`, `documentos`.`plazo_credito` AS `plazo_credito`, `documentos`.`medio_pago` AS `medio_pago`, `documentos`.`moneda` AS `moneda`, `documentos`.`tipo_cambio` AS `tipo_cambio`, `documentos`.`servicios_gravados` AS `servicios_gravados`, `documentos`.`servicios_exentos` AS `servicios_exentos`, `documentos`.`servicios_exonerados` AS `servicios_exonerados`, `documentos`.`mercancias_gravadas` AS `mercancias_gravadas`, `documentos`.`mercancias_exentas` AS `mercancias_exentas`, `documentos`.`mercancias_exoneradas` AS `mercancias_exoneradas`, `documentos`.`total_gravado` AS `total_gravado`, `documentos`.`total_exento` AS `total_exento`, `documentos`.`total_exonerado` AS `total_exonerado`, `documentos`.`total_venta` AS `total_venta`, `documentos`.`total_descuentos` AS `total_descuentos`, `documentos`.`total_venta_neta` AS `total_venta_neta`, `documentos`.`total_impuestos` AS `total_impuestos`, `documentos`.`total_comprobante` AS `total_comprobante`, `documentos`.`notas` AS `notas`, `documentos`.`id_usuario` AS `id_usuario`, `documentos`.`id_empresa` AS `id_empresa`, `documentos`.`envio_atv` AS `envio_atv`, `documentos`.`valido_atv` AS `valido_atv`, `documentos`.`detalle_atv` AS `detalle_atv`, `documentos`.`correo_enviado` AS `correo_enviado`, `documentos`.`fecha_correo` AS `fecha_correo`, `documentos`.`fecha_envio` AS `fecha_envio`, `documentos`.`fecha_valido` AS `fecha_valido` FROM `documentos` WHERE date_format(`documentos`.`fecha`,'%Y-%m') = date_format(current_timestamp() - interval 0 month,'%Y-%m')  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `documentos_mes_anterior`
--
DROP TABLE IF EXISTS `documentos_mes_anterior`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `documentos_mes_anterior`  AS SELECT `documentos`.`id_documento` AS `id_documento`, `documentos`.`consecutivo` AS `consecutivo`, `documentos`.`tipo_documento` AS `tipo_documento`, `documentos`.`clave` AS `clave`, `documentos`.`codigo_seguridad` AS `codigo_seguridad`, `documentos`.`fecha` AS `fecha`, `documentos`.`emisor_cedula` AS `emisor_cedula`, `documentos`.`emisor_nombre` AS `emisor_nombre`, `documentos`.`emisor_tipo` AS `emisor_tipo`, `documentos`.`emisor_comercial` AS `emisor_comercial`, `documentos`.`emisor_id_provincia` AS `emisor_id_provincia`, `documentos`.`emisor_id_canton` AS `emisor_id_canton`, `documentos`.`emisor_id_distrito` AS `emisor_id_distrito`, `documentos`.`emisor_id_barrio` AS `emisor_id_barrio`, `documentos`.`emisor_otras_senas` AS `emisor_otras_senas`, `documentos`.`emisor_cod` AS `emisor_cod`, `documentos`.`emisor_telefono` AS `emisor_telefono`, `documentos`.`emisor_correo` AS `emisor_correo`, `documentos`.`receptor_nombre` AS `receptor_nombre`, `documentos`.`receptor_cedula` AS `receptor_cedula`, `documentos`.`receptor_tipo` AS `receptor_tipo`, `documentos`.`receptor_comercial` AS `receptor_comercial`, `documentos`.`receptor_id_provincia` AS `receptor_id_provincia`, `documentos`.`receptor_id_canton` AS `receptor_id_canton`, `documentos`.`receptor_id_distrito` AS `receptor_id_distrito`, `documentos`.`receptor_id_barrio` AS `receptor_id_barrio`, `documentos`.`receptor_otras_senas` AS `receptor_otras_senas`, `documentos`.`receptor_cod` AS `receptor_cod`, `documentos`.`receptor_telefono` AS `receptor_telefono`, `documentos`.`receptor_correo` AS `receptor_correo`, `documentos`.`condicion_venta` AS `condicion_venta`, `documentos`.`plazo_credito` AS `plazo_credito`, `documentos`.`medio_pago` AS `medio_pago`, `documentos`.`moneda` AS `moneda`, `documentos`.`tipo_cambio` AS `tipo_cambio`, `documentos`.`servicios_gravados` AS `servicios_gravados`, `documentos`.`servicios_exentos` AS `servicios_exentos`, `documentos`.`servicios_exonerados` AS `servicios_exonerados`, `documentos`.`mercancias_gravadas` AS `mercancias_gravadas`, `documentos`.`mercancias_exentas` AS `mercancias_exentas`, `documentos`.`mercancias_exoneradas` AS `mercancias_exoneradas`, `documentos`.`total_gravado` AS `total_gravado`, `documentos`.`total_exento` AS `total_exento`, `documentos`.`total_exonerado` AS `total_exonerado`, `documentos`.`total_venta` AS `total_venta`, `documentos`.`total_descuentos` AS `total_descuentos`, `documentos`.`total_venta_neta` AS `total_venta_neta`, `documentos`.`total_impuestos` AS `total_impuestos`, `documentos`.`total_comprobante` AS `total_comprobante`, `documentos`.`notas` AS `notas`, `documentos`.`id_usuario` AS `id_usuario`, `documentos`.`id_empresa` AS `id_empresa`, `documentos`.`envio_atv` AS `envio_atv`, `documentos`.`valido_atv` AS `valido_atv`, `documentos`.`detalle_atv` AS `detalle_atv`, `documentos`.`correo_enviado` AS `correo_enviado`, `documentos`.`fecha_correo` AS `fecha_correo`, `documentos`.`fecha_envio` AS `fecha_envio`, `documentos`.`fecha_valido` AS `fecha_valido` FROM `documentos` WHERE date_format(`documentos`.`fecha`,'%Y-%m') = date_format(current_timestamp() - interval 1 month,'%Y-%m')  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `documentos_proceso`
--
DROP TABLE IF EXISTS `documentos_proceso`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `documentos_proceso`  AS SELECT `documentos`.`id_documento` AS `id_documento`, `documentos`.`consecutivo` AS `consecutivo`, `documentos`.`tipo_documento` AS `tipo_documento`, `documentos`.`clave` AS `clave`, `documentos`.`codigo_seguridad` AS `codigo_seguridad`, `documentos`.`fecha` AS `fecha`, `documentos`.`emisor_cedula` AS `emisor_cedula`, `documentos`.`emisor_nombre` AS `emisor_nombre`, `documentos`.`emisor_tipo` AS `emisor_tipo`, `documentos`.`emisor_comercial` AS `emisor_comercial`, `documentos`.`emisor_id_provincia` AS `emisor_id_provincia`, `documentos`.`emisor_id_canton` AS `emisor_id_canton`, `documentos`.`emisor_id_distrito` AS `emisor_id_distrito`, `documentos`.`emisor_id_barrio` AS `emisor_id_barrio`, `documentos`.`emisor_otras_senas` AS `emisor_otras_senas`, `documentos`.`emisor_cod` AS `emisor_cod`, `documentos`.`emisor_telefono` AS `emisor_telefono`, `documentos`.`emisor_correo` AS `emisor_correo`, `documentos`.`receptor_nombre` AS `receptor_nombre`, `documentos`.`receptor_cedula` AS `receptor_cedula`, `documentos`.`receptor_tipo` AS `receptor_tipo`, `documentos`.`receptor_comercial` AS `receptor_comercial`, `documentos`.`receptor_id_provincia` AS `receptor_id_provincia`, `documentos`.`receptor_id_canton` AS `receptor_id_canton`, `documentos`.`receptor_id_distrito` AS `receptor_id_distrito`, `documentos`.`receptor_id_barrio` AS `receptor_id_barrio`, `documentos`.`receptor_otras_senas` AS `receptor_otras_senas`, `documentos`.`receptor_cod` AS `receptor_cod`, `documentos`.`receptor_telefono` AS `receptor_telefono`, `documentos`.`receptor_correo` AS `receptor_correo`, `documentos`.`condicion_venta` AS `condicion_venta`, `documentos`.`plazo_credito` AS `plazo_credito`, `documentos`.`medio_pago` AS `medio_pago`, `documentos`.`moneda` AS `moneda`, `documentos`.`tipo_cambio` AS `tipo_cambio`, `documentos`.`servicios_gravados` AS `servicios_gravados`, `documentos`.`servicios_exentos` AS `servicios_exentos`, `documentos`.`servicios_exonerados` AS `servicios_exonerados`, `documentos`.`mercancias_gravadas` AS `mercancias_gravadas`, `documentos`.`mercancias_exentas` AS `mercancias_exentas`, `documentos`.`mercancias_exoneradas` AS `mercancias_exoneradas`, `documentos`.`total_gravado` AS `total_gravado`, `documentos`.`total_exento` AS `total_exento`, `documentos`.`total_exonerado` AS `total_exonerado`, `documentos`.`total_venta` AS `total_venta`, `documentos`.`total_descuentos` AS `total_descuentos`, `documentos`.`total_venta_neta` AS `total_venta_neta`, `documentos`.`total_impuestos` AS `total_impuestos`, `documentos`.`total_comprobante` AS `total_comprobante`, `documentos`.`notas` AS `notas`, `documentos`.`id_usuario` AS `id_usuario`, `documentos`.`id_empresa` AS `id_empresa`, `documentos`.`id_caja` AS `id_caja`, `documentos`.`id_sucursal` AS `id_sucursal`, `documentos`.`envio_atv` AS `envio_atv`, `documentos`.`valido_atv` AS `valido_atv`, `documentos`.`detalle_atv` AS `detalle_atv`, `documentos`.`correo_enviado` AS `correo_enviado`, `documentos`.`fecha_correo` AS `fecha_correo`, `documentos`.`fecha_envio` AS `fecha_envio`, `documentos`.`fecha_valido` AS `fecha_valido` FROM `documentos` WHERE `documentos`.`envio_atv` = 1 AND `documentos`.`valido_atv` = 00  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `documentos_semana`
--
DROP TABLE IF EXISTS `documentos_semana`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `documentos_semana`  AS SELECT `documentos`.`id_documento` AS `id_documento`, `documentos`.`consecutivo` AS `consecutivo`, `documentos`.`tipo_documento` AS `tipo_documento`, `documentos`.`clave` AS `clave`, `documentos`.`codigo_seguridad` AS `codigo_seguridad`, `documentos`.`fecha` AS `fecha`, `documentos`.`emisor_cedula` AS `emisor_cedula`, `documentos`.`emisor_nombre` AS `emisor_nombre`, `documentos`.`emisor_tipo` AS `emisor_tipo`, `documentos`.`emisor_comercial` AS `emisor_comercial`, `documentos`.`emisor_id_provincia` AS `emisor_id_provincia`, `documentos`.`emisor_id_canton` AS `emisor_id_canton`, `documentos`.`emisor_id_distrito` AS `emisor_id_distrito`, `documentos`.`emisor_id_barrio` AS `emisor_id_barrio`, `documentos`.`emisor_otras_senas` AS `emisor_otras_senas`, `documentos`.`emisor_cod` AS `emisor_cod`, `documentos`.`emisor_telefono` AS `emisor_telefono`, `documentos`.`emisor_correo` AS `emisor_correo`, `documentos`.`receptor_nombre` AS `receptor_nombre`, `documentos`.`receptor_cedula` AS `receptor_cedula`, `documentos`.`receptor_tipo` AS `receptor_tipo`, `documentos`.`receptor_comercial` AS `receptor_comercial`, `documentos`.`receptor_id_provincia` AS `receptor_id_provincia`, `documentos`.`receptor_id_canton` AS `receptor_id_canton`, `documentos`.`receptor_id_distrito` AS `receptor_id_distrito`, `documentos`.`receptor_id_barrio` AS `receptor_id_barrio`, `documentos`.`receptor_otras_senas` AS `receptor_otras_senas`, `documentos`.`receptor_cod` AS `receptor_cod`, `documentos`.`receptor_telefono` AS `receptor_telefono`, `documentos`.`receptor_correo` AS `receptor_correo`, `documentos`.`condicion_venta` AS `condicion_venta`, `documentos`.`plazo_credito` AS `plazo_credito`, `documentos`.`medio_pago` AS `medio_pago`, `documentos`.`moneda` AS `moneda`, `documentos`.`tipo_cambio` AS `tipo_cambio`, `documentos`.`servicios_gravados` AS `servicios_gravados`, `documentos`.`servicios_exentos` AS `servicios_exentos`, `documentos`.`servicios_exonerados` AS `servicios_exonerados`, `documentos`.`mercancias_gravadas` AS `mercancias_gravadas`, `documentos`.`mercancias_exentas` AS `mercancias_exentas`, `documentos`.`mercancias_exoneradas` AS `mercancias_exoneradas`, `documentos`.`total_gravado` AS `total_gravado`, `documentos`.`total_exento` AS `total_exento`, `documentos`.`total_exonerado` AS `total_exonerado`, `documentos`.`total_venta` AS `total_venta`, `documentos`.`total_descuentos` AS `total_descuentos`, `documentos`.`total_venta_neta` AS `total_venta_neta`, `documentos`.`total_impuestos` AS `total_impuestos`, `documentos`.`total_comprobante` AS `total_comprobante`, `documentos`.`notas` AS `notas`, `documentos`.`id_usuario` AS `id_usuario`, `documentos`.`id_empresa` AS `id_empresa`, `documentos`.`envio_atv` AS `envio_atv`, `documentos`.`valido_atv` AS `valido_atv`, `documentos`.`detalle_atv` AS `detalle_atv`, `documentos`.`correo_enviado` AS `correo_enviado`, `documentos`.`fecha_correo` AS `fecha_correo`, `documentos`.`fecha_envio` AS `fecha_envio`, `documentos`.`fecha_valido` AS `fecha_valido` FROM `documentos` WHERE yearweek(`documentos`.`fecha`,1) = yearweek(current_timestamp() - interval 0 week,1)  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `documentos_semanal`
--
DROP TABLE IF EXISTS `documentos_semanal`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `documentos_semanal`  AS SELECT `documentos_view`.`id_documento` AS `id_documento`, `documentos_view`.`consecutivo` AS `consecutivo`, `documentos_view`.`tipo_documento` AS `tipo_documento`, `documentos_view`.`clave` AS `clave`, `documentos_view`.`codigo_seguridad` AS `codigo_seguridad`, `documentos_view`.`fecha` AS `fecha`, `documentos_view`.`emisor_cedula` AS `emisor_cedula`, `documentos_view`.`emisor_nombre` AS `emisor_nombre`, `documentos_view`.`emisor_tipo` AS `emisor_tipo`, `documentos_view`.`emisor_comercial` AS `emisor_comercial`, `documentos_view`.`emisor_id_provincia` AS `emisor_id_provincia`, `documentos_view`.`emisor_id_canton` AS `emisor_id_canton`, `documentos_view`.`emisor_id_distrito` AS `emisor_id_distrito`, `documentos_view`.`emisor_id_barrio` AS `emisor_id_barrio`, `documentos_view`.`emisor_otras_senas` AS `emisor_otras_senas`, `documentos_view`.`emisor_cod` AS `emisor_cod`, `documentos_view`.`emisor_telefono` AS `emisor_telefono`, `documentos_view`.`emisor_correo` AS `emisor_correo`, `documentos_view`.`receptor_nombre` AS `receptor_nombre`, `documentos_view`.`receptor_cedula` AS `receptor_cedula`, `documentos_view`.`receptor_tipo` AS `receptor_tipo`, `documentos_view`.`receptor_comercial` AS `receptor_comercial`, `documentos_view`.`receptor_id_provincia` AS `receptor_id_provincia`, `documentos_view`.`receptor_id_canton` AS `receptor_id_canton`, `documentos_view`.`receptor_id_distrito` AS `receptor_id_distrito`, `documentos_view`.`receptor_id_barrio` AS `receptor_id_barrio`, `documentos_view`.`receptor_otras_senas` AS `receptor_otras_senas`, `documentos_view`.`receptor_cod` AS `receptor_cod`, `documentos_view`.`receptor_telefono` AS `receptor_telefono`, `documentos_view`.`receptor_correo` AS `receptor_correo`, `documentos_view`.`condicion_venta` AS `condicion_venta`, `documentos_view`.`plazo_credito` AS `plazo_credito`, `documentos_view`.`medio_pago` AS `medio_pago`, `documentos_view`.`moneda` AS `moneda`, `documentos_view`.`tipo_cambio` AS `tipo_cambio`, `documentos_view`.`servicios_gravados` AS `servicios_gravados`, `documentos_view`.`servicios_exentos` AS `servicios_exentos`, `documentos_view`.`servicios_exonerados` AS `servicios_exonerados`, `documentos_view`.`mercancias_gravadas` AS `mercancias_gravadas`, `documentos_view`.`mercancias_exentas` AS `mercancias_exentas`, `documentos_view`.`mercancias_exoneradas` AS `mercancias_exoneradas`, `documentos_view`.`total_gravado` AS `total_gravado`, `documentos_view`.`total_exento` AS `total_exento`, `documentos_view`.`total_exonerado` AS `total_exonerado`, `documentos_view`.`total_venta` AS `total_venta`, `documentos_view`.`total_descuentos` AS `total_descuentos`, `documentos_view`.`total_venta_neta` AS `total_venta_neta`, `documentos_view`.`total_impuestos` AS `total_impuestos`, `documentos_view`.`total_comprobante` AS `total_comprobante`, `documentos_view`.`notas` AS `notas`, `documentos_view`.`id_usuario` AS `id_usuario`, `documentos_view`.`id_empresa` AS `id_empresa`, `documentos_view`.`envio_atv` AS `envio_atv`, `documentos_view`.`valido_atv` AS `valido_atv`, `documentos_view`.`detalle_atv` AS `detalle_atv`, `documentos_view`.`correo_enviado` AS `correo_enviado`, `documentos_view`.`fecha_correo` AS `fecha_correo`, `documentos_view`.`fecha_envio` AS `fecha_envio`, `documentos_view`.`fecha_valido` AS `fecha_valido` FROM `documentos_view` WHERE `documentos_view`.`dias_emitido` <= 7 AND `documentos_view`.`dias_emitido` > 00  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `documentos_semana_anterior`
--
DROP TABLE IF EXISTS `documentos_semana_anterior`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `documentos_semana_anterior`  AS SELECT `documentos`.`id_documento` AS `id_documento`, `documentos`.`consecutivo` AS `consecutivo`, `documentos`.`tipo_documento` AS `tipo_documento`, `documentos`.`clave` AS `clave`, `documentos`.`codigo_seguridad` AS `codigo_seguridad`, `documentos`.`fecha` AS `fecha`, `documentos`.`emisor_cedula` AS `emisor_cedula`, `documentos`.`emisor_nombre` AS `emisor_nombre`, `documentos`.`emisor_tipo` AS `emisor_tipo`, `documentos`.`emisor_comercial` AS `emisor_comercial`, `documentos`.`emisor_id_provincia` AS `emisor_id_provincia`, `documentos`.`emisor_id_canton` AS `emisor_id_canton`, `documentos`.`emisor_id_distrito` AS `emisor_id_distrito`, `documentos`.`emisor_id_barrio` AS `emisor_id_barrio`, `documentos`.`emisor_otras_senas` AS `emisor_otras_senas`, `documentos`.`emisor_cod` AS `emisor_cod`, `documentos`.`emisor_telefono` AS `emisor_telefono`, `documentos`.`emisor_correo` AS `emisor_correo`, `documentos`.`receptor_nombre` AS `receptor_nombre`, `documentos`.`receptor_cedula` AS `receptor_cedula`, `documentos`.`receptor_tipo` AS `receptor_tipo`, `documentos`.`receptor_comercial` AS `receptor_comercial`, `documentos`.`receptor_id_provincia` AS `receptor_id_provincia`, `documentos`.`receptor_id_canton` AS `receptor_id_canton`, `documentos`.`receptor_id_distrito` AS `receptor_id_distrito`, `documentos`.`receptor_id_barrio` AS `receptor_id_barrio`, `documentos`.`receptor_otras_senas` AS `receptor_otras_senas`, `documentos`.`receptor_cod` AS `receptor_cod`, `documentos`.`receptor_telefono` AS `receptor_telefono`, `documentos`.`receptor_correo` AS `receptor_correo`, `documentos`.`condicion_venta` AS `condicion_venta`, `documentos`.`plazo_credito` AS `plazo_credito`, `documentos`.`medio_pago` AS `medio_pago`, `documentos`.`moneda` AS `moneda`, `documentos`.`tipo_cambio` AS `tipo_cambio`, `documentos`.`servicios_gravados` AS `servicios_gravados`, `documentos`.`servicios_exentos` AS `servicios_exentos`, `documentos`.`servicios_exonerados` AS `servicios_exonerados`, `documentos`.`mercancias_gravadas` AS `mercancias_gravadas`, `documentos`.`mercancias_exentas` AS `mercancias_exentas`, `documentos`.`mercancias_exoneradas` AS `mercancias_exoneradas`, `documentos`.`total_gravado` AS `total_gravado`, `documentos`.`total_exento` AS `total_exento`, `documentos`.`total_exonerado` AS `total_exonerado`, `documentos`.`total_venta` AS `total_venta`, `documentos`.`total_descuentos` AS `total_descuentos`, `documentos`.`total_venta_neta` AS `total_venta_neta`, `documentos`.`total_impuestos` AS `total_impuestos`, `documentos`.`total_comprobante` AS `total_comprobante`, `documentos`.`notas` AS `notas`, `documentos`.`id_usuario` AS `id_usuario`, `documentos`.`id_empresa` AS `id_empresa`, `documentos`.`envio_atv` AS `envio_atv`, `documentos`.`valido_atv` AS `valido_atv`, `documentos`.`detalle_atv` AS `detalle_atv`, `documentos`.`correo_enviado` AS `correo_enviado`, `documentos`.`fecha_correo` AS `fecha_correo`, `documentos`.`fecha_envio` AS `fecha_envio`, `documentos`.`fecha_valido` AS `fecha_valido` FROM `documentos` WHERE yearweek(`documentos`.`fecha`,1) = yearweek(current_timestamp() - interval 1 week,1)  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `documentos_view`
--
DROP TABLE IF EXISTS `documentos_view`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `documentos_view`  AS SELECT `documentos`.`id_documento` AS `id_documento`, `documentos`.`consecutivo` AS `consecutivo`, `documentos`.`tipo_documento` AS `tipo_documento`, `documentos`.`clave` AS `clave`, `documentos`.`codigo_seguridad` AS `codigo_seguridad`, `documentos`.`fecha` AS `fecha`, `documentos`.`emisor_cedula` AS `emisor_cedula`, `documentos`.`emisor_nombre` AS `emisor_nombre`, `documentos`.`emisor_tipo` AS `emisor_tipo`, `documentos`.`emisor_comercial` AS `emisor_comercial`, `documentos`.`emisor_id_provincia` AS `emisor_id_provincia`, `documentos`.`emisor_id_canton` AS `emisor_id_canton`, `documentos`.`emisor_id_distrito` AS `emisor_id_distrito`, `documentos`.`emisor_id_barrio` AS `emisor_id_barrio`, `documentos`.`emisor_otras_senas` AS `emisor_otras_senas`, `documentos`.`emisor_cod` AS `emisor_cod`, `documentos`.`emisor_telefono` AS `emisor_telefono`, `documentos`.`emisor_correo` AS `emisor_correo`, `documentos`.`receptor_nombre` AS `receptor_nombre`, `documentos`.`receptor_cedula` AS `receptor_cedula`, `documentos`.`receptor_tipo` AS `receptor_tipo`, `documentos`.`receptor_comercial` AS `receptor_comercial`, `documentos`.`receptor_id_provincia` AS `receptor_id_provincia`, `documentos`.`receptor_id_canton` AS `receptor_id_canton`, `documentos`.`receptor_id_distrito` AS `receptor_id_distrito`, `documentos`.`receptor_id_barrio` AS `receptor_id_barrio`, `documentos`.`receptor_otras_senas` AS `receptor_otras_senas`, `documentos`.`receptor_cod` AS `receptor_cod`, `documentos`.`receptor_telefono` AS `receptor_telefono`, `documentos`.`receptor_correo` AS `receptor_correo`, `documentos`.`condicion_venta` AS `condicion_venta`, `documentos`.`plazo_credito` AS `plazo_credito`, `documentos`.`medio_pago` AS `medio_pago`, `documentos`.`moneda` AS `moneda`, `documentos`.`tipo_cambio` AS `tipo_cambio`, `documentos`.`servicios_gravados` AS `servicios_gravados`, `documentos`.`servicios_exentos` AS `servicios_exentos`, `documentos`.`servicios_exonerados` AS `servicios_exonerados`, `documentos`.`mercancias_gravadas` AS `mercancias_gravadas`, `documentos`.`mercancias_exentas` AS `mercancias_exentas`, `documentos`.`mercancias_exoneradas` AS `mercancias_exoneradas`, `documentos`.`total_gravado` AS `total_gravado`, `documentos`.`total_exento` AS `total_exento`, `documentos`.`total_exonerado` AS `total_exonerado`, `documentos`.`total_venta` AS `total_venta`, `documentos`.`total_descuentos` AS `total_descuentos`, `documentos`.`total_venta_neta` AS `total_venta_neta`, `documentos`.`total_impuestos` AS `total_impuestos`, `documentos`.`total_comprobante` AS `total_comprobante`, `documentos`.`notas` AS `notas`, `documentos`.`id_usuario` AS `id_usuario`, `documentos`.`id_empresa` AS `id_empresa`, `documentos`.`envio_atv` AS `envio_atv`, `documentos`.`valido_atv` AS `valido_atv`, `documentos`.`detalle_atv` AS `detalle_atv`, `documentos`.`correo_enviado` AS `correo_enviado`, `documentos`.`fecha_correo` AS `fecha_correo`, `documentos`.`fecha_envio` AS `fecha_envio`, `documentos`.`fecha_valido` AS `fecha_valido`, to_days(current_timestamp()) - to_days(`documentos`.`fecha`) AS `dias_emitido` FROM `documentos``documentos`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `empresas_view`
--
DROP TABLE IF EXISTS `empresas_view`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `empresas_view`  AS SELECT `e`.`id_empresa` AS `id_empresa`, `e`.`identificacion` AS `identificacion`, `e`.`id_tipo_identificacion` AS `id_tipo_identificacion`, `t`.`tipo_identificacion` AS `tipo_identificacion`, `e`.`razon` AS `razon`, `e`.`razon` AS `nombre`, `e`.`nombre_comercial` AS `nombre_comercial`, `e`.`cod_actividad` AS `cod_actividad`, `e`.`id_ubicacion` AS `id_ubicacion`, `u`.`cod_provincia` AS `cod_provincia`, `u`.`cod_canton` AS `cod_canton`, `u`.`cod_distrito` AS `cod_distrito`, `u`.`cod_barrio` AS `cod_barrio`, `u`.`provincia` AS `provincia`, `u`.`canton` AS `canton`, `u`.`distrito` AS `distrito`, `u`.`barrio` AS `barrio`, `e`.`otras_senas` AS `otras_senas`, `e`.`telefono` AS `telefono`, `e`.`cod_pais` AS `cod_pais`, `c`.`codigo_telefono` AS `codigo_telefono`, `c`.`nombre` AS `nombre_pais`, `e`.`correo` AS `correo`, `e`.`estado` AS `estado` FROM (((`laura_seguridad`.`empresas` `e` join `laura_seguridad`.`tipos_identificaciones` `t` on(`e`.`id_tipo_identificacion` = `t`.`id_tipo_identificacion`)) join `laura_seguridad`.`codigos_paises` `c` on(`e`.`cod_pais` = `c`.`cod_pais`)) join `laura_seguridad`.`ubicaciones` `u` on(`e`.`id_ubicacion` = `u`.`id_ubicacion`))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_inactivos`
--
DROP TABLE IF EXISTS `productos_inactivos`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `productos_inactivos`  AS SELECT `productos`.`id_producto` AS `id_producto`, `productos`.`id_unidad` AS `id_unidad`, `productos`.`unidad_empaque` AS `unidad_empaque`, `productos`.`id_categoria` AS `id_categoria`, `categorias`.`nombre_categoria` AS `nombre_categoria`, `unidades_medida`.`simbolo` AS `simbolo_unidad`, `unidades_medida`.`descripcion` AS `nombre_unidad`, `productos`.`id_empresa` AS `id_empresa`, `productos`.`codigo_cabys` AS `codigo_cabys`, `productos`.`codigo_venta` AS `codigo_venta`, `productos`.`codigo_interno` AS `codigo_interno`, `productos`.`descripcion` AS `descripcion`, `productos`.`impuesto` AS `impuesto`, `productos`.`valor_unitario` AS `valor_unitario`, `productos`.`valor_impuesto` AS `valor_impuesto`, `productos`.`valor_total` AS `valor_total`, `productos`.`descuento` AS `descuento`, `productos`.`porcentaje_descuento` AS `porcentaje_descuento`, `productos`.`fecha_creacion` AS `fecha_creacion`, `productos`.`fecha_modificacion` AS `fecha_modificacion`, `productos`.`fecha_eliminacion` AS `fecha_eliminacion`, `productos`.`estado` AS `estado` FROM ((`productos` join `unidades_medida` on(`productos`.`id_unidad` = `unidades_medida`.`id_unidad`)) join `categorias` on(`productos`.`id_categoria` = `categorias`.`id_categoria`)) WHERE `productos`.`estado` = 0 ORDER BY `productos`.`descripcion` ASC  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_view`
--
DROP TABLE IF EXISTS `productos_view`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `productos_view`  AS SELECT `productos`.`id_producto` AS `id_producto`, `productos`.`id_unidad` AS `id_unidad`, `productos`.`unidad_empaque` AS `unidad_empaque`, `productos`.`id_categoria` AS `id_categoria`, `categorias`.`nombre_categoria` AS `nombre_categoria`, `unidades_medida`.`simbolo` AS `simbolo_unidad`, `unidades_medida`.`descripcion` AS `nombre_unidad`, `productos`.`id_empresa` AS `id_empresa`, `productos`.`codigo_cabys` AS `codigo_cabys`, `productos`.`codigo_venta` AS `codigo_venta`, `productos`.`codigo_interno` AS `codigo_interno`, `productos`.`descripcion` AS `descripcion`, `productos`.`impuesto` AS `impuesto`, `productos`.`valor_unitario` AS `valor_unitario`, `productos`.`valor_impuesto` AS `valor_impuesto`, `productos`.`valor_total` AS `valor_total`, `productos`.`descuento` AS `descuento`, `productos`.`porcentaje_descuento` AS `porcentaje_descuento`, `productos`.`fecha_creacion` AS `fecha_creacion`, `productos`.`fecha_modificacion` AS `fecha_modificacion`, `productos`.`fecha_eliminacion` AS `fecha_eliminacion`, `productos`.`estado` AS `estado` FROM ((`productos` join `unidades_medida` on(`productos`.`id_unidad` = `unidades_medida`.`id_unidad`)) join `categorias` on(`productos`.`id_categoria` = `categorias`.`id_categoria`)) ORDER BY `productos`.`descripcion` ASC  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `reporte_dia`
--
DROP TABLE IF EXISTS `reporte_dia`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reporte_dia`  AS SELECT `reporte_diario`.`fecha_documento` AS `fecha_documento`, `reporte_diario`.`codigo` AS `codigo`, `reporte_diario`.`codigo_venta` AS `codigo_venta`, `reporte_diario`.`unidades` AS `unidades`, `reporte_diario`.`unidad_medida` AS `unidad_medida`, `reporte_diario`.`detalle` AS `detalle`, `reporte_diario`.`precio_unidad` AS `precio_unidad`, `reporte_diario`.`valor_neto` AS `valor_neto`, `reporte_diario`.`valor_subtotal` AS `valor_subtotal`, `reporte_diario`.`valor_impuestos` AS `valor_impuestos`, `reporte_diario`.`valor_total` AS `valor_total`, `reporte_diario`.`dias_emitido` AS `dias_emitido` FROM `reporte_diario` WHERE `reporte_diario`.`dias_emitido` = 00  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `reporte_diario`
--
DROP TABLE IF EXISTS `reporte_diario`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reporte_diario`  AS SELECT cast(`d`.`fecha` as date) AS `fecha_documento`, `l`.`codigo` AS `codigo`, `l`.`codigo_venta` AS `codigo_venta`, sum(`l`.`cantidad`) AS `unidades`, `l`.`unidad_medida` AS `unidad_medida`, `l`.`detalle` AS `detalle`, `l`.`precio_unidad` AS `precio_unidad`, sum(`l`.`monto_total`) AS `valor_neto`, sum(`l`.`sub_total`) AS `valor_subtotal`, sum(`l`.`impuesto_neto`) AS `valor_impuestos`, sum(`l`.`total_linea`) AS `valor_total`, `d`.`dias_emitido` AS `dias_emitido` FROM (`documentos_view` `d` join `documentos_detalles` `l` on(`d`.`id_documento` = `l`.`id_documento`)) GROUP BY cast(`d`.`fecha` as date), `l`.`detalle``detalle`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `reporte_meses`
--
DROP TABLE IF EXISTS `reporte_meses`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reporte_meses`  AS SELECT date_format(`reporte_diario`.`fecha_documento`,'%Y-%m') AS `fecha_documento`, `reporte_diario`.`codigo` AS `codigo`, `reporte_diario`.`codigo_venta` AS `codigo_venta`, sum(`reporte_diario`.`unidades`) AS `unidades`, `reporte_diario`.`unidad_medida` AS `unidad_medida`, `reporte_diario`.`detalle` AS `detalle`, `reporte_diario`.`precio_unidad` AS `precio_unidad`, sum(`reporte_diario`.`valor_neto`) AS `valor_neto`, sum(`reporte_diario`.`valor_subtotal`) AS `valor_subtotal`, sum(`reporte_diario`.`valor_impuestos`) AS `valor_impuestos`, sum(`reporte_diario`.`valor_total`) AS `valor_total`, `reporte_diario`.`dias_emitido` AS `dias_emitido` FROM `reporte_diario` GROUP BY date_format(`reporte_diario`.`fecha_documento`,'%Y-%m'), `reporte_diario`.`detalle``detalle`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `reporte_mes_actual`
--
DROP TABLE IF EXISTS `reporte_mes_actual`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reporte_mes_actual`  AS SELECT date_format(`reporte_diario`.`fecha_documento`,'%Y-%m') AS `fecha_documento`, `reporte_diario`.`codigo` AS `codigo`, `reporte_diario`.`codigo_venta` AS `codigo_venta`, sum(`reporte_diario`.`unidades`) AS `unidades`, `reporte_diario`.`unidad_medida` AS `unidad_medida`, `reporte_diario`.`detalle` AS `detalle`, `reporte_diario`.`precio_unidad` AS `precio_unidad`, sum(`reporte_diario`.`valor_neto`) AS `valor_neto`, sum(`reporte_diario`.`valor_subtotal`) AS `valor_subtotal`, sum(`reporte_diario`.`valor_impuestos`) AS `valor_impuestos`, sum(`reporte_diario`.`valor_total`) AS `valor_total`, `reporte_diario`.`dias_emitido` AS `dias_emitido` FROM `reporte_diario` WHERE date_format(`reporte_diario`.`fecha_documento`,'%Y-%m') = date_format(current_timestamp() - interval 0 month,'%Y-%m') GROUP BY date_format(`reporte_diario`.`fecha_documento`,'%Y-%m'), `reporte_diario`.`detalle``detalle`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `reporte_semana`
--
DROP TABLE IF EXISTS `reporte_semana`;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reporte_semana`  AS SELECT `reporte_diario`.`fecha_documento` AS `fecha_documento`, `reporte_diario`.`codigo` AS `codigo`, `reporte_diario`.`codigo_venta` AS `codigo_venta`, `reporte_diario`.`unidades` AS `unidades`, `reporte_diario`.`unidad_medida` AS `unidad_medida`, `reporte_diario`.`detalle` AS `detalle`, `reporte_diario`.`precio_unidad` AS `precio_unidad`, `reporte_diario`.`valor_neto` AS `valor_neto`, `reporte_diario`.`valor_subtotal` AS `valor_subtotal`, `reporte_diario`.`valor_impuestos` AS `valor_impuestos`, `reporte_diario`.`valor_total` AS `valor_total`, `reporte_diario`.`dias_emitido` AS `dias_emitido` FROM `reporte_diario` WHERE yearweek(cast(`reporte_diario`.`fecha_documento` as date),1) = yearweek(current_timestamp() - interval 0 week,1) GROUP BY yearweek(cast(`reporte_diario`.`fecha_documento` as date),1), `reporte_diario`.`detalle``detalle`  ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_cod_pais` FOREIGN KEY (`cod_pais`) REFERENCES `laura_seguridad`.`codigos_paises` (`cod_pais`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_detalles`
--
ALTER TABLE `documentos_detalles`
  ADD CONSTRAINT `documentos_detalles_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id_documento`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
