<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per aggiungere un nuovo strumento al database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */
if(isset($_POST['nomeStrumento'])) {
    $nomeStrumento = $_POST['nomeStrumento'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

if(isset($_POST['numeroinventario'])) {
    $numeroInventario = $_POST['numeroinventario'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// collocazione
if(isset($_POST['stanzaStrumento'])) {
    $collocazione = $_POST['stanzaStrumento'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// punto
if(isset($_POST['armadioStrumento'])) {
    $punto = $_POST['armadioStrumento'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// ripiano
if(isset($_POST['ripianoStrumento'])) {
    $ripiano = $_POST['ripianoStrumento'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// variabili di prova
// $nomeStrumento = "nomeSA_test";
// $numeroInventario = "numeroInventario_test";


/* Funzioni */

// Aggiunta dati a tabella strumentazione_apparecchiatura
/*function aggiungiStrumento()
{
	global $connection;
    global $nomeStrumento;

    //query di inserimento
    $table = "strumentazione_apparecchiatura";
    $insert = "INSERT INTO $table (nomeSA) 
                    VALUES ('$nomeStrumento');";
    
    if (mysqli_query($connection, $insert)) {
    	// echo di prova
        //echo "<br>Nuovo record creato con successo!<br><br>";
    } else {
        echo "<br>Errore: " . $insert . "<br>" . mysqli_error($connection);
    }
}*/

// Aggiunta dati a tabella inventario
function aggiungiNumeroInventario()
{
    global $connection;
    global $numeroInventario;
    
    if(!checkNumeroInventario($numeroInventario))
    {
        $idSA = estraiIdSA();
        $idRipiano = estraiIdRipiano();

        //query di inserimento
        $table = "inventario";
        $insert = "INSERT INTO $table (numeroInventario, idSA, idRipiano) 
                        VALUES ('$numeroInventario', '$idSA', '$idRipiano');";
        
        if (mysqli_query($connection, $insert)) {
            // echo di prova
            //echo "<br>Nuovo record creato con successo!<br><br>";
        } else {
            echo "<br>Errore: " . $insert . "<br>" . mysqli_error($connection);
        }

        aggiornaQuantita($idSA, $idRipiano);

        echo "<p style=\"color: green;\"><b>Il nuovo strumento inventariato &egrave; stato inserito con successo.</b></p><br>";
    }
    else
    {
        echo "<p style=\"color: red;\"><b>Il numero di inventario inserito &egrave; gi&agrave; stato utilizzato.</b></p><br>";
    }

    /* Chiusura connessione al database */
    // require('dbclose.php');
}

function aggiornaQuantita($idSA, $idRipiano)
{
    global $connection;

    if(!checkQuantitaSa($idSA, $idRipiano))
    {
        $quantita = 1;
        $today = date("Y/m/d");
        $query = "INSERT INTO quantitasa (idSA, idRipiano, quantita, dataVerifica, dataScadenza) VALUES ('$idSA', '$idRipiano', '$quantita', '$today', '$today');";

        $result = mysqli_query($connection, $query)
            or die ("20Errore nella query " . mysqli_error($connection) . "<br>");
    }
    else
    {
        $newQuantita = getQuantita($idSA, $idRipiano) + 1;
        $today = date("Y/m/d");
        $query = "UPDATE quantitasa
                    SET quantita = '$newQuantita', dataVerifica = '$today', dataScadenza = '$today'
                    WHERE idSA = '$idSA' AND idRipiano = '$idRipiano';";

        $result = mysqli_query($connection, $query)
            or die ("21Errore nella query " . mysqli_error($connection) . "<br>");
    }
}

function checkQuantitaSa($idSA, $idRipiano)
{
    global $connection;

    $query = "SELECT * FROM quantitasa 
                WHERE idSA = '$idSA' AND idRipiano = '$idRipiano';";

    $result = mysqli_query($connection, $query)
        or die ("24Errore nella query " . mysqli_error($connection) . "<br>");
    
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

function getQuantita($idSA, $idRipiano)
{
    global $connection;

    $query = "SELECT * FROM quantitasa 
                WHERE idSA = '$idSA' AND idRipiano = '$idRipiano';";

    $result = mysqli_query($connection, $query)
        or die ("23Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['quantita'];
}

function checkNumeroInventario($numeroInventario)
{
    global $connection;

    $query = "SELECT * FROM inventario 
                WHERE numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("18Errore nella query " . mysqli_error($connection) . "<br>");
    
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

// Estrazione dati da tabella strumentazione_apparecchiatura
function estraiIdSA()
{
    global $connection;
    global $nomeStrumento;

    //query di ricerca
    $table = "strumentazione_apparecchiatura";
    $query = "SELECT idSA FROM $table WHERE nomeSA='$nomeStrumento';";

    $result = mysqli_query($connection, $query) 
        or die(mysql_error());

    while($row = mysqli_fetch_array($result)){
        $idSA = $row['idSA'];
    }

    return $idSA;
}

function estraiIdRipiano()
{
    global $connection;
    global $collocazione, $punto, $ripiano;

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

    return $idR;
}

// DA CONCLUDERE
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

    $idP = getIdPunto($punto);
    // aggiunto controllo esistenza
    if(!checkRipiano($ripiano, $idP))
    {
        $queryRipiano      = "INSERT INTO ripiano (siglaRipiano, idPunto) VALUES ('$ripiano', '$idP')";
        $resultR = mysqli_query($connection, $queryRipiano)
            or die ("10Errore nella query " . mysqli_error($connection) . "<br>");
    }

    $idR = getIdRipiano($ripiano);

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

function getIdPunto($punto)
{
    global $connection;

    $query = "SELECT * FROM punto 
                WHERE siglaPunto = '$punto';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idPunto'];
}

function getIdRipiano($ripiano)
{
    global $connection;

    $query = "SELECT * FROM ripiano 
                WHERE siglaRipiano = '$ripiano';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idRipiano'];
}


/* Istruzioni principali */
// aggiungiNumeroInventario();

/* Chiusura connessione al database */
// require('dbclose.php');

?>