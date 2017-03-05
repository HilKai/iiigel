-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Mrz 2017 um 18:04
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
-- Tabellenstruktur für Tabelle `chapters`
--

CREATE TABLE `chapters` (
  `ID` int(11) NOT NULL,
  `sID` varchar(60) DEFAULT NULL,
  `iIndex` int(11) NOT NULL,
  `sTitle` varchar(50) NOT NULL,
  `sText` text NOT NULL,
  `sNote` varchar(255) NOT NULL,
  `ModulID` int(11) NOT NULL,
  `bInterpreter` tinyint(1) NOT NULL,
  `bIsMandatoryHandIn` tinyint(1) NOT NULL,
  `bIsLive` tinyint(1) NOT NULL,
  `bLiveInterpretation` tinyint(1) NOT NULL,
  `bShowCloud` tinyint(1) NOT NULL,
  `bIsDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL,
  `ModulID` int(11) NOT NULL,
  `InstitutionsID` int(11) NOT NULL,
  `sName` varchar(50) NOT NULL,
  `bIsDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `handins`
--

CREATE TABLE `handins` (
  `ID` int(11) NOT NULL,
  `sID` varchar(60) DEFAULT NULL,
  `Date` date NOT NULL,
  `GroupID` int(11) NOT NULL,
  `ChapterID` int(11) NOT NULL,
  `bIsAccepted` tinyint(1) NOT NULL,
  `bIsUnderReview` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `institutions`
--

CREATE TABLE `institutions` (
  `ID` int(11) NOT NULL,
  `sID` varchar(60) DEFAULT NULL,
  `sName` varchar(50) NOT NULL,
  `bIsDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `institutions`
--

INSERT INTO `institutions` (`ID`, `sID`, `sName`, `bIsDeleted`) VALUES
(1, NULL, 'Gymnasium Am Geroweiher', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modules`
--

CREATE TABLE `modules` (
  `ID` int(11) NOT NULL,
  `sID` varchar(60) DEFAULT NULL,
  `sName` varchar(50) NOT NULL,
  `sDescription` text NOT NULL,
  `sLanguage` varchar(50) NOT NULL,
  `sIcon` varchar(255) NOT NULL,
  `bIsDeleted` tinyint(1) NOT NULL,
  `bIsLive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `modules`
--

INSERT INTO `modules` (`ID`, `sID`, `sName`, `sDescription`, `sLanguage`, `sIcon`, `bIsDeleted`, `bIsLive`) VALUES
(1, NULL, 'SmallBasic', 'SmallBasic ist die erste Programmiersprache, die man in der AG lernt. Für Smaba sind keinerlei Vorkenntnisse notwendig.Empfohlen wird sie für alle Schüler des 6. Jahrgangs und höher.', 'Microsoft Small Basic', '', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `moduletoinstitution`
--

CREATE TABLE `moduletoinstitution` (
  `ModuleID` int(11) NOT NULL,
  `InstitutionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transcribedtags`
--

CREATE TABLE `transcribedtags` (
  `sForm` varchar(255) NOT NULL,
  `sParameters` varchar(255) NOT NULL,
  `sInto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `sID` varchar(60) DEFAULT NULL,
  `sUsername` varchar(20) NOT NULL,
  `sFirstName` varchar(50) NOT NULL,
  `sLastName` varchar(50) NOT NULL,
  `sEMail` varchar(255) NOT NULL,
  `sHashedPassword` varchar(60) NOT NULL,
  `sProfilePicture` varchar(255) NOT NULL,
  `bIsVerified` tinyint(1) NOT NULL,
  `bIsAdmin` tinyint(1) NOT NULL,
  `bIsOnline` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usertogroup`
--

CREATE TABLE `usertogroup` (
  `iFortschritt` int(11) NOT NULL,
  `bIsTrainer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usertoinstitution`
--

CREATE TABLE `usertoinstitution` (
  `bIsInstitutionleader` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `handins`
--
ALTER TABLE `handins`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `chapters`
--
ALTER TABLE `chapters`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `groups`
--
ALTER TABLE `groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `handins`
--
ALTER TABLE `handins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `institutions`
--
ALTER TABLE `institutions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `modules`
--
ALTER TABLE `modules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
