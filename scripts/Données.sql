-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : lun. 24 nov. 2025 à 12:54
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

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `user_id`, `email`, `password`) VALUES
(1, 1, 'admin@emusic.fr', '$2y$13$9wjfv3F9gTxMj9rXNdcxsO8CYZvl6o4naJznFGSLvX0IzCFq8uUye');

--
-- Déchargement des données de la table `classe_instrument`
--

INSERT INTO `classe_instrument` (`id`, `libelle`) VALUES
(1, 'Cordes'),
(2, 'Bois'),
(3, 'Cuivres'),
(4, 'Percussions'),
(5, 'Claviers');

--
-- Déchargement des données de la table `contrat_pret`
--

INSERT INTO `contrat_pret` (`id`, `eleve_id`, `instrument_id`, `num_contrat`, `date_debut`, `date_fin`, `etat_detaille_debut`, `etat_detaille_retour`, `attestation_assurance`) VALUES
(1, 3, 2, 'CPT-2023-001', '2023-09-01', '2024-06-30', 'Instrument en parfait état, quelques micro-rayures sur le corps.', 'Superbe état', 1),
(2, 4, 1, 'CPT-2023-002', '2023-09-15', '2024-07-15', 'Petite bosse sur le pavillon, cordes neuves.', 'Non évalué', 0),
(3, 5, 4, 'CPT-2023-003', '2023-10-01', '2024-08-30', 'Très bon état général, housse fournie légèrement usée.', 'Non évalué', 1),
(4, 6, 3, 'CPT-2023-004', '2023-10-10', '2024-09-10', 'Usure normale, quelques marques d\'utilisation visibles.', 'Non évalué', 1),
(5, 7, 5, 'CPT-2023-005', '2023-11-01', '2024-10-31', 'Neuf, sans aucun défaut visible.', 'Non évalué', 0);

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

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `type_id`, `jour_id`, `type_instrument_id`, `professeur_id`, `libelle`, `age_mini`, `heure_debut`, `heure_fin`) VALUES
(1, 1, 1, 1, 1, 'batterie', 6, '16:00:00', '17:00:00'),
(2, 2, 3, 2, 1, 'Guitare', 8, '14:30:00', '16:00:00'),
(3, 1, 5, 8, 4, 'Piano', 14, '18:30:00', '19:30:00');

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20251112081853', '2025-11-12 08:20:24', 20598),
('DoctrineMigrations\\Version20251112101819', '2025-11-12 10:18:43', 1597),
('DoctrineMigrations\\Version20251112104208', '2025-11-12 10:42:13', 553),
('DoctrineMigrations\\Version20251112104429', '2025-11-12 10:44:35', 147),
('DoctrineMigrations\\Version20251112105229', '2025-11-12 10:52:36', 1041);

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

--
-- Déchargement des données de la table `gestionnaire`
--

INSERT INTO `gestionnaire` (`id`, `email`, `roles`, `password`, `user_id`) VALUES
(1, 'gestion@emusic.fr', '', '$2y$13$eX1mv9luD89fNdMVMGzvXeDdd8noRmowTHFBKlD17wTAPoB3fSSW', 2);

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

--
-- Déchargement des données de la table `instrument_couleur`
--

INSERT INTO `instrument_couleur` (`instrument_id`, `couleur_id`) VALUES
(5, 6);

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`id`, `professionnel_id`, `contrat_pret_id`, `instrument_id`, `date_debut`, `date_fin`, `descriptif`, `prix`, `quotite`) VALUES
(1, 1, 1, 1, '2025-10-20 09:00:00', '2025-10-20 12:00:00', 'Réparation du violon - Remplacement cordier', 120, 1),
(2, 3, 2, 3, '2025-11-05 14:00:00', '2025-11-05 16:30:00', 'Accordage et harmonisation du piano Steinway (num_serie: PIA202009)', 250, 1);

--
-- Déchargement des données de la table `jour`
--

INSERT INTO `jour` (`id`, `libelle`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi');

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

--
-- Déchargement des données de la table `metier`
--

INSERT INTO `metier` (`id`, `libelle`) VALUES
(1, 'Luthier'),
(2, 'Technicien pianos'),
(3, 'Réparateur instruments à vent');

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`id`, `user_id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 3, 'Dupont', 'Marie', 13, 'Rue des Écoles', 75005, 'Paris', 102030405, 'marie.dupont@musique.fr'),
(2, 5, 'Martin', 'Paul', 8, 'Avenue Mozart', 69006, 'Lyon', 478123456, 'paul.martin@musique.fr'),
(3, 6, 'Bernard', 'Lucie', 3, 'Rue Beethoven', 31000, 'Toulouse', 561874523, 'lucie.bernard@musique.fr'),
(4, 7, 'Petit', 'Julien', 27, 'Boulevard Chopin', 44000, 'Nantes', 240556677, 'julien.petit@musique.fr');

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

--
-- Déchargement des données de la table `professionnel`
--

INSERT INTO `professionnel` (`id`, `metier_id`, `nom`, `num_rue`, `rue`, `cp`, `ville`, `tel`, `mail`) VALUES
(1, 1, 'Atelier Corde sensible', 10, 'Rue de Rome', 75008, 'Paris', 123456789, 'contact@cordesensible.fr'),
(2, 2, 'Piano Accord', 5, 'Avenue des Touches', 69002, 'Lyon', 987654321, 'contact@pianoaccord.fr'),
(3, 2, 'Harmonie Piano', 12, 'Boulevard Mozart', 75016, 'Paris', 147258369, 'contact@harmoniepiano.fr');

--
-- Déchargement des données de la table `tranche`
--

INSERT INTO `tranche` (`id`, `libelle`, `quotient_mini`) VALUES
(1, 'Tranche A', 0),
(2, 'Tranche B', 601),
(3, 'Tranche C', 1001),
(4, 'Tranche D', 1501);

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `nom`) VALUES
(1, 'Cours Individuel'),
(2, 'Cours Collectif'),
(3, 'Atelier Éveil');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
