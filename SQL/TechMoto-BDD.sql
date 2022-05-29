-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 29 mai 2022 à 18:38
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
-- Base de données : `techmoto`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(75) NOT NULL,
  `street` varchar(75) NOT NULL,
  `number` varchar(10) NOT NULL,
  `zipcode` varchar(45) NOT NULL,
  `extra` varchar(75) DEFAULT NULL,
  `repeatIndicator` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `slug` varchar(90) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `published_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`author_id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_article_user1_idx` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(4, 'Accessoires'),
(2, 'Équipement moto'),
(3, 'Pièces'),
(1, 'Vêtements');

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

DROP TABLE IF EXISTS `command`;
CREATE TABLE IF NOT EXISTS `command` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `statut` int(11) NOT NULL,
  `totalPrice` float NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`,`address_id`),
  UNIQUE KEY `reference_UNIQUE` (`reference`),
  KEY `fk_command_user1_idx` (`user_id`),
  KEY `fk_command_address1_idx` (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `command_product`
--

DROP TABLE IF EXISTS `command_product`;
CREATE TABLE IF NOT EXISTS `command_product` (
  `command_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`command_id`,`product_id`),
  KEY `fk_command_has_product_product1_idx` (`product_id`),
  KEY `fk_command_has_product_command1_idx` (`command_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `published_at` datetime NOT NULL,
  `upvote` int(11) DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`,`article_id`),
  KEY `fk_comment_user1_idx` (`user_id`),
  KEY `fk_comment_article1_idx` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(60) NOT NULL,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `name`, `slug`, `logo`) VALUES
(1, 'Honda', 'honda', ''),
(2, 'BMW', 'bmw', ''),
(3, 'Benelli', 'benelli', ''),
(4, 'Brixton', 'brixton', ''),
(5, 'Ducati', 'ducati', ''),
(6, 'Harley-Davidson', 'harley_davidson', ''),
(7, 'Indian', 'Indian', ''),
(8, 'Kawasaki', 'kawasaki', ''),
(9, 'KTM', 'ktm', ''),
(10, 'Royal Enfield', 'royal_enfield', ''),
(11, 'Suzuki', 'suzuki', ''),
(12, 'Triumph', 'Triumph', ''),
(13, 'Yamaha', 'Yamaha', '');

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `moto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`moto_id`),
  KEY `fk_option_moto1_idx` (`moto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `module`
--

INSERT INTO `module` (`id`, `name`, `description`, `picture`, `moto_id`) VALUES
(1, 'Une instrumentation à double cadrans avec un écran LCD multifonctions\r\n', 'Les cadrans analogiques de la vitesse et du compte-tour sont complétés par un écran LCD multifonctions, faisant ainsi l’équilibre entre un style rétro et des fonctionnalités modernes. \r\n', 'Z900_option_3.jpg', 1),
(2, 'Freins avant à montage radial', 'A l’avant, des disques de 300 mm (diamètre effectif : 267 mm) sont mordus par des étriers monoblocs à 4 pistons radiaux. Le maître-cylindre à piston radial du frein contribue aussi à l’incroyable sensation de contrôle que peut délivrer les étriers.', 'Z900RS_option_2.jpg', 1),
(3, 'KTRC (Kawasaki Traction Control)', 'Pour donner toujours plus d’assurance au pilote, la Z900RS est équipée de la dernière technologie Kawasaki. Le KTRC présente deux modes qui couvrent de nombreuses situations de conduite, permettant de meilleure performance en conduite sportive et d’être plus confiant sur les surfaces glissantes.', 'Honda_option_2.jpg', 1),
(4, 'Une instrumentation à double cadrans avec un écran LCD multifonctions', 'Les cadrans analogiques de la vitesse et du compte-tour sont complétés par un écran LCD multifonctions, faisant ainsi l’équilibre entre un style rétro et des fonctionnalités modernes.', 'Z900_option_3.jpg', 2),
(5, 'Freins avant à montage radial', 'A l’avant, des disques de 300 mm (diamètre effectif : 267 mm) sont mordus par des étriers monoblocs à 4 pistons radiaux. Le maître-cylindre à piston radial du frein contribue aussi à l’incroyable sensation de contrôle que peut délivrer les étriers.', 'Z900RS_option_2.jpg', 2),
(6, 'KTRC (Kawasaki TRaction Control)', 'Pour donner toujours plus d’assurance au pilote, la Z900RS est équipée de la dernière technologie Kawasaki. Le KTRC présente deux modes qui couvrent de nombreuses situations de conduite, permettant de meilleure performance en conduite sportive et d’être plus confiant sur les surfaces glissantes.', 'Honda_option_2.jpg', 2),
(8, 'Un moteur bicylindre puissant et agréable', 'Qu\'il s\'agisse de votre première moto (ou de la dernière en date), le moteur compatible avec le permis A2 offre un couple puissant à mi-régime et énergique à haut régime.', 'Z900_option_2.jpg', 5),
(9, 'Tableau de bord LCD', 'La superbe instrumentation LCD avec rétro-éclairage personnalisable affiche clairement les informations et propose des indicateurs personnalisables de position et de changement de vitesse.', 'Honda_option_1.jpg', 5),
(10, 'Nouvelles roues et bras oscillant allégés', 'Le bras oscillant allégé et les nouvelles roues à 5 branches réduisent la masse non suspendue, ce qui permet une direction plus réactive.', 'Honda_option_2.jpg', 5);

-- --------------------------------------------------------

--
-- Structure de la table `moto`
--

DROP TABLE IF EXISTS `moto`;
CREATE TABLE IF NOT EXISTS `moto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(60) NOT NULL,
  `released_in` date NOT NULL,
  `price` int(11) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `accroche` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `technical_profil_id` int(11) NOT NULL,
  `marque_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`technical_profil_id`,`marque_id`,`type_id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_moto_technical_profil_idx` (`technical_profil_id`),
  KEY `fk_moto_marque1_idx` (`marque_id`),
  KEY `fk_moto_type1_idx` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `moto`
--

INSERT INTO `moto` (`id`, `name`, `slug`, `released_in`, `price`, `slogan`, `accroche`, `banner`, `thumbnail`, `picture`, `technical_profil_id`, `marque_id`, `type_id`) VALUES
(1, 'Z900RS', 'z900rs', '2022-01-03', 12649, 'Hommage à une pionnière !', 'Le style profond d’une légende des années 70,la Z1 reine de la « coolitude »', 'Z900RS_banner.jpg', 'Z900RS_thumbnail.jpg', 'Z900RS_picture.jpg', 1, 8, 5),
(2, 'Z900', 'z900', '2022-01-03', 9799, 'Roadtser musclé !', 'Kawasaki Z900 : Efficacité à l\'ancienne', 'Z900RS_banner.jpg', 'Z900RS_thumbnail.jpg', 'Z900RS_picture.jpg', 2, 8, 1),
(5, 'CB500F', 'cb500f', '2022-01-03', 6799, 'Libérez le motard qui est en vous', 'Une bicylindre puissante et extrêmement agréable', 'Honda_banner_3.jpg', 'Honda_thumbnail_3.jpg', 'Honda_picture_3.jpg', 5, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `subCategory_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`subCategory_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `reference_UNIQUE` (`reference`),
  KEY `fk_product_subCategory1_idx` (`subCategory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `product_moto`
--

DROP TABLE IF EXISTS `product_moto`;
CREATE TABLE IF NOT EXISTS `product_moto` (
  `product_id` int(11) NOT NULL,
  `moto_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`moto_id`),
  KEY `fk_product_has_moto_moto1_idx` (`moto_id`),
  KEY `fk_product_has_moto_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`category_id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_subCategory_category1_idx` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `subcategory`
--

INSERT INTO `subcategory` (`id`, `name`, `category_id`) VALUES
(9, 'Bagagerie', 4),
(3, 'Casque', 2),
(18, 'Feu et Clignotants', 3),
(4, 'Gants', 2),
(17, 'Protection', 3),
(19, 'Saute-vent', 3),
(16, 'Silencieux', 3),
(11, 'Stickers', 4),
(10, 'Supports', 4),
(2, 'Sweat', 1),
(1, 'T-Shirt', 1),
(5, 'Veste', 2);

-- --------------------------------------------------------

--
-- Structure de la table `technical_profil`
--

DROP TABLE IF EXISTS `technical_profil`;
CREATE TABLE IF NOT EXISTS `technical_profil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cylindre` int(11) NOT NULL,
  `moteur` varchar(150) NOT NULL,
  `puissance` varchar(150) NOT NULL,
  `couple` varchar(150) NOT NULL,
  `démarrage` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `technical_profil`
--

INSERT INTO `technical_profil` (`id`, `cylindre`, `moteur`, `puissance`, `couple`, `démarrage`) VALUES
(1, 948, 'Quatre cylindres en ligne 4 temps à refroidissement liquide', '82 kW {111 ch} / 8,500 tr/min', '98.5 N•m {10 kgf•m} / 6,500 tr/min\r\n', 'Électrique'),
(2, 948, 'Quatre cylindres en ligne 4 temps à refroidissement liquide', '70 kW {95 ch} / 8,000 tr/min', '91.2 N•m {9.3 kgf•m} / 6,500 tr/min', 'Électrique'),
(5, 471, 'Bicylindre 4 temps, double ACT et 4 soupapes par cylindre, refroidi par eau', '35 kW (47ch) à 8 600 tr/min', '43 Nm à 6 500 tr/min', 'Électrique');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(2, 'Custom'),
(1, 'Roadster'),
(3, 'Sportive'),
(4, 'trail'),
(5, 'Vintage');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_user1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `command`
--
ALTER TABLE `command`
  ADD CONSTRAINT `fk_command_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_command_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `command_product`
--
ALTER TABLE `command_product`
  ADD CONSTRAINT `fk_command_has_product_command1` FOREIGN KEY (`command_id`) REFERENCES `command` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_command_has_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_article1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `fk_option_moto1` FOREIGN KEY (`moto_id`) REFERENCES `moto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `moto`
--
ALTER TABLE `moto`
  ADD CONSTRAINT `fk_moto_marque1` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_moto_technical_profil` FOREIGN KEY (`technical_profil_id`) REFERENCES `technical_profil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_moto_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_subCategory1` FOREIGN KEY (`subCategory_id`) REFERENCES `subcategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `product_moto`
--
ALTER TABLE `product_moto`
  ADD CONSTRAINT `fk_product_has_moto_moto1` FOREIGN KEY (`moto_id`) REFERENCES `moto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_has_moto_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `fk_subCategory_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
