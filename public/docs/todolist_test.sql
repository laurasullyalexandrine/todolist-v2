-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 07 avr. 2024 à 13:02
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `todolist_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240202124730', '2024-04-07 13:01:33', 57),
('DoctrineMigrations\\Version20240202131343', '2024-04-07 13:01:33', 42),
('DoctrineMigrations\\Version20240202131615', '2024-04-07 13:01:33', 13),
('DoctrineMigrations\\Version20240223091804', '2024-04-07 13:01:33', 22),
('DoctrineMigrations\\Version20240223093253', '2024-04-07 13:01:33', 88);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `content` varchar(255) NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `title`, `content`, `is_done`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Tâche administration n° 1', 'Contenu de la tâche d\'administration n° 1', 0, '2024-03-07 13:01:43', NULL, 1),
(2, 'Tâche administration n° 2', 'Contenu de la tâche d\'administration n° 2', 0, '2024-04-07 13:01:43', NULL, 1),
(3, 'Tâche administration n° 3', 'Contenu de la tâche d\'administration n° 3', 0, '2024-04-07 13:01:43', NULL, 1),
(4, 'Tâche administration n° 4', 'Contenu de la tâche d\'administration n° 4', 0, '2024-04-07 13:01:43', NULL, 1),
(5, 'Tâche administration n° 5', 'Contenu de la tâche d\'administration n° 5', 0, '2024-04-07 13:01:43', NULL, 1),
(6, 'Tâche administration terminée n° 1', 'Contenu de la tâche d\'administration terminée n° 1', 1, '2024-04-07 13:01:43', NULL, 1),
(7, 'Tâche administration terminée n° 2', 'Contenu de la tâche d\'administration terminée n° 2', 1, '2024-04-07 13:01:43', NULL, 1),
(8, 'Tâche administration terminée n° 3', 'Contenu de la tâche d\'administration terminée n° 3', 1, '2024-04-07 13:01:43', NULL, 1),
(9, 'Tâche administration terminée n° 4', 'Contenu de la tâche d\'administration terminée n° 4', 1, '2024-04-07 13:01:43', NULL, 1),
(10, 'Tâche anonyme n° 1', 'Contenu de la tâche anonyme n° 1', 0, '2024-03-07 13:01:43', NULL, 2),
(11, 'Tâche anonyme n° 2', 'Contenu de la tâche anonyme n° 2', 0, '2024-04-07 13:01:43', NULL, 2),
(12, 'Tâche anonyme n° 3', 'Contenu de la tâche anonyme n° 3', 0, '2024-04-07 13:01:43', NULL, 2),
(13, 'Tâche anonyme n° 4', 'Contenu de la tâche anonyme n° 4', 0, '2024-04-07 13:01:43', NULL, 2),
(14, 'Tâche anonyme n° 5', 'Contenu de la tâche anonyme n° 5', 0, '2024-04-07 13:01:43', NULL, 2),
(15, 'Tâche anonyme n° 6', 'Contenu de la tâche anonyme n° 6', 0, '2024-04-07 13:01:43', NULL, 2),
(16, 'Tâche anonyme n° 7', 'Contenu de la tâche anonyme n° 7', 0, '2024-04-07 13:01:43', NULL, 2),
(17, 'Tâche anonyme n° 8', 'Contenu de la tâche anonyme n° 8', 0, '2024-04-07 13:01:43', NULL, 2),
(18, 'Tâche anonyme terminée n° 1', 'Contenu de la tâche anonyme terminée n° 1', 1, '2024-04-07 13:01:43', NULL, 2),
(19, 'Tâche anonyme terminée n° 2', 'Contenu de la tâche anonyme terminée n° 2', 1, '2024-04-07 13:01:43', NULL, 2),
(20, 'Tâche anonyme terminée n° 3', 'Contenu de la tâche anonyme terminée n° 3', 1, '2024-04-07 13:01:43', NULL, 2),
(21, 'Tâche anonyme terminée n° 4', 'Contenu de la tâche anonyme terminée n° 4', 1, '2024-04-07 13:01:43', NULL, 2),
(22, 'Tâche anonyme terminée n° 5', 'Contenu de la tâche anonyme terminée n° 5', 1, '2024-04-07 13:01:43', NULL, 2),
(23, 'Tâche anonyme terminée n° 6', 'Contenu de la tâche anonyme terminée n° 6', 1, '2024-04-07 13:01:43', NULL, 2),
(24, 'Tâche à faire n° 1', 'Contenu de la tâche à faire n° 1', 0, '2024-03-07 13:01:43', NULL, 3),
(25, 'Tâche à faire n° 2', 'Contenu de la tâche à faire n° 2', 0, '2024-03-07 13:01:43', NULL, 3),
(26, 'Tâche à faire n° 1', 'Contenu de la tâche à faire n° 1', 0, '2024-04-07 13:01:43', NULL, 4),
(27, 'Tâche à faire n° 2', 'Contenu de la tâche à faire n° 2', 0, '2024-04-07 13:01:43', NULL, 4),
(28, 'Tâche à faire n° 3', 'Contenu de la tâche à faire n° 3', 0, '2024-04-07 13:01:43', NULL, 4),
(29, 'Tâche à faire n° 4', 'Contenu de la tâche à faire n° 4', 0, '2024-04-07 13:01:43', NULL, 4),
(30, 'Tâche à faire n° 5', 'Contenu de la tâche à faire n° 5', 0, '2024-04-07 13:01:43', NULL, 4),
(31, 'Tâche à faire n° 6', 'Contenu de la tâche à faire n° 6', 0, '2024-04-07 13:01:43', NULL, 4),
(32, 'Tâche à faire n° 7', 'Contenu de la tâche à faire n° 7', 0, '2024-04-07 13:01:43', NULL, 4),
(33, 'Tâche à faire n° 8', 'Contenu de la tâche à faire n° 8', 0, '2024-04-07 13:01:43', NULL, 4),
(34, 'Tâche terminée n° 1', 'Contenu de la tâche terminée n° 1', 1, '2024-04-07 13:01:43', NULL, 4),
(35, 'Tâche terminée n° 2', 'Contenu de la tâche terminée n° 2', 1, '2024-04-07 13:01:43', NULL, 4),
(36, 'Tâche terminée n° 3', 'Contenu de la tâche terminée n° 3', 1, '2024-04-07 13:01:43', NULL, 4),
(37, 'Tâche terminée n° 4', 'Contenu de la tâche terminée n° 4', 1, '2024-04-07 13:01:43', NULL, 4),
(38, 'Tâche terminée n° 5', 'Contenu de la tâche terminée n° 5', 1, '2024-04-07 13:01:43', NULL, 4),
(39, 'Tâche terminée n° 6', 'Contenu de la tâche terminée n° 6', 1, '2024-04-07 13:01:43', NULL, 4),
(40, 'Tâche n° 1 de franck28', 'Contenu de la tâche n° 1 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(41, 'Tâche n° 2 de franck28', 'Contenu de la tâche n° 2 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(42, 'Tâche n° 3 de franck28', 'Contenu de la tâche n° 3 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(43, 'Tâche n° 4 de franck28', 'Contenu de la tâche n° 4 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(44, 'Tâche n° 5 de franck28', 'Contenu de la tâche n° 5 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(45, 'Tâche n° 6 de franck28', 'Contenu de la tâche n° 6 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(46, 'Tâche n° 7 de franck28', 'Contenu de la tâche n° 7 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(47, 'Tâche n° 8 de franck28', 'Contenu de la tâche n° 8 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(48, 'Tâche n° 9 de franck28', 'Contenu de la tâche n° 9 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(49, 'Tâche n° 10 de franck28', 'Contenu de la tâche n° 10 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(50, 'Tâche terminée n° 1 de franck28', 'Contenu de la tâche terminée n° 1 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(51, 'Tâche terminée n° 2 de franck28', 'Contenu de la tâche terminée n° 2 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(52, 'Tâche terminée n° 3 de franck28', 'Contenu de la tâche terminée n° 3 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(53, 'Tâche terminée n° 4 de franck28', 'Contenu de la tâche terminée n° 4 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(54, 'Tâche terminée n° 5 de franck28', 'Contenu de la tâche terminée n° 5 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(55, 'Tâche terminée n° 6 de franck28', 'Contenu de la tâche terminée n° 6 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(56, 'Tâche terminée n° 7 de franck28', 'Contenu de la tâche terminée n° 7 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(57, 'Tâche terminée n° 8 de franck28', 'Contenu de la tâche terminée n° 8 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(58, 'Tâche terminée n° 9 de franck28', 'Contenu de la tâche terminée n° 9 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(59, 'Tâche terminée n° 10 de franck28', 'Contenu de la tâche terminée n° 10 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(60, 'Tâche terminée n° 11 de franck28', 'Contenu de la tâche terminée n° 11 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(61, 'Tâche terminée n° 12 de franck28', 'Contenu de la tâche terminée n° 12 de franck28', 0, '2024-04-07 13:01:43', NULL, 5),
(62, 'Tâche n° 1 de cthomas', 'Contenu de la tâche n° 1 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(63, 'Tâche n° 2 de cthomas', 'Contenu de la tâche n° 2 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(64, 'Tâche n° 3 de cthomas', 'Contenu de la tâche n° 3 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(65, 'Tâche n° 4 de cthomas', 'Contenu de la tâche n° 4 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(66, 'Tâche n° 5 de cthomas', 'Contenu de la tâche n° 5 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(67, 'Tâche n° 6 de cthomas', 'Contenu de la tâche n° 6 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(68, 'Tâche n° 7 de cthomas', 'Contenu de la tâche n° 7 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(69, 'Tâche n° 8 de cthomas', 'Contenu de la tâche n° 8 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(70, 'Tâche n° 9 de cthomas', 'Contenu de la tâche n° 9 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(71, 'Tâche n° 10 de cthomas', 'Contenu de la tâche n° 10 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(72, 'Tâche terminée n° 1 de cthomas', 'Contenu de la tâche terminée n° 1 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(73, 'Tâche terminée n° 2 de cthomas', 'Contenu de la tâche terminée n° 2 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(74, 'Tâche terminée n° 3 de cthomas', 'Contenu de la tâche terminée n° 3 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(75, 'Tâche terminée n° 4 de cthomas', 'Contenu de la tâche terminée n° 4 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(76, 'Tâche terminée n° 5 de cthomas', 'Contenu de la tâche terminée n° 5 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(77, 'Tâche terminée n° 6 de cthomas', 'Contenu de la tâche terminée n° 6 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(78, 'Tâche terminée n° 7 de cthomas', 'Contenu de la tâche terminée n° 7 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(79, 'Tâche terminée n° 8 de cthomas', 'Contenu de la tâche terminée n° 8 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(80, 'Tâche terminée n° 9 de cthomas', 'Contenu de la tâche terminée n° 9 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(81, 'Tâche terminée n° 10 de cthomas', 'Contenu de la tâche terminée n° 10 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(82, 'Tâche terminée n° 11 de cthomas', 'Contenu de la tâche terminée n° 11 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(83, 'Tâche terminée n° 12 de cthomas', 'Contenu de la tâche terminée n° 12 de cthomas', 0, '2024-04-07 13:01:43', NULL, 6),
(84, 'Tâche n° 1 de apicard', 'Contenu de la tâche n° 1 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(85, 'Tâche n° 2 de apicard', 'Contenu de la tâche n° 2 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(86, 'Tâche n° 3 de apicard', 'Contenu de la tâche n° 3 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(87, 'Tâche n° 4 de apicard', 'Contenu de la tâche n° 4 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(88, 'Tâche n° 5 de apicard', 'Contenu de la tâche n° 5 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(89, 'Tâche n° 6 de apicard', 'Contenu de la tâche n° 6 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(90, 'Tâche n° 7 de apicard', 'Contenu de la tâche n° 7 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(91, 'Tâche n° 8 de apicard', 'Contenu de la tâche n° 8 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(92, 'Tâche n° 9 de apicard', 'Contenu de la tâche n° 9 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(93, 'Tâche n° 10 de apicard', 'Contenu de la tâche n° 10 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(94, 'Tâche terminée n° 1 de apicard', 'Contenu de la tâche terminée n° 1 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(95, 'Tâche terminée n° 2 de apicard', 'Contenu de la tâche terminée n° 2 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(96, 'Tâche terminée n° 3 de apicard', 'Contenu de la tâche terminée n° 3 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(97, 'Tâche terminée n° 4 de apicard', 'Contenu de la tâche terminée n° 4 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(98, 'Tâche terminée n° 5 de apicard', 'Contenu de la tâche terminée n° 5 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(99, 'Tâche terminée n° 6 de apicard', 'Contenu de la tâche terminée n° 6 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(100, 'Tâche terminée n° 7 de apicard', 'Contenu de la tâche terminée n° 7 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(101, 'Tâche terminée n° 8 de apicard', 'Contenu de la tâche terminée n° 8 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(102, 'Tâche terminée n° 9 de apicard', 'Contenu de la tâche terminée n° 9 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(103, 'Tâche terminée n° 10 de apicard', 'Contenu de la tâche terminée n° 10 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(104, 'Tâche terminée n° 11 de apicard', 'Contenu de la tâche terminée n° 11 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(105, 'Tâche terminée n° 12 de apicard', 'Contenu de la tâche terminée n° 12 de apicard', 0, '2024-04-07 13:01:43', NULL, 7),
(106, 'Tâche n° 1 de stephane.perrin', 'Contenu de la tâche n° 1 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(107, 'Tâche n° 2 de stephane.perrin', 'Contenu de la tâche n° 2 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(108, 'Tâche n° 3 de stephane.perrin', 'Contenu de la tâche n° 3 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(109, 'Tâche n° 4 de stephane.perrin', 'Contenu de la tâche n° 4 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(110, 'Tâche n° 5 de stephane.perrin', 'Contenu de la tâche n° 5 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(111, 'Tâche n° 6 de stephane.perrin', 'Contenu de la tâche n° 6 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(112, 'Tâche n° 7 de stephane.perrin', 'Contenu de la tâche n° 7 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(113, 'Tâche n° 8 de stephane.perrin', 'Contenu de la tâche n° 8 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(114, 'Tâche n° 9 de stephane.perrin', 'Contenu de la tâche n° 9 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(115, 'Tâche n° 10 de stephane.perrin', 'Contenu de la tâche n° 10 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(116, 'Tâche terminée n° 1 de stephane.perrin', 'Contenu de la tâche terminée n° 1 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(117, 'Tâche terminée n° 2 de stephane.perrin', 'Contenu de la tâche terminée n° 2 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(118, 'Tâche terminée n° 3 de stephane.perrin', 'Contenu de la tâche terminée n° 3 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(119, 'Tâche terminée n° 4 de stephane.perrin', 'Contenu de la tâche terminée n° 4 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(120, 'Tâche terminée n° 5 de stephane.perrin', 'Contenu de la tâche terminée n° 5 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(121, 'Tâche terminée n° 6 de stephane.perrin', 'Contenu de la tâche terminée n° 6 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(122, 'Tâche terminée n° 7 de stephane.perrin', 'Contenu de la tâche terminée n° 7 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(123, 'Tâche terminée n° 8 de stephane.perrin', 'Contenu de la tâche terminée n° 8 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(124, 'Tâche terminée n° 9 de stephane.perrin', 'Contenu de la tâche terminée n° 9 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(125, 'Tâche terminée n° 10 de stephane.perrin', 'Contenu de la tâche terminée n° 10 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(126, 'Tâche terminée n° 11 de stephane.perrin', 'Contenu de la tâche terminée n° 11 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(127, 'Tâche terminée n° 12 de stephane.perrin', 'Contenu de la tâche terminée n° 12 de stephane.perrin', 0, '2024-04-07 13:01:43', NULL, 8),
(128, 'Tâche n° 1 de victor.jacob', 'Contenu de la tâche n° 1 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(129, 'Tâche n° 2 de victor.jacob', 'Contenu de la tâche n° 2 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(130, 'Tâche n° 3 de victor.jacob', 'Contenu de la tâche n° 3 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(131, 'Tâche n° 4 de victor.jacob', 'Contenu de la tâche n° 4 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(132, 'Tâche n° 5 de victor.jacob', 'Contenu de la tâche n° 5 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(133, 'Tâche n° 6 de victor.jacob', 'Contenu de la tâche n° 6 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(134, 'Tâche n° 7 de victor.jacob', 'Contenu de la tâche n° 7 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(135, 'Tâche n° 8 de victor.jacob', 'Contenu de la tâche n° 8 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(136, 'Tâche n° 9 de victor.jacob', 'Contenu de la tâche n° 9 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(137, 'Tâche n° 10 de victor.jacob', 'Contenu de la tâche n° 10 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(138, 'Tâche terminée n° 1 de victor.jacob', 'Contenu de la tâche terminée n° 1 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(139, 'Tâche terminée n° 2 de victor.jacob', 'Contenu de la tâche terminée n° 2 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(140, 'Tâche terminée n° 3 de victor.jacob', 'Contenu de la tâche terminée n° 3 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(141, 'Tâche terminée n° 4 de victor.jacob', 'Contenu de la tâche terminée n° 4 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(142, 'Tâche terminée n° 5 de victor.jacob', 'Contenu de la tâche terminée n° 5 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(143, 'Tâche terminée n° 6 de victor.jacob', 'Contenu de la tâche terminée n° 6 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(144, 'Tâche terminée n° 7 de victor.jacob', 'Contenu de la tâche terminée n° 7 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(145, 'Tâche terminée n° 8 de victor.jacob', 'Contenu de la tâche terminée n° 8 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(146, 'Tâche terminée n° 9 de victor.jacob', 'Contenu de la tâche terminée n° 9 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(147, 'Tâche terminée n° 10 de victor.jacob', 'Contenu de la tâche terminée n° 10 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(148, 'Tâche terminée n° 11 de victor.jacob', 'Contenu de la tâche terminée n° 11 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(149, 'Tâche terminée n° 12 de victor.jacob', 'Contenu de la tâche terminée n° 12 de victor.jacob', 0, '2024-04-07 13:01:43', NULL, 9),
(150, 'Tâche n° 1 de gberthelot', 'Contenu de la tâche n° 1 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(151, 'Tâche n° 2 de gberthelot', 'Contenu de la tâche n° 2 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(152, 'Tâche n° 3 de gberthelot', 'Contenu de la tâche n° 3 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(153, 'Tâche n° 4 de gberthelot', 'Contenu de la tâche n° 4 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(154, 'Tâche n° 5 de gberthelot', 'Contenu de la tâche n° 5 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(155, 'Tâche n° 6 de gberthelot', 'Contenu de la tâche n° 6 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(156, 'Tâche n° 7 de gberthelot', 'Contenu de la tâche n° 7 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(157, 'Tâche n° 8 de gberthelot', 'Contenu de la tâche n° 8 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(158, 'Tâche n° 9 de gberthelot', 'Contenu de la tâche n° 9 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(159, 'Tâche n° 10 de gberthelot', 'Contenu de la tâche n° 10 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(160, 'Tâche terminée n° 1 de gberthelot', 'Contenu de la tâche terminée n° 1 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(161, 'Tâche terminée n° 2 de gberthelot', 'Contenu de la tâche terminée n° 2 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(162, 'Tâche terminée n° 3 de gberthelot', 'Contenu de la tâche terminée n° 3 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(163, 'Tâche terminée n° 4 de gberthelot', 'Contenu de la tâche terminée n° 4 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(164, 'Tâche terminée n° 5 de gberthelot', 'Contenu de la tâche terminée n° 5 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(165, 'Tâche terminée n° 6 de gberthelot', 'Contenu de la tâche terminée n° 6 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(166, 'Tâche terminée n° 7 de gberthelot', 'Contenu de la tâche terminée n° 7 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(167, 'Tâche terminée n° 8 de gberthelot', 'Contenu de la tâche terminée n° 8 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(168, 'Tâche terminée n° 9 de gberthelot', 'Contenu de la tâche terminée n° 9 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(169, 'Tâche terminée n° 10 de gberthelot', 'Contenu de la tâche terminée n° 10 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(170, 'Tâche terminée n° 11 de gberthelot', 'Contenu de la tâche terminée n° 11 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(171, 'Tâche terminée n° 12 de gberthelot', 'Contenu de la tâche terminée n° 12 de gberthelot', 0, '2024-04-07 13:01:43', NULL, 10),
(172, 'Tâche n° 1 de efernandes', 'Contenu de la tâche n° 1 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(173, 'Tâche n° 2 de efernandes', 'Contenu de la tâche n° 2 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(174, 'Tâche n° 3 de efernandes', 'Contenu de la tâche n° 3 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(175, 'Tâche n° 4 de efernandes', 'Contenu de la tâche n° 4 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(176, 'Tâche n° 5 de efernandes', 'Contenu de la tâche n° 5 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(177, 'Tâche n° 6 de efernandes', 'Contenu de la tâche n° 6 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(178, 'Tâche n° 7 de efernandes', 'Contenu de la tâche n° 7 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(179, 'Tâche n° 8 de efernandes', 'Contenu de la tâche n° 8 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(180, 'Tâche n° 9 de efernandes', 'Contenu de la tâche n° 9 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(181, 'Tâche n° 10 de efernandes', 'Contenu de la tâche n° 10 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(182, 'Tâche terminée n° 1 de efernandes', 'Contenu de la tâche terminée n° 1 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(183, 'Tâche terminée n° 2 de efernandes', 'Contenu de la tâche terminée n° 2 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(184, 'Tâche terminée n° 3 de efernandes', 'Contenu de la tâche terminée n° 3 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(185, 'Tâche terminée n° 4 de efernandes', 'Contenu de la tâche terminée n° 4 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(186, 'Tâche terminée n° 5 de efernandes', 'Contenu de la tâche terminée n° 5 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(187, 'Tâche terminée n° 6 de efernandes', 'Contenu de la tâche terminée n° 6 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(188, 'Tâche terminée n° 7 de efernandes', 'Contenu de la tâche terminée n° 7 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(189, 'Tâche terminée n° 8 de efernandes', 'Contenu de la tâche terminée n° 8 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(190, 'Tâche terminée n° 9 de efernandes', 'Contenu de la tâche terminée n° 9 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(191, 'Tâche terminée n° 10 de efernandes', 'Contenu de la tâche terminée n° 10 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(192, 'Tâche terminée n° 11 de efernandes', 'Contenu de la tâche terminée n° 11 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(193, 'Tâche terminée n° 12 de efernandes', 'Contenu de la tâche terminée n° 12 de efernandes', 0, '2024-04-07 13:01:43', NULL, 11),
(194, 'Tâche n° 1 de isabelle72', 'Contenu de la tâche n° 1 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(195, 'Tâche n° 2 de isabelle72', 'Contenu de la tâche n° 2 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(196, 'Tâche n° 3 de isabelle72', 'Contenu de la tâche n° 3 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(197, 'Tâche n° 4 de isabelle72', 'Contenu de la tâche n° 4 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(198, 'Tâche n° 5 de isabelle72', 'Contenu de la tâche n° 5 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(199, 'Tâche n° 6 de isabelle72', 'Contenu de la tâche n° 6 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(200, 'Tâche n° 7 de isabelle72', 'Contenu de la tâche n° 7 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(201, 'Tâche n° 8 de isabelle72', 'Contenu de la tâche n° 8 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(202, 'Tâche n° 9 de isabelle72', 'Contenu de la tâche n° 9 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(203, 'Tâche n° 10 de isabelle72', 'Contenu de la tâche n° 10 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(204, 'Tâche terminée n° 1 de isabelle72', 'Contenu de la tâche terminée n° 1 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(205, 'Tâche terminée n° 2 de isabelle72', 'Contenu de la tâche terminée n° 2 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(206, 'Tâche terminée n° 3 de isabelle72', 'Contenu de la tâche terminée n° 3 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(207, 'Tâche terminée n° 4 de isabelle72', 'Contenu de la tâche terminée n° 4 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(208, 'Tâche terminée n° 5 de isabelle72', 'Contenu de la tâche terminée n° 5 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(209, 'Tâche terminée n° 6 de isabelle72', 'Contenu de la tâche terminée n° 6 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(210, 'Tâche terminée n° 7 de isabelle72', 'Contenu de la tâche terminée n° 7 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(211, 'Tâche terminée n° 8 de isabelle72', 'Contenu de la tâche terminée n° 8 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(212, 'Tâche terminée n° 9 de isabelle72', 'Contenu de la tâche terminée n° 9 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(213, 'Tâche terminée n° 10 de isabelle72', 'Contenu de la tâche terminée n° 10 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(214, 'Tâche terminée n° 11 de isabelle72', 'Contenu de la tâche terminée n° 11 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(215, 'Tâche terminée n° 12 de isabelle72', 'Contenu de la tâche terminée n° 12 de isabelle72', 0, '2024-04-07 13:01:43', NULL, 12),
(216, 'Tâche n° 1 de antoinette13', 'Contenu de la tâche n° 1 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(217, 'Tâche n° 2 de antoinette13', 'Contenu de la tâche n° 2 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(218, 'Tâche n° 3 de antoinette13', 'Contenu de la tâche n° 3 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(219, 'Tâche n° 4 de antoinette13', 'Contenu de la tâche n° 4 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(220, 'Tâche n° 5 de antoinette13', 'Contenu de la tâche n° 5 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(221, 'Tâche n° 6 de antoinette13', 'Contenu de la tâche n° 6 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(222, 'Tâche n° 7 de antoinette13', 'Contenu de la tâche n° 7 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(223, 'Tâche n° 8 de antoinette13', 'Contenu de la tâche n° 8 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(224, 'Tâche n° 9 de antoinette13', 'Contenu de la tâche n° 9 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(225, 'Tâche n° 10 de antoinette13', 'Contenu de la tâche n° 10 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(226, 'Tâche terminée n° 1 de antoinette13', 'Contenu de la tâche terminée n° 1 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(227, 'Tâche terminée n° 2 de antoinette13', 'Contenu de la tâche terminée n° 2 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(228, 'Tâche terminée n° 3 de antoinette13', 'Contenu de la tâche terminée n° 3 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(229, 'Tâche terminée n° 4 de antoinette13', 'Contenu de la tâche terminée n° 4 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(230, 'Tâche terminée n° 5 de antoinette13', 'Contenu de la tâche terminée n° 5 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(231, 'Tâche terminée n° 6 de antoinette13', 'Contenu de la tâche terminée n° 6 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(232, 'Tâche terminée n° 7 de antoinette13', 'Contenu de la tâche terminée n° 7 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(233, 'Tâche terminée n° 8 de antoinette13', 'Contenu de la tâche terminée n° 8 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(234, 'Tâche terminée n° 9 de antoinette13', 'Contenu de la tâche terminée n° 9 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(235, 'Tâche terminée n° 10 de antoinette13', 'Contenu de la tâche terminée n° 10 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(236, 'Tâche terminée n° 11 de antoinette13', 'Contenu de la tâche terminée n° 11 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(237, 'Tâche terminée n° 12 de antoinette13', 'Contenu de la tâche terminée n° 12 de antoinette13', 0, '2024-04-07 13:01:43', NULL, 13),
(238, 'Tâche n° 1 de turpin.alfred', 'Contenu de la tâche n° 1 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(239, 'Tâche n° 2 de turpin.alfred', 'Contenu de la tâche n° 2 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(240, 'Tâche n° 3 de turpin.alfred', 'Contenu de la tâche n° 3 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(241, 'Tâche n° 4 de turpin.alfred', 'Contenu de la tâche n° 4 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(242, 'Tâche n° 5 de turpin.alfred', 'Contenu de la tâche n° 5 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(243, 'Tâche n° 6 de turpin.alfred', 'Contenu de la tâche n° 6 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(244, 'Tâche n° 7 de turpin.alfred', 'Contenu de la tâche n° 7 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(245, 'Tâche n° 8 de turpin.alfred', 'Contenu de la tâche n° 8 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(246, 'Tâche n° 9 de turpin.alfred', 'Contenu de la tâche n° 9 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(247, 'Tâche n° 10 de turpin.alfred', 'Contenu de la tâche n° 10 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(248, 'Tâche terminée n° 1 de turpin.alfred', 'Contenu de la tâche terminée n° 1 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(249, 'Tâche terminée n° 2 de turpin.alfred', 'Contenu de la tâche terminée n° 2 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(250, 'Tâche terminée n° 3 de turpin.alfred', 'Contenu de la tâche terminée n° 3 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(251, 'Tâche terminée n° 4 de turpin.alfred', 'Contenu de la tâche terminée n° 4 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(252, 'Tâche terminée n° 5 de turpin.alfred', 'Contenu de la tâche terminée n° 5 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(253, 'Tâche terminée n° 6 de turpin.alfred', 'Contenu de la tâche terminée n° 6 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(254, 'Tâche terminée n° 7 de turpin.alfred', 'Contenu de la tâche terminée n° 7 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(255, 'Tâche terminée n° 8 de turpin.alfred', 'Contenu de la tâche terminée n° 8 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(256, 'Tâche terminée n° 9 de turpin.alfred', 'Contenu de la tâche terminée n° 9 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(257, 'Tâche terminée n° 10 de turpin.alfred', 'Contenu de la tâche terminée n° 10 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(258, 'Tâche terminée n° 11 de turpin.alfred', 'Contenu de la tâche terminée n° 11 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(259, 'Tâche terminée n° 12 de turpin.alfred', 'Contenu de la tâche terminée n° 12 de turpin.alfred', 0, '2024-04-07 13:01:43', NULL, 14),
(260, 'Tâche n° 1 de cfischer', 'Contenu de la tâche n° 1 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(261, 'Tâche n° 2 de cfischer', 'Contenu de la tâche n° 2 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(262, 'Tâche n° 3 de cfischer', 'Contenu de la tâche n° 3 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(263, 'Tâche n° 4 de cfischer', 'Contenu de la tâche n° 4 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(264, 'Tâche n° 5 de cfischer', 'Contenu de la tâche n° 5 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(265, 'Tâche n° 6 de cfischer', 'Contenu de la tâche n° 6 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(266, 'Tâche n° 7 de cfischer', 'Contenu de la tâche n° 7 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(267, 'Tâche n° 8 de cfischer', 'Contenu de la tâche n° 8 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(268, 'Tâche n° 9 de cfischer', 'Contenu de la tâche n° 9 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(269, 'Tâche n° 10 de cfischer', 'Contenu de la tâche n° 10 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(270, 'Tâche terminée n° 1 de cfischer', 'Contenu de la tâche terminée n° 1 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(271, 'Tâche terminée n° 2 de cfischer', 'Contenu de la tâche terminée n° 2 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(272, 'Tâche terminée n° 3 de cfischer', 'Contenu de la tâche terminée n° 3 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(273, 'Tâche terminée n° 4 de cfischer', 'Contenu de la tâche terminée n° 4 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(274, 'Tâche terminée n° 5 de cfischer', 'Contenu de la tâche terminée n° 5 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(275, 'Tâche terminée n° 6 de cfischer', 'Contenu de la tâche terminée n° 6 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(276, 'Tâche terminée n° 7 de cfischer', 'Contenu de la tâche terminée n° 7 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(277, 'Tâche terminée n° 8 de cfischer', 'Contenu de la tâche terminée n° 8 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(278, 'Tâche terminée n° 9 de cfischer', 'Contenu de la tâche terminée n° 9 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(279, 'Tâche terminée n° 10 de cfischer', 'Contenu de la tâche terminée n° 10 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(280, 'Tâche terminée n° 11 de cfischer', 'Contenu de la tâche terminée n° 11 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(281, 'Tâche terminée n° 12 de cfischer', 'Contenu de la tâche terminée n° 12 de cfischer', 0, '2024-04-07 13:01:43', NULL, 15),
(282, 'Tâche n° 1 de gfoucher', 'Contenu de la tâche n° 1 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(283, 'Tâche n° 2 de gfoucher', 'Contenu de la tâche n° 2 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(284, 'Tâche n° 3 de gfoucher', 'Contenu de la tâche n° 3 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(285, 'Tâche n° 4 de gfoucher', 'Contenu de la tâche n° 4 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(286, 'Tâche n° 5 de gfoucher', 'Contenu de la tâche n° 5 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(287, 'Tâche n° 6 de gfoucher', 'Contenu de la tâche n° 6 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(288, 'Tâche n° 7 de gfoucher', 'Contenu de la tâche n° 7 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(289, 'Tâche n° 8 de gfoucher', 'Contenu de la tâche n° 8 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(290, 'Tâche n° 9 de gfoucher', 'Contenu de la tâche n° 9 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(291, 'Tâche n° 10 de gfoucher', 'Contenu de la tâche n° 10 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(292, 'Tâche terminée n° 1 de gfoucher', 'Contenu de la tâche terminée n° 1 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(293, 'Tâche terminée n° 2 de gfoucher', 'Contenu de la tâche terminée n° 2 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(294, 'Tâche terminée n° 3 de gfoucher', 'Contenu de la tâche terminée n° 3 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(295, 'Tâche terminée n° 4 de gfoucher', 'Contenu de la tâche terminée n° 4 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(296, 'Tâche terminée n° 5 de gfoucher', 'Contenu de la tâche terminée n° 5 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(297, 'Tâche terminée n° 6 de gfoucher', 'Contenu de la tâche terminée n° 6 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(298, 'Tâche terminée n° 7 de gfoucher', 'Contenu de la tâche terminée n° 7 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(299, 'Tâche terminée n° 8 de gfoucher', 'Contenu de la tâche terminée n° 8 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(300, 'Tâche terminée n° 9 de gfoucher', 'Contenu de la tâche terminée n° 9 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(301, 'Tâche terminée n° 10 de gfoucher', 'Contenu de la tâche terminée n° 10 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(302, 'Tâche terminée n° 11 de gfoucher', 'Contenu de la tâche terminée n° 11 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(303, 'Tâche terminée n° 12 de gfoucher', 'Contenu de la tâche terminée n° 12 de gfoucher', 0, '2024-04-07 13:01:43', NULL, 16),
(304, 'Tâche n° 1 de agnes.gay', 'Contenu de la tâche n° 1 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(305, 'Tâche n° 2 de agnes.gay', 'Contenu de la tâche n° 2 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(306, 'Tâche n° 3 de agnes.gay', 'Contenu de la tâche n° 3 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(307, 'Tâche n° 4 de agnes.gay', 'Contenu de la tâche n° 4 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(308, 'Tâche n° 5 de agnes.gay', 'Contenu de la tâche n° 5 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(309, 'Tâche n° 6 de agnes.gay', 'Contenu de la tâche n° 6 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(310, 'Tâche n° 7 de agnes.gay', 'Contenu de la tâche n° 7 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(311, 'Tâche n° 8 de agnes.gay', 'Contenu de la tâche n° 8 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(312, 'Tâche n° 9 de agnes.gay', 'Contenu de la tâche n° 9 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(313, 'Tâche n° 10 de agnes.gay', 'Contenu de la tâche n° 10 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(314, 'Tâche terminée n° 1 de agnes.gay', 'Contenu de la tâche terminée n° 1 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(315, 'Tâche terminée n° 2 de agnes.gay', 'Contenu de la tâche terminée n° 2 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(316, 'Tâche terminée n° 3 de agnes.gay', 'Contenu de la tâche terminée n° 3 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(317, 'Tâche terminée n° 4 de agnes.gay', 'Contenu de la tâche terminée n° 4 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(318, 'Tâche terminée n° 5 de agnes.gay', 'Contenu de la tâche terminée n° 5 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(319, 'Tâche terminée n° 6 de agnes.gay', 'Contenu de la tâche terminée n° 6 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(320, 'Tâche terminée n° 7 de agnes.gay', 'Contenu de la tâche terminée n° 7 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(321, 'Tâche terminée n° 8 de agnes.gay', 'Contenu de la tâche terminée n° 8 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(322, 'Tâche terminée n° 9 de agnes.gay', 'Contenu de la tâche terminée n° 9 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(323, 'Tâche terminée n° 10 de agnes.gay', 'Contenu de la tâche terminée n° 10 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(324, 'Tâche terminée n° 11 de agnes.gay', 'Contenu de la tâche terminée n° 11 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(325, 'Tâche terminée n° 12 de agnes.gay', 'Contenu de la tâche terminée n° 12 de agnes.gay', 0, '2024-04-07 13:01:43', NULL, 17),
(326, 'Tâche n° 1 de anastasie15', 'Contenu de la tâche n° 1 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(327, 'Tâche n° 2 de anastasie15', 'Contenu de la tâche n° 2 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(328, 'Tâche n° 3 de anastasie15', 'Contenu de la tâche n° 3 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(329, 'Tâche n° 4 de anastasie15', 'Contenu de la tâche n° 4 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(330, 'Tâche n° 5 de anastasie15', 'Contenu de la tâche n° 5 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(331, 'Tâche n° 6 de anastasie15', 'Contenu de la tâche n° 6 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(332, 'Tâche n° 7 de anastasie15', 'Contenu de la tâche n° 7 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(333, 'Tâche n° 8 de anastasie15', 'Contenu de la tâche n° 8 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(334, 'Tâche n° 9 de anastasie15', 'Contenu de la tâche n° 9 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(335, 'Tâche n° 10 de anastasie15', 'Contenu de la tâche n° 10 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(336, 'Tâche terminée n° 1 de anastasie15', 'Contenu de la tâche terminée n° 1 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(337, 'Tâche terminée n° 2 de anastasie15', 'Contenu de la tâche terminée n° 2 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(338, 'Tâche terminée n° 3 de anastasie15', 'Contenu de la tâche terminée n° 3 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(339, 'Tâche terminée n° 4 de anastasie15', 'Contenu de la tâche terminée n° 4 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(340, 'Tâche terminée n° 5 de anastasie15', 'Contenu de la tâche terminée n° 5 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(341, 'Tâche terminée n° 6 de anastasie15', 'Contenu de la tâche terminée n° 6 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(342, 'Tâche terminée n° 7 de anastasie15', 'Contenu de la tâche terminée n° 7 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(343, 'Tâche terminée n° 8 de anastasie15', 'Contenu de la tâche terminée n° 8 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(344, 'Tâche terminée n° 9 de anastasie15', 'Contenu de la tâche terminée n° 9 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(345, 'Tâche terminée n° 10 de anastasie15', 'Contenu de la tâche terminée n° 10 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(346, 'Tâche terminée n° 11 de anastasie15', 'Contenu de la tâche terminée n° 11 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(347, 'Tâche terminée n° 12 de anastasie15', 'Contenu de la tâche terminée n° 12 de anastasie15', 0, '2024-04-07 13:01:43', NULL, 18),
(348, 'Tâche n° 1 de graynaud', 'Contenu de la tâche n° 1 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(349, 'Tâche n° 2 de graynaud', 'Contenu de la tâche n° 2 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(350, 'Tâche n° 3 de graynaud', 'Contenu de la tâche n° 3 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(351, 'Tâche n° 4 de graynaud', 'Contenu de la tâche n° 4 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(352, 'Tâche n° 5 de graynaud', 'Contenu de la tâche n° 5 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(353, 'Tâche n° 6 de graynaud', 'Contenu de la tâche n° 6 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(354, 'Tâche n° 7 de graynaud', 'Contenu de la tâche n° 7 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(355, 'Tâche n° 8 de graynaud', 'Contenu de la tâche n° 8 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(356, 'Tâche n° 9 de graynaud', 'Contenu de la tâche n° 9 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(357, 'Tâche n° 10 de graynaud', 'Contenu de la tâche n° 10 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(358, 'Tâche terminée n° 1 de graynaud', 'Contenu de la tâche terminée n° 1 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(359, 'Tâche terminée n° 2 de graynaud', 'Contenu de la tâche terminée n° 2 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(360, 'Tâche terminée n° 3 de graynaud', 'Contenu de la tâche terminée n° 3 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(361, 'Tâche terminée n° 4 de graynaud', 'Contenu de la tâche terminée n° 4 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(362, 'Tâche terminée n° 5 de graynaud', 'Contenu de la tâche terminée n° 5 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(363, 'Tâche terminée n° 6 de graynaud', 'Contenu de la tâche terminée n° 6 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(364, 'Tâche terminée n° 7 de graynaud', 'Contenu de la tâche terminée n° 7 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(365, 'Tâche terminée n° 8 de graynaud', 'Contenu de la tâche terminée n° 8 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(366, 'Tâche terminée n° 9 de graynaud', 'Contenu de la tâche terminée n° 9 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(367, 'Tâche terminée n° 10 de graynaud', 'Contenu de la tâche terminée n° 10 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(368, 'Tâche terminée n° 11 de graynaud', 'Contenu de la tâche terminée n° 11 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(369, 'Tâche terminée n° 12 de graynaud', 'Contenu de la tâche terminée n° 12 de graynaud', 0, '2024-04-07 13:01:43', NULL, 19),
(370, 'Tâche n° 1 de lebrun.guillaume', 'Contenu de la tâche n° 1 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(371, 'Tâche n° 2 de lebrun.guillaume', 'Contenu de la tâche n° 2 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(372, 'Tâche n° 3 de lebrun.guillaume', 'Contenu de la tâche n° 3 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(373, 'Tâche n° 4 de lebrun.guillaume', 'Contenu de la tâche n° 4 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(374, 'Tâche n° 5 de lebrun.guillaume', 'Contenu de la tâche n° 5 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(375, 'Tâche n° 6 de lebrun.guillaume', 'Contenu de la tâche n° 6 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(376, 'Tâche n° 7 de lebrun.guillaume', 'Contenu de la tâche n° 7 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(377, 'Tâche n° 8 de lebrun.guillaume', 'Contenu de la tâche n° 8 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(378, 'Tâche n° 9 de lebrun.guillaume', 'Contenu de la tâche n° 9 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(379, 'Tâche n° 10 de lebrun.guillaume', 'Contenu de la tâche n° 10 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(380, 'Tâche terminée n° 1 de lebrun.guillaume', 'Contenu de la tâche terminée n° 1 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(381, 'Tâche terminée n° 2 de lebrun.guillaume', 'Contenu de la tâche terminée n° 2 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(382, 'Tâche terminée n° 3 de lebrun.guillaume', 'Contenu de la tâche terminée n° 3 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(383, 'Tâche terminée n° 4 de lebrun.guillaume', 'Contenu de la tâche terminée n° 4 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(384, 'Tâche terminée n° 5 de lebrun.guillaume', 'Contenu de la tâche terminée n° 5 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(385, 'Tâche terminée n° 6 de lebrun.guillaume', 'Contenu de la tâche terminée n° 6 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(386, 'Tâche terminée n° 7 de lebrun.guillaume', 'Contenu de la tâche terminée n° 7 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(387, 'Tâche terminée n° 8 de lebrun.guillaume', 'Contenu de la tâche terminée n° 8 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(388, 'Tâche terminée n° 9 de lebrun.guillaume', 'Contenu de la tâche terminée n° 9 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(389, 'Tâche terminée n° 10 de lebrun.guillaume', 'Contenu de la tâche terminée n° 10 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(390, 'Tâche terminée n° 11 de lebrun.guillaume', 'Contenu de la tâche terminée n° 11 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(391, 'Tâche terminée n° 12 de lebrun.guillaume', 'Contenu de la tâche terminée n° 12 de lebrun.guillaume', 0, '2024-04-07 13:01:43', NULL, 20),
(392, 'Tâche n° 1 de christelle29', 'Contenu de la tâche n° 1 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(393, 'Tâche n° 2 de christelle29', 'Contenu de la tâche n° 2 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(394, 'Tâche n° 3 de christelle29', 'Contenu de la tâche n° 3 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(395, 'Tâche n° 4 de christelle29', 'Contenu de la tâche n° 4 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(396, 'Tâche n° 5 de christelle29', 'Contenu de la tâche n° 5 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(397, 'Tâche n° 6 de christelle29', 'Contenu de la tâche n° 6 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(398, 'Tâche n° 7 de christelle29', 'Contenu de la tâche n° 7 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(399, 'Tâche n° 8 de christelle29', 'Contenu de la tâche n° 8 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(400, 'Tâche n° 9 de christelle29', 'Contenu de la tâche n° 9 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(401, 'Tâche n° 10 de christelle29', 'Contenu de la tâche n° 10 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(402, 'Tâche terminée n° 1 de christelle29', 'Contenu de la tâche terminée n° 1 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(403, 'Tâche terminée n° 2 de christelle29', 'Contenu de la tâche terminée n° 2 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(404, 'Tâche terminée n° 3 de christelle29', 'Contenu de la tâche terminée n° 3 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(405, 'Tâche terminée n° 4 de christelle29', 'Contenu de la tâche terminée n° 4 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(406, 'Tâche terminée n° 5 de christelle29', 'Contenu de la tâche terminée n° 5 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(407, 'Tâche terminée n° 6 de christelle29', 'Contenu de la tâche terminée n° 6 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(408, 'Tâche terminée n° 7 de christelle29', 'Contenu de la tâche terminée n° 7 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(409, 'Tâche terminée n° 8 de christelle29', 'Contenu de la tâche terminée n° 8 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(410, 'Tâche terminée n° 9 de christelle29', 'Contenu de la tâche terminée n° 9 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(411, 'Tâche terminée n° 10 de christelle29', 'Contenu de la tâche terminée n° 10 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(412, 'Tâche terminée n° 11 de christelle29', 'Contenu de la tâche terminée n° 11 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(413, 'Tâche terminée n° 12 de christelle29', 'Contenu de la tâche terminée n° 12 de christelle29', 0, '2024-04-07 13:01:43', NULL, 21),
(414, 'Tâche n° 1 de louis.victor', 'Contenu de la tâche n° 1 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(415, 'Tâche n° 2 de louis.victor', 'Contenu de la tâche n° 2 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(416, 'Tâche n° 3 de louis.victor', 'Contenu de la tâche n° 3 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22);
INSERT INTO `task` (`id`, `title`, `content`, `is_done`, `created_at`, `updated_at`, `user_id`) VALUES
(417, 'Tâche n° 4 de louis.victor', 'Contenu de la tâche n° 4 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(418, 'Tâche n° 5 de louis.victor', 'Contenu de la tâche n° 5 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(419, 'Tâche n° 6 de louis.victor', 'Contenu de la tâche n° 6 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(420, 'Tâche n° 7 de louis.victor', 'Contenu de la tâche n° 7 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(421, 'Tâche n° 8 de louis.victor', 'Contenu de la tâche n° 8 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(422, 'Tâche n° 9 de louis.victor', 'Contenu de la tâche n° 9 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(423, 'Tâche n° 10 de louis.victor', 'Contenu de la tâche n° 10 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(424, 'Tâche terminée n° 1 de louis.victor', 'Contenu de la tâche terminée n° 1 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(425, 'Tâche terminée n° 2 de louis.victor', 'Contenu de la tâche terminée n° 2 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(426, 'Tâche terminée n° 3 de louis.victor', 'Contenu de la tâche terminée n° 3 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(427, 'Tâche terminée n° 4 de louis.victor', 'Contenu de la tâche terminée n° 4 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(428, 'Tâche terminée n° 5 de louis.victor', 'Contenu de la tâche terminée n° 5 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(429, 'Tâche terminée n° 6 de louis.victor', 'Contenu de la tâche terminée n° 6 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(430, 'Tâche terminée n° 7 de louis.victor', 'Contenu de la tâche terminée n° 7 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(431, 'Tâche terminée n° 8 de louis.victor', 'Contenu de la tâche terminée n° 8 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(432, 'Tâche terminée n° 9 de louis.victor', 'Contenu de la tâche terminée n° 9 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(433, 'Tâche terminée n° 10 de louis.victor', 'Contenu de la tâche terminée n° 10 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(434, 'Tâche terminée n° 11 de louis.victor', 'Contenu de la tâche terminée n° 11 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22),
(435, 'Tâche terminée n° 12 de louis.victor', 'Contenu de la tâche terminée n° 12 de louis.victor', 0, '2024-04-07 13:01:43', NULL, 22);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `email` varchar(180) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'laura', '[\"ROLE_ADMIN\"]', '$2y$04$2AU.CXhS.7GHDA16menBbeH23m0vJDZdluBcpw8hS8aRhbgp5Lvvi', 'laura@todolist.fr', '2024-04-07 13:01:43', NULL),
(2, 'anonymous', '[\"ROLE_ANONYMOUS\"]', '$2y$04$hXcHQoqy0RbvXTtu9iYV4.0pKGa5sXdVPheLohO6MpDCjjHjzqf32', 'anonymous@todolist.fr', '2024-04-07 13:01:43', NULL),
(3, 'paul', '[\"ROLE_USER\"]', '$2y$04$U6Ni5UXOXBUmYYwoPbaQbeeP9UAZg4MuWLqIlkdRelcFV9h9aa9Yi', 'paul@todolist.fr', '2024-04-07 13:01:43', NULL),
(4, 'pauline', '[\"ROLE_USER\"]', '$2y$04$QbydNxhfZABn3id/suEn6eI.A/7niygKN7fPqoK45c9DnWvUl0zMG', 'pauline@todolist.fr', '2024-04-07 13:01:43', NULL),
(5, 'franck28', '[\"ROLE_USER\"]', '$2y$04$iS7h4A0OJaVSGLX7V.eOA.BHKvFi6XzHBwjy7s6uscRmZ8yYimJYS', 'franck28@todolist.fr', '2024-04-07 13:01:43', NULL),
(6, 'cthomas', '[\"ROLE_USER\"]', '$2y$04$Z2NXJYskHR7GJtOC8Vokru8WGy4w3wZU/oDVxdk1tpjGYTf1veebq', 'cthomas@todolist.fr', '2024-04-07 13:01:43', NULL),
(7, 'apicard', '[\"ROLE_USER\"]', '$2y$04$o6vvHUU8yPCN8NWbsZESj.bfvO70z3ufLcdyJTz9UR20.HWgLYhXG', 'apicard@todolist.fr', '2024-04-07 13:01:43', NULL),
(8, 'stephane.perrin', '[\"ROLE_USER\"]', '$2y$04$8QtA7jE6QA622nt9/bU2T.TVQzWblxT263/vr.BP/xNxpihzLQHeO', 'stephane.perrin@todolist.fr', '2024-04-07 13:01:43', NULL),
(9, 'victor.jacob', '[\"ROLE_USER\"]', '$2y$04$34h1b/sGcJ/QwGEfftbcseSReJI7xfRJhLqUR/5VQw0xxbPeAC.EK', 'victor.jacob@todolist.fr', '2024-04-07 13:01:43', NULL),
(10, 'gberthelot', '[\"ROLE_USER\"]', '$2y$04$ARceY.qclX3SdEvfrqI8c.ZkTZ.AbMBig3HxZnpZUDej9KihOk6uK', 'gberthelot@todolist.fr', '2024-04-07 13:01:43', NULL),
(11, 'efernandes', '[\"ROLE_USER\"]', '$2y$04$IQOU8uBgsl8Tk4wQpRLyJOj.9AwlHB5seVi6LUjJ4CNNVpt2QCU3i', 'efernandes@todolist.fr', '2024-04-07 13:01:43', NULL),
(12, 'isabelle72', '[\"ROLE_USER\"]', '$2y$04$taMJCU05wQV71wA8DLeUAOuAskuUepQSgFjIRoYGoiA3rYcHBI41K', 'isabelle72@todolist.fr', '2024-04-07 13:01:43', NULL),
(13, 'antoinette13', '[\"ROLE_USER\"]', '$2y$04$.2RvuoO/AtiVDbvakq2t.eT0KDDEW1T16EWrulXcPwLa2skMQAAdS', 'antoinette13@todolist.fr', '2024-04-07 13:01:43', NULL),
(14, 'turpin.alfred', '[\"ROLE_USER\"]', '$2y$04$.r0if1lXtVGfALHGYjDCO.7dDQT1.TdF7ZrdeCjbQxHuAUY6lMUGO', 'turpin.alfred@todolist.fr', '2024-04-07 13:01:43', NULL),
(15, 'cfischer', '[\"ROLE_USER\"]', '$2y$04$IFBRbeGcmgskJl2DL1eHn.auJ6teuOsNBtZu35Bf5gIg5XksF1Uwe', 'cfischer@todolist.fr', '2024-04-07 13:01:43', NULL),
(16, 'gfoucher', '[\"ROLE_USER\"]', '$2y$04$jw82jzUFCqtRsJk4i9AiH.Q9LHnQKK2oJ36eKOADKb5tzxL.lLcN2', 'gfoucher@todolist.fr', '2024-04-07 13:01:43', NULL),
(17, 'agnes.gay', '[\"ROLE_USER\"]', '$2y$04$iAD532Pw9Ca3zgIX2LdUHO.p2BPAlQMPhP5AN8RoZVFvF5By6lQUi', 'agnes.gay@todolist.fr', '2024-04-07 13:01:43', NULL),
(18, 'anastasie15', '[\"ROLE_USER\"]', '$2y$04$QCQptpnlLaagyyH5qzAwGO1KcMbh8QSYGxG5i0.j3JmoHwiG0me1S', 'anastasie15@todolist.fr', '2024-04-07 13:01:43', NULL),
(19, 'graynaud', '[\"ROLE_USER\"]', '$2y$04$P4ufN4/WFh4g/z7bVdZOieist.Hz.HMnTvWoppl/6fK86R8pMRAbm', 'graynaud@todolist.fr', '2024-04-07 13:01:43', NULL),
(20, 'lebrun.guillaume', '[\"ROLE_USER\"]', '$2y$04$uS16LEAa18fKIEMJ2LTkR.0B2Y1012EMLIvVVOZLuExdVrW0sP0oK', 'lebrun.guillaume@todolist.fr', '2024-04-07 13:01:43', NULL),
(21, 'christelle29', '[\"ROLE_USER\"]', '$2y$04$rHByNSkU8g1Zz42pVxmSxehmCii60W/LSi6HglYOZ3TJNq64xnoAO', 'christelle29@todolist.fr', '2024-04-07 13:01:43', NULL),
(22, 'louis.victor', '[\"ROLE_USER\"]', '$2y$04$n.z61nwyVID.C75m8Dx/AeI0/rNf8g0uC2oHiroROsZj5FN1e.PVu', 'louis.victor@todolist.fr', '2024-04-07 13:01:43', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_527EDB25A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=436;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB25A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
