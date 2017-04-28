-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 24 Avril 2017 à 08:02
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `covoiturage`
--

-- --------------------------------------------------------

--
-- Structure de la table `trajets`
--

CREATE TABLE `trajets` (
  `idtrajet` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `depart` varchar(250) NOT NULL,
  `arriver` varchar(250) NOT NULL,
  `places` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL,
  `time` varchar(250) NOT NULL,
  `aller_retour` varchar(250) NOT NULL,
  `trajet` varchar(250) NOT NULL,
  `price` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `trajets`
--

INSERT INTO `trajets` (`idtrajet`, `vehicleid`, `userid`, `depart`, `arriver`, `places`, `date`, `time`, `aller_retour`, `trajet`, `price`) VALUES
(1, 1, 1, 'Gafsa', 'Tunis', '3', '17-02-2017', '00:00', 'oui', 'RÃ©gulier', '14'),
(2, 2, 2, 'Gafsa', 'Sousse', '4', '24-02-2017', '13:05', 'oui', 'Non RÃ©gulier', '11'),
(3, 2, 2, 'Gafsa', 'Tunis', '4', '18-02-2017', '22:00', 'oui', 'Non RÃ©gulier', '15'),
(5, 3, 3, 'Tunis', 'Sousse', '4', '17-02-2017', '07:00', 'oui', 'RÃ©gulier', '4'),
(6, 3, 3, 'Tunis', 'Mahdia', '3', '18-02-2017', '08:00', 'oui', 'RÃ©gulier', '5');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `avatar` text NOT NULL,
  `register_date` datetime NOT NULL,
  `date_login` date DEFAULT '0000-00-00',
  `profession` varchar(250) NOT NULL DEFAULT 'Non Précisé',
  `tabac` varchar(250) NOT NULL DEFAULT 'Non Précisé',
  `tel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`userid`, `fname`, `lname`, `birthdate`, `gender`, `email`, `password`, `avatar`, `register_date`, `date_login`, `profession`, `tabac`, `tel`) VALUES
(1, 'Ahmed', 'Gafsi', '1990-08-27', 'Homme', 'a@a.com', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', '1_a08fc030eaf7fd810b1fad4a4958d997.jpg', '2017-02-17 15:02:30', '2017-03-02', 'Architect', 'AutorisÃ©', '22111000'),
(2, 'Bilel', 'Omrani', '1993-02-24', 'Homme', 'b@b.com', '875f26fdb1cecf20ceb4ca028263dec6', '2_07f4029b4ea364823dfe14bc11006bc9.jpg', '2017-02-17 15:02:32', '2017-02-17', 'Ã©tudiant', 'Non AutorisÃ©', '22111111'),
(3, 'Sabrine', 'Khlifi', '1987-11-25', 'Femme', 'c@c.com', 'c1f68ec06b490b3ecb4066b1b13a9ee9', '3_ed718ba3ea3ed7e5748e53506ae42a5b.jpg', '2017-02-17 15:02:55', '2017-02-17', 'MÃ©decine', 'Non AutorisÃ©', '54111888');

-- --------------------------------------------------------

--
-- Structure de la table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `mark` varchar(250) NOT NULL,
  `color` varchar(250) NOT NULL,
  `air_cond` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vehicles`
--

INSERT INTO `vehicles` (`vehicleid`, `userid`, `mark`, `color`, `air_cond`) VALUES
(1, 1, 'Renault Symbol', 'Blanc', 'ClimatisÃ©e'),
(2, 2, 'Peugeot 206', 'Gris', 'Non ClimatisÃ©e'),
(3, 3, 'Volkswagen Passat', 'Noir', 'ClimatisÃ©e');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `trajets`
--
ALTER TABLE `trajets`
  ADD PRIMARY KEY (`idtrajet`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Index pour la table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicleid`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `trajets`
--
ALTER TABLE `trajets`
  MODIFY `idtrajet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
