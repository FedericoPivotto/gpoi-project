# Pagina dell'amministratore
- Nome utente
- Password (in md5)
- Categoria (ruolo)

# Consulta

## Reagente
### Filtri
Per ogni filtro viene generata una tabella parziale, per esempio, la tabella che si ottiene da una ricerca in base allo stato fornirà solo il nome del reagente solido, una volta che si seleziona il reagente che si vuole analizzare, si richiama una funzione php che in get si prende il nome del reagente, ed esegue la ricerca in base all'id che viene passato.

I filtri nella pagina di consultazione vengono visualizzati simultaneamente sempre tutti e 4

- nome
- aspetto
- ditta produttrice
- modalità di conservazione

### Attributi nella pagina di consultazione
- Nome
- Formula chimica
- Stato (solido, gassoso o liquido)
- Nome ditta
- Frasi di rischio con pittogramma (possono essere molteplici)
- collocazione (che può esser più di una)
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio
	- per ogni collocazione anche la quantità presente in quel luogo
		- data di verifica della quantità
		- data di scadenza
- Scheda di sicurezza
	- nome
	- data di rilascio
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio
	- link (se è digitale)
- modalità di conservazione
- temperatura di conservazione
- nome delle esperienze collegate

## Vetreria

### Filtri
- nome

### Attributi nella pagina di consultazione
- Nome
- Collocazione (che può esser più di una)
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio
	- per ogni collocazione anche la quantità presente in quel luogo

## Strumentazione

### Filtri
- nome
- numero di invertario

### Attributi nella pagina di consultazione
- Nome
- Caratteristiche tecniche (è un testo)
- numero di inventario
- Collocazione (che può esser più di una)
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio
	- per ogni collocazione anche la quantità presente in quel luogo
- Nome manuale
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio
	- link (se è digitale)
	- data rilascio

(due tabelle diverse)
- storico manutenzione ordinaria
	- azione (testo)
	- data
- storico manutenzione straordinaria
	- azione (testo)
	- data

- riparazione
	- motivazione (testo)
	- data

Nella pagina di consultazione predisponiamo anche la modifica tramite bottone che porta a pagina dedicata

# Cose da aggiungere nella pagina dell'admin

##Form di aggiunta per ditta
- nome
- indirizzo
- telefono
- mail

# Aggiunta di un reagente
- Nome (textbox) (obbligatoria)
- Formula chimica (textbox) (obbligatoria)
- Stato (solido, gassoso o liquido) (obbligatoria)
- Nome ditta (menu a tendina) (obbligatoria)
- modalita di conservazione (text box) (obbligatoria)
- temperatura di conservazione (text box) (obbligatoria)
- Scheda di sicurezza (obbligatoria)
	- nome
	- data di rilascio
	- link (se è digitale)
	(SE LA SCHEDA È FISICA)
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio
	- quantità

- pittogrammi (checkbox)

## COSE DA METTERE NELLA PAGINA DI CONSULTAZIONE (BOTTONE CHE MODIFICA NELLE TABELLE COLLEGATE)
- nome delle esperienze collegate
- collocazione (che può esser più di una)
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio
	- per ogni collocazione anche la quantità presente in quel luogo
		- data di verifica della quantità
		- data di scadenza

ed infine
- bottone "aggiungi"

# Aggiunta di vetreria
Nuova tipologia di vetreria i dati che servono saranno
- nome della vetreria (solo un textbox)
ed infine
- bottone "aggiungi"

# Aggiunta strumentazione
## Nuovo tipo di strumento
- nome (textbox) (obbligatoria)
- caratteristiche tecnice (textbox) (obbligatoria)
- Nome manuale (obbligatoria)
	- data rilascio (obbligatoria)
	- link (se è digitale)
	(SE IL MANUALE È FISICO)
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio
	- quantità

## Nuovo strumento
- tipo (tendina) (obbligatoria)
	- quindi nome e caratteristiche tecniche compaiono ma non sono modificabili
- numero di inventario

- Collocazione
	- Sigla della stanza
	- Codice dell'armadio
	- Numero del ripiano nell'armadio

## COSE DA METTERE NELLA PAGINA DI CONSULTAZIONE (BOTTONE CHE MODIFICA NELLE TABELLE COLLEGATE)
(due tabelle diverse)
- storico manutenzione ordinaria
	- azione (testo)
	- data
- storico manutenzione straordinaria
	- azione (testo)
	- data
- riparazione
	- motivazione (testo)
	- data


# COSE DA METTERE NELLA PAGINA DELL'ADMIN

## Tabelle da mettere
- per i reagenti (nome reagente)
- per la vetreria (nome vetreria)
- per la strumentazione (nome strumentazione e numero inventario)

## Aggiunta ditta produttrice
- nome
- indirizzo
- telefono
- email

# Pulsanti da aggiungere

## Aggiunta (sotto le categorie sono riportati i dati da far aggiungere)
- ogni collocazione di vetreria
	- replichiamo i campi di aggiunta per le collocazione della pagina, per esempio, se in reagente c'è data di scadenza e data di verifica in vetreria non c'è data di scadenza ma solo data di verifica 
- manuali di istruzioni e schede di sicurezza (vetreria)
	- stanza armadio ripiano quantità


## Modifica su ogni riga delle tabelle specificate

PER GUIDO crea i form con gli attributi specificati precompilati con i dati presenti nel DB per farlo lascia il value dei campi di input vuoti, dato che per rendere un input precompilato bisogna fare una stampa in php. Essenzialmente ciò che devi fare è per tutti i campi qui sotto delle pagine specificate un form con gli stessi campi, sarebbe meglio che creassi queste pagine in una loro cartella nominata modifica

- collocazione (reagente, strumentazione, vetreia)
	- quantità
	- data verifica
	- data scadenza
- scheda di sicurezza (reagente)
	- quantità
- manuale delle istruzioni (strumentazione)
	- quantità
- sulla collocazione della prima tabella della strumentazione
	- stanza armadio ripiano

## Cancellazione su ogni riga delle tabelle specificate
- collocazione (per ogni prodotto)
- scheda di sicurezza (reagente)
- manuale delle istruzioni (strumentazione)
- esperienze collegate del reagente (reagente)
