-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 23. Mai 2011 um 16:39
-- Server Version: 5.5.8
-- PHP-Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `fermi`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fermi_role`
--

CREATE TABLE IF NOT EXISTS `fermi_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` set('1') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fermi_role`
--

INSERT INTO `fermi_role` (`role_id`, `name`, `parent_id`) VALUES
(1, 'default', NULL),
(2, 'admin', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fermi_role_user`
--

CREATE TABLE IF NOT EXISTS `fermi_role_user` (
  `role_user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` set('1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`role_user_id`),
  UNIQUE KEY `UQ_e25d3cdf36978e9b84d1e0e4732b23444d9575aa` (`role_id`,`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fermi_role_user`
--

INSERT INTO `fermi_role_user` (`role_user_id`, `role_id`, `user_id`) VALUES
(1, '1', 1),
(2, '1', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fermi_setting`
--

CREATE TABLE IF NOT EXISTS `fermi_setting` (
  `setting_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fermi_setting`
--

INSERT INTO `fermi_setting` (`setting_id`, `name`, `value`) VALUES
(1, 'pagetitle', 'fermi powered site');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fermi_site`
--

CREATE TABLE IF NOT EXISTS `fermi_site` (
  `site_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`site_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Daten für Tabelle `fermi_site`
--

INSERT INTO `fermi_site` (`site_id`, `name`, `content`, `title`, `author_id`) VALUES
(6, 'index', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'Home', 0),
(12, 'hans', 'Serious business', 'About', 0),
(25, 'test', 'blaaa', 'Testseite', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fermi_user`
--

CREATE TABLE IF NOT EXISTS `fermi_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fermi_user`
--

INSERT INTO `fermi_user` (`user_id`, `email`, `pass`, `salt`, `name`) VALUES
(1, 'ephimetheuss@gmail.com', 'admin', 'asd476', 'paul'),
(2, 'hans@email.de', 'admin', 'asd476', 'hans');
