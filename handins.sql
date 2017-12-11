-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Dez 2017 um 20:14
-- Server-Version: 10.1.19-MariaDB
-- PHP-Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `iiigel`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `handins`
--

CREATE TABLE `handins` (
  `ID` int(11) NOT NULL,
  `sID` varchar(60) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `ChapterID` int(11) NOT NULL,
  `bIsAccepted` tinyint(1) NOT NULL,
  `bIsUnderReview` tinyint(1) NOT NULL,
  `isRejected` tinyint(1) NOT NULL,
  `sText` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `handins`
--

INSERT INTO `handins` (`ID`, `sID`, `Date`, `UserID`, `GroupID`, `ChapterID`, `bIsAccepted`, `bIsUnderReview`, `isRejected`, `sText`) VALUES
(1, NULL, '2017-03-31 21:32:07', 6, 1, 4, 0, 0, 0, 'blub'),
(2, NULL, '2017-03-31 21:33:14', 8, 1, 0, 0, 0, 0, ''),
(3, NULL, '2017-03-31 21:34:17', 9, 1, 0, 0, 0, 0, ''),
(5, NULL, '2017-03-31 21:36:13', 8, 4, 0, 0, 0, 0, ''),
(6, NULL, '2017-03-31 21:36:22', 6, 4, 0, 0, 0, 0, ''),
(7, NULL, '2017-03-31 21:36:27', 9, 4, 0, 0, 0, 0, '');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `handins`
--
ALTER TABLE `handins`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `handins`
--
ALTER TABLE `handins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
