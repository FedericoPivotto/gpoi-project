<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per eliminare reagente dal database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// idStrumento
// <input type="hidden" name="idStrumento" value="12">
    if(isset($_POST['idStrumento'])) {
        $idStrumento = $_POST['idStrumento'];
        // echo "idStrumento: |" . $idStrumento . "|";
    }

/* Funzioni */
function eliminaCategoriaStrumento()
{
    global $connection;
    global $idStrumento;
    
    // estrazione numeri di inventario
    $query = "SELECT * FROM inventario
                WHERE idSA = '$idStrumento';";
    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // estrapolazione dati
    while ($row = mysqli_fetch_array($result)) {
        eliminaStrumento($row['numeroInventario']);
    }

    // eliminazione finale categoria strumento
    $query = "DELETE FROM strumentazione_apparecchiatura 
                WHERE idSA = '$idStrumento';";
    $result = mysqli_query($connection, $query)
        or die ("33Errore nella query " . mysqli_error($connection) . "<br>");

    // relativa scheda di sicurezza e relative quantita
    eliminaManualeQuantita(); /////////////////////////
}


function getIdManuale()
{
    global $connection;
    global $idStrumento;

    $query = "SELECT * FROM strumentazione_apparecchiatura
                WHERE idSA = '$idStrumento';";

    $result = mysqli_query($connection, $query)
        or die ("5Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idManuale'];
}

// relativa scheda di sicurezza e relative quantita
function eliminaManualeQuantita()
{
    global $connection;

    $idManuale = getIdManuale();

    // eliminazione collocazioni e quantita
    $query = "DELETE FROM situato_m_r 
            WHERE idManuale = '$idManuale';";

    $result = mysqli_query($connection, $query)
        or die ("69Errore nella query " . mysqli_error($connection) . "<br>");

    // eliminazione scheda
    $query = "DELETE FROM manualeistruzioni 
            WHERE idManuale = '$idManuale';";
    $result = mysqli_query($connection, $query)
        or die ("67Errore nella query " . mysqli_error($connection) . "<br>");
}

function eliminaStrumento($numeroInventario)
{
    global $connection;
    global $idStrumento;

    // eliminazioni
    // relativo manuale delle istruzioni e relative quantita
    // eliminaManualeQuantita(); // da implementare in elimina categoria
    // relativo storico ordinario
    eliminaStoricoOrdinario();
    // relativo storico straordinario
    eliminaStoricoStraordinario();
    // relativo storico riparazioni
    eliminaStoricoRiparazioni();
    // relativa quantita (aggiornamento -1) ed eliminazione per sicurezza
    aggiornaQuantitaSA();
    eliminaQuantitaSA($idStrumento);

    // eliminazione finale
    $query = "DELETE FROM inventario 
                WHERE idSA = '$idStrumento' AND numeroInventario = '$numeroInventario';";
    $result = mysqli_query($connection, $query)
        or die ("79Errore nella query " . mysqli_error($connection) . "<br>");
}

function getIdInventario()
{
    global $connection;
    global $numeroInventario;

    $query = "SELECT * FROM inventario
                WHERE numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("5Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idInventario'];
}

// relativo storico ordinario
function eliminaStoricoOrdinario()
{
    global $connection;
    global $numeroInventario;

    $idInventario = getIdInventario();

    $query = "DELETE FROM storicomanutenzione_ordinaria 
                WHERE idInventario = '$idInventario';";
    $result = mysqli_query($connection, $query)
        or die ("66Errore nella query " . mysqli_error($connection) . "<br>");
}

// relativo storico straordinario
function eliminaStoricoStraordinario()
{
    global $connection;
    global $numeroInventario;

    $idInventario = getIdInventario();

    $query = "DELETE FROM storicomanutenzione_straordinaria 
                WHERE idInventario = '$idInventario';";
    $result = mysqli_query($connection, $query)
        or die ("55Errore nella query " . mysqli_error($connection) . "<br>");
}

// relativo storico riparazioni
function eliminaStoricoRiparazioni()
{
    global $connection;
    global $numeroInventario;

    $idInventario = getIdInventario();

    $query = "DELETE FROM riparazione 
                WHERE idInventario = '$idInventario';";
    $result = mysqli_query($connection, $query)
        or die ("88Errore nella query " . mysqli_error($connection) . "<br>");
}

function getIdRipiano()
{
    global $connection;
    global $numeroInventario;

    $query = "SELECT * FROM inventario
                WHERE numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("5Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idRipiano'];
}

// relativa quantita (aggiornamento -1)
function aggiornaQuantitaSA()
{
    global $idStrumento;

    $idRipiano = getIdRipiano();
    aggiornaQuantita($idStrumento, $idRipiano);
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

// datascadenza sarà da togliere
function aggiornaQuantita($idSA, $idRipiano)
{
    global $connection;

    $newQuantita = getQuantita($idSA, $idRipiano) - 1;
    $today = date("Y/m/d");
    $query = "UPDATE quantitasa
                SET quantita = '$newQuantita', dataVerifica = '$today', dataScadenza = '$today'
                WHERE idSA = '$idSA' AND idRipiano = '$idRipiano';";

    $result = mysqli_query($connection, $query)
        or die ("21Errore nella query " . mysqli_error($connection) . "<br>");
}

function eliminaQuantitaSA($idSA)
{
    global $connection;

    $query = "DELETE FROM quantitasa 
                WHERE idSA = '$idSA';";
    $result = mysqli_query($connection, $query)
        or die ("22Errore nella query " . mysqli_error($connection) . "<br>");
}


/* Istruzioni principali */
eliminaCategoriaStrumento();
header("location: /gestione.php");

/* Chiusura connessione al database */
require('dbclose.php');

?>