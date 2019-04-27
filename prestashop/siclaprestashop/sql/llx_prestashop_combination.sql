-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-04-2019 a las 21:04:26
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ng902`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llx_prestashop_combination`
--

DROP TABLE IF EXISTS `llx_prestashop_combination`;
CREATE TABLE IF NOT EXISTS `llx_prestashop_combination` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `sicla_id` int(11) NOT NULL,
  `presta_id` int(11) NOT NULL,
  `valor` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`rowid`),
  UNIQUE KEY `unico` (`valor`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `llx_prestashop_combination`
--

INSERT INTO `llx_prestashop_combination` (`rowid`, `sicla_id`, `presta_id`, `valor`) VALUES
(1, 1, 127, 'AMARILLO\n'),
(2, 2, 128, 'AZUL CLARO\n'),
(3, 3, 129, 'AZUL\n'),
(4, 4, 130, 'BLANCO\n'),
(5, 5, 131, 'KHAKI\n'),
(6, 6, 132, 'MARINO\n'),
(7, 7, 133, 'NARANJA\n'),
(8, 8, 134, 'NEGRO\n'),
(9, 9, 135, 'ROJO\n'),
(10, 10, 136, 'VERDE OSCURO\n'),
(11, 11, 137, 'VERDE\n'),
(12, 12, 138, 'PLATEADO\n'),
(13, 13, 139, 'BURDEOS\n'),
(14, 14, 140, 'MARRON\n'),
(15, 15, 141, 'GRIS\n'),
(16, 16, 142, 'FUCSIA\n'),
(17, 17, 143, 'AZUL ROYAL\n'),
(18, 18, 144, 'TRANSPARENTE\n'),
(19, 19, 145, 'DORADO\n'),
(20, 20, 146, 'ROSA\n'),
(21, 21, 147, 'ESPAÑA\n'),
(22, 22, 148, 'FRANCIA\n'),
(23, 23, 149, 'ITALIA\n'),
(24, 24, 150, 'PORTUGAL\n'),
(25, 25, 151, 'NATURAL\n'),
(26, 26, 152, 'BEIG\n'),
(27, 27, 153, 'BLANCO / AZUL\n'),
(28, 28, 154, 'BLANCO / ROJO\n'),
(29, 29, 155, 'BLANCO / AMARILLO\n'),
(30, 30, 156, 'BLANCO / VERDE\n'),
(31, 31, 157, 'VERDE CLARO\n'),
(32, 32, 158, 'MANZANA\n'),
(33, 33, 159, 'MELON\n'),
(34, 34, 160, 'TOMATE\n'),
(35, 35, 161, 'FRESA\n'),
(36, 36, 162, 'KIWI\n'),
(37, 37, 163, 'PIÑA\n'),
(38, 38, 164, 'UVA\n'),
(39, 39, 165, 'PISTACHO\n'),
(40, 40, 166, 'AMARILLO / BLANCO\n'),
(41, 41, 167, 'AZUL / BLANCO\n'),
(42, 42, 168, 'NEGRO/BLANCO\n'),
(43, 43, 169, 'ROJO / AMARILLO\n'),
(44, 44, 170, 'ROJO / BLANCO\n'),
(45, 45, 171, 'VERDE / BLANCO\n'),
(46, 46, 172, 'IU\n'),
(47, 47, 173, 'PP\n'),
(48, 48, 174, 'PSOE\n'),
(49, 49, 175, 'ESPAÑA / BRONCE\n'),
(50, 50, 176, 'ESPAÑA / ORO\n'),
(51, 51, 177, 'ESPAÑA / PLATEADO\n'),
(52, 52, 178, 'ROJO / BRONCE\n'),
(53, 53, 179, 'ROJO / ORO\n'),
(54, 54, 180, 'ROJO / PLATA\n'),
(55, 55, 181, 'TIPO A\n'),
(56, 56, 182, 'TIPO B\n'),
(57, 57, 183, 'AMARILLO FLUOR\n'),
(58, 58, 184, 'BLANCO / NEGRO\n'),
(59, 59, 185, 'LIMON\n'),
(60, 60, 186, 'SANDIA\n'),
(61, 61, 187, 'OCEANO\n'),
(62, 62, 188, 'VAINILLA\n'),
(63, 63, 189, 'NARANJA FLUOR\n'),
(64, 64, 190, 'PLATEADO / AZUL\n'),
(65, 65, 191, 'PLATA / NARANJA\n'),
(66, 66, 192, 'PLATA / NEGRO\n'),
(67, 67, 193, 'PLATEADO / ROJO\n'),
(68, 68, 194, 'BLANCO / GRIS\n'),
(69, 69, 195, 'BLANCO / FUCSIA\n'),
(70, 70, 196, 'BLANCO / NARANJA\n'),
(71, 71, 197, 'CISNE\n'),
(72, 72, 198, 'GATO\n'),
(73, 73, 199, 'TRASLUCIDO AZUL\n'),
(74, 74, 200, 'TRASLUCIDO ROJO\n'),
(75, 75, 201, 'FUCSIA FLUOR\n'),
(76, 76, 202, 'VERDE FLUOR\n'),
(77, 77, 203, 'PLATANO\n'),
(78, 78, 204, 'TRASLUCIDO AMARILLO\n'),
(79, 79, 205, 'TRASLUCIDO BLANCO\n'),
(80, 80, 206, 'TRASLUCIDO FUCSIA\n'),
(81, 81, 207, 'TRASLUCIDO NARANJA\n'),
(82, 82, 208, 'TRASLUCIDO VERDE\n'),
(83, 83, 209, 'TRASLUCIDO NEGRO\n'),
(84, 84, 210, 'GRIS / AMARILLO\n'),
(85, 85, 211, 'GRIS / AZUL\n'),
(86, 86, 212, 'GRIS / ROJO\n'),
(87, 87, 213, 'GRIS / VERDE\n'),
(88, 88, 214, 'TIPO C\n'),
(89, 89, 215, 'TIPO D\n'),
(90, 90, 216, 'GRIS / NARANJA\n'),
(91, 91, 217, 'GRIS / NEGRO\n'),
(92, 92, 218, 'ARBOL\n'),
(93, 93, 219, 'PAPA NOEL\n'),
(94, 94, 220, 'LIMA\n'),
(95, 95, 221, 'MARRÓN CLARO\n'),
(96, 96, 222, 'MARRÓN OSCURO\n'),
(97, 97, 223, 'PERA\n'),
(98, 98, 224, 'PERRO\n'),
(99, 100, 226, 'CERDO\n'),
(100, 101, 227, 'TROFEO\n'),
(101, 102, 228, 'GOLF\n'),
(102, 103, 229, 'TENIS\n'),
(103, 104, 230, 'FUTBOL\n'),
(104, 105, 231, 'ATLETISMO\n'),
(105, 106, 232, 'PADEL\n'),
(106, 107, 233, 'DORADO / PLATEADO\n'),
(107, 108, 234, 'NEGRO / GRIS\n'),
(108, 109, 235, 'BALONCESTO\n'),
(109, 110, 236, 'RUGBY\n'),
(110, 111, 237, 'CORAZÓN\n'),
(111, 112, 238, 'GAFAS\n'),
(112, 113, 239, 'GUIÑO\n'),
(113, 114, 240, 'SONRISA\n'),
(114, 115, 241, 'ALEMANIA'),
(115, 116, 242, 'ANDALUCIA'),
(116, 117, 243, 'PAISES BAJOS'),
(117, 118, 244, 'OSO\n'),
(118, 119, 245, 'A / FELIZ NAVIDAD'),
(119, 120, 246, 'B / ARBOL'),
(120, 121, 247, 'C / DECORACIÓN'),
(121, 122, 248, 'GRIS OSCURO'),
(122, 123, 249, 'PLATA MATE\n'),
(123, 124, 250, 'MARINO OSCURO'),
(124, 125, 251, 'VERDE BOTELLA'),
(125, 127, 253, 'ESTRELLA\n'),
(126, 128, 254, 'FLOR\n'),
(127, 129, 255, 'NUBE\n'),
(128, 130, 256, 'AMARILLO / MARINO\n'),
(129, 131, 257, 'AZUL / NATURAL\n'),
(130, 132, 258, 'KAKI / MARINO\n'),
(131, 133, 259, 'MARINO / KAKI\n'),
(132, 134, 260, 'NATURAL / MARINO\n'),
(133, 135, 261, 'NARANJA / NATURAL\n'),
(134, 136, 262, 'NEGRO / NATURAL\n'),
(135, 137, 263, 'ROJO / NATURAL\n'),
(136, 138, 264, 'VERDE / NATURAL\n'),
(137, 139, 265, 'BLANCO / MARINO\n'),
(138, 140, 266, 'NARANJA / BLANCO\n'),
(139, 141, 267, 'AZUL / NEGRO\n'),
(140, 142, 268, 'MARINO / ROJO\n'),
(141, 143, 269, 'NARANJA / NEGRO\n'),
(142, 144, 270, 'NEGRO / NEGRO\n'),
(143, 145, 271, 'ROJO / MARINO\n'),
(144, 146, 272, 'VERDE / NEGRO\n'),
(145, 147, 273, 'TRANSP / AMARILLO\n'),
(146, 148, 274, 'TRANSP / AZUL\n'),
(147, 149, 275, 'TRANSP / ROJO\n'),
(148, 150, 276, 'BEIGE / NEGRO\n'),
(149, 151, 277, 'MARINO / NEGRO\n'),
(150, 152, 278, 'ROJO / NEGRO\n'),
(151, 153, 279, 'AMARILLO / NATURAL\n'),
(152, 154, 280, 'NATURAL / NEGRO\n');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
