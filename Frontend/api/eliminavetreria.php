<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per eliminare reagente dal database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// idVetreria
// <input type="hidden" name="idVetreria" value="12">
    if(isset($_POST['idVetreria'])) {
        $idVetreria = $_POST['idVetreria'];
        // echo "idVetreria: |" . $idVetreria . "|";
    }

/* Funzioni */
function eliminaVetreria()
{
    global $connection;
    global $idVetreria;

    // eliminazioni
    // relative quantita
    eliminaQuantita();

    // eliminazione finale
    $query = "DELETE FROM vetreria_attrezzatura 
                WHERE idVA = '$idVetreria';";
    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

// relative quantita
function eliminaQuantita()
{
    global $connection;
    global $idVetreria;

    $query = "DELETE FROM quantitava 
                WHERE idVA = '$idVetreria';";
    $result = mysqli_query($connection, $query)
        or die ("70Errore nella query " . mysqli_error($connection) . "<br>");
}

/* Istruzioni principali */
eliminaVetreria();
header("location: /gestione.php");

/* Chiusura connessione al database */
require('dbclose.php');

?>