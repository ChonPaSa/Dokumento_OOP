-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Nov 2018 um 10:50
-- Server-Version: 10.1.31-MariaDB
-- PHP-Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `documents`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `catID` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`catID`, `name`) VALUES
(1, 'Rechnung'),
(2, 'Abmahnung'),
(3, 'Vertrag'),
(4, 'Zugangsdaten');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `documents`
--

CREATE TABLE `documents` (
  `docID` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int(10) UNSIGNED NOT NULL,
  `timestamp` datetime NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `documents`
--

INSERT INTO `documents` (`docID`, `name`, `url`, `category`, `timestamp`, `location`, `contact`) VALUES
(1, 'Strom Rechnung', 'data/uploads/doc_5bd6db024ffb0.gif', 1, '2018-10-29 00:00:00', '2018 Rechungen Ordner', 'MyStrom\r\n123455 Stadt'),
(2, 'Abmahnung', 'data/uploads/doc_5bd6db51ca0ec.pdf', 2, '2018-10-29 00:00:00', 'Schwarze Kiste', 'Cobrador\r\nCalle lado\r\n203847 Ciudad'),
(3, 'Arbeitsvertrag', 'data/uploads/doc_5bd6db9479043.jpg', 3, '2018-10-29 00:00:00', 'Rote Ordner', 'My Arbeitgeber\r\nIrgendwo'),
(4, 'Muster für Kundeverträge', 'data/uploads/doc_5bd6dbc6942a0.pdf', 3, '2018-10-29 00:00:00', 'Rote Ordner', ''),
(5, 'Miete vertrag', 'data/uploads/doc_5bd6dbf850e2f.pdf', 3, '2018-10-29 00:00:00', 'Schwarze Kiste', 'Hausverwaltung\r\nBreite str 12\r\n98765 bb'),
(6, 'Gas Rechnung 03/2018', 'data/uploads/doc_5bd6dc5cd5b76.gif', 1, '2018-10-29 00:00:00', 'Schrank unter', 'Gas&apos;o&apos;Gas\r\ngasometer str 2\r\n456 gastadt'),
(7, 'Tierarzt Abmahnung', 'data/uploads/doc_5bd6dca42f960.pdf', 2, '2018-10-29 00:00:00', 'Sand kiste', 'Kats Kats Kats\r\nMiaustr 123\r\nPawstadt'),
(8, 'Gas Rechnung 02/2018', 'data/uploads/doc_5bd6dd109ab7a.gif', 1, '2018-10-29 00:00:00', 'Schwarze Kiste', 'Gas&apos;o&apos;Ga\r\ngasometer str 2\r\n456gastadt'),
(9, 'Strom 2017', 'data/uploads/doc_5bd6dd5a8b524.pdf', 1, '2017-10-29 00:00:00', '2018 Rechungen Ordner', 'Elektro spark\r\nBlitzstr 11111\r\n12355 bakdj'),
(10, '2016 Strom Rechnung', 'data/uploads/doc_5bd6dd8e9a1b6.gif', 1, '2016-10-29 00:00:00', 'Rechungen Ordner', 'Elektro spark\r\nBlitzstr 11111\r\n12355 bakdj'),
(11, '2016 Gas Rechnung', 'data/uploads/doc_5bd6ddac9458a.pdf', 1, '2016-10-29 00:00:00', 'Rechungen Ordner', 'Elektro spark\r\nBlitzstr 11111'),
(12, 'Abmahnung Telefon', 'data/uploads/doc_5bd6ddc7b3520.pdf', 2, '2017-10-29 00:00:00', 'Rote Ordner', 'Handy spark\r\nBlitzstr 11111\r\n12355 bakdj'),
(13, 'Rechnung 01/2018', 'data/uploads/doc_5bdc1d41d56f9.gif', 1, '2018-01-02 00:00:00', 'dort', 'Straße bla\r\nStadt blo');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `labels`
--

CREATE TABLE `labels` (
  `labID` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `labels`
--

INSERT INTO `labels` (`labID`, `name`) VALUES
(1, 'In Bearbeitung'),
(2, 'Bezahlt'),
(3, 'Antwort erwartet'),
(5, 'Erledigt'),
(6, 'Wichtig!');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mapping_labels`
--

CREATE TABLE `mapping_labels` (
  `docID` int(10) UNSIGNED NOT NULL,
  `labID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `mapping_labels`
--

INSERT INTO `mapping_labels` (`docID`, `labID`) VALUES
(1, 2),
(1, 5),
(2, 1),
(3, 5),
(4, 1),
(5, 5),
(6, 1),
(6, 3),
(7, 1),
(8, 2),
(9, 2),
(10, 2),
(10, 5),
(11, 2),
(11, 5),
(12, 1),
(12, 3),
(13, 1),
(13, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `userID` int(10) UNSIGNED NOT NULL,
  `userName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `familyName` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`userID`, `userName`, `email`, `name`, `familyName`, `password`) VALUES
(1, 'pardo', 'bla@bla.com', 'ascension', 'pardo', '$2y$10$GVCEjjBMs4s758pYT5dhF.ufqg2BxHN4WjgYbCh1jOnXQXN1g6UyW');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catID`);

--
-- Indizes für die Tabelle `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`docID`),
  ADD KEY `category` (`category`);

--
-- Indizes für die Tabelle `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`labID`);

--
-- Indizes für die Tabelle `mapping_labels`
--
ALTER TABLE `mapping_labels`
  ADD UNIQUE KEY `docID_2` (`docID`,`labID`),
  ADD KEY `docID` (`docID`),
  ADD KEY `labID` (`labID`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `catID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `documents`
--
ALTER TABLE `documents`
  MODIFY `docID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `labels`
--
ALTER TABLE `labels`
  MODIFY `labID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
