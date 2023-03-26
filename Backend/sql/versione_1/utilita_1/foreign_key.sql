ALTER TABLE utente
ADD FOREIGN KEY (idCategoria) REFERENCES categoria (idCategoria);

ALTER TABLE token
ADD FOREIGN KEY (idUtente) REFERENCES utente (idUtente);




ALTER TABLE punto
ADD FOREIGN KEY (idCollocazione) REFERENCES collocazionefisica (idCollocazione);

ALTER TABLE ripiano
ADD FOREIGN KEY (idPunto) REFERENCES punto (idPunto);




ALTER TABLE reagente
ADD FOREIGN KEY (idAspetto) REFERENCES aspetto (idAspetto);

ALTER TABLE reagente
ADD FOREIGN KEY (idDitta) REFERENCES dittaproduttrice (idDitta);

ALTER TABLE reagente
ADD FOREIGN KEY (idModalita) REFERENCES modalitaconservazione (idModalita);

ALTER TABLE reagente
ADD FOREIGN KEY (idScheda) REFERENCES schedasicurezza (idScheda);

ALTER TABLE reagente
ADD FOREIGN KEY (idQuantitaMagazzino) REFERENCES quantita (idQuantita);

ALTER TABLE reagente
ADD FOREIGN KEY (idQuantitaLaboratorio) REFERENCES quantita (idQuantita);




ALTER TABLE vetreria_attrezzatura
ADD FOREIGN KEY (idQuantitaMagazzino) REFERENCES quantita (idQuantita);

ALTER TABLE vetreria_attrezzatura
ADD FOREIGN KEY (idQuantitaLaboratorio) REFERENCES quantita (idQuantita);




ALTER TABLE strumentazione_apparecchiatura
ADD FOREIGN KEY (idManuale) REFERENCES manualeistruzioni (idManuale);

ALTER TABLE strumentazione_apparecchiatura
ADD FOREIGN KEY (idQuantitaMagazzino) REFERENCES quantita (idQuantita);

ALTER TABLE strumentazione_apparecchiatura
ADD FOREIGN KEY (idQuantitaLaboratorio) REFERENCES quantita (idQuantita);




ALTER TABLE storicomanutenzione
ADD FOREIGN KEY (idSA) REFERENCES strumentazione_apparecchiatura (idSA);

ALTER TABLE riparazione
ADD FOREIGN KEY (idSA) REFERENCES strumentazione_apparecchiatura (idSA);




ALTER TABLE possiede_r_p
ADD FOREIGN KEY (idReagente) REFERENCES reagente (idReagente);

ALTER TABLE possiede_r_p
ADD FOREIGN KEY (idPittogramma) REFERENCES pittogrammasicurezza (idPittogramma);



ALTER TABLE prevede_r_e
ADD FOREIGN KEY (idReagente) REFERENCES reagente (idReagente);

ALTER TABLE prevede_r_e
ADD FOREIGN KEY (idEsperienza) REFERENCES esperienzadidattica (idEsperienza);



ALTER TABLE situato_r_c
ADD FOREIGN KEY (idReagente) REFERENCES reagente (idReagente);

ALTER TABLE situato_r_c
ADD FOREIGN KEY (idCollocazione) REFERENCES collocazionefisica (idCollocazione);



ALTER TABLE situato_s_c
ADD FOREIGN KEY (idScheda) REFERENCES schedasicurezza (idScheda);

ALTER TABLE situato_s_c
ADD FOREIGN KEY (idCollocazione) REFERENCES collocazionefisica (idCollocazione);



ALTER TABLE consulta_u_va
ADD FOREIGN KEY (idUtente) REFERENCES utente (idUtente);

ALTER TABLE consulta_u_va
ADD FOREIGN KEY (idVA) REFERENCES vetreria_attrezzatura (idVA);



ALTER TABLE situato_va_c
ADD FOREIGN KEY (idVA) REFERENCES vetreria_attrezzatura (idVA);

ALTER TABLE situato_va_c
ADD FOREIGN KEY (idCollocazione) REFERENCES collocazionefisica (idCollocazione);



ALTER TABLE consulta_u_sa
ADD FOREIGN KEY (idUtente) REFERENCES utente (idUtente);

ALTER TABLE consulta_u_sa
ADD FOREIGN KEY (idSA) REFERENCES strumentazione_apparecchiatura (idSA);



ALTER TABLE situato_sa_c
ADD FOREIGN KEY (idSA) REFERENCES strumentazione_apparecchiatura (idSA);

ALTER TABLE situato_sa_c
ADD FOREIGN KEY (idCollocazione) REFERENCES collocazionefisica (idCollocazione);



ALTER TABLE situato_m_c
ADD FOREIGN KEY (idManuale) REFERENCES manualeistruzioni (idManuale);

ALTER TABLE situato_m_c
ADD FOREIGN KEY (idCollocazione) REFERENCES collocazionefisica (idCollocazione);
