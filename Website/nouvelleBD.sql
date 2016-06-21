-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Client :  mysql
-- Généré le :  Lun 23 Février 2015 à 16:40
-- Version du serveur :  5.5.32-MariaDB
-- Version de PHP :  5.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `infs3_prj05`
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
-- Structure de la table `Année`
--

CREATE TABLE IF NOT EXISTS `Année` (
`idAnnee` int(11) NOT NULL
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
-- Structure de la table `Diviser`
--

CREATE TABLE IF NOT EXISTS `Diviser` (
  `idSemaine` int(11) NOT NULL,
  `idSequence` int(11) NOT NULL,
  `nbH_Semaine` int(11) NOT NULL
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Intervenant`
--

INSERT INTO `Intervenant` (`idIntervenant`, `idStatut`, `loginLDAP`, `pass`, `nom`, `prenom`, `admin`) VALUES
(42, 1, 'philippe.vautrot@univ-reims.fr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'VAUTROT', 'Philippe', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Matière`
--

CREATE TABLE IF NOT EXISTS `Matière` (
  `idMatiere` int(11) NOT NULL,
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
(4201, 'Projet', 0, 10, 20, 20);

-- --------------------------------------------------------

--
-- Structure de la table `Repartition`
--

CREATE TABLE IF NOT EXISTS `Repartition` (
  `idSequence` int(11) NOT NULL,
  `idSemestre` int(11) NOT NULL,
  `nbGroupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Semaine_Travaillée`
--

CREATE TABLE IF NOT EXISTS `Semaine_Travaillée` (
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

-- --------------------------------------------------------

--
-- Structure de la table `Sequence_Pedagogique`
--

CREATE TABLE IF NOT EXISTS `Sequence_Pedagogique` (
  `idSequence` int(11) NOT NULL,
  `idMatiere` int(11) NOT NULL,
  `libSequence` varchar(32) NOT NULL,
  `nbH_Total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Sequence_Pedagogique`
--

INSERT INTO `Sequence_Pedagogique` (`idSequence`, `idMatiere`, `libSequence`, `nbH_Total`) VALUES
(1, 4201, 'CM', 5);

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
-- Index pour la table `Année`
--
ALTER TABLE `Année`
 ADD PRIMARY KEY (`idAnnee`);

--
-- Index pour la table `Décharge`
--
ALTER TABLE `Décharge`
 ADD PRIMARY KEY (`idAnnee`,`idIntervenant`), ADD KEY `Decharge_ibfk_Intervenant` (`idIntervenant`);

--
-- Index pour la table `Diviser`
--
ALTER TABLE `Diviser`
 ADD PRIMARY KEY (`idSemaine`,`idSequence`), ADD KEY `Diviser_ibfk_Sequence` (`idSequence`);

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
-- Index pour la table `Semaine_Travaillée`
--
ALTER TABLE `Semaine_Travaillée`
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
-- AUTO_INCREMENT pour la table `Année`
--
ALTER TABLE `Année`
MODIFY `idAnnee` int(11) NOT NULL AUTO_INCREMENT;
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
-- Contraintes pour la table `Décharge`
--
ALTER TABLE `Décharge`
ADD CONSTRAINT `Décharge_ibfk_Annee` FOREIGN KEY (`idAnnee`) REFERENCES `Année` (`idAnnee`),
ADD CONSTRAINT `Décharge_ibfk_Intervenant` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idIntervenant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Diviser`
--
ALTER TABLE `Diviser`
ADD CONSTRAINT `Diviser_ibfk_Semaine` FOREIGN KEY (`idSemaine`) REFERENCES `Semaine_Travaillée` (`idSemaine`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `Diviser_ibfk_Sequence` FOREIGN KEY (`idSequence`) REFERENCES `Sequence_Pedagogique` (`idSequence`) ON DELETE CASCADE ON UPDATE CASCADE;

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
--
-- Base de données :  `test_cutrona`
--

-- --------------------------------------------------------

--
-- Structure de la table `PRODUIT`
--
-- utilisé(#1146 - Table 'test_cutrona.PRODUIT' doesn't exist)
-- Erreur de lecture des données :  (#1146 - Table 'test_cutrona.PRODUIT' doesn't exist)
--
-- Base de données :  `test_nocent`
--

-- --------------------------------------------------------

--
-- Structure de la table `attendee`
--

CREATE TABLE IF NOT EXISTS `attendee` (
`id` int(11) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `student` tinyint(1) NOT NULL,
  `registration` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `attendee`
--

INSERT INTO `attendee` (`id`, `lastname`, `firstname`, `email`, `tel`, `student`, `registration`) VALUES
(1, 'Nocent', 'Olivier', 'olivier.nocent@univ-reims.fr', '0326971559', 0, '2014-12-02');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `attendee`
--
ALTER TABLE `attendee`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `attendee`
--
ALTER TABLE `attendee`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
