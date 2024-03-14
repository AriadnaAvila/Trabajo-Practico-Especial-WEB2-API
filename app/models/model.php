<?php

require_once './config.php';

class Model
{

    protected $db;

    function __construct()
    {
        $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
        $this->deploy();
    }

    function deploy()
    {
        $hashedPass = '$2a$12$Qgr52SZgfwUpRKdD1LAZ.OfjIuYdIsEjeuJ3/.N1jUfrkPtZNN.3e';
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END
  
            -- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-03-2024 a las 00:02:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_tiendaropa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabladetalles`
--

CREATE TABLE `tabladetalles` (
  `id_detalles` int(11) NOT NULL,
  `talle` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `id_prenda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabladetalles`
--

INSERT INTO `tabladetalles` (`id_detalles`, `talle`, `stock`, `categoria`, `id_prenda`) VALUES
(15, 'm', 6, 'remera', 25),
(16, 'l', 8, 'remera', 25),
(17, 's', 6, 'remera', 26),
(18, 'm', 7, 'remera', 26),
(19, 'xl', 3, 'pantalon', 27),
(20, 'l', 9, 'pantalon', 27),
(21, 'xl', 43, 'pantalon', 28),
(22, 'xs', 5, 'pantalon', 28),
(23, 'l', 5, 'buzo', 29),
(24, 'm', 10, 'buzo', 29),
(25, 'xl', 1, 'buzo', 30),
(26, 'l', 3, 'buzo', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablaprendas`
--

CREATE TABLE `tablaprendas` (
  `id_prenda` int(10) NOT NULL,
  `prenda` varchar(50) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `costo` int(10) NOT NULL,
  `rebaja` int(3) NOT NULL,
  `imagen` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tablaprendas`
--

INSERT INTO `tablaprendas` (`id_prenda`, `prenda`, `categoria`, `costo`, `rebaja`, `imagen`) VALUES
(25, 'Remera KOI 2023', 'remera', 12000, 5, '../img/prendas/koi.jpg'),
(26, 'Remera KRÜ 2024', 'remera', 10000, 0, '../img/prendas/kru.jpg'),
(27, 'Pantalon NAVI 2020', 'pantalon', 15000, 25, '../img/prendas/navi.png'),
(28, 'Pantalon KOI 2023', 'pantalon', 15000, 10, '../img/prendas/koi.jpg'),
(29, 'Buzo KOI 2024', 'buzo', 25000, 0, '../img/prendas/koi.jpg'),
(30, 'Buzo MadKat', 'buzo', 40000, 0, '../img/prendas/madkat.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`) VALUES
(1, 'webadmin@demo.com', '$hashedPass');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tabladetalles`
--
ALTER TABLE `tabladetalles`
  ADD PRIMARY KEY (`id_detalles`),
  ADD KEY `id_prenda` (`id_prenda`);

--
-- Indices de la tabla `tablaprendas`
--
ALTER TABLE `tablaprendas`
  ADD PRIMARY KEY (`id_prenda`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tabladetalles`
--
ALTER TABLE `tabladetalles`
  MODIFY `id_detalles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tablaprendas`
--
ALTER TABLE `tablaprendas`
  MODIFY `id_prenda` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tabladetalles`
--
ALTER TABLE `tabladetalles`
  ADD CONSTRAINT `id_prenda` FOREIGN KEY (`id_prenda`) REFERENCES `tablaprendas` (`id_prenda`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



END;
            $this->db->query($sql);
        }
    }
}

?>