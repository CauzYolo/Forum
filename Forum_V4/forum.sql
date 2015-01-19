-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 14 Janvier 2015 à 14:02
-- Version du serveur :  5.5.40-0ubuntu0.14.04.1
-- Version de PHP :  5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
`idCat` int(11) NOT NULL,
  `libCat` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`idCat`, `libCat`) VALUES
(1, 'Programmation Web'),
(2, 'Reseau'),
(3, 'Algorithme'),
(4, 'Test');

-- --------------------------------------------------------

--
-- Structure de la table `droits`
--

CREATE TABLE IF NOT EXISTS `droits` (
`idDroit` int(11) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isMod` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `droits`
--

INSERT INTO `droits` (`idDroit`, `isAdmin`, `isMod`) VALUES
(1, 1, 1),
(2, 0, 1),
(3, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `formatImage`
--

CREATE TABLE IF NOT EXISTS `formatImage` (
`idFormat` int(11) NOT NULL,
  `libFormat` varchar(4) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `formatImage`
--

INSERT INTO `formatImage` (`idFormat`, `libFormat`) VALUES
(1, 'jpeg'),
(2, 'jpg'),
(3, 'png'),
(4, 'gif'),
(5, 'bmp');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE IF NOT EXISTS `reponse` (
`idRep` int(11) NOT NULL,
  `dateRep` date NOT NULL,
  `descrRep` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `modification` tinyint(1) NOT NULL DEFAULT '0',
  `idUser` int(11) NOT NULL,
  `idSujet` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `reponse`
--

INSERT INTO `reponse` (`idRep`, `dateRep`, `descrRep`, `modification`, `idUser`, `idSujet`) VALUES
(1, '0000-00-00', 'Il nous manque la suite', 0, 1, 2),
(2, '2015-01-12', '<p>Si tu veux mon avis &ccedil;a va &ecirc;tre compliqu&eacute; :)</p>', 1, 5, 1),
(3, '2015-01-12', '<p><em>Je ne pense <strong>pas</strong> :p </em></p>', 1, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sujet`
--

CREATE TABLE IF NOT EXISTS `sujet` (
`idSujet` int(11) NOT NULL,
  `titreSujet` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateSujet` date NOT NULL,
  `descrSujet` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `nbVue` int(11) NOT NULL DEFAULT '0',
  `estFerme` tinyint(1) NOT NULL DEFAULT '0',
  `idUser` int(11) NOT NULL,
  `idCat` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `sujet`
--

INSERT INTO `sujet` (`idSujet`, `titreSujet`, `dateSujet`, `descrSujet`, `nbVue`, `estFerme`, `idUser`, `idCat`) VALUES
(1, 'Faire le php!', '0000-00-00', '<p>Nous allons commencer par les bases de<strong> </strong>PHP. Pour effectuer ce cours, nous aurons besoin de Wamp ou Lamp ou Mamp...</p>', 0, 0, 10, 1),
(2, 'Apprendre le php', '0000-00-00', 'Nous allons commencer par les bases de PHP. Pour effectuer ce cours, nous aurons besoin de Wamp ou Lamp ou Mamp...', 0, 0, 1, 1),
(3, 'Apprendre l''HTML', '0000-00-00', 'Nous allons commencer par les bases de HTML. Pour effectuer ce cours, nous aurons besoin de Wamp ou Lamp ou Mamp...', 0, 0, 1, 1),
(4, 'Apprendre le TCP/IP', '0000-00-00', 'Nous allons commencer par expliquer ces deux protocoles ...', 0, 0, 1, 2),
(8, 'Apprendre l''algorithmie', '2015-01-05', 'Oh lol!', 0, 0, 10, 3),
(9, 'Apprendre l''algorithmie', '2015-01-13', '<p>Lel :)<br />&nbsp;</p>', 0, 0, 10, 4);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`idUser` int(11) NOT NULL,
  `pseudoUser` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `loginUser` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `pwdUser` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `mailUser` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estBLUser` tinyint(1) NOT NULL DEFAULT '0',
  `urlLogo` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `idDroit` int(1) NOT NULL DEFAULT '3'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`idUser`, `pseudoUser`, `loginUser`, `pwdUser`, `mailUser`, `estBLUser`, `urlLogo`, `idDroit`) VALUES
(1, 'administrateur', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 0, 'image/6da268c5f1baf587b556caa4a83d0ff6.jpg', 1),
(2, 'admini', 'alex', '21232f297a57a5a743894a0e4a801fc3', NULL, 0, 'image/750f1a3f9d56a13cfa1a4a68549d81f7.jpg', 2),
(3, 'Master', 'alex', '534b44a19bf18d20b71ecc4eb77c572f', NULL, 0, 'image/32a0926e06867f3914d8fea7d9b77ca7.jpg', 3),
(4, 'CauzYolo', 'william', '4c12192c97a92105e79b18ec8433d36c', NULL, 0, 'image/0b3098a6dca0522baa2e07625e002bdc.jpg', 1),
(5, 'titi', 'titi', '5d933eef19aee7da192608de61b6c23d', NULL, 0, 'image/885c4e273b3d7752dad8b89d047dabaf.jpg', 3),
(6, 'toto', 'toto', 'f71dbe52628a3f83a77ab494817525c6', NULL, 0, 'image/2df5ad35df212b37e45eaa0d2168f152.jpg', 3),
(7, 'tutu', 'tutu', 'bdb8c008fa551ba75f8481963f2201da', NULL, 0, 'image/f6da900e9b4380433024088f5ca60670.jpg', 3);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
 ADD PRIMARY KEY (`idCat`);

--
-- Index pour la table `droits`
--
ALTER TABLE `droits`
 ADD PRIMARY KEY (`idDroit`);

--
-- Index pour la table `formatImage`
--
ALTER TABLE `formatImage`
 ADD PRIMARY KEY (`idFormat`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
 ADD PRIMARY KEY (`idRep`), ADD KEY `index_idSujetRep` (`idSujet`) COMMENT 'Clef étrangère entre idSujet et table Reponse', ADD KEY `index_idUserRep` (`idUser`) COMMENT 'index sur fk idUser de la table réponse';

--
-- Index pour la table `sujet`
--
ALTER TABLE `sujet`
 ADD PRIMARY KEY (`idSujet`), ADD KEY `index_IdUserSujet` (`idUser`) COMMENT 'index sur fk idUser de la table sujet', ADD KEY `index_idCatSujet` (`idCat`) COMMENT 'index sur fk idCat de la table user';

--
-- Index pour la table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`idUser`), ADD KEY `index_idDroitUser` (`idDroit`) COMMENT 'index sur fk idDroit de la table user';

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
MODIFY `idCat` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `droits`
--
ALTER TABLE `droits`
MODIFY `idDroit` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `formatImage`
--
ALTER TABLE `formatImage`
MODIFY `idFormat` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
MODIFY `idRep` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `sujet`
--
ALTER TABLE `sujet`
MODIFY `idSujet` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
ADD CONSTRAINT `fk_idSujetRep` FOREIGN KEY (`idSujet`) REFERENCES `sujet` (`idSujet`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_idUserRep` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sujet`
--
ALTER TABLE `sujet`
ADD CONSTRAINT `fk_IdCatSujet` FOREIGN KEY (`idCat`) REFERENCES `categorie` (`idCat`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_idUserSujet` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `fk_idDroitUser` FOREIGN KEY (`idDroit`) REFERENCES `droits` (`idDroit`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
