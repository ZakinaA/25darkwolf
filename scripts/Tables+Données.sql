-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : lun. 24 nov. 2025 à 13:00
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `accessoire`
--

INSERT INTO `accessoire` (`id`, `instrument_id`, `libelle`) VALUES
(1, 1, 'Archet'),
(2, 1, 'Housse de transport'),
(3, 3, 'Anche'),
(4, 4, 'Sourdine'),
(5, 5, 'Baguettes'),
(6, 6, 'Pupitre'),
(7, 7, 'Accordeur'),
(8, 2, 'Housse de transport');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_880E0D76A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `user_id`, `email`, `password`) VALUES
(1, 1, 'admin@emusic.fr', '$2y$13$9wjfv3F9gTxMj9rXNdcxsO8CYZvl6o4naJznFGSLvX0IzCFq8uUye');

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Structure de la table `contrat_pret`
--

DROP TABLE IF EXISTS `contrat_pret`;
CREATE TABLE IF NOT EXISTS `contrat_pret` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eleve_id` int(11) NOT NULL,
  `instrument_id` int(11) NOT NULL,
  `num_contrat` varchar(255) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `etat_detaille_debut` varchar(255) NOT NULL,
  `etat_detaille_retour` varchar(255) DEFAULT NULL,
  `attestation_assurance` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1FB84C67A6CC7B2` (`eleve_id`),
  KEY `IDX_1FB84C67CF11D9C` (`instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contrat_pret`
--

INSERT INTO `contrat_pret` (`id`, `eleve_id`, `instrument_id`, `num_contrat`, `date_debut`, `date_fin`, `etat_detaille_debut`, `etat_detaille_retour`, `attestation_assurance`) VALUES
(1, 3, 2, 'CPT-2023-001', '2023-09-01', '2024-06-30', 'Instrument en parfait état, quelques micro-rayures sur le corps.', 'Superbe état', 1),
(2, 4, 1, 'CPT-2023-002', '2023-09-15', '2024-07-15', 'Petite bosse sur le pavillon, cordes neuves.', 'Non évalué', 0),
(3, 5, 4, 'CPT-2023-003', '2023-10-01', '2024-08-30', 'Très bon état général, housse fournie légèrement usée.', 'Non évalué', 1),
(4, 6, 3, 'CPT-2023-004', '2023-10-10', '2024-09-10', 'Usure normale, quelques marques d\'utilisation visibles.', 'Non évalué', 1),
(5, 7, 5, 'CPT-2023-005', '2023-11-01', '2024-10-31', 'Neuf, sans aucun défaut visible.', 'Non évalué', 0);

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
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `jour_id` int(11) DEFAULT NULL,
  `type_instrument_id` int(11) DEFAULT NULL,
  `professeur_id` int(11) DEFAULT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `age_mini` int(11) DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FDCA8C9CC54C8C93` (`type_id`),
  KEY `IDX_FDCA8C9C220C6AD0` (`jour_id`),
  KEY `IDX_FDCA8C9C7C1CAAA9` (`type_instrument_id`),
  KEY `IDX_FDCA8C9CBAB22EE9` (`professeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `type_id`, `jour_id`, `type_instrument_id`, `professeur_id`, `libelle`, `age_mini`, `heure_debut`, `heure_fin`) VALUES
(1, 1, 1, 1, 1, 'batterie', 6, '16:00:00', '17:00:00'),
(2, 2, 3, 2, 1, 'Guitare', 8, '14:30:00', '16:00:00'),
(3, 1, 5, 8, 4, 'Piano', 14, '18:30:00', '19:30:00');

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
('DoctrineMigrations\\Version20251112081853', '2025-11-12 08:20:24', 20598),
('DoctrineMigrations\\Version20251112101819', '2025-11-12 10:18:43', 1597),
('DoctrineMigrations\\Version20251112104208', '2025-11-12 10:42:13', 553),
('DoctrineMigrations\\Version20251112104429', '2025-11-12 10:44:35', 147),
('DoctrineMigrations\\Version20251112105229', '2025-11-12 10:52:36', 1041);

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tranche_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `num_rue` int(11) DEFAULT NULL,
  `rue` varchar(60) DEFAULT NULL,
  `copos` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_ECA105F7A76ED395` (`user_id`),
  KEY `IDX_ECA105F7B76F6B31` (`tranche_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`id`, `tranche_id`, `user_id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 1, 8, 'Marie', 'Sophie', 15, 'Rue de la Fugue', 75010, 'Paris', 601112233, 'sophie.leblanc@mail.fr'),
(2, 2, 9, 'Dubois', 'Thomas', 4, 'Impasse du Tempo', 69007, 'Lyon', 604445566, 'thomas.dubois@mail.fr'),
(3, 1, 10, 'Dubois', 'Clara', 13, 'Rue des Fleurs', 69002, 'Lyon', 601010103, 'clara.dubois@example.com'),
(4, 2, 11, 'Lefevre', 'Gabriel', 14, 'Avenue du Parc', 13008, 'Marseille', 601010104, 'gabriel.lefevre@example.com'),
(5, 3, 12, 'Bernard', 'Louise', 15, 'Boulevard Jean', 33000, 'Bordeaux', 601010105, 'louise.bernard@example.com'),
(6, 4, 13, 'Durand', 'Paul', 16, 'Chemin Vert', 31000, 'Toulouse', 601010106, 'paul.durand@example.com'),
(7, 1, 14, 'Petit', 'Manon', 17, 'Impasse Bleue', 59000, 'Lille', 601010107, 'manon.petit@example.com');

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

-- --------------------------------------------------------

--
-- Structure de la table `gestionnaire`
--

DROP TABLE IF EXISTS `gestionnaire`;
CREATE TABLE IF NOT EXISTS `gestionnaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F4461B20A76ED395` (`user_id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `gestionnaire`
--

INSERT INTO `gestionnaire` (`id`, `email`, `roles`, `password`, `user_id`) VALUES
(1, 'gestion@emusic.fr', '', '$2y$13$eX1mv9luD89fNdMVMGzvXeDdd8noRmowTHFBKlD17wTAPoB3fSSW', 2);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eleve_id` int(11) DEFAULT NULL,
  `cours_id` int(11) DEFAULT NULL,
  `date_inscrption` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E90F6D6A6CC7B2` (`eleve_id`),
  KEY `IDX_5E90F6D67ECF78B0` (`cours_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `instrument`
--

DROP TABLE IF EXISTS `instrument`;
CREATE TABLE IF NOT EXISTS `instrument` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_instrument_id` int(11) DEFAULT NULL,
  `marque_id` int(11) DEFAULT NULL,
  `num_serie` varchar(100) NOT NULL,
  `date_achat` date DEFAULT NULL,
  `prix_achat` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3CBF69DD7C1CAAA9` (`type_instrument_id`),
  KEY `IDX_3CBF69DD4827B9B2` (`marque_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instrument`
--

INSERT INTO `instrument` (`id`, `type_instrument_id`, `marque_id`, `num_serie`, `date_achat`, `prix_achat`) VALUES
(1, 1, 1, 'VIO202001', '2020-02-15', 1250),
(2, 2, 3, 'GUI201905', '2019-05-22', 850),
(3, 3, 4, 'FLU202103', '2021-03-10', 600),
(4, 4, 4, 'CLA201812', '2018-12-01', 950),
(5, 5, 1, 'TRO202106', '2021-06-25', 1100),
(6, 6, 1, 'TRO202203', '2022-03-08', 1300),
(7, 7, 6, 'BAT201711', '2017-11-30', 1500),
(8, 8, 2, 'PIA202009', '2020-09-05', 3500);

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
(5, 6);

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

DROP TABLE IF EXISTS `intervention`;
CREATE TABLE IF NOT EXISTS `intervention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `professionnel_id` int(11) NOT NULL,
  `contrat_pret_id` int(11) NOT NULL,
  `instrument_id` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `descriptif` longtext NOT NULL,
  `prix` double NOT NULL,
  `quotite` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D11814AB8A49CC82` (`professionnel_id`),
  KEY `IDX_D11814ABB2AF233D` (`contrat_pret_id`),
  KEY `IDX_D11814ABCF11D9C` (`instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`id`, `professionnel_id`, `contrat_pret_id`, `instrument_id`, `date_debut`, `date_fin`, `descriptif`, `prix`, `quotite`) VALUES
(1, 1, 1, 1, '2025-10-20 09:00:00', '2025-10-20 12:00:00', 'Réparation du violon - Remplacement cordier', 120, 1),
(2, 3, 2, 3, '2025-11-05 14:00:00', '2025-11-05 16:30:00', 'Accordage et harmonisation du piano Steinway (num_serie: PIA202009)', 250, 1);

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
-- Structure de la table `metier`
--

DROP TABLE IF EXISTS `metier`;
CREATE TABLE IF NOT EXISTS `metier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `metier`
--

INSERT INTO `metier` (`id`, `libelle`) VALUES
(1, 'Luthier'),
(2, 'Technicien pianos'),
(3, 'Réparateur instruments à vent');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inscription_id` int(11) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `date_paiement` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B1DC7A1E5DAC5993` (`inscription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `num_rue` int(11) DEFAULT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `copos` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_17A55299A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`id`, `user_id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 3, 'Dupont', 'Marie', 13, 'Rue des Écoles', 75005, 'Paris', 102030405, 'marie.dupont@musique.fr'),
(2, 5, 'Martin', 'Paul', 8, 'Avenue Mozart', 69006, 'Lyon', 478123456, 'paul.martin@musique.fr'),
(3, 6, 'Bernard', 'Lucie', 3, 'Rue Beethoven', 31000, 'Toulouse', 561874523, 'lucie.bernard@musique.fr'),
(4, 7, 'Petit', 'Julien', 27, 'Boulevard Chopin', 44000, 'Nantes', 240556677, 'julien.petit@musique.fr');

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
-- Structure de la table `professionnel`
--

DROP TABLE IF EXISTS `professionnel`;
CREATE TABLE IF NOT EXISTS `professionnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metier_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `num_rue` int(11) NOT NULL,
  `rue` varchar(255) NOT NULL,
  `cp` int(11) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `tel` int(11) NOT NULL,
  `mail` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7A28C10FED16FA20` (`metier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professionnel`
--

INSERT INTO `professionnel` (`id`, `metier_id`, `nom`, `num_rue`, `rue`, `cp`, `ville`, `tel`, `mail`) VALUES
(1, 1, 'Atelier Corde sensible', 10, 'Rue de Rome', 75008, 'Paris', 123456789, 'contact@cordesensible.fr'),
(2, 2, 'Piano Accord', 5, 'Avenue des Touches', 69002, 'Lyon', 987654321, 'contact@pianoaccord.fr'),
(3, 2, 'Harmonie Piano', 12, 'Boulevard Mozart', 75016, 'Paris', 147258369, 'contact@harmoniepiano.fr');

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tranche_id` int(11) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `num_rue` int(11) DEFAULT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `copos` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_52520D07B76F6B31` (`tranche_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tranche`
--

INSERT INTO `tranche` (`id`, `libelle`, `quotient_mini`) VALUES
(1, 'Tranche A', 0),
(2, 'Tranche B', 601),
(3, 'Tranche C', 1001),
(4, 'Tranche D', 1501);

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
(1, 'Cours Individuel'),
(2, 'Cours Collectif'),
(3, 'Atelier Éveil');

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

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'admin@emusic.fr', '[\"ROLE_ADMIN\"]', '$2y$13$kU5GoWNIArQgbZmK8JU2RunDP/0hDYhFMjNGIoHu/8ff9wv.h8Xt.'),
(2, 'gestion@emusic.fr', '[\"ROLE_GESTIONNAIRE\"]', '$2y$13$l/JQ1C7VXFyrai.ewcmpKuN5DF188l8MqLJUQ4fSO1UXp.P4uTw8O'),
(3, 'marie.dupont@musique.fr', '[\"ROLE_PROF\"]', '$2y$13$N9ZkADi7ou7wAjbwcLjGTOsjhiIMf0qxGqe6x91/Zi.7fLvzV9H/u'),
(4, 'sophie.leblanc@mail.fr', '[\"ROLE_ELEVE\"]', '$2y$13$tRqNwcxjOZgy9SmvZSjY4.0fhcPwOaNNqoqfWt2oJOk3AG0edADDO'),
(5, 'paul.martin@musique.fr', '[\"ROLE_PROF\"]', '$2y$13$2gReDnkO8mrHwrius9V7de5GqWaKgmHId3t.9yOWRF9YPVSsJTz6W'),
(6, 'lucie.bernard@musique.fr', '[\"ROLE_PROF\"]', '$2y$13$o8cpn.WRK5mrOQtD/58D5eO/7rOWXN.c7BrE5GLp8ZerFMo/v3TPq'),
(7, 'julien.petit@musique.fr', '[\"ROLE_PROF\"]', '$2y$13$MHZqVUOW78.vnY4qhAOKJu9YCz19bEWJ65CDBFMjnRvRTAIgPdBAG$2y$13$RAED8IwieKRzTa8SroVbXO27qwygGYzb08VjnGrzjlHNRvUsceYFy'),
(8, 'sophie.marie@mail.fr', '[\"ROLE_ELEVE\"]', '$2y$13$mE7VJqobyBGv/IMrODcRsO2sx8ZpoIRbcuqmasH7bJ50.i87RQrRC'),
(9, 'thomas.dubois@mail.fr', '[\"ROLE_ELEVE\"]', '$2y$13$uoD7zZu2kjCU7fCPjxte9.RIbUaPJqDZ9oWrAu7CvnuTQQ.VCquxq'),
(10, 'clara.dubois@example.com', '[\"ROLE_ELEVE\"]', '$2y$13$cgchPVjJdwBkr38Z6kpP3OPmtCRXwPHjk1E1bZAoKniLIoa7ayBHu'),
(11, 'gabriel.lefevre@example.com', '[\"ROLE_ELEVE\"]', '$2y$13$Z3FQTSUiEUWLx0skY8KccutFbIL9g8NAyAuABtudfB.yEWx.9SGi2'),
(12, 'louise.bernard@example.com', '[\"ROLE_ELEVE\"]', '$2y$13$Lp5C3tdjsdaMhP37ub8O0e.XQAg2tDhB.BScRvrNVO69/F04STG4m'),
(13, 'paul.durand@example.com', '[\"ROLE_ELEVE\"]', '$2y$13$CBtyLTCtMhC5vjwEgUrOeexE/RzkUJWekg0BruDmlAILWMJfVCqz2'),
(14, 'manon.petit@example.com', '[\"ROLE_ELEVE\"]', '$2y$13$tQ6lJRMRPocDBkQoseiDG.42h/g4Ii/ha9X8UDFd/EdTiT2qhiIRa');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accessoire`
--
ALTER TABLE `accessoire`
  ADD CONSTRAINT `FK_8FD026ACF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_880E0D76A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `contrat_pret`
--
ALTER TABLE `contrat_pret`
  ADD CONSTRAINT `FK_1FB84C67A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`),
  ADD CONSTRAINT `FK_1FB84C67CF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `FK_FDCA8C9C220C6AD0` FOREIGN KEY (`jour_id`) REFERENCES `jour` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9C7C1CAAA9` FOREIGN KEY (`type_instrument_id`) REFERENCES `type_instrument` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9CBAB22EE9` FOREIGN KEY (`professeur_id`) REFERENCES `professeur` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9CC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `FK_ECA105F7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_ECA105F7B76F6B31` FOREIGN KEY (`tranche_id`) REFERENCES `tranche` (`id`);

--
-- Contraintes pour la table `eleve_responsable`
--
ALTER TABLE `eleve_responsable`
  ADD CONSTRAINT `FK_D735073053C59D72` FOREIGN KEY (`responsable_id`) REFERENCES `responsable` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D7350730A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `gestionnaire`
--
ALTER TABLE `gestionnaire`
  ADD CONSTRAINT `FK_F4461B20A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D67ECF78B0` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`),
  ADD CONSTRAINT `FK_5E90F6D6A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`);

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
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `FK_D11814AB8A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`),
  ADD CONSTRAINT `FK_D11814ABB2AF233D` FOREIGN KEY (`contrat_pret_id`) REFERENCES `contrat_pret` (`id`),
  ADD CONSTRAINT `FK_D11814ABCF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `FK_B1DC7A1E5DAC5993` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`);

--
-- Contraintes pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `FK_17A55299A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `professeur_type_instrument`
--
ALTER TABLE `professeur_type_instrument`
  ADD CONSTRAINT `FK_1E1989D67C1CAAA9` FOREIGN KEY (`type_instrument_id`) REFERENCES `type_instrument` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1E1989D6BAB22EE9` FOREIGN KEY (`professeur_id`) REFERENCES `professeur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `professionnel`
--
ALTER TABLE `professionnel`
  ADD CONSTRAINT `FK_7A28C10FED16FA20` FOREIGN KEY (`metier_id`) REFERENCES `metier` (`id`);

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

--
-- Contraintes pour la table `type_instrument`
--
ALTER TABLE `type_instrument`
  ADD CONSTRAINT `FK_21BCBFF8CE879FB1` FOREIGN KEY (`classe_instrument_id`) REFERENCES `classe_instrument` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
