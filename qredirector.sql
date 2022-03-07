-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-03-2022 a las 20:44:19
-- Versión del servidor: 10.3.34-MariaDB-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `qredirector`
--
CREATE DATABASE IF NOT EXISTS `qredirector` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `qredirector`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

DROP TABLE IF EXISTS `ubicaciones`;
CREATE TABLE `ubicaciones` (
  `id` int(11) NOT NULL,
  `ubicacion` varchar(48) NOT NULL,
  `id_padre` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `ubicacion`, `id_padre`) VALUES
(1, '(raiz)', NULL),
(2, 'Cuba', 1),
(3, 'Camagüey', 2),
(4, 'IPVCE Máximo Gómez Báez', 3),
(5, 'IPVCE', 4),
(6, 'IPU', 4),
(7, 'IPI', 4),
(8, 'Dirección IPI', 7),
(9, 'Departamento de F. Técnica', 7),
(14, 'Laboratorio 5', 7),
(15, 'Laboratorio 6', 7),
(16, 'Dirección IPU', 6),
(17, 'Unidad Presupuestada', 4),
(18, 'Dirección General', 4),
(19, 'Laboratorio 1', 5),
(20, 'Laboratorio 2', 5),
(21, 'Laboratorio 3', 5),
(22, 'Laboratorio 4', 7),
(23, 'Laboratorio 8', 7),
(24, 'Laboratorio 10', 6),
(25, 'Secretaría Docente IPI', 7),
(26, 'Subdirección IPI', 7),
(27, 'Secretaría Docente IPU', 6),
(28, 'Subdirección Docente IPU', 6),
(29, 'Dirección IPVCE', 5),
(30, 'Secretaría Docente IPVCE', 5),
(31, 'Almacén de Ocio', 4),
(32, 'Almacén', 4),
(33, 'ATM', 17),
(34, 'Aula Tecnológica', 5),
(36, 'CDIP', 5),
(37, 'Contabilidad', 17),
(39, 'Estadística', 17),
(40, 'Inversiones', 17),
(42, 'Laboratorio de Concursos', 5),
(43, 'Laboratorio de Profesores', 5),
(44, 'Tecnología Educativa', 18),
(45, 'Nodo', 44),
(46, 'OTS', 17),
(47, 'Protocolo', 18),
(48, 'Secretaría General', 18),
(49, 'Subdirección Administrativa', 17),
(50, 'Subdirección General', 18),
(51, 'COPEXTEL', 4),
(52, 'Aulas IPI', 7),
(53, 'Aula 1', 52),
(54, 'Aula 2', 52),
(55, 'Aula 3', 52),
(56, 'Jose Manuel', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos`
--

DROP TABLE IF EXISTS `codigos`;
CREATE TABLE `codigos` (
  `id` varchar(6) NOT NULL,
  `url_code` varchar(255) NOT NULL,
  `id_ubicacion` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `hits` int(11) NOT NULL DEFAULT 0,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `codigos`
--

INSERT INTO `codigos` (`id`, `url_code`, `id_ubicacion`, `activo`, `hits`, `file`) VALUES
('dir001', 'https://www.facebook.com/generalisimoIPVCE', 18, 1, 3, NULL),
('ipi001', 'https://www.facebook.com/ipicamaguey', 55, 1, 8, NULL),
('ipi002', 'https://www.facebook.com/ipicamaguey', 54, 1, 2, NULL),
('ipi003', 'https://www.facebook.com/ipicamaguey', 53, 1, 9, NULL),
('ipi004', 'https://r.kboom.nat.cu/admin/dashboard/files/Informe-Notas.pdf', 22, 1, 3, NULL),
('ipi005', 'https://www.facebook.com/ipicamaguey/', 26, 1, 4, NULL),
('ipi006', 'https://r.kboom.nat.cu/admin/dashboard/files/Informe-Notas.pdf', 25, 1, 6, NULL),
('ipi007', 'https://www.facebook.com/ipicamaguey/', 8, 1, 3, NULL),
('ipi008', 'https://r.kboom.nat.cu/admin/dashboard/files/Informe-Notas.pdf', 15, 1, 10, NULL),
('ipi009', 'https://r.kboom.nat.cu/admin/dashboard/files/Informe-Notas.pdf', 14, 1, 4, NULL),
('ipi010', 'https://encuestas.kboom.nat.cu/index.php/727874?lang=es', 9, 1, 2, NULL),
('ipu005', 'https://encuestas.kboom.nat.cu/index.php/727874?lang=es', 16, 1, 2, NULL),
('jms001', 'https://ia.josemanuel.top.mx', 56, 1, 0, NULL),
('tec001', 'https://encuestas.kboom.nat.cu/index.php/727874?lang=es', 44, 1, 15, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `clave` varchar(40) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 30,
  `id_ubicacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `clave`, `admin`, `id_ubicacion`) VALUES
(1, 'admin', 'Administrador general', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1),
(2, 'ebm', 'Enmanuel Basulto Martínez', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 4),
(3, 'yaimelgl', 'Yaimel', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ubicacion` (`ubicacion`),
  ADD KEY `id_padre` (`id_padre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `id_ubicacion` (`id_ubicacion`);

--
-- Indices de la tabla `codigos`
--
ALTER TABLE `codigos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ubicacion` (`id_ubicacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
  

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD CONSTRAINT `ubicaciones_ibfk_1` FOREIGN KEY (`id_padre`) REFERENCES `ubicaciones` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicaciones` (`id`);

--
-- Filtros para la tabla `codigos`
--
ALTER TABLE `codigos`
  ADD CONSTRAINT `codigos_ibfk_1` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicaciones` (`id`);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
