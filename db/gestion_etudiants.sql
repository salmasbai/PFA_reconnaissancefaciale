-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 27 juin 2025 à 19:13
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
-- Base de données : `aeroport_test1`
--
CREATE DATABASE IF NOT EXISTS `aeroport_test1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aeroport_test1`;
--
-- Base de données : `aeroport_test2`
--
CREATE DATABASE IF NOT EXISTS `aeroport_test2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aeroport_test2`;

-- --------------------------------------------------------

--
-- Structure de la table `ascenseurs_escaliers`
--

CREATE TABLE `ascenseurs_escaliers` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ascenseurs_escaliers`
--

INSERT INTO `ascenseurs_escaliers` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, 'MC pano gauche', 1, 1, 100, 60, 77.7778, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 2, 'MC pano droit', 1, 1, 100, 60, 0, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 3, 'MC arrivé', 1, 1, 100, 20, 0, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 4, 'Asc police', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 5, 'Asc STB', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 6, 'esc dep droit', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 7, 'esc depart gauche', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 8, 'esc arrivee droit', 1, 1, 100, 0, 0, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 9, 'esc arrivee gauche', 1, 1, 100, 0, 0, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `ascenseurs_escaliers_2024_01`
--

CREATE TABLE `ascenseurs_escaliers_2024_01` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ascenseurs_escaliers_2024_01`
--

INSERT INTO `ascenseurs_escaliers_2024_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, 'MC pano gauche', 1, 1, 100, 60, 60, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 2, 'MC pano droit', 1, 1, 100, 60, 60, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 3, 'MC arrivé', 1, 1, 100, 20, 60, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 4, 'Asc police', 1, 1, 100, 100, 60, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 5, 'Asc STB', 1, 1, 100, 100, 60, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 6, 'esc dep droit', 1, 1, 100, 100, 60, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 7, 'esc depart gauche', 1, 1, 100, 100, 60, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 8, 'esc arrivee droit', 1, 1, 100, 0, 60, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 9, 'esc arrivee gauche', 1, 1, 100, 0, 60, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `ascenseurs_escaliers_2024_02`
--

CREATE TABLE `ascenseurs_escaliers_2024_02` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ascenseurs_escaliers_2024_02`
--

INSERT INTO `ascenseurs_escaliers_2024_02` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, 'MC pano gauche', 1, 1, 100, 60, 60, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 2, 'MC pano droit', 1, 1, 100, 60, 60, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 3, 'MC arrivé', 1, 1, 100, 20, 60, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 4, 'Asc police', 1, 1, 100, 100, 60, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 5, 'Asc STB', 1, 1, 100, 100, 60, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 6, 'esc dep droit', 1, 1, 100, 100, 60, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 7, 'esc depart gauche', 1, 1, 100, 100, 60, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 8, 'esc arrivee droit', 1, 1, 100, 0, 60, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 9, 'esc arrivee gauche', 1, 1, 100, 0, 60, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `ascenseurs_escaliers_2024_03`
--

CREATE TABLE `ascenseurs_escaliers_2024_03` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ascenseurs_escaliers_2024_03`
--

INSERT INTO `ascenseurs_escaliers_2024_03` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, 'MC pano gauche', 1, 1, 100, 99, 64.3333, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 2, 'MC pano droit', 1, 1, 100, 60, 64.3333, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 3, 'MC arrivé', 1, 1, 100, 20, 64.3333, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 4, 'Asc police', 1, 1, 100, 100, 64.3333, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 5, 'Asc STB', 1, 1, 100, 100, 64.3333, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 6, 'esc dep droit', 1, 1, 100, 100, 64.3333, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 7, 'esc depart gauche', 1, 1, 100, 100, 64.3333, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 8, 'esc arrivee droit', 1, 1, 100, 0, 64.3333, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 9, 'esc arrivee gauche', 1, 1, 100, 0, 64.3333, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `ascenseurs_escaliers_2025_01`
--

CREATE TABLE `ascenseurs_escaliers_2025_01` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ascenseurs_escaliers_2025_01`
--

INSERT INTO `ascenseurs_escaliers_2025_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, 'MC pano gauche', 5, 1, 100, 60, 77.7778, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 2, 'MC pano droit', 1, 1, 100, 60, 0, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 3, 'MC arrivé', 1, 1, 100, 20, 0, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 4, 'Asc police', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 5, 'Asc STB', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 6, 'esc dep droit', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 7, 'esc depart gauche', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 8, 'esc arrivee droit', 1, 1, 100, 0, 0, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 9, 'esc arrivee gauche', 1, 1, 100, 0, 0, 1, 1, 1, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `balisage_lumineux`
--

CREATE TABLE `balisage_lumineux` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `balisage_lumineux`
--

INSERT INTO `balisage_lumineux` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `balisage_lumineux_2024_01`
--

CREATE TABLE `balisage_lumineux_2024_01` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `balisage_lumineux_2024_01`
--

INSERT INTO `balisage_lumineux_2024_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `balisage_lumineux_2024_02`
--

CREATE TABLE `balisage_lumineux_2024_02` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `balisage_lumineux_2024_02`
--

INSERT INTO `balisage_lumineux_2024_02` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `balisage_lumineux_2024_03`
--

CREATE TABLE `balisage_lumineux_2024_03` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `balisage_lumineux_2024_03`
--

INSERT INTO `balisage_lumineux_2024_03` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `balisage_lumineux_2025_01`
--

CREATE TABLE `balisage_lumineux_2025_01` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `balisage_lumineux_2025_01`
--

INSERT INTO `balisage_lumineux_2025_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('Installations électriques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `billans`
--

CREATE TABLE `billans` (
  `id` int(11) NOT NULL,
  `month` varchar(2) NOT NULL,
  `year` varchar(4) NOT NULL,
  `data_field` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `billans`
--

INSERT INTO `billans` (`id`, `month`, `year`, `data_field`) VALUES
(1, '03', '2024', ''),
(2, '03', '2024', ''),
(3, '01', '2024', ''),
(4, '03', '2024', ''),
(5, '03', '2024', ''),
(6, '01', '2024', ''),
(7, '01', '2024', '');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_of_table`
--

CREATE TABLE `categorie_of_table` (
  `id_table` int(11) NOT NULL,
  `nom_table` varchar(100) DEFAULT NULL,
  `categorie_table` varchar(200) DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie_of_table`
--

INSERT INTO `categorie_of_table` (`id_table`, `nom_table`, `categorie_table`, `date_recorded`) VALUES
(15, 'Postes HTABT', 'Installations électriques', '2024-02-01'),
(16, 'Groupes electrogènes classiques et temps zéro', 'Installations électriques', '2024-02-01'),
(17, 'Onduleurs', 'Installations électriques', '2024-02-01'),
(18, 'Basse tension et éclairage public', 'Installations électriques', '2024-02-01'),
(19, 'Balisage lumineux', 'Installations électriques', '2024-02-01'),
(20, 'Système de climatisation', 'Installations thermiques', '2024-02-01'),
(21, '', 'Equipements de sûreté', '2024-02-01'),
(22, 'Système de sonorisation', 'Equipements électroniques', '2024-02-01'),
(23, 'Système de détection incendie', 'Equipements électroniques', '2024-02-01'),
(24, 'Ascenseurs, trottoirs roulants, escaliers mécaniques et montes charges', 'Equipements électromécaniques', '2024-02-01'),
(25, 'Portes automatiques', 'Equipements électromécaniques', '2024-02-01'),
(26, 'Passerelles (y compris les convertisseurs et mires de guidage)', 'Equipements électromécaniques', '2024-02-01'),
(27, 'y compris les bascules', 'Système de traitement des bagages(STB)', '2024-02-01'),
(28, 'Véhicules SLIA', 'Véhicules SLIA', '2024-02-01'),
(32, '', '', '2019-01-01'),
(33, '', '', '2019-01-01'),
(37, '', '', '2019-01-01'),
(38, '', '', '2019-02-01'),
(39, '', '', '2019-01-01'),
(115, 'postes_hta_bt', 'postes HTABT', NULL),
(116, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(117, 'onduleurs', 'onduleurs', NULL),
(118, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(119, 'balisage_lumineux', 'Balisage lumineux', NULL),
(120, 'equipements_climatisation', 'Système de climatisation', NULL),
(121, 'equipements_surete1', 'Equipements de sûreté', NULL),
(122, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(123, 'système_détection_incendie', 'Système de détection incendie', NULL),
(124, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(125, 'portes_automatiques', 'portes automatiques', NULL),
(126, 'passerelles', 'passerelles', NULL),
(127, 'stb', 'STB', NULL),
(128, 'slia', 'SLIA', NULL),
(129, 'postes_hta_bt', 'postes HTABT', NULL),
(130, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(131, 'onduleurs', 'onduleurs', NULL),
(132, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(133, 'balisage_lumineux', 'Balisage lumineux', NULL),
(134, 'equipements_climatisation', 'Système de climatisation', NULL),
(135, 'equipements_surete1', 'Equipements de sûreté', NULL),
(136, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(137, 'système_détection_incendie', 'Système de détection incendie', NULL),
(138, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(139, 'portes_automatiques', 'portes automatiques', NULL),
(140, 'passerelles', 'passerelles', NULL),
(141, 'stb', 'STB', NULL),
(142, 'slia', 'SLIA', NULL),
(143, 'postes_hta_bt', 'postes HTABT', NULL),
(144, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(145, 'onduleurs', 'onduleurs', NULL),
(146, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(147, 'balisage_lumineux', 'Balisage lumineux', NULL),
(148, 'equipements_climatisation', 'Système de climatisation', NULL),
(149, 'equipements_surete1', 'Equipements de sûreté', NULL),
(150, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(151, 'système_détection_incendie', 'Système de détection incendie', NULL),
(152, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(153, 'portes_automatiques', 'portes automatiques', NULL),
(154, 'passerelles', 'passerelles', NULL),
(155, 'stb', 'STB', NULL),
(156, 'slia', 'SLIA', NULL),
(157, 'postes_hta_bt', 'postes HTABT', NULL),
(158, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(159, 'onduleurs', 'onduleurs', NULL),
(160, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(161, 'balisage_lumineux', 'Balisage lumineux', NULL),
(162, 'equipements_climatisation', 'Système de climatisation', NULL),
(163, 'equipements_surete1', 'Equipements de sûreté', NULL),
(164, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(165, 'système_détection_incendie', 'Système de détection incendie', NULL),
(166, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(167, 'portes_automatiques', 'portes automatiques', NULL),
(168, 'passerelles', 'passerelles', NULL),
(169, 'stb', 'STB', NULL),
(170, 'slia', 'SLIA', NULL),
(171, 'postes_hta_bt', 'postes HTABT', NULL),
(172, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(173, 'onduleurs', 'onduleurs', NULL),
(174, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(175, 'balisage_lumineux', 'Balisage lumineux', NULL),
(176, 'equipements_climatisation', 'Système de climatisation', NULL),
(177, 'equipements_surete1', 'Equipements de sûreté', NULL),
(178, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(179, 'système_détection_incendie', 'Système de détection incendie', NULL),
(180, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(181, 'portes_automatiques', 'portes automatiques', NULL),
(182, 'passerelles', 'passerelles', NULL),
(183, 'stb', 'STB', NULL),
(184, 'slia', 'SLIA', NULL),
(185, 'postes_hta_bt', 'postes HTABT', NULL),
(186, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(187, 'onduleurs', 'onduleurs', NULL),
(188, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(189, 'balisage_lumineux', 'Balisage lumineux', NULL),
(190, 'equipements_climatisation', 'Système de climatisation', NULL),
(191, 'equipements_surete1', 'Equipements de sûreté', NULL),
(192, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(193, 'système_détection_incendie', 'Système de détection incendie', NULL),
(194, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(195, 'portes_automatiques', 'portes automatiques', NULL),
(196, 'passerelles', 'passerelles', NULL),
(197, 'stb', 'STB', NULL),
(198, 'slia', 'SLIA', NULL),
(199, 'postes_hta_bt', 'postes HTABT', NULL),
(200, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(201, 'onduleurs', 'onduleurs', NULL),
(202, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(203, 'balisage_lumineux', 'Balisage lumineux', NULL),
(204, 'equipements_climatisation', 'Système de climatisation', NULL),
(205, 'equipements_surete1', 'Equipements de sûreté', NULL),
(206, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(207, 'système_détection_incendie', 'Système de détection incendie', NULL),
(208, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(209, 'portes_automatiques', 'portes automatiques', NULL),
(210, 'passerelles', 'passerelles', NULL),
(211, 'stb', 'STB', NULL),
(212, 'slia', 'SLIA', NULL),
(213, 'postes_hta_bt', 'postes HTABT', NULL),
(214, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(215, 'onduleurs', 'onduleurs', NULL),
(216, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(217, 'balisage_lumineux', 'Balisage lumineux', NULL),
(218, 'equipements_climatisation', 'Système de climatisation', NULL),
(219, 'equipements_surete1', 'Equipements de sûreté', NULL),
(220, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(221, 'système_détection_incendie', 'Système de détection incendie', NULL),
(222, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(223, 'portes_automatiques', 'portes automatiques', NULL),
(224, 'passerelles', 'passerelles', NULL),
(225, 'stb', 'STB', NULL),
(226, 'slia', 'SLIA', NULL),
(227, 'postes_hta_bt', 'postes HTABT', NULL),
(228, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(229, 'onduleurs', 'onduleurs', NULL),
(230, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(231, 'balisage_lumineux', 'Balisage lumineux', NULL),
(232, 'equipements_climatisation', 'Système de climatisation', NULL),
(233, 'equipements_surete1', 'Equipements de sûreté', NULL),
(234, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(235, 'système_détection_incendie', 'Système de détection incendie', NULL),
(236, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(237, 'portes_automatiques', 'portes automatiques', NULL),
(238, 'passerelles', 'passerelles', NULL),
(239, 'stb', 'STB', NULL),
(240, 'slia', 'SLIA', NULL),
(241, 'postes_hta_bt', 'postes HTABT', NULL),
(242, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(243, 'onduleurs', 'onduleurs', NULL),
(244, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(245, 'balisage_lumineux', 'Balisage lumineux', NULL),
(246, 'equipements_climatisation', 'Système de climatisation', NULL),
(247, 'equipements_surete1', 'Equipements de sûreté', NULL),
(248, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(249, 'système_détection_incendie', 'Système de détection incendie', NULL),
(250, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(251, 'portes_automatiques', 'portes automatiques', NULL),
(252, 'passerelles', 'passerelles', NULL),
(253, 'stb', 'STB', NULL),
(254, 'slia', 'SLIA', NULL),
(255, 'postes_hta_bt', 'postes HTABT', NULL),
(256, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(257, 'onduleurs', 'onduleurs', NULL),
(258, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(259, 'balisage_lumineux', 'Balisage lumineux', NULL),
(260, 'equipements_climatisation', 'Système de climatisation', NULL),
(261, 'equipements_surete1', 'Equipements de sûreté', NULL),
(262, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(263, 'système_détection_incendie', 'Système de détection incendie', NULL),
(264, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(265, 'portes_automatiques', 'portes automatiques', NULL),
(266, 'passerelles', 'passerelles', NULL),
(267, 'stb', 'STB', NULL),
(268, 'slia', 'SLIA', NULL),
(269, 'postes_hta_bt', 'postes HTABT', NULL),
(270, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(271, 'onduleurs', 'onduleurs', NULL),
(272, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(273, 'balisage_lumineux', 'Balisage lumineux', NULL),
(274, 'equipements_climatisation', 'Système de climatisation', NULL),
(275, 'equipements_surete1', 'Equipements de sûreté', NULL),
(276, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(277, 'système_détection_incendie', 'Système de détection incendie', NULL),
(278, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(279, 'portes_automatiques', 'portes automatiques', NULL),
(280, 'passerelles', 'passerelles', NULL),
(281, 'stb', 'STB', NULL),
(282, 'slia', 'SLIA', NULL),
(283, 'postes_hta_bt', 'postes HTABT', NULL),
(284, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(285, 'onduleurs', 'onduleurs', NULL),
(286, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(287, 'balisage_lumineux', 'Balisage lumineux', NULL),
(288, 'equipements_climatisation', 'Système de climatisation', NULL),
(289, 'equipements_surete1', 'Equipements de sûreté', NULL),
(290, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(291, 'système_détection_incendie', 'Système de détection incendie', NULL),
(292, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(293, 'portes_automatiques', 'portes automatiques', NULL),
(294, 'passerelles', 'passerelles', NULL),
(295, 'stb', 'STB', NULL),
(296, 'slia', 'SLIA', NULL),
(297, 'postes_hta_bt', 'postes HTABT', NULL),
(298, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(299, 'onduleurs', 'onduleurs', NULL),
(300, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(301, 'balisage_lumineux', 'Balisage lumineux', NULL),
(302, 'equipements_climatisation', 'Système de climatisation', NULL),
(303, 'equipements_surete1', 'Equipements de sûreté', NULL),
(304, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(305, 'système_détection_incendie', 'Système de détection incendie', NULL),
(306, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(307, 'portes_automatiques', 'portes automatiques', NULL),
(308, 'passerelles', 'passerelles', NULL),
(309, 'stb', 'STB', NULL),
(310, 'slia', 'SLIA', NULL),
(311, 'postes_hta_bt', 'postes HTABT', NULL),
(312, 'groupes_electrogènes_classiques_temps_zéro', 'Groupes electrogènes classiques et temps zéro', NULL),
(313, 'onduleurs', 'onduleurs', NULL),
(314, 'eclairage_publique_bt', 'Basse tension et éclairage public', NULL),
(315, 'balisage_lumineux', 'Balisage lumineux', NULL),
(316, 'equipements_climatisation', 'Système de climatisation', NULL),
(317, 'equipements_surete1', 'Equipements de sûreté', NULL),
(318, 'systheme_sonorisation', 'Système de sonorisation', NULL),
(319, 'système_détection_incendie', 'Système de détection incendie', NULL),
(320, 'ascenseurs_escaliers', 'ascenseurs escaliers', NULL),
(321, 'portes_automatiques', 'portes automatiques', NULL),
(322, 'passerelles', 'passerelles', NULL),
(323, 'stb', 'STB', NULL),
(324, 'slia', 'SLIA', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `eclairage_publique_bt`
--

CREATE TABLE `eclairage_publique_bt` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_service` int(11) NOT NULL,
  `nom_service` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eclairage_publique_bt`
--

INSERT INTO `eclairage_publique_bt` (`categorie`, `id_service`, `nom_service`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 15, 'Hall', 1, 1, 100, 90, 93.5714, 1, 1, 1, '2024-02-01'),
('Installations électriques', 16, 'Enregistrement', 1, 1, 100, 60, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 17, 'Livraison bag', 1, 1, 100, 60, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 18, 'PAF', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 19, 'PIF', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 20, 'Arrivée +4', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 21, 'depart +4', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 22, 'toilettes', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 23, 'depart +8', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 24, 'parkin avions', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 25, 'acces aéroport', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 26, 'esplanade', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 27, 'Bureaux', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 28, 'armoires et TGBT', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Installations électriques', 38, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `eclairage_publique_bt_2024_01`
--

CREATE TABLE `eclairage_publique_bt_2024_01` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_service` int(11) NOT NULL,
  `nom_service` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eclairage_publique_bt_2024_01`
--

INSERT INTO `eclairage_publique_bt_2024_01` (`categorie`, `id_service`, `nom_service`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 15, 'Hall', 1, 1, 100, 90, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 16, 'Enregistrement', 1, 1, 100, 60, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 17, 'Livraison bag', 1, 1, 100, 60, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 18, 'PAF', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 19, 'PIF', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 20, 'Arrivée +4', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 21, 'depart +4', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 22, 'toilettes', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 23, 'depart +8', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 24, 'parkin avions', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 25, 'acces aéroport', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 26, 'esplanade', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 27, 'Bureaux', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 28, 'armoires et TGBT', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01'),
('Installations électriques', 38, '', 1, 1, 100, 100, 94, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `eclairage_publique_bt_2024_02`
--

CREATE TABLE `eclairage_publique_bt_2024_02` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_service` int(11) NOT NULL,
  `nom_service` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eclairage_publique_bt_2024_02`
--

INSERT INTO `eclairage_publique_bt_2024_02` (`categorie`, `id_service`, `nom_service`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 15, 'Hall', 1, 1, 100, 90, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 16, 'Enregistrement', 1, 1, 100, 60, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 17, 'Livraison bag', 1, 1, 100, 60, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 18, 'PAF', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 19, 'PIF', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 20, 'Arrivée +4', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 21, 'depart +4', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 22, 'toilettes', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 23, 'depart +8', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 24, 'parkin avions', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 25, 'acces aéroport', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 26, 'esplanade', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 27, 'Bureaux', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 28, 'armoires et TGBT', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01'),
('Installations électriques', 38, '', 1, 1, 100, 100, 94, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `eclairage_publique_bt_2024_03`
--

CREATE TABLE `eclairage_publique_bt_2024_03` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_service` int(11) NOT NULL,
  `nom_service` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eclairage_publique_bt_2024_03`
--

INSERT INTO `eclairage_publique_bt_2024_03` (`categorie`, `id_service`, `nom_service`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 15, 'Hall', 1, 1, 100, 90, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 16, 'Enregistrement', 1, 1, 100, 60, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 17, 'Livraison bag', 1, 1, 100, 60, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 18, 'PAF', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 19, 'PIF', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 20, 'Arrivée +4', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 21, 'depart +4', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 22, 'toilettes', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 23, 'depart +8', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 24, 'parkin avions', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 25, 'acces aéroport', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 26, 'esplanade', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 27, 'Bureaux', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 28, 'armoires et TGBT', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01'),
('Installations électriques', 38, '', 1, 1, 100, 100, 94, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `eclairage_publique_bt_2025_01`
--

CREATE TABLE `eclairage_publique_bt_2025_01` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_service` int(11) NOT NULL,
  `nom_service` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eclairage_publique_bt_2025_01`
--

INSERT INTO `eclairage_publique_bt_2025_01` (`categorie`, `id_service`, `nom_service`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 15, 'Hall', 1, 1, 100, 90, 93.5714, 1, 1, 1, '2025-01-01'),
('Installations électriques', 16, 'Enregistrement', 1, 1, 100, 60, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 17, 'Livraison bag', 1, 1, 100, 60, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 18, 'PAF', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 19, 'PIF', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 20, 'Arrivée +4', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 21, 'depart +4', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 22, 'toilettes', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 23, 'depart +8', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 24, 'parkin avions', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 25, 'acces aéroport', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 26, 'esplanade', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 27, 'Bureaux', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 28, 'armoires et TGBT', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Installations électriques', 38, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_climatisation`
--

CREATE TABLE `equipements_climatisation` (
  `categorie` varchar(200) DEFAULT 'Installations thermiques',
  `id_equipement` int(11) NOT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `nombre_equipement` int(11) DEFAULT NULL,
  `famille_dequipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `temps_total_bonfonctionnement` int(11) DEFAULT 744,
  `temps_ouverture` int(11) DEFAULT 744,
  `pourcentage_disponibilite_par_equipement` float DEFAULT 100,
  `pourcentage_disponibilite_par_famille` float DEFAULT NULL,
  `coeficient` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT NULL,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_climatisation`
--

INSERT INTO `equipements_climatisation` (`categorie`, `id_equipement`, `nom_equipement`, `nombre_equipement`, `famille_dequipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `temps_total_bonfonctionnement`, `temps_ouverture`, `pourcentage_disponibilite_par_equipement`, `pourcentage_disponibilite_par_famille`, `coeficient`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations thermiques', 20, 'GEG1', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 21, 'GEG 2', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 22, 'PAC1', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 23, 'PAC 2', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 24, 'PAC3', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 25, 'PAC 4', 1, 'PAC', 1, 1, 100, 0, 744, 0, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 26, 'PAC1SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 27, 'PAC 2 SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 28, 'CTA 1', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 29, 'CTA 2', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 30, 'CTA 3', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 31, 'CTA 4', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 32, 'CTA5', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 33, 'CTA 6', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 34, 'CTA 7', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 35, 'ventilo-convecteurs', 82, 'ventilo-convecteurs', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 36, 'split-system', 63, 'split-system', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 37, 'pompes de circulation d\'eau', 26, 'pompes de circulation', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 38, 'caissons d\'air neuf', 2, 'caissons d\'air neuf', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 42, '', 0, '', 1, 1, 100, 744, 744, 100, NULL, NULL, NULL, 0, 1, 1, 1, '2019-01-01'),
('Installations thermiques', 43, '', 0, '', 1, 1, 100, 744, 744, 100, NULL, NULL, NULL, 0, 1, 1, 1, '2019-01-01'),
('Installations thermiques', 47, '', 0, '', 1, 1, 100, 744, 744, 100, NULL, NULL, NULL, 0, 1, 1, 1, '2019-01-01'),
('Installations thermiques', 48, '', 0, '', 1, 1, 100, 744, 744, 100, NULL, NULL, NULL, 0, 1, 1, 1, '2019-02-01'),
('Installations thermiques', 49, '', 0, '', 1, 1, 100, 744, 744, 100, NULL, NULL, NULL, 0, 1, 1, 1, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_climatisation_2024_01`
--

CREATE TABLE `equipements_climatisation_2024_01` (
  `categorie` varchar(200) DEFAULT 'Installations thermiques',
  `id_equipement` int(11) NOT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `nombre_equipement` int(11) DEFAULT NULL,
  `famille_dequipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `temps_total_bonfonctionnement` int(11) DEFAULT 744,
  `temps_ouverture` int(11) DEFAULT 744,
  `pourcentage_disponibilite_par_equipement` float DEFAULT 100,
  `pourcentage_disponibilite_par_famille` float DEFAULT NULL,
  `coeficient` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT NULL,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_climatisation_2024_01`
--

INSERT INTO `equipements_climatisation_2024_01` (`categorie`, `id_equipement`, `nom_equipement`, `nombre_equipement`, `famille_dequipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `temps_total_bonfonctionnement`, `temps_ouverture`, `pourcentage_disponibilite_par_equipement`, `pourcentage_disponibilite_par_famille`, `coeficient`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations thermiques', 20, 'GEG1', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 21, 'GEG 2', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 22, 'PAC1', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 23, 'PAC 2', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 24, 'PAC3', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 25, 'PAC 4', 1, 'PAC', 1, 1, 100, 0, 744, 0, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 26, 'PAC1SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 27, 'PAC 2 SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 28, 'CTA 1', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 29, 'CTA 2', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 30, 'CTA 3', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 31, 'CTA 4', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 32, 'CTA5', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 33, 'CTA 6', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 34, 'CTA 7', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 35, 'ventilo-convecteurs', 82, 'ventilo-convecteurs', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 36, 'split-system', 63, 'split-system', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 37, 'pompes de circulation d\'eau', 26, 'pompes de circulation', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 38, 'caissons d\'air neuf', 2, 'caissons d\'air neuf', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 42, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 43, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 47, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 48, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-01-01'),
('Installations thermiques', 49, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_climatisation_2024_02`
--

CREATE TABLE `equipements_climatisation_2024_02` (
  `categorie` varchar(200) DEFAULT 'Installations thermiques',
  `id_equipement` int(11) NOT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `nombre_equipement` int(11) DEFAULT NULL,
  `famille_dequipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `temps_total_bonfonctionnement` int(11) DEFAULT 744,
  `temps_ouverture` int(11) DEFAULT 744,
  `pourcentage_disponibilite_par_equipement` float DEFAULT 100,
  `pourcentage_disponibilite_par_famille` float DEFAULT NULL,
  `coeficient` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT NULL,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_climatisation_2024_02`
--

INSERT INTO `equipements_climatisation_2024_02` (`categorie`, `id_equipement`, `nom_equipement`, `nombre_equipement`, `famille_dequipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `temps_total_bonfonctionnement`, `temps_ouverture`, `pourcentage_disponibilite_par_equipement`, `pourcentage_disponibilite_par_famille`, `coeficient`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations thermiques', 20, 'GEG1', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 21, 'GEG 2', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 22, 'PAC1', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 23, 'PAC 2', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 24, 'PAC3', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 25, 'PAC 4', 1, 'PAC', 1, 1, 100, 0, 744, 0, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 26, 'PAC1SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 27, 'PAC 2 SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 28, 'CTA 1', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 29, 'CTA 2', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 30, 'CTA 3', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 31, 'CTA 4', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 32, 'CTA5', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 33, 'CTA 6', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 34, 'CTA 7', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 35, 'ventilo-convecteurs', 82, 'ventilo-convecteurs', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 36, 'split-system', 63, 'split-system', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 37, 'pompes de circulation d\'eau', 26, 'pompes de circulation', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 38, 'caissons d\'air neuf', 2, 'caissons d\'air neuf', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 42, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 43, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 47, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 48, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-02-01'),
('Installations thermiques', 49, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_climatisation_2024_03`
--

CREATE TABLE `equipements_climatisation_2024_03` (
  `categorie` varchar(200) DEFAULT 'Installations thermiques',
  `id_equipement` int(11) NOT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `nombre_equipement` int(11) DEFAULT NULL,
  `famille_dequipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `temps_total_bonfonctionnement` int(11) DEFAULT 744,
  `temps_ouverture` int(11) DEFAULT 744,
  `pourcentage_disponibilite_par_equipement` float DEFAULT 100,
  `pourcentage_disponibilite_par_famille` float DEFAULT NULL,
  `coeficient` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT NULL,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_climatisation_2024_03`
--

INSERT INTO `equipements_climatisation_2024_03` (`categorie`, `id_equipement`, `nom_equipement`, `nombre_equipement`, `famille_dequipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `temps_total_bonfonctionnement`, `temps_ouverture`, `pourcentage_disponibilite_par_equipement`, `pourcentage_disponibilite_par_famille`, `coeficient`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations thermiques', 20, 'GEG1', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 21, 'GEG 2', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 22, 'PAC1', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 23, 'PAC 2', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 24, 'PAC3', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 25, 'PAC 4', 1, 'PAC', 1, 1, 100, 0, 744, 0, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 26, 'PAC1SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 27, 'PAC 2 SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 28, 'CTA 1', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 29, 'CTA 2', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 30, 'CTA 3', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 31, 'CTA 4', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 32, 'CTA5', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 33, 'CTA 6', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 34, 'CTA 7', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 35, 'ventilo-convecteurs', 82, 'ventilo-convecteurs', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 36, 'split-system', 63, 'split-system', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 37, 'pompes de circulation d\'eau', 26, 'pompes de circulation', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 38, 'caissons d\'air neuf', 2, 'caissons d\'air neuf', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 42, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 43, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 47, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 48, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-03-01'),
('Installations thermiques', 49, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 10.7143, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_climatisation_2025_01`
--

CREATE TABLE `equipements_climatisation_2025_01` (
  `categorie` varchar(200) DEFAULT 'Installations thermiques',
  `id_equipement` int(11) NOT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `nombre_equipement` int(11) DEFAULT NULL,
  `famille_dequipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `temps_total_bonfonctionnement` int(11) DEFAULT 744,
  `temps_ouverture` int(11) DEFAULT 744,
  `pourcentage_disponibilite_par_equipement` float DEFAULT 100,
  `pourcentage_disponibilite_par_famille` float DEFAULT NULL,
  `coeficient` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT NULL,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_climatisation_2025_01`
--

INSERT INTO `equipements_climatisation_2025_01` (`categorie`, `id_equipement`, `nom_equipement`, `nombre_equipement`, `famille_dequipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `temps_total_bonfonctionnement`, `temps_ouverture`, `pourcentage_disponibilite_par_equipement`, `pourcentage_disponibilite_par_famille`, `coeficient`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations thermiques', 20, 'GEG1', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 21, 'GEG 2', 1, 'GEG', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 22, 'PAC1', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 23, 'PAC 2', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 24, 'PAC3', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 25, 'PAC 4', 1, 'PAC', 1, 1, 100, 0, 744, 0, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 26, 'PAC1SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 27, 'PAC 2 SR', 1, 'PAC', 1, 1, 100, 744, 744, 100, 83.3333, 0.142857, 11.9048, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 28, 'CTA 1', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 29, 'CTA 2', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 30, 'CTA 3', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 31, 'CTA 4', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 32, 'CTA5', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 33, 'CTA 6', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 34, 'CTA 7', 1, 'CTA', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 35, 'ventilo-convecteurs', 82, 'ventilo-convecteurs', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 36, 'split-system', 63, 'split-system', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 37, 'pompes de circulation d\'eau', 26, 'pompes de circulation', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 38, 'caissons d\'air neuf', 2, 'caissons d\'air neuf', 1, 1, 100, 744, 744, 100, 100, 0.142857, 14.2857, 97.6191, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 42, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 0, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 43, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 0, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 47, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 0, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 48, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 0, 1, 1, 1, '2025-01-01'),
('Installations thermiques', 49, '', 0, '', 1, 1, 100, 744, 744, 100, 0, 0, 0, 0, 1, 1, 1, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_surete1`
--

CREATE TABLE `equipements_surete1` (
  `categorie` varchar(100) DEFAULT 'equipements de surete',
  `id_equipement` int(11) NOT NULL,
  `localisation_equipement` varchar(100) DEFAULT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `marque_equipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_surete1`
--

INSERT INTO `equipements_surete1` (`categorie`, `id_equipement`, `localisation_equipement`, `nom_equipement`, `marque_equipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements de surete', 1, 'STB', 'EDS 1 (intégré)', 'VIS-HR VH2023 (Standard 2)', 1, 1, 100, 0, 83.4219, 1, 1, 1, '2024-02-01'),
('equipements de surete', 2, 'STB', 'EDS 2 (intégré)', 'VIS-HR VH2024 (Standard 2)', 1, 1, 100, 0, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 3, 'STB', 'Tomographe (intégré)', 'Examiner SX', 1, 1, 100, 0, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 4, 'Ligne 1 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 5, 'Ligne 2 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 6, 'Ligne 3 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 7, 'PIF 5', 'Scanner à Rayon X', 'ASTROPHYSICS XIS-6545', 1, 1, 100, 0, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 8, 'Passage de Service 6', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 9, 'PIF 4', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 10, 'Passage T1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 11, 'Entrée hall publique', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XD', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 12, 'STB mode dégradé chute 1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 13, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 14, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'HEIMANN 100/100T', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 15, 'PIF 1', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 16, 'PIF 2', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 17, 'Arrivée', 'Scanner à Rayon X', 'NUCTECH CX100100D', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 18, 'PIF 3', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 19, 'Passage de service 7', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 20, 'Arrivée', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 21, 'Entrée hall publique', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 22, 'STB côté porte 6', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 23, 'Fret', 'Scanner à Rayon X', 'Astrophysics Xis 1818dv', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 24, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 25, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 26, '', 'ETD', 'NUCTECH', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 27, '', 'DEL', 'NUCTECH', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 28, '', 'DEL', 'NUCTECH', 1, 1, 100, 68.97, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 29, '', 'DEL', 'CHEA', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('equipements de surete', 33, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2019-01-01'),
('equipements de surete', 34, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2019-01-01'),
('equipements de surete', 38, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2019-01-01'),
('equipements de surete', 39, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2019-02-01'),
('equipements de surete', 40, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_surete1_2024_01`
--

CREATE TABLE `equipements_surete1_2024_01` (
  `categorie` varchar(100) DEFAULT 'equipements de surete',
  `id_equipement` int(11) NOT NULL,
  `localisation_equipement` varchar(100) DEFAULT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `marque_equipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_surete1_2024_01`
--

INSERT INTO `equipements_surete1_2024_01` (`categorie`, `id_equipement`, `localisation_equipement`, `nom_equipement`, `marque_equipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements de surete', 1, 'STB', 'EDS 1 (intégré)', 'VIS-HR VH2023 (Standard 2)', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 2, 'STB', 'EDS 2 (intégré)', 'VIS-HR VH2024 (Standard 2)', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 3, 'STB', 'Tomographe (intégré)', 'Examiner SX', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 4, 'Ligne 1 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 5, 'Ligne 2 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 6, 'Ligne 3 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 7, 'PIF 5', 'Scanner à Rayon X', 'ASTROPHYSICS XIS-6545', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 8, 'Passage de Service 6', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 9, 'PIF 4', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 10, 'Passage T1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 11, 'Entrée hall publique', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XD', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 12, 'STB mode dégradé chute 1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 13, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 14, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'HEIMANN 100/100T', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 15, 'PIF 1', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 16, 'PIF 2', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 17, 'Arrivée', 'Scanner à Rayon X', 'NUCTECH CX100100D', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 18, 'PIF 3', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 19, 'Passage de service 7', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 20, 'Arrivée', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 21, 'Entrée hall publique', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 22, 'STB côté porte 6', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 23, 'Fret', 'Scanner à Rayon X', 'Astrophysics Xis 1818dv', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 24, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 25, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 26, '', 'ETD', 'NUCTECH', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 27, '', 'DEL', 'NUCTECH', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 28, '', 'DEL', 'NUCTECH', 1, 1, 100, 68.97, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 29, '', 'DEL', 'CHEA', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 33, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 34, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 38, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 39, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01'),
('equipements de surete', 40, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_surete1_2024_02`
--

CREATE TABLE `equipements_surete1_2024_02` (
  `categorie` varchar(100) DEFAULT 'equipements de surete',
  `id_equipement` int(11) NOT NULL,
  `localisation_equipement` varchar(100) DEFAULT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `marque_equipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_surete1_2024_02`
--

INSERT INTO `equipements_surete1_2024_02` (`categorie`, `id_equipement`, `localisation_equipement`, `nom_equipement`, `marque_equipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements de surete', 1, 'STB', 'EDS 1 (intégré)', 'VIS-HR VH2023 (Standard 2)', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 2, 'STB', 'EDS 2 (intégré)', 'VIS-HR VH2024 (Standard 2)', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 3, 'STB', 'Tomographe (intégré)', 'Examiner SX', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 4, 'Ligne 1 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 5, 'Ligne 2 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 6, 'Ligne 3 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 7, 'PIF 5', 'Scanner à Rayon X', 'ASTROPHYSICS XIS-6545', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 8, 'Passage de Service 6', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 9, 'PIF 4', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 10, 'Passage T1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 11, 'Entrée hall publique', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XD', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 12, 'STB mode dégradé chute 1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 13, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 14, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'HEIMANN 100/100T', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 15, 'PIF 1', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 16, 'PIF 2', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 17, 'Arrivée', 'Scanner à Rayon X', 'NUCTECH CX100100D', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 18, 'PIF 3', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 19, 'Passage de service 7', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 20, 'Arrivée', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 21, 'Entrée hall publique', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 22, 'STB côté porte 6', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 23, 'Fret', 'Scanner à Rayon X', 'Astrophysics Xis 1818dv', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 24, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 25, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 26, '', 'ETD', 'NUCTECH', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 27, '', 'DEL', 'NUCTECH', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 28, '', 'DEL', 'NUCTECH', 1, 1, 100, 68.97, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 29, '', 'DEL', 'CHEA', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 33, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 34, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 38, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 39, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01'),
('equipements de surete', 40, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_surete1_2024_03`
--

CREATE TABLE `equipements_surete1_2024_03` (
  `categorie` varchar(100) DEFAULT 'equipements de surete',
  `id_equipement` int(11) NOT NULL,
  `localisation_equipement` varchar(100) DEFAULT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `marque_equipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_surete1_2024_03`
--

INSERT INTO `equipements_surete1_2024_03` (`categorie`, `id_equipement`, `localisation_equipement`, `nom_equipement`, `marque_equipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements de surete', 1, 'STB', 'EDS 1 (intégré)', 'VIS-HR VH2023 (Standard 2)', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 2, 'STB', 'EDS 2 (intégré)', 'VIS-HR VH2024 (Standard 2)', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 3, 'STB', 'Tomographe (intégré)', 'Examiner SX', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 4, 'Ligne 1 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 5, 'Ligne 2 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 6, 'Ligne 3 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 7, 'PIF 5', 'Scanner à Rayon X', 'ASTROPHYSICS XIS-6545', 1, 1, 100, 0, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 8, 'Passage de Service 6', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 9, 'PIF 4', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 10, 'Passage T1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 11, 'Entrée hall publique', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XD', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 12, 'STB mode dégradé chute 1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 13, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 14, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'HEIMANN 100/100T', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 15, 'PIF 1', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 16, 'PIF 2', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 17, 'Arrivée', 'Scanner à Rayon X', 'NUCTECH CX100100D', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 18, 'PIF 3', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 19, 'Passage de service 7', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 20, 'Arrivée', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 21, 'Entrée hall publique', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 22, 'STB côté porte 6', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 23, 'Fret', 'Scanner à Rayon X', 'Astrophysics Xis 1818dv', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 24, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 25, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 26, '', 'ETD', 'NUCTECH', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 27, '', 'DEL', 'NUCTECH', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 28, '', 'DEL', 'NUCTECH', 1, 1, 100, 68.97, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 29, '', 'DEL', 'CHEA', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 33, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 34, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 38, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 39, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01'),
('equipements de surete', 40, '', '', '', 1, 1, 100, 100, 87.3226, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_surete1_2025_01`
--

CREATE TABLE `equipements_surete1_2025_01` (
  `categorie` varchar(100) DEFAULT 'equipements de surete',
  `id_equipement` int(11) NOT NULL,
  `localisation_equipement` varchar(100) DEFAULT NULL,
  `nom_equipement` varchar(100) DEFAULT NULL,
  `marque_equipement` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipements_surete1_2025_01`
--

INSERT INTO `equipements_surete1_2025_01` (`categorie`, `id_equipement`, `localisation_equipement`, `nom_equipement`, `marque_equipement`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements de surete', 1, 'STB', 'EDS 1 (intégré)', 'VIS-HR VH2023 (Standard 2)', 1, 1, 100, 0, 83.4219, 1, 1, 1, '2025-01-01'),
('equipements de surete', 2, 'STB', 'EDS 2 (intégré)', 'VIS-HR VH2024 (Standard 2)', 1, 1, 100, 0, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 3, 'STB', 'Tomographe (intégré)', 'Examiner SX', 1, 1, 100, 0, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 4, 'Ligne 1 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 5, 'Ligne 2 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 6, 'Ligne 3 de livraison bagages arrivée', 'Scanner conventionnel à Rayon X (intégré)', 'RAPISCAN', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 7, 'PIF 5', 'Scanner à Rayon X', 'ASTROPHYSICS XIS-6545', 1, 1, 100, 0, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 8, 'Passage de Service 6', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 9, 'PIF 4', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 10, 'Passage T1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 6545', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 11, 'Entrée hall publique', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XD', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 12, 'STB mode dégradé chute 1', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 13, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'ASTROPHYSICS XIS 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 14, 'STB mode dégradé chute 17', 'Scanner à Rayon X', 'HEIMANN 100/100T', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 15, 'PIF 1', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 16, 'PIF 2', 'Scanner à Rayon X', 'NUCTECH CX6040BI', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 17, 'Arrivée', 'Scanner à Rayon X', 'NUCTECH CX100100D', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 18, 'PIF 3', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 19, 'Passage de service 7', 'Scanner à Rayon X', 'Astrophysics Xis 6040', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 20, 'Arrivée', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 21, 'Entrée hall publique', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 22, 'STB côté porte 6', 'Scanner à Rayon X', 'Astrophysics Xis 100XDX', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 23, 'Fret', 'Scanner à Rayon X', 'Astrophysics Xis 1818dv', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 24, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 25, '', 'ETD', 'Ion scan 600', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 26, '', 'ETD', 'NUCTECH', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 27, '', 'DEL', 'NUCTECH', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 28, '', 'DEL', 'NUCTECH', 1, 1, 100, 68.97, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 29, '', 'DEL', 'CHEA', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 33, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 34, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 38, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 39, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('equipements de surete', 40, '', '', '', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `global_du_mois`
--

CREATE TABLE `global_du_mois` (
  `id` int(11) NOT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `element_de_categorie` varchar(100) DEFAULT NULL,
  `TRP` float DEFAULT NULL,
  `TRP_realise` float DEFAULT NULL,
  `TRP_objectifs` float DEFAULT NULL,
  `TRP_ecart` float DEFAULT NULL,
  `TD` float DEFAULT NULL,
  `TD_realise` float DEFAULT NULL,
  `TD_objectifs` float DEFAULT NULL,
  `TD_ecart` float DEFAULT NULL,
  `MTTR` float DEFAULT NULL,
  `MTTR_realise` float DEFAULT NULL,
  `MTTR_objectifs` float DEFAULT NULL,
  `MTTR_ecart` float DEFAULT NULL,
  `tandance` varchar(200) DEFAULT NULL,
  `commentaires` varchar(500) DEFAULT NULL,
  `TRP_par_categorie` decimal(10,2) DEFAULT NULL,
  `MTTR_par_categorie` decimal(10,2) DEFAULT NULL,
  `TD_par_categorie` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `global_du_mois`
--

INSERT INTO `global_du_mois` (`id`, `categorie`, `element_de_categorie`, `TRP`, `TRP_realise`, `TRP_objectifs`, `TRP_ecart`, `TD`, `TD_realise`, `TD_objectifs`, `TD_ecart`, `MTTR`, `MTTR_realise`, `MTTR_objectifs`, `MTTR_ecart`, `tandance`, `commentaires`, `TRP_par_categorie`, `MTTR_par_categorie`, `TD_par_categorie`) VALUES
(1, 'Installations électriques', 'Postes HTABT', 100, NULL, NULL, NULL, 100, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 55.33, 0.55, 37.91),
(2, 'Installations électriques', 'Groupes électrogènes classiques et temps zéro', 16.6667, NULL, NULL, NULL, 16.6667, NULL, NULL, NULL, 0.166667, NULL, NULL, NULL, NULL, NULL, 55.33, 0.55, 37.91),
(3, 'Installations électriques', 'Onduleurs', 16.6667, NULL, NULL, NULL, 16.6667, NULL, NULL, NULL, 0.166667, NULL, NULL, NULL, NULL, NULL, 55.33, 0.55, 37.91),
(4, 'Installations électriques', 'Basse tension et éclairage public', 93.3333, NULL, NULL, NULL, 6.23809, NULL, NULL, NULL, 0.933333, NULL, NULL, NULL, NULL, NULL, 55.33, 0.55, 37.91),
(5, 'Installations électriques', 'Balisage lumineux', 50, NULL, NULL, NULL, 50, NULL, NULL, NULL, 0.5, NULL, NULL, NULL, NULL, NULL, 55.33, 0.55, 37.91),
(6, 'Installations thermiques', 'Système de climatisation', 100, NULL, NULL, NULL, 77.2818, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 100.00, 1.00, 77.28),
(7, 'Equipements de sûreté', 'Equipements de sûreté', 100, NULL, NULL, NULL, 2.45359, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 100.00, 1.00, 2.45),
(8, 'Equipements électroniques', 'Système de sonorisation', 100, NULL, NULL, NULL, 100, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 100.00, 1.00, 100.00),
(9, 'Equipements électroniques', 'Système de détection incendie', 100, NULL, NULL, NULL, 100, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 100.00, 1.00, 100.00),
(10, 'Equipements électromécaniques', 'Ascenseurs et escaliers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16.67, 0.17, 16.67),
(11, 'Equipements électromécaniques', 'Portes automatiques', 16.6667, NULL, NULL, NULL, 16.6667, NULL, NULL, NULL, 0.166667, NULL, NULL, NULL, NULL, NULL, 16.67, 0.17, 16.67),
(12, 'Equipements électromécaniques', 'Passerelles', 16.6667, NULL, NULL, NULL, 16.6667, NULL, NULL, NULL, 0.166667, NULL, NULL, NULL, NULL, NULL, 16.67, 0.17, 16.67),
(13, 'Système de traitement des bagages (STB)', 'STB', 66.6667, NULL, NULL, NULL, 6.26, NULL, NULL, NULL, 0.666667, NULL, NULL, NULL, NULL, NULL, 66.67, 0.67, 6.26),
(14, 'Véhicules SLIA', 'SLIA', 16.6667, NULL, NULL, NULL, 16.6667, NULL, NULL, NULL, 0.166667, NULL, NULL, NULL, NULL, NULL, 16.67, 0.17, 16.67);

-- --------------------------------------------------------

--
-- Structure de la table `global_du_mois_2024_01`
--

CREATE TABLE `global_du_mois_2024_01` (
  `id` int(11) NOT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `element_de_categorie` varchar(100) DEFAULT NULL,
  `TRP` float DEFAULT NULL,
  `TRP_realise` float DEFAULT NULL,
  `TRP_objectifs` float DEFAULT NULL,
  `TRP_ecart` float DEFAULT NULL,
  `TD` float DEFAULT NULL,
  `TD_realise` float DEFAULT NULL,
  `TD_objectifs` float DEFAULT NULL,
  `TD_ecart` float DEFAULT NULL,
  `MTTR` float DEFAULT NULL,
  `MTTR_realise` float DEFAULT NULL,
  `MTTR_objectifs` float DEFAULT NULL,
  `MTTR_ecart` float DEFAULT NULL,
  `tandance` varchar(200) DEFAULT NULL,
  `commentaires` varchar(500) DEFAULT NULL,
  `TRP_par_categorie` decimal(10,2) DEFAULT NULL,
  `MTTR_par_categorie` decimal(10,2) DEFAULT NULL,
  `TD_par_categorie` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `global_du_mois_2024_02`
--

CREATE TABLE `global_du_mois_2024_02` (
  `id` int(11) NOT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `element_de_categorie` varchar(100) DEFAULT NULL,
  `TRP` float DEFAULT NULL,
  `TRP_realise` float DEFAULT NULL,
  `TRP_objectifs` float DEFAULT NULL,
  `TRP_ecart` float DEFAULT NULL,
  `TD` float DEFAULT NULL,
  `TD_realise` float DEFAULT NULL,
  `TD_objectifs` float DEFAULT NULL,
  `TD_ecart` float DEFAULT NULL,
  `MTTR` float DEFAULT NULL,
  `MTTR_realise` float DEFAULT NULL,
  `MTTR_objectifs` float DEFAULT NULL,
  `MTTR_ecart` float DEFAULT NULL,
  `tandance` varchar(200) DEFAULT NULL,
  `commentaires` varchar(500) DEFAULT NULL,
  `TRP_par_categorie` decimal(10,2) DEFAULT NULL,
  `MTTR_par_categorie` decimal(10,2) DEFAULT NULL,
  `TD_par_categorie` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `global_du_mois_2025_01`
--

CREATE TABLE `global_du_mois_2025_01` (
  `id` int(11) NOT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `element_de_categorie` varchar(100) DEFAULT NULL,
  `TRP` float DEFAULT NULL,
  `TRP_realise` float DEFAULT NULL,
  `TRP_objectifs` float DEFAULT NULL,
  `TRP_ecart` float DEFAULT NULL,
  `TD` float DEFAULT NULL,
  `TD_realise` float DEFAULT NULL,
  `TD_objectifs` float DEFAULT NULL,
  `TD_ecart` float DEFAULT NULL,
  `MTTR` float DEFAULT NULL,
  `MTTR_realise` float DEFAULT NULL,
  `MTTR_objectifs` float DEFAULT NULL,
  `MTTR_ecart` float DEFAULT NULL,
  `tandance` varchar(200) DEFAULT NULL,
  `commentaires` varchar(500) DEFAULT NULL,
  `TRP_par_categorie` decimal(10,2) DEFAULT NULL,
  `MTTR_par_categorie` decimal(10,2) DEFAULT NULL,
  `TD_par_categorie` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `groupes_electrogènes_classiques_temps_zéro`
--

CREATE TABLE `groupes_electrogènes_classiques_temps_zéro` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_groupe` int(11) NOT NULL,
  `nom_groupe` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groupes_electrogènes_classiques_temps_zéro`
--

INSERT INTO `groupes_electrogènes_classiques_temps_zéro` (`categorie`, `id_groupe`, `nom_groupe`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installations électriques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installations électriques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installations électriques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01'),
('Installations électriques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `groupes_electrogènes_classiques_temps_zéro_2024_01`
--

CREATE TABLE `groupes_electrogènes_classiques_temps_zéro_2024_01` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_groupe` int(11) NOT NULL,
  `nom_groupe` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groupes_electrogènes_classiques_temps_zéro_2024_01`
--

INSERT INTO `groupes_electrogènes_classiques_temps_zéro_2024_01` (`categorie`, `id_groupe`, `nom_groupe`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `groupes_electrogènes_classiques_temps_zéro_2024_02`
--

CREATE TABLE `groupes_electrogènes_classiques_temps_zéro_2024_02` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_groupe` int(11) NOT NULL,
  `nom_groupe` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groupes_electrogènes_classiques_temps_zéro_2024_02`
--

INSERT INTO `groupes_electrogènes_classiques_temps_zéro_2024_02` (`categorie`, `id_groupe`, `nom_groupe`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `groupes_electrogènes_classiques_temps_zéro_2024_03`
--

CREATE TABLE `groupes_electrogènes_classiques_temps_zéro_2024_03` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_groupe` int(11) NOT NULL,
  `nom_groupe` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groupes_electrogènes_classiques_temps_zéro_2024_03`
--

INSERT INTO `groupes_electrogènes_classiques_temps_zéro_2024_03` (`categorie`, `id_groupe`, `nom_groupe`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `groupes_electrogènes_classiques_temps_zéro_2025_01`
--

CREATE TABLE `groupes_electrogènes_classiques_temps_zéro_2025_01` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_groupe` int(11) NOT NULL,
  `nom_groupe` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groupes_electrogènes_classiques_temps_zéro_2025_01`
--

INSERT INTO `groupes_electrogènes_classiques_temps_zéro_2025_01` (`categorie`, `id_groupe`, `nom_groupe`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('Installations électriques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installations électriques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installations électriques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installations électriques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installations électriques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `onduleurs`
--

CREATE TABLE `onduleurs` (
  `categorie` varchar(100) DEFAULT 'Installation electriques',
  `id_onduleur` int(11) NOT NULL,
  `nom_onduleur` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `onduleurs`
--

INSERT INTO `onduleurs` (`categorie`, `id_onduleur`, `nom_onduleur`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installation electriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installation electriques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installation electriques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installation electriques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installation electriques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01'),
('Installation electriques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `onduleurs_2024_01`
--

CREATE TABLE `onduleurs_2024_01` (
  `categorie` varchar(100) DEFAULT 'Installation electriques',
  `id_onduleur` int(11) NOT NULL,
  `nom_onduleur` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `onduleurs_2024_01`
--

INSERT INTO `onduleurs_2024_01` (`categorie`, `id_onduleur`, `nom_onduleur`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installation electriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installation electriques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installation electriques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installation electriques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installation electriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installation electriques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `onduleurs_2024_02`
--

CREATE TABLE `onduleurs_2024_02` (
  `categorie` varchar(100) DEFAULT 'Installation electriques',
  `id_onduleur` int(11) NOT NULL,
  `nom_onduleur` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `onduleurs_2024_02`
--

INSERT INTO `onduleurs_2024_02` (`categorie`, `id_onduleur`, `nom_onduleur`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installation electriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installation electriques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installation electriques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installation electriques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installation electriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installation electriques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `onduleurs_2024_03`
--

CREATE TABLE `onduleurs_2024_03` (
  `categorie` varchar(100) DEFAULT 'Installation electriques',
  `id_onduleur` int(11) NOT NULL,
  `nom_onduleur` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `onduleurs_2024_03`
--

INSERT INTO `onduleurs_2024_03` (`categorie`, `id_onduleur`, `nom_onduleur`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installation electriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installation electriques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installation electriques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installation electriques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installation electriques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installation electriques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `onduleurs_2025_01`
--

CREATE TABLE `onduleurs_2025_01` (
  `categorie` varchar(100) DEFAULT 'Installation electriques',
  `id_onduleur` int(11) NOT NULL,
  `nom_onduleur` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `onduleurs_2025_01`
--

INSERT INTO `onduleurs_2025_01` (`categorie`, `id_onduleur`, `nom_onduleur`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installation electriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('Installation electriques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installation electriques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installation electriques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installation electriques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installation electriques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `passerelles`
--

CREATE TABLE `passerelles` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `passerelles`
--

INSERT INTO `passerelles` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' Passerelle1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('equipements mecaniques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('equipements mecaniques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('equipements mecaniques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01'),
('equipements mecaniques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `passerelles_2024_01`
--

CREATE TABLE `passerelles_2024_01` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `passerelles_2024_01`
--

INSERT INTO `passerelles_2024_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' Passerelle1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `passerelles_2024_02`
--

CREATE TABLE `passerelles_2024_02` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `passerelles_2024_02`
--

INSERT INTO `passerelles_2024_02` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' Passerelle1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `passerelles_2024_03`
--

CREATE TABLE `passerelles_2024_03` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `passerelles_2024_03`
--

INSERT INTO `passerelles_2024_03` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' Passerelle1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `passerelles_2025_01`
--

CREATE TABLE `passerelles_2025_01` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `passerelles_2025_01`
--

INSERT INTO `passerelles_2025_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' Passerelle1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('equipements mecaniques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('equipements mecaniques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('equipements mecaniques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('equipements mecaniques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `portes_automatiques`
--

CREATE TABLE `portes_automatiques` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `portes_automatiques`
--

INSERT INTO `portes_automatiques` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' porte1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('equipements mecaniques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('equipements mecaniques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('equipements mecaniques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01'),
('equipements mecaniques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `portes_automatiques_2024_01`
--

CREATE TABLE `portes_automatiques_2024_01` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `portes_automatiques_2024_01`
--

INSERT INTO `portes_automatiques_2024_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' porte1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('equipements mecaniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `portes_automatiques_2024_02`
--

CREATE TABLE `portes_automatiques_2024_02` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `portes_automatiques_2024_02`
--

INSERT INTO `portes_automatiques_2024_02` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' porte1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('equipements mecaniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `portes_automatiques_2024_03`
--

CREATE TABLE `portes_automatiques_2024_03` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `portes_automatiques_2024_03`
--

INSERT INTO `portes_automatiques_2024_03` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' porte1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('equipements mecaniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `portes_automatiques_2025_01`
--

CREATE TABLE `portes_automatiques_2025_01` (
  `categorie` varchar(100) DEFAULT 'equipements mecaniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `portes_automatiques_2025_01`
--

INSERT INTO `portes_automatiques_2025_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('equipements mecaniques', 1, ' porte1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('equipements mecaniques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('equipements mecaniques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('equipements mecaniques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('equipements mecaniques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('equipements mecaniques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `postes_hta_bt`
--

CREATE TABLE `postes_hta_bt` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_poste` int(11) NOT NULL,
  `nom_poste` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `postes_hta_bt`
--

INSERT INTO `postes_hta_bt` (`categorie`, `id_poste`, `nom_poste`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 20, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installations électriques', 21, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installations électriques', 25, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Installations électriques', 26, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01'),
('Installations électriques', 27, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `postes_hta_bt_2024_01`
--

CREATE TABLE `postes_hta_bt_2024_01` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_poste` int(11) NOT NULL,
  `nom_poste` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `postes_hta_bt_2024_01`
--

INSERT INTO `postes_hta_bt_2024_01` (`categorie`, `id_poste`, `nom_poste`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 20, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 21, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 25, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 26, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Installations électriques', 27, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `postes_hta_bt_2024_02`
--

CREATE TABLE `postes_hta_bt_2024_02` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_poste` int(11) NOT NULL,
  `nom_poste` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `postes_hta_bt_2024_02`
--

INSERT INTO `postes_hta_bt_2024_02` (`categorie`, `id_poste`, `nom_poste`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 20, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 21, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 25, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 26, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Installations électriques', 27, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `postes_hta_bt_2024_03`
--

CREATE TABLE `postes_hta_bt_2024_03` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_poste` int(11) NOT NULL,
  `nom_poste` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `postes_hta_bt_2024_03`
--

INSERT INTO `postes_hta_bt_2024_03` (`categorie`, `id_poste`, `nom_poste`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 20, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 21, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 25, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 26, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Installations électriques', 27, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `postes_hta_bt_2025_01`
--

CREATE TABLE `postes_hta_bt_2025_01` (
  `categorie` varchar(100) DEFAULT 'Installations électriques',
  `id_poste` int(11) NOT NULL,
  `nom_poste` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `postes_hta_bt_2025_01`
--

INSERT INTO `postes_hta_bt_2025_01` (`categorie`, `id_poste`, `nom_poste`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Installations électriques', 1, 'poste1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('Installations électriques', 20, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installations électriques', 21, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installations électriques', 25, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installations électriques', 26, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Installations électriques', 27, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `slia`
--

CREATE TABLE `slia` (
  `categorie` varchar(100) DEFAULT 'Véhicules SLIA',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `slia`
--

INSERT INTO `slia` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Véhicules SLIA', 1, ' element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Véhicules SLIA', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Véhicules SLIA', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Véhicules SLIA', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Véhicules SLIA', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01'),
('Véhicules SLIA', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `slia_2024_01`
--

CREATE TABLE `slia_2024_01` (
  `categorie` varchar(100) DEFAULT 'Véhicules SLIA',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `slia_2024_01`
--

INSERT INTO `slia_2024_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Véhicules SLIA', 1, ' element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Véhicules SLIA', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Véhicules SLIA', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Véhicules SLIA', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Véhicules SLIA', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Véhicules SLIA', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `slia_2024_02`
--

CREATE TABLE `slia_2024_02` (
  `categorie` varchar(100) DEFAULT 'Véhicules SLIA',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `slia_2024_02`
--

INSERT INTO `slia_2024_02` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Véhicules SLIA', 1, ' element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Véhicules SLIA', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Véhicules SLIA', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Véhicules SLIA', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Véhicules SLIA', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Véhicules SLIA', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `slia_2024_03`
--

CREATE TABLE `slia_2024_03` (
  `categorie` varchar(100) DEFAULT 'Véhicules SLIA',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `slia_2024_03`
--

INSERT INTO `slia_2024_03` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Véhicules SLIA', 1, ' element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Véhicules SLIA', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Véhicules SLIA', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Véhicules SLIA', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Véhicules SLIA', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Véhicules SLIA', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `slia_2025_01`
--

CREATE TABLE `slia_2025_01` (
  `categorie` varchar(100) DEFAULT 'Véhicules SLIA',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `slia_2025_01`
--

INSERT INTO `slia_2025_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Véhicules SLIA', 1, ' element1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('Véhicules SLIA', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Véhicules SLIA', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Véhicules SLIA', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Véhicules SLIA', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Véhicules SLIA', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `stb`
--

CREATE TABLE `stb` (
  `categorie` varchar(100) DEFAULT 'Système de traitement des bagages(STB) y compris les bascules',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stb`
--

INSERT INTO `stb` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Système de traitement des bagages(STB) y compris les bascules', 11, 'comptoirs d\'enregistrement', 1, 1, 100, 92, 93.9, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 12, 'Rideaux anti intrusion et coffrets électrique', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 13, 'Rideaux coupe-feu', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 14, 'chariots DCV', 1, 1, 100, 47, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 15, 'Rails, et générateurs de fréquences 25 KHZ et armoires électrique', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 16, 'Lignes de livraison des bagages et armoires électriques cotée arrivée', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 17, 'Ligne convoyeurs et armoires électriques cotée EDS', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 18, 'Ligne convoyeuse et armoires électriques cotée TOMOGRAPHE', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 19, 'Partie automatisme et informatique', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 20, 'Bascules électriques', 1, 1, 100, 100, 0, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 24, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 25, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 29, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 30, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 31, '', 1, 1, 0, 100, 0, 1, 1, 0, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `stb_2024_01`
--

CREATE TABLE `stb_2024_01` (
  `categorie` varchar(100) DEFAULT 'Système de traitement des bagages(STB) y compris les bascules',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stb_2024_01`
--

INSERT INTO `stb_2024_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Système de traitement des bagages(STB) y compris les bascules', 11, 'comptoirs d\'enregistrement', 1, 1, 100, 92, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 12, 'Rideaux anti intrusion et coffrets électrique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 13, 'Rideaux coupe-feu', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 14, 'chariots DCV', 1, 1, 100, 47, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 15, 'Rails, et générateurs de fréquences 25 KHZ et armoires électrique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 16, 'Lignes de livraison des bagages et armoires électriques cotée arrivée', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 17, 'Ligne convoyeurs et armoires électriques cotée EDS', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 18, 'Ligne convoyeuse et armoires électriques cotée TOMOGRAPHE', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 19, 'Partie automatisme et informatique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 20, 'Bascules électriques', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 24, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 25, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 29, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 30, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 31, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `stb_2024_02`
--

CREATE TABLE `stb_2024_02` (
  `categorie` varchar(100) DEFAULT 'Système de traitement des bagages(STB) y compris les bascules',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stb_2024_02`
--

INSERT INTO `stb_2024_02` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Système de traitement des bagages(STB) y compris les bascules', 11, 'comptoirs d\'enregistrement', 1, 1, 100, 92, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 12, 'Rideaux anti intrusion et coffrets électrique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 13, 'Rideaux coupe-feu', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 14, 'chariots DCV', 1, 1, 100, 47, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 15, 'Rails, et générateurs de fréquences 25 KHZ et armoires électrique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 16, 'Lignes de livraison des bagages et armoires électriques cotée arrivée', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 17, 'Ligne convoyeurs et armoires électriques cotée EDS', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 18, 'Ligne convoyeuse et armoires électriques cotée TOMOGRAPHE', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 19, 'Partie automatisme et informatique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 20, 'Bascules électriques', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 24, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 25, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 29, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 30, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01'),
('Système de traitement des bagages(STB) y compris les bascules', 31, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `stb_2024_03`
--

CREATE TABLE `stb_2024_03` (
  `categorie` varchar(100) DEFAULT 'Système de traitement des bagages(STB) y compris les bascules',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stb_2024_03`
--

INSERT INTO `stb_2024_03` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Système de traitement des bagages(STB) y compris les bascules', 11, 'comptoirs d\'enregistrement', 1, 1, 100, 92, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 12, 'Rideaux anti intrusion et coffrets électrique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 13, 'Rideaux coupe-feu', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 14, 'chariots DCV', 1, 1, 100, 47, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 15, 'Rails, et générateurs de fréquences 25 KHZ et armoires électrique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 16, 'Lignes de livraison des bagages et armoires électriques cotée arrivée', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 17, 'Ligne convoyeurs et armoires électriques cotée EDS', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 18, 'Ligne convoyeuse et armoires électriques cotée TOMOGRAPHE', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 19, 'Partie automatisme et informatique', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 20, 'Bascules électriques', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 24, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 25, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 29, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 30, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01'),
('Système de traitement des bagages(STB) y compris les bascules', 31, '', 1, 1, 100, 100, 95.9333, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `stb_2025_01`
--

CREATE TABLE `stb_2025_01` (
  `categorie` varchar(100) DEFAULT 'Système de traitement des bagages(STB) y compris les bascules',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stb_2025_01`
--

INSERT INTO `stb_2025_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Système de traitement des bagages(STB) y compris les bascules', 11, 'comptoirs d\'enregistrement', 1, 1, 100, 92, 93.9, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 12, 'Rideaux anti intrusion et coffrets électrique', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 13, 'Rideaux coupe-feu', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 14, 'chariots DCV', 1, 1, 100, 47, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 15, 'Rails, et générateurs de fréquences 25 KHZ et armoires électrique', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 16, 'Lignes de livraison des bagages et armoires électriques cotée arrivée', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 17, 'Ligne convoyeurs et armoires électriques cotée EDS', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 18, 'Ligne convoyeuse et armoires électriques cotée TOMOGRAPHE', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 19, 'Partie automatisme et informatique', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 20, 'Bascules électriques', 1, 1, 100, 100, 0, 1, 1, 1, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 24, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 25, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 29, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 30, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Système de traitement des bagages(STB) y compris les bascules', 31, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `systheme_sonorisation`
--

CREATE TABLE `systheme_sonorisation` (
  `categorie` varchar(200) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `systheme_sonorisation`
--

INSERT INTO `systheme_sonorisation` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 5, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-01-01'),
('Equipements électroniques', 6, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-01-01'),
('Equipements électroniques', 10, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-01-01'),
('Equipements électroniques', 11, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-02-01'),
('Equipements électroniques', 12, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `systheme_sonorisation_2024_01`
--

CREATE TABLE `systheme_sonorisation_2024_01` (
  `categorie` varchar(200) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `systheme_sonorisation_2024_01`
--

INSERT INTO `systheme_sonorisation_2024_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `systheme_sonorisation_2024_02`
--

CREATE TABLE `systheme_sonorisation_2024_02` (
  `categorie` varchar(200) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `systheme_sonorisation_2024_02`
--

INSERT INTO `systheme_sonorisation_2024_02` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `systheme_sonorisation_2024_03`
--

CREATE TABLE `systheme_sonorisation_2024_03` (
  `categorie` varchar(200) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `systheme_sonorisation_2024_03`
--

INSERT INTO `systheme_sonorisation_2024_03` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `systheme_sonorisation_2025_01`
--

CREATE TABLE `systheme_sonorisation_2025_01` (
  `categorie` varchar(200) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `systheme_sonorisation_2025_01`
--

INSERT INTO `systheme_sonorisation_2025_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('Equipements électroniques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Equipements électroniques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Equipements électroniques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Equipements électroniques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Equipements électroniques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `système_détection_incendie`
--

CREATE TABLE `système_détection_incendie` (
  `categorie` varchar(100) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `système_détection_incendie`
--

INSERT INTO `système_détection_incendie` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 5, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-01-01'),
('Equipements électroniques', 6, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-01-01'),
('Equipements électroniques', 10, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-01-01'),
('Equipements électroniques', 11, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-02-01'),
('Equipements électroniques', 12, NULL, 1, 1, NULL, 100, NULL, 1, 1, NULL, '2019-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `système_détection_incendie_2024_01`
--

CREATE TABLE `système_détection_incendie_2024_01` (
  `categorie` varchar(100) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `système_détection_incendie_2024_01`
--

INSERT INTO `système_détection_incendie_2024_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01'),
('Equipements électroniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `système_détection_incendie_2024_02`
--

CREATE TABLE `système_détection_incendie_2024_02` (
  `categorie` varchar(100) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `système_détection_incendie_2024_02`
--

INSERT INTO `système_détection_incendie_2024_02` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01'),
('Equipements électroniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `système_détection_incendie_2024_03`
--

CREATE TABLE `système_détection_incendie_2024_03` (
  `categorie` varchar(100) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `système_détection_incendie_2024_03`
--

INSERT INTO `système_détection_incendie_2024_03` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 5, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 6, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 10, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 11, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01'),
('Equipements électroniques', 12, '', 1, 1, 100, 100, 100, 1, 1, 1, '2024-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `système_détection_incendie_2025_01`
--

CREATE TABLE `système_détection_incendie_2025_01` (
  `categorie` varchar(100) DEFAULT 'Equipements électroniques',
  `id_element` int(11) NOT NULL,
  `nom_element` varchar(100) DEFAULT NULL,
  `Nombre_dinterventions_planifiées` int(11) DEFAULT 1,
  `Nombre_dinterventions_réalisées_a_temps` int(11) DEFAULT 1,
  `TRP` float DEFAULT NULL,
  `pourcentage_disponibilite_par_element` float DEFAULT 100,
  `disponibilite_totale` float DEFAULT NULL,
  `Nombre_de_réparations` int(11) DEFAULT 1,
  `Temps_total_de_réparation_heures` int(11) DEFAULT 1,
  `MTTR` float DEFAULT NULL,
  `date_recorded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `système_détection_incendie_2025_01`
--

INSERT INTO `système_détection_incendie_2025_01` (`categorie`, `id_element`, `nom_element`, `Nombre_dinterventions_planifiées`, `Nombre_dinterventions_réalisées_a_temps`, `TRP`, `pourcentage_disponibilite_par_element`, `disponibilite_totale`, `Nombre_de_réparations`, `Temps_total_de_réparation_heures`, `MTTR`, `date_recorded`) VALUES
('Equipements électroniques', 1, 'element1', 1, 1, 100, 100, 100, 1, 1, 1, '2025-01-01'),
('Equipements électroniques', 5, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Equipements électroniques', 6, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Equipements électroniques', 10, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Equipements électroniques', 11, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01'),
('Equipements électroniques', 12, '', 1, 1, 0, 100, 0, 1, 1, 0, '2025-01-01');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ascenseurs_escaliers`
--
ALTER TABLE `ascenseurs_escaliers`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `ascenseurs_escaliers_2024_01`
--
ALTER TABLE `ascenseurs_escaliers_2024_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `ascenseurs_escaliers_2024_02`
--
ALTER TABLE `ascenseurs_escaliers_2024_02`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `ascenseurs_escaliers_2024_03`
--
ALTER TABLE `ascenseurs_escaliers_2024_03`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `ascenseurs_escaliers_2025_01`
--
ALTER TABLE `ascenseurs_escaliers_2025_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `balisage_lumineux`
--
ALTER TABLE `balisage_lumineux`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `balisage_lumineux_2024_01`
--
ALTER TABLE `balisage_lumineux_2024_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `balisage_lumineux_2024_02`
--
ALTER TABLE `balisage_lumineux_2024_02`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `balisage_lumineux_2024_03`
--
ALTER TABLE `balisage_lumineux_2024_03`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `balisage_lumineux_2025_01`
--
ALTER TABLE `balisage_lumineux_2025_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `billans`
--
ALTER TABLE `billans`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie_of_table`
--
ALTER TABLE `categorie_of_table`
  ADD PRIMARY KEY (`id_table`);

--
-- Index pour la table `eclairage_publique_bt`
--
ALTER TABLE `eclairage_publique_bt`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `eclairage_publique_bt_2024_01`
--
ALTER TABLE `eclairage_publique_bt_2024_01`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `eclairage_publique_bt_2024_02`
--
ALTER TABLE `eclairage_publique_bt_2024_02`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `eclairage_publique_bt_2024_03`
--
ALTER TABLE `eclairage_publique_bt_2024_03`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `eclairage_publique_bt_2025_01`
--
ALTER TABLE `eclairage_publique_bt_2025_01`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `equipements_climatisation`
--
ALTER TABLE `equipements_climatisation`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_climatisation_2024_01`
--
ALTER TABLE `equipements_climatisation_2024_01`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_climatisation_2024_02`
--
ALTER TABLE `equipements_climatisation_2024_02`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_climatisation_2024_03`
--
ALTER TABLE `equipements_climatisation_2024_03`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_climatisation_2025_01`
--
ALTER TABLE `equipements_climatisation_2025_01`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_surete1`
--
ALTER TABLE `equipements_surete1`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_surete1_2024_01`
--
ALTER TABLE `equipements_surete1_2024_01`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_surete1_2024_02`
--
ALTER TABLE `equipements_surete1_2024_02`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_surete1_2024_03`
--
ALTER TABLE `equipements_surete1_2024_03`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `equipements_surete1_2025_01`
--
ALTER TABLE `equipements_surete1_2025_01`
  ADD PRIMARY KEY (`id_equipement`);

--
-- Index pour la table `global_du_mois`
--
ALTER TABLE `global_du_mois`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `global_du_mois_2024_01`
--
ALTER TABLE `global_du_mois_2024_01`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `global_du_mois_2024_02`
--
ALTER TABLE `global_du_mois_2024_02`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `global_du_mois_2025_01`
--
ALTER TABLE `global_du_mois_2025_01`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groupes_electrogènes_classiques_temps_zéro`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro`
  ADD PRIMARY KEY (`id_groupe`);

--
-- Index pour la table `groupes_electrogènes_classiques_temps_zéro_2024_01`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro_2024_01`
  ADD PRIMARY KEY (`id_groupe`);

--
-- Index pour la table `groupes_electrogènes_classiques_temps_zéro_2024_02`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro_2024_02`
  ADD PRIMARY KEY (`id_groupe`);

--
-- Index pour la table `groupes_electrogènes_classiques_temps_zéro_2024_03`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro_2024_03`
  ADD PRIMARY KEY (`id_groupe`);

--
-- Index pour la table `groupes_electrogènes_classiques_temps_zéro_2025_01`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro_2025_01`
  ADD PRIMARY KEY (`id_groupe`);

--
-- Index pour la table `onduleurs`
--
ALTER TABLE `onduleurs`
  ADD PRIMARY KEY (`id_onduleur`);

--
-- Index pour la table `onduleurs_2024_01`
--
ALTER TABLE `onduleurs_2024_01`
  ADD PRIMARY KEY (`id_onduleur`);

--
-- Index pour la table `onduleurs_2024_02`
--
ALTER TABLE `onduleurs_2024_02`
  ADD PRIMARY KEY (`id_onduleur`);

--
-- Index pour la table `onduleurs_2024_03`
--
ALTER TABLE `onduleurs_2024_03`
  ADD PRIMARY KEY (`id_onduleur`);

--
-- Index pour la table `onduleurs_2025_01`
--
ALTER TABLE `onduleurs_2025_01`
  ADD PRIMARY KEY (`id_onduleur`);

--
-- Index pour la table `passerelles`
--
ALTER TABLE `passerelles`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `passerelles_2024_01`
--
ALTER TABLE `passerelles_2024_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `passerelles_2024_02`
--
ALTER TABLE `passerelles_2024_02`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `passerelles_2024_03`
--
ALTER TABLE `passerelles_2024_03`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `passerelles_2025_01`
--
ALTER TABLE `passerelles_2025_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `portes_automatiques`
--
ALTER TABLE `portes_automatiques`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `portes_automatiques_2024_01`
--
ALTER TABLE `portes_automatiques_2024_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `portes_automatiques_2024_02`
--
ALTER TABLE `portes_automatiques_2024_02`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `portes_automatiques_2024_03`
--
ALTER TABLE `portes_automatiques_2024_03`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `portes_automatiques_2025_01`
--
ALTER TABLE `portes_automatiques_2025_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `postes_hta_bt`
--
ALTER TABLE `postes_hta_bt`
  ADD PRIMARY KEY (`id_poste`);

--
-- Index pour la table `postes_hta_bt_2024_01`
--
ALTER TABLE `postes_hta_bt_2024_01`
  ADD PRIMARY KEY (`id_poste`);

--
-- Index pour la table `postes_hta_bt_2024_02`
--
ALTER TABLE `postes_hta_bt_2024_02`
  ADD PRIMARY KEY (`id_poste`);

--
-- Index pour la table `postes_hta_bt_2024_03`
--
ALTER TABLE `postes_hta_bt_2024_03`
  ADD PRIMARY KEY (`id_poste`);

--
-- Index pour la table `postes_hta_bt_2025_01`
--
ALTER TABLE `postes_hta_bt_2025_01`
  ADD PRIMARY KEY (`id_poste`);

--
-- Index pour la table `slia`
--
ALTER TABLE `slia`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `slia_2024_01`
--
ALTER TABLE `slia_2024_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `slia_2024_02`
--
ALTER TABLE `slia_2024_02`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `slia_2024_03`
--
ALTER TABLE `slia_2024_03`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `slia_2025_01`
--
ALTER TABLE `slia_2025_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `stb`
--
ALTER TABLE `stb`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `stb_2024_01`
--
ALTER TABLE `stb_2024_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `stb_2024_02`
--
ALTER TABLE `stb_2024_02`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `stb_2024_03`
--
ALTER TABLE `stb_2024_03`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `stb_2025_01`
--
ALTER TABLE `stb_2025_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `systheme_sonorisation`
--
ALTER TABLE `systheme_sonorisation`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `systheme_sonorisation_2024_01`
--
ALTER TABLE `systheme_sonorisation_2024_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `systheme_sonorisation_2024_02`
--
ALTER TABLE `systheme_sonorisation_2024_02`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `systheme_sonorisation_2024_03`
--
ALTER TABLE `systheme_sonorisation_2024_03`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `systheme_sonorisation_2025_01`
--
ALTER TABLE `systheme_sonorisation_2025_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `système_détection_incendie`
--
ALTER TABLE `système_détection_incendie`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `système_détection_incendie_2024_01`
--
ALTER TABLE `système_détection_incendie_2024_01`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `système_détection_incendie_2024_02`
--
ALTER TABLE `système_détection_incendie_2024_02`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `système_détection_incendie_2024_03`
--
ALTER TABLE `système_détection_incendie_2024_03`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `système_détection_incendie_2025_01`
--
ALTER TABLE `système_détection_incendie_2025_01`
  ADD PRIMARY KEY (`id_element`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ascenseurs_escaliers`
--
ALTER TABLE `ascenseurs_escaliers`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT pour la table `ascenseurs_escaliers_2024_01`
--
ALTER TABLE `ascenseurs_escaliers_2024_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `ascenseurs_escaliers_2024_02`
--
ALTER TABLE `ascenseurs_escaliers_2024_02`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `ascenseurs_escaliers_2024_03`
--
ALTER TABLE `ascenseurs_escaliers_2024_03`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `ascenseurs_escaliers_2025_01`
--
ALTER TABLE `ascenseurs_escaliers_2025_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `balisage_lumineux`
--
ALTER TABLE `balisage_lumineux`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `balisage_lumineux_2024_01`
--
ALTER TABLE `balisage_lumineux_2024_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `balisage_lumineux_2024_02`
--
ALTER TABLE `balisage_lumineux_2024_02`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `balisage_lumineux_2024_03`
--
ALTER TABLE `balisage_lumineux_2024_03`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `balisage_lumineux_2025_01`
--
ALTER TABLE `balisage_lumineux_2025_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `billans`
--
ALTER TABLE `billans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `categorie_of_table`
--
ALTER TABLE `categorie_of_table`
  MODIFY `id_table` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT pour la table `eclairage_publique_bt`
--
ALTER TABLE `eclairage_publique_bt`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT pour la table `eclairage_publique_bt_2024_01`
--
ALTER TABLE `eclairage_publique_bt_2024_01`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `eclairage_publique_bt_2024_02`
--
ALTER TABLE `eclairage_publique_bt_2024_02`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `eclairage_publique_bt_2024_03`
--
ALTER TABLE `eclairage_publique_bt_2024_03`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `eclairage_publique_bt_2025_01`
--
ALTER TABLE `eclairage_publique_bt_2025_01`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `equipements_climatisation`
--
ALTER TABLE `equipements_climatisation`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT pour la table `equipements_climatisation_2024_01`
--
ALTER TABLE `equipements_climatisation_2024_01`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `equipements_climatisation_2024_02`
--
ALTER TABLE `equipements_climatisation_2024_02`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `equipements_climatisation_2024_03`
--
ALTER TABLE `equipements_climatisation_2024_03`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `equipements_climatisation_2025_01`
--
ALTER TABLE `equipements_climatisation_2025_01`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `equipements_surete1`
--
ALTER TABLE `equipements_surete1`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT pour la table `equipements_surete1_2024_01`
--
ALTER TABLE `equipements_surete1_2024_01`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `equipements_surete1_2024_02`
--
ALTER TABLE `equipements_surete1_2024_02`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `equipements_surete1_2024_03`
--
ALTER TABLE `equipements_surete1_2024_03`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `equipements_surete1_2025_01`
--
ALTER TABLE `equipements_surete1_2025_01`
  MODIFY `id_equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `global_du_mois`
--
ALTER TABLE `global_du_mois`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `global_du_mois_2024_01`
--
ALTER TABLE `global_du_mois_2024_01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `global_du_mois_2024_02`
--
ALTER TABLE `global_du_mois_2024_02`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `global_du_mois_2025_01`
--
ALTER TABLE `global_du_mois_2025_01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `groupes_electrogènes_classiques_temps_zéro`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro`
  MODIFY `id_groupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `groupes_electrogènes_classiques_temps_zéro_2024_01`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro_2024_01`
  MODIFY `id_groupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `groupes_electrogènes_classiques_temps_zéro_2024_02`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro_2024_02`
  MODIFY `id_groupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `groupes_electrogènes_classiques_temps_zéro_2024_03`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro_2024_03`
  MODIFY `id_groupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `groupes_electrogènes_classiques_temps_zéro_2025_01`
--
ALTER TABLE `groupes_electrogènes_classiques_temps_zéro_2025_01`
  MODIFY `id_groupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `onduleurs`
--
ALTER TABLE `onduleurs`
  MODIFY `id_onduleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `onduleurs_2024_01`
--
ALTER TABLE `onduleurs_2024_01`
  MODIFY `id_onduleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `onduleurs_2024_02`
--
ALTER TABLE `onduleurs_2024_02`
  MODIFY `id_onduleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `onduleurs_2024_03`
--
ALTER TABLE `onduleurs_2024_03`
  MODIFY `id_onduleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `onduleurs_2025_01`
--
ALTER TABLE `onduleurs_2025_01`
  MODIFY `id_onduleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `passerelles`
--
ALTER TABLE `passerelles`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `passerelles_2024_01`
--
ALTER TABLE `passerelles_2024_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `passerelles_2024_02`
--
ALTER TABLE `passerelles_2024_02`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `passerelles_2024_03`
--
ALTER TABLE `passerelles_2024_03`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `passerelles_2025_01`
--
ALTER TABLE `passerelles_2025_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `portes_automatiques`
--
ALTER TABLE `portes_automatiques`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `portes_automatiques_2024_01`
--
ALTER TABLE `portes_automatiques_2024_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `portes_automatiques_2024_02`
--
ALTER TABLE `portes_automatiques_2024_02`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `portes_automatiques_2024_03`
--
ALTER TABLE `portes_automatiques_2024_03`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `portes_automatiques_2025_01`
--
ALTER TABLE `portes_automatiques_2025_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `postes_hta_bt`
--
ALTER TABLE `postes_hta_bt`
  MODIFY `id_poste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `postes_hta_bt_2024_01`
--
ALTER TABLE `postes_hta_bt_2024_01`
  MODIFY `id_poste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `postes_hta_bt_2024_02`
--
ALTER TABLE `postes_hta_bt_2024_02`
  MODIFY `id_poste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `postes_hta_bt_2024_03`
--
ALTER TABLE `postes_hta_bt_2024_03`
  MODIFY `id_poste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `postes_hta_bt_2025_01`
--
ALTER TABLE `postes_hta_bt_2025_01`
  MODIFY `id_poste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `slia`
--
ALTER TABLE `slia`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `slia_2024_01`
--
ALTER TABLE `slia_2024_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `slia_2024_02`
--
ALTER TABLE `slia_2024_02`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `slia_2024_03`
--
ALTER TABLE `slia_2024_03`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `slia_2025_01`
--
ALTER TABLE `slia_2025_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `stb`
--
ALTER TABLE `stb`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `stb_2024_01`
--
ALTER TABLE `stb_2024_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `stb_2024_02`
--
ALTER TABLE `stb_2024_02`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `stb_2024_03`
--
ALTER TABLE `stb_2024_03`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `stb_2025_01`
--
ALTER TABLE `stb_2025_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `systheme_sonorisation`
--
ALTER TABLE `systheme_sonorisation`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `systheme_sonorisation_2024_01`
--
ALTER TABLE `systheme_sonorisation_2024_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `systheme_sonorisation_2024_02`
--
ALTER TABLE `systheme_sonorisation_2024_02`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `systheme_sonorisation_2024_03`
--
ALTER TABLE `systheme_sonorisation_2024_03`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `systheme_sonorisation_2025_01`
--
ALTER TABLE `systheme_sonorisation_2025_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `système_détection_incendie`
--
ALTER TABLE `système_détection_incendie`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `système_détection_incendie_2024_01`
--
ALTER TABLE `système_détection_incendie_2024_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `système_détection_incendie_2024_02`
--
ALTER TABLE `système_détection_incendie_2024_02`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `système_détection_incendie_2024_03`
--
ALTER TABLE `système_détection_incendie_2024_03`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `système_détection_incendie_2025_01`
--
ALTER TABLE `système_détection_incendie_2025_01`
  MODIFY `id_element` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Base de données : `bd1`
--
CREATE DATABASE IF NOT EXISTS `bd1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd1`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `titre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Base de données : `gestion_absences`
--
CREATE DATABASE IF NOT EXISTS `gestion_absences` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestion_absences`;
--
-- Base de données : `gestion_etudiants`
--
CREATE DATABASE IF NOT EXISTS `gestion_etudiants` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestion_etudiants`;

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure_debut_creneau` time DEFAULT NULL,
  `heure_fin_creneau` time DEFAULT NULL,
  `justifiee` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Structure de la table `classe_matiere`
--

CREATE TABLE `classe_matiere` (
  `classe_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL
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

CREATE TABLE `emploi_du_temps` (
  `id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL,
  `jour_semaine` varchar(20) NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `matiere_id` int(11) DEFAULT NULL,
  `professeur_id` int(11) DEFAULT NULL,
  `matiere` varchar(100) NOT NULL,
  `enseignant` varchar(100) NOT NULL,
  `salle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emploi_du_temps`
--

INSERT INTO `emploi_du_temps` (`id`, `classe_id`, `jour_semaine`, `heure_debut`, `heure_fin`, `matiere_id`, `professeur_id`, `matiere`, `enseignant`, `salle`) VALUES
(129, 4, 'Lundi', '08:00:00', '10:00:00', 1, 7, '', '', 'CE1'),
(130, 4, 'Lundi', '10:00:00', '12:00:00', 5, 8, '', '', 'CE1'),
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
(18, 'ARIJ', 'BENCHEKROUN', 'SS7895555', '', 'E12355555', 'XX100006', 'ING', 5, 4, 1),
(19, 'azdaag', 'abdellah', 'SS7844486', '', 'E5555660', 'XX444400', 'ING', 9, 4, 1);

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

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `code`, `professeur_id`) VALUES
(1, 'DEV', 'AD0185', 7),
(5, 'RESEAUX', 'AD0186', 8);

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
(5, 'boukssim', 'mouhssine', 'mouhssine.boukssim.25@ump.ac.ma', '0609090909', 'DEV', '2025-06-24 00:40:50', 7),
(6, 'TAIBI', 'CHAKIB', 'chakib.taibi.25@ump.ac.ma', '0700437280', 'RESEAUX', '2025-06-25 01:24:46', 8);

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
(7, 'boukssim', 'mouhssine', 'mouhssine.boukssim.25@ump.ac.ma', '$2y$10$5G55TDtBCf29KyqLOBTus../l7iRcLxsDEKcE5tL1kc6n7chfuYt2', 'professeur', '2025-06-24 00:40:50'),
(8, 'TAIBI', 'CHAKIB', 'chakib.taibi.25@ump.ac.ma', '$2y$10$b0ozwOQCos2xW.BpxHCdHeCpfbl24BKZfKXzyP80r6PqnHjU6Js9e', 'professeur', '2025-06-25 01:24:46'),
(9, 'azdaag', 'abdellah', 'abdellah.azdaag.25@ump.ac.ma', '$2y$10$3gLU/XipeiAxDLvd8.tQRuHrIP/CiHxRhlyunirhxqLDRQldOf7Ui', 'etudiant', '2025-06-26 14:43:45');

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
-- Index pour la table `classe_matiere`
--
ALTER TABLE `classe_matiere`
  ADD PRIMARY KEY (`classe_id`,`matiere_id`),
  ADD KEY `matiere_id` (`matiere_id`);

--
-- Index pour la table `emploi_du_temps`
--
ALTER TABLE `emploi_du_temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classe_id` (`classe_id`),
  ADD KEY `fk_edt_matiere` (`matiere_id`),
  ADD KEY `fk_edt_professeur` (`professeur_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `emploi_du_temps`
--
ALTER TABLE `emploi_du_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `professeurs`
--
ALTER TABLE `professeurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
--
-- Base de données : `marketingdegital`
--
CREATE DATABASE IF NOT EXISTS `marketingdegital` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `marketingdegital`;

-- --------------------------------------------------------

--
-- Structure de la table `wp_commentmeta`
--

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wp_comments`
--

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'Un commentateur ou commentatrice WordPress', 'wapuu@wordpress.example', 'https://fr.wordpress.org/', '', '2025-04-25 18:17:36', '2025-04-25 16:17:36', 'Bonjour, ceci est un commentaire.\nPour débuter avec la modération, la modification et la suppression de commentaires, veuillez visiter l’écran des Commentaires dans le Tableau de bord.\nLes avatars des personnes qui commentent arrivent depuis <a href=\"https://fr.gravatar.com/\">Gravatar</a>.', 0, '1', '', 'comment', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `wp_links`
--

CREATE TABLE `wp_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wp_options`
--

CREATE TABLE `wp_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'cron', 'a:11:{i:1748917057;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1748924290;a:1:{s:21:\"wp_update_user_counts\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1748927854;a:1:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1748929654;a:1:{s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1748931454;a:1:{s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1748967457;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1748967490;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1748967498;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1749208992;a:1:{s:30:\"wp_delete_temp_updater_backups\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1749313057;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'on'),
(2, 'siteurl', 'http://localhost:8080/wordpress-6.6/wordpress', 'on'),
(3, 'home', 'http://localhost:8080/wordpress-6.6/wordpress', 'on'),
(4, 'blogname', 'SHOPITA', 'on'),
(5, 'blogdescription', '', 'on'),
(6, 'users_can_register', '0', 'on'),
(7, 'admin_email', 'essbaisalma0@gmail.com', 'on'),
(8, 'start_of_week', '1', 'on'),
(9, 'use_balanceTags', '0', 'on'),
(10, 'use_smilies', '1', 'on'),
(11, 'require_name_email', '1', 'on'),
(12, 'comments_notify', '1', 'on'),
(13, 'posts_per_rss', '10', 'on'),
(14, 'rss_use_excerpt', '0', 'on'),
(15, 'mailserver_url', 'mail.example.com', 'on'),
(16, 'mailserver_login', 'login@example.com', 'on'),
(17, 'mailserver_pass', 'password', 'on'),
(18, 'mailserver_port', '110', 'on'),
(19, 'default_category', '1', 'on'),
(20, 'default_comment_status', 'open', 'on'),
(21, 'default_ping_status', 'open', 'on'),
(22, 'default_pingback_flag', '1', 'on'),
(23, 'posts_per_page', '10', 'on'),
(24, 'date_format', 'j F Y', 'on'),
(25, 'time_format', 'G\\hi', 'on'),
(26, 'links_updated_date_format', 'd F Y G\\hi', 'on'),
(27, 'comment_moderation', '0', 'on'),
(28, 'moderation_notify', '1', 'on'),
(29, 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', 'on'),
(30, 'rewrite_rules', 'a:95:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:39:\"index.php?&page_id=23&cpage=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:58:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:68:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:88:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:64:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:53:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$\";s:91:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:77:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:65:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:61:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:47:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:53:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:51:\"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:38:\"([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}', 'on'),
(31, 'hack_file', '0', 'on'),
(32, 'blog_charset', 'UTF-8', 'on'),
(33, 'moderation_keys', '', 'off'),
(34, 'active_plugins', 'a:2:{i:0;s:33:\"classic-editor/classic-editor.php\";i:1;s:29:\"vf-expansion/vf-expansion.php\";}', 'on'),
(35, 'category_base', '', 'on'),
(36, 'ping_sites', 'http://rpc.pingomatic.com/', 'on'),
(37, 'comment_max_links', '2', 'on'),
(38, 'gmt_offset', '0', 'on'),
(39, 'default_email_category', '1', 'on'),
(40, 'recently_edited', '', 'off'),
(41, 'template', 'storepress', 'on'),
(42, 'stylesheet', 'storepress', 'on'),
(43, 'comment_registration', '0', 'on'),
(44, 'html_type', 'text/html', 'on'),
(45, 'use_trackback', '0', 'on'),
(46, 'default_role', 'subscriber', 'on'),
(47, 'db_version', '58975', 'on'),
(48, 'uploads_use_yearmonth_folders', '1', 'on'),
(49, 'upload_path', '', 'on'),
(50, 'blog_public', '1', 'on'),
(51, 'default_link_category', '2', 'on'),
(52, 'show_on_front', 'page', 'on'),
(53, 'tag_base', '', 'on'),
(54, 'show_avatars', '1', 'on'),
(55, 'avatar_rating', 'G', 'on'),
(56, 'upload_url_path', '', 'on'),
(57, 'thumbnail_size_w', '150', 'on'),
(58, 'thumbnail_size_h', '150', 'on'),
(59, 'thumbnail_crop', '1', 'on'),
(60, 'medium_size_w', '300', 'on'),
(61, 'medium_size_h', '300', 'on'),
(62, 'avatar_default', 'mystery', 'on'),
(63, 'large_size_w', '1024', 'on'),
(64, 'large_size_h', '1024', 'on'),
(65, 'image_default_link_type', 'none', 'on'),
(66, 'image_default_size', '', 'on'),
(67, 'image_default_align', '', 'on'),
(68, 'close_comments_for_old_posts', '0', 'on'),
(69, 'close_comments_days_old', '14', 'on'),
(70, 'thread_comments', '1', 'on'),
(71, 'thread_comments_depth', '5', 'on'),
(72, 'page_comments', '0', 'on'),
(73, 'comments_per_page', '50', 'on'),
(74, 'default_comments_page', 'newest', 'on'),
(75, 'comment_order', 'asc', 'on'),
(76, 'sticky_posts', 'a:0:{}', 'on'),
(77, 'widget_categories', 'a:3:{i:1;a:1:{s:5:\"title\";s:10:\"Categories\";}i:2;a:1:{s:5:\"title\";s:10:\"Categories\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(78, 'widget_text', 'a:4:{i:1;a:2:{s:5:\"title\";s:12:\"Useful Links\";s:4:\"text\";s:695:\"<ul id=\"menu-primar-menu\" class=\"menu\">\r\n                                <li class=\"menu-item\"><a href=\"javascript:void(0);\">About Us</a></li>\r\n                                <li class=\"menu-item\"><a href=\"javascript:void(0);\">My Account</a></li>\r\n                                <li class=\"menu-item\"><a href=\"javascript:void(0);\">Best Seller</a></li>\r\n                                <li class=\"menu-item\"><a href=\"javascript:void(0);\">Blog</a></li>\r\n                                <li class=\"menu-item\"><a href=\"javascript:void(0);\">Contact</a></li>\r\n                                <li class=\"menu-item\"><a href=\"javascript:void(0);\">Collections</a></li>\r\n                            </ul>\";}i:2;a:2:{s:5:\"title\";s:0:\"\";s:4:\"text\";s:1221:\"<div class=\"widget textwidget\">\r\n                            <a href=\"javascript:void(0);\"><img src=\"http://localhost:8080/wordpress-6.6/wordpress/wp-content/plugins/vf-expansion/inc/themes/storepress/assets/images/logo_2.png\" alt=\"image\"></a>\r\n                            <p>\r\n                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed do eiusmod tempor incididunt.\r\n                            </p>\r\n                            <a class=\"btn btn-primary\" href=\"#\">Read More</a>\r\n                        </div><div class=\"widget widget_mail\">\r\n                            <h5 class=\"widget-title\">Sign up to Get Lates Updates</h5>\r\n                            <form role=\"mail\" method=\"get\" class=\"mail-form\" action=\"/\">\r\n                                <label>\r\n                                    <span class=\"screen-reader-text\">Search for:</span>\r\n                                    <input type=\"email\" class=\"mail-field\" placeholder=\"Your Email Address...\" value=\"\" name=\"e\">\r\n                                </label>\r\n                                <button type=\"submit\" class=\"submit\">Subscribe Now</button>\r\n                            </form>\r\n                        </div>\";}i:3;a:2:{s:5:\"title\";s:0:\"\";s:4:\"text\";s:1554:\"<aside class=\"widget widget_opening\">\r\n                            <h5 class=\"widget-title\">Opening Hours</h5>\r\n                            <div class=\"opening-hours\">\r\n                                <dl class=\"st-grid-dl\">\r\n                                    <dt>Mon - Tues</dt>\r\n                                    <dd>8AM – 4PM</dd>\r\n                                    <dt>Wed - Thus</dt>\r\n                                    <dd>9AM – 6PM</dd>\r\n                                    <dt>Fri - Sat</dt>\r\n                                    <dd>10AM – 5PM</dd>\r\n                                    <dt>Sunday</dt>\r\n                                    <dd>Emerg. Only</dd>\r\n                                    <dt>Personal</dt>\r\n                                    <dd>Mon - 11AM</dd>\r\n                                </dl>\r\n                            </div>\r\n                        </aside><div class=\"widget widget_social\">\r\n                            <h5 class=\"widget-title\">Follow Us</h5>\r\n                            <ul>\r\n                                <li><a href=\"#\"><i class=\"fa fa-facebook\"></i></a></li>\r\n                                <li><a href=\"#\"><i class=\"fa fa-twitter\"></i></a></li>\r\n                                <li><a href=\"#\"><i class=\"fa fa-instagram\"></i></a></li>\r\n                                <li><a href=\"#\"><i class=\"fa fa-youtube-play\"></i></a></li>\r\n                                <li><a href=\"#\"><i class=\"fa fa-dribbble\"></i></a></li>\r\n                            </ul>\r\n                        </div>\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(79, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'auto'),
(80, 'uninstall_plugins', 'a:0:{}', 'off'),
(81, 'timezone_string', 'Europe/Paris', 'on'),
(82, 'page_for_posts', '0', 'on'),
(83, 'page_on_front', '23', 'on'),
(84, 'default_post_format', '0', 'on'),
(85, 'link_manager_enabled', '0', 'on'),
(86, 'finished_splitting_shared_terms', '1', 'on'),
(87, 'site_icon', '0', 'on'),
(88, 'medium_large_size_w', '768', 'on'),
(89, 'medium_large_size_h', '0', 'on'),
(90, 'wp_page_for_privacy_policy', '3', 'on'),
(91, 'show_comments_cookies_opt_in', '1', 'on'),
(92, 'admin_email_lifespan', '1761149854', 'on'),
(93, 'disallowed_keys', '', 'off'),
(94, 'comment_previously_approved', '1', 'on'),
(95, 'auto_plugin_theme_update_emails', 'a:0:{}', 'off'),
(96, 'auto_update_core_dev', 'enabled', 'on'),
(97, 'auto_update_core_minor', 'enabled', 'on'),
(98, 'auto_update_core_major', 'enabled', 'on'),
(99, 'wp_force_deactivated_plugins', 'a:0:{}', 'off'),
(100, 'wp_attachment_pages_enabled', '0', 'on'),
(101, 'initial_db_version', '57155', 'on'),
(102, 'wp_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:61:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'auto'),
(103, 'fresh_site', '0', 'off'),
(104, 'WPLANG', 'fr_FR', 'auto'),
(105, 'user_count', '1', 'off'),
(106, 'widget_block', 'a:6:{i:2;a:1:{s:7:\"content\";s:19:\"<!-- wp:search /-->\";}i:3;a:1:{s:7:\"content\";s:159:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Articles récents</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->\";}i:4;a:1:{s:7:\"content\";s:233:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Commentaires récents</h2><!-- /wp:heading --><!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div><!-- /wp:group -->\";}i:5;a:1:{s:7:\"content\";s:146:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Archives</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:6;a:1:{s:7:\"content\";s:151:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Catégories</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(107, 'sidebars_widgets', 'a:4:{s:26:\"storepress-sidebar-primary\";a:3:{i:0;s:8:\"search-1\";i:1;s:14:\"recent-posts-1\";i:2;s:10:\"archives-1\";}s:19:\"storepress-footer-1\";a:1:{i:0;s:6:\"text-1\";}s:19:\"storepress-footer-2\";a:1:{i:0;s:6:\"text-2\";}s:19:\"storepress-footer-3\";a:1:{i:0;s:6:\"text-3\";}}', 'auto'),
(108, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(109, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(110, 'widget_archives', 'a:3:{i:1;a:1:{s:5:\"title\";s:8:\"Archives\";}i:2;a:1:{s:5:\"title\";s:8:\"Archives\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(111, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(112, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(113, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(114, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(115, 'widget_meta', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(116, 'widget_search', 'a:3:{i:1;a:1:{s:5:\"title\";s:6:\"Search\";}i:2;a:1:{s:5:\"title\";s:6:\"Search\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(117, 'widget_recent-posts', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(118, 'widget_recent-comments', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(119, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(120, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(121, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(122, '_transient_wp_core_block_css_files', 'a:2:{s:7:\"version\";s:5:\"6.8.1\";s:5:\"files\";a:536:{i:0;s:23:\"archives/editor-rtl.css\";i:1;s:27:\"archives/editor-rtl.min.css\";i:2;s:19:\"archives/editor.css\";i:3;s:23:\"archives/editor.min.css\";i:4;s:22:\"archives/style-rtl.css\";i:5;s:26:\"archives/style-rtl.min.css\";i:6;s:18:\"archives/style.css\";i:7;s:22:\"archives/style.min.css\";i:8;s:20:\"audio/editor-rtl.css\";i:9;s:24:\"audio/editor-rtl.min.css\";i:10;s:16:\"audio/editor.css\";i:11;s:20:\"audio/editor.min.css\";i:12;s:19:\"audio/style-rtl.css\";i:13;s:23:\"audio/style-rtl.min.css\";i:14;s:15:\"audio/style.css\";i:15;s:19:\"audio/style.min.css\";i:16;s:19:\"audio/theme-rtl.css\";i:17;s:23:\"audio/theme-rtl.min.css\";i:18;s:15:\"audio/theme.css\";i:19;s:19:\"audio/theme.min.css\";i:20;s:21:\"avatar/editor-rtl.css\";i:21;s:25:\"avatar/editor-rtl.min.css\";i:22;s:17:\"avatar/editor.css\";i:23;s:21:\"avatar/editor.min.css\";i:24;s:20:\"avatar/style-rtl.css\";i:25;s:24:\"avatar/style-rtl.min.css\";i:26;s:16:\"avatar/style.css\";i:27;s:20:\"avatar/style.min.css\";i:28;s:21:\"button/editor-rtl.css\";i:29;s:25:\"button/editor-rtl.min.css\";i:30;s:17:\"button/editor.css\";i:31;s:21:\"button/editor.min.css\";i:32;s:20:\"button/style-rtl.css\";i:33;s:24:\"button/style-rtl.min.css\";i:34;s:16:\"button/style.css\";i:35;s:20:\"button/style.min.css\";i:36;s:22:\"buttons/editor-rtl.css\";i:37;s:26:\"buttons/editor-rtl.min.css\";i:38;s:18:\"buttons/editor.css\";i:39;s:22:\"buttons/editor.min.css\";i:40;s:21:\"buttons/style-rtl.css\";i:41;s:25:\"buttons/style-rtl.min.css\";i:42;s:17:\"buttons/style.css\";i:43;s:21:\"buttons/style.min.css\";i:44;s:22:\"calendar/style-rtl.css\";i:45;s:26:\"calendar/style-rtl.min.css\";i:46;s:18:\"calendar/style.css\";i:47;s:22:\"calendar/style.min.css\";i:48;s:25:\"categories/editor-rtl.css\";i:49;s:29:\"categories/editor-rtl.min.css\";i:50;s:21:\"categories/editor.css\";i:51;s:25:\"categories/editor.min.css\";i:52;s:24:\"categories/style-rtl.css\";i:53;s:28:\"categories/style-rtl.min.css\";i:54;s:20:\"categories/style.css\";i:55;s:24:\"categories/style.min.css\";i:56;s:19:\"code/editor-rtl.css\";i:57;s:23:\"code/editor-rtl.min.css\";i:58;s:15:\"code/editor.css\";i:59;s:19:\"code/editor.min.css\";i:60;s:18:\"code/style-rtl.css\";i:61;s:22:\"code/style-rtl.min.css\";i:62;s:14:\"code/style.css\";i:63;s:18:\"code/style.min.css\";i:64;s:18:\"code/theme-rtl.css\";i:65;s:22:\"code/theme-rtl.min.css\";i:66;s:14:\"code/theme.css\";i:67;s:18:\"code/theme.min.css\";i:68;s:22:\"columns/editor-rtl.css\";i:69;s:26:\"columns/editor-rtl.min.css\";i:70;s:18:\"columns/editor.css\";i:71;s:22:\"columns/editor.min.css\";i:72;s:21:\"columns/style-rtl.css\";i:73;s:25:\"columns/style-rtl.min.css\";i:74;s:17:\"columns/style.css\";i:75;s:21:\"columns/style.min.css\";i:76;s:33:\"comment-author-name/style-rtl.css\";i:77;s:37:\"comment-author-name/style-rtl.min.css\";i:78;s:29:\"comment-author-name/style.css\";i:79;s:33:\"comment-author-name/style.min.css\";i:80;s:29:\"comment-content/style-rtl.css\";i:81;s:33:\"comment-content/style-rtl.min.css\";i:82;s:25:\"comment-content/style.css\";i:83;s:29:\"comment-content/style.min.css\";i:84;s:26:\"comment-date/style-rtl.css\";i:85;s:30:\"comment-date/style-rtl.min.css\";i:86;s:22:\"comment-date/style.css\";i:87;s:26:\"comment-date/style.min.css\";i:88;s:31:\"comment-edit-link/style-rtl.css\";i:89;s:35:\"comment-edit-link/style-rtl.min.css\";i:90;s:27:\"comment-edit-link/style.css\";i:91;s:31:\"comment-edit-link/style.min.css\";i:92;s:32:\"comment-reply-link/style-rtl.css\";i:93;s:36:\"comment-reply-link/style-rtl.min.css\";i:94;s:28:\"comment-reply-link/style.css\";i:95;s:32:\"comment-reply-link/style.min.css\";i:96;s:30:\"comment-template/style-rtl.css\";i:97;s:34:\"comment-template/style-rtl.min.css\";i:98;s:26:\"comment-template/style.css\";i:99;s:30:\"comment-template/style.min.css\";i:100;s:42:\"comments-pagination-numbers/editor-rtl.css\";i:101;s:46:\"comments-pagination-numbers/editor-rtl.min.css\";i:102;s:38:\"comments-pagination-numbers/editor.css\";i:103;s:42:\"comments-pagination-numbers/editor.min.css\";i:104;s:34:\"comments-pagination/editor-rtl.css\";i:105;s:38:\"comments-pagination/editor-rtl.min.css\";i:106;s:30:\"comments-pagination/editor.css\";i:107;s:34:\"comments-pagination/editor.min.css\";i:108;s:33:\"comments-pagination/style-rtl.css\";i:109;s:37:\"comments-pagination/style-rtl.min.css\";i:110;s:29:\"comments-pagination/style.css\";i:111;s:33:\"comments-pagination/style.min.css\";i:112;s:29:\"comments-title/editor-rtl.css\";i:113;s:33:\"comments-title/editor-rtl.min.css\";i:114;s:25:\"comments-title/editor.css\";i:115;s:29:\"comments-title/editor.min.css\";i:116;s:23:\"comments/editor-rtl.css\";i:117;s:27:\"comments/editor-rtl.min.css\";i:118;s:19:\"comments/editor.css\";i:119;s:23:\"comments/editor.min.css\";i:120;s:22:\"comments/style-rtl.css\";i:121;s:26:\"comments/style-rtl.min.css\";i:122;s:18:\"comments/style.css\";i:123;s:22:\"comments/style.min.css\";i:124;s:20:\"cover/editor-rtl.css\";i:125;s:24:\"cover/editor-rtl.min.css\";i:126;s:16:\"cover/editor.css\";i:127;s:20:\"cover/editor.min.css\";i:128;s:19:\"cover/style-rtl.css\";i:129;s:23:\"cover/style-rtl.min.css\";i:130;s:15:\"cover/style.css\";i:131;s:19:\"cover/style.min.css\";i:132;s:22:\"details/editor-rtl.css\";i:133;s:26:\"details/editor-rtl.min.css\";i:134;s:18:\"details/editor.css\";i:135;s:22:\"details/editor.min.css\";i:136;s:21:\"details/style-rtl.css\";i:137;s:25:\"details/style-rtl.min.css\";i:138;s:17:\"details/style.css\";i:139;s:21:\"details/style.min.css\";i:140;s:20:\"embed/editor-rtl.css\";i:141;s:24:\"embed/editor-rtl.min.css\";i:142;s:16:\"embed/editor.css\";i:143;s:20:\"embed/editor.min.css\";i:144;s:19:\"embed/style-rtl.css\";i:145;s:23:\"embed/style-rtl.min.css\";i:146;s:15:\"embed/style.css\";i:147;s:19:\"embed/style.min.css\";i:148;s:19:\"embed/theme-rtl.css\";i:149;s:23:\"embed/theme-rtl.min.css\";i:150;s:15:\"embed/theme.css\";i:151;s:19:\"embed/theme.min.css\";i:152;s:19:\"file/editor-rtl.css\";i:153;s:23:\"file/editor-rtl.min.css\";i:154;s:15:\"file/editor.css\";i:155;s:19:\"file/editor.min.css\";i:156;s:18:\"file/style-rtl.css\";i:157;s:22:\"file/style-rtl.min.css\";i:158;s:14:\"file/style.css\";i:159;s:18:\"file/style.min.css\";i:160;s:23:\"footnotes/style-rtl.css\";i:161;s:27:\"footnotes/style-rtl.min.css\";i:162;s:19:\"footnotes/style.css\";i:163;s:23:\"footnotes/style.min.css\";i:164;s:23:\"freeform/editor-rtl.css\";i:165;s:27:\"freeform/editor-rtl.min.css\";i:166;s:19:\"freeform/editor.css\";i:167;s:23:\"freeform/editor.min.css\";i:168;s:22:\"gallery/editor-rtl.css\";i:169;s:26:\"gallery/editor-rtl.min.css\";i:170;s:18:\"gallery/editor.css\";i:171;s:22:\"gallery/editor.min.css\";i:172;s:21:\"gallery/style-rtl.css\";i:173;s:25:\"gallery/style-rtl.min.css\";i:174;s:17:\"gallery/style.css\";i:175;s:21:\"gallery/style.min.css\";i:176;s:21:\"gallery/theme-rtl.css\";i:177;s:25:\"gallery/theme-rtl.min.css\";i:178;s:17:\"gallery/theme.css\";i:179;s:21:\"gallery/theme.min.css\";i:180;s:20:\"group/editor-rtl.css\";i:181;s:24:\"group/editor-rtl.min.css\";i:182;s:16:\"group/editor.css\";i:183;s:20:\"group/editor.min.css\";i:184;s:19:\"group/style-rtl.css\";i:185;s:23:\"group/style-rtl.min.css\";i:186;s:15:\"group/style.css\";i:187;s:19:\"group/style.min.css\";i:188;s:19:\"group/theme-rtl.css\";i:189;s:23:\"group/theme-rtl.min.css\";i:190;s:15:\"group/theme.css\";i:191;s:19:\"group/theme.min.css\";i:192;s:21:\"heading/style-rtl.css\";i:193;s:25:\"heading/style-rtl.min.css\";i:194;s:17:\"heading/style.css\";i:195;s:21:\"heading/style.min.css\";i:196;s:19:\"html/editor-rtl.css\";i:197;s:23:\"html/editor-rtl.min.css\";i:198;s:15:\"html/editor.css\";i:199;s:19:\"html/editor.min.css\";i:200;s:20:\"image/editor-rtl.css\";i:201;s:24:\"image/editor-rtl.min.css\";i:202;s:16:\"image/editor.css\";i:203;s:20:\"image/editor.min.css\";i:204;s:19:\"image/style-rtl.css\";i:205;s:23:\"image/style-rtl.min.css\";i:206;s:15:\"image/style.css\";i:207;s:19:\"image/style.min.css\";i:208;s:19:\"image/theme-rtl.css\";i:209;s:23:\"image/theme-rtl.min.css\";i:210;s:15:\"image/theme.css\";i:211;s:19:\"image/theme.min.css\";i:212;s:29:\"latest-comments/style-rtl.css\";i:213;s:33:\"latest-comments/style-rtl.min.css\";i:214;s:25:\"latest-comments/style.css\";i:215;s:29:\"latest-comments/style.min.css\";i:216;s:27:\"latest-posts/editor-rtl.css\";i:217;s:31:\"latest-posts/editor-rtl.min.css\";i:218;s:23:\"latest-posts/editor.css\";i:219;s:27:\"latest-posts/editor.min.css\";i:220;s:26:\"latest-posts/style-rtl.css\";i:221;s:30:\"latest-posts/style-rtl.min.css\";i:222;s:22:\"latest-posts/style.css\";i:223;s:26:\"latest-posts/style.min.css\";i:224;s:18:\"list/style-rtl.css\";i:225;s:22:\"list/style-rtl.min.css\";i:226;s:14:\"list/style.css\";i:227;s:18:\"list/style.min.css\";i:228;s:22:\"loginout/style-rtl.css\";i:229;s:26:\"loginout/style-rtl.min.css\";i:230;s:18:\"loginout/style.css\";i:231;s:22:\"loginout/style.min.css\";i:232;s:25:\"media-text/editor-rtl.css\";i:233;s:29:\"media-text/editor-rtl.min.css\";i:234;s:21:\"media-text/editor.css\";i:235;s:25:\"media-text/editor.min.css\";i:236;s:24:\"media-text/style-rtl.css\";i:237;s:28:\"media-text/style-rtl.min.css\";i:238;s:20:\"media-text/style.css\";i:239;s:24:\"media-text/style.min.css\";i:240;s:19:\"more/editor-rtl.css\";i:241;s:23:\"more/editor-rtl.min.css\";i:242;s:15:\"more/editor.css\";i:243;s:19:\"more/editor.min.css\";i:244;s:30:\"navigation-link/editor-rtl.css\";i:245;s:34:\"navigation-link/editor-rtl.min.css\";i:246;s:26:\"navigation-link/editor.css\";i:247;s:30:\"navigation-link/editor.min.css\";i:248;s:29:\"navigation-link/style-rtl.css\";i:249;s:33:\"navigation-link/style-rtl.min.css\";i:250;s:25:\"navigation-link/style.css\";i:251;s:29:\"navigation-link/style.min.css\";i:252;s:33:\"navigation-submenu/editor-rtl.css\";i:253;s:37:\"navigation-submenu/editor-rtl.min.css\";i:254;s:29:\"navigation-submenu/editor.css\";i:255;s:33:\"navigation-submenu/editor.min.css\";i:256;s:25:\"navigation/editor-rtl.css\";i:257;s:29:\"navigation/editor-rtl.min.css\";i:258;s:21:\"navigation/editor.css\";i:259;s:25:\"navigation/editor.min.css\";i:260;s:24:\"navigation/style-rtl.css\";i:261;s:28:\"navigation/style-rtl.min.css\";i:262;s:20:\"navigation/style.css\";i:263;s:24:\"navigation/style.min.css\";i:264;s:23:\"nextpage/editor-rtl.css\";i:265;s:27:\"nextpage/editor-rtl.min.css\";i:266;s:19:\"nextpage/editor.css\";i:267;s:23:\"nextpage/editor.min.css\";i:268;s:24:\"page-list/editor-rtl.css\";i:269;s:28:\"page-list/editor-rtl.min.css\";i:270;s:20:\"page-list/editor.css\";i:271;s:24:\"page-list/editor.min.css\";i:272;s:23:\"page-list/style-rtl.css\";i:273;s:27:\"page-list/style-rtl.min.css\";i:274;s:19:\"page-list/style.css\";i:275;s:23:\"page-list/style.min.css\";i:276;s:24:\"paragraph/editor-rtl.css\";i:277;s:28:\"paragraph/editor-rtl.min.css\";i:278;s:20:\"paragraph/editor.css\";i:279;s:24:\"paragraph/editor.min.css\";i:280;s:23:\"paragraph/style-rtl.css\";i:281;s:27:\"paragraph/style-rtl.min.css\";i:282;s:19:\"paragraph/style.css\";i:283;s:23:\"paragraph/style.min.css\";i:284;s:35:\"post-author-biography/style-rtl.css\";i:285;s:39:\"post-author-biography/style-rtl.min.css\";i:286;s:31:\"post-author-biography/style.css\";i:287;s:35:\"post-author-biography/style.min.css\";i:288;s:30:\"post-author-name/style-rtl.css\";i:289;s:34:\"post-author-name/style-rtl.min.css\";i:290;s:26:\"post-author-name/style.css\";i:291;s:30:\"post-author-name/style.min.css\";i:292;s:26:\"post-author/editor-rtl.css\";i:293;s:30:\"post-author/editor-rtl.min.css\";i:294;s:22:\"post-author/editor.css\";i:295;s:26:\"post-author/editor.min.css\";i:296;s:25:\"post-author/style-rtl.css\";i:297;s:29:\"post-author/style-rtl.min.css\";i:298;s:21:\"post-author/style.css\";i:299;s:25:\"post-author/style.min.css\";i:300;s:33:\"post-comments-form/editor-rtl.css\";i:301;s:37:\"post-comments-form/editor-rtl.min.css\";i:302;s:29:\"post-comments-form/editor.css\";i:303;s:33:\"post-comments-form/editor.min.css\";i:304;s:32:\"post-comments-form/style-rtl.css\";i:305;s:36:\"post-comments-form/style-rtl.min.css\";i:306;s:28:\"post-comments-form/style.css\";i:307;s:32:\"post-comments-form/style.min.css\";i:308;s:26:\"post-content/style-rtl.css\";i:309;s:30:\"post-content/style-rtl.min.css\";i:310;s:22:\"post-content/style.css\";i:311;s:26:\"post-content/style.min.css\";i:312;s:23:\"post-date/style-rtl.css\";i:313;s:27:\"post-date/style-rtl.min.css\";i:314;s:19:\"post-date/style.css\";i:315;s:23:\"post-date/style.min.css\";i:316;s:27:\"post-excerpt/editor-rtl.css\";i:317;s:31:\"post-excerpt/editor-rtl.min.css\";i:318;s:23:\"post-excerpt/editor.css\";i:319;s:27:\"post-excerpt/editor.min.css\";i:320;s:26:\"post-excerpt/style-rtl.css\";i:321;s:30:\"post-excerpt/style-rtl.min.css\";i:322;s:22:\"post-excerpt/style.css\";i:323;s:26:\"post-excerpt/style.min.css\";i:324;s:34:\"post-featured-image/editor-rtl.css\";i:325;s:38:\"post-featured-image/editor-rtl.min.css\";i:326;s:30:\"post-featured-image/editor.css\";i:327;s:34:\"post-featured-image/editor.min.css\";i:328;s:33:\"post-featured-image/style-rtl.css\";i:329;s:37:\"post-featured-image/style-rtl.min.css\";i:330;s:29:\"post-featured-image/style.css\";i:331;s:33:\"post-featured-image/style.min.css\";i:332;s:34:\"post-navigation-link/style-rtl.css\";i:333;s:38:\"post-navigation-link/style-rtl.min.css\";i:334;s:30:\"post-navigation-link/style.css\";i:335;s:34:\"post-navigation-link/style.min.css\";i:336;s:27:\"post-template/style-rtl.css\";i:337;s:31:\"post-template/style-rtl.min.css\";i:338;s:23:\"post-template/style.css\";i:339;s:27:\"post-template/style.min.css\";i:340;s:24:\"post-terms/style-rtl.css\";i:341;s:28:\"post-terms/style-rtl.min.css\";i:342;s:20:\"post-terms/style.css\";i:343;s:24:\"post-terms/style.min.css\";i:344;s:24:\"post-title/style-rtl.css\";i:345;s:28:\"post-title/style-rtl.min.css\";i:346;s:20:\"post-title/style.css\";i:347;s:24:\"post-title/style.min.css\";i:348;s:26:\"preformatted/style-rtl.css\";i:349;s:30:\"preformatted/style-rtl.min.css\";i:350;s:22:\"preformatted/style.css\";i:351;s:26:\"preformatted/style.min.css\";i:352;s:24:\"pullquote/editor-rtl.css\";i:353;s:28:\"pullquote/editor-rtl.min.css\";i:354;s:20:\"pullquote/editor.css\";i:355;s:24:\"pullquote/editor.min.css\";i:356;s:23:\"pullquote/style-rtl.css\";i:357;s:27:\"pullquote/style-rtl.min.css\";i:358;s:19:\"pullquote/style.css\";i:359;s:23:\"pullquote/style.min.css\";i:360;s:23:\"pullquote/theme-rtl.css\";i:361;s:27:\"pullquote/theme-rtl.min.css\";i:362;s:19:\"pullquote/theme.css\";i:363;s:23:\"pullquote/theme.min.css\";i:364;s:39:\"query-pagination-numbers/editor-rtl.css\";i:365;s:43:\"query-pagination-numbers/editor-rtl.min.css\";i:366;s:35:\"query-pagination-numbers/editor.css\";i:367;s:39:\"query-pagination-numbers/editor.min.css\";i:368;s:31:\"query-pagination/editor-rtl.css\";i:369;s:35:\"query-pagination/editor-rtl.min.css\";i:370;s:27:\"query-pagination/editor.css\";i:371;s:31:\"query-pagination/editor.min.css\";i:372;s:30:\"query-pagination/style-rtl.css\";i:373;s:34:\"query-pagination/style-rtl.min.css\";i:374;s:26:\"query-pagination/style.css\";i:375;s:30:\"query-pagination/style.min.css\";i:376;s:25:\"query-title/style-rtl.css\";i:377;s:29:\"query-title/style-rtl.min.css\";i:378;s:21:\"query-title/style.css\";i:379;s:25:\"query-title/style.min.css\";i:380;s:25:\"query-total/style-rtl.css\";i:381;s:29:\"query-total/style-rtl.min.css\";i:382;s:21:\"query-total/style.css\";i:383;s:25:\"query-total/style.min.css\";i:384;s:20:\"query/editor-rtl.css\";i:385;s:24:\"query/editor-rtl.min.css\";i:386;s:16:\"query/editor.css\";i:387;s:20:\"query/editor.min.css\";i:388;s:19:\"quote/style-rtl.css\";i:389;s:23:\"quote/style-rtl.min.css\";i:390;s:15:\"quote/style.css\";i:391;s:19:\"quote/style.min.css\";i:392;s:19:\"quote/theme-rtl.css\";i:393;s:23:\"quote/theme-rtl.min.css\";i:394;s:15:\"quote/theme.css\";i:395;s:19:\"quote/theme.min.css\";i:396;s:23:\"read-more/style-rtl.css\";i:397;s:27:\"read-more/style-rtl.min.css\";i:398;s:19:\"read-more/style.css\";i:399;s:23:\"read-more/style.min.css\";i:400;s:18:\"rss/editor-rtl.css\";i:401;s:22:\"rss/editor-rtl.min.css\";i:402;s:14:\"rss/editor.css\";i:403;s:18:\"rss/editor.min.css\";i:404;s:17:\"rss/style-rtl.css\";i:405;s:21:\"rss/style-rtl.min.css\";i:406;s:13:\"rss/style.css\";i:407;s:17:\"rss/style.min.css\";i:408;s:21:\"search/editor-rtl.css\";i:409;s:25:\"search/editor-rtl.min.css\";i:410;s:17:\"search/editor.css\";i:411;s:21:\"search/editor.min.css\";i:412;s:20:\"search/style-rtl.css\";i:413;s:24:\"search/style-rtl.min.css\";i:414;s:16:\"search/style.css\";i:415;s:20:\"search/style.min.css\";i:416;s:20:\"search/theme-rtl.css\";i:417;s:24:\"search/theme-rtl.min.css\";i:418;s:16:\"search/theme.css\";i:419;s:20:\"search/theme.min.css\";i:420;s:24:\"separator/editor-rtl.css\";i:421;s:28:\"separator/editor-rtl.min.css\";i:422;s:20:\"separator/editor.css\";i:423;s:24:\"separator/editor.min.css\";i:424;s:23:\"separator/style-rtl.css\";i:425;s:27:\"separator/style-rtl.min.css\";i:426;s:19:\"separator/style.css\";i:427;s:23:\"separator/style.min.css\";i:428;s:23:\"separator/theme-rtl.css\";i:429;s:27:\"separator/theme-rtl.min.css\";i:430;s:19:\"separator/theme.css\";i:431;s:23:\"separator/theme.min.css\";i:432;s:24:\"shortcode/editor-rtl.css\";i:433;s:28:\"shortcode/editor-rtl.min.css\";i:434;s:20:\"shortcode/editor.css\";i:435;s:24:\"shortcode/editor.min.css\";i:436;s:24:\"site-logo/editor-rtl.css\";i:437;s:28:\"site-logo/editor-rtl.min.css\";i:438;s:20:\"site-logo/editor.css\";i:439;s:24:\"site-logo/editor.min.css\";i:440;s:23:\"site-logo/style-rtl.css\";i:441;s:27:\"site-logo/style-rtl.min.css\";i:442;s:19:\"site-logo/style.css\";i:443;s:23:\"site-logo/style.min.css\";i:444;s:27:\"site-tagline/editor-rtl.css\";i:445;s:31:\"site-tagline/editor-rtl.min.css\";i:446;s:23:\"site-tagline/editor.css\";i:447;s:27:\"site-tagline/editor.min.css\";i:448;s:26:\"site-tagline/style-rtl.css\";i:449;s:30:\"site-tagline/style-rtl.min.css\";i:450;s:22:\"site-tagline/style.css\";i:451;s:26:\"site-tagline/style.min.css\";i:452;s:25:\"site-title/editor-rtl.css\";i:453;s:29:\"site-title/editor-rtl.min.css\";i:454;s:21:\"site-title/editor.css\";i:455;s:25:\"site-title/editor.min.css\";i:456;s:24:\"site-title/style-rtl.css\";i:457;s:28:\"site-title/style-rtl.min.css\";i:458;s:20:\"site-title/style.css\";i:459;s:24:\"site-title/style.min.css\";i:460;s:26:\"social-link/editor-rtl.css\";i:461;s:30:\"social-link/editor-rtl.min.css\";i:462;s:22:\"social-link/editor.css\";i:463;s:26:\"social-link/editor.min.css\";i:464;s:27:\"social-links/editor-rtl.css\";i:465;s:31:\"social-links/editor-rtl.min.css\";i:466;s:23:\"social-links/editor.css\";i:467;s:27:\"social-links/editor.min.css\";i:468;s:26:\"social-links/style-rtl.css\";i:469;s:30:\"social-links/style-rtl.min.css\";i:470;s:22:\"social-links/style.css\";i:471;s:26:\"social-links/style.min.css\";i:472;s:21:\"spacer/editor-rtl.css\";i:473;s:25:\"spacer/editor-rtl.min.css\";i:474;s:17:\"spacer/editor.css\";i:475;s:21:\"spacer/editor.min.css\";i:476;s:20:\"spacer/style-rtl.css\";i:477;s:24:\"spacer/style-rtl.min.css\";i:478;s:16:\"spacer/style.css\";i:479;s:20:\"spacer/style.min.css\";i:480;s:20:\"table/editor-rtl.css\";i:481;s:24:\"table/editor-rtl.min.css\";i:482;s:16:\"table/editor.css\";i:483;s:20:\"table/editor.min.css\";i:484;s:19:\"table/style-rtl.css\";i:485;s:23:\"table/style-rtl.min.css\";i:486;s:15:\"table/style.css\";i:487;s:19:\"table/style.min.css\";i:488;s:19:\"table/theme-rtl.css\";i:489;s:23:\"table/theme-rtl.min.css\";i:490;s:15:\"table/theme.css\";i:491;s:19:\"table/theme.min.css\";i:492;s:24:\"tag-cloud/editor-rtl.css\";i:493;s:28:\"tag-cloud/editor-rtl.min.css\";i:494;s:20:\"tag-cloud/editor.css\";i:495;s:24:\"tag-cloud/editor.min.css\";i:496;s:23:\"tag-cloud/style-rtl.css\";i:497;s:27:\"tag-cloud/style-rtl.min.css\";i:498;s:19:\"tag-cloud/style.css\";i:499;s:23:\"tag-cloud/style.min.css\";i:500;s:28:\"template-part/editor-rtl.css\";i:501;s:32:\"template-part/editor-rtl.min.css\";i:502;s:24:\"template-part/editor.css\";i:503;s:28:\"template-part/editor.min.css\";i:504;s:27:\"template-part/theme-rtl.css\";i:505;s:31:\"template-part/theme-rtl.min.css\";i:506;s:23:\"template-part/theme.css\";i:507;s:27:\"template-part/theme.min.css\";i:508;s:30:\"term-description/style-rtl.css\";i:509;s:34:\"term-description/style-rtl.min.css\";i:510;s:26:\"term-description/style.css\";i:511;s:30:\"term-description/style.min.css\";i:512;s:27:\"text-columns/editor-rtl.css\";i:513;s:31:\"text-columns/editor-rtl.min.css\";i:514;s:23:\"text-columns/editor.css\";i:515;s:27:\"text-columns/editor.min.css\";i:516;s:26:\"text-columns/style-rtl.css\";i:517;s:30:\"text-columns/style-rtl.min.css\";i:518;s:22:\"text-columns/style.css\";i:519;s:26:\"text-columns/style.min.css\";i:520;s:19:\"verse/style-rtl.css\";i:521;s:23:\"verse/style-rtl.min.css\";i:522;s:15:\"verse/style.css\";i:523;s:19:\"verse/style.min.css\";i:524;s:20:\"video/editor-rtl.css\";i:525;s:24:\"video/editor-rtl.min.css\";i:526;s:16:\"video/editor.css\";i:527;s:20:\"video/editor.min.css\";i:528;s:19:\"video/style-rtl.css\";i:529;s:23:\"video/style-rtl.min.css\";i:530;s:15:\"video/style.css\";i:531;s:19:\"video/style.min.css\";i:532;s:19:\"video/theme-rtl.css\";i:533;s:23:\"video/theme-rtl.min.css\";i:534;s:15:\"video/theme.css\";i:535;s:19:\"video/theme.min.css\";}}', 'on'),
(126, 'recovery_keys', 'a:0:{}', 'off'),
(127, 'theme_mods_twentytwentyfour', 'a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1748789542;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:3:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";}s:9:\"sidebar-2\";a:2:{i:0;s:7:\"block-5\";i:1;s:7:\"block-6\";}}}}', 'off'),
(156, 'finished_updating_comment_type', '1', 'auto'),
(157, '_site_transient_wp_plugin_dependencies_plugin_data', 'a:0:{}', 'off'),
(158, 'recently_activated', 'a:0:{}', 'off'),
(174, 'db_upgraded', '', 'on'),
(181, 'auto_core_update_notified', 'a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:22:\"essbaisalma0@gmail.com\";s:7:\"version\";s:5:\"6.8.1\";s:9:\"timestamp\";i:1747999534;}', 'off'),
(184, 'https_detection_errors', 'a:1:{s:20:\"https_request_failed\";a:1:{i:0;s:28:\"La demande HTTPS a échoué.\";}}', 'auto'),
(187, '_transient_wp_styles_for_blocks', 'a:2:{s:4:\"hash\";s:32:\"04bc21473354e6654273c9319dc29fde\";s:6:\"blocks\";a:5:{s:11:\"core/button\";s:0:\"\";s:14:\"core/site-logo\";s:0:\"\";s:18:\"core/post-template\";s:120:\":where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}\";s:12:\"core/columns\";s:102:\":where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}\";s:14:\"core/pullquote\";s:69:\":root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}\";}}', 'on'),
(188, '_transient_health-check-site-status-result', '{\"good\":16,\"recommended\":5,\"critical\":2}', 'on'),
(193, 'can_compress_scripts', '1', 'on'),
(222, '_site_transient_timeout_php_check_38979a08dcd71638878b7b4419751271', '1749341481', 'off'),
(223, '_site_transient_php_check_38979a08dcd71638878b7b4419751271', 'a:5:{s:19:\"recommended_version\";s:3:\"7.4\";s:15:\"minimum_version\";s:6:\"7.2.24\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}', 'off'),
(226, '_site_transient_timeout_browser_0e0369e2813db7deb26e5937c353aab4', '1749341637', 'off');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(227, '_site_transient_browser_0e0369e2813db7deb26e5937c353aab4', 'a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:9:\"136.0.0.0\";s:8:\"platform\";s:7:\"Windows\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}', 'off'),
(247, 'wp_calendar_block_has_published_posts', '1', 'auto'),
(295, 'current_theme', 'StorePress', 'auto'),
(296, 'theme_mods_storepress', 'a:4:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;s:11:\"custom_logo\";i:15;}', 'on'),
(297, 'theme_switched', '', 'auto'),
(298, 'downloaded_font_files', 'a:57:{s:86:\"https://fonts.gstatic.com/s/dancingscript/v25/If2RXTr6YS-zF4S-kcSWSVi_szLviuEViw.woff2\";s:113:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/dancing-script/If2RXTr6YS-zF4S-kcSWSVi_szLviuEViw.woff2\";s:86:\"https://fonts.gstatic.com/s/dancingscript/v25/If2RXTr6YS-zF4S-kcSWSVi_szLuiuEViw.woff2\";s:113:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/dancing-script/If2RXTr6YS-zF4S-kcSWSVi_szLuiuEViw.woff2\";s:83:\"https://fonts.gstatic.com/s/dancingscript/v25/If2RXTr6YS-zF4S-kcSWSVi_szLgiuE.woff2\";s:110:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/dancing-script/If2RXTr6YS-zF4S-kcSWSVi_szLgiuE.woff2\";s:76:\"https://fonts.gstatic.com/s/poppins/v23/pxiAyp8kv8JHgFVrJJLmE0tDMPKzSQ.woff2\";s:102:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiAyp8kv8JHgFVrJJLmE0tDMPKzSQ.woff2\";s:76:\"https://fonts.gstatic.com/s/poppins/v23/pxiAyp8kv8JHgFVrJJLmE0tMMPKzSQ.woff2\";s:102:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiAyp8kv8JHgFVrJJLmE0tMMPKzSQ.woff2\";s:73:\"https://fonts.gstatic.com/s/poppins/v23/pxiAyp8kv8JHgFVrJJLmE0tCMPI.woff2\";s:99:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiAyp8kv8JHgFVrJJLmE0tCMPI.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmv1pVFteOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmv1pVFteOcEg.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmv1pVGdeOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmv1pVGdeOcEg.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmv1pVF9eO.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmv1pVF9eO.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm21lVFteOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm21lVFteOcEg.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm21lVGdeOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm21lVGdeOcEg.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm21lVF9eO.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm21lVF9eO.woff2\";s:73:\"https://fonts.gstatic.com/s/poppins/v23/pxiGyp8kv8JHgFVrJJLucXtAKPY.woff2\";s:99:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiGyp8kv8JHgFVrJJLucXtAKPY.woff2\";s:73:\"https://fonts.gstatic.com/s/poppins/v23/pxiGyp8kv8JHgFVrJJLufntAKPY.woff2\";s:99:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiGyp8kv8JHgFVrJJLufntAKPY.woff2\";s:70:\"https://fonts.gstatic.com/s/poppins/v23/pxiGyp8kv8JHgFVrJJLucHtA.woff2\";s:96:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiGyp8kv8JHgFVrJJLucHtA.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmg1hVFteOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmg1hVFteOcEg.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmg1hVGdeOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmg1hVGdeOcEg.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmg1hVF9eO.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmg1hVF9eO.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmr19VFteOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmr19VFteOcEg.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmr19VGdeOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmr19VGdeOcEg.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmr19VF9eO.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmr19VF9eO.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmy15VFteOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmy15VFteOcEg.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmy15VGdeOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmy15VGdeOcEg.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLmy15VF9eO.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLmy15VF9eO.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm111VFteOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm111VFteOcEg.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm111VGdeOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm111VGdeOcEg.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm111VF9eO.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm111VF9eO.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm81xVFteOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm81xVFteOcEg.woff2\";s:77:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm81xVGdeOcEg.woff2\";s:103:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm81xVGdeOcEg.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiDyp8kv8JHgFVrJJLm81xVF9eO.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiDyp8kv8JHgFVrJJLm81xVF9eO.woff2\";s:73:\"https://fonts.gstatic.com/s/poppins/v23/pxiGyp8kv8JHgFVrLPTucXtAKPY.woff2\";s:99:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiGyp8kv8JHgFVrLPTucXtAKPY.woff2\";s:73:\"https://fonts.gstatic.com/s/poppins/v23/pxiGyp8kv8JHgFVrLPTufntAKPY.woff2\";s:99:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiGyp8kv8JHgFVrLPTufntAKPY.woff2\";s:70:\"https://fonts.gstatic.com/s/poppins/v23/pxiGyp8kv8JHgFVrLPTucHtA.woff2\";s:96:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiGyp8kv8JHgFVrLPTucHtA.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLFj_Z11lFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLFj_Z11lFc-K.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLFj_Z1JlFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLFj_Z1JlFc-K.woff2\";s:72:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLFj_Z1xlFQ.woff2\";s:98:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLFj_Z1xlFQ.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLDz8Z11lFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLDz8Z11lFc-K.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLDz8Z1JlFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLDz8Z1JlFc-K.woff2\";s:72:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLDz8Z1xlFQ.woff2\";s:98:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLDz8Z1xlFQ.woff2\";s:70:\"https://fonts.gstatic.com/s/poppins/v23/pxiEyp8kv8JHgFVrJJbecmNE.woff2\";s:96:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiEyp8kv8JHgFVrJJbecmNE.woff2\";s:70:\"https://fonts.gstatic.com/s/poppins/v23/pxiEyp8kv8JHgFVrJJnecmNE.woff2\";s:96:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiEyp8kv8JHgFVrJJnecmNE.woff2\";s:68:\"https://fonts.gstatic.com/s/poppins/v23/pxiEyp8kv8JHgFVrJJfecg.woff2\";s:94:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiEyp8kv8JHgFVrJJfecg.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLGT9Z11lFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLGT9Z11lFc-K.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLGT9Z1JlFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLGT9Z1JlFc-K.woff2\";s:72:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLGT9Z1xlFQ.woff2\";s:98:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLGT9Z1xlFQ.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLEj6Z11lFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLEj6Z11lFc-K.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLEj6Z1JlFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLEj6Z1JlFc-K.woff2\";s:72:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2\";s:98:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLCz7Z11lFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLCz7Z11lFc-K.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLCz7Z1JlFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLCz7Z1JlFc-K.woff2\";s:72:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLCz7Z1xlFQ.woff2\";s:98:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLCz7Z1xlFQ.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLDD4Z11lFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLDD4Z11lFc-K.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLDD4Z1JlFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLDD4Z1JlFc-K.woff2\";s:72:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLDD4Z1xlFQ.woff2\";s:98:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLDD4Z1xlFQ.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLBT5Z11lFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLBT5Z11lFc-K.woff2\";s:74:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLBT5Z1JlFc-K.woff2\";s:100:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLBT5Z1JlFc-K.woff2\";s:72:\"https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLBT5Z1xlFQ.woff2\";s:98:\"C:/xampp/htdocs/wordpress-6.6/wordpress/wp-content//fonts/poppins/pxiByp8kv8JHgFVrLBT5Z1xlFQ.woff2\";}', 'off'),
(327, 'storepress_media_id', 'a:8:{i:0;i:15;i:1;i:16;i:2;i:17;i:3;i:18;i:4;i:19;i:5;i:20;i:6;i:21;i:7;i:22;}', 'auto'),
(328, 'site_logo', '15', 'auto'),
(331, 'category_children', 'a:1:{i:3;a:1:{i:0;i:4;}}', 'auto'),
(332, 'item_details_page', 'Done', 'auto'),
(334, '_transient_is_multi_author', '0', 'on'),
(338, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/fr_FR/wordpress-6.8.1.zip\";s:6:\"locale\";s:5:\"fr_FR\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/fr_FR/wordpress-6.8.1.zip\";s:10:\"no_content\";s:0:\"\";s:11:\"new_bundled\";s:0:\"\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"6.8.1\";s:7:\"version\";s:5:\"6.8.1\";s:11:\"php_version\";s:6:\"7.2.24\";s:13:\"mysql_version\";s:5:\"5.5.5\";s:11:\"new_bundled\";s:3:\"6.7\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1748905705;s:15:\"version_checked\";s:5:\"6.8.1\";s:12:\"translations\";a:0:{}}', 'off'),
(361, '_site_transient_timeout_theme_roots', '1748907509', 'off'),
(362, '_site_transient_theme_roots', 'a:5:{s:10:\"storepress\";s:7:\"/themes\";s:16:\"twentytwentyfive\";s:7:\"/themes\";s:16:\"twentytwentyfour\";s:7:\"/themes\";s:17:\"twentytwentythree\";s:7:\"/themes\";s:15:\"twentytwentytwo\";s:7:\"/themes\";}', 'off'),
(363, '_site_transient_update_themes', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1748905711;s:7:\"checked\";a:5:{s:10:\"storepress\";s:6:\"1.0.12\";s:16:\"twentytwentyfive\";s:3:\"1.2\";s:16:\"twentytwentyfour\";s:3:\"1.2\";s:17:\"twentytwentythree\";s:3:\"1.5\";s:15:\"twentytwentytwo\";s:3:\"1.8\";}s:8:\"response\";a:3:{s:16:\"twentytwentyfour\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfour\";s:11:\"new_version\";s:3:\"1.3\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfour/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfour.1.3.zip\";s:8:\"requires\";s:3:\"6.4\";s:12:\"requires_php\";s:3:\"7.0\";}s:17:\"twentytwentythree\";a:6:{s:5:\"theme\";s:17:\"twentytwentythree\";s:11:\"new_version\";s:3:\"1.6\";s:3:\"url\";s:47:\"https://wordpress.org/themes/twentytwentythree/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/theme/twentytwentythree.1.6.zip\";s:8:\"requires\";s:3:\"6.1\";s:12:\"requires_php\";s:3:\"5.6\";}s:15:\"twentytwentytwo\";a:6:{s:5:\"theme\";s:15:\"twentytwentytwo\";s:11:\"new_version\";s:3:\"2.0\";s:3:\"url\";s:45:\"https://wordpress.org/themes/twentytwentytwo/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/theme/twentytwentytwo.2.0.zip\";s:8:\"requires\";s:3:\"5.9\";s:12:\"requires_php\";s:3:\"5.6\";}}s:9:\"no_update\";a:2:{s:10:\"storepress\";a:6:{s:5:\"theme\";s:10:\"storepress\";s:11:\"new_version\";s:6:\"1.0.12\";s:3:\"url\";s:40:\"https://wordpress.org/themes/storepress/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/theme/storepress.1.0.12.zip\";s:8:\"requires\";b:0;s:12:\"requires_php\";s:3:\"5.6\";}s:16:\"twentytwentyfive\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfive\";s:11:\"new_version\";s:3:\"1.2\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfive/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfive.1.2.zip\";s:8:\"requires\";s:3:\"6.7\";s:12:\"requires_php\";s:3:\"7.2\";}}s:12:\"translations\";a:0:{}}', 'off'),
(364, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1748905713;s:8:\"response\";a:1:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:3:\"5.4\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:54:\"https://downloads.wordpress.org/plugin/akismet.5.4.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:60:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=2818463\";s:2:\"1x\";s:60:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=2818463\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/akismet/assets/banner-1544x500.png?rev=2900731\";s:2:\"1x\";s:62:\"https://ps.w.org/akismet/assets/banner-772x250.png?rev=2900731\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.8\";s:6:\"tested\";s:5:\"6.8.1\";s:12:\"requires_php\";s:3:\"7.2\";s:16:\"requires_plugins\";a:0:{}}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:4:{s:33:\"classic-editor/classic-editor.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:28:\"w.org/plugins/classic-editor\";s:4:\"slug\";s:14:\"classic-editor\";s:6:\"plugin\";s:33:\"classic-editor/classic-editor.php\";s:11:\"new_version\";s:5:\"1.6.7\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/classic-editor/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/classic-editor.1.6.7.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671\";s:2:\"1x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-128x128.png?rev=1998671\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/classic-editor/assets/banner-1544x500.png?rev=1998671\";s:2:\"1x\";s:69:\"https://ps.w.org/classic-editor/assets/banner-772x250.png?rev=1998676\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";}s:9:\"hello.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/hello-dolly/assets/banner-1544x500.jpg?rev=2645582\";s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}s:29:\"vf-expansion/vf-expansion.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:26:\"w.org/plugins/vf-expansion\";s:4:\"slug\";s:12:\"vf-expansion\";s:6:\"plugin\";s:29:\"vf-expansion/vf-expansion.php\";s:11:\"new_version\";s:5:\"1.0.5\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/vf-expansion/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/vf-expansion.1.0.5.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:65:\"https://ps.w.org/vf-expansion/assets/icon-128x128.png?rev=2774138\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:67:\"https://ps.w.org/vf-expansion/assets/banner-772x250.png?rev=2782815\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:27:\"woocommerce/woocommerce.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/woocommerce\";s:4:\"slug\";s:11:\"woocommerce\";s:6:\"plugin\";s:27:\"woocommerce/woocommerce.php\";s:11:\"new_version\";s:5:\"9.8.5\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/woocommerce/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/woocommerce.9.8.5.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:56:\"https://ps.w.org/woocommerce/assets/icon.svg?rev=3234504\";s:3:\"svg\";s:56:\"https://ps.w.org/woocommerce/assets/icon.svg?rev=3234504\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/woocommerce/assets/banner-1544x500.png?rev=3234504\";s:2:\"1x\";s:66:\"https://ps.w.org/woocommerce/assets/banner-772x250.png?rev=3234504\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.6\";}}s:7:\"checked\";a:5:{s:19:\"akismet/akismet.php\";s:5:\"5.3.3\";s:33:\"classic-editor/classic-editor.php\";s:5:\"1.6.7\";s:9:\"hello.php\";s:5:\"1.7.2\";s:29:\"vf-expansion/vf-expansion.php\";s:5:\"1.0.5\";s:27:\"woocommerce/woocommerce.php\";s:5:\"9.8.5\";}}', 'off'),
(376, '_site_transient_timeout_wp_theme_files_patterns-635737493f90accf803c148ddca2da97', '1748916234', 'off'),
(377, '_site_transient_wp_theme_files_patterns-635737493f90accf803c148ddca2da97', 'a:2:{s:7:\"version\";s:6:\"1.0.12\";s:8:\"patterns\";a:0:{}}', 'off');

-- --------------------------------------------------------

--
-- Structure de la table `wp_postmeta`
--

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(3, 9, '_edit_lock', '1748787741:1'),
(6, 9, '_edit_last', '1'),
(7, 9, '_wp_page_template', 'default'),
(12, 12, '_wp_attached_file', '2025/06/Capture.png'),
(13, 12, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:306;s:6:\"height\";i:300;s:4:\"file\";s:19:\"2025/06/Capture.png\";s:8:\"filesize\";i:213709;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(14, 13, '_menu_item_type', 'custom'),
(15, 13, '_menu_item_menu_item_parent', '0'),
(16, 13, '_menu_item_object_id', '13'),
(17, 13, '_menu_item_object', 'custom'),
(18, 13, '_menu_item_target', ''),
(19, 13, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(20, 13, '_menu_item_xfn', ''),
(21, 13, '_menu_item_url', 'http://localhost:8080/wordpress-6.6/wordpress/'),
(22, 13, '_menu_item_orphaned', '1748865223'),
(23, 14, '_menu_item_type', 'post_type'),
(24, 14, '_menu_item_menu_item_parent', '0'),
(25, 14, '_menu_item_object_id', '2'),
(26, 14, '_menu_item_object', 'page'),
(27, 14, '_menu_item_target', ''),
(28, 14, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(29, 14, '_menu_item_xfn', ''),
(30, 14, '_menu_item_url', ''),
(31, 14, '_menu_item_orphaned', '1748865223'),
(32, 15, '_wp_attached_file', '2025/06/logo_2.png'),
(33, 15, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:160;s:6:\"height\";i:50;s:4:\"file\";s:18:\"2025/06/logo_2.png\";s:8:\"filesize\";i:2700;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(34, 16, '_wp_attached_file', '2025/06/post01.jpg'),
(35, 16, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1700;s:6:\"height\";i:1080;s:4:\"file\";s:18:\"2025/06/post01.jpg\";s:8:\"filesize\";i:302321;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(36, 17, '_wp_attached_file', '2025/06/post02.jpg'),
(37, 17, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1700;s:6:\"height\";i:1080;s:4:\"file\";s:18:\"2025/06/post02.jpg\";s:8:\"filesize\";i:189214;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(38, 18, '_wp_attached_file', '2025/06/post03.jpg'),
(39, 18, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1700;s:6:\"height\";i:1080;s:4:\"file\";s:18:\"2025/06/post03.jpg\";s:8:\"filesize\";i:326755;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(40, 19, '_wp_attached_file', '2025/06/product01.png'),
(41, 19, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:21:\"2025/06/product01.png\";s:8:\"filesize\";i:52095;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(42, 20, '_wp_attached_file', '2025/06/product02.png'),
(43, 20, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:21:\"2025/06/product02.png\";s:8:\"filesize\";i:47061;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(44, 21, '_wp_attached_file', '2025/06/product03.png'),
(45, 21, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:21:\"2025/06/product03.png\";s:8:\"filesize\";i:73669;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(46, 22, '_wp_attached_file', '2025/06/product04.png'),
(47, 22, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:21:\"2025/06/product04.png\";s:8:\"filesize\";i:54615;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(48, 23, '_wp_page_template', 'templates/template-frontpage.php'),
(51, 24, '_thumbnail_id', '16'),
(54, 25, '_thumbnail_id', '17'),
(57, 26, '_thumbnail_id', '18'),
(58, 27, '_thumbnail_id', '19'),
(59, 28, '_thumbnail_id', '20'),
(60, 29, '_thumbnail_id', '21'),
(61, 30, '_thumbnail_id', '22');

-- --------------------------------------------------------

--
-- Structure de la table `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(255) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2025-04-25 18:17:36', '2025-04-25 16:17:36', '<!-- wp:paragraph -->\n<p>Bienvenue sur WordPress. Ceci est votre premier article. Modifiez-le ou supprimez-le, puis commencez à écrire !</p>\n<!-- /wp:paragraph -->', 'Bonjour tout le monde !', '', 'publish', 'open', 'open', '', 'bonjour-tout-le-monde', '', '', '2025-04-25 18:17:36', '2025-04-25 16:17:36', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=1', 0, 'post', '', 1),
(2, 1, '2025-04-25 18:17:36', '2025-04-25 16:17:36', '<!-- wp:paragraph -->\n<p>Ceci est une page d’exemple. C’est différent d’un article de blog parce qu’elle restera au même endroit et apparaîtra dans la navigation de votre site (dans la plupart des thèmes). La plupart des gens commencent par une page « À propos » qui les présente aux personnes visitant le site. Cela pourrait ressembler à quelque chose comme cela :</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Bonjour ! Je suis un mécanicien qui aspire à devenir acteur, et voici mon site. J’habite à Bordeaux, j’ai un super chien baptisé Russell, et j’aime la vodka (ainsi qu’être surpris par la pluie soudaine lors de longues balades sur la plage au coucher du soleil).</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>…ou quelque chose comme cela :</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>La société 123 Machin Truc a été créée en 1971, et n’a cessé de proposer au public des machins-trucs de qualité depuis lors. Située à Saint-Remy-en-Bouzemont-Saint-Genest-et-Isson, 123 Machin Truc emploie 2 000 personnes, et fabrique toutes sortes de bidules supers pour la communauté bouzemontoise.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>En tant que nouvel utilisateur ou utilisatrice de WordPress, vous devriez vous rendre sur <a href=\"http://localhost:8080/wordpress-6.6/wordpress/wp-admin/\">votre tableau de bord</a> pour supprimer cette page et créer de nouvelles pages pour votre contenu. Amusez-vous bien !</p>\n<!-- /wp:paragraph -->', 'Page d’exemple', '', 'publish', 'closed', 'open', '', 'page-d-exemple', '', '', '2025-04-25 18:17:36', '2025-04-25 16:17:36', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?page_id=2', 0, 'page', '', 0),
(3, 1, '2025-04-25 18:17:36', '2025-04-25 16:17:36', '<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Qui sommes-nous ?</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>L’adresse de notre site est : http://localhost:8080/wordpress-6.6/wordpress.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Commentaires</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>Quand vous laissez un commentaire sur notre site, les données inscrites dans le formulaire de commentaire, ainsi que votre adresse IP et l’agent utilisateur de votre navigateur sont collectés pour nous aider à la détection des commentaires indésirables.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Une chaîne anonymisée créée à partir de votre adresse e-mail (également appelée hash) peut être envoyée au service Gravatar pour vérifier si vous utilisez ce dernier. Les clauses de confidentialité du service Gravatar sont disponibles ici : https://automattic.com/privacy/. Après validation de votre commentaire, votre photo de profil sera visible publiquement à coté de votre commentaire.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Médias</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>Si vous téléversez des images sur le site, nous vous conseillons d’éviter de téléverser des images contenant des données EXIF de coordonnées GPS. Les personnes visitant votre site peuvent télécharger et extraire des données de localisation depuis ces images.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Cookies</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>Si vous déposez un commentaire sur notre site, il vous sera proposé d’enregistrer votre nom, adresse e-mail et site dans des cookies. C’est uniquement pour votre confort afin de ne pas avoir à saisir ces informations si vous déposez un autre commentaire plus tard. Ces cookies expirent au bout d’un an.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Si vous vous rendez sur la page de connexion, un cookie temporaire sera créé afin de déterminer si votre navigateur accepte les cookies. Il ne contient pas de données personnelles et sera supprimé automatiquement à la fermeture de votre navigateur.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Lorsque vous vous connecterez, nous mettrons en place un certain nombre de cookies pour enregistrer vos informations de connexion et vos préférences d’écran. La durée de vie d’un cookie de connexion est de deux jours, celle d’un cookie d’option d’écran est d’un an. Si vous cochez « Se souvenir de moi », votre cookie de connexion sera conservé pendant deux semaines. Si vous vous déconnectez de votre compte, le cookie de connexion sera effacé.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>En modifiant ou en publiant une publication, un cookie supplémentaire sera enregistré dans votre navigateur. Ce cookie ne comprend aucune donnée personnelle. Il indique simplement l’ID de la publication que vous venez de modifier. Il expire au bout d’un jour.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Contenu embarqué depuis d’autres sites</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>Les articles de ce site peuvent inclure des contenus intégrés (par exemple des vidéos, images, articles…). Le contenu intégré depuis d’autres sites se comporte de la même manière que si le visiteur se rendait sur cet autre site.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Ces sites web pourraient collecter des données sur vous, utiliser des cookies, embarquer des outils de suivis tiers, suivre vos interactions avec ces contenus embarqués si vous disposez d’un compte connecté sur leur site web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Utilisation et transmission de vos données personnelles</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>Si vous demandez une réinitialisation de votre mot de passe, votre adresse IP sera incluse dans l’e-mail de réinitialisation.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Durées de stockage de vos données</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>Si vous laissez un commentaire, le commentaire et ses métadonnées sont conservés indéfiniment. Cela permet de reconnaître et approuver automatiquement les commentaires suivants au lieu de les laisser dans la file de modération.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Pour les comptes qui s’inscrivent sur notre site (le cas échéant), nous stockons également les données personnelles indiquées dans leur profil. Tous les comptes peuvent voir, modifier ou supprimer leurs informations personnelles à tout moment (à l’exception de leur identifiant). Les gestionnaires du site peuvent aussi voir et modifier ces informations.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Les droits que vous avez sur vos données</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>Si vous avez un compte ou si vous avez laissé des commentaires sur le site, vous pouvez demander à recevoir un fichier contenant toutes les données personnelles que nous possédons à votre sujet, incluant celles que vous nous avez fournies. Vous pouvez également demander la suppression des données personnelles vous concernant. Cela ne prend pas en compte les données stockées à des fins administratives, légales ou pour des raisons de sécurité.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Où vos données sont envoyées</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texte suggéré : </strong>Les commentaires des visiteurs peuvent être vérifiés à l’aide d’un service automatisé de détection des commentaires indésirables.</p>\n<!-- /wp:paragraph -->\n', 'Politique de confidentialité', '', 'draft', 'closed', 'open', '', 'politique-de-confidentialite', '', '', '2025-04-25 18:17:36', '2025-04-25 16:17:36', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?page_id=3', 0, 'page', '', 0),
(4, 0, '2025-04-25 18:17:38', '2025-04-25 16:17:38', '<!-- wp:page-list /-->', 'Navigation', '', 'publish', 'closed', 'closed', '', 'navigation', '', '', '2025-04-25 18:17:38', '2025-04-25 16:17:38', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/2025/04/25/navigation/', 0, 'wp_navigation', '', 0),
(6, 1, '2025-04-25 18:22:44', '2025-04-25 16:22:44', '{\"version\": 3, \"isGlobalStylesUserThemeJSON\": true }', 'Custom Styles', '', 'publish', 'closed', 'closed', '', 'wp-global-styles-twentytwentyfour', '', '', '2025-04-25 18:22:44', '2025-04-25 16:22:44', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/2025/04/25/wp-global-styles-twentytwentyfour/', 0, 'wp_global_styles', '', 0),
(8, 1, '2025-06-01 02:13:58', '0000-00-00 00:00:00', '', 'Brouillon auto', '', 'auto-draft', 'open', 'open', '', '', '', '', '2025-06-01 02:13:58', '0000-00-00 00:00:00', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=8', 0, 'post', '', 0),
(9, 1, '2025-06-01 02:34:03', '2025-06-01 00:34:03', '<!-- wp:paragraph -->\r\n<p>🌸Parce que chaque femme mérite de se sentir belle chez elle.<br />📦 Livraison partout au Maroc<br />💳 Paiement à la livraison<br />📲 WhatsApp : 0643127446</p>\r\n<!-- /wp:paragraph -->', 'POURQUOI ShopiTa Store', '', 'publish', 'open', 'open', '', 'pourquoi-shopita-store', '', '', '2025-06-01 16:24:28', '2025-06-01 14:24:28', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=9', 0, 'post', '', 0),
(10, 1, '2025-06-01 02:34:03', '2025-06-01 00:34:03', '<!-- wp:paragraph -->\n<p>🌸Parce que chaque femme mérite de se sentir belle chez elle.<br>📦 Livraison partout au Maroc<br>💳 Paiement à la livraison<br>📲 WhatsApp : 0643127446</p>\n<!-- /wp:paragraph -->', 'POURQUOI ShopiTa Store', '', 'inherit', 'closed', 'closed', '', '9-revision-v1', '', '', '2025-06-01 02:34:03', '2025-06-01 00:34:03', '', 9, 'http://localhost:8080/wordpress-6.6/wordpress/?p=10', 0, 'revision', '', 0),
(11, 1, '2025-06-01 16:22:46', '2025-06-01 14:22:46', '<!-- wp:paragraph -->\r\n<p>🌸Parce que chaque femme mérite de se sentir belle chez elle.<br />📦 Livraison partout au Maroc<br />💳 Paiement à la livraison<br />📲 WhatsApp : 0643127446</p>\r\n<!-- /wp:paragraph -->', 'POURQUOI ShopiTa Store', '', 'inherit', 'closed', 'closed', '', '9-revision-v1', '', '', '2025-06-01 16:22:46', '2025-06-01 14:22:46', '', 9, 'http://localhost:8080/wordpress-6.6/wordpress/?p=11', 0, 'revision', '', 0),
(12, 1, '2025-06-01 16:27:11', '2025-06-01 14:27:11', '', 'Capture', '', 'inherit', 'open', 'closed', '', 'capture', '', '', '2025-06-01 16:27:11', '2025-06-01 14:27:11', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/wp-content/uploads/2025/06/Capture.png', 0, 'attachment', 'image/png', 0),
(13, 1, '2025-06-02 13:53:43', '0000-00-00 00:00:00', '', 'Accueil', '', 'draft', 'closed', 'closed', '', '', '', '', '2025-06-02 13:53:43', '0000-00-00 00:00:00', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=13', 1, 'nav_menu_item', '', 0),
(14, 1, '2025-06-02 13:53:43', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'closed', 'closed', '', '', '', '', '2025-06-02 13:53:43', '0000-00-00 00:00:00', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=14', 1, 'nav_menu_item', '', 0),
(15, 1, '2025-06-02 13:58:03', '2025-06-02 11:58:03', '', 'logo_2', 'StorePress caption', 'inherit', 'open', 'closed', '', 'logo_2', '', '', '2025-06-02 13:58:03', '2025-06-02 11:58:03', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/logo_2/', 0, 'attachment', 'image/png', 0),
(16, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 'post01', 'StorePress caption', 'inherit', 'open', 'closed', '', 'post01', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/post01/', 0, 'attachment', 'image/jpeg', 0),
(17, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 'post02', 'StorePress caption', 'inherit', 'open', 'closed', '', 'post02', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/post02/', 0, 'attachment', 'image/jpeg', 0),
(18, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 'post03', 'StorePress caption', 'inherit', 'open', 'closed', '', 'post03', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/post03/', 0, 'attachment', 'image/jpeg', 0),
(19, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 'product01', 'StorePress caption', 'inherit', 'open', 'closed', '', 'product01', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/product01/', 0, 'attachment', 'image/png', 0),
(20, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 'product02', 'StorePress caption', 'inherit', 'open', 'closed', '', 'product02', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/product02/', 0, 'attachment', 'image/png', 0),
(21, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 'product03', 'StorePress caption', 'inherit', 'open', 'closed', '', 'product03', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/product03/', 0, 'attachment', 'image/png', 0),
(22, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 'product04', 'StorePress caption', 'inherit', 'open', 'closed', '', 'product04', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/product04/', 0, 'attachment', 'image/png', 0),
(23, 1, '2025-06-02 11:58:04', '2025-06-02 09:58:04', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2025-06-02 11:58:04', '2025-06-02 09:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/home/', 0, 'page', '', 0),
(24, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', 'Everyday Same Happy Days', '', 'publish', 'open', 'open', '', 'everyday-same-happy-days', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/2025/06/02/everyday-same-happy-days/', 0, 'post', '', 0),
(25, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', 'Everyday Same Happy Days', '', 'publish', 'open', 'open', '', 'everyday-same-happy-days-2', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/2025/06/02/everyday-same-happy-days-2/', 0, 'post', '', 0),
(26, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', 'Everyday Same Happy Days', '', 'publish', 'open', 'open', '', 'everyday-same-happy-days-3', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/2025/06/02/everyday-same-happy-days-3/', 0, 'post', '', 0),
(27, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', 'Product 01', '', 'publish', 'closed', 'closed', '', 'product-01', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=27', 0, 'product', '', 0),
(28, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', 'Product 02', '', 'publish', 'closed', 'closed', '', 'product-02', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=28', 0, 'product', '', 0),
(29, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', 'Product 03', '', 'publish', 'closed', 'closed', '', 'product-03', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=29', 0, 'product', '', 0),
(30, 1, '2025-06-02 13:58:04', '2025-06-02 11:58:04', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', 'Product 04', '', 'publish', 'closed', 'closed', '', 'product-04', '', '', '2025-06-02 13:58:04', '2025-06-02 11:58:04', '', 0, 'http://localhost:8080/wordpress-6.6/wordpress/?p=30', 0, 'product', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wp_termmeta`
--

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wp_terms`
--

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Non classé', 'non-classe', 0),
(2, 'twentytwentyfour', 'twentytwentyfour', 0),
(3, 'ALISON', 'alison', 0),
(4, 'ALISON_SOUS_CATEGORIE', 'alison_sous_categorie', 0),
(5, 'ALISON', 'alison', 0),
(6, 'ALISON tutorial', 'alison-tutorial', 0),
(7, 'Fashion', 'fashion', 0),
(8, 'Designer', 'designer', 0),
(9, 'Lifestyle', 'lifestyle', 0),
(10, 'Lifestyle', 'lifestyle', 0),
(11, 'Fashion', 'fashion', 0),
(12, 'Designer', 'designer', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wp_term_relationships`
--

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(6, 2, 0),
(9, 3, 0),
(9, 5, 0),
(9, 6, 0),
(24, 1, 0),
(24, 10, 0),
(25, 1, 0),
(25, 11, 0),
(26, 1, 0),
(26, 12, 0);

-- --------------------------------------------------------

--
-- Structure de la table `wp_term_taxonomy`
--

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 4),
(2, 2, 'wp_theme', '', 0, 1),
(3, 3, 'category', '', 0, 1),
(4, 4, 'category', '', 3, 0),
(5, 5, 'post_tag', '', 0, 1),
(6, 6, 'post_tag', '', 0, 1),
(7, 7, 'category', 'example category', 0, 0),
(8, 8, 'category', 'example category', 0, 0),
(9, 9, 'category', 'example category', 0, 0),
(10, 10, 'post_tag', '', 0, 1),
(11, 11, 'post_tag', '', 0, 1),
(12, 12, 'post_tag', '', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `wp_usermeta`
--

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'root'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'wp_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', ''),
(15, 1, 'show_welcome_panel', '1'),
(16, 1, 'session_tokens', 'a:1:{s:64:\"8d0d515b40a5e7d2f7b9c7c3ef443c9a968b30f55e5a7c6bc21d2c194443d239\";a:4:{s:10:\"expiration\";i:1748909634;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36\";s:5:\"login\";i:1748736834;}}'),
(17, 1, 'wp_dashboard_quick_press_last_post_id', '8'),
(18, 1, 'wp_persisted_preferences', 'a:3:{s:4:\"core\";a:1:{s:26:\"isComplementaryAreaVisible\";b:1;}s:9:\"_modified\";s:24:\"2025-06-01T00:26:27.243Z\";s:14:\"core/edit-post\";a:1:{s:12:\"welcomeGuide\";b:0;}}'),
(19, 1, 'wp_user-settings', 'editor=tinymce'),
(20, 1, 'wp_user-settings-time', '1748787502'),
(21, 1, 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}'),
(22, 1, 'metaboxhidden_nav-menus', 'a:1:{i:0;s:12:\"add-post_tag\";}');

-- --------------------------------------------------------

--
-- Structure de la table `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(255) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'root', '$wp$2y$10$VIhh2Wv6Gekl5pjpe0If8Ow9tUPaJiRvTYDI1STiiIjSLzPQDn8qu', 'root', 'essbaisalma0@gmail.com', 'http://localhost:8080/wordpress-6.6/wordpress', '2025-04-25 16:17:35', '', 0, 'root');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Index pour la table `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Index pour la table `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Index pour la table `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Index pour la table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Index pour la table `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Index pour la table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Index pour la table `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Index pour la table `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Index pour la table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Index pour la table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Index pour la table `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wp_options`
--
ALTER TABLE `wp_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT pour la table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Base de données : `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Structure de la table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Structure de la table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Structure de la table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Structure de la table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

--
-- Déchargement des données de la table `pma__export_templates`
--

INSERT INTO `pma__export_templates` (`id`, `username`, `export_type`, `template_name`, `template_data`) VALUES
(1, 'root', 'database', 'template1_test', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"structure_or_data_forced\":\"0\",\"table_select[]\":[\"ascenseurs_escaliers\",\"balisage_lumineux\",\"categorie_of_table\",\"eclairage_publique_bt\",\"equipements_climatisation\",\"equipements_surete1\",\"global_du_mois\",\"groupes_electrogènes_classiques_temps_zéro\",\"onduleurs\",\"passerelles\",\"portes_automatiques\",\"postes_hta_bt\",\"slia\",\"stb\",\"systheme_sonorisation\",\"système_détection_incendie\"],\"table_structure[]\":[\"ascenseurs_escaliers\",\"balisage_lumineux\",\"categorie_of_table\",\"eclairage_publique_bt\",\"equipements_climatisation\",\"equipements_surete1\",\"global_du_mois\",\"groupes_electrogènes_classiques_temps_zéro\",\"onduleurs\",\"passerelles\",\"portes_automatiques\",\"postes_hta_bt\",\"slia\",\"stb\",\"systheme_sonorisation\",\"système_détection_incendie\"],\"table_data[]\":[\"ascenseurs_escaliers\",\"balisage_lumineux\",\"categorie_of_table\",\"eclairage_publique_bt\",\"equipements_climatisation\",\"equipements_surete1\",\"global_du_mois\",\"groupes_electrogènes_classiques_temps_zéro\",\"onduleurs\",\"passerelles\",\"portes_automatiques\",\"postes_hta_bt\",\"slia\",\"stb\",\"systheme_sonorisation\",\"système_détection_incendie\"],\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"@DATABASE@\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"structure_and_data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"structure_and_data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_procedure_function\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"xml_structure_or_data\":\"data\",\"xml_export_events\":\"something\",\"xml_export_functions\":\"something\",\"xml_export_procedures\":\"something\",\"xml_export_tables\":\"something\",\"xml_export_triggers\":\"something\",\"xml_export_views\":\"something\",\"xml_export_contents\":\"something\",\"yaml_structure_or_data\":\"data\",\"\":null,\"lock_tables\":null,\"as_separate_files\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_create_database\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}');

-- --------------------------------------------------------

--
-- Structure de la table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Structure de la table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Structure de la table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Déchargement des données de la table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"aeroport_test2\",\"table\":\"ascenseurs_escaliers\"},{\"db\":\"aeroport_test2\",\"table\":\"global_du_mois\"},{\"db\":\"aeroport_test2\",\"table\":\"postes_hta_bt\"},{\"db\":\"aeroport_test2\",\"table\":\"groupes_electrog\\u00e8nes_classiques_temps_z\\u00e9ro\"},{\"db\":\"aeroport_test2\",\"table\":\"categorie_of_table\"},{\"db\":\"aeroport_test2\",\"table\":\"eclairage_publique_bt\"},{\"db\":\"aeroport_test2\",\"table\":\"slia\"},{\"db\":\"aeroport_test2\",\"table\":\"stb\"},{\"db\":\"aeroport_test2\",\"table\":\"passerelles\"},{\"db\":\"aeroport_test2\",\"table\":\"portes_automatiques\"}]');

-- --------------------------------------------------------

--
-- Structure de la table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Structure de la table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Déchargement des données de la table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'aeroport_test2', 'eclairage_publique_bt', '{\"sorted_col\":\"`eclairage_publique_bt`.`id_service` ASC\"}', '2024-07-26 10:52:50'),
('root', 'aeroport_test2', 'equipements_climatisation', '{\"sorted_col\":\"`equipements_climatisation`.`disponibilite_par_famille_coef` ASC\"}', '2024-07-25 21:10:36'),
('root', 'aeroport_test2', 'postes_hta_bt', '{\"CREATE_TIME\":\"2024-07-24 16:48:41\"}', '2024-07-31 22:17:10');

-- --------------------------------------------------------

--
-- Structure de la table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Déchargement des données de la table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-08-02 22:42:37', '{\"Console\\/Mode\":\"collapse\",\"NavigationWidth\":280}');

-- --------------------------------------------------------

--
-- Structure de la table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Structure de la table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Index pour la table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Index pour la table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Index pour la table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Index pour la table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Index pour la table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Index pour la table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Index pour la table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Index pour la table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Index pour la table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Index pour la table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Index pour la table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Index pour la table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Index pour la table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Base de données : `shopita`
--
CREATE DATABASE IF NOT EXISTS `shopita` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `shopita`;
--
-- Base de données : `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
