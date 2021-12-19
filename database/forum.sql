-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 19 déc. 2021 à 22:31
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `publicationDate` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  `picture` text,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `publicationDate`, `userId`, `picture`) VALUES
(2, 'titre', 'content', '2021-12-18 00:00:00', 14, NULL),
(3, 'post1', 'evidemment', '2021-12-18 00:00:00', 14, NULL),
(6, 'un titre', 'une photo', '2021-12-18 00:00:00', 14, './assets/post_pictures/6.jpg'),
(7, 'UN TITRE', 'DESCRIPTIONQ', '2021-12-19 00:00:00', 16, './assets/post_pictures/7.jpg'),
(8, 'D', 'D', '2021-12-19 00:00:00', 16, NULL),
(9, 'e', 'e', '2021-12-19 00:00:00', 16, NULL),
(10, 'y', 'y', '2021-12-19 00:00:00', 16, NULL),
(11, 'HEY', 'hey', '2021-12-19 22:27:54', 16, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE IF NOT EXISTS `favorite` (
  `userId` int(11) NOT NULL,
  `articleId` int(11) NOT NULL,
  KEY `userIdFav` (`userId`),
  KEY `articleIdFav` (`articleId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `profilePicture` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `mail`, `profilePicture`, `admin`) VALUES
(2, 'Mattox', '$2y$10$gnG8AmN7q8PHl2ckvR0JI.VpJcRl9bzEiO6DfpY9q7PkFMUaQMR8O', 'mattox@gmail.com', 'https://imgur.com/a/iAJex60', 1),
(14, 'Mattox1', '$2y$10$pnr/3n3w9j9twSRaHcahneQitJr1bKXqCUlWAUtWPckcrkQv3QNzO', 'mattox1@gmail.com', './assets/profile_pictures/Mattox1.jpg', 1),
(15, 'Mattox2', '$2y$10$NT1/NyPwBkzIo9p78UzUgOGbFYmiz3wB9mMrN2qTPcirNbFotkY7W', 'mattox2@gmail.com', './assets/profile_pictures/Mattox2.gif', 0),
(16, 'forum', '$2y$10$eilgZgRJRIFdsbuofxYH7Or8RvkcShg/irrvkc1TPTzjaO8bfTpse', 'forum@gmail.com', './assets/profile_pictures/forum.gif', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `articleIdFav` FOREIGN KEY (`articleId`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userIdFav` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
