-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 19 Janvier 2015 à 15:41
-- Version du serveur: 5.5.40
-- Version de PHP: 5.4.36-0+deb7u1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `projetS3(bis)`
--

-- --------------------------------------------------------

--
-- Structure de la table `Affectation`
--

CREATE TABLE IF NOT EXISTS `Affectation` (
  `n°Affectation` int(11) NOT NULL AUTO_INCREMENT,
  `type_Cours` varchar(30) NOT NULL,
  `idSemestre` int(11) NOT NULL,
  `idModule` int(11) NOT NULL,
  `idProf` int(11) NOT NULL,
  PRIMARY KEY (`n°Affectation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Concerner`
--

CREATE TABLE IF NOT EXISTS `Concerner` (
  `idGroupe` int(11) NOT NULL,
  `n°Affectation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Enseignant`
--

CREATE TABLE IF NOT EXISTS `Enseignant` (
  `idProf` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(65) NOT NULL,
  `nbHmin` int(11) NOT NULL,
  `nbHmax` int(11) NOT NULL,
  `decharge` int(11) NOT NULL,
  `nbHexterieur` int(11) NOT NULL,
  `statut` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `estDirecteur` tinyint(1) NOT NULL,
  PRIMARY KEY (`idProf`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `Enseignant`
--

INSERT INTO `Enseignant` (`idProf`, `nom`, `prenom`, `email`, `nbHmin`, `nbHmax`, `decharge`, `nbHexterieur`, `statut`, `pass`, `estDirecteur`) VALUES
(1, 'CUTRONA', 'Jerome', 'jerome.cutrona@univ-reims.fr', 192, 288, 0, 0, 'SUP', '5ed25af7b1ed23fb00122e13d7f74c4d8262acd8', 0),
(2, 'GILLARD', 'Didier', 'didier.gillard@univ-reims.fr', 192, 288, 0, 0, 'SUP', '', 0),
(3, 'VAUTROT', 'Philippe', 'philippe.vautrot@univ-reims.fr', 192, 288, 0, 0, 'SUP', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 1),
(4, 'BENASSAROU', 'Aassif', 'aassif.benassarou@univ-reims.fr', 192, 288, 0, 0, 'SUP', '', 0),
(5, 'SANDRON', 'Lydie', 'lydie.sandron@univ-reims.fr', 384, 576, 0, 0, 'SEC', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 0),
(6, 'GUESSOUM', 'Zahia', 'zahia.guessoum@univ-reims.fr', 192, 288, 0, 0, 'SUP', '', 0),
(7, 'COUTANT', 'Etienne', 'etienne.countant@univ-reims.fr', 384, 576, 0, 0, 'SEC', '', 0),
(8, 'CLIN', 'Exavérine', 'exaverine.clin@univ-reims.fr', 64, 64, 0, 0, 'DOC', '', 0),
(9, 'ISMAEL', 'Muhannad', 'muhannad.ismael@univ-reims.fr', 96, 96, 0, 0, 'ATER', '', 0),
(10, 'COUDRAIN', 'Sébastien', 'sebastien.coudrain@univ-reims.fr', 0, 0, 0, 0, 'BIATOSS', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Groupe`
--

CREATE TABLE IF NOT EXISTS `Groupe` (
  `idGroupe` varchar(11) NOT NULL,
  PRIMARY KEY (`idGroupe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Groupe`
--

INSERT INTO `Groupe` (`idGroupe`) VALUES
('1A'),
('1B'),
('2A'),
('2B');

-- --------------------------------------------------------

--
-- Structure de la table `Module`
--

CREATE TABLE IF NOT EXISTS `Module` (
  `idModule` varchar(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `dateDebut` varchar(10) NOT NULL,
  `dateFin` varchar(10) NOT NULL,
  `nbHTP_PPN` int(11) DEFAULT NULL,
  `nbHTD_PPN` int(11) DEFAULT NULL,
  `nbHCM_PPN` int(11) DEFAULT NULL,
  `TDM` tinyint(1) DEFAULT '0',
  `idSemestre` int(11) NOT NULL,
  PRIMARY KEY (`idModule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Module`
--

INSERT INTO `Module` (`idModule`, `nom`, `dateDebut`, `dateFin`, `nbHTP_PPN`, `nbHTD_PPN`, `nbHCM_PPN`, `TDM`, `idSemestre`) VALUES
('M1102', 'Introduction a l''algorithmique', '2014-09-15', '2014-11-15', 40, NULL, 9, 0, 1),
('M1103', 'Structures de donnees et algor', '2014-11-17', '2015-01-17', 35, NULL, 7, 0, 1),
('M1104', 'Introduction aux bases de donn', '2014-09-15', '2015-01-17', 28, 14, 14, 0, 1),
('M1201', 'Mathematiques discretes', '2014-09-15', '2014-11-22', NULL, 34, 10, 0, 1),
('M1202', 'Algebre lineaire', '2014-11-17', '2015-01-17', 14, 12, 6, 0, 1),
('M1203', 'Environnement economique', '2014-11-17', '2015-01-17', NULL, 21, 7, 0, 1),
('M1204', 'Fonctionnement des organisatio', '2014-09-22', '2015-01-17', 14, 16, 10, 0, 1),
('M2105', 'Introduction aux IHM', '2015-02-16', '2015-06-13', 14, 22, 8, 0, 2),
('M2106', 'Communiquer en anglais', '2015-02-23', '2015-06-13', 20, 21, NULL, 0, 2),
('M2204', 'Gestion de projet informatique', '2015-02-16', '2015-03-14', 12, 7, 8, 0, 2),
('M2333', 'Coucou', '2015-01-01', '2015-01-10', 10, 10, 10, 1, 2),
('M3102', 'Services reseaux', '2014-11-17', '2015-01-15', 0, 14, 7, 0, 3),
('M3104', 'Programmation web cote serveur', '2014-09-14', '2015-01-10', 28, NULL, 10, 0, 3),
('M3106C1', 'Base de la programmation en C+', '2014-11-10', '2015-01-17', 18, NULL, 10, 0, 3),
('M3204', 'Gestion des systemes d''informa', '2014-09-08', '2015-01-17', 12, 12, 13, 0, 3),
('M4101C1', 'Intelligence Artificielle', '2015-02-16', '2015-04-18', 18, NULL, 9, 0, 4),
('M4102C1', 'Realite Virtuelle', '2015-02-16', '2015-04-18', 18, NULL, 9, 0, 4),
('M4103C', 'Programmation web - client ric', '2015-02-16', '2015-04-18', 18, NULL, 9, 0, 4);

-- --------------------------------------------------------

--
-- Structure de la table `Repartition`
--

CREATE TABLE IF NOT EXISTS `Repartition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSemestre` int(11) NOT NULL,
  `idModule` varchar(11) NOT NULL,
  `idSemaine` int(11) NOT NULL,
  `nbHTP` int(11) NOT NULL,
  `nbHTD` int(11) NOT NULL,
  `nbHCM` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Contenu de la table `Repartition`
--

INSERT INTO `Repartition` (`id`, `idSemestre`, `idModule`, `idSemaine`, `nbHTP`, `nbHTD`, `nbHCM`) VALUES
(1, 1, 'M1103', 47, 0, 0, 1),
(2, 1, 'M1103', 48, 5, 0, 1),
(3, 1, 'M1103', 49, 5, 0, 1),
(4, 1, 'M1103', 50, 5, 0, 1),
(5, 1, 'M1103', 51, 5, 0, 1),
(6, 1, 'M1104', 38, 0, 0, 2),
(7, 1, 'M1104', 39, 2, 1, 2),
(8, 1, 'M1104', 40, 2, 1, 2),
(9, 1, 'M1104', 41, 2, 1, 2),
(10, 1, 'M1104', 42, 2, 1, 1),
(11, 1, 'M1202', 47, 2, 0, 1),
(12, 1, 'M1202', 48, 2, 2, 1),
(13, 1, 'M1202', 49, 2, 2, 1),
(14, 1, 'M1202', 50, 2, 2, 1),
(15, 1, 'M1202', 51, 2, 2, 0),
(16, 2, 'M2105', 8, 0, 0, 1),
(17, 2, 'M2105', 9, 1, 1, 1),
(18, 2, 'M2105', 10, 1, 1, 1),
(19, 2, 'M2105', 11, 1, 1, 1),
(20, 2, 'M2105', 12, 1, 2, 0),
(21, 2, 'M2106', 8, 0, 0, 5),
(22, 2, 'M2106', 9, 0, 1, 1),
(23, 2, 'M2106', 10, 2, 1, 1),
(24, 2, 'M2106', 11, 2, 1, 1),
(25, 2, 'M2106', 12, 2, 1, 0),
(26, 2, 'M2204', 8, 0, 0, 1),
(27, 2, 'M2204', 9, 0, 1, 1),
(28, 2, 'M2204', 10, 2, 1, 1),
(29, 2, 'M2204', 11, 2, 1, 1),
(30, 2, 'M2204', 12, 2, 1, 1),
(31, 3, 'M3102', 47, 0, 2, 1),
(32, 3, 'M3102', 48, 0, 2, 1),
(33, 3, 'M3102', 49, 0, 2, 1),
(34, 3, 'M3102', 50, 0, 2, 1),
(35, 3, 'M3102', 51, 0, 2, 1),
(36, 3, 'M3104', 38, 0, 0, 2),
(37, 3, 'M3104', 39, 2, 0, 1),
(38, 3, 'M3104', 40, 2, 0, 1),
(39, 3, 'M3104', 41, 2, 0, 1),
(40, 3, 'M3104', 42, 2, 0, 1),
(41, 3, 'M3106C1', 46, 0, 0, 2),
(42, 3, 'M3106C1', 47, 0, 0, 2),
(43, 3, 'M3106C1', 48, 3, 0, 1),
(44, 3, 'M3106C1', 49, 3, 0, 1),
(45, 3, 'M3106C1', 50, 3, 0, 1),
(46, 3, 'M3204', 37, 0, 0, 1),
(47, 3, 'M3204', 38, 0, 0, 1),
(48, 3, 'M3204', 39, 0, 0, 1),
(49, 3, 'M3204', 40, 0, 0, 1),
(50, 3, 'M3204', 41, 0, 0, 1),
(51, 4, 'M4101C1', 8, 2, 0, 1),
(52, 4, 'M4101C1', 9, 2, 0, 1),
(53, 4, 'M4101C1', 10, 2, 0, 1),
(54, 4, 'M4101C1', 11, 2, 0, 1),
(55, 4, 'M4101C1', 12, 2, 0, 1),
(56, 4, 'M4102C1', 8, 2, 0, 1),
(57, 4, 'M4102C1', 9, 2, 0, 1),
(58, 4, 'M4102C1', 10, 2, 0, 1),
(59, 4, 'M4102C1', 11, 2, 0, 1),
(60, 4, 'M4102C1', 12, 2, 0, 1),
(61, 4, 'M4103C', 8, 2, 0, 1),
(62, 4, 'M4103C', 9, 2, 0, 1),
(63, 4, 'M4103C', 10, 2, 0, 1),
(64, 4, 'M4103C', 11, 2, 0, 1),
(65, 4, 'M4103C', 12, 2, 0, 1),
(66, 1, 'M1102', 47, 2, 2, 1),
(67, 1, 'M1102', 48, 2, 2, 1),
(68, 1, 'M1102', 49, 2, 2, 1),
(69, 1, 'M1102', 50, 2, 2, 2),
(70, 1, 'M1102', 51, 2, 2, 0),
(71, 1, 'M1201', 38, 0, 2, 2),
(72, 1, 'M1201', 39, 0, 2, 2),
(73, 1, 'M1201', 40, 0, 2, 2),
(74, 1, 'M1201', 41, 0, 2, 2),
(75, 1, 'M1201', 42, 0, 2, 2),
(76, 1, 'M1203', 38, 1, 2, 1),
(77, 1, 'M1203', 39, 1, 2, 1),
(78, 1, 'M1203', 40, 1, 2, 2),
(79, 1, 'M1203', 41, 2, 1, 1),
(80, 1, 'M1203', 42, 2, 2, 0),
(81, 1, 'M1204', 47, 2, 2, 2),
(82, 1, 'M1204', 48, 2, 2, 1),
(83, 1, 'M1204', 49, 2, 2, 1),
(84, 1, 'M1204', 50, 2, 1, 1),
(85, 1, 'M1204', 51, 1, 2, 2),
(90, 2, 'M2333', 1, 1, 1, 1),
(91, 2, 'M2333', 2, 2, 2, 2),
(92, 2, 'M2333', 3, 3, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `Semaine`
--

CREATE TABLE IF NOT EXISTS `Semaine` (
  `idSemaine` int(11) NOT NULL,
  PRIMARY KEY (`idSemaine`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Semaine`
--

INSERT INTO `Semaine` (`idSemaine`) VALUES
(1),
(2),
(3),
(4),
(5),
(7),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(45),
(46),
(47),
(48),
(49),
(50),
(51),
(52);

-- --------------------------------------------------------

--
-- Structure de la table `Vacataire`
--

CREATE TABLE IF NOT EXISTS `Vacataire` (
  `idProf` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(65) NOT NULL,
  `nbHmin` int(11) NOT NULL,
  `nbHmax` int(11) NOT NULL,
  `pass` varchar(30) NOT NULL,
  PRIMARY KEY (`idProf`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Vacataire`
--

INSERT INTO `Vacataire` (`idProf`, `nom`, `prenom`, `email`, `nbHmin`, `nbHmax`, `pass`) VALUES
(1, 'LOUPPE', 'Christophe', 'christophe.louppe@univ-reims.fr', 0, 0, ''),
(2, 'LAMBERT', 'Ludovic', 'ludovic.lambert@univ-reims.fr', 0, 0, 'poney');

-- --------------------------------------------------------

--
-- Structure de la table `Voeux`
--

CREATE TABLE IF NOT EXISTS `Voeux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProf` int(11) NOT NULL,
  `idModule` varchar(11) NOT NULL,
  `CM` int(11) NOT NULL,
  `TD` int(11) NOT NULL,
  `TP` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `Voeux`
--

INSERT INTO `Voeux` (`id`, `idProf`, `idModule`, `CM`, `TD`, `TP`) VALUES
(32, 1, 'M1102', 0, 1, 2),
(33, 1, 'M1104', 0, 2, 2),
(34, 5, 'M1104', 4, 5, 0),
(35, 5, 'M3104', 4, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
