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

// idReagente
// <input type="hidden" name="idReagente" value="12">
    if(isset($_POST['idReagente'])) {
        $idReagente = $_POST['idReagente'];
        // echo "idReagente: |" . $idReagente . "|";
    }

/* Funzioni */
function eliminaQuantitaReagente()
{
    global $connection;
    global $idRipiano, $idReagente;

    $query = "DELETE FROM quantitar 
                WHERE idRipiano = '$idRipiano' AND idReagente = '$idReagente';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

/* Istruzioni principali */
eliminaQuantitaReagente();
header("location: /reagente.php?idReagente=" . $idReagente);

/* Chiusura connessione al database */
require('dbclose.php');

?>