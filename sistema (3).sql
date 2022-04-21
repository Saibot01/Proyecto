-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-04-2022 a las 06:01:14
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `borde`
--

CREATE TABLE `borde` (
  `idBorde` int(11) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `borde`
--

INSERT INTO `borde` (`idBorde`, `Descripción`) VALUES
(0, 'Sin Borde'),
(1, 'Con Borde');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `Descripción`) VALUES
(1, 'Gastronomia '),
(2, 'Bebidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `idMarca` int(11) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`idMarca`, `Descripción`) VALUES
(1, 'Pilsen'),
(2, 'Heineken'),
(3, 'Corona');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medida`
--

CREATE TABLE `medida` (
  `idMedida` int(11) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medida`
--

INSERT INTO `medida` (`idMedida`, `Descripción`) VALUES
(1, 'Pequeño'),
(2, 'Mediano'),
(3, 'Grande'),
(4, '250ml'),
(5, '500ml'),
(6, '1litro'),
(7, '1,5 litros'),
(8, '450ml'),
(9, '3/4 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio`
--

CREATE TABLE `precio` (
  `idPrecio` int(10) NOT NULL,
  `Cod_Barra` int(100) DEFAULT NULL,
  `Precio_Bruto` int(100) DEFAULT NULL,
  `Observación` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preciocabecera`
--

CREATE TABLE `preciocabecera` (
  `idPrecio` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Aprobado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones_producto`
--

CREATE TABLE `presentaciones_producto` (
  `idProducto` int(11) DEFAULT NULL,
  `Cod_Barra` int(11) NOT NULL,
  `idMarca` int(11) DEFAULT NULL,
  `idMedida` int(11) DEFAULT NULL,
  `idBorde` int(11) DEFAULT NULL,
  `idSabor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `Producto` varchar(100) DEFAULT NULL,
  `idTipoProducto` int(11) DEFAULT NULL,
  `idSección` int(11) DEFAULT NULL,
  `idSubsección` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `activo` smallint(6) DEFAULT NULL,
  `observación` varchar(500) DEFAULT NULL,
  `impuesto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `Producto`, `idTipoProducto`, `idSección`, `idSubsección`, `idCategoria`, `activo`, `observación`, `impuesto`) VALUES
(1, 'CARAMELO', 1, 1, 1, 1, 1, 'DE MADERA', 10),
(6, 'Hamburguesa Chesse Long', 2, 2, 2, 1, 1, 'Riquisimo', 10),
(7, 'PILSEN LATA FINA', 3, 3, 2, 2, 1, 'Heventema', 10),
(14, 'LOMITO', 2, 2, 2, 1, 1, 'XXL', 10),
(22, 'Pepperoni', 1, 1, 1, 1, 1, 'XXL', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(10) NOT NULL,
  `rol` varchar(23) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sabores`
--

CREATE TABLE `sabores` (
  `IdSabor` int(11) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sabores`
--

INSERT INTO `sabores` (`IdSabor`, `Descripción`) VALUES
(1, 'Pepperoni'),
(2, 'Pollo con Katupiri'),
(3, 'Jamón y Queso'),
(4, 'Carnibora '),
(5, 'Napolitano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sección`
--

CREATE TABLE `sección` (
  `idSección` int(11) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sección`
--

INSERT INTO `sección` (`idSección`, `Descripción`) VALUES
(1, 'Pizza'),
(2, 'Hamburguesa'),
(3, 'Cerveza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subsección`
--

CREATE TABLE `subsección` (
  `idSubSección` int(11) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subsección`
--

INSERT INTO `subsección` (`idSubSección`, `Descripción`) VALUES
(1, 'aaa'),
(2, 'bbb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoproducto`
--

CREATE TABLE `tipoproducto` (
  `idTipoProducto` int(11) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipoproducto`
--

INSERT INTO `tipoproducto` (`idTipoProducto`, `Descripción`) VALUES
(1, 'Pizza'),
(2, 'Hamburguesa'),
(3, 'Cerveza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(100) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `estatus`) VALUES
(1, 'Victor Cardozo', 'vcard@gmail.com', 'Victor', '82233bce59652cf3cc0eb7a03f3109d1', 1, 1),
(2, 'Tobias', 'tobias@gmail.com', 'Tobias', '2d95188a755067ac95e25f90b6e7c1ab', 1, 1),
(3, 'Pepe', 'pepe@gmail.com', 'Pepe', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `borde`
--
ALTER TABLE `borde`
  ADD PRIMARY KEY (`idBorde`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`idMarca`);

--
-- Indices de la tabla `medida`
--
ALTER TABLE `medida`
  ADD PRIMARY KEY (`idMedida`);

--
-- Indices de la tabla `precio`
--
ALTER TABLE `precio`
  ADD PRIMARY KEY (`idPrecio`),
  ADD KEY `fk_codBarra` (`Cod_Barra`);

--
-- Indices de la tabla `preciocabecera`
--
ALTER TABLE `preciocabecera`
  ADD KEY `fk_precio` (`idPrecio`);

--
-- Indices de la tabla `presentaciones_producto`
--
ALTER TABLE `presentaciones_producto`
  ADD PRIMARY KEY (`Cod_Barra`),
  ADD KEY `fk_marca` (`idMarca`),
  ADD KEY `fk_medida` (`idMedida`),
  ADD KEY `fk_Borde` (`idBorde`),
  ADD KEY `fk_Sabor` (`idSabor`),
  ADD KEY `fk_idProducto` (`idProducto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `idProducto` (`idProducto`),
  ADD KEY `fk_Sección` (`idSección`),
  ADD KEY `fk_Subsección` (`idSubsección`),
  ADD KEY `fk_Categoria` (`idCategoria`),
  ADD KEY `fk_tipoProducto` (`idTipoProducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `sabores`
--
ALTER TABLE `sabores`
  ADD PRIMARY KEY (`IdSabor`);

--
-- Indices de la tabla `sección`
--
ALTER TABLE `sección`
  ADD PRIMARY KEY (`idSección`);

--
-- Indices de la tabla `subsección`
--
ALTER TABLE `subsección`
  ADD PRIMARY KEY (`idSubSección`);

--
-- Indices de la tabla `tipoproducto`
--
ALTER TABLE `tipoproducto`
  ADD PRIMARY KEY (`idTipoProducto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `fk_rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `precio`
--
ALTER TABLE `precio`
  ADD CONSTRAINT `fk_codBarra` FOREIGN KEY (`Cod_Barra`) REFERENCES `presentaciones_producto` (`Cod_Barra`);

--
-- Filtros para la tabla `preciocabecera`
--
ALTER TABLE `preciocabecera`
  ADD CONSTRAINT `fk_precio` FOREIGN KEY (`idPrecio`) REFERENCES `precio` (`idPrecio`);

--
-- Filtros para la tabla `presentaciones_producto`
--
ALTER TABLE `presentaciones_producto`
  ADD CONSTRAINT `fk_Borde` FOREIGN KEY (`idBorde`) REFERENCES `borde` (`idBorde`),
  ADD CONSTRAINT `fk_Sabor` FOREIGN KEY (`idSabor`) REFERENCES `sabores` (`IdSabor`),
  ADD CONSTRAINT `fk_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`),
  ADD CONSTRAINT `fk_marca` FOREIGN KEY (`idMarca`) REFERENCES `marca` (`idMarca`),
  ADD CONSTRAINT `fk_medida` FOREIGN KEY (`idMedida`) REFERENCES `medida` (`idMedida`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_Categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `fk_Sección` FOREIGN KEY (`idSección`) REFERENCES `sección` (`idSección`),
  ADD CONSTRAINT `fk_Subsección` FOREIGN KEY (`idSubsección`) REFERENCES `subsección` (`idSubSección`),
  ADD CONSTRAINT `fk_tipoProducto` FOREIGN KEY (`idTipoProducto`) REFERENCES `tipoproducto` (`idTipoProducto`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
