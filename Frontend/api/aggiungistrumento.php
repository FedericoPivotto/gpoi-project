<?php

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

/*	nome, caratteristiche
	nomemanuale, datarilasciomanuale

	if(checkFis)
		collocazione, punto, ripiano, quantita

	if(checkDig)
		linkmanuale */

// nome
if(isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    // echo "nome: |" . $nome . "|";
}
// caratteristiche
if(isset($_POST['caratteristiche'])) {
    $caratteristiche = $_POST['caratteristiche'];
    // echo "caratteristiche: |" . $caratteristiche . "|";
}

// nomemanuale
if(isset($_POST['nomemanuale'])) {
    $nomemanuale = $_POST['nomemanuale'];
    // echo "nomemanuale: |" . $nomemanuale . "|";
}
// datarilasciomanuale
if(isset($_POST['datarilasciomanuale'])) {
    $datarilasciomanuale = $_POST['datarilasciomanuale'];
    // echo "datarilasciomanuale: |" . $datarilasciomanuale . "|";
}

/* if(checkFis) */
	// collocazione
	if(isset($_POST['stanzaTipoStrumento'])) {
	    $collocazione = $_POST['stanzaTipoStrumento'];
        // echo "stanza: |" . $collocazione . "|";
	}
	// punto
	if(isset($_POST['armadioTipoStrumento'])) {
	    $punto = $_POST['armadioTipoStrumento'];
        // echo "armadio: |" . $punto . "|";
	}
	// ripiano
	if(isset($_POST['ripianoTipoStrumento'])) {
	    $ripiano = $_POST['ripianoTipoStrumento'];
        // echo "ripiano: |" . $ripiano . "|";
	}
	// quantita
	if(isset($_POST['quantita'])) {
	    $quantita = $_POST['quantita'];
        // echo "quantita: |" . $quantita . "|";
	}

/* if(checkDig) */
	// linkmanuale
	if(isset($_POST['linkmanuale'])) {
	    $linkmanuale = $_POST['linkmanuale'];
        // echo "linkmanuale: |" . $linkmanuale . "|";
	}


/* Funzioni */
function aggiungiStrumento()
{
	global $connection;
	global $nome, $caratteristiche;

    if(!checkStrumento($nome))
    {
    	$idManuale = aggiungiManuale();
        // echo "ID MANUALE: |" . $idManuale . "|";
        // query di inserimento
        $query = "INSERT INTO strumentazione_apparecchiatura (nomeSA, caratteristicaTecnica, idManuale) VALUES ('$nome', '$caratteristiche', '$idManuale');";

        $result = mysqli_query($connection, $query)
        	or die ("1Errore nella query " . mysqli_error($connection) . "<br>");

        echo "<p style=\"color: green;\"><b>Il nuovo tipo di strumento &egrave; stato inserito con successo.</b></p><br>";
    }
    else
    {
        echo "<p style=\"color: red;\"><b>Il tipo di strumento inserito &egrave; gi&agrave; presente.</b></p><br>";
    }

    /* Chiusura connessione al database */
    // require('dbclose.php');
}

function checkStrumento($nome)
{
    global $connection;

    $query = "SELECT * FROM strumentazione_apparecchiatura 
                WHERE nomeSA = '$nome';";

    $result = mysqli_query($connection, $query)
        or die ("0Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function aggiungiManuale()
{
	global $connection;

	$table = "manualeistruzioni";
	
	if( isset($_POST['checkFis']) && isset($_POST['checkDig']) )
	{
		global $nomemanuale, $datarilasciomanuale;
		global $linkmanuale;
		
		// query inserimento manuale digitale
		$query = "INSERT INTO ".$table." (nomeManuale, dataRilascio, linkManuale) 
                    VALUES ('$nomemanuale', '$datarilasciomanuale', '$linkmanuale');";
        $result = mysqli_query($connection, $query)
        	or die ("2Errore nella query " . mysqli_error($connection) . "<br>");

        $idManuale = getIdNuovoManuale($nomemanuale, $datarilasciomanuale);

        // gestione collocazione
        aggiungiCollocazioneManuale($idManuale);

        return $idManuale;
	}
	else if(isset($_POST['checkFis']))
	{
		global $nomemanuale, $datarilasciomanuale;
		
		// query inserimento manuale fisico
		$query = "INSERT INTO ".$table." (nomeManuale, dataRilascio) 
                    VALUES ('$nomemanuale', '$datarilasciomanuale');";
        $result = mysqli_query($connection, $query)
        	or die ("3Errore nella query " . mysqli_error($connection) . "<br>");

        $idManuale = getIdNuovoManuale($nomemanuale, $datarilasciomanuale);

        // gestione collocazione
        aggiungiCollocazioneManuale($idManuale);

        return $idManuale;
	}
	else if(isset($_POST['checkDig']))
	{
		global $nomemanuale, $datarilasciomanuale;
		global $linkmanuale;
		
		// query inserimento manuale digitale
		$query = "INSERT INTO ".$table." (nomeManuale, dataRilascio, linkManuale) 
                    VALUES ('$nomemanuale', '$datarilasciomanuale', '$linkmanuale');";
        $result = mysqli_query($connection, $query)
        	or die ("4Errore nella query " . mysqli_error($connection) . "<br>");
        	
        $idManuale = getIdNuovoManuale($nomemanuale, $datarilasciomanuale);

        return $idManuale;
	}
	else
	{
		// echo "Errore nell'inserimento del manuale";
	}
}

function getIdNuovoManuale($nomemanuale, $datarilasciomanuale)
{
    global $connection;

    $query = "SELECT * FROM manualeistruzioni 
    			WHERE nomeManuale = '$nomemanuale' AND dataRilascio = '$datarilasciomanuale';";

    $result = mysqli_query($connection, $query)
        or die ("5Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idManuale'];
}

function aggiungiCollocazioneManuale($idManuale)
{
	global $connection;
	global $collocazione, $punto, $ripiano, $quantita;

    $query = "SELECT * FROM ripiano
                INNER JOIN punto
                    ON punto.idPunto = ripiano.idPunto
                INNER JOIN collocazionefisica
                    ON collocazionefisica.idCollocazione = punto.idCollocazione
                WHERE ripiano.siglaRipiano = '$ripiano' 
                	AND punto.siglaPunto = '$punto'
                	AND collocazionefisica.siglaStanza = '$collocazione';";

    $result = mysqli_query($connection, $query)
        or die ("6Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);
    $idR = $row['idRipiano'];

    if(mysqli_affected_rows($connection) == 0) // collocazione non esistente
	{
		// inserimento nuova collocazione
		$idR = inserisciNuovaCollocazione($collocazione, $punto, $ripiano);
	}

    if(!checkSituatoMR($idManuale, $idR))
    {
    	// inserimento tupla in molti a molti
    	$queryFk = "INSERT INTO situato_m_r (idManuale, idRipiano, quantita) VALUES ('$idManuale', '$idR', '$quantita');";
    	$result = mysqli_query($connection, $queryFk)
    	   or die ("7Errore nella query " . mysqli_error($connection) . "<br>");
    }
}

function checkSituatoMR($idManuale, $idRipiano)
{
    global $connection;

    $query = "SELECT * FROM situato_m_r 
                WHERE idManuale = '$idManuale' AND idRipiano = '$idRipiano';";

    $result = mysqli_query($connection, $query)
        or die ("34Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function inserisciNuovaCollocazione($collocazione, $punto, $ripiano)
{
	global $connection;

	// aggiunto controllo esistenza
	if(!checkCollocazione($collocazione))
	{
		$queryCollocazione = "INSERT INTO collocazionefisica (siglaStanza) VALUES ('$collocazione')";
		$resultC = mysqli_query($connection, $queryCollocazione)
	    	or die ("8Errore nella query " . mysqli_error($connection) . "<br>");
	}

	$idC = getIdCollocazione($collocazione);
	// aggiunto controllo esistenza
	if(!checkPunto($punto, $idC))
	{
		$queryPunto 	   = "INSERT INTO punto (siglaPunto, idCollocazione) VALUES ('$punto', '$idC')";
		$resultP = mysqli_query($connection, $queryPunto)
	    	or die ("9Errore nella query " . mysqli_error($connection) . "<br>");
	}

	$idP = getIdPunto($punto, $idC);
	// aggiunto controllo esistenza
	if(!checkRipiano($ripiano, $idP))
	{
		$queryRipiano      = "INSERT INTO ripiano (siglaRipiano, idPunto) VALUES ('$ripiano', '$idP')";
		$resultR = mysqli_query($connection, $queryRipiano)
	    	or die ("10Errore nella query " . mysqli_error($connection) . "<br>");
    }

    $idR = getIdRipiano($ripiano, $idP);

    return $idR;
}

function checkCollocazione($collocazione)
{
    global $connection;

    $query = "SELECT * FROM collocazionefisica 
    			WHERE siglaStanza = '$collocazione';";

    $result = mysqli_query($connection, $query)
        or die ("13Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
    	return true;
    }
    else
    {
    	return false;
    }
}

function checkPunto($punto, $idC)
{
    global $connection;

    $query = "SELECT * FROM punto 
    			WHERE siglaPunto = '$punto' AND idCollocazione = '$idC';";

    $result = mysqli_query($connection, $query)
        or die ("14Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
    	return true;
    }
    else
    {
    	return false;
    }
}

function checkRipiano($ripiano, $idP)
{
    global $connection;

    $query = "SELECT * FROM ripiano 
    			WHERE siglaRipiano = '$ripiano' AND idPunto = '$idP';";

    $result = mysqli_query($connection, $query)
        or die ("15Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
    	return true;
    }
    else
    {
    	return false;
    }
}

function getIdCollocazione($collocazione)
{
    global $connection;

    $query = "SELECT * FROM collocazionefisica 
    			WHERE siglaStanza = '$collocazione';";

    $result = mysqli_query($connection, $query)
        or die ("11Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idCollocazione'];
}

function getIdPunto($punto, $idC)
{
    global $connection;

    $query = "SELECT * FROM punto 
    			WHERE siglaPunto = '$punto' AND idCollocazione = '$idC';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idPunto'];
}

function getIdRipiano($ripiano, $idP)
{
    global $connection;

    $query = "SELECT * FROM ripiano 
    			WHERE siglaRipiano = '$ripiano' AND idPunto = $idP;";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idRipiano'];
}


/* Istruzioni principali */
// aggiungiStrumento();

/* Chiusura connessione al database */
// require('dbclose.php');

?>