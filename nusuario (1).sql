-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2025 at 02:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nusuario`
--

-- --------------------------------------------------------

--
-- Table structure for table `recuperar`
--

CREATE TABLE `recuperar` (
  `EMAIL` varchar(50) NOT NULL,
  `TOKEN` varchar(50) NOT NULL,
  `CLAVE_NUEVA` int(8) NOT NULL,
  `FECHA_ALTA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registronuevo`
--

CREATE TABLE `registronuevo` (
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registronuevo`
--

INSERT INTO `registronuevo` (`nombre`, `apellido`, `email`, `pass`, `user`) VALUES
('jajaja', 'jujuju', 'jajaju@gmail.com', '$2y$10$2BoE838Edg5wOOYYhDaE3eB/JyqjOjoW/jlzvUsMZ0RfmkLjdqpNO', '1234'),
('uriel el pato', 'blanco', 'patito@gmail.com', '$2y$10$2ZG3PhnYgYDtgiiroMG4SuC8EV9or370kIEU3A6bk6t5c1nEl8ld2', 'pato'),
('guillermo', 'ingrao', 'guillerme7@gmail.com', '$2y$10$adeMlVUtI50YCqH4g4gLtOB07XzGW3Hha/.KOkcpvF8ZN1Ww7eFcS', '1234'),
('dasdasd', 'asdasdas', 'asdasdasd@gmail.com', '$2y$10$Cegq4GXst12v6tw.dkJpg.nC2dIaIz/FFDCpSR4hqyhjDfRSngAky', '1234');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
