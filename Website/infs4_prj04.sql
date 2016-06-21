-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Client :  mysql
-- Généré le :  Ven 27 Février 2015 à 17:28
-- Version du serveur :  5.5.32-MariaDB
-- Version de PHP :  5.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `infs4_prj04`
--

-- --------------------------------------------------------

--
-- Structure de la table `Affectation`
--

CREATE TABLE IF NOT EXISTS `Affectation` (
  `idIntervenant` int(11) NOT NULL,
  `idSequence` int(11) NOT NULL,
  `nb_Sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Annee`
--

CREATE TABLE IF NOT EXISTS `Annee` (
`idAnnee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Diviser`
--

CREATE TABLE IF NOT EXISTS `Diviser` (
  `idSemaine` int(11) NOT NULL,
  `idSequence` int(11) NOT NULL,
  `nbH_Semaine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Décharge`
--

CREATE TABLE IF NOT EXISTS `Décharge` (
  `idAnnee` int(11) NOT NULL,
  `idIntervenant` int(11) NOT NULL,
  `decharge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Intervenant`
--

CREATE TABLE IF NOT EXISTS `Intervenant` (
`idIntervenant` int(11) NOT NULL,
  `idStatut` int(11) NOT NULL,
  `loginLDAP` varchar(32) NOT NULL,
  `pass` varchar(500) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Intervenant`
--

INSERT INTO `Intervenant` (`idIntervenant`, `idStatut`, `loginLDAP`, `pass`, `nom`, `prenom`, `admin`) VALUES
(1, 0, 'didier.gillard@univ-reims.fr', '1234', 'Gillard', 'Didier', 0),
(2, 0, 'olivier.nocent@univ-reims.fr', '1234', 'Nocent', 'Olivier', 0),
(3, 1, 'gilles.escuyer@univ-reims.fr', '1234', 'Escuyer', 'Gilles', 0),
(4, 0, 'antoine.jonquet@univ-reims.fr', '1234', 'Jonquet', 'Antoine', 0),
(5, 1, 'lydie.sandron@univ-reims.fr', '1234', 'Sandron', 'Lydie', 0),
(42, 1, 'philippe.vautrot@univ-reims.fr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'VAUTROT', 'Philippe', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Matière`
--

CREATE TABLE IF NOT EXISTS `Matière` (
  `idMatiere` varchar(32) NOT NULL,
  `libMatiere` varchar(100) NOT NULL,
  `demiSemestre` int(11) NOT NULL COMMENT '0 = Semestre complet, sinon 1 ou 2',
  `nbHCM_PPN` int(11) NOT NULL,
  `nbHTP_PPN` int(11) NOT NULL,
  `nbHTD_PPN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Matière`
--

INSERT INTO `Matière` (`idMatiere`, `libMatiere`, `demiSemestre`, `nbHCM_PPN`, `nbHTP_PPN`, `nbHTD_PPN`) VALUES
(' M4101C2', 'APIs Google', 1, 9, 18, 0),
('M1101', 'Introduction aux systèmes informatiques', 0, 8, 24, 18),
('M1102', 'Introduction à l''algorithmique et à la programmation', 1, 9, 40, 0),
('M1103', 'Structures de données et algorithmes fondamentaux', 2, 7, 35, 0),
('M2102', 'Architecture des réseaux', 2, 7, 21, 0),
('M2103', 'Bases de la programmation orientée objets', 1, 9, 40, 0),
('M2104', 'Base de la conception orientée objet', 2, 8, 0, 35),
('M3101', 'Principes des systèmes d''exploitation', 1, 8, 32, 7),
('M3102', 'Services réseaux', 2, 7, 0, 34),
('M3103', 'Algorithmique avancée', 1, 8, 16, 0),
('M4101C', 'Administration système et réseau', 1, 9, 18, 0),
('M4101C1', 'Intelligence Artificielle', 1, 9, 18, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Repartition`
--

CREATE TABLE IF NOT EXISTS `Repartition` (
  `idSequence` int(11) NOT NULL,
  `idSemestre` int(11) NOT NULL,
  `nbGroupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Repartition`
--

INSERT INTO `Repartition` (`idSequence`, `idSemestre`, `nbGroupe`) VALUES
(1, 1, 12);

-- --------------------------------------------------------

--
-- Structure de la table `Semaine_Travaillee`
--

CREATE TABLE IF NOT EXISTS `Semaine_Travaillee` (
  `idSemaine` int(11) NOT NULL,
  `idSemestre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Semestre`
--

CREATE TABLE IF NOT EXISTS `Semestre` (
  `idSemestre` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateMilieu` date NOT NULL,
  `dateFin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Semestre`
--

INSERT INTO `Semestre` (`idSemestre`, `dateDebut`, `dateMilieu`, `dateFin`) VALUES
(1, '2014-09-01', '2015-11-23', '2015-01-18'),
(2, '2015-02-02', '2015-04-22', '2015-07-04'),
(3, '2015-09-01', '2015-11-23', '2016-01-18'),
(4, '2016-02-02', '2016-04-22', '2016-07-04');

-- --------------------------------------------------------

--
-- Structure de la table `Sequence_Pedagogique`
--

CREATE TABLE IF NOT EXISTS `Sequence_Pedagogique` (
`idSequence` int(11) NOT NULL,
  `idMatiere` varchar(32) NOT NULL,
  `libSequence` varchar(32) NOT NULL,
  `nbH_Total` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Sequence_Pedagogique`
--

INSERT INTO `Sequence_Pedagogique` (`idSequence`, `idMatiere`, `libSequence`, `nbH_Total`) VALUES
(1, 'M2103', 'CM', 5),
(2, 'M1102', 'CM', 16),
(3, 'M1102', 'TP', 24),
(4, 'M1102', 'TD', 8),
(6, ' M4101C2', 'CM', 16);

-- --------------------------------------------------------

--
-- Structure de la table `Statut`
--

CREATE TABLE IF NOT EXISTS `Statut` (
  `idStatut` int(11) NOT NULL,
  `libStatut` varchar(32) NOT NULL,
  `nbHMin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Voeux`
--

CREATE TABLE IF NOT EXISTS `Voeux` (
  `idIntervenant` int(11) NOT NULL,
  `idSequence` int(11) NOT NULL,
  `nb_Desire` int(11) NOT NULL,
  `nb_Depanne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Affectation`
--
ALTER TABLE `Affectation`
 ADD PRIMARY KEY (`idIntervenant`,`idSequence`), ADD KEY `Affectation_fk_Sequence` (`idSequence`);

--
-- Index pour la table `Annee`
--
ALTER TABLE `Annee`
 ADD PRIMARY KEY (`idAnnee`);

--
-- Index pour la table `Diviser`
--
ALTER TABLE `Diviser`
 ADD PRIMARY KEY (`idSemaine`,`idSequence`), ADD KEY `Diviser_ibfk_Sequence` (`idSequence`);

--
-- Index pour la table `Décharge`
--
ALTER TABLE `Décharge`
 ADD PRIMARY KEY (`idAnnee`,`idIntervenant`), ADD KEY `Decharge_ibfk_Intervenant` (`idIntervenant`);

--
-- Index pour la table `Intervenant`
--
ALTER TABLE `Intervenant`
 ADD PRIMARY KEY (`idIntervenant`);

--
-- Index pour la table `Matière`
--
ALTER TABLE `Matière`
 ADD PRIMARY KEY (`idMatiere`);

--
-- Index pour la table `Repartition`
--
ALTER TABLE `Repartition`
 ADD PRIMARY KEY (`idSequence`,`idSemestre`), ADD KEY `Repartition_ibfk_Semestre` (`idSemestre`);

--
-- Index pour la table `Semaine_Travaillee`
--
ALTER TABLE `Semaine_Travaillee`
 ADD PRIMARY KEY (`idSemaine`);

--
-- Index pour la table `Semestre`
--
ALTER TABLE `Semestre`
 ADD PRIMARY KEY (`idSemestre`);

--
-- Index pour la table `Sequence_Pedagogique`
--
ALTER TABLE `Sequence_Pedagogique`
 ADD PRIMARY KEY (`idSequence`);

--
-- Index pour la table `Statut`
--
ALTER TABLE `Statut`
 ADD PRIMARY KEY (`idStatut`);

--
-- Index pour la table `Voeux`
--
ALTER TABLE `Voeux`
 ADD PRIMARY KEY (`idIntervenant`,`idSequence`), ADD KEY `Voeux_ibfk_Sequence` (`idSequence`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Annee`
--
ALTER TABLE `Annee`
MODIFY `idAnnee` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Intervenant`
--
ALTER TABLE `Intervenant`
MODIFY `idIntervenant` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `Sequence_Pedagogique`
--
ALTER TABLE `Sequence_Pedagogique`
MODIFY `idSequence` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Affectation`
--
ALTER TABLE `Affectation`
ADD CONSTRAINT `Affectation_fk_Intervenant` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idIntervenant`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `Affectation_fk_Sequence` FOREIGN KEY (`idSequence`) REFERENCES `Sequence_Pedagogique` (`idSequence`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Diviser`
--
ALTER TABLE `Diviser`
ADD CONSTRAINT `Diviser_ibfk_Semaine` FOREIGN KEY (`idSemaine`) REFERENCES `Semaine_Travaillee` (`idSemaine`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `Diviser_ibfk_Sequence` FOREIGN KEY (`idSequence`) REFERENCES `Sequence_Pedagogique` (`idSequence`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Décharge`
--
ALTER TABLE `Décharge`
ADD CONSTRAINT `Décharge_ibfk_Annee` FOREIGN KEY (`idAnnee`) REFERENCES `Annee` (`idAnnee`),
ADD CONSTRAINT `Décharge_ibfk_Intervenant` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idIntervenant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Repartition`
--
ALTER TABLE `Repartition`
ADD CONSTRAINT `Repartition_ibfk_Semestre` FOREIGN KEY (`idSemestre`) REFERENCES `Semestre` (`idSemestre`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `Repartition_ibfk_Sequence` FOREIGN KEY (`idSequence`) REFERENCES `Sequence_Pedagogique` (`idSequence`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Voeux`
--
ALTER TABLE `Voeux`
ADD CONSTRAINT `Voeux_ibfk_Intervenant` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idIntervenant`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `Voeux_ibfk_Sequence` FOREIGN KEY (`idSequence`) REFERENCES `Sequence_Pedagogique` (`idSequence`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
