-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 06 nov. 2019 à 15:49
-- Version du serveur :  5.7.24
-- Version de PHP :  7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dashboard`
--

-- --------------------------------------------------------

--
-- Structure de la table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forID` int(11) NOT NULL,
  `objet_alert` varchar(255) CHARACTER SET utf8 NOT NULL,
  `msg_alert` text CHARACTER SET utf8 NOT NULL,
  `fromID` int(11) NOT NULL,
  `date_alert` datetime NOT NULL,
  `done` varchar(4) CHARACTER SET utf8 DEFAULT 'NO',
  `done_date` timestamp NULL DEFAULT NULL,
  `expiration_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=185 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `alerts`
--

INSERT INTO `alerts` (`id`, `forID`, `objet_alert`, `msg_alert`, `fromID`, `date_alert`, `done`, `done_date`, `expiration_date`) VALUES
(183, 175, 'ggz', 'rgrg', 175, '2018-07-19 11:34:52', 'DONE', NULL, NULL),
(184, 175, 'gntnt', 'tjhttjj', 175, '2018-07-23 12:23:58', 'NO', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `analytics`
--

DROP TABLE IF EXISTS `analytics`;
CREATE TABLE IF NOT EXISTS `analytics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientsID` int(11) NOT NULL,
  `userNb` text,
  `sessionNb` text,
  `bounceRate` text,
  `sessionDuration` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `analytics`
--

INSERT INTO `analytics` (`id`, `clientsID`, `userNb`, `sessionNb`, `bounceRate`, `sessionDuration`) VALUES
(18, 193, '<iframe width=\"600\" height=\"371\" seamless frameborder=\"0\" scrolling=\"no\" src=\"https://docs.google.com/spreadsheets/d/e/2PACX-1vRHjmqat71BUiIOsbg_WThBxxk9OD-b8nXwRqIVDMD8Wf54FCPKns72VI2JzeUxLWIYFKJMSbX0tBuk/pubchart?oid=360779989&amp;format=interactive\"></iframe>', '<iframe width=\"600\" height=\"371\" seamless frameborder=\"0\" scrolling=\"no\" src=\"https://docs.google.com/spreadsheets/d/e/2PACX-1vRHjmqat71BUiIOsbg_WThBxxk9OD-b8nXwRqIVDMD8Wf54FCPKns72VI2JzeUxLWIYFKJMSbX0tBuk/pubchart?oid=70898040&amp;format=interactive\"></iframe>', '<iframe width=\"600\" height=\"371\" seamless frameborder=\"0\" scrolling=\"no\" src=\"https://docs.google.com/spreadsheets/d/e/2PACX-1vRHjmqat71BUiIOsbg_WThBxxk9OD-b8nXwRqIVDMD8Wf54FCPKns72VI2JzeUxLWIYFKJMSbX0tBuk/pubchart?oid=1291433226&amp;format=interactive\"></iframe>', '<iframe width=\"600\" height=\"371\" seamless frameborder=\"0\" scrolling=\"no\" src=\"https://docs.google.com/spreadsheets/d/e/2PACX-1vRHjmqat71BUiIOsbg_WThBxxk9OD-b8nXwRqIVDMD8Wf54FCPKns72VI2JzeUxLWIYFKJMSbX0tBuk/pubchart?oid=769011007&amp;format=interactive\"></iframe>'),
(27, 176, NULL, NULL, NULL, NULL),
(28, 177, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `mails`
--

DROP TABLE IF EXISTS `mails`;
CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forID` int(11) NOT NULL,
  `mail_subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mail_message` text CHARACTER SET utf8 NOT NULL,
  `date_mail` datetime NOT NULL,
  `date_next_mail` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mails`
--

INSERT INTO `mails` (`id`, `forID`, `mail_subject`, `mail_message`, `date_mail`, `date_next_mail`) VALUES
(152, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 00:00:00', '2018-07-23 13:02:04'),
(153, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 00:00:00', '2018-07-23 13:03:01'),
(154, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 11:59:37', '2018-07-23 13:03:37'),
(155, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 11:59:40', '2018-07-23 13:03:40'),
(156, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 12:00:00', '2018-07-23 13:44:00'),
(157, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 12:00:01', '2018-07-23 13:44:01'),
(158, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 12:01:17', '2018-07-23 13:45:17'),
(159, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 12:01:53', '2018-07-23 13:45:53'),
(160, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 12:02:24', '2018-07-23 14:18:24'),
(161, 144, 'Sujet du mail', 'Message du mail', '2018-07-23 12:02:45', '2018-07-23 14:54:45');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `entreprise` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mail` varchar(255) CHARACTER SET utf8 NOT NULL,
  `tel` int(11) NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8 NOT NULL,
  `projet` varchar(255) CHARACTER SET utf8 NOT NULL,
  `avancement` varchar(255) CHARACTER SET utf8 NOT NULL,
  `drive` varchar(255) CHARACTER SET utf8 NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `serverIP` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `type` varchar(25) CHARACTER SET utf8 NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=180 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `nom`, `entreprise`, `mail`, `tel`, `mdp`, `projet`, `avancement`, `drive`, `site`, `serverIP`, `type`, `date_ajout`) VALUES
(176, 'C1', 'EC1', 'tom@yo.frz', 555, '$2y$10$OfW0Cz8nTpQBG5HtzJ80oOPOc4/Crn9RvwltKuGtTAusFIyY3Mgb2', '', '', '', '', '', 'Client', '2018-07-18'),
(178, 'Maximilien Boutet', 'LeSquid', 'boutet.maximilien@gmail.com', 666666, '$2y$10$Gk2Ks2aoPgEYJqozQILXp./QKW4GwtuiTz24nJYA9QNQatPZ4d2RW', 'x', '100', 'x', 'x', 'x', 'Administrateur', '2019-11-04');

-- --------------------------------------------------------

--
-- Structure de la table `minichat_2`
--

DROP TABLE IF EXISTS `minichat_2`;
CREATE TABLE IF NOT EXISTS `minichat_2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `par` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pour` varchar(255) CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `date_message` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=209 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `minichat_2`
--

INSERT INTO `minichat_2` (`id`, `par`, `pour`, `message`, `date_message`) VALUES
(201, 'OWCS', 'EC1', 'zegzzeg', '2018-07-19 13:58:11'),
(202, 'OWCS', 'ISCG ENTREPRISE', 'efefe', '2018-07-23 07:46:09'),
(203, 'OWCS', 'ISCG ENTREPRISE', 'efefe', '2018-07-23 07:46:13'),
(204, 'OWCS', 'ISCG ENTREPRISE', 'efefe', '2018-07-23 07:46:34'),
(205, 'OWCS', 'ISCG ENTREPRISE', 'zergzegez', '2018-07-23 08:38:26'),
(206, 'OWCS', 'OWCS', 'ezgzee', '2018-07-23 10:22:52'),
(207, 'OWCS', 'OWCS', 'fdgerg', '2018-07-23 10:49:48'),
(208, 'OWCS', 'OWCS', 'hfjrth', '2018-07-26 10:49:18');

-- --------------------------------------------------------

--
-- Structure de la table `servers`
--

DROP TABLE IF EXISTS `servers`;
CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date_last_action` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
