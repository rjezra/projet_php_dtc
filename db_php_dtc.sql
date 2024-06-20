-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 19 juin 2024 à 21:22
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `exo_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `conger`
--

CREATE TABLE `conger` (
  `id_conger` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `date_debut_conger` date NOT NULL,
  `date_fin_conger` date NOT NULL,
  `motif_conger` text NOT NULL,
  `acceptation_conger` varchar(20) NOT NULL,
  `nombre_jours_conger` int(11) NOT NULL,
  `reste_conger` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nombreconger`
--

CREATE TABLE `nombreconger` (
  `id_nombre_conger` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `reste_conger` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `nombreconger`
--

INSERT INTO `nombreconger` (`id_nombre_conger`, `id_users`, `reste_conger`) VALUES
(1, 20, 30);

-- --------------------------------------------------------

--
-- Structure de la table `presence`
--

CREATE TABLE `presence` (
  `id_presence` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `date_pres` date NOT NULL,
  `observation` varchar(50) NOT NULL,
  `heure_entrer` time NOT NULL,
  `heure_sortie` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `mdp` text NOT NULL,
  `isEnable` tinyint(1) NOT NULL,
  `roles` varchar(30) NOT NULL,
  `created_at` date NOT NULL,
  `photo` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `pseudo`, `mdp`, `isEnable`, `roles`, `created_at`, `photo`, `mail`, `phone`) VALUES
(20, 'Rakotomandimby', 'fetra', 'fetra-Admin', '$2y$10$ZIeH126DoMXqxdKezE30bei3uoQ9Npg9aAwvDHun7z73wZhb8r9Pi', 1, 'admin', '2024-06-19', 'ROC_0479.jpg', 'jahoely@gmail.com', '02356 656545');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `conger`
--
ALTER TABLE `conger`
  ADD PRIMARY KEY (`id_conger`),
  ADD KEY `id_users` (`id_users`);

--
-- Index pour la table `nombreconger`
--
ALTER TABLE `nombreconger`
  ADD PRIMARY KEY (`id_nombre_conger`),
  ADD KEY `id_users` (`id_users`);

--
-- Index pour la table `presence`
--
ALTER TABLE `presence`
  ADD PRIMARY KEY (`id_presence`),
  ADD KEY `id_users` (`id_users`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `conger`
--
ALTER TABLE `conger`
  MODIFY `id_conger` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `nombreconger`
--
ALTER TABLE `nombreconger`
  MODIFY `id_nombre_conger` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `presence`
--
ALTER TABLE `presence`
  MODIFY `id_presence` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `conger`
--
ALTER TABLE `conger`
  ADD CONSTRAINT `conger_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `nombreconger`
--
ALTER TABLE `nombreconger`
  ADD CONSTRAINT `nombreconger_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `presence`
--
ALTER TABLE `presence`
  ADD CONSTRAINT `presence_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
