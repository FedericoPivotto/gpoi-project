<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per aggiungere nuove collocazioni reagente al database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// idReagente
// <input type="hidden" name="idReagente" value="12">
    if(isset($_POST['idReagente'])) {
        $idReagente = $_POST['idReagente'];
        // echo "idReagente: |" . $idReagente . "|";
    }

// dati collocazione, quantita e date reagente
    // collocazione
    if(isset($_POST['stanza'])) {
        $collocazione = $_POST['stanza'];
        // echo "stanza: |" . $collocazione . "|";
    }
    // punto
    if(isset($_POST['armadio'])) {
        $punto = $_POST['armadio'];
        // echo "armadio: |" . $punto . "|";
    }
    // ripiano
    if(isset($_POST['ripiano'])) {
        $ripiano = $_POST['ripiano'];
        // echo "ripiano: |" . $ripiano . "|";
    }
    // quantita
    if(isset($_POST['quantita'])) {
        $quantita = $_POST['quantita'];
        // echo "quantita: |" . $quantita . "|";
    }
    // dataVerifica
    if(isset($_POST['dataVerifica'])) {
        $dataVerifica = $_POST['dataVerifica'];
        // echo "dataVerifica: |" . $dataVerifica . "|";
    }
    // dataScadenza
    if(isset($_POST['dataScadenza'])) {
        $dataScadenza = $_POST['dataScadenza'];
        // echo "dataScadenza: |" . $dataScadenza . "|";
    }

/* Funzioni */

function aggiungiCollocazioneReagente()
{
    global $connection;
    global $idReagente;
    global $collocazione, $punto, $ripiano, $quantita, $dataVerifica, $dataScadenza;

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

    if(!checkQuantitaR($idReagente, $idR))
    {
        // inserimento tupla in molti a molti
        $queryFk = "INSERT INTO quantitar (idReagente, idRipiano, quantita, dataVerifica, dataScadenza) VALUES ('$idReagente', '$idR', '$quantita', '$dataVerifica', '$dataScadenza');";
        $result = mysqli_query($connection, $queryFk)
            or die ("7Errore nella query " . mysqli_error($connection) . "<br>");
    }
    else
    {
        echo "<p style=\"color: red;\"><b>La collocazione inserita risulta essere gi&agrave; esistente.<br>Consiglio: modificare quella gi&agrave; presente.</b></p><br>";
    }
}

function checkQuantitaR($idReagente, $idRipiano)
{
    global $connection;

    $query = "SELECT * FROM quantitar 
                WHERE idReagente = '$idReagente' AND idRipiano = '$idRipiano';";

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
        $queryPunto        = "INSERT INTO punto (siglaPunto, idCollocazione) VALUES ('$punto', '$idC')";
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
aggiungiCollocazioneReagente();
header("location: /reagente.php?idReagente=" . $idReagente);

/* Chiusura connessione al database */
require('dbclose.php');

?>