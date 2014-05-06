-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 06 mei 2014 om 15:15
-- Serverversie: 5.6.14
-- PHP-versie: 5.5.6

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=157 ;

--
-- Gegevens worden uitgevoerd voor tabel `beleg`
--

INSERT INTO `beleg` (`belegid`, `type`, `prijs`, `bestelregelid`) VALUES
(1, 'kaas', 50, NULL),
(2, 'hesp', 50, NULL),
(3, 'sla', 50, NULL),
(4, 'mayonaise', 20, NULL),
(111, 'sla', 50, 82),
(112, 'sla', 50, 83),
(113, 'sla', 50, 84),
(114, 'sla', 50, 85),
(117, 'mayonaise', 20, 88),
(118, 'mayonaise', 20, 89),
(119, 'mayonaise', 20, 90),
(120, 'mayonaise', 20, 91),
(121, 'mayonaise', 20, 92),
(122, 'mayonaise', 20, 93),
(123, 'mayonaise', 20, 94),
(124, 'sla', 50, 95),
(125, 'mayonaise', 20, 95),
(126, 'hesp', 50, 96),
(127, 'mayonaise', 20, 96),
(128, 'sla', 50, 97),
(129, 'mayonaise', 20, 97),
(130, 'hesp', 50, 98),
(131, 'mayonaise', 20, 98),
(132, 'sla', 50, 99),
(133, 'mayonaise', 20, 99),
(134, 'hesp', 50, 100),
(135, 'mayonaise', 20, 100),
(136, 'sla', 50, 101),
(137, 'mayonaise', 20, 101),
(138, 'sla', 50, 102),
(139, 'mayonaise', 20, 102),
(140, 'sla', 50, 103),
(141, 'mayonaise', 20, 103),
(142, 'sla', 50, 104),
(143, 'mayonaise', 20, 104),
(144, 'sla', 50, 105),
(145, 'mayonaise', 20, 105),
(146, 'sla', 50, 106),
(147, 'mayonaise', 20, 106),
(148, 'sla', 50, 107),
(149, 'mayonaise', 20, 107),
(150, 'sla', 50, 108),
(151, 'mayonaise', 20, 108),
(152, 'sla', 50, 109),
(153, 'mayonaise', 20, 109),
(154, 'sla', 50, 110),
(155, 'mayonaise', 20, 110),
(156, 'sla', 50, 111);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE IF NOT EXISTS `bestelling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(3) NOT NULL,
  `tijdstip` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=74 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelling`
--

INSERT INTO `bestelling` (`id`, `userid`, `tijdstip`) VALUES
(58, 11, '2014-05-06 14:07:22'),
(59, 11, '2014-05-06 14:07:54'),
(61, 11, '2014-05-06 14:09:25'),
(62, 11, '2014-05-06 14:10:12'),
(63, 11, '2014-05-06 14:10:27'),
(64, 11, '2014-05-06 14:10:47'),
(65, 11, '2014-05-06 14:11:06'),
(66, 11, '2014-05-06 14:11:10'),
(67, 11, '2014-05-06 14:12:02'),
(68, 11, '2014-05-06 14:15:40'),
(69, 11, '2014-05-06 14:16:17'),
(70, 11, '2014-05-06 14:16:19'),
(71, 11, '2014-05-06 14:21:53'),
(72, 11, '2014-05-06 14:22:03'),
(73, 11, '2014-05-06 14:22:40');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=112 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelregel`
--

INSERT INTO `bestelregel` (`bestelregelid`, `bestelregelprijs`, `bestellingid`) VALUES
(82, 200, 58),
(83, 200, 58),
(84, 200, 59),
(85, 200, 59),
(88, 170, 61),
(89, 170, 62),
(90, 170, 63),
(91, 170, 64),
(92, 170, 65),
(93, 170, 66),
(94, 170, 67),
(95, 220, 68),
(96, 170, 68),
(97, 220, 69),
(98, 170, 69),
(99, 220, 70),
(100, 170, 70),
(101, 220, 71),
(102, 220, 71),
(103, 220, 71),
(104, 220, 71),
(105, 220, 71),
(106, 220, 72),
(107, 220, 72),
(108, 220, 72),
(109, 220, 72),
(110, 220, 72),
(111, 200, 73);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=117 ;

--
-- Gegevens worden uitgevoerd voor tabel `brood`
--

INSERT INTO `brood` (`broodid`, `type`, `prijs`, `bestelregelid`) VALUES
(6, 'klein grof', 100, NULL),
(7, 'groot grof', 150, NULL),
(8, 'klein wit', 100, NULL),
(9, 'groot wit', 150, NULL),
(10, 'ciabatta', 200, NULL),
(87, 'groot grof', 150, 82),
(88, 'groot grof', 150, 83),
(89, 'groot grof', 150, 84),
(90, 'groot grof', 150, 85),
(93, 'groot grof', 150, 88),
(94, 'groot grof', 150, 89),
(95, 'groot grof', 150, 90),
(96, 'groot grof', 150, 91),
(97, 'groot grof', 150, 92),
(98, 'groot grof', 150, 93),
(99, 'groot grof', 150, 94),
(100, 'groot grof', 150, 95),
(101, 'klein grof', 100, 96),
(102, 'groot grof', 150, 97),
(103, 'klein grof', 100, 98),
(104, 'groot grof', 150, 99),
(105, 'klein grof', 100, 100),
(106, 'groot grof', 150, 101),
(107, 'groot grof', 150, 102),
(108, 'groot grof', 150, 103),
(109, 'groot grof', 150, 104),
(110, 'groot grof', 150, 105),
(111, 'groot grof', 150, 106),
(112, 'groot grof', 150, 107),
(113, 'groot grof', 150, 108),
(114, 'groot grof', 150, 109),
(115, 'groot grof', 150, 110),
(116, 'groot grof', 150, 111);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Gegevens worden uitgevoerd voor tabel `user`
--

INSERT INTO `user` (`id`, `email`, `pw`, `naam`, `salt`) VALUES
(11, 'markvanderveken@gmail.com', '8b65014e47a81af83d63d2d002ece972d0750fc1326ed801923ecd97a07b0db0', 'markie', '6007fe19f9ff99ddd301c39133db173027f14be949ea30dba31940a1f97b74665d8630d4316e763d'),
(12, 'lol@lol.Com', '23235c0673845a3d1f045511499646384c3e61bab87e335a30e6e621b27c71c4', 'lol', 'fa937eb5aa036a7bea4435e6927187f39135824557d6f3c94d68f2db10045fd9b397c973c58b6ee70200af91f16a'),
(13, 'lol@lol.com', '7461718ac065e8dc4a96bbb3950ba6e3730f9b2fc02cb2e40e9b5e422a30a1fc', 'lol', 'e3bd2b0ded72d062fa76f0c2abf040bd61c568ae33f248a36e04fc6f745f9371e0a7277b9762855b2fef6cf22e9b3034'),
(14, 'me@me.com', 'cfaee34d7f1d272b79d4320fea90368ee47080967b2a5ef69d98598a56ecbb2a', 'me', 'f2f86c534e6c4ca39efd7229b6045d3b9ee40bcacb179101bb98f5ebba78d9a5227f28373fade6c9031be9');

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
