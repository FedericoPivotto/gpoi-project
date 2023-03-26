<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per eliminare esperienza reagente dal database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// idEsperienza
// <input type="hidden" name="idEsperienza" value="12">
    if(isset($_POST['idEsperienza'])) {
        $idEsperienza = $_POST['idEsperienza'];
        // echo "idEsperienza: |" . $idEsperienza . "|";
    }

// idReagente
// <input type="hidden" name="idReagente" value="12">
    if(isset($_POST['idReagente'])) {
        $idReagente = $_POST['idReagente'];
        // echo "idReagente: |" . $idReagente . "|";
    }

/* Funzioni */
function eliminaEsperienza()
{
    global $connection;
    global $idEsperienza, $idReagente;

    $query = "DELETE FROM prevede_r_e 
                WHERE idEsperienza = '$idEsperienza' AND idReagente = '$idReagente';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

/* Istruzioni principali */
eliminaEsperienza();
header("location: /reagente.php?idReagente=" . $idReagente);

/* Chiusura connessione al database */
require('dbclose.php');

?>