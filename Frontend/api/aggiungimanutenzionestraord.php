<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per aggiungere nuove manutenzioni straordinarie al database
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

// data manutenzione
if(isset($_POST['dataManutenzione'])) {
    $dataManutenzione = $_POST['dataManutenzione'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// azione
if(isset($_POST['azione'])) {
    $azione = $_POST['azione'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// variabili di prova
/*
$numeroInventario = "numeroInventario_01";
$dataManutenzione = "2020-05-04";
$azione = "azionestraordinaria_test";
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

// Aggiunta dati a tabella storicomanutenzione_straordinaria
function aggiungiManutenzioneStraord()
{
	global $connection;
    global $dataManutenzione;
    global $azione;
    global $numeroInventario;

    if(checkNumeroInventario($numeroInventario))
    {
	    $idInventario = estraiIdInventario();

	    if(!checkManutenzioneStraordDoppia($dataManutenzione, $azione, $idInventario))
	    {
	        //query di inserimento
	        $table = "storicomanutenzione_straordinaria";
	        $insert = "INSERT INTO $table (dataManutenzione, azione, idInventario) 
	                        VALUES ('$dataManutenzione', '$azione', '$idInventario');";
	        
	        if (mysqli_query($connection, $insert)) {
	            // echo di prova
	            //echo "<br>Nuovo record creato con successo!<br><br>";
	        } else {
	            echo "<br>Errore: " . $insert . "<br>" . mysqli_error($connection);
	        }

	        echo "<p style=\"color: green;\"><b>La nuova manutenzione ordinaria &egrave; stata inserita con successo.</b></p><br>";
	    }
	    else
	    {
	        echo "<p style=\"color: red;\"><b>La manutenzione ordinaria inserita risulta essere gi&agrave; esistente.</b></p><br>";
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

// Controllo manutenzioni straordinarie doppie
function checkManutenzioneStraordDoppia($dataManutenzione, $azione, $idInventario)
{
    global $connection;

    $query = "SELECT * FROM storicomanutenzione_straordinaria 
                WHERE dataManutenzione = '$dataManutenzione' AND  azione = '$azione' AND idInventario = '$idInventario';";

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
aggiungiManutenzioneStraord();
header("location: /strumentazione.php?idStrumentazione=" . $idStrumento . "&numeroInventario=" . $numeroInventario);

/* Chiusura connessione al database */
require('dbclose.php');

?>