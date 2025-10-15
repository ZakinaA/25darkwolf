-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 15 oct. 2025 à 06:33
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
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  `age_mini` int(11) DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `jour_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FDCA8C9CC54C8C93` (`type_id`),
  KEY `IDX_FDCA8C9C220C6AD0` (`jour_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `libelle`, `age_mini`, `heure_debut`, `heure_fin`, `type_id`, `jour_id`) VALUES
(1, 'Piano débutant', 6, '09:00:00', '10:00:00', 1, 1),
(2, 'Guitare intermédiaire', 10, '10:00:00', '11:00:00', 2, 2);

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
('DoctrineMigrations\\Version20251013122523', '2025-10-13 12:39:04', 203),
('DoctrineMigrations\\Version20251013123845', '2025-10-13 12:57:48', 366),
('DoctrineMigrations\\Version20251013125428', '2025-10-13 12:57:48', 184),
('DoctrineMigrations\\Version20251013125914', '2025-10-13 12:59:31', 1057),
('DoctrineMigrations\\Version20251013132915', '2025-10-13 13:29:27', 153),
('DoctrineMigrations\\Version20251013133132', '2025-10-13 13:31:41', 1072),
('DoctrineMigrations\\Version20251013133335', '2025-10-13 13:33:42', 1069),
('DoctrineMigrations\\Version20251013133457', '2025-10-13 13:35:55', 152),
('DoctrineMigrations\\Version20251013133732', '2025-10-13 13:37:40', 1031),
('DoctrineMigrations\\Version20251013134412', '2025-10-13 13:44:17', 185),
('DoctrineMigrations\\Version20251013134521', '2025-10-13 13:45:26', 1073),
('DoctrineMigrations\\Version20251013134823', '2025-10-13 13:48:28', 1205),
('DoctrineMigrations\\Version20251013135002', '2025-10-13 13:50:09', 160),
('DoctrineMigrations\\Version20251013135207', '2025-10-13 13:52:13', 1017),
('DoctrineMigrations\\Version20251013135721', '2025-10-13 13:57:24', 1076),
('DoctrineMigrations\\Version20251013135944', '2025-10-13 13:59:53', 153),
('DoctrineMigrations\\Version20251013140127', '2025-10-13 14:01:31', 1057);

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `num_rue` int(11) DEFAULT NULL,
  `rue` varchar(60) DEFAULT NULL,
  `copos` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `tranche_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ECA105F7B76F6B31` (`tranche_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`, `tranche_id`) VALUES
(1, 'Durand', 'Léo', 12, 'Rue de la musique', 75001, 'Paris', 123456789, 'leo.durand@example.com', 1),
(2, 'Martin', 'Sophie', 5, 'Rue des écoles', 69000, 'Lyon', 987654321, 'sophie.martin@example.com', 2);

-- --------------------------------------------------------

--
-- Structure de la table `eleve_responsable`
--

DROP TABLE IF EXISTS `eleve_responsable`;
CREATE TABLE IF NOT EXISTS `eleve_responsable` (
  `eleve_id` int(11) NOT NULL,
  `responsable_id` int(11) NOT NULL,
  PRIMARY KEY (`eleve_id`,`responsable_id`),
  KEY `IDX_D7350730A6CC7B2` (`eleve_id`),
  KEY `IDX_D735073053C59D72` (`responsable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eleve_responsable`
--

INSERT INTO `eleve_responsable` (`eleve_id`, `responsable_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_inscrption` date DEFAULT NULL,
  `eleve_id` int(11) DEFAULT NULL,
  `cours_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E90F6D6A6CC7B2` (`eleve_id`),
  KEY `IDX_5E90F6D67ECF78B0` (`cours_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `date_inscrption`, `eleve_id`, `cours_id`) VALUES
(1, '2025-09-01', 1, 1),
(2, '2025-09-02', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `jour`
--

DROP TABLE IF EXISTS `jour`;
CREATE TABLE IF NOT EXISTS `jour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jour`
--

INSERT INTO `jour` (`id`, `libelle`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi');

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
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` double DEFAULT NULL,
  `date_paiement` date DEFAULT NULL,
  `inscription_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B1DC7A1E5DAC5993` (`inscription_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `montant`, `date_paiement`, `inscription_id`) VALUES
(1, 150, '2025-09-15', 1),
(2, 200, '2025-09-20', 2);

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `num_rue` int(11) DEFAULT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `copos` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `tranche_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_52520D07B76F6B31` (`tranche_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `responsable`
--

INSERT INTO `responsable` (`id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`, `tranche_id`) VALUES
(1, 'Durand', 'Claire', 12, 'Rue de la musique', 75001, 'Paris', 123123123, 'claire.durand@example.com', 1),
(2, 'Martin', 'Luc', 5, 'Rue des écoles', 69000, 'Lyon', 321321321, 'luc.martin@example.com', 2);

-- --------------------------------------------------------

--
-- Structure de la table `tranche`
--

DROP TABLE IF EXISTS `tranche`;
CREATE TABLE IF NOT EXISTS `tranche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  `quotient_mini` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tranche`
--

INSERT INTO `tranche` (`id`, `libelle`, `quotient_mini`) VALUES
(1, 'Tranche A', 0),
(2, 'Tranche B', 500),
(3, 'Tranche C', 1000);

-- --------------------------------------------------------

--
-- Structure de la table `tranche_type`
--

DROP TABLE IF EXISTS `tranche_type`;
CREATE TABLE IF NOT EXISTS `tranche_type` (
  `tranche_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`tranche_id`,`type_id`),
  KEY `IDX_F98E49B2B76F6B31` (`tranche_id`),
  KEY `IDX_F98E49B2C54C8C93` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tranche_type`
--

INSERT INTO `tranche_type` (`tranche_id`, `type_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `nom`) VALUES
(1, 'Piano'),
(2, 'Guitare'),
(3, 'Violon');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `FK_FDCA8C9C220C6AD0` FOREIGN KEY (`jour_id`) REFERENCES `jour` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9CC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `FK_ECA105F7B76F6B31` FOREIGN KEY (`tranche_id`) REFERENCES `tranche` (`id`);

--
-- Contraintes pour la table `eleve_responsable`
--
ALTER TABLE `eleve_responsable`
  ADD CONSTRAINT `FK_D735073053C59D72` FOREIGN KEY (`responsable_id`) REFERENCES `responsable` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D7350730A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D67ECF78B0` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`),
  ADD CONSTRAINT `FK_5E90F6D6A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `FK_B1DC7A1E5DAC5993` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`);

--
-- Contraintes pour la table `responsable`
--
ALTER TABLE `responsable`
  ADD CONSTRAINT `FK_52520D07B76F6B31` FOREIGN KEY (`tranche_id`) REFERENCES `tranche` (`id`);

--
-- Contraintes pour la table `tranche_type`
--
ALTER TABLE `tranche_type`
  ADD CONSTRAINT `FK_F98E49B2B76F6B31` FOREIGN KEY (`tranche_id`) REFERENCES `tranche` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F98E49B2C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
