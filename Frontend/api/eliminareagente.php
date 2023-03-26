<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per eliminare reagente dal database
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

/* Funzioni */
function eliminaReagente()
{
    global $connection;
    global $idReagente;

    // eliminazioni
    // relativi pittogrammi
    eliminaPittogrammi();
    // relative esperienze
    eliminaEsperienze();
    // relative quantita
    eliminaQuantita();

    // eliminazione finale
    $query = "DELETE FROM reagente 
                WHERE idReagente = '$idReagente';";
    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // relativa scheda di sicurezza e relative quantita
    eliminaSchedaQuantita();
}

function getIdScheda()
{
    global $connection;
    global $idReagente;

    $query = "SELECT * FROM reagente
                WHERE idReagente = '$idReagente';";

    $result = mysqli_query($connection, $query)
        or die ("5Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idScheda'];
}

// relativa scheda di sicurezza e relative quantita
function eliminaSchedaQuantita()
{
    global $connection;

    $idScheda = getIdScheda();

    // eliminazione collocazioni e quantita
    $query = "DELETE FROM situato_s_r 
            WHERE idScheda = '$idScheda';";

    $result = mysqli_query($connection, $query)
        or die ("69Errore nella query " . mysqli_error($connection) . "<br>");

    // eliminazione scheda
    $query = "DELETE FROM schedasicurezza 
            WHERE idScheda = '$idScheda';";
    $result = mysqli_query($connection, $query)
        or die ("67Errore nella query " . mysqli_error($connection) . "<br>");
}

// relativi pittogrammi
function eliminaPittogrammi()
{
    global $connection;
    global $idReagente;

    $query = "DELETE FROM possiede_r_p 
                WHERE idReagente = '$idReagente';";
    $result = mysqli_query($connection, $query)
        or die ("68Errore nella query " . mysqli_error($connection) . "<br>");
}

// relative esperienze
function eliminaEsperienze()
{
    global $connection;
    global $idReagente;

    $query = "DELETE FROM prevede_r_e 
                WHERE idReagente = '$idReagente';";
    $result = mysqli_query($connection, $query)
        or die ("68Errore nella query " . mysqli_error($connection) . "<br>");
}

// relative quantita
function eliminaQuantita()
{
    global $connection;
    global $idReagente;

    $query = "DELETE FROM quantitar 
                WHERE idReagente = '$idReagente';";
    $result = mysqli_query($connection, $query)
        or die ("70Errore nella query " . mysqli_error($connection) . "<br>");
}

/* Istruzioni principali */
eliminaReagente();
header("location: /gestione.php");

/* Chiusura connessione al database */
require('dbclose.php');

?>