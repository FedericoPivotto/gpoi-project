-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 21, 2020 alle 22:49
-- Versione del server: 10.4.8-MariaDB
-- Versione PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_gestionalechimica`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `aspetto`
--

CREATE TABLE `aspetto` (
  `idAspetto` int(10) UNSIGNED NOT NULL,
  `statoMateria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(10) UNSIGNED NOT NULL,
  `nomeCategoria` varchar(50) NOT NULL,
  `descrizione` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `collocazionefisica`
--

CREATE TABLE `collocazionefisica` (
  `idCollocazione` int(10) UNSIGNED NOT NULL,
  `siglaStanza` varchar(50) NOT NULL,
  `descrizione` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `dittaproduttrice`
--

CREATE TABLE `dittaproduttrice` (
  `idDitta` int(10) UNSIGNED NOT NULL,
  `nomeDitta` varchar(50) NOT NULL,
  `indirizzo` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `email` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `esperienzadidattica`
--

CREATE TABLE `esperienzadidattica` (
  `idEsperienza` int(10) UNSIGNED NOT NULL,
  `nomeEsperienza` varchar(100) NOT NULL,
  `linkEsperienza` longtext NOT NULL COMMENT 'prima era "esperienzaLink"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `manualeistruzioni`
--

CREATE TABLE `manualeistruzioni` (
  `idManuale` int(10) UNSIGNED NOT NULL,
  `nomeManuale` varchar(100) NOT NULL,
  `dataRilascio` date NOT NULL,
  `linkManuale` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `modalitaconservazione`
--

CREATE TABLE `modalitaconservazione` (
  `idModalita` int(10) UNSIGNED NOT NULL,
  `modalita` varchar(50) NOT NULL,
  `temperatura` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `pittogrammasicurezza`
--

CREATE TABLE `pittogrammasicurezza` (
  `idPittogramma` int(10) UNSIGNED NOT NULL,
  `simbolo` longtext NOT NULL,
  `fraseRischio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `possiede_r_p`
--

CREATE TABLE `possiede_r_p` (
  `idReagente` int(10) UNSIGNED NOT NULL,
  `idPittogramma` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `prevede_r_e`
--

CREATE TABLE `prevede_r_e` (
  `idReagente` int(10) UNSIGNED NOT NULL,
  `idEsperienza` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `punto`
--

CREATE TABLE `punto` (
  `idPunto` int(10) UNSIGNED NOT NULL,
  `siglaPunto` varchar(50) NOT NULL,
  `codiceQr` longtext NOT NULL,
  `idCollocazione` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `quantitar`
--

CREATE TABLE `quantitar` (
  `idQuantitaR` int(10) UNSIGNED NOT NULL,
  `quantita` varchar(50) NOT NULL,
  `dataVerifica` date NOT NULL,
  `dataScadenza` date DEFAULT NULL,
  `idRipiano` int(11) UNSIGNED NOT NULL,
  `idReagente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `quantitasa`
--

CREATE TABLE `quantitasa` (
  `idQuantitaSA` int(10) UNSIGNED NOT NULL,
  `quantita` varchar(50) NOT NULL,
  `dataVerifica` date NOT NULL,
  `dataScadenza` date DEFAULT NULL,
  `idRipiano` int(11) UNSIGNED NOT NULL,
  `idSA` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `quantitava`
--

CREATE TABLE `quantitava` (
  `idQuantitaVA` int(10) UNSIGNED NOT NULL,
  `quantita` varchar(50) NOT NULL,
  `dataVerifica` date NOT NULL,
  `dataScadenza` date DEFAULT NULL,
  `idRipiano` int(11) UNSIGNED NOT NULL,
  `idVA` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `reagente`
--

CREATE TABLE `reagente` (
  `idReagente` int(11) UNSIGNED NOT NULL,
  `nomeReagente` varchar(100) NOT NULL,
  `formulaChimica` varchar(50) NOT NULL,
  `idAspetto` int(11) UNSIGNED NOT NULL,
  `idDitta` int(11) UNSIGNED NOT NULL,
  `idModalita` int(11) UNSIGNED NOT NULL,
  `idScheda` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `riparazione`
--

CREATE TABLE `riparazione` (
  `idRiparazione` int(10) UNSIGNED NOT NULL,
  `motivazione` longtext NOT NULL,
  `dataRiparazione` date NOT NULL,
  `idSA` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `ripiano`
--

CREATE TABLE `ripiano` (
  `idRipiano` int(10) UNSIGNED NOT NULL,
  `numeroRipiano` varchar(50) NOT NULL,
  `idPunto` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `schedasicurezza`
--

CREATE TABLE `schedasicurezza` (
  `idScheda` int(10) UNSIGNED NOT NULL,
  `nomeScheda` varchar(100) NOT NULL,
  `dataRilascio` date NOT NULL,
  `linkScheda` longtext NOT NULL COMMENT 'può essere vuoto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `situato_m_c`
--

CREATE TABLE `situato_m_c` (
  `idManuale` int(10) UNSIGNED NOT NULL,
  `idRipiano` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `situato_s_c`
--

CREATE TABLE `situato_s_c` (
  `idScheda` int(10) UNSIGNED NOT NULL,
  `idRipiano` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `storicomanutenzione_ordinaria`
--

CREATE TABLE `storicomanutenzione_ordinaria` (
  `idStoricoOrd` int(10) UNSIGNED NOT NULL,
  `azione` longtext NOT NULL,
  `dataManutenzione` date NOT NULL,
  `idSA` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `storicomanutenzione_straordinaria`
--

CREATE TABLE `storicomanutenzione_straordinaria` (
  `idStoricoStra` int(10) UNSIGNED NOT NULL,
  `azione` longtext NOT NULL,
  `dataManutenzione` date NOT NULL,
  `idSA` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `strumentazione_apparecchiatura`
--

CREATE TABLE `strumentazione_apparecchiatura` (
  `idSA` int(10) UNSIGNED NOT NULL,
  `nomeSA` varchar(100) NOT NULL COMMENT 'prima era "tipo"',
  `caratteristicaTecnica` longtext NOT NULL,
  `numeroInventario` varchar(50) NOT NULL,
  `idManuale` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `token`
--

CREATE TABLE `token` (
  `idToken` int(10) UNSIGNED NOT NULL,
  `token` longtext NOT NULL,
  `scadenza` datetime NOT NULL,
  `idUtente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `idUtente` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `idCategoria` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `vetreria_attrezzatura`
--

CREATE TABLE `vetreria_attrezzatura` (
  `idVA` int(10) UNSIGNED NOT NULL,
  `nomeVA` varchar(100) NOT NULL COMMENT 'prima era "tipo"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `aspetto`
--
ALTER TABLE `aspetto`
  ADD PRIMARY KEY (`idAspetto`),
  ADD UNIQUE KEY `statoMateria` (`statoMateria`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`),
  ADD UNIQUE KEY `nomeCategoria` (`nomeCategoria`);

--
-- Indici per le tabelle `collocazionefisica`
--
ALTER TABLE `collocazionefisica`
  ADD PRIMARY KEY (`idCollocazione`),
  ADD UNIQUE KEY `siglaStanza` (`siglaStanza`);

--
-- Indici per le tabelle `dittaproduttrice`
--
ALTER TABLE `dittaproduttrice`
  ADD PRIMARY KEY (`idDitta`),
  ADD UNIQUE KEY `nomeDitta` (`nomeDitta`);

--
-- Indici per le tabelle `esperienzadidattica`
--
ALTER TABLE `esperienzadidattica`
  ADD PRIMARY KEY (`idEsperienza`),
  ADD UNIQUE KEY `nomeEsperienza` (`nomeEsperienza`);

--
-- Indici per le tabelle `manualeistruzioni`
--
ALTER TABLE `manualeistruzioni`
  ADD PRIMARY KEY (`idManuale`),
  ADD UNIQUE KEY `nomeManuale` (`nomeManuale`);

--
-- Indici per le tabelle `modalitaconservazione`
--
ALTER TABLE `modalitaconservazione`
  ADD PRIMARY KEY (`idModalita`),
  ADD UNIQUE KEY `modalita` (`modalita`);

--
-- Indici per le tabelle `pittogrammasicurezza`
--
ALTER TABLE `pittogrammasicurezza`
  ADD PRIMARY KEY (`idPittogramma`);

--
-- Indici per le tabelle `possiede_r_p`
--
ALTER TABLE `possiede_r_p`
  ADD PRIMARY KEY (`idReagente`,`idPittogramma`),
  ADD KEY `idPittogramma` (`idPittogramma`);

--
-- Indici per le tabelle `prevede_r_e`
--
ALTER TABLE `prevede_r_e`
  ADD PRIMARY KEY (`idReagente`,`idEsperienza`),
  ADD KEY `idEsperienza` (`idEsperienza`);

--
-- Indici per le tabelle `punto`
--
ALTER TABLE `punto`
  ADD PRIMARY KEY (`idPunto`),
  ADD UNIQUE KEY `siglaPunto` (`siglaPunto`),
  ADD KEY `idCollocazione` (`idCollocazione`);

--
-- Indici per le tabelle `quantitar`
--
ALTER TABLE `quantitar`
  ADD PRIMARY KEY (`idQuantitaR`),
  ADD KEY `idReagente` (`idReagente`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `quantitasa`
--
ALTER TABLE `quantitasa`
  ADD PRIMARY KEY (`idQuantitaSA`),
  ADD KEY `idSA` (`idSA`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `quantitava`
--
ALTER TABLE `quantitava`
  ADD PRIMARY KEY (`idQuantitaVA`),
  ADD KEY `idVA` (`idVA`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `reagente`
--
ALTER TABLE `reagente`
  ADD PRIMARY KEY (`idReagente`),
  ADD UNIQUE KEY `nomeReagente` (`nomeReagente`,`formulaChimica`),
  ADD KEY `idAspetto` (`idAspetto`),
  ADD KEY `idDitta` (`idDitta`),
  ADD KEY `idModalita` (`idModalita`),
  ADD KEY `idScheda` (`idScheda`);

--
-- Indici per le tabelle `riparazione`
--
ALTER TABLE `riparazione`
  ADD PRIMARY KEY (`idRiparazione`),
  ADD KEY `idSA` (`idSA`);

--
-- Indici per le tabelle `ripiano`
--
ALTER TABLE `ripiano`
  ADD PRIMARY KEY (`idRipiano`),
  ADD UNIQUE KEY `numeroRipiano` (`numeroRipiano`),
  ADD KEY `idPunto` (`idPunto`);

--
-- Indici per le tabelle `schedasicurezza`
--
ALTER TABLE `schedasicurezza`
  ADD PRIMARY KEY (`idScheda`),
  ADD UNIQUE KEY `nomeScheda` (`nomeScheda`);

--
-- Indici per le tabelle `situato_m_c`
--
ALTER TABLE `situato_m_c`
  ADD PRIMARY KEY (`idManuale`,`idRipiano`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `situato_s_c`
--
ALTER TABLE `situato_s_c`
  ADD PRIMARY KEY (`idScheda`,`idRipiano`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `storicomanutenzione_ordinaria`
--
ALTER TABLE `storicomanutenzione_ordinaria`
  ADD PRIMARY KEY (`idStoricoOrd`),
  ADD KEY `idSA` (`idSA`) USING BTREE;

--
-- Indici per le tabelle `storicomanutenzione_straordinaria`
--
ALTER TABLE `storicomanutenzione_straordinaria`
  ADD PRIMARY KEY (`idStoricoStra`),
  ADD KEY `idSA` (`idSA`);

--
-- Indici per le tabelle `strumentazione_apparecchiatura`
--
ALTER TABLE `strumentazione_apparecchiatura`
  ADD PRIMARY KEY (`idSA`),
  ADD UNIQUE KEY `nomeSA` (`nomeSA`,`numeroInventario`),
  ADD KEY `idManuale` (`idManuale`);

--
-- Indici per le tabelle `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`idToken`),
  ADD KEY `idUtente` (`idUtente`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`idUtente`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indici per le tabelle `vetreria_attrezzatura`
--
ALTER TABLE `vetreria_attrezzatura`
  ADD PRIMARY KEY (`idVA`),
  ADD UNIQUE KEY `nomeVA` (`nomeVA`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `aspetto`
--
ALTER TABLE `aspetto`
  MODIFY `idAspetto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `collocazionefisica`
--
ALTER TABLE `collocazionefisica`
  MODIFY `idCollocazione` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `dittaproduttrice`
--
ALTER TABLE `dittaproduttrice`
  MODIFY `idDitta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `esperienzadidattica`
--
ALTER TABLE `esperienzadidattica`
  MODIFY `idEsperienza` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `manualeistruzioni`
--
ALTER TABLE `manualeistruzioni`
  MODIFY `idManuale` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `modalitaconservazione`
--
ALTER TABLE `modalitaconservazione`
  MODIFY `idModalita` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `pittogrammasicurezza`
--
ALTER TABLE `pittogrammasicurezza`
  MODIFY `idPittogramma` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `punto`
--
ALTER TABLE `punto`
  MODIFY `idPunto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `quantitar`
--
ALTER TABLE `quantitar`
  MODIFY `idQuantitaR` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `quantitasa`
--
ALTER TABLE `quantitasa`
  MODIFY `idQuantitaSA` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `quantitava`
--
ALTER TABLE `quantitava`
  MODIFY `idQuantitaVA` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `reagente`
--
ALTER TABLE `reagente`
  MODIFY `idReagente` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `riparazione`
--
ALTER TABLE `riparazione`
  MODIFY `idRiparazione` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ripiano`
--
ALTER TABLE `ripiano`
  MODIFY `idRipiano` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `schedasicurezza`
--
ALTER TABLE `schedasicurezza`
  MODIFY `idScheda` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `storicomanutenzione_ordinaria`
--
ALTER TABLE `storicomanutenzione_ordinaria`
  MODIFY `idStoricoOrd` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `storicomanutenzione_straordinaria`
--
ALTER TABLE `storicomanutenzione_straordinaria`
  MODIFY `idStoricoStra` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `strumentazione_apparecchiatura`
--
ALTER TABLE `strumentazione_apparecchiatura`
  MODIFY `idSA` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `token`
--
ALTER TABLE `token`
  MODIFY `idToken` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `idUtente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `vetreria_attrezzatura`
--
ALTER TABLE `vetreria_attrezzatura`
  MODIFY `idVA` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `possiede_r_p`
--
ALTER TABLE `possiede_r_p`
  ADD CONSTRAINT `possiede_r_p_ibfk_1` FOREIGN KEY (`idReagente`) REFERENCES `reagente` (`idReagente`),
  ADD CONSTRAINT `possiede_r_p_ibfk_2` FOREIGN KEY (`idPittogramma`) REFERENCES `pittogrammasicurezza` (`idPittogramma`);

--
-- Limiti per la tabella `prevede_r_e`
--
ALTER TABLE `prevede_r_e`
  ADD CONSTRAINT `prevede_r_e_ibfk_1` FOREIGN KEY (`idReagente`) REFERENCES `reagente` (`idReagente`),
  ADD CONSTRAINT `prevede_r_e_ibfk_2` FOREIGN KEY (`idEsperienza`) REFERENCES `esperienzadidattica` (`idEsperienza`);

--
-- Limiti per la tabella `punto`
--
ALTER TABLE `punto`
  ADD CONSTRAINT `punto_ibfk_1` FOREIGN KEY (`idCollocazione`) REFERENCES `collocazionefisica` (`idCollocazione`);

--
-- Limiti per la tabella `quantitar`
--
ALTER TABLE `quantitar`
  ADD CONSTRAINT `quantitar_ibfk_1` FOREIGN KEY (`idReagente`) REFERENCES `reagente` (`idReagente`),
  ADD CONSTRAINT `quantitar_ibfk_2` FOREIGN KEY (`idRipiano`) REFERENCES `ripiano` (`idRipiano`);

--
-- Limiti per la tabella `quantitasa`
--
ALTER TABLE `quantitasa`
  ADD CONSTRAINT `quantitasa_ibfk_1` FOREIGN KEY (`idSA`) REFERENCES `strumentazione_apparecchiatura` (`idSA`),
  ADD CONSTRAINT `quantitasa_ibfk_2` FOREIGN KEY (`idRipiano`) REFERENCES `ripiano` (`idRipiano`);

--
-- Limiti per la tabella `quantitava`
--
ALTER TABLE `quantitava`
  ADD CONSTRAINT `quantitava_ibfk_1` FOREIGN KEY (`idVA`) REFERENCES `vetreria_attrezzatura` (`idVA`),
  ADD CONSTRAINT `quantitava_ibfk_2` FOREIGN KEY (`idRipiano`) REFERENCES `ripiano` (`idRipiano`);

--
-- Limiti per la tabella `reagente`
--
ALTER TABLE `reagente`
  ADD CONSTRAINT `reagente_ibfk_1` FOREIGN KEY (`idAspetto`) REFERENCES `aspetto` (`idAspetto`),
  ADD CONSTRAINT `reagente_ibfk_2` FOREIGN KEY (`idDitta`) REFERENCES `dittaproduttrice` (`idDitta`),
  ADD CONSTRAINT `reagente_ibfk_3` FOREIGN KEY (`idModalita`) REFERENCES `modalitaconservazione` (`idModalita`),
  ADD CONSTRAINT `reagente_ibfk_4` FOREIGN KEY (`idScheda`) REFERENCES `schedasicurezza` (`idScheda`);

--
-- Limiti per la tabella `riparazione`
--
ALTER TABLE `riparazione`
  ADD CONSTRAINT `riparazione_ibfk_1` FOREIGN KEY (`idSA`) REFERENCES `strumentazione_apparecchiatura` (`idSA`);

--
-- Limiti per la tabella `ripiano`
--
ALTER TABLE `ripiano`
  ADD CONSTRAINT `ripiano_ibfk_1` FOREIGN KEY (`idPunto`) REFERENCES `punto` (`idPunto`);

--
-- Limiti per la tabella `situato_m_c`
--
ALTER TABLE `situato_m_c`
  ADD CONSTRAINT `situato_m_c_ibfk_1` FOREIGN KEY (`idManuale`) REFERENCES `manualeistruzioni` (`idManuale`),
  ADD CONSTRAINT `situato_m_c_ibfk_2` FOREIGN KEY (`idRipiano`) REFERENCES `ripiano` (`idRipiano`);

--
-- Limiti per la tabella `situato_s_c`
--
ALTER TABLE `situato_s_c`
  ADD CONSTRAINT `situato_s_c_ibfk_1` FOREIGN KEY (`idScheda`) REFERENCES `schedasicurezza` (`idScheda`),
  ADD CONSTRAINT `situato_s_c_ibfk_2` FOREIGN KEY (`idRipiano`) REFERENCES `ripiano` (`idRipiano`);

--
-- Limiti per la tabella `storicomanutenzione_ordinaria`
--
ALTER TABLE `storicomanutenzione_ordinaria`
  ADD CONSTRAINT `storicomanutenzione_ordinaria_ibfk_1` FOREIGN KEY (`idSA`) REFERENCES `strumentazione_apparecchiatura` (`idSA`);

--
-- Limiti per la tabella `storicomanutenzione_straordinaria`
--
ALTER TABLE `storicomanutenzione_straordinaria`
  ADD CONSTRAINT `storicomanutenzione_straordinaria_ibfk_1` FOREIGN KEY (`idSA`) REFERENCES `strumentazione_apparecchiatura` (`idSA`);

--
-- Limiti per la tabella `strumentazione_apparecchiatura`
--
ALTER TABLE `strumentazione_apparecchiatura`
  ADD CONSTRAINT `strumentazione_apparecchiatura_ibfk_1` FOREIGN KEY (`idManuale`) REFERENCES `manualeistruzioni` (`idManuale`);

--
-- Limiti per la tabella `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utente` (`idUtente`);

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
