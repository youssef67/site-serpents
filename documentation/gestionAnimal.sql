-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 13 déc. 2023 à 22:59
-- Version du serveur : 10.6.12-MariaDB-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionAnimal`
--

-- --------------------------------------------------------

--
-- Structure de la table `Animal`
--

CREATE TABLE `Animal` (
  `id_animal` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `id_race` int(10) UNSIGNED DEFAULT NULL,
  `genre` int(11) DEFAULT NULL,
  `poids` int(11) DEFAULT NULL,
  `duree_vie` int(11) DEFAULT NULL,
  `date_naissance` datetime DEFAULT NULL,
  `date_mort` datetime DEFAULT NULL,
  `path_img` varchar(100) DEFAULT NULL,
  `id_mere` int(11) DEFAULT NULL,
  `id_pere` int(11) DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Animal`
--

INSERT INTO `Animal` (`id_animal`, `nom`, `id_race`, `genre`, `poids`, `duree_vie`, `date_naissance`, `date_mort`, `path_img`, `id_mere`, `id_pere`, `delete_at`) VALUES
(1223, 'male-1', 1, 2, 6300, 5, '2023-12-12 21:33:22', '2024-12-13 00:00:00', 'snake-7.png', NULL, NULL, '2023-12-12 22:27:21'),
(1225, 'femelle-1', 2, 1, 10600, 9, '2023-12-12 21:33:39', '2024-12-13 00:00:00', 'snake-8.png', NULL, NULL, '2023-12-12 22:27:21'),
(1226, 'Abyss', 2, 2, 3152, 2, '2023-12-12 21:34:13', '2024-12-13 00:00:00', 'snake-9.png', 1225, 1223, '2023-12-12 22:27:21'),
(1227, 'Monte', 2, 1, 12253, 9, '2023-12-12 22:51:41', '2024-12-13 00:00:00', 'snake-11.png', 1225, 1223, NULL),
(1228, 'General', 2, 2, 17840, 6, '2023-12-12 22:51:55', '2024-12-13 00:00:00', 'snake-13.jpg', 1227, 1226, '2023-12-12 22:27:21'),
(1229, 'Cluster', 2, 1, 18343, 5, '2023-12-12 22:53:53', '2024-12-13 00:00:00', 'snake-5.png', 1227, 1226, '2023-12-12 22:27:21'),
(1230, 'Wink', 2, 2, 13793, 12, '2023-12-12 22:54:06', '2024-12-13 00:00:00', 'snake-9.png', 1227, 1226, NULL),
(1231, 'Snooze', 2, 2, 13571, 9, '2023-12-12 22:54:48', '2024-12-13 00:00:00', 'snake-5.png', 1227, 1226, NULL),
(1233, 'Cookie', 2, 1, 779, 8, '2023-12-13 22:26:29', '2023-12-13 22:34:29', 'snake-6.png', 1225, 1226, '2023-12-12 22:27:21');

-- --------------------------------------------------------

--
-- Structure de la table `Race`
--

CREATE TABLE `Race` (
  `id_race` int(10) UNSIGNED NOT NULL,
  `nom_race` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Race`
--

INSERT INTO `Race` (`id_race`, `nom_race`) VALUES
(1, 'Boa'),
(2, 'Cobra'),
(3, 'Couleuvre'),
(4, 'Crotale'),
(5, 'Anaconda'),
(6, 'Python');

-- --------------------------------------------------------

--
-- Structure de la table `Relation`
--

CREATE TABLE `Relation` (
  `id_relation` int(10) UNSIGNED NOT NULL,
  `id_enfant` int(10) UNSIGNED DEFAULT NULL,
  `id_pere` int(10) UNSIGNED DEFAULT NULL,
  `id_mere` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Animal`
--
ALTER TABLE `Animal`
  ADD PRIMARY KEY (`id_animal`),
  ADD KEY `id_race` (`id_race`);

--
-- Index pour la table `Race`
--
ALTER TABLE `Race`
  ADD PRIMARY KEY (`id_race`);

--
-- Index pour la table `Relation`
--
ALTER TABLE `Relation`
  ADD PRIMARY KEY (`id_relation`),
  ADD KEY `id_enfant` (`id_enfant`),
  ADD KEY `id_pere` (`id_pere`),
  ADD KEY `id_mere` (`id_mere`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Animal`
--
ALTER TABLE `Animal`
  MODIFY `id_animal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1234;

--
-- AUTO_INCREMENT pour la table `Race`
--
ALTER TABLE `Race`
  MODIFY `id_race` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `Relation`
--
ALTER TABLE `Relation`
  MODIFY `id_relation` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Animal`
--
ALTER TABLE `Animal`
  ADD CONSTRAINT `race_fk` FOREIGN KEY (`id_race`) REFERENCES `Race` (`id_race`);

--
-- Contraintes pour la table `Relation`
--
ALTER TABLE `Relation`
  ADD CONSTRAINT `enfant_fk` FOREIGN KEY (`id_enfant`) REFERENCES `Animal` (`id_animal`),
  ADD CONSTRAINT `mere_fk` FOREIGN KEY (`id_mere`) REFERENCES `Animal` (`id_animal`),
  ADD CONSTRAINT `pere_fk` FOREIGN KEY (`id_pere`) REFERENCES `Animal` (`id_animal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
