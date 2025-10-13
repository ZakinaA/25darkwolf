-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : lun. 13 oct. 2025 à 14:55
-- Version du serveur : 11.3.2-MariaDB
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `emusic`
--

-- --------------------------------------------------------

--
-- Structure de la table `accessoire`
--

DROP TABLE IF EXISTS `accessoire`;
CREATE TABLE IF NOT EXISTS `accessoire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instrument_id` int(11) DEFAULT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8FD026ACF11D9C` (`instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `accessoire`
--

INSERT INTO `accessoire` (`id`, `instrument_id`, `libelle`) VALUES
(1, 1, 'Archet'),
(2, 2, 'Housse de transport'),
(3, 3, 'Anche'),
(4, 4, 'Sourdine'),
(5, 5, 'Baguettes'),
(6, 6, 'Pupitre'),
(7, 7, 'Accordeur');

-- --------------------------------------------------------

--
-- Structure de la table `classe_instrument`
--

DROP TABLE IF EXISTS `classe_instrument`;
CREATE TABLE IF NOT EXISTS `classe_instrument` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classe_instrument`
--

INSERT INTO `classe_instrument` (`id`, `libelle`) VALUES
(1, 'Cordes'),
(2, 'Bois'),
(3, 'Cuivres'),
(4, 'Percussions'),
(5, 'Claviers');

-- --------------------------------------------------------

--
-- Structure de la table `couleur`
--

DROP TABLE IF EXISTS `couleur`;
CREATE TABLE IF NOT EXISTS `couleur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `couleur`
--

INSERT INTO `couleur` (`id`, `nom`) VALUES
(1, 'Noir'),
(2, 'Blanc'),
(3, 'Rouge'),
(4, 'Bleu'),
(5, 'Marron'),
(6, 'Doré'),
(7, 'Argenté');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20251013134357', '2025-10-13 13:44:17', 5306);

-- --------------------------------------------------------

--
-- Structure de la table `instrument`
--

DROP TABLE IF EXISTS `instrument`;
CREATE TABLE IF NOT EXISTS `instrument` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_instrument_id` int(11) DEFAULT NULL,
  `marque_id` int(11) DEFAULT NULL,
  `num_serie` varchar(255) DEFAULT NULL,
  `date_achat` date DEFAULT NULL,
  `prix_achat` double DEFAULT NULL,
  `utilisation` varchar(255) DEFAULT NULL,
  `chemin_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3CBF69DD7C1CAAA9` (`type_instrument_id`),
  KEY `IDX_3CBF69DD4827B9B2` (`marque_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instrument`
--

INSERT INTO `instrument` (`id`, `type_instrument_id`, `marque_id`, `num_serie`, `date_achat`, `prix_achat`, `utilisation`, `chemin_image`) VALUES
(1, 1, 1, 'VIO202001', '2020-02-15', 1200, 'Cours individuels', 'images/violon_yamaha.jpg'),
(2, 2, 3, 'GUI201905', '2019-05-22', 850, 'Cours + concerts', 'images/guitare_fender.jpg'),
(3, 3, 4, 'FLU202103', '2021-03-10', 600, 'Cours collectifs', 'images/flute_selmer.jpg'),
(4, 4, 4, 'CLA201812', '2018-12-01', 950, 'Cours individuels', 'images/clarinette_selmer.jpg'),
(5, 5, 1, 'TRO202106', '2021-06-25', 1100, 'Cours + fanfare', 'images/trompette_yamaha.jpg'),
(6, 6, 1, 'TRO202203', '2022-03-08', 1300, 'Cours individuels', 'images/trombone_yamaha.jpg'),
(7, 7, 6, 'BAT201711', '2017-11-30', 1500, 'Cours + répétitions', 'images/batterie_pearl.jpg'),
(8, 8, 2, 'PIA202009', '2020-09-05', 3500, 'Cours + concerts', 'images/piano_steinway.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `instrument_couleur`
--

DROP TABLE IF EXISTS `instrument_couleur`;
CREATE TABLE IF NOT EXISTS `instrument_couleur` (
  `instrument_id` int(11) NOT NULL,
  `couleur_id` int(11) NOT NULL,
  PRIMARY KEY (`instrument_id`,`couleur_id`),
  KEY `IDX_443EF844CF11D9C` (`instrument_id`),
  KEY `IDX_443EF844C31BA576` (`couleur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instrument_couleur`
--

INSERT INTO `instrument_couleur` (`instrument_id`, `couleur_id`) VALUES
(1, 5),
(2, 3),
(3, 2),
(4, 7),
(5, 6),
(6, 7),
(7, 1),
(8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `libelle`) VALUES
(1, 'Yamaha'),
(2, 'Steinway & Sons'),
(3, 'Fender'),
(4, 'Selmer'),
(5, 'Roland'),
(6, 'Pearl');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `num_rue` int(11) DEFAULT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `copos` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 'Dupont', 'Marie', 12, 'Rue des Écoles', 75005, 'Paris', 102030405, 'marie.dupont@musique.fr'),
(2, 'Martin', 'Paul', 8, 'Avenue Mozart', 69006, 'Lyon', 478123456, 'paul.martin@musique.fr'),
(3, 'Bernard', 'Lucie', 3, 'Rue Beethoven', 31000, 'Toulouse', 561874523, 'lucie.bernard@musique.fr'),
(4, 'Petit', 'Julien', 27, 'Boulevard Chopin', 44000, 'Nantes', 240556677, 'julien.petit@musique.fr');

-- --------------------------------------------------------

--
-- Structure de la table `professeur_type_instrument`
--

DROP TABLE IF EXISTS `professeur_type_instrument`;
CREATE TABLE IF NOT EXISTS `professeur_type_instrument` (
  `professeur_id` int(11) NOT NULL,
  `type_instrument_id` int(11) NOT NULL,
  PRIMARY KEY (`professeur_id`,`type_instrument_id`),
  KEY `IDX_1E1989D6BAB22EE9` (`professeur_id`),
  KEY `IDX_1E1989D67C1CAAA9` (`type_instrument_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professeur_type_instrument`
--

INSERT INTO `professeur_type_instrument` (`professeur_id`, `type_instrument_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8);

-- --------------------------------------------------------

--
-- Structure de la table `type_instrument`
--

DROP TABLE IF EXISTS `type_instrument`;
CREATE TABLE IF NOT EXISTS `type_instrument` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classe_instrument_id` int(11) DEFAULT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_21BCBFF8CE879FB1` (`classe_instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_instrument`
--

INSERT INTO `type_instrument` (`id`, `classe_instrument_id`, `libelle`) VALUES
(1, 1, 'Violon'),
(2, 1, 'Guitare'),
(3, 2, 'Flûte traversière'),
(4, 2, 'Clarinette'),
(5, 3, 'Trompette'),
(6, 3, 'Trombone'),
(7, 4, 'Batterie'),
(8, 5, 'Piano');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accessoire`
--
ALTER TABLE `accessoire`
  ADD CONSTRAINT `FK_8FD026ACF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `instrument`
--
ALTER TABLE `instrument`
  ADD CONSTRAINT `FK_3CBF69DD4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`),
  ADD CONSTRAINT `FK_3CBF69DD7C1CAAA9` FOREIGN KEY (`type_instrument_id`) REFERENCES `type_instrument` (`id`);

--
-- Contraintes pour la table `instrument_couleur`
--
ALTER TABLE `instrument_couleur`
  ADD CONSTRAINT `FK_443EF844C31BA576` FOREIGN KEY (`couleur_id`) REFERENCES `couleur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_443EF844CF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `professeur_type_instrument`
--
ALTER TABLE `professeur_type_instrument`
  ADD CONSTRAINT `FK_1E1989D67C1CAAA9` FOREIGN KEY (`type_instrument_id`) REFERENCES `type_instrument` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1E1989D6BAB22EE9` FOREIGN KEY (`professeur_id`) REFERENCES `professeur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `type_instrument`
--
ALTER TABLE `type_instrument`
  ADD CONSTRAINT `FK_21BCBFF8CE879FB1` FOREIGN KEY (`classe_instrument_id`) REFERENCES `classe_instrument` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
