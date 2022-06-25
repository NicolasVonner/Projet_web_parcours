-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql-fastadventure.alwaysdata.net
-- Generation Time: Jun 25, 2022 at 10:43 PM
-- Server version: 10.6.7-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fastadventure_cnam`
--

-- --------------------------------------------------------

--
-- Table structure for table `activite`
--

CREATE TABLE `activite` (
  `codeAct` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `activiteType` varchar(255) DEFAULT NULL,
  `activite` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `activite`
--

INSERT INTO `activite` (`codeAct`, `position`, `activiteType`, `activite`) VALUES
(44, 207, 'jeu_texte', 53),
(43, 207, 'jeu_texte', 52),
(42, 206, 'jeu_texte', 51),
(41, 205, 'jeu_texte', 50),
(40, 204, 'jeu_texte', 49),
(39, 203, 'jeu_texte', 48),
(38, 203, 'jeu_texte', 47),
(45, 209, 'jeu_texte', 54);

-- --------------------------------------------------------

--
-- Table structure for table `equipe`
--

CREATE TABLE `equipe` (
  `id` int(11) NOT NULL,
  `nomE` varchar(255) DEFAULT NULL,
  `dateCrea` date DEFAULT NULL,
  `chef` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `historique_parcour`
--

CREATE TABLE `historique_parcour` (
  `joueur` int(11) NOT NULL,
  `parcour` int(11) NOT NULL,
  `step` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `historique_parcour`
--

INSERT INTO `historique_parcour` (`joueur`, `parcour`, `step`, `position`, `time`) VALUES
(17, 107, 3, 205, '2022-06-25 10:56:13'),
(17, 107, 2, 204, '2022-06-25 10:56:08'),
(17, 107, 1, 203, '2022-06-25 10:56:04'),
(17, 107, 5, 207, '2022-06-24 01:35:36'),
(17, 107, 4, 206, '2022-06-24 01:35:30'),
(17, 107, 3, 205, '2022-06-24 01:35:26'),
(17, 107, 2, 204, '2022-06-24 01:35:23'),
(17, 107, 1, 203, '2022-06-24 01:35:20'),
(17, 107, 5, 207, '2022-06-24 01:34:17'),
(17, 107, 4, 206, '2022-06-24 01:34:10'),
(17, 107, 3, 205, '2022-06-24 01:34:07'),
(17, 107, 2, 204, '2022-06-24 01:34:02'),
(17, 107, 1, 203, '2022-06-24 01:26:21'),
(17, 107, 5, 207, '2022-06-24 01:21:08'),
(17, 107, 4, 206, '2022-06-24 01:20:53'),
(17, 107, 3, 205, '2022-06-24 01:20:42'),
(17, 107, 2, 204, '2022-06-24 01:20:36'),
(17, 107, 1, 203, '2022-06-24 01:20:29'),
(17, 107, 5, 207, '2022-06-25 14:32:39'),
(17, 107, 4, 206, '2022-06-25 14:32:32'),
(17, 107, 3, 205, '2022-06-25 14:32:27'),
(17, 107, 2, 204, '2022-06-25 14:32:22'),
(17, 107, 1, 203, '2022-06-25 14:32:17'),
(17, 107, 5, 207, '2022-06-25 10:56:26'),
(17, 107, 4, 206, '2022-06-25 10:56:17'),
(17, 107, 1, 203, '2022-06-25 14:56:52'),
(17, 107, 2, 204, '2022-06-25 14:56:57'),
(17, 107, 3, 205, '2022-06-25 14:57:01'),
(17, 107, 4, 206, '2022-06-25 14:57:04'),
(17, 107, 5, 207, '2022-06-25 14:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `jeu_image`
--

CREATE TABLE `jeu_image` (
  `id` int(11) NOT NULL,
  `refImage` int(11) DEFAULT NULL,
  `reponse` varchar(255) DEFAULT NULL,
  `indice` varchar(255) DEFAULT NULL,
  `choix_1` varchar(255) DEFAULT NULL,
  `choix_2` varchar(255) DEFAULT NULL,
  `choix_3` varchar(255) DEFAULT NULL,
  `choix_4` varchar(255) DEFAULT NULL,
  `choix_5` varchar(255) NOT NULL,
  `choix_6` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `jeu_texte`
--

CREATE TABLE `jeu_texte` (
  `id` int(11) NOT NULL,
  `devinette` varchar(255) DEFAULT NULL,
  `reponse` varchar(255) DEFAULT NULL,
  `indice` varchar(255) DEFAULT NULL,
  `choix_1` varchar(255) DEFAULT NULL,
  `choix_2` varchar(255) DEFAULT NULL,
  `choix_3` varchar(255) DEFAULT NULL,
  `choix_4` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `jeu_texte`
--

INSERT INTO `jeu_texte` (`id`, `devinette`, `reponse`, `indice`, `choix_1`, `choix_2`, `choix_3`, `choix_4`) VALUES
(44, '1   40 ', '41', '', '40', '41', '40.5', ''),
(45, '8 8', '16', 'Les maths ...', '17', '16', '15', ''),
(38, 'Comment s\'appel le président Francais ?', 'Macron', 'Manu ...', 'Macron', 'Brigitte', 'Chirac', 'Diablo x9'),
(37, '0 1 2 4 8 16 32 64 ?', '128', 'Binaire', '128', '124', '', 'Continue sans moi.'),
(40, 'Un pentagone à combien de cotés ?', '5', 'USA ...', '14', '5', '', ''),
(41, 'Evolution de pikatchu ?', 'Raichu', '', 'Raichu', 'mewtoo', 'carapuce', ''),
(46, '1', 'E', 'Ee', 'E', 'Ee', 'Ee', 'Eee'),
(47, 'Qui est le president de la république?', 'Macron', 'Brigitte ...', 'Macron', 'Gandalf', 'pinocchio', 'Marine LE PEN'),
(48, 'Combien fait 2 * 2?', '4', 'Réfléchis ...', '1', '3', '3', '4'),
(49, '1   1', '2', '', '1', '2', '', ''),
(50, 'Combien de coupe du monde de football à la france', '2', '98 ... et ?', '2', '3', '1', ''),
(51, '2 4 8 16 32 64 128 256 ?', '512', '', '1024', '765', '512', ''),
(52, 'Pokemon foudre de sacha ...', 'Pikatchu', '', 'Picatchu', 'Pikatchu', 'Piquatchu', 'Elector'),
(53, '6*8', '48', '', '56', '35', '48', '46'),
(54, 'test', 'a', 'a', 'd', 'a', 'c', 'b');

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

CREATE TABLE `membre` (
  `codeM` int(11) NOT NULL,
  `nomM` varchar(255) DEFAULT NULL,
  `prenomM` varchar(255) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `adresseMail` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dateInscription` date DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `avatar` varchar(25) NOT NULL,
  `equipe` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`codeM`, `nomM`, `prenomM`, `username`, `adresseMail`, `password`, `dateInscription`, `dateNaissance`, `avatar`, `equipe`, `token`) VALUES
(17, 'Vonner', 'Nicolas', 'Mkalonis', 'nicolas.vonner@icloud.com', '$2y$10$kExBfRpC5yOXILIKrfret.tvlioVTumHDe9q.wMWTKaKZCPIeFupu', '2022-05-23', '1996-09-18', 'face15.jpg', NULL, '628e48a0b2913'),
(23, 'Prof', 'AdminCnam', 'AdminCnam', 'AdimCnam@vivelecnam.net', '$2y$10$Wt06DatQ3sRUX2wzuJZKlOghFY2R6RkqtdNaGqDeQ8iYJmmJPJQbW', '2022-06-25', '2018-07-22', 'face8.jpg', NULL, NULL),
(22, 'LAMÉ', 'Adrien', 'alame122', 'adri04.ml@gmail.com', '$2y$10$c1x9stkiSxRXvuRn5NJI7OhkDTY/.XaZWup.rlwR84ubm7E3naVm2', '2022-06-25', '2018-10-30', 'face8.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `codePa` int(11) NOT NULL,
  `codeM` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  `dateN` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`codePa`, `codeM`, `note`, `commentaire`, `dateN`) VALUES
(107, 17, 5, 'azaze', '2022-06-25 14:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `parcour`
--

CREATE TABLE `parcour` (
  `codePa` int(11) NOT NULL,
  `createur` int(11) DEFAULT NULL,
  `nomPa` varchar(255) DEFAULT NULL,
  `descriptionPa` text NOT NULL,
  `dateCreation` date DEFAULT NULL,
  `dateDerniereModif` date DEFAULT NULL,
  `hashCode` varchar(255) DEFAULT NULL,
  `activation` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `parcour`
--

INSERT INTO `parcour` (`codePa`, `createur`, `nomPa`, `descriptionPa`, `dateCreation`, `dateDerniereModif`, `hashCode`, `activation`) VALUES
(107, 17, 'Nom du parcours', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent accumsan urna a hendrerit sagittis. Curabitur ultricies mi ac leo varius scelerisque. Aliquam vel lectus et nulla mattis efficitur in sit amet justo. Nunc sit amet nunc vitae massa aliquam dictum. Nulla eget nisl quis ligula consectetur accumsan in non nibh. Nunc egestas tellus sit amet quam pharetra, at sagittis ligula faucibus. Nulla tristique, sem vitae lacinia accumsan, erat eros sagittis erat, eget pellentesque elit justo at enim. Nam euismod odio at dui interdum, vel condimentum leo viverra. Pellentesque commodo lobortis orci non suscipit. Ut ac metus id libero sollicitudin commodo non at orci. Cras sapien odio, feugiat ac vestibulum sed, commodo non turpis. Integer consequat cursus convallis. Aliquam eget pharetra mauris, non sodales magna. Phasellus feugiat erat vitae pretium fringilla. Sed dignissim arcu urna, vitae sollicitudin ex lacinia nec. Sed vel tortor nec lectus ultrices rutrum.', '2022-06-24', '2022-06-24', '62', 0),
(108, 23, 'Nom du parcours', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent accumsan urna a hendrerit sagittis. Curabitur ultricies mi ac leo varius scelerisque. Aliquam vel lectus et nulla mattis efficitur in sit amet justo. Nunc sit amet nunc vitae massa aliquam dictum. Nulla eget nisl quis ligula consectetur accumsan in non nibh. Nunc egestas tellus sit amet quam pharetra, at sagittis ligula faucibus. Nulla tristique, sem vitae lacinia accumsan, erat eros sagittis erat, eget pellentesque elit justo at enim. Nam euismod odio at dui interdum, vel condimentum leo viverra. Pellentesque commodo lobortis orci non suscipit. Ut ac metus id libero sollicitudin commodo non at orci. Cras sapien odio, feugiat ac vestibulum sed, commodo non turpis. Integer consequat cursus convallis. Aliquam eget pharetra mauris, non sodales magna. Phasellus feugiat erat vitae pretium fringilla. Sed dignissim arcu urna, vitae sollicitudin ex lacinia nec. Sed vel tortor nec lectus ultrices rutrum.', '2022-06-25', '2022-06-25', '0a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `codePo` int(11) NOT NULL,
  `parcour` int(11) DEFAULT NULL,
  `nomPo` varchar(255) DEFAULT NULL,
  `pays` varchar(25) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`codePo`, `parcour`, `nomPo`, `pays`, `latitude`, `longitude`) VALUES
(208, 108, '26 Farringdon Road, Islington, London, EC1M 3HE', ' United Kingdom', 51.5201, -0.10568),
(207, 107, '89 Grosvenor Park, Southwark, London, SE5 0NJ', ' United Kingdom', 51.481, -0.09905),
(203, 107, '119 Hillingdon Street, Southwark, London, SE17 3UL', ' United Kingdom', 51.4831, -0.09888),
(204, 107, '16 Hendre Road, Southwark, London, SE1 5SR', ' United Kingdom', 51.4913, -0.07948),
(205, 107, '12 Lyndhurst Way, Southwark, London, SE15 5AT', ' United Kingdom', 51.4733, -0.07484),
(206, 107, '85 Grove Pk, Southwark, London, SE5 8AF', ' United Kingdom', 51.4698, -0.08823),
(209, 108, '4 Shrubbery Close, Islington, London, N1 7BZ', ' United Kingdom', 51.537, -0.09386);

-- --------------------------------------------------------

--
-- Table structure for table `typeactiv`
--

CREATE TABLE `typeactiv` (
  `nomAc` varchar(255) NOT NULL,
  `descriptionAc` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `typeactiv`
--

INSERT INTO `typeactiv` (`nomAc`, `descriptionAc`) VALUES
('jeu_texte', 'Il s\'agit d\'une devinette.Posez à l\'utilisateur une question, et lui soumettre de 2 à 4 réponses.'),
('jeu_image', 'Il s\'agit de soumettre à l\'utilisateur une image et il doit deviner ce qu\'elle represente.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`codeAct`),
  ADD KEY `position` (`position`),
  ADD KEY `typeJeu` (`activiteType`);

--
-- Indexes for table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chef` (`chef`);

--
-- Indexes for table `historique_parcour`
--
ALTER TABLE `historique_parcour`
  ADD PRIMARY KEY (`joueur`,`parcour`,`step`,`time`),
  ADD KEY `parcour` (`parcour`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `jeu_image`
--
ALTER TABLE `jeu_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeu_texte`
--
ALTER TABLE `jeu_texte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`codeM`),
  ADD KEY `equipe` (`equipe`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`codePa`,`codeM`,`dateN`),
  ADD KEY `codePa` (`codePa`,`codeM`);

--
-- Indexes for table `parcour`
--
ALTER TABLE `parcour`
  ADD PRIMARY KEY (`codePa`),
  ADD KEY `createur` (`createur`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`codePo`),
  ADD KEY `parcour` (`parcour`);

--
-- Indexes for table `typeactiv`
--
ALTER TABLE `typeactiv`
  ADD PRIMARY KEY (`nomAc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activite`
--
ALTER TABLE `activite`
  MODIFY `codeAct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeu_image`
--
ALTER TABLE `jeu_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeu_texte`
--
ALTER TABLE `jeu_texte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `membre`
--
ALTER TABLE `membre`
  MODIFY `codeM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `parcour`
--
ALTER TABLE `parcour`
  MODIFY `codePa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `codePo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
