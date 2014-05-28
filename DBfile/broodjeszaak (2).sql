-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 28 mei 2014 om 17:02
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `broodjeszaak`
--
CREATE DATABASE IF NOT EXISTS `broodjeszaak` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `broodjeszaak`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(30) COLLATE utf8_bin NOT NULL,
  `pw` varchar(150) COLLATE utf8_bin NOT NULL,
  `salt` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `admin`
--

INSERT INTO `admin` (`id`, `naam`, `pw`, `salt`) VALUES
(1, 'admin', '20e76c9da91820326d19df737ee8655d2044b48095dd1357a159a413a1bbcafd', '492b1290ab4369b0348daf6dce9c5f2e116f1a3a1a0ada49c07880af649541ce959654f2a3c877f2e6a1ecf099678e5cdb');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `beleg`
--

CREATE TABLE IF NOT EXISTS `beleg` (
  `belegid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_bin NOT NULL,
  `prijs` int(3) NOT NULL,
  `bestelregelid` int(11) DEFAULT NULL,
  PRIMARY KEY (`belegid`),
  KEY `bestelregelid` (`bestelregelid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=115 ;

--
-- Gegevens worden uitgevoerd voor tabel `beleg`
--

INSERT INTO `beleg` (`belegid`, `type`, `prijs`, `bestelregelid`) VALUES
(1, 'kaas', 50, NULL),
(2, 'hesp', 50, NULL),
(3, 'sla', 50, NULL),
(4, 'mayonaise', 20, NULL),
(105, 'sla', 50, 92),
(106, 'mayonaise', 20, 92),
(107, 'kaas', 50, 93),
(108, 'hesp', 50, 93),
(109, 'sla', 50, 93),
(110, 'mayonaise', 20, 93),
(111, 'hesp', 50, 94),
(112, 'sla', 50, 94),
(113, 'hesp', 50, 95),
(114, 'sla', 50, 95);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE IF NOT EXISTS `bestelling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(3) NOT NULL,
  `tijdstip` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=90 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelling`
--

INSERT INTO `bestelling` (`id`, `userid`, `tijdstip`) VALUES
(88, 6, '2014-03-17 14:18:07'),
(89, 11, '2014-03-18 15:36:05');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelregel`
--

CREATE TABLE IF NOT EXISTS `bestelregel` (
  `bestelregelid` int(11) NOT NULL AUTO_INCREMENT,
  `bestelregelprijs` int(3) NOT NULL,
  `bestellingid` int(11) NOT NULL,
  PRIMARY KEY (`bestelregelid`),
  KEY `bestellingid` (`bestellingid`),
  KEY `bestellingid_2` (`bestellingid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=96 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelregel`
--

INSERT INTO `bestelregel` (`bestelregelid`, `bestelregelprijs`, `bestellingid`) VALUES
(92, 220, 88),
(93, 320, 88),
(94, 250, 89),
(95, 250, 89);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `brood`
--

CREATE TABLE IF NOT EXISTS `brood` (
  `broodid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_bin NOT NULL,
  `prijs` int(3) NOT NULL,
  `bestelregelid` int(11) DEFAULT NULL,
  PRIMARY KEY (`broodid`),
  KEY `bestelregelid` (`bestelregelid`),
  KEY `bestelregelid_2` (`bestelregelid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=71 ;

--
-- Gegevens worden uitgevoerd voor tabel `brood`
--

INSERT INTO `brood` (`broodid`, `type`, `prijs`, `bestelregelid`) VALUES
(6, 'klein grof', 100, NULL),
(7, 'groot grof', 150, NULL),
(8, 'klein wit', 100, NULL),
(9, 'groot wit', 150, NULL),
(10, 'ciabatta', 200, NULL),
(67, 'groot grof', 150, 92),
(68, 'groot wit', 150, 93),
(69, 'groot grof', 150, 94),
(70, 'groot grof', 150, 95);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(320) COLLATE utf8_bin NOT NULL,
  `pw` varchar(150) COLLATE utf8_bin NOT NULL,
  `naam` varchar(50) COLLATE utf8_bin NOT NULL,
  `salt` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `user`
--

INSERT INTO `user` (`id`, `email`, `pw`, `naam`, `salt`) VALUES
(11, 'markvanderveken@gmail.com', '5211f8d02c80e328f1c74bcb03b90b54eacf323f843405a49d59478bbc08a04c', 'markie', '11a5cb92cd217f9b1bd06db92aa2f17d66b10ac998a28a4fd3410f02ee2efb65d1b30e3478d61530df10');

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `beleg`
--
ALTER TABLE `beleg`
  ADD CONSTRAINT `beleg_ibfk_1` FOREIGN KEY (`bestelregelid`) REFERENCES `bestelregel` (`bestelregelid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `bestelregel`
--
ALTER TABLE `bestelregel`
  ADD CONSTRAINT `bestelregel_ibfk_1` FOREIGN KEY (`bestellingid`) REFERENCES `bestelling` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `brood`
--
ALTER TABLE `brood`
  ADD CONSTRAINT `broodbestelregel` FOREIGN KEY (`bestelregelid`) REFERENCES `bestelregel` (`bestelregelid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
