-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Client :  mysql
-- Généré le :  Mar 15 Décembre 2015 à 15:29
-- Version du serveur :  5.5.32-MariaDB
-- Version de PHP :  5.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `infs3_prj09`
--

-- --------------------------------------------------------

--
-- Structure de la table `Administrateur`
--

CREATE TABLE IF NOT EXISTS `Administrateur` (
`numAdmin` int(11) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `tel` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE IF NOT EXISTS `Commentaire` (
`numCommentaire` int(11) NOT NULL,
  `loginEnseignant` varchar(8) NOT NULL,
  `contenu` text NOT NULL,
  `dateEnvoi` date NOT NULL,
  `numEntreprise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Convention`
--

CREATE TABLE IF NOT EXISTS `Convention` (
`numConcention` int(11) NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `numAdmin` int(11) NOT NULL,
  `loginEnseignant` varchar(8) NOT NULL,
  `numStage` int(11) NOT NULL,
  `loginEtudiant` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Enseignant`
--

CREATE TABLE IF NOT EXISTS `Enseignant` (
`loginEnseignant` varchar(8) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `tel` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Entrepreneur`
--

CREATE TABLE IF NOT EXISTS `Entrepreneur` (
`numEntrepreneur` int(11) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `fonction` varchar(256) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `tel` varchar(14) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Entrepreneur`
--

INSERT INTO `Entrepreneur` (`numEntrepreneur`, `prenom`, `nom`, `mail`, `fonction`, `pass`, `tel`) VALUES
(1, '', '', '', '', '', ''),
(2, 'Valentin', 'Collet', 'colcol&commat;etudiant&period;univ-reims&period;fr', '', '74c3b1c0ccefcc3319838d2c595fb101a7e9491c', '0345621578'),
(3, 'Valentin', 'Collet', 'colcol&commat;etudiant&period;univ-reims&period;fr', '', '74c3b1c0ccefcc3319838d2c595fb101a7e9491c', '0345621578'),
(4, 'Rémi', 'PECCARD', 'test@gmail.com', 'directeur', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '314159265358'),
(5, 'Valentin', 'Collet', 'colcol&commat;etudiant&period;univ-reims&period;fr', '', '74c3b1c0ccefcc3319838d2c595fb101a7e9491c', '0345621578');

-- --------------------------------------------------------

--
-- Structure de la table `Entreprise`
--

CREATE TABLE IF NOT EXISTS `Entreprise` (
`numEtreprise` int(11) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `tel` varchar(14) NOT NULL,
  `adresse` varchar(256) NOT NULL,
  `typeJuridique` varchar(256) NOT NULL,
  `site` varchar(256) NOT NULL,
  `ville` varchar(256) NOT NULL,
  `pays` varchar(256) NOT NULL,
  `SIRET` varchar(256) NOT NULL,
  `SIREN` varchar(256) NOT NULL,
  `codeAPE` varchar(256) NOT NULL,
  `logo` varchar(256) DEFAULT NULL,
  `numEntrepreneur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Etudiant`
--

CREATE TABLE IF NOT EXISTS `Etudiant` (
`loginEtudiant` varchar(8) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `tel` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Stage`
--

CREATE TABLE IF NOT EXISTS `Stage` (
`numStage` int(11) NOT NULL,
  `titre` varchar(256) NOT NULL,
  `dateFin` date NOT NULL,
  `dateDebut` date NOT NULL,
  `description` text NOT NULL,
  `domaine` varchar(256) NOT NULL,
  `nbPoste` int(11) NOT NULL,
  `gratification` int(11) NOT NULL,
  `numEntreprise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Administrateur`
--
ALTER TABLE `Administrateur`
 ADD PRIMARY KEY (`numAdmin`);

--
-- Index pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
 ADD PRIMARY KEY (`numCommentaire`), ADD UNIQUE KEY `loginEnseignant` (`loginEnseignant`), ADD UNIQUE KEY `numEntreprise` (`numEntreprise`);

--
-- Index pour la table `Convention`
--
ALTER TABLE `Convention`
 ADD PRIMARY KEY (`numConcention`), ADD UNIQUE KEY `numAdmin` (`numAdmin`), ADD UNIQUE KEY `loginEnseignant` (`loginEnseignant`), ADD UNIQUE KEY `numStage` (`numStage`), ADD UNIQUE KEY `loginEtudiant` (`loginEtudiant`);

--
-- Index pour la table `Enseignant`
--
ALTER TABLE `Enseignant`
 ADD PRIMARY KEY (`loginEnseignant`);

--
-- Index pour la table `Entrepreneur`
--
ALTER TABLE `Entrepreneur`
 ADD PRIMARY KEY (`numEntrepreneur`);

--
-- Index pour la table `Entreprise`
--
ALTER TABLE `Entreprise`
 ADD PRIMARY KEY (`numEtreprise`), ADD UNIQUE KEY `numEntrepreneur` (`numEntrepreneur`);

--
-- Index pour la table `Etudiant`
--
ALTER TABLE `Etudiant`
 ADD PRIMARY KEY (`loginEtudiant`);

--
-- Index pour la table `Stage`
--
ALTER TABLE `Stage`
 ADD PRIMARY KEY (`numStage`), ADD UNIQUE KEY `numEntreprise` (`numEntreprise`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Administrateur`
--
ALTER TABLE `Administrateur`
MODIFY `numAdmin` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
MODIFY `numCommentaire` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Convention`
--
ALTER TABLE `Convention`
MODIFY `numConcention` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Entrepreneur`
--
ALTER TABLE `Entrepreneur`
MODIFY `numEntrepreneur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `Entreprise`
--
ALTER TABLE `Entreprise`
MODIFY `numEtreprise` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Stage`
--
ALTER TABLE `Stage`
MODIFY `numStage` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
ADD CONSTRAINT `fk_commentaireEnseignant` FOREIGN KEY (`loginEnseignant`) REFERENCES `Enseignant` (`loginEnseignant`),
ADD CONSTRAINT `fk_commentaireEntreprise` FOREIGN KEY (`numEntreprise`) REFERENCES `Entreprise` (`numEtreprise`);

--
-- Contraintes pour la table `Convention`
--
ALTER TABLE `Convention`
ADD CONSTRAINT `fk_conventionAdmin` FOREIGN KEY (`numAdmin`) REFERENCES `Administrateur` (`numAdmin`),
ADD CONSTRAINT `fk_conventionEtudiant` FOREIGN KEY (`loginEtudiant`) REFERENCES `Etudiant` (`loginEtudiant`),
ADD CONSTRAINT `fk_conventionStage` FOREIGN KEY (`numStage`) REFERENCES `Stage` (`numStage`),
ADD CONSTRAINT `fk_convetionEnseignant` FOREIGN KEY (`loginEnseignant`) REFERENCES `Enseignant` (`loginEnseignant`);

--
-- Contraintes pour la table `Entreprise`
--
ALTER TABLE `Entreprise`
ADD CONSTRAINT `fk_entrepriseEntrepreneur` FOREIGN KEY (`numEntrepreneur`) REFERENCES `Entrepreneur` (`numEntrepreneur`);

--
-- Contraintes pour la table `Stage`
--
ALTER TABLE `Stage`
ADD CONSTRAINT `fk_stageEntreprise` FOREIGN KEY (`numEntreprise`) REFERENCES `Entreprise` (`numEtreprise`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
