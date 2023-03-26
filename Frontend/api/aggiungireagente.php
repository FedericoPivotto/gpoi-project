<?php

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

/*	nome, formula
    stato
	nomeDitta
    modalitaConservazione, temperaturaConservazione
    nomescheda, datarilascioscheda

    if(checkFis)
        stanzaTipoReagente, armadioTipoReagente, ripianoTipoReagente, quantita

    if(checkDig)
        linkscheda */

// nome
    if(isset($_POST['nome'])) {
        $nome = $_POST['nome'];
        // echo "nome: |" . $nome . "|";
    }
// formula
    if(isset($_POST['formula'])) {
        $formula = $_POST['formula'];
        // echo "formula: |" . $formula . "|";
    }

// stato
    if(isset($_POST['stato'])) {
        $stato = $_POST['stato'];
        // echo "stato: |" . $stato . "|";
    }

// nomeDitta
    if(isset($_POST['nomeDitta'])) {
        $nomeDitta = $_POST['nomeDitta'];
        // echo "nomeDitta: |" . $nomeDitta . "|";
    }

// modalitaConservazione
    if(isset($_POST['modalitaConservazione'])) {
        $modalitaConservazione = $_POST['modalitaConservazione'];
        // echo "modalitaConservazione: |" . $modalitaConservazione . "|";
    }
// temperaturaConservazione
    if(isset($_POST['temperaturaConservazione'])) {
        $temperaturaConservazione = $_POST['temperaturaConservazione'];
        // echo "temperaturaConservazione: |" . $temperaturaConservazione . "|";
    }

// nomescheda
    if(isset($_POST['nomescheda'])) {
        $nomescheda = $_POST['nomescheda'];
        // echo "nomescheda: |" . $nomescheda . "|";
    }
// datarilascioscheda
    if(isset($_POST['datarilascioscheda'])) {
        $datarilascioscheda = $_POST['datarilascioscheda'];
        // echo "datarilascioscheda: |" . $datarilascioscheda . "|";
    }

/* if(checkFis) */
	// collocazione
	if(isset($_POST['stanzaManuale'])) {
	    $collocazione = $_POST['stanzaManuale'];
        // echo "stanza: |" . $collocazione . "|";
	}
	// punto
	if(isset($_POST['armadioManuale'])) {
	    $punto = $_POST['armadioManuale'];
        // echo "armadio: |" . $punto . "|";
	}
	// ripiano
	if(isset($_POST['ripianoManuale'])) {
	    $ripiano = $_POST['ripianoManuale'];
        // echo "ripiano: |" . $ripiano . "|";
	}
	// quantita
	if(isset($_POST['quantita'])) {
	    $quantita = $_POST['quantita'];
        // echo "quantita: |" . $quantita . "|";
	}

/* if(checkDig) */
	// linkscheda
	if(isset($_POST['linkscheda'])) {
	    $linkscheda = $_POST['linkscheda'];
        // echo "linkscheda: |" . $linkscheda . "|";
	}

// pittogrammi | pittogrammi_count
    if(!empty($_POST['check_list'])) {
        $pittogrammi       = $_POST['check_list'];
        // $pittogrammi_count = count($_POST['check_list']);
        // loop
        /*foreach($pittogrammi as $selected)
        {
            echo "<p>".$selected ."</p>";
        }*/
    }


/* Funzioni */
function aggiungiReagente()
{
	global $connection;
	global $nome, $formula;
    global $stato;
    global $nomeDitta;
    global $modalitaConservazione, $temperaturaConservazione;
    global $pittogrammi;

    if(!checkReagente($nome))
    {
        $idAspetto  = getIdAspetto($stato);
        $idDitta    = getIdDitta($nomeDitta);
        $idModalita = getIdModalita($modalitaConservazione, $temperaturaConservazione);
    	$idScheda   = aggiungiScheda();

        // echo "ID SCHEDA: |" . $idScheda . "|";
        // query di inserimento
        $query = "INSERT INTO reagente (nomeReagente, formulaChimica, idAspetto, idDitta, idModalita, idScheda) VALUES ('$nome', '$formula', '$idAspetto', '$idDitta', '$idModalita', '$idScheda');";

        $result = mysqli_query($connection, $query)
        	or die ("1Errore nella query " . mysqli_error($connection) . "<br>");

        $idReagente = getIdReagente($nome);
        aggiungiPittogrammi($idReagente, $pittogrammi);

        echo "<p style=\"color: green;\"><b>Il nuovo tipo di reagente &egrave; stato inserito con successo.</b></p><br>";
    }
    else
    {
        echo "<p style=\"color: red;\"><b>Il tipo di reagente inserito &egrave; gi&agrave; presente.</b></p><br>";
    }

    /* Chiusura connessione al database */
    // require('dbclose.php');
}

function aggiungiPittogrammi($idReagente, $pittogrammi)
{
    global $connection; 

    // loop pittogrammi
    foreach($pittogrammi as $selected)
    {
        // echo "<p>".$selected ."</p>";
        $query = "INSERT INTO possiede_r_p (idReagente, idPittogramma) VALUES ('$idReagente', '$selected');";

        $result = mysqli_query($connection, $query)
            or die ("40Errore nella query " . mysqli_error($connection) . "<br>");
    }
}

function checkReagente($nome)
{
    global $connection;

    $query = "SELECT * FROM reagente 
                WHERE nomeReagente = '$nome';";

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

function getIdAspetto($stato)
{
    global $connection;

    $query = "SELECT * FROM aspetto 
                WHERE statoMateria = '$stato';";

    $result = mysqli_query($connection, $query)
        or die ("30Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idAspetto'];
}

function getIdReagente($nome)
{
    global $connection;

    $query = "SELECT * FROM reagente 
                WHERE nomeReagente = '$nome';";

    $result = mysqli_query($connection, $query)
        or die ("30Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idReagente'];
}

function getIdDitta($nomeDitta)
{
    global $connection;

    $query = "SELECT * FROM dittaproduttrice 
                WHERE nomeDitta = '$nomeDitta';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idDitta'];
}

function getIdModalita($modalitaConservazione, $temperaturaConservazione)
{
    global $connection;

    // se non esiste agigungi
    if(!checkModalita($modalitaConservazione, $temperaturaConservazione))
    {
        $queryInsert = "INSERT INTO modalitaconservazione (modalita, temperatura) VALUES ('$modalitaConservazione', '$temperaturaConservazione')";
        $resultInsert = mysqli_query($connection, $queryInsert)
            or die ("8Errore nella query " . mysqli_error($connection) . "<br>");
    }

    // get idModalita
    $query = "SELECT * FROM modalitaconservazione 
                WHERE modalita = '$modalitaConservazione' AND temperatura = '$temperaturaConservazione';";
    $result = mysqli_query($connection, $query)
        or die ("31Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idModalita'];
}

function checkModalita($modalitaConservazione, $temperaturaConservazione)
{
    global $connection;

    $query = "SELECT * FROM modalitaconservazione 
                WHERE modalita = '$modalitaConservazione' AND temperatura = '$temperaturaConservazione';";

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

function aggiungiScheda()
{
	global $connection;

	$table = "schedasicurezza";
	
	if( isset($_POST['checkFis']) && isset($_POST['checkDig']) )
	{
		global $nomescheda, $datarilascioscheda;
		global $linkscheda;
		
		// query inserimento scheda digitale
		$query = "INSERT INTO ".$table." (nomeScheda, dataRilascio, linkScheda) 
                    VALUES ('$nomescheda', '$datarilascioscheda', '$linkscheda');";
        $result = mysqli_query($connection, $query)
        	or die ("2Errore nella query " . mysqli_error($connection) . "<br>");

        $idScheda = getIdNuovaScheda($nomescheda, $datarilascioscheda);

        // gestione collocazione
        aggiungiCollocazioneScheda($idScheda);

        return $idScheda;
	}
	else if(isset($_POST['checkFis']))
	{
		global $nomescheda, $datarilascioscheda;
		
		// query inserimento scheda fisica
		$query = "INSERT INTO ".$table." (nomeScheda, dataRilascio) 
                    VALUES ('$nomescheda', '$datarilascioscheda');";
        $result = mysqli_query($connection, $query)
        	or die ("3Errore nella query " . mysqli_error($connection) . "<br>");

        $idScheda = getIdNuovaScheda($nomescheda, $datarilascioscheda);

        // gestione collocazione
        aggiungiCollocazioneScheda($idScheda);

        return $idScheda;
	}
	else if(isset($_POST['checkDig']))
	{
		global $nomescheda, $datarilascioscheda;
		global $linkscheda;
		
		// query inserimento scheda digitale
		$query = "INSERT INTO ".$table." (nomeScheda, dataRilascio, linkScheda) 
                    VALUES ('$nomescheda', '$datarilascioscheda', '$linkscheda');";
        $result = mysqli_query($connection, $query)
        	or die ("4Errore nella query " . mysqli_error($connection) . "<br>");
        	
        $idScheda = getIdNuovaScheda($nomescheda, $datarilascioscheda);

        return $idScheda;
	}
	else
	{
		// echo "Errore nell'inserimento della scheda";
	}
}

function getIdNuovaScheda($nomescheda, $datarilascioscheda)
{
    global $connection;

    $query = "SELECT * FROM schedasicurezza 
    			WHERE nomeScheda = '$nomescheda' AND dataRilascio = '$datarilascioscheda';";

    $result = mysqli_query($connection, $query)
        or die ("5Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idScheda'];
}

function aggiungiCollocazioneScheda($idScheda)
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

    if(!checkSituatoSR($idScheda, $idR))
    {
    	// inserimento tupla in molti a molti
    	$queryFk = "INSERT INTO situato_s_r (idScheda, idRipiano, quantita) VALUES ('$idScheda', '$idR', '$quantita');";
    	$result = mysqli_query($connection, $queryFk)
        	or die ("7Errore nella query " . mysqli_error($connection) . "<br>");
    }
}

function checkSituatoSR($idScheda, $idRipiano)
{
    global $connection;

    $query = "SELECT * FROM situato_s_r 
                WHERE idScheda = '$idScheda' AND idRipiano = '$idRipiano';";

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
    			WHERE siglaRipiano = '$ripiano' AND idPunto = '$idP';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idRipiano'];
}



/* Istruzioni principali */
// aggiungiReagente();

/* Chiusura connessione al database */
// require('dbclose.php');

?>