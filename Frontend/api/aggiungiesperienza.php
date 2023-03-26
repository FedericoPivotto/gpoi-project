<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per aggiungere nuove esperienze reagente nel database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// idReagente
// <input type="hidden" name="idReagente" value="12">
    if(isset($_POST['idReagente'])) {
        $idReagente = $_POST['idReagente'];
        echo "idReagente: |" . $idReagente . "|";
    }
// nomeEsperienza
    if(isset($_POST['nomeEsperienza'])) {
        $nomeEsperienza = $_POST['nomeEsperienza'];
        echo "nomeEsperienza: |" . $nomeEsperienza . "|";
    }
// linkEsperienza
    if(isset($_POST['linkEsperienza'])) {
        $linkEsperienza = $_POST['linkEsperienza'];
        echo "linkEsperienza: |" . $linkEsperienza . "|";
    }


/* Funzioni */

function aggiungiEsperienza()
{
    global $connection;
    global $idReagente;
    global $nomeEsperienza, $linkEsperienza;

    if(!checkEsperienza($nomeEsperienza, $linkEsperienza))
    {
        inserisciEsperienza();
    }

    $idEsperienza = getIdEsperienza($nomeEsperienza, $linkEsperienza);
    associaEsperienza($idEsperienza, $idReagente);
}

function associaEsperienza($idEsperienza, $idReagente)
{
    global $connection;

    echo "ESP: " .$idEsperienza. "REA: " . $idReagente . "<br>";
    $query = "INSERT INTO prevede_r_e (idReagente, idEsperienza) 
                VALUES ('$idReagente', '$idEsperienza');";
    $result = mysqli_query($connection, $query)
        or die ("7Errore nella query " . mysqli_error($connection) . "<br>");
}

function inserisciEsperienza()
{
    global $connection;
    global $nomeEsperienza, $linkEsperienza;

    $query = "INSERT INTO esperienzadidattica (nomeEsperienza, linkEsperienza) 
                VALUES ('$nomeEsperienza', '$linkEsperienza');";
    $result = mysqli_query($connection, $query)
        or die ("2Errore nella query " . mysqli_error($connection) . "<br>");
}

function checkEsperienza($nomeEsperienza, $linkEsperienza)
{
    global $connection;

    $query = "SELECT * FROM esperienzadidattica 
                WHERE nomeEsperienza = '$nomeEsperienza' AND linkEsperienza = '$linkEsperienza';";

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

function getIdEsperienza($nomeEsperienza, $linkEsperienza)
{
    global $connection;

    $query = "SELECT * FROM esperienzadidattica 
                WHERE nomeEsperienza = '$nomeEsperienza' AND linkEsperienza = '$linkEsperienza';";

    $result = mysqli_query($connection, $query)
        or die ("11Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idEsperienza'];
}


/* Istruzioni principali */
aggiungiEsperienza();
header("location: /reagente.php?idReagente=" . $idReagente);

/* Chiusura connessione al database */
require('dbclose.php');

?>