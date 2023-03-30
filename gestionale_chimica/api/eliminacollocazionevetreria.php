<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per eliminare quantita vetreria dal database
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

// idVetreria
// <input type="hidden" name="idVetreria" value="12">
    if(isset($_POST['idVetreria'])) {
        $idVetreria = $_POST['idVetreria'];
        // echo "idVetreria: |" . $idVetreria . "|";
    }

/* Funzioni */
function eliminaQuantitaVetreria()
{
    global $connection;
    global $idRipiano, $idVetreria;

    $query = "DELETE FROM quantitava 
                WHERE idRipiano = '$idRipiano' AND idVA = '$idVetreria';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

/* Istruzioni principali */
eliminaQuantitaVetreria();
header("location: /vetreria.php?idVetreria=" . $idVetreria);

/* Chiusura connessione al database */
require('dbclose.php');

?>