<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per aggiungere nuove riparazioni al database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// numero inventario
if(isset($_POST['numeroInventario'])) {
    $numeroInventario = $_POST['numeroInventario'];
    $idStrumento = getIdStrumento($numeroInventario);
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// data riparazione
if(isset($_POST['dataRiparazione'])) {
    $dataRiparazione = $_POST['dataRiparazione'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// motivazione
if(isset($_POST['motivazione'])) {
    $motivazione = $_POST['motivazione'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// variabili di prova
/*
$numeroInventario = "numeroInventario_01";
$dataRiparazione = "2020-05-04";
$motivazione = "testo_test";
*/

/* Funzioni */

function getIdStrumento($numeroInventario)
{
    global $connection;

    $query = "SELECT * FROM inventario 
                WHERE numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("50Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idSA'];
}

// Aggiunta dati a tabella riparazione
function aggiungiRiparazione()
{
	global $connection;
    global $dataRiparazione;
    global $motivazione;
    global $numeroInventario;

    if(checkNumeroInventario($numeroInventario))
    {
	    $idInventario = estraiIdInventario();

	    if(!checkRiparazioneDoppia($dataRiparazione, $motivazione, $idInventario))
	    {
	        //query di inserimento
	        $table = "riparazione";
	        $insert = "INSERT INTO $table (dataRiparazione, motivazione, idInventario) 
	                        VALUES ('$dataRiparazione', '$motivazione', '$idInventario');";
	        
	        if (mysqli_query($connection, $insert)) {
	            // echo di prova
	            //echo "<br>Nuovo record creato con successo!<br><br>";
	        } else {
	            echo "<br>Errore: " . $insert . "<br>" . mysqli_error($connection);
	        }

	        echo "<p style=\"color: green;\"><b>La nuova riparazione &egrave; stata inserita con successo.</b></p><br>";
	    }
	    else
	    {
	        echo "<p style=\"color: red;\"><b>La riparazione inserita risulta essere gi&agrave; esistente.</b></p><br>";
	    }
    }
    else
    {
        echo "<p style=\"color: red;\"><b>Il numero inventario inserito non esiste.</b></p><br>";
    }
}

// Controllo esistenza numero inventario
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

// Controllo manutenzioni ordinarie doppie
function checkRiparazioneDoppia($dataRiparazione, $motivazione, $idInventario)
{
    global $connection;

    $query = "SELECT * FROM riparazione 
                WHERE dataRiparazione = '$dataRiparazione' AND  motivazione = '$motivazione' AND idInventario = '$idInventario';";

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

// Estrazione idInventario da tabella inventario
function estraiIdInventario()
{
    global $connection;
    global $numeroInventario;

    //query di ricerca
    $table = "inventario";
    $query = "SELECT idInventario FROM $table WHERE numeroInventario='$numeroInventario';";

    $result = mysqli_query($connection, $query) 
        or die(mysql_error());

    while($row = mysqli_fetch_array($result)){
        $idInventario = $row['idInventario'];
    }

    return $idInventario;
}


/* Istruzioni principali */
aggiungiRiparazione();
header("location: /strumentazione.php?idStrumentazione=" . $idStrumento . "&numeroInventario=" . $numeroInventario);

/* Chiusura connessione al database */
require('dbclose.php');

?>