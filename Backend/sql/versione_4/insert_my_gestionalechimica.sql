-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2020 alle 16:48
-- Versione del server: 5.6.33-log
-- PHP Version: 5.3.10


--
-- Database: `my_gestionalechimica`
--

-- --------------------------------------------------------

--
-- INSERT tabella `aspetto`
--

INSERT INTO aspetto(statoMateria) VALUES
('statoMateria_01'),
('statoMateria_02'),
('statoMateria_03');

-- --------------------------------------------------------

--
-- INSERT tabella `categoria`
--

INSERT INTO categoria(nomeCategoria, descrizione) VALUES
('studente', 'Consulta'),
('ITP', 'Consulta e Modifica'),
('Docente', 'Consulta, Modifica e Aggiunta');

-- --------------------------------------------------------

--
-- INSERT tabella `collocazionefisica`
--

INSERT INTO collocazionefisica(siglaStanza, descrizione) VALUES
('siglaStanza_01', 'testo_01'),
('siglaStanza_02', 'testo_02'),
('siglaStanza_03', 'testo_03');

-- --------------------------------------------------------

--
-- INSERT tabella `dittaproduttrice`
--

INSERT INTO dittaproduttrice(nomeDitta, indirizzo, telefono, email) VALUES
('nomeDitta_01', 'indirizzo_01', 'telefono_01', 'email_01'),
('nomeDitta_02', 'indirizzo_02', 'telefono_02', 'email_02'),
('nomeDitta_03', 'indirizzo_03', 'telefono_03', 'email_03');

-- --------------------------------------------------------

--
-- INSERT tabella `esperienzadidattica`
--

INSERT INTO esperienzadidattica(nomeEsperienza, linkEsperienza) VALUES
('nomeEsperienza_01', 'linkEsperienza_01'),
('nomeEsperienza_02', 'linkEsperienza_02'),
('nomeEsperienza_03', 'linkEsperienza_03');

-- --------------------------------------------------------

--
-- INSERT tabella `manualeistruzioni`
--

INSERT INTO manualeistruzioni(nomeManuale, dataRilascio, linkManuale) VALUES
('nomeManuale_01', '2020-03-14', 'linkManuale_01'),
('nomeManuale_02', '2020-03-14', 'linkManuale_02'),
('nomeManuale_03', '2020-03-14', 'linkManuale_03');

-- --------------------------------------------------------

--
-- INSERT tabella `modalitaconservazione`
--

INSERT INTO modalitaconservazione(modalita, temperatura) VALUES
('modalita_01', 'temperatura_01'),
('modalita_02', 'temperatura_02'),
('modalita_03', 'temperatura_03');

-- --------------------------------------------------------

--
-- INSERT tabella `pittogrammasicurezza`
--

INSERT INTO pittogrammasicurezza(simbolo, fraseRischio) VALUES
('simbolo_01', 'fraseRischio_01'),
('simbolo_02', 'fraseRischio_02'),
('simbolo_03', 'fraseRischio_03');

-- --------------------------------------------------------

--
-- INSERT tabella `schedasicurezza`
--

INSERT INTO schedasicurezza(nomeScheda, dataRilascio, linkScheda) VALUES
('nomeScheda_01', '2020-03-14', 'linkScheda_01'),
('nomeScheda_02', '2020-03-14', 'linkScheda_02'),
('nomeScheda_03', '2020-03-14', 'linkScheda_03');

-- --------------------------------------------------------

--
-- INSERT tabella `punto`
--

INSERT INTO punto(siglaPunto, codiceQr, idCollocazione) VALUES
('simbolo_01', 'fraseRischio_01', 1),
('simbolo_02', 'fraseRischio_02', 2),
('simbolo_03', 'fraseRischio_03', 3);

-- --------------------------------------------------------
--
-- INSERT tabella `ripiano`
--

INSERT INTO ripiano(numeroRipiano, idPunto) VALUES
('ripiano_01', 1),
('ripiano_02', 2),
('ripiano_03', 3);

-- --------------------------------------------------------

--
-- INSERT tabella `utente`
--

INSERT INTO utente(username, password, idCategoria) VALUES
('studente_01', 'studente_01', 1),
('itp_02', 'itp_02', 2),
('docente_03', 'docente_03', 3);

-- --------------------------------------------------------
--
-- INSERT tabella `token`
--

INSERT INTO token(token, scadenza, idUtente) VALUES
('token_01', '2020-03-14 00:00:00', 1),
('token_02', '2020-03-14 00:00:00', 2),
('token_03', '2020-03-14 00:00:00', 3);

-- --------------------------------------------------------

--
-- INSERT tabella `strumentazione_apparecchiatura`
--

INSERT INTO strumentazione_apparecchiatura(nomeSA, caratteristicaTecnica, numeroInventario, idManuale) VALUES
('nomeSA_01', 'caratteristicaTecnica_01', 'numeroInventario_01', 1),
('nomeSA_02', 'caratteristicaTecnica_02', 'numeroInventario_02', 2),
('nomeSA_03', 'caratteristicaTecnica_03', 'numeroInventario_03', 3);

-- --------------------------------------------------------

--
-- INSERT tabella `vetreria_attrezzatura`
--

INSERT INTO vetreria_attrezzatura(nomeVA) VALUES
('nomeVA_01'),
('nomeVA_02'),
('nomeVA_03');

-- --------------------------------------------------------
--
-- INSERT tabella `reagente`
--

INSERT INTO reagente(nomeReagente, formulaChimica, idAspetto, idDitta, idModalita, idScheda) VALUES
('nomeReagente_01', 'formulaChimica_01', 1, 1, 1, 1),
('nomeReagente_02', 'formulaChimica_02', 2, 2, 2, 2),
('nomeReagente_03', 'formulaChimica_03', 3, 3, 3, 3);

-- --------------------------------------------------------

--
-- INSERT tabella `quantitar`
--

INSERT INTO quantitar(quantita, dataVerifica, dataScadenza, idRipiano, idReagente) VALUES
('quantitar_01', '2020-03-14', '2020-03-14', 1, 1),
('quantitar_02', '2020-03-14', '2020-03-14', 2, 2),
('quantitar_03', '2020-03-14', '2020-03-14', 3, 3);

-- --------------------------------------------------------

--
-- INSERT tabella `quantitasa`
--

INSERT INTO quantitasa(quantita, dataVerifica, dataScadenza, idRipiano, idSA) VALUES
('quantitasa_01', '2020-03-14', '2020-03-14', 1, 1),
('quantitasa_02', '2020-03-14', '2020-03-14', 2, 2),
('quantitasa_03', '2020-03-14', '2020-03-14', 3, 3);

-- --------------------------------------------------------

--
-- INSERT tabella `quantitava`
--

INSERT INTO quantitava(quantita, dataVerifica, dataScadenza, idRipiano, idVA) VALUES
('quantitava_01', '2020-03-14', '2020-03-14', 1, 1),
('quantitava_02', '2020-03-14', '2020-03-14', 2, 2),
('quantitava_03', '2020-03-14', '2020-03-14', 3, 3);

-- --------------------------------------------------------

--
-- INSERT tabella `riparazione`
--

INSERT INTO riparazione(motivazione, dataRiparazione, idSA) VALUES
('testo_01', '2020-03-14', 1),
('testo_02', '2020-03-14', 2),
('testo_03', '2020-03-14', 3);

-- --------------------------------------------------------

--
-- INSERT tabella `storicomanutenzione_ordinaria`
--

INSERT INTO storicomanutenzione_ordinaria(azione, dataManutenzione, idSA) VALUES
('azioneordinaria_01', '2020-03-14', 1),
('azioneordinaria_02', '2020-03-14', 2),
('azioneordinaria_03', '2020-03-14', 3);

-- --------------------------------------------------------

--
-- INSERT tabella `storicomanutenzione_straordinaria`
--

INSERT INTO storicomanutenzione_straordinaria(azione, dataManutenzione, idSA) VALUES
('azionestraordinaria_01', '2020-03-14', 1),
('azionestraordinaria_02', '2020-03-14', 2),
('azionestraordinaria_03', '2020-03-14', 3);

-- --------------------------------------------------------

--
-- INSERT tabella `possiede_r_p`
--

INSERT INTO possiede_r_p(idReagente, idPittogramma) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- INSERT tabella `prevede_r_e`
--

INSERT INTO prevede_r_e(idReagente, idEsperienza) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- INSERT tabella `situato_m_c`
--

INSERT INTO situato_m_c(idManuale, idRipiano) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- INSERT tabella `situato_s_c`
--

INSERT INTO situato_s_c(idScheda, idRipiano) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------
