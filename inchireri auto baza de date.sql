-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2024 at 08:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inchirieriauto`
--

-- --------------------------------------------------------

--
-- Table structure for table `cereriinchiriere`
--

CREATE TABLE `cereriinchiriere` (
  `id` int(11) NOT NULL,
  `id_utilizator` int(11) DEFAULT NULL,
  `id_masina` int(11) DEFAULT NULL,
  `data_inceput` date NOT NULL,
  `data_sfarsit` date NOT NULL,
  `status` varchar(60) NOT NULL,
  `cost_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cereriinchiriere`
--

INSERT INTO `cereriinchiriere` (`id`, `id_utilizator`, `id_masina`, `data_inceput`, `data_sfarsit`, `status`, `cost_total`) VALUES
(7, 5, NULL, '2024-01-29', '2024-01-31', 'in asteptare', 0.00),
(8, 5, NULL, '2024-01-29', '2024-01-31', 'in asteptare', 0.00),
(9, 5, NULL, '2024-01-29', '2024-01-31', 'in asteptare', 0.00),
(10, 5, NULL, '2024-01-29', '2024-01-31', 'in asteptare', 0.00),
(11, 5, NULL, '2024-01-29', '2024-01-31', 'in asteptare', 0.00),
(12, 5, NULL, '2024-01-29', '2024-01-31', 'in asteptare', 0.00),
(13, 5, NULL, '2024-01-29', '2024-01-31', 'in asteptare', 0.00),
(14, 5, NULL, '2024-01-18', '2024-01-26', 'in asteptare', 0.00),
(15, 5, NULL, '2024-01-18', '2024-01-26', 'in asteptare', 0.00),
(16, 5, NULL, '2024-01-21', '2024-01-24', 'in asteptare', 0.00),
(17, 5, NULL, '2024-01-21', '2024-01-24', 'in asteptare', 0.00),
(18, 5, NULL, '2024-01-17', '2024-01-24', 'in asteptare', 0.00),
(19, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(20, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(21, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(22, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(23, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(24, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(25, 2, NULL, '2022-02-22', '2023-02-25', 'in asteptare', 0.00),
(26, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(27, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(28, 2, NULL, '0000-00-00', '0000-00-00', 'in asteptare', 0.00),
(33, 7, 7, '2024-01-08', '2024-01-13', 'in asteptare', 1800.00),
(34, 7, 8, '2024-01-08', '2024-01-10', 'in asteptare', 1500.00),
(35, 8, 8, '2024-01-23', '2024-01-28', 'aprobat', 3000.00);

-- --------------------------------------------------------

--
-- Table structure for table `clasemasini`
--

CREATE TABLE `clasemasini` (
  `idClasa` int(11) NOT NULL,
  `numeClasa` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clasemasini`
--

INSERT INTO `clasemasini` (`idClasa`, `numeClasa`) VALUES
(1, 'Berlina'),
(2, 'Coupe'),
(3, 'Cabriolet'),
(4, 'Hatchback'),
(5, 'Monovolum'),
(6, 'Pickup'),
(7, 'SUV'),
(8, 'Compacta');

-- --------------------------------------------------------

--
-- Table structure for table `masini`
--

CREATE TABLE `masini` (
  `id` int(11) NOT NULL,
  `marca` varchar(60) NOT NULL,
  `model` varchar(60) NOT NULL,
  `an` int(11) NOT NULL,
  `pret_inchiriere` decimal(10,2) NOT NULL,
  `clasa_id` int(11) DEFAULT NULL,
  `motorizare` varchar(60) DEFAULT NULL,
  `consum` decimal(5,2) DEFAULT NULL,
  `transmisie` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masini`
--

INSERT INTO `masini` (`id`, `marca`, `model`, `an`, `pret_inchiriere`, `clasa_id`, `motorizare`, `consum`, `transmisie`) VALUES
(7, 'Volkswagen', 'Golf', 2019, 300.00, 4, 'Benzina', 10.00, 'Automata'),
(8, 'BMW', 'Seria 5', 2017, 500.00, 1, 'Diesel', 7.00, 'Automata'),
(9, 'Audi', 'Q8', 2019, 800.00, 7, 'Diesel', 12.00, 'Automata'),
(10, 'Volkswagen', 'Passat', 2018, 450.00, 1, 'Diesel', 6.00, 'Manuala'),
(11, 'Opel', 'Astra', 2019, 350.00, 1, 'Benzina', 9.00, 'Manuala'),
(12, 'Skoda', 'Kodiaq', 2019, 550.00, 7, 'Diesel', 9.00, 'Automata'),
(13, 'Audi', 'A8', 2016, 700.00, 1, 'Diesel', 11.00, 'Automata'),
(14, 'Tesla', 'Model Y', 2022, 750.00, 4, 'Electric', 0.00, 'Automata'),
(15, 'Merecedes-Benz', 'C63 AMG', 2012, 1000.00, 2, 'Benzina', 20.00, 'Automata'),
(16, 'Mercedes-Benz', 'T', 2022, 600.00, 5, 'Diesel', 10.00, 'Automata');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `parola` varchar(60) NOT NULL,
  `este_admin` tinyint(4) DEFAULT 0,
  `nume` varchar(60) DEFAULT NULL,
  `prenume` varchar(60) DEFAULT NULL,
  `cnp` varchar(60) DEFAULT NULL,
  `data_nasterii` date DEFAULT NULL,
  `numar_permis` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `username`, `parola`, `este_admin`, `nume`, `prenume`, `cnp`, `data_nasterii`, `numar_permis`) VALUES
(1, 'test22', '$2y$10$kqb1Q0rW4qcuXgGIRdK85eV28PZqPxP9me9FtiGyWqWuNhsGGE0G2', 0, NULL, NULL, NULL, NULL, NULL),
(2, 'test1234', '$2y$10$SjxKQzha2iiZRqCJXAyPguA6N9fX3zIOrlpbPR9nMpZNlOn5QWus6', 1, 'Gica ', 'Gica', '123345634567432', '2019-02-28', 'G2145521352'),
(3, 'testare', '$2y$10$GE8b.SVV.kPXmwAG5SehjuzLBlrhSLC4J2KY.Hte398nWix0wruCm', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'testare', '$2y$10$pXjb/ry6lNgzY8VliFzf7epso34fV1sVePruesTgMd0QW9qjVxb4C', 0, NULL, NULL, NULL, NULL, NULL),
(5, 'Gica', '$2y$10$ug7p2Y6OUdpFK014.0BwpOdlAnS2pTG7jz/LNcQw8Y8GI4yiHs.gS', 0, 'Test', 'Muschi', '93533242142141242', '1994-07-05', 'b9742108947091'),
(6, 'testtt', '$2y$10$7LMImpO1CmEKywUPIgJf6O1hz7nlpiSQJI4sgkBIDiIi7z4crQRpK', 0, NULL, NULL, NULL, NULL, NULL),
(7, 'testt12', '$2y$10$JHxTGOw3zc7oPBfabWV/CunMteOHsg0PjmTYLKkzOGMr2xPUN5knO', 0, 'Gigel', 'Ionel', '1853524212222222', '1990-01-30', 'B95031'),
(8, 'remus', '$2y$10$hGG8hWHweHaRIk6PNTNnh.f2u8NI3heFvY2BL7.iYkgxzropEfZYK', 1, 'Popescu', 'Remus', '5020423100542', '2002-06-19', 'DB184242');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cereriinchiriere`
--
ALTER TABLE `cereriinchiriere`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilizator` (`id_utilizator`),
  ADD KEY `id_masina` (`id_masina`);

--
-- Indexes for table `clasemasini`
--
ALTER TABLE `clasemasini`
  ADD PRIMARY KEY (`idClasa`);

--
-- Indexes for table `masini`
--
ALTER TABLE `masini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clasa_id` (`clasa_id`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cereriinchiriere`
--
ALTER TABLE `cereriinchiriere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `clasemasini`
--
ALTER TABLE `clasemasini`
  MODIFY `idClasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `masini`
--
ALTER TABLE `masini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cereriinchiriere`
--
ALTER TABLE `cereriinchiriere`
  ADD CONSTRAINT `cereriinchiriere_ibfk_1` FOREIGN KEY (`id_utilizator`) REFERENCES `utilizatori` (`id`),
  ADD CONSTRAINT `cereriinchiriere_ibfk_2` FOREIGN KEY (`id_masina`) REFERENCES `masini` (`id`);

--
-- Constraints for table `masini`
--
ALTER TABLE `masini`
  ADD CONSTRAINT `masini_ibfk_1` FOREIGN KEY (`clasa_id`) REFERENCES `clasemasini` (`idClasa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
