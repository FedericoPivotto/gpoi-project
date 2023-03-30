<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per modificare quantita scheda reagente nel database
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
function modificaQuantitaScheda($quantita, $idRipiano, $idScheda)
{
    global $connection;
    // global $idRipiano, $idScheda, $idReagente;

    $query = "UPDATE situato_s_r
                SET quantita = '$quantita'
                        WHERE idRipiano = '$idRipiano' AND idScheda = '$idScheda';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

function printHiddenInput()
{
    global $idRipiano, $idScheda, $idReagente;

    echo "<input type=\"hidden\" name=\"idRipiano\" value=\"".$idRipiano."\">";
    echo "<input type=\"hidden\" name=\"idScheda\" value=\"".$idScheda."\">";
    echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$idReagente."\">";
}

/* Istruzioni principali */
/*printHiddenInput(); // da collocare dentro al form di aggiornamento

if(isset($_POST['btnAggiorna']))
{*/
    // possibile redirect
    
    if( isset($_POST['quantita']) && isset($_POST['idRipiano']) && isset($_POST['idScheda']) && isset($_POST['idReagente']))
    {
        $quantita = $_POST['quantita'];

        $idRip = $_POST['idRipiano'];
        $idSch = $_POST['idScheda'];
        $idReg = $_POST['idReagente'];

        modificaQuantitaScheda($quantita, $idRip, $idSch);
        header("location: /reagente.php?idReagente=" . $idReg);
    }
//}

/* Chiusura connessione al database */
require('dbclose.php');

?>