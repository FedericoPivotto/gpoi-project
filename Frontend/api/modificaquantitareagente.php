<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per modificare quantita reagente database
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
function modificaQuantitaReagente($quantita, $dataVerifica, $dataScadenza, $idRipiano, $idReagente)
{
    global $connection;
    // global $idRipiano, $idReagente;

    $query = "UPDATE quantitar
                SET quantita = '$quantita', 
                    dataVerifica = '$dataVerifica', 
                    dataScadenza = '$dataScadenza'
                        WHERE idRipiano = '$idRipiano' AND idReagente = '$idReagente';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

function printHiddenInput()
{
    global $idRipiano, $idReagente;

    echo "<input type=\"hidden\" name=\"idRipiano\" value=\"".$idRipiano."\">";
    echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$idReagente."\">";
}

/* Istruzioni principali */
// printHiddenInput(); // da collocare dentro al form di aggiornamento

// if(isset($_POST['btnAggiorna']))
// {
    // possibile redirect
    
    if( isset($_POST['quantita']) && isset($_POST['dataVerifica']) && isset($_POST['dataScadenza']) && isset($_POST['idRipiano']) && isset($_POST['idReagente']) )
    {
        $quantita = $_POST['quantita'];
        $dataVerifica = $_POST['dataVerifica'];
        $dataScadenza = $_POST['dataScadenza'];

        $idRip = $_POST['idRipiano'];
        $idReg = $_POST['idReagente'];

        modificaQuantitaReagente($quantita, $dataVerifica, $dataScadenza, $idRip, $idReg);
        header("location: /reagente.php?idReagente=" . $idReg);
    }
// }

/* Chiusura connessione al database */
require('dbclose.php');

?>