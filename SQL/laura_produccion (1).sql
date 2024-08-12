-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-01-2023 a las 19:30:21
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
-- Base de datos: `laura_produccion`
--
CREATE DATABASE IF NOT EXISTS `laura_produccion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci;
USE `laura_produccion`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_lotes`
--

CREATE TABLE IF NOT EXISTS `detalle_lotes` (
  `id_detalle_lote` int(20) NOT NULL,
  `id_lote` int(20) NOT NULL,
  `id_producto` int(20) NOT NULL,
  `valor_unitario` int(10) NOT NULL,
  `valor_lineal` int(10) NOT NULL,
  `cantidad` double(100,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_productos`
--

CREATE TABLE IF NOT EXISTS `detalle_productos` (
  `id_detalle` int(20) NOT NULL,
  `id_producto` int(20) NOT NULL,
  `id_materia_prima` int(20) NOT NULL,
  `cantidad_requerida` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE IF NOT EXISTS `lotes` (
  `id_lote` int(20) NOT NULL,
  `tipo_lote` varchar(1) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `valor_total` double(40,2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes_compra_view`
--

CREATE TABLE IF NOT EXISTS `lotes_compra_view` (
  `id_lote` int(20) DEFAULT NULL,
  `tipo_lote` varchar(1) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `valor_total` double(40,2) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes_produccion_view`
--

CREATE TABLE IF NOT EXISTS `lotes_produccion_view` (
  `id_lote` int(20) DEFAULT NULL,
  `tipo_lote` varchar(1) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `valor_total` double(40,2) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
