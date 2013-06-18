-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Ven 24 Mai 2013 à 16:17
-- Version du serveur: 5.5.27-log
-- Version de PHP: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `divinebreath`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(255) NOT NULL,
  `account_pw` varchar(255) NOT NULL,
  `account_mail` varchar(255) NOT NULL,
  `account_grade` int(11) NOT NULL DEFAULT '1',
  `player_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`account_id`, `account_name`, `account_pw`, `account_mail`, `account_grade`, `player_id`) VALUES
(1, 'ss4game1', '6672e69bcda2241cc2c12c43fc2f1eb6', 'yurii.azoria@gmail.com', 1, 14),
(2, 'nii38', '6672e69bcda2241cc2c12c43fc2f1eb6', 'yurii.azoria@gmail.com', 1, 15);

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE IF NOT EXISTS `classe` (
  `id_classe` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `vit` int(11) NOT NULL,
  `str` int(11) NOT NULL,
  `int` int(11) NOT NULL,
  `dex` int(11) NOT NULL,
  `skill1` varchar(255) NOT NULL,
  `skill2` varchar(255) NOT NULL,
  `skill3` varchar(255) NOT NULL,
  PRIMARY KEY (`id_classe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `classe`
--

INSERT INTO `classe` (`id_classe`, `nom`, `vit`, `str`, `int`, `dex`, `skill1`, `skill2`, `skill3`) VALUES
(1, 'Berserker', 5, 8, 3, 4, 'Moulinet', 'Berserk', 'Lame enchanté'),
(2, 'Paladin', 8, 5, 3, 4, 'Charge', 'Corps puissant', 'Bouclier Impénétrable'),
(3, 'Prêtre', 5, 3, 8, 4, 'Soin', 'Appel de la foudre', 'Force de la nature'),
(4, 'Assassin', 4, 5, 3, 8, 'Furtif', 'Lame fourbe', 'Transcendation');

-- --------------------------------------------------------

--
-- Structure de la table `mob_proto`
--

CREATE TABLE IF NOT EXISTS `mob_proto` (
  `id_monstre` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `life` int(11) NOT NULL,
  `degat` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id_monstre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `mob_proto`
--

INSERT INTO `mob_proto` (`id_monstre`, `name`, `life`, `degat`, `exp`, `lvl`, `grade`) VALUES
(1, 'loup', 200, 15, 30, 2, 1),
(2, 'chien enragé', 125, 5, 10, 1, 1),
(3, 'chiens galeux', 145, 10, 20, 1, 2),
(4, 'Renard des neiges', 175, 20, 25, 2, 1),
(5, 'Renard abominable', 200, 35, 35, 3, 2),
(6, 'Sanglier féroce', 200, 30, 30, 3, 2),
(7, 'Sanglier sauvage', 200, 30, 20, 3, 1),
(8, 'Cerf cannibal', 250, 50, 45, 4, 2),
(9, 'Cerf furieux', 225, 45, 40, 4, 1),
(10, 'Sauvage', 250, 50, 60, 5, 1),
(11, 'Chef sauvage', 300, 100, 100, 5, 3),
(12, 'Scorpion géant', 200, 100, 70, 6, 1),
(13, 'Ours des neiges', 300, 120, 75, 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `pallier_lvl`
--

CREATE TABLE IF NOT EXISTS `pallier_lvl` (
  `pallier_id` int(11) NOT NULL AUTO_INCREMENT,
  `lvl` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  PRIMARY KEY (`pallier_id`),
  KEY `pallier_id` (`pallier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `pallier_lvl`
--

INSERT INTO `pallier_lvl` (`pallier_id`, `lvl`, `exp`) VALUES
(1, 1, 20),
(2, 2, 50),
(3, 3, 85),
(4, 4, 100),
(5, 5, 135),
(6, 6, 200),
(7, 7, 300);

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `degat` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `locate` varchar(255) NOT NULL,
  `life` int(11) NOT NULL,
  `str` int(11) NOT NULL,
  `int` int(11) NOT NULL,
  `vit` int(11) NOT NULL,
  `dex` int(11) NOT NULL,
  `classe` varchar(255) NOT NULL,
  `degat_magique` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=REDUNDANT AUTO_INCREMENT=16 ;

--
-- Contenu de la table `player`
--

INSERT INTO `player` (`id`, `nom`, `degat`, `exp`, `lvl`, `locate`, `life`, `str`, `int`, `vit`, `dex`, `classe`, `degat_magique`) VALUES
(14, 'sShotrah', 24, 0, 1, 'cité', 150, 8, 3, 5, 4, 'Berserker', 9),
(15, 'tutu', 96, 30, 4, 'cité', 191, 32, 12, 20, 16, 'Berserker', 90);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
