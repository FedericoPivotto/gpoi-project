-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 19, 2020 alle 21:41
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

--
-- Dump dei dati per la tabella `aspetto`
--

INSERT INTO `aspetto` (`idAspetto`, `statoMateria`) VALUES
(1, 'statoMateria_01'),
(2, 'statoMateria_02'),
(3, 'statoMateria_03');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(10) UNSIGNED NOT NULL,
  `nomeCategoria` varchar(50) NOT NULL,
  `descrizione` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nomeCategoria`, `descrizione`) VALUES
(1, 'Amministratore', 'Tutto'),
(2, 'Studente', 'Consulta'),
(3, 'ITP', 'Consulta e Modifica'),
(4, 'Docente', 'Consulta, Modifica e Aggiunta');

-- --------------------------------------------------------

--
-- Struttura della tabella `collocazionefisica`
--

CREATE TABLE `collocazionefisica` (
  `idCollocazione` int(10) UNSIGNED NOT NULL,
  `siglaStanza` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `collocazionefisica`
--

INSERT INTO `collocazionefisica` (`idCollocazione`, `siglaStanza`) VALUES
(1, 'siglaStanza_01'),
(2, 'siglaStanza_02'),
(3, 'siglaStanza_03');

-- --------------------------------------------------------

--
-- Struttura della tabella `dittaproduttrice`
--

CREATE TABLE `dittaproduttrice` (
  `idDitta` int(10) UNSIGNED NOT NULL,
  `nomeDitta` varchar(50) NOT NULL,
  `indirizzo` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dittaproduttrice`
--

INSERT INTO `dittaproduttrice` (`idDitta`, `nomeDitta`, `indirizzo`, `telefono`, `email`) VALUES
(1, 'nomeDitta_01', 'indirizzo_01', 'telefono_01', 'email_01'),
(2, 'nomeDitta_02', 'indirizzo_02', 'telefono_02', 'email_02'),
(3, 'nomeDitta_03', 'indirizzo_03', 'telefono_03', 'email_03');

-- --------------------------------------------------------

--
-- Struttura della tabella `esperienzadidattica`
--

CREATE TABLE `esperienzadidattica` (
  `idEsperienza` int(10) UNSIGNED NOT NULL,
  `nomeEsperienza` varchar(100) NOT NULL,
  `linkEsperienza` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `esperienzadidattica`
--

INSERT INTO `esperienzadidattica` (`idEsperienza`, `nomeEsperienza`, `linkEsperienza`) VALUES
(1, 'nomeEsperienza_01', 'linkEsperienza_01'),
(2, 'nomeEsperienza_02', 'linkEsperienza_02'),
(3, 'nomeEsperienza_03', 'linkEsperienza_03');

-- --------------------------------------------------------

--
-- Struttura della tabella `inventario`
--

CREATE TABLE `inventario` (
  `idInventario` int(10) UNSIGNED NOT NULL,
  `numeroInventario` varchar(50) NOT NULL,
  `idSA` int(10) UNSIGNED NOT NULL,
  `idRipiano` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `inventario`
--

INSERT INTO `inventario` (`idInventario`, `numeroInventario`, `idSA`, `idRipiano`) VALUES
(1, 'numeroInventario_01', 1, 1),
(2, 'numeroInventario_02', 2, 2),
(3, 'numeroInventario_03', 3, 3);

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

--
-- Dump dei dati per la tabella `manualeistruzioni`
--

INSERT INTO `manualeistruzioni` (`idManuale`, `nomeManuale`, `dataRilascio`, `linkManuale`) VALUES
(1, 'nomeManuale_01', '2020-03-14', 'linkManuale_01'),
(2, 'nomeManuale_02', '2020-03-14', 'linkManuale_02'),
(3, 'nomeManuale_03', '2020-03-14', 'linkManuale_03');

-- --------------------------------------------------------

--
-- Struttura della tabella `modalitaconservazione`
--

CREATE TABLE `modalitaconservazione` (
  `idModalita` int(10) UNSIGNED NOT NULL,
  `modalita` varchar(50) NOT NULL,
  `temperatura` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `modalitaconservazione`
--

INSERT INTO `modalitaconservazione` (`idModalita`, `modalita`, `temperatura`) VALUES
(1, 'modalita_01', 'temperatura_01'),
(2, 'modalita_02', 'temperatura_02'),
(3, 'modalita_03', 'temperatura_03');

-- --------------------------------------------------------

--
-- Struttura della tabella `pittogrammasicurezza`
--

CREATE TABLE `pittogrammasicurezza` (
  `idPittogramma` int(10) UNSIGNED NOT NULL,
  `linkSimbolo` longtext NOT NULL,
  `fraseRischio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `pittogrammasicurezza`
--

INSERT INTO `pittogrammasicurezza` (`idPittogramma`, `linkSimbolo`, `fraseRischio`) VALUES
(1, 'media/pittogrammi/comburente.svg', 'Comburente'),
(2, 'media/pittogrammi/corrosivo.svg', 'Corrosivo'),
(3, 'media/pittogrammi/esplosivo.svg', 'Esplosivo'),
(4, 'media/pittogrammi/gas_pressurizzato.svg', 'Gas pressurizzato'),
(5, 'media/pittogrammi/infiammabile.svg', 'Infiammabile'),
(6, 'media/pittogrammi/irritante.svg', 'Irritante'),
(7, 'media/pittogrammi/nocivo.svg', 'Nocivo'),
(8, 'media/pittogrammi/nocivo_ambiente.svg', 'Nocivo per l\'ambiente'),
(9, 'media/pittogrammi/tossico.svg', 'Tossico');

-- --------------------------------------------------------

--
-- Struttura della tabella `possiede_r_p`
--

CREATE TABLE `possiede_r_p` (
  `idReagente` int(10) UNSIGNED NOT NULL,
  `idPittogramma` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `possiede_r_p`
--

INSERT INTO `possiede_r_p` (`idReagente`, `idPittogramma`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `prevede_r_e`
--

CREATE TABLE `prevede_r_e` (
  `idReagente` int(10) UNSIGNED NOT NULL,
  `idEsperienza` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prevede_r_e`
--

INSERT INTO `prevede_r_e` (`idReagente`, `idEsperienza`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `punto`
--

CREATE TABLE `punto` (
  `idPunto` int(10) UNSIGNED NOT NULL,
  `siglaPunto` varchar(50) NOT NULL,
  `codiceQr` longtext DEFAULT NULL,
  `idCollocazione` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `punto`
--

INSERT INTO `punto` (`idPunto`, `siglaPunto`, `codiceQr`, `idCollocazione`) VALUES
(1, 'siglaPunto_01', 'codiceQr_01', 1),
(2, 'siglaPunto_02', 'codiceQr_02', 2),
(3, 'siglaPunto_03', 'codiceQr_03', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `quantitar`
--

CREATE TABLE `quantitar` (
  `idReagente` int(10) UNSIGNED NOT NULL,
  `idRipiano` int(10) UNSIGNED NOT NULL,
  `quantita` varchar(50) NOT NULL,
  `dataVerifica` date NOT NULL,
  `dataScadenza` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `quantitar`
--

INSERT INTO `quantitar` (`idReagente`, `idRipiano`, `quantita`, `dataVerifica`, `dataScadenza`) VALUES
(1, 1, '1', '2020-05-14', '2020-05-14'),
(2, 2, '1', '2020-05-14', '2020-05-14'),
(3, 3, '1', '2020-05-14', '2020-05-14');

-- --------------------------------------------------------

--
-- Struttura della tabella `quantitasa`
--

CREATE TABLE `quantitasa` (
  `idSA` int(10) UNSIGNED NOT NULL,
  `idRipiano` int(10) UNSIGNED NOT NULL,
  `quantita` varchar(50) NOT NULL,
  `dataVerifica` date NOT NULL,
  `dataScadenza` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `quantitasa`
--

INSERT INTO `quantitasa` (`idSA`, `idRipiano`, `quantita`, `dataVerifica`, `dataScadenza`) VALUES
(1, 1, '1', '2020-03-14', '2020-03-14'),
(2, 2, '1', '2020-03-14', '2020-03-14'),
(3, 3, '1', '2020-03-14', '2020-03-14');

-- --------------------------------------------------------

--
-- Struttura della tabella `quantitava`
--

CREATE TABLE `quantitava` (
  `idVA` int(10) UNSIGNED NOT NULL,
  `idRipiano` int(10) UNSIGNED NOT NULL,
  `quantita` varchar(50) NOT NULL,
  `dataVerifica` date NOT NULL,
  `dataScadenza` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `quantitava`
--

INSERT INTO `quantitava` (`idVA`, `idRipiano`, `quantita`, `dataVerifica`, `dataScadenza`) VALUES
(1, 1, '1', '2020-03-14', '2020-03-14'),
(2, 2, '1', '2020-03-14', '2020-03-14'),
(3, 3, '1', '2020-03-14', '2020-03-14');

-- --------------------------------------------------------

--
-- Struttura della tabella `reagente`
--

CREATE TABLE `reagente` (
  `idReagente` int(10) UNSIGNED NOT NULL,
  `nomeReagente` varchar(100) NOT NULL,
  `formulaChimica` varchar(50) NOT NULL,
  `idAspetto` int(10) UNSIGNED NOT NULL,
  `idDitta` int(10) UNSIGNED NOT NULL,
  `idModalita` int(10) UNSIGNED NOT NULL,
  `idScheda` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `reagente`
--

INSERT INTO `reagente` (`idReagente`, `nomeReagente`, `formulaChimica`, `idAspetto`, `idDitta`, `idModalita`, `idScheda`) VALUES
(1, 'nomeReagente_01', 'formulaChimica_01', 1, 1, 1, 1),
(2, 'nomeReagente_02', 'formulaChimica_02', 2, 2, 2, 2),
(3, 'nomeReagente_03', 'formulaChimica_03', 3, 3, 3, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `riparazione`
--

CREATE TABLE `riparazione` (
  `idRiparazione` int(10) UNSIGNED NOT NULL,
  `motivazione` longtext NOT NULL,
  `dataRiparazione` date NOT NULL,
  `idInventario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `riparazione`
--

INSERT INTO `riparazione` (`idRiparazione`, `motivazione`, `dataRiparazione`, `idInventario`) VALUES
(1, 'testo_01', '2020-03-14', 1),
(2, 'testo_02', '2020-03-14', 2),
(3, 'testo_03', '2020-03-14', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `ripiano`
--

CREATE TABLE `ripiano` (
  `idRipiano` int(10) UNSIGNED NOT NULL,
  `siglaRipiano` varchar(50) NOT NULL,
  `idPunto` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ripiano`
--

INSERT INTO `ripiano` (`idRipiano`, `siglaRipiano`, `idPunto`) VALUES
(1, 'siglaRipiano_01', 1),
(2, 'siglaRipiano_02', 2),
(3, 'siglaRipiano_03', 3);

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

--
-- Dump dei dati per la tabella `schedasicurezza`
--

INSERT INTO `schedasicurezza` (`idScheda`, `nomeScheda`, `dataRilascio`, `linkScheda`) VALUES
(1, 'nomeScheda_01', '2020-03-14', 'linkScheda_01'),
(2, 'nomeScheda_02', '2020-03-14', 'linkScheda_02'),
(3, 'nomeScheda_03', '2020-03-14', 'linkScheda_03');

-- --------------------------------------------------------

--
-- Struttura della tabella `situato_m_r`
--

CREATE TABLE `situato_m_r` (
  `idManuale` int(10) UNSIGNED NOT NULL,
  `idRipiano` int(10) UNSIGNED NOT NULL,
  `quantita` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `situato_m_r`
--

INSERT INTO `situato_m_r` (`idManuale`, `idRipiano`, `quantita`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `situato_s_r`
--

CREATE TABLE `situato_s_r` (
  `idScheda` int(10) UNSIGNED NOT NULL,
  `idRipiano` int(10) UNSIGNED NOT NULL,
  `quantita` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `situato_s_r`
--

INSERT INTO `situato_s_r` (`idScheda`, `idRipiano`, `quantita`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `storicomanutenzione_ordinaria`
--

CREATE TABLE `storicomanutenzione_ordinaria` (
  `idStoricoOrd` int(10) UNSIGNED NOT NULL,
  `azione` longtext NOT NULL,
  `dataManutenzione` date NOT NULL,
  `idInventario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `storicomanutenzione_ordinaria`
--

INSERT INTO `storicomanutenzione_ordinaria` (`idStoricoOrd`, `azione`, `dataManutenzione`, `idInventario`) VALUES
(1, 'azioneordinaria_01', '2020-03-14', 1),
(2, 'azioneordinaria_02', '2020-03-14', 2),
(3, 'azioneordinaria_03', '2020-03-14', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `storicomanutenzione_straordinaria`
--

CREATE TABLE `storicomanutenzione_straordinaria` (
  `idStoricoStra` int(10) UNSIGNED NOT NULL,
  `azione` longtext NOT NULL,
  `dataManutenzione` date NOT NULL,
  `idInventario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `storicomanutenzione_straordinaria`
--

INSERT INTO `storicomanutenzione_straordinaria` (`idStoricoStra`, `azione`, `dataManutenzione`, `idInventario`) VALUES
(1, 'azionestraordinaria_01', '2020-03-14', 1),
(2, 'azionestraordinaria_02', '2020-03-14', 2),
(3, 'azionestraordinaria_03', '2020-03-14', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `strumentazione_apparecchiatura`
--

CREATE TABLE `strumentazione_apparecchiatura` (
  `idSA` int(10) UNSIGNED NOT NULL,
  `nomeSA` varchar(100) NOT NULL,
  `caratteristicaTecnica` longtext NOT NULL,
  `idManuale` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `strumentazione_apparecchiatura`
--

INSERT INTO `strumentazione_apparecchiatura` (`idSA`, `nomeSA`, `caratteristicaTecnica`, `idManuale`) VALUES
(1, 'nomeSA_01', 'caratteristicaTecnica_01', 1),
(2, 'nomeSA_02', 'caratteristicaTecnica_02', 2),
(3, 'nomeSA_03', 'caratteristicaTecnica_03', 3);

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

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`idUtente`, `username`, `password`, `idCategoria`) VALUES
(1, 'admin_01', 'b2cdd380947330cab613d974492b8e26', 1),
(2, 'studente_02', '8d5ea2cbcbd5dcbec9f717c767834333', 2),
(3, 'itp_03', 'f6ebf43f91e0a6fac8d27bb7dfea19a2', 3),
(4, 'docente_04', '62f04ac333bda7fb0aa0e3475ca346bd', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `vetreria_attrezzatura`
--

CREATE TABLE `vetreria_attrezzatura` (
  `idVA` int(10) UNSIGNED NOT NULL,
  `nomeVA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `vetreria_attrezzatura`
--

INSERT INTO `vetreria_attrezzatura` (`idVA`, `nomeVA`) VALUES
(1, 'nomeVA_01'),
(2, 'nomeVA_02'),
(3, 'nomeVA_03');

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
  ADD PRIMARY KEY (`idDitta`);

--
-- Indici per le tabelle `esperienzadidattica`
--
ALTER TABLE `esperienzadidattica`
  ADD PRIMARY KEY (`idEsperienza`);

--
-- Indici per le tabelle `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idInventario`),
  ADD UNIQUE KEY `numeroInventario` (`numeroInventario`),
  ADD KEY `idRipiano` (`idRipiano`),
  ADD KEY `idSA` (`idSA`);

--
-- Indici per le tabelle `manualeistruzioni`
--
ALTER TABLE `manualeistruzioni`
  ADD PRIMARY KEY (`idManuale`);

--
-- Indici per le tabelle `modalitaconservazione`
--
ALTER TABLE `modalitaconservazione`
  ADD PRIMARY KEY (`idModalita`);

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
  ADD KEY `idCollocazione` (`idCollocazione`);

--
-- Indici per le tabelle `quantitar`
--
ALTER TABLE `quantitar`
  ADD PRIMARY KEY (`idRipiano`,`idReagente`),
  ADD KEY `idReagente` (`idReagente`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `quantitasa`
--
ALTER TABLE `quantitasa`
  ADD PRIMARY KEY (`idRipiano`,`idSA`),
  ADD KEY `idSA` (`idSA`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `quantitava`
--
ALTER TABLE `quantitava`
  ADD PRIMARY KEY (`idRipiano`,`idVA`),
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
  ADD KEY `idSA` (`idInventario`);

--
-- Indici per le tabelle `ripiano`
--
ALTER TABLE `ripiano`
  ADD PRIMARY KEY (`idRipiano`),
  ADD KEY `idPunto` (`idPunto`);

--
-- Indici per le tabelle `schedasicurezza`
--
ALTER TABLE `schedasicurezza`
  ADD PRIMARY KEY (`idScheda`);

--
-- Indici per le tabelle `situato_m_r`
--
ALTER TABLE `situato_m_r`
  ADD PRIMARY KEY (`idManuale`,`idRipiano`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `situato_s_r`
--
ALTER TABLE `situato_s_r`
  ADD PRIMARY KEY (`idScheda`,`idRipiano`),
  ADD KEY `idRipiano` (`idRipiano`) USING BTREE;

--
-- Indici per le tabelle `storicomanutenzione_ordinaria`
--
ALTER TABLE `storicomanutenzione_ordinaria`
  ADD PRIMARY KEY (`idStoricoOrd`),
  ADD KEY `idSA` (`idInventario`) USING BTREE;

--
-- Indici per le tabelle `storicomanutenzione_straordinaria`
--
ALTER TABLE `storicomanutenzione_straordinaria`
  ADD PRIMARY KEY (`idStoricoStra`),
  ADD KEY `idSA` (`idInventario`);

--
-- Indici per le tabelle `strumentazione_apparecchiatura`
--
ALTER TABLE `strumentazione_apparecchiatura`
  ADD PRIMARY KEY (`idSA`),
  ADD UNIQUE KEY `nomeSA` (`nomeSA`) USING BTREE,
  ADD KEY `idManuale` (`idManuale`);

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
  MODIFY `idAspetto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `collocazionefisica`
--
ALTER TABLE `collocazionefisica`
  MODIFY `idCollocazione` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT per la tabella `dittaproduttrice`
--
ALTER TABLE `dittaproduttrice`
  MODIFY `idDitta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `esperienzadidattica`
--
ALTER TABLE `esperienzadidattica`
  MODIFY `idEsperienza` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idInventario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT per la tabella `manualeistruzioni`
--
ALTER TABLE `manualeistruzioni`
  MODIFY `idManuale` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT per la tabella `modalitaconservazione`
--
ALTER TABLE `modalitaconservazione`
  MODIFY `idModalita` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `pittogrammasicurezza`
--
ALTER TABLE `pittogrammasicurezza`
  MODIFY `idPittogramma` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `punto`
--
ALTER TABLE `punto`
  MODIFY `idPunto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT per la tabella `reagente`
--
ALTER TABLE `reagente`
  MODIFY `idReagente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT per la tabella `riparazione`
--
ALTER TABLE `riparazione`
  MODIFY `idRiparazione` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `ripiano`
--
ALTER TABLE `ripiano`
  MODIFY `idRipiano` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT per la tabella `schedasicurezza`
--
ALTER TABLE `schedasicurezza`
  MODIFY `idScheda` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `storicomanutenzione_ordinaria`
--
ALTER TABLE `storicomanutenzione_ordinaria`
  MODIFY `idStoricoOrd` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `storicomanutenzione_straordinaria`
--
ALTER TABLE `storicomanutenzione_straordinaria`
  MODIFY `idStoricoStra` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `strumentazione_apparecchiatura`
--
ALTER TABLE `strumentazione_apparecchiatura`
  MODIFY `idSA` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `idUtente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT per la tabella `vetreria_attrezzatura`
--
ALTER TABLE `vetreria_attrezzatura`
  MODIFY `idVA` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`idRipiano`) REFERENCES `ripiano` (`idRipiano`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`idSA`) REFERENCES `strumentazione_apparecchiatura` (`idSA`);

--
-- Limiti per la tabella `possiede_r_p`
--
ALTER TABLE `possiede_r_p`
  ADD CONSTRAINT `possiede_r_p_ibfk_1` FOREIGN KEY (`idReagente`) REFERENCES `reagente` (`idReagente`) ON DELETE CASCADE,
  ADD CONSTRAINT `possiede_r_p_ibfk_2` FOREIGN KEY (`idPittogramma`) REFERENCES `pittogrammasicurezza` (`idPittogramma`);

--
-- Limiti per la tabella `prevede_r_e`
--
ALTER TABLE `prevede_r_e`
  ADD CONSTRAINT `prevede_r_e_ibfk_1` FOREIGN KEY (`idReagente`) REFERENCES `reagente` (`idReagente`) ON DELETE CASCADE,
  ADD CONSTRAINT `prevede_r_e_ibfk_2` FOREIGN KEY (`idEsperienza`) REFERENCES `esperienzadidattica` (`idEsperienza`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `quantitasa_ibfk_1` FOREIGN KEY (`idSA`) REFERENCES `strumentazione_apparecchiatura` (`idSA`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `reagente_ibfk_4` FOREIGN KEY (`idScheda`) REFERENCES `schedasicurezza` (`idScheda`) ON DELETE CASCADE;

--
-- Limiti per la tabella `riparazione`
--
ALTER TABLE `riparazione`
  ADD CONSTRAINT `riparazione_ibfk_1` FOREIGN KEY (`idInventario`) REFERENCES `inventario` (`idInventario`);

--
-- Limiti per la tabella `ripiano`
--
ALTER TABLE `ripiano`
  ADD CONSTRAINT `ripiano_ibfk_1` FOREIGN KEY (`idPunto`) REFERENCES `punto` (`idPunto`);

--
-- Limiti per la tabella `situato_m_r`
--
ALTER TABLE `situato_m_r`
  ADD CONSTRAINT `situato_m_r_ibfk_1` FOREIGN KEY (`idManuale`) REFERENCES `manualeistruzioni` (`idManuale`),
  ADD CONSTRAINT `situato_m_r_ibfk_2` FOREIGN KEY (`idRipiano`) REFERENCES `ripiano` (`idRipiano`);

--
-- Limiti per la tabella `situato_s_r`
--
ALTER TABLE `situato_s_r`
  ADD CONSTRAINT `situato_s_r_ibfk_1` FOREIGN KEY (`idScheda`) REFERENCES `schedasicurezza` (`idScheda`),
  ADD CONSTRAINT `situato_s_r_ibfk_2` FOREIGN KEY (`idRipiano`) REFERENCES `ripiano` (`idRipiano`);

--
-- Limiti per la tabella `storicomanutenzione_ordinaria`
--
ALTER TABLE `storicomanutenzione_ordinaria`
  ADD CONSTRAINT `storicomanutenzione_ordinaria_ibfk_1` FOREIGN KEY (`idInventario`) REFERENCES `inventario` (`idInventario`);

--
-- Limiti per la tabella `storicomanutenzione_straordinaria`
--
ALTER TABLE `storicomanutenzione_straordinaria`
  ADD CONSTRAINT `storicomanutenzione_straordinaria_ibfk_1` FOREIGN KEY (`idInventario`) REFERENCES `inventario` (`idInventario`);

--
-- Limiti per la tabella `strumentazione_apparecchiatura`
--
ALTER TABLE `strumentazione_apparecchiatura`
  ADD CONSTRAINT `strumentazione_apparecchiatura_ibfk_1` FOREIGN KEY (`idManuale`) REFERENCES `manualeistruzioni` (`idManuale`) ON DELETE CASCADE;

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
