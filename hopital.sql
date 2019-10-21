-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 20 Octobre 2019 à 20:10
-- Version du serveur :  5.7.27-0ubuntu0.16.04.1
-- Version de PHP :  7.0.33-0ubuntu0.16.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hopital`
--

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `id_medecin` int(11) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` int(11) NOT NULL,
  `specialite` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  `id_service` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `medecin`
--

INSERT INTO `medecin` (`id_medecin`, `prenom`, `nom`, `telephone`, `specialite`, `email`, `mdp`, `id_service`) VALUES
(12, 'cheikh', 'dieng', 773043248, 'cardiologue', 'cheikh@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 14),
(13, 'mouhamed', 'mbaye', 762458974, 'chirurgien', 'mouhamed@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 17);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id_patient` int(11) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `adresse` varchar(45) NOT NULL,
  `telephone` int(11) NOT NULL,
  `id_secretaire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `patient`
--

INSERT INTO `patient` (`id_patient`, `prenom`, `nom`, `age`, `adresse`, `telephone`, `id_secretaire`) VALUES
(1, 'mamadou', 'diop', 15, 'dakar', 773024152, 12),
(2, 'lamine', 'fall', 21, 'dakar', 771254120, 13),
(3, 'cheikh', 'dieng', 23, 'dakar', 773043248, 14),
(4, 'albert', 'diop', 12, 'dakar', 706541245, 14),
(5, 'albert', 'diouf', 12, 'dakar', 773043248, 14),
(12, 'adama', 'dieng', 12, 'dakar', 773043248, 12),
(14, 'mame anta', 'diouf', 23, 'dakar', 773043248, 13),
(16, 'cheikh', 'dieng', 12, 'dakar', 773043248, 12),
(18, 'moussa', 'fall', 24, 'dakar', 773024152, 12),
(19, 'khady', 'dieng', 12, 'dakar', 773043248, 12),
(20, 'sokhna khadija', 'diouf', 19, 'thies', 781254961, 14);

-- --------------------------------------------------------

--
-- Structure de la table `plage_horaire`
--

CREATE TABLE `plage_horaire` (
  `id_horaire` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `id_medecin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `plage_horaire`
--

INSERT INTO `plage_horaire` (`id_horaire`, `date`, `heure_debut`, `heure_fin`, `id_medecin`) VALUES
(1, '2019-10-19', '08:00:00', '17:00:00', 12);

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vous`
--

CREATE TABLE `rendez_vous` (
  `num_rv` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `id_secretaire` int(11) NOT NULL,
  `id_horaire` int(11) NOT NULL,
  `id_medecin` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`num_rv`, `date`, `heure_debut`, `heure_fin`, `id_secretaire`, `id_horaire`, `id_medecin`, `id_patient`) VALUES
(1, '2019-10-19', '12:00:00', '12:30:00', 12, 1, 12, 1),
(2, '2019-10-19', '12:30:00', '13:00:00', 12, 1, 12, 2),
(3, '2019-10-20', '00:13:18', '00:00:00', 13, 1, 12, 20);

-- --------------------------------------------------------

--
-- Structure de la table `secretaire`
--

CREATE TABLE `secretaire` (
  `id_secretaire` int(11) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  `id_service` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `secretaire`
--

INSERT INTO `secretaire` (`id_secretaire`, `prenom`, `nom`, `telephone`, `email`, `mdp`, `id_service`) VALUES
(12, 'khady', 'seye', 762458974, 'khady@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 14),
(13, 'adama', 'diop', 706541245, 'adama@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 15),
(14, 'amina', 'diouf', 775864152, 'amina@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 16),
(15, 'mame anta', 'dieng', 773043248, 'mame@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 17);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id_service` int(11) NOT NULL,
  `nom_service` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `services`
--

INSERT INTO `services` (`id_service`, `nom_service`) VALUES
(14, 'cardiologie'),
(15, 'pharmacie'),
(16, 'ophtalmologie'),
(17, 'Chirurgie');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`id_medecin`),
  ADD KEY `fk_medecin_services1_idx` (`id_service`),
  ADD KEY `fk_medecin_services2_idx` (`id_service`),
  ADD KEY `fk_medecin_services5_idx` (`id_service`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD KEY `fk_patient_secretaire1_idx` (`id_secretaire`);

--
-- Index pour la table `plage_horaire`
--
ALTER TABLE `plage_horaire`
  ADD PRIMARY KEY (`id_horaire`),
  ADD KEY `fk_plage_horaire_medecin1_idx` (`id_medecin`);

--
-- Index pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD PRIMARY KEY (`num_rv`),
  ADD KEY `fk_rendez_vous_secretaire1_idx` (`id_secretaire`),
  ADD KEY `fk_rendez_vous_plage_horaire1_idx` (`id_horaire`),
  ADD KEY `fk_rendez_vous_medecin1_idx` (`id_medecin`),
  ADD KEY `fk_rendez_vous_patient1_idx` (`id_patient`);

--
-- Index pour la table `secretaire`
--
ALTER TABLE `secretaire`
  ADD PRIMARY KEY (`id_secretaire`),
  ADD KEY `fk_secretaire_services1_idx` (`id_service`),
  ADD KEY `fk_secretaire_services2_idx` (`id_service`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id_service`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id_medecin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `plage_horaire`
--
ALTER TABLE `plage_horaire`
  MODIFY `id_horaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  MODIFY `num_rv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `secretaire`
--
ALTER TABLE `secretaire`
  MODIFY `id_secretaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD CONSTRAINT `fk_medecin_services1` FOREIGN KEY (`id_service`) REFERENCES `services` (`id_service`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `fk_patient_secretaire1` FOREIGN KEY (`id_secretaire`) REFERENCES `secretaire` (`id_secretaire`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `plage_horaire`
--
ALTER TABLE `plage_horaire`
  ADD CONSTRAINT `fk_plage_horaire_medecin1` FOREIGN KEY (`id_medecin`) REFERENCES `medecin` (`id_medecin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD CONSTRAINT `fk_rendez_vous_medecin1` FOREIGN KEY (`id_medecin`) REFERENCES `medecin` (`id_medecin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rendez_vous_patient1` FOREIGN KEY (`id_patient`) REFERENCES `patient` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rendez_vous_plage_horaire1` FOREIGN KEY (`id_horaire`) REFERENCES `plage_horaire` (`id_horaire`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rendez_vous_secretaire1` FOREIGN KEY (`id_secretaire`) REFERENCES `secretaire` (`id_secretaire`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `secretaire`
--
ALTER TABLE `secretaire`
  ADD CONSTRAINT `fk_secretaire_services1` FOREIGN KEY (`id_service`) REFERENCES `services` (`id_service`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
