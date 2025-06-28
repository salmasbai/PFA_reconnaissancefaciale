-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 28 juin 2025 à 10:55
-- Version du serveur : 9.1.0
-- Version de PHP : 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_etudiants`
--

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

DROP TABLE IF EXISTS `absences`;
CREATE TABLE IF NOT EXISTS `absences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `etudiant_id` int NOT NULL,
  `matiere_id` int NOT NULL,
  `date` date NOT NULL,
  `heure_debut_creneau` time DEFAULT NULL,
  `heure_fin_creneau` time DEFAULT NULL,
  `justifiee` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `etudiant_id` (`etudiant_id`),
  KEY `matiere_id` (`matiere_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `absences`
--

INSERT INTO `absences` (`id`, `etudiant_id`, `matiere_id`, `date`, `heure_debut_creneau`, `heure_fin_creneau`, `justifiee`) VALUES
(1, 17, 1, '2025-06-02', '14:00:00', '16:00:00', 1),
(2, 12, 1, '2025-06-02', '14:00:00', '16:00:00', 0),
(5, 12, 5, '2025-06-16', '10:00:00', '12:00:00', 0),
(6, 15, 5, '2025-06-16', '10:00:00', '12:00:00', 0),
(10, 18, 1, '2025-06-02', '08:00:00', '10:00:00', 0),
(12, 12, 1, '2025-06-02', '08:00:00', '10:00:00', 1),
(13, 16, 1, '2025-06-02', '08:00:00', '10:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_classe` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `niveau` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `filiere` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `annee_universitaire` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `filiere_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_classes_filiere` (`filiere_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `nom_classe`, `niveau`, `filiere`, `annee_universitaire`, `filiere_id`) VALUES
(3, 'ITIRC1', '1', '', '2025/2026', 1),
(4, 'ITIRC2', '2', '', '2025/2026', 1),
(5, 'ITIRC3', '3', '', '2025/2026', 1),
(6, 'GC1', '1', '', '2025/2026', 2),
(7, 'GC2', '2', '', '2025/2026', 2),
(8, 'GC3', '3', '', '2025/2026', 2),
(12, 'CP 1', '1', '', '2025/2026', 4),
(13, 'CP 2', '2', '', '2025/2026', 4),
(14, 'IDSCC1', '1', '', '2025/2026', 5),
(15, 'IDSCC2', '2', '', '2025/2026', 5),
(16, 'IDSCC3', '3', '', '2025/2026', 5),
(17, 'SICS1', '1', '', '2025/2026', 6),
(18, 'SICS2', '2', '', '2025/2026', 6),
(19, 'SICS3', '3', '', '2025/2026', 6),
(20, 'GE1', '1', '', '2025/2026', 7),
(21, 'GE2', '2', '', '2025/2026', 7),
(22, 'GE3', '3', '', '2025/2026', 7),
(23, 'GI1', '1', '', '2025/2026', 8),
(24, 'GI2', '2', '', '2025/2026', 8),
(25, 'GI3', '3', '', '2025/2026', 8),
(26, 'GINDS1', '1', '', '2025/2026', 9),
(27, 'GINDS2', '2', '', '2025/2026', 9),
(28, 'GINDS3', '3', '', '2025/2026', 9),
(29, 'GSEIR1', '1', '', '2025/2026', 10),
(30, 'GSEIR2', '2', '', '2025/2026', 10),
(31, 'GSEIR3', '3', '', '2025/2026', 10),
(32, 'MGSI1', '1', '', '2025/2026', 11),
(33, 'MGSI2', '2', '', '2025/2026', 11),
(34, 'MGSI3', '3', '', '2025/2026', 11);

-- --------------------------------------------------------

--
-- Structure de la table `classe_matiere`
--

DROP TABLE IF EXISTS `classe_matiere`;
CREATE TABLE IF NOT EXISTS `classe_matiere` (
  `classe_id` int NOT NULL,
  `matiere_id` int NOT NULL,
  PRIMARY KEY (`classe_id`,`matiere_id`),
  KEY `matiere_id` (`matiere_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classe_matiere`
--

INSERT INTO `classe_matiere` (`classe_id`, `matiere_id`) VALUES
(4, 1),
(4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `emploi_du_temps`
--

DROP TABLE IF EXISTS `emploi_du_temps`;
CREATE TABLE IF NOT EXISTS `emploi_du_temps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `classe_id` int NOT NULL,
  `jour_semaine` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `matiere_id` int DEFAULT NULL,
  `professeur_id` int DEFAULT NULL,
  `matiere` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `enseignant` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `salle` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `classe_id` (`classe_id`),
  KEY `fk_edt_matiere` (`matiere_id`),
  KEY `fk_edt_professeur` (`professeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emploi_du_temps`
--

INSERT INTO `emploi_du_temps` (`id`, `classe_id`, `jour_semaine`, `heure_debut`, `heure_fin`, `matiere_id`, `professeur_id`, `matiere`, `enseignant`, `salle`) VALUES
(129, 4, 'Lundi', '08:00:00', '10:00:00', 1, 7, 'Développement Web', 'Mohcine Bouksim', 'CE1'),
(130, 4, 'Lundi', '10:00:00', '12:00:00', 5, 8, 'Réseaux Informatiques', 'Chakib Taibi', 'CE1'),
(131, 4, 'Lundi', '14:00:00', '16:00:00', NULL, NULL, '', '', ''),
(132, 4, 'Lundi', '16:00:00', '18:00:00', NULL, NULL, '', '', ''),
(133, 4, 'Mardi', '08:00:00', '10:00:00', NULL, NULL, '', '', ''),
(134, 4, 'Mardi', '10:00:00', '12:00:00', NULL, NULL, '', '', ''),
(135, 4, 'Mardi', '14:00:00', '16:00:00', NULL, NULL, '', '', ''),
(136, 4, 'Mardi', '16:00:00', '18:00:00', NULL, NULL, '', '', ''),
(137, 4, 'Mercredi', '08:00:00', '10:00:00', NULL, NULL, '', '', ''),
(138, 4, 'Mercredi', '10:00:00', '12:00:00', NULL, NULL, '', '', ''),
(139, 4, 'Mercredi', '14:00:00', '16:00:00', NULL, NULL, '', '', ''),
(140, 4, 'Mercredi', '16:00:00', '18:00:00', NULL, NULL, '', '', ''),
(141, 4, 'Jeudi', '08:00:00', '10:00:00', NULL, NULL, '', '', ''),
(142, 4, 'Jeudi', '10:00:00', '12:00:00', NULL, NULL, '', '', ''),
(143, 4, 'Jeudi', '14:00:00', '16:00:00', NULL, NULL, '', '', ''),
(144, 4, 'Jeudi', '16:00:00', '18:00:00', NULL, NULL, '', '', ''),
(145, 4, 'Vendredi', '08:00:00', '10:00:00', NULL, NULL, '', '', ''),
(146, 4, 'Vendredi', '10:00:00', '12:00:00', NULL, NULL, '', '', ''),
(147, 4, 'Vendredi', '14:00:00', '16:00:00', NULL, NULL, '', '', ''),
(148, 4, 'Vendredi', '16:00:00', '18:00:00', NULL, NULL, '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` text COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` text COLLATE utf8mb4_general_ci NOT NULL,
  `numero_etudiant` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `photo_path` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `code_massar` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_apogee` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `cycle` enum('CP','ING') COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `classe_id` int DEFAULT NULL,
  `filiere_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_massar` (`code_massar`),
  UNIQUE KEY `numero_apogee` (`numero_apogee`),
  KEY `fk_etud_user` (`user_id`),
  KEY `fk_etudiants_classe` (`classe_id`),
  KEY `fk_etudiants_filiere` (`filiere_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `numero_etudiant`, `photo_path`, `code_massar`, `numero_apogee`, `cycle`, `user_id`, `classe_id`, `filiere_id`) VALUES
(5, 'ESSBAI', 'Salma', 'SS7890900', '/uploads/etudiants/2025/05/etud_6ab44f43.png', 'E12345640', 'XX123456', 'ING', 4, NULL, NULL),
(7, 'ouary', 'imane', 'SS7890986', '/uploads/etudiants/2025/05/etud_a05b5cce.jpg', 'E12345699', 'XX123499', 'ING', 3, NULL, NULL),
(8, 'ABDERAHMAN', 'ABDERAHMAN', '6898990', '/uploads/etudiants/2025/06/etud_c7a3dc1f.png', 'E12366640', 'XX100456', 'ING', NULL, NULL, NULL),
(9, 'MALAK', 'LAKHEL', 'SS70000', '/uploads/etudiants/2025/06/etud_6859c24b1267a.jpg', 'H12345660', '98556565', 'ING', NULL, 4, 1),
(11, 'ouissaaden', 'abir', 'SS7890000', '/uploads/etudiants/2025/06/etud_6859c60a8a074.PNG', 'H12300660', 'XX123400', 'CP', NULL, 12, 4),
(12, 'ESSBAI', 'FATIMA', 'SS00000', '/uploads/etudiants/2025/06/etud_6859c7672d514.jpeg', 'E1000000', 'XX100000', 'ING', NULL, 4, 1),
(13, 'FATIMA', 'ZAHRA', 'SS0000000', '/uploads/etudiants/2025/06/etud_6859e8ed85df6.jfif', 'E12345678', 'XX1123450', 'ING', NULL, 4, 1),
(14, 'FA', 'TY', 'SS789888', '/uploads/etudiants/2025/06/etud_6859e9b8e7b7a.jfif', 'h1340178799', 'XX120000', 'CP', NULL, 13, 4),
(15, 'zineb', 'abou', 'SS7855986', '/uploads/etudiants/2025/06/etud_6859ef162bf32.png', 'E12665678', 'XX155456', 'ING', NULL, 4, 1),
(16, 'MALAK', 'SAFII', 'SS789077', '/uploads/etudiants/2025/06/etud_6859f00c4f45d.jpg', 'H12345555', 'XX125555', 'ING', NULL, 4, 1),
(17, 'ABDOU', 'NADJMA', 'SS0000000', '/uploads/etudiants/2025/06/etud_6859f0ca53c07.jfif', 'E0987543', 'XX654321', 'ING', NULL, 4, 1),
(18, 'ARIJ', 'BENCHEKROUN', 'SS7895555', '', 'E12355555', 'XX100006', 'ING', 5, 4, 1),
(19, 'azdaag', 'abdellah', 'SS7844486', '', 'E5555660', 'XX444400', 'ING', 9, 4, 1),
(20, 'OUARY', 'Emen', 'A999098', '', 'J139316440', 'A999098', 'ING', 10, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

DROP TABLE IF EXISTS `filieres`;
CREATE TABLE IF NOT EXISTS `filieres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_filiere` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `type_filiere` enum('prepa','ingenieur','autre') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_filiere` (`nom_filiere`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`id`, `nom_filiere`, `type_filiere`) VALUES
(1, 'ITIRC', 'ingenieur'),
(2, 'GC', 'ingenieur'),
(4, 'CP', 'prepa'),
(5, 'IDSCC', 'ingenieur'),
(6, 'SICS', 'ingenieur'),
(7, 'GE', 'ingenieur'),
(8, 'GI', 'ingenieur'),
(9, 'GINDS', 'ingenieur'),
(10, 'GSEIR', 'ingenieur'),
(11, 'MGSI', 'ingenieur');

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `professeur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `professeur_id` (`professeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `code`, `professeur_id`) VALUES
(1, 'DEV', 'AD0185', 7),
(5, 'RESEAUX', 'AD0186', 8);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(191) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeurs`
--

DROP TABLE IF EXISTS `professeurs`;
CREATE TABLE IF NOT EXISTS `professeurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `specialite` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_prof_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `professeurs`
--

INSERT INTO `professeurs` (`id`, `nom`, `prenom`, `email`, `telephone`, `specialite`, `date_ajout`, `user_id`) VALUES
(2, 'mrimi', 'mustapha', 'mrimimustapha0@gmail.com', '0606060606', 'maths', '2025-05-22 10:07:43', 2),
(3, 'MOHAMMED', 'NACIRI', 'NACIRIMOHAMMED@GMAIL.com', '0600098888', 'maths', '2025-06-23 14:26:46', NULL),
(5, 'boukssim', 'mouhssine', 'mouhssine.boukssim.25@ump.ac.ma', '0609090909', 'DEV', '2025-06-24 00:40:50', 7),
(6, 'TAIBI', 'CHAKIB', 'chakib.taibi.25@ump.ac.ma', '0700437280', 'RESEAUX', '2025-06-25 01:24:46', 8);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','professeur','etudiant') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'mrimi', 'mustapha', 'mrimimustapha0@gmail.com', '$2y$10$N/XzFK6cDfC4R7IJVB2ELOR7GX.AoGKxJLBAHjTzDdgDlcBIDCAFq', 'professeur', '2025-05-22 10:09:34'),
(3, 'ouary', 'imane', 'ouaryimane0@gmail.com', '$2y$10$o9gF97labX9NPJUlJn6D2OUNizENhtu8vmPVlErVj3f5ldjmhT7k6', 'etudiant', '2025-05-22 10:10:12'),
(4, 'essbai', 'salma', 'essbaisalma0@gmail.com', '$2y$10$9nw.g9yaePM5koWTPG60t.fyzXSwX/RQj5LyvgmSkVp89veOvnh0.', 'etudiant', '2025-05-22 10:12:03'),
(5, 'ARIJ', 'BENCHEKROUN', 'benchekroun.arij.25@ump.ac.ma', '$2y$10$okRaPlShGm1l4H42vO1TdebA9Pmsd4N8CS10qCYjOkcJEYEbZgZXW', 'etudiant', '2025-06-24 00:33:46'),
(6, 'taibi', 'chakib', 'taibichakib@gmail.com', '$2y$10$s9KgLszjEzmP11NNrNaMru74JWomE4Zl3x.1ZmE16Q8DpiQ4tbD/m', 'professeur', '2025-06-24 00:38:29'),
(7, 'boukssim', 'mouhssine', 'mouhssine.boukssim.25@ump.ac.ma', '$2y$10$5G55TDtBCf29KyqLOBTus../l7iRcLxsDEKcE5tL1kc6n7chfuYt2', 'professeur', '2025-06-24 00:40:50'),
(8, 'TAIBI', 'CHAKIB', 'chakib.taibi.25@ump.ac.ma', '$2y$10$b0ozwOQCos2xW.BpxHCdHeCpfbl24BKZfKXzyP80r6PqnHjU6Js9e', 'professeur', '2025-06-25 01:24:46'),
(9, 'azdaag', 'abdellah', 'abdellah.azdaag.25@ump.ac.ma', '$2y$10$3gLU/XipeiAxDLvd8.tQRuHrIP/CiHxRhlyunirhxqLDRQldOf7Ui', 'etudiant', '2025-06-26 14:43:45'),
(10, 'OUARY', 'Emen', 'imane.ouary20@ump.ac.ma', '$2y$12$S55O/csXWFaAkI1Nj3C/b.IjmCFJiAafsY8viKDjTDPdmW61CP3we', 'etudiant', '2025-06-27 21:45:02');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absences_ibfk_2` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_classes_filiere` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `classe_matiere`
--
ALTER TABLE `classe_matiere`
  ADD CONSTRAINT `classe_matiere_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classe_matiere_ibfk_2` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `emploi_du_temps`
--
ALTER TABLE `emploi_du_temps`
  ADD CONSTRAINT `emploi_du_temps_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_edt_matiere` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_edt_professeur` FOREIGN KEY (`professeur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_etud_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `fk_etudiants_classe` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_etudiants_filiere` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD CONSTRAINT `matieres_ibfk_1` FOREIGN KEY (`professeur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `professeurs`
--
ALTER TABLE `professeurs`
  ADD CONSTRAINT `fk_prof_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
