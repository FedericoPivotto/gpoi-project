<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per modificare quantita vetreria database
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
function modificaQuantitaVetreria($quantita, $dataVerifica, $dataScadenza, $idRipiano, $idVetreria)
{
    global $connection;
    // global $idRipiano, $idVetreria;

    $query = "UPDATE quantitava
                SET quantita = '$quantita', 
                    dataVerifica = '$dataVerifica', 
                    dataScadenza = '$dataScadenza'
                        WHERE idRipiano = '$idRipiano' AND idVA = '$idVetreria';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

function printHiddenInput()
{
    global $idRipiano, $idVetreria;

    echo "<input type=\"hidden\" name=\"idRipiano\" value=\"".$idRipiano."\">";
    echo "<input type=\"hidden\" name=\"idVetreria\" value=\"".$idVetreria."\">";
}

/* Istruzioni principali */
/*printHiddenInput(); // da collocare dentro al form di aggiornamento

if(isset($_POST['btnAggiorna']))
{*/
    // possibile redirect
    
    if( isset($_POST['quantita']) && isset($_POST['dataVerifica']) && isset($_POST['dataScadenza']) && isset($_POST['idRipiano']) && isset($_POST['idVetreria']) )
    {
        $quantita = $_POST['quantita'];
        $dataVerifica = $_POST['dataVerifica'];
        $dataScadenza = $_POST['dataScadenza'];

        $idRip = $_POST['idRipiano'];
        $idVet = $_POST['idVetreria'];

        modificaQuantitaVetreria($quantita, $dataVerifica, $dataScadenza, $idRip, $idVet);
        header("location: /vetreria.php?idVetreria=" . $idVet);
    }
//}

/* Chiusura connessione al database */
require('dbclose.php');

?>