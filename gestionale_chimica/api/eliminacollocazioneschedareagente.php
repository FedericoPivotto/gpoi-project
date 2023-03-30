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

// idScheda
// <input type="hidden" name="idScheda" value="12">
    if(isset($_POST['idScheda'])) {
        $idScheda = $_POST['idScheda'];
        // echo "idScheda: |" . $idScheda . "|";
    }

// idReagente
// <input type="hidden" name="idReagente" value="12">
    if(isset($_POST['idReagente'])) {
        $idReagente = $_POST['idReagente'];
        // echo "idReagente: |" . $idReagente . "|";
    }

/* Funzioni */
function eliminaQuantitaScheda()
{
    global $connection;
    global $idRipiano, $idScheda;

    $query = "DELETE FROM situato_s_r 
                WHERE idRipiano = '$idRipiano' AND idScheda = '$idScheda';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

/* Istruzioni principali */
eliminaQuantitaScheda();
header("location: /reagente.php?idReagente=" . $idReagente);

/* Chiusura connessione al database */
require('dbclose.php');

?>