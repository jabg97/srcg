-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2017 a las 02:42:25
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `srcg`
--

DROP DATABASE IF EXISTS `srcg`;
CREATE DATABASE IF NOT EXISTS `srcg` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `srcg`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacios`
--

CREATE TABLE `espacios` (
  `codigo` smallint(5) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacidad` smallint(5) UNSIGNED NOT NULL,
  `zonas` smallint(5) UNSIGNED NOT NULL,
  `filas` smallint(5) UNSIGNED NOT NULL,
  `columnas` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Volcado de datos para la tabla `espacios`
--

INSERT INTO `espacios` (`codigo`, `nombre`, `direccion`, `capacidad`, `zonas`, `filas`, `columnas`) VALUES
(1, 'IMDER PALMIRA', 'CALLE 27 #35-00', 400, 2, 4, 8),
(2, 'TEATRO MATERON', 'PARQUE DE BOLIVAR', 250, 3, 10, 4),
(3, 'CENTRO DE CONVENCIONES', 'LA ESTACION', 200, 2, 4, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultades`
--

CREATE TABLE `facultades` (
  `codigo` smallint(5) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `facultades`
--

INSERT INTO `facultades` (`codigo`, `nombre`, `color`) VALUES
(4, 'INSTITUTOS DE PSICOLOGÍA Y EDUCACIÓN', '#3F51B5'),
(7, 'FACULTAD DE INGENIERÍA', '#FF5722'),
(8, 'FACULTAD DE CIENCIAS DE LA ADMINISTRACIÓN', '#009688');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `graduandos`
--

CREATE TABLE `graduandos` (
  `codigo` bigint(20) UNSIGNED NOT NULL,
  `programa` smallint(5) UNSIGNED DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info`
--

CREATE TABLE `info` (
  `id` tinyint(1) NOT NULL,
  `invitados` smallint(5) UNSIGNED NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechalimite` datetime NOT NULL,
  `fechaevento` datetime NOT NULL,
  `espacio` smallint(5) UNSIGNED NOT NULL,
  `tipo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `info`
--

INSERT INTO `info` (`id`, `invitados`, `password`, `fechalimite`, `fechaevento`, `espacio`, `tipo`) VALUES
(1, 3, '1234', '2017-12-05 00:00:00', '2017-12-09 15:00:00', 3, 1);

--
-- Disparadores `info`
--
DELIMITER $$
CREATE TRIGGER `only_one` BEFORE INSERT ON `info` FOR EACH ROW begin
       DECLARE size TINYINT UNSIGNED;
       SELECT COUNT(id)
       INTO @size
       FROM info;

       IF @size >= 1
       THEN
       SET NEW.id = NULL;
    
        END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitados`
--

CREATE TABLE `invitados` (
  `documento` bigint(20) UNSIGNED NOT NULL,
  `graduando` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asistencia` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `codigo` smallint(5) UNSIGNED NOT NULL,
  `facultad` smallint(5) UNSIGNED DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`codigo`, `facultad`, `nombre`) VALUES
(2710, 7, 'TECNOLOGÍA EN ELECTRÓNICA'),
(2711, 7, 'TECNOLOGÍA EN SISTEMAS DE INFORMACIÓN'),
(2712, 7, 'TECNOLOGÍA EN ALIMENTOS'),
(2716, 7, 'TECNOLOGÍA AGROAMBIENTAL'),
(3461, 4, 'PSICOLOGÍA'),
(3484, 4, 'LICENCIATURA EN EDUCACIÓN FÍSICA Y DEPORTES'),
(3751, 7, 'INGENIERÍA INDUSTRIAL'),
(3841, 8, 'CONTADURÍA PÚBLICA'),
(3845, 8, 'ADMINISTRACIÓN DE EMPRESAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `codigo` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `email`, `rol`, `password`) VALUES
('admin', 'admin@gmail.com', 'ROLE_ADMIN', '$2y$04$HSnpK7VkvQCL.x34ch1XxODJIPIUrCpOBvlW.DILsey3N/q1txSnO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `espacios`
--
ALTER TABLE `espacios`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `UNIQ_CA2517903A909126` (`nombre`),
  ADD UNIQUE KEY `UNIQ_CA251790F384BE95` (`direccion`);

--
-- Indices de la tabla `facultades`
--
ALTER TABLE `facultades`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `UNIQ_FAF914A23A909126` (`nombre`),
  ADD UNIQUE KEY `UNIQ_FAF914A2665648E9` (`color`);

--
-- Indices de la tabla `graduandos`
--
ALTER TABLE `graduandos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `programa` (`programa`);

--
-- Indices de la tabla `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CB8931579894C820` (`invitados`),
  ADD UNIQUE KEY `UNIQ_CB893157BCDC4FD4` (`fechalimite`),
  ADD UNIQUE KEY `UNIQ_CB893157594DC93B` (`fechaevento`),
  ADD UNIQUE KEY `UNIQ_CB89315790BF6AA4` (`espacio`),
  ADD UNIQUE KEY `UNIQ_CB893157702D1D47` (`tipo`),
  ADD UNIQUE KEY `UNIQ_CB89315735C246D5` (`password`);

--
-- Indices de la tabla `invitados`
--
ALTER TABLE `invitados`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `graduando` (`graduando`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `UNIQ_65BD43A23A909126` (`nombre`),
  ADD KEY `facultad` (`facultad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `UNIQ_EF687F2E7927C74` (`email`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `graduandos`
--
ALTER TABLE `graduandos`
  ADD CONSTRAINT `FK_2DAF22522F0140D` FOREIGN KEY (`programa`) REFERENCES `programas` (`codigo`);

--
-- Filtros para la tabla `invitados`
--
ALTER TABLE `invitados`
  ADD CONSTRAINT `FK_9894C820A2A7AFAA` FOREIGN KEY (`graduando`) REFERENCES `graduandos` (`codigo`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `FK_65BD43A2F50454DF` FOREIGN KEY (`facultad`) REFERENCES `facultades` (`codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

