<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per eliminare quantita reagente dal database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// idRipiano
// <input type="hidden" name="idRipiano" value="12">
    if(isset($_POST['idRipiano'])) {
        $idRipiano = $_POST['idRipiano'];
        // echo "idRipiano: |" . $idRipiano . "|";
    }

// idManuale
// <input type="hidden" name="idManuale" value="12">
    if(isset($_POST['idManuale'])) {
        $idManuale = $_POST['idManuale'];
        // echo "idManuale: |" . $idManuale . "|";
    }

// idStrumento, numeroInventario
// <input type="hidden" name="numeroInventario" value="12">
    if(isset($_POST['numeroInventario'])) {
        $numeroInventario = $_POST['numeroInventario'];
        $idStrumento = getIdStrumento($numeroInventario);
        // echo "idStrumento: |" . $idStrumento . "|";
    }

/* Funzioni */
function getIdStrumento($numeroInventario)
{
    global $connection;

    $query = "SELECT * FROM inventario 
                WHERE numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("11Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idSA'];
}

function eliminaQuantitaManuale()
{
    global $connection;
    global $idRipiano, $idManuale;

    $query = "DELETE FROM situato_m_r 
                WHERE idRipiano = '$idRipiano' AND idManuale = '$idManuale';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

/* Istruzioni principali */
eliminaQuantitaManuale();
header("location: /strumentazione.php?idStrumentazione=" . $idStrumento . "&numeroInventario=" . $numeroInventario);

/* Chiusura connessione al database */
require('dbclose.php');

?>