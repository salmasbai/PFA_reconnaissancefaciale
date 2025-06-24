-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 24 juin 2025 à 19:54
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

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

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `justifiee` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `nom_classe` varchar(100) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  `filiere` varchar(100) NOT NULL,
  `annee_universitaire` varchar(20) DEFAULT NULL,
  `filiere_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Structure de la table `emploi_du_temps`
--

CREATE TABLE `emploi_du_temps` (
  `id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL,
  `jour_semaine` varchar(20) NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `matiere` varchar(100) NOT NULL,
  `enseignant` varchar(100) NOT NULL,
  `salle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emploi_du_temps`
--

INSERT INTO `emploi_du_temps` (`id`, `classe_id`, `jour_semaine`, `heure_debut`, `heure_fin`, `matiere`, `enseignant`, `salle`) VALUES
(4, 4, 'Lundi', '08:00:00', '10:00:00', 'DEV', 'boukssim mouhssine', 'CE1'),
(5, 4, 'Lundi', '10:00:00', '12:00:00', 'RESEUX', 'taibi chakib', 'C1');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `numero_etudiant` varchar(20) NOT NULL,
  `photo_path` varchar(100) NOT NULL,
  `code_massar` varchar(20) NOT NULL,
  `numero_apogee` varchar(20) NOT NULL,
  `cycle` enum('CP','ING') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `classe_id` int(11) DEFAULT NULL,
  `filiere_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(18, 'ARIJ', 'BENCHEKROUN', 'SS7895555', '', 'E12355555', 'XX100006', 'ING', 5, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE `filieres` (
  `id` int(11) NOT NULL,
  `nom_filiere` varchar(100) NOT NULL,
  `type_filiere` enum('prepa','ingenieur','autre') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `matieres` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `professeur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeurs`
--

CREATE TABLE `professeurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `professeurs`
--

INSERT INTO `professeurs` (`id`, `nom`, `prenom`, `email`, `telephone`, `specialite`, `date_ajout`, `user_id`) VALUES
(2, 'mrimi', 'mustapha', 'mrimimustapha0@gmail.com', '0606060606', 'maths', '2025-05-22 10:07:43', 2),
(3, 'MOHAMMED', 'NACIRI', 'NACIRIMOHAMMED@GMAIL.com', '0600098888', 'maths', '2025-06-23 14:26:46', NULL),
(4, 'taibi', 'chakib', 'taibichakib@gmail.com', '0606060606', 'PC', '2025-06-24 00:38:29', 6),
(5, 'boukssim', 'mouhssine', 'mouhssine.boukssim.25@ump.ac.ma', '0609090909', 'DEV', '2025-06-24 00:40:50', 7);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','professeur','etudiant') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'mrimi', 'mustapha', 'mrimimustapha0@gmail.com', '$2y$10$N/XzFK6cDfC4R7IJVB2ELOR7GX.AoGKxJLBAHjTzDdgDlcBIDCAFq', 'professeur', '2025-05-22 10:09:34'),
(3, 'ouary', 'imane', 'ouaryimane0@gmail.com', '$2y$10$o9gF97labX9NPJUlJn6D2OUNizENhtu8vmPVlErVj3f5ldjmhT7k6', 'etudiant', '2025-05-22 10:10:12'),
(4, 'essbai', 'salma', 'essbaisalma0@gmail.com', '$2y$10$9nw.g9yaePM5koWTPG60t.fyzXSwX/RQj5LyvgmSkVp89veOvnh0.', 'etudiant', '2025-05-22 10:12:03'),
(5, 'ARIJ', 'BENCHEKROUN', 'benchekroun.arij.25@ump.ac.ma', '$2y$10$okRaPlShGm1l4H42vO1TdebA9Pmsd4N8CS10qCYjOkcJEYEbZgZXW', 'etudiant', '2025-06-24 00:33:46'),
(6, 'taibi', 'chakib', 'taibichakib@gmail.com', '$2y$10$s9KgLszjEzmP11NNrNaMru74JWomE4Zl3x.1ZmE16Q8DpiQ4tbD/m', 'professeur', '2025-06-24 00:38:29'),
(7, 'boukssim', 'mouhssine', 'mouhssine.boukssim.25@ump.ac.ma', '$2y$10$5G55TDtBCf29KyqLOBTus../l7iRcLxsDEKcE5tL1kc6n7chfuYt2', 'professeur', '2025-06-24 00:40:50');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiant_id` (`etudiant_id`),
  ADD KEY `matiere_id` (`matiere_id`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_classes_filiere` (`filiere_id`);

--
-- Index pour la table `emploi_du_temps`
--
ALTER TABLE `emploi_du_temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classe_id` (`classe_id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_massar` (`code_massar`),
  ADD UNIQUE KEY `numero_apogee` (`numero_apogee`),
  ADD KEY `fk_etud_user` (`user_id`),
  ADD KEY `fk_etudiants_classe` (`classe_id`),
  ADD KEY `fk_etudiants_filiere` (`filiere_id`);

--
-- Index pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_filiere` (`nom_filiere`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `professeur_id` (`professeur_id`);

--
-- Index pour la table `professeurs`
--
ALTER TABLE `professeurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_prof_user` (`user_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `emploi_du_temps`
--
ALTER TABLE `emploi_du_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `professeurs`
--
ALTER TABLE `professeurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Contraintes pour la table `emploi_du_temps`
--
ALTER TABLE `emploi_du_temps`
  ADD CONSTRAINT `emploi_du_temps_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

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
