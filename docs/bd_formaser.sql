-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2024 a las 18:40:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_formaser`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_aprendiz`
--

CREATE TABLE `cursos_aprendiz` (
  `Id` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `inscripcion` date NOT NULL,
  `ficha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos_aprendiz`
--

INSERT INTO `cursos_aprendiz` (`Id`, `documento`, `inscripcion`, `ficha`) VALUES
(1, 1234567878, '2024-04-18', 2941210),
(2, 12345, '2024-04-18', 444431),
(3, 1234567878, '2024-04-18', 444431),
(4, 1234567878, '2024-04-18', 2941210),
(5, 12345, '2024-04-18', 2941210),
(6, 1, '2024-04-18', 2941210),
(7, 1145, '2024-04-18', 2941210),
(8, 5523, '2024-04-18', 2941210),
(9, 1234567878, '2024-04-18', 2941210),
(10, 12345, '2024-04-18', 2941210),
(11, 1, '2024-04-18', 2941210),
(12, 1145, '2024-04-18', 2941210),
(13, 5523, '2024-04-18', 2941210),
(14, 10101, '2024-04-18', 2941210),
(15, 80, '2024-04-18', 2941210),
(16, 1, '2024-04-18', 444431),
(17, 1145, '2024-04-18', 444431),
(18, 5523, '2024-04-18', 444431),
(19, 10101, '2024-04-18', 444431),
(20, 80, '2024-04-18', 444431),
(27, 100, '2024-04-18', 2941210),
(28, 100, '2024-04-18', 444431);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `ficha` int(11) NOT NULL,
  `nombre_curso` varchar(1000) NOT NULL,
  `fecha_inicio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`ficha`, `nombre_curso`, `fecha_inicio`) VALUES
(123, 'Hace algo', '2024-04-20'),
(5532, 'wa', '2024-04-20'),
(43335, 'COMPORTAMIENTO EMPRENDEDOR', '2024-04-20'),
(444431, 'Hola', '2024-04-18'),
(2941210, 'COMPORTAMIENTO EMPRENDEDO', '2024-04-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nombre_funcionario` varchar(250) NOT NULL,
  `apellido_funcionario` varchar(250) NOT NULL,
  `pass_funcionario` varchar(250) NOT NULL,
  `rol_funcionario` varchar(11) NOT NULL,
  `estado_funcionario` int(3) NOT NULL DEFAULT 1,
  `documento_funcionario` int(20) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nombre_funcionario`, `apellido_funcionario`, `pass_funcionario`, `rol_funcionario`, `estado_funcionario`, `documento_funcionario`) VALUES
(1, 'Javier', 'Serna', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Funcionario', 1, 12345);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresados`
--

CREATE TABLE `ingresados` (
  `id_ingresado` int(11) NOT NULL,
  `nombre_completo` varchar(250) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `ficha` int(11) NOT NULL,
  `estado` varchar(200) NOT NULL,
  `documento` int(11) NOT NULL,
  `tipo_documento` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingresados`
--

INSERT INTO `ingresados` (`id_ingresado`, `nombre_completo`, `fecha_ingreso`, `ficha`, `estado`, `documento`, `tipo_documento`) VALUES
(1, 'JUAN CAMILO VANEGAS GONZALEZ', '2024-04-11', 2941210, 'Matriculado', 1234567878, 'CC'),
(5, 'Holas', '2024-04-18', 2941210, 'Matriculado', 12345, 'CC'),
(7, 'dfgdf', '2024-04-18', 2941210, 'Matriculado', 1, 'CC'),
(8, 'wa', '2024-04-18', 2941210, 'Preinscrito', 24, 'CC'),
(9, 'sadafasf', '2024-04-18', 2941210, 'Preinscrito', 3422, 'CC'),
(10, 'fghrt', '2024-04-18', 2941210, 'Matriculado', 1145, 'CC'),
(11, 'tumgh', '2024-04-18', 2941210, 'Matriculado', 5523, 'CC'),
(12, 'En espera...', '2024-04-18', 2941210, 'Primera inscripción', 123, 'CC'),
(13, 'Hola mundo', '2024-04-18', 2941210, 'Matriculado', 10101, 'CC'),
(14, 'JUAN CAMILO VANEGAS GONZÁLEZ', '2024-04-18', 2941210, 'Preinscrito', 80, 'CC'),
(17, 'asfasf', '2024-04-18', 2941210, 'Primera inscripción', 34, 'CC'),
(18, 'JUAN CAMILO VANEGAS GONZÁLEZ', '2024-04-18', 444431, 'Preinscrito', 80, 'CC'),
(19, 'fdggerge', '2024-04-18', 2941210, 'Matriculado', 100, 'CC'),
(20, 'fdggerge', '2024-04-18', 444431, 'Matriculado', 100, 'CC'),
(21, 'En espera...', '2024-04-20', 123, 'Preinscrito', 123987, 'CC'),
(22, 'En espera...', '2024-04-20', 444431, 'Preinscrito', 987, 'CC'),
(23, 'Hector', '2024-04-20', 2941210, 'Preinscrito', 987654, 'CC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos_aprendiz`
--
ALTER TABLE `cursos_aprendiz`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`ficha`);

--
-- Indices de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingresados`
--
ALTER TABLE `ingresados`
  ADD PRIMARY KEY (`id_ingresado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos_aprendiz`
--
ALTER TABLE `cursos_aprendiz`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ingresados`
--
ALTER TABLE `ingresados`
  MODIFY `id_ingresado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cursos_aprendiz`
--
ALTER TABLE `cursos_aprendiz`
  ADD CONSTRAINT `cursos_aprendiz_ibfk_1` FOREIGN KEY (`ficha`) REFERENCES `fichas` (`ficha`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
