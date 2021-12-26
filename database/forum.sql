-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 26 déc. 2021 à 19:22
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

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
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `publicationDate` datetime NOT NULL,
  `userId` int NOT NULL,
  `picture` text,
  `modified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `publicationDate`, `userId`, `picture`, `modified`) VALUES
(2, 'titre', 'content', '2021-12-18 00:00:00', 14, NULL, 0),
(3, 'post1', 'evidemment', '2021-12-18 00:00:00', 14, NULL, 1),
(6, 'un titre', 'une photo', '2021-12-18 00:00:00', 14, '/Assets/postPictures/6.jpg', 0),
(16, 'Voici un titre qualitatif', 'Et une description qualitative!!', '2021-12-26 13:50:26', 18, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE IF NOT EXISTS `favorite` (
  `userId` int NOT NULL,
  `articleId` int NOT NULL,
  KEY `userIdFav` (`userId`),
  KEY `articleIdFav` (`articleId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `favorite`
--

INSERT INTO `favorite` (`userId`, `articleId`) VALUES
(18, 16),
(18, 6);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `profilePicture` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `mail`, `profilePicture`, `admin`) VALUES
(14, 'Mattox1', '$2y$10$pnr/3n3w9j9twSRaHcahneQitJr1bKXqCUlWAUtWPckcrkQv3QNzO', 'mattox1@gmail.com', '/Assets/ProfilePictures/Mattox1.jpg', 1),
(15, 'Mattox2', '$2y$10$NT1/NyPwBkzIo9p78UzUgOGbFYmiz3wB9mMrN2qTPcirNbFotkY7W', 'mattox2@gmail.com', '/Assets/ProfilePictures/Mattox2.gif', 0),
(17, 'Camille', '$2y$10$HpSz/xAHqOmi1do0FM4GNOfuaaumMVF9zRhZeefMRQKJ/23oW/0PG', 'camille@gmail.com', '/Assets/ProfilePictures/Camille.png', 0),
(18, 'Maximauve', '$2y$10$QcuXK7aLo/HNhVSQy96wtuJkkTKiNgeIbTGGGqH.zO0jEfyDUUOkG', 'max.mourgues@gmail.com', '/Assets/ProfilePictures/Maximauve.png', 1),
(20, 'MaxiDeux', '$2y$10$EN0kjUS5pGYb5s5kwACIGewBmZBSxcNtkPtXGlXuh584nOXqFytWu', 'max.mourgues2@gmail.com', '/Assets/ProfilePictures/MaxiDeux.gif', 0),
(21, 'MaxiLol', '$2y$10$vBVD9fPwKtF6Xjbpla0z1.qq95ruoTUHFOMPWqnfQHp93/1X0oYoG', 'max.mourgues3@gmail.com', '/Assets/ProfilePictures/MaxiLol.gif', 0);

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
