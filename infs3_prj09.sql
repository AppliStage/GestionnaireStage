-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 13 Janvier 2016 à 23:10
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `infs3_prj09`
--

-- --------------------------------------------------------

--
-- Structure de la table `Administrateur`
--

CREATE TABLE `Administrateur` (
  `numAdmin` varchar(8) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `tel` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE `Commentaire` (
  `numCommentaire` int(11) NOT NULL,
  `dateEnvoi` date NOT NULL,
  `loginEnseignant` varchar(8) NOT NULL,
  `numEntreprise` int(11) NOT NULL,
  `contenu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Commentaire`
--

INSERT INTO `Commentaire` (`numCommentaire`, `dateEnvoi`, `loginEnseignant`, `numEntreprise`, `contenu`) VALUES
(10, '2016-01-13', 'gando002', 29, 'Bla Bla bla, Les enseignants peuvent surment envoyer des messages maintenant.'),
(11, '2016-01-13', 'gando002', 29, 'Je peux commenter plusieurs fois la même entreprise ?'),
(12, '2016-01-13', 'gando002', 29, 'Oui.'),
(13, '2016-01-13', 'gando002', 29, 'Cette images n''est pas libre de droit et elle est un peu pourrie je trouve.. J''appel au changement !'),
(14, '2016-01-13', 'gando002', 29, 'Et à une marge en bas ');

-- --------------------------------------------------------

--
-- Structure de la table `Convention`
--

CREATE TABLE `Convention` (
  `numConvention` int(11) NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `numAdmin` varchar(8) NOT NULL,
  `loginEnseignant` varchar(8) NOT NULL,
  `numStage` int(11) NOT NULL,
  `loginEtudiant` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Enseignant`
--

CREATE TABLE `Enseignant` (
  `loginEnseignant` varchar(8) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `tel` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Enseignant`
--

INSERT INTO `Enseignant` (`loginEnseignant`, `prenom`, `nom`, `mail`, `tel`) VALUES
('gando002', 'Antony', 'Ganodnou', 'gmigan.a@gmail.com', '0645547614');

-- --------------------------------------------------------

--
-- Structure de la table `Entrepreneur`
--

CREATE TABLE `Entrepreneur` (
  `numEntrepreneur` int(11) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `fonction` varchar(256) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `tel` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Entrepreneur`
--

INSERT INTO `Entrepreneur` (`numEntrepreneur`, `prenom`, `nom`, `mail`, `fonction`, `pass`, `tel`) VALUES
(4, 'Rémi', 'PECCARD', 'remi.peccard@etudiant.univ-reims.fr', 'directeur', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '314159265358'),
(7, 'antony', 'gandonou', 'gmigan.a@gmail.com', '', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '0645547614'),
(8, 'Ive', 'Jean', 'test2@gmail.com', '', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '0645547614'),
(9, 'steven', 'gandonou', 'gandonousteven@gmail.com', '', '9495778ed2ea9015ed81ec7a5807a2a52a7e5d81', '');

-- --------------------------------------------------------

--
-- Structure de la table `Entreprise`
--

CREATE TABLE `Entreprise` (
  `numEntreprise` int(11) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `tel` varchar(14) NOT NULL,
  `adresse` varchar(256) NOT NULL,
  `typeJuridique` varchar(256) NOT NULL,
  `site` varchar(256) DEFAULT NULL,
  `ville` varchar(256) NOT NULL,
  `pays` varchar(256) NOT NULL,
  `SIRET` varchar(256) NOT NULL,
  `SIREN` varchar(256) NOT NULL,
  `codeAPE` varchar(256) NOT NULL,
  `logo` varchar(256) DEFAULT NULL,
  `numEntrepreneur` int(11) NOT NULL,
  `codePostal` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Entreprise`
--

INSERT INTO `Entreprise` (`numEntreprise`, `nom`, `tel`, `adresse`, `typeJuridique`, `site`, `ville`, `pays`, `SIRET`, `SIREN`, `codeAPE`, `logo`, `numEntrepreneur`, `codePostal`) VALUES
(29, 'Lego', '0645547614', '10 chemin des rouliers', 'SARL', 'Array', 'Reims', 'France', '58761532451254', '123456788', '00258', NULL, 4, 51100),
(30, 'HSBC', '0519892564', '15 boulevard de la marsange', 'SARL', 'Array', 'Reims', 'France', '58761532441254', '123456788', '00258', NULL, 4, 51100),
(31, 'BimEntreprise', '0645547615', '52 rue noel', 'SARL', 'Array', 'Bailly', 'France', '58761558441254', '123456788', '02585', NULL, 8, 77700),
(32, 'Dr.manga', '0128565487', '45 rue du congo', 'SA', 'Array', 'Paris', 'France', '58761558441554', '159263487', '00258', NULL, 9, 75006),
(33, 'GandoInc', '0645547614', '6 boulevard des bonbons', 'SARL', 'Array', 'Paris', 'France', '58761558441266', '123456788', '0564', NULL, 7, 75013);

-- --------------------------------------------------------

--
-- Structure de la table `Etudiant`
--

CREATE TABLE `Etudiant` (
  `loginEtudiant` varchar(8) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `tel` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `postuler`
--

CREATE TABLE `postuler` (
  `numStage` int(11) NOT NULL,
  `loginEtudiant` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Stage`
--

CREATE TABLE `Stage` (
  `numStage` int(11) NOT NULL,
  `titre` varchar(256) NOT NULL,
  `dateFin` date NOT NULL,
  `dateDebut` date NOT NULL,
  `description` text NOT NULL,
  `domaine` varchar(256) NOT NULL,
  `nbPoste` int(11) NOT NULL,
  `gratification` text NOT NULL,
  `numEntreprise` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Stage`
--

INSERT INTO `Stage` (`numStage`, `titre`, `dateFin`, `dateDebut`, `description`, `domaine`, `nbPoste`, `gratification`, `numEntreprise`, `dateCreation`) VALUES
(29, 'Stage de Chef de Projet Avant-Vente', '2016-07-30', '2016-05-05', '\r\nMission:\r\nVous aurez pour responsabilité de piloter des projets en avant-vente afin : - de faire des études GO/NO GO - de coordonner et de piloter notre différentes entités pour répondre aux projets engagés - de vous assurer du suivi et de l''aboutissement des projets sélectionnés\r\n\r\nProfil:\r\nDe formation école de management, école de commerce, MBA ou ingénieur (BAC+5), vous êtes attiré(e) par le métier de chef de projet en avant-vente qui vous permettra de développer ou de mettre à profit vos connaissances techniques. Vous êtes rigoureux et doté d’un sens affuté de l''analyse et de la synthèse pour étudier les sujets d''avant-vente. Votre relationnel sera aussi un atout important pour bien piloter les projets engagés. – Indemnités de stage + variable commercial avantageux en fonction de vos performances, 100% Pass Navigo et tickets restaurants. Rémunération méritocratique. – Possibilité d’embauche à la suite du stage : nous privilégions donc les stages de fin d’études.', 'informatique', 1, '0', 30, '2015-12-26 12:17:57'),
(30, 'Stage - Participation à l''urbanisation du système d''information', '2016-07-30', '2016-05-05', 'Misson\r\nSopra Steria, leader européen de la transformation numérique, propose l''un des portefeuilles d''offres les plus complets du marché : conseil, intégration de systèmes, édition de solutions métier, infrastructure management et business process services. Il apporte ainsi une réponse globale aux enjeux de développement et de compétitivité des grandes entreprises et organisations. Combinant valeur ajoutée, innovation et performance des services délivrés, Sopra Steria accompagne ses clients dans leur transformation et les aide à faire le meilleur usage du numérique. Fort de 37 000 collaborateurs dans plus de 20 pays, le groupe Sopra Steria affiche un chiffre d''affaires pro forma 2014 de 3,4 milliards d''euros.\r\n\r\nIntérêt du stage\r\n- Participer à toutes les phases d''un projet (conception, modélisation métier, développement, recette)\r\n- Participer à la conception fonctionnelle avec le support d''un référent fonctionnel\r\n- Participer aux développements avec le support d''un référent technique\r\n- Participer aux suivis de la qualité et au pilotage avec le support d''un chef de projet\r\nEnvironnement technologique: Java/J2E, C, Apache, Angular JS \r\n\r\n', 'informatique', 1, 'Rémunération de stage: De 83.33 à 250 EUR par mois', 29, '2015-12-26 12:32:35'),
(33, 'Stage Contrôle de Gestion RH (H/F)', '2016-07-30', '2016-05-05', 'Mission\r\n\r\nStage de 6 mois , basé à Reims Les missions principales : Au sein de notre Direction des Ressources Humaines, vous aurez en charge les missions suivantes : - Analyse et construction de la base de données économique et sociale (BDES) - Compléter les reportings RH (Reporting social Pernod Ricard / Bilans sociaux / rapports annuels…) - Conception et réalisation de divers tableaux de bords RH\r\nProfil\r\n\r\nLe profil recherché : De formation Bac +3 à Bac+5 en Ressources Humaines / Finance / Statistiques, votre récent parcours vous a offert la possibilité d’une première expérience en RH au cours de laquelle vous avez su démontrer vos capacités de rigueur et de synthèse. Vous disposez d’un sens de l’organisation et maîtrisez les outils informatiques du Pack Office: en particulier Excel (construction de tableaux dynamiques) et gestion de base de données. Horaire : 35 h / hebdo Poste à pourvoir : 15 Février 2016 Dépôt de candidature : avant le 8 janvier 2016', 'gestion', 1, '1000', 31, '2016-01-11 23:30:52'),
(34, 'Stage longue durée en contrôle de gestion', '2016-07-30', '2016-05-05', 'Mission\r\n\r\nLe groupe Express entretient une relation privilégiée avec ses lecteurs en leur proposant des contenus et services plurimédias à forte valeur ajoutée. Parmi ses marques, se côtoient L''Express, L''Expansion, Point de Vue, L''Etudiant, Maisons Côté Sud, Ouest...\r\n\r\nMissions :\r\nRattaché(e) au Directeur du Contrôle de Gestion du Groupe, vous serez en charge du suivi :\r\n*de titres de presse/activité:imputation des factures, analyse des charges et produits, reporting, simulations de coûts, établissement du budget..\r\n*de dossiers transversaux (ex: répartition des frais communs)\r\n*du logiciel de gestion des achats.\r\n*de missions ponctuelles diverses.\r\n\r\nCes travaux seront faits en liaison avec le contrôleur de gestion responsable du dossier.\r\nLe poste est évolutif en fonction des capacités du stagiaire.\r\nProfil\r\n\r\nEcole de commerce, DUT Gestion, BTS Compta Gestion... Votre aisance à manier les chiffres, vos qualités de rigueur ainsi qu''une véritable motivation et un esprit d''équipe sont vos meilleurs atouts. Très bonne maitrîse des outils informatiques (Excel, Word..). Très bonnes qualités relationnelles. Une connaissance des bases de la comptabilité générale et/ou de BO serait un plus.', 'informatique', 1, 'Selon profil (minimum 554,40 €/mois net) + remboursement des transports en commun à 100% + 1 RTT par mois', 33, '2016-01-11 23:33:44'),
(35, 'Stage web développer', '2016-07-30', '2016-05-05', 'Mission\r\n\r\nPrésentation Futsal-Store\r\nFutsal-Store, première e-boutique dédiée à l''univers du Futsal en France et créée en 2010, propose des produits spécifiques au Futsal et foot à 5 en France et à l''étranger. Futsal-Store est surtout le spécialiste en France avec des centaines d''articles proposés pour les clubs, entreprises et particuliers.\r\nLa structure propose des marques telles que Nike, adidas, Errea, Joma, Puma, Select et Reusch, et compte de nombreux parrain tel que Frédéric DEHU (ex: OM, PSG), Jonathan CHAULET, Alexandre TEIXEIRA et Djamel HAROUN, internationaux français.\r\n\r\nDescription de la mission :\r\nLe stagiaire assistera l''équipe et sera chargé :\r\n- Créations de newsletters\r\n- Mise en place d''offres commerciales\r\n- Mise en place et suivi de market place\r\n- Création d''un module afin de maximiser le temps de présence des prospects/clients\r\nProfil\r\n\r\nMaîtrise de HTML5, CSS3 - Bases solides en PHP, MySQL, Javascript (jQuery), Linux - Connaissance du CMS Prestashop Souhaitées : - Maîtrise des principes POO, MVC et AJAX - Connaissances en SEO, web-analytic Goût prononcé pour le développement commercial Très bon relationnel Excellente organisation, rigueur Autonomie, prise d’initiatives Très bonne maîtrise des outils informatiques ci-dessus Une Connaissance et intérêt pour le milieu sportif, notamment du Football/Futsal serait un plus.', 'informatique', 1, '554,40€ + primes', 29, '2016-01-11 23:36:05');

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
  ADD PRIMARY KEY (`numCommentaire`);

--
-- Index pour la table `Convention`
--
ALTER TABLE `Convention`
  ADD PRIMARY KEY (`numConvention`),
  ADD UNIQUE KEY `numAdmin` (`numAdmin`),
  ADD UNIQUE KEY `loginEnseignant` (`loginEnseignant`),
  ADD UNIQUE KEY `numStage` (`numStage`),
  ADD UNIQUE KEY `loginEtudiant` (`loginEtudiant`);

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
  ADD PRIMARY KEY (`numEntreprise`);

--
-- Index pour la table `Etudiant`
--
ALTER TABLE `Etudiant`
  ADD PRIMARY KEY (`loginEtudiant`);

--
-- Index pour la table `postuler`
--
ALTER TABLE `postuler`
  ADD PRIMARY KEY (`numStage`,`loginEtudiant`),
  ADD UNIQUE KEY `numStage` (`numStage`),
  ADD UNIQUE KEY `loginEtudiant` (`loginEtudiant`);

--
-- Index pour la table `Stage`
--
ALTER TABLE `Stage`
  ADD PRIMARY KEY (`numStage`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  MODIFY `numCommentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `Convention`
--
ALTER TABLE `Convention`
  MODIFY `numConvention` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Entrepreneur`
--
ALTER TABLE `Entrepreneur`
  MODIFY `numEntrepreneur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `Entreprise`
--
ALTER TABLE `Entreprise`
  MODIFY `numEntreprise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `Stage`
--
ALTER TABLE `Stage`
  MODIFY `numStage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
