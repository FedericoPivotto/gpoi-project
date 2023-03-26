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

// idManuale
// <input type="hidden" name="idManuale" value="12">
    if(isset($_POST['idManuale'])) {
        $idManuale = $_POST['idManuale'];
        // echo "idManuale: |" . $idManuale . "|";
    }

// idStrumentazione
// <input type="hidden" name="idStrumentazione" value="12">
    if(isset($_POST['idStrumentazione'])) {
        $idStrumentazione = $_POST['idStrumentazione'];
        // echo "idStrumentazione: |" . $idStrumentazione . "|";
    }

/* Funzioni */
function modificaQuantitaManuale($quantita, $idRipiano, $idManuale)
{
    global $connection;
    // global $idRipiano, $idManuale, $idReagente;

    $query = "UPDATE situato_m_r
                SET quantita = '$quantita'
                        WHERE idRipiano = '$idRipiano' AND idManuale = '$idManuale';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

function printHiddenInput()
{
    global $idRipiano, $idManuale, $idStrumentazione;

    echo "<input type=\"hidden\" name=\"idRipiano\" value=\"".$idRipiano."\">";
    echo "<input type=\"hidden\" name=\"idManuale\" value=\"".$idManuale."\">";
    echo "<input type=\"hidden\" name=\"idStrumentazione\" value=\"".$idStrumentazione."\">";
}

/* Istruzioni principali */
/*printHiddenInput(); // da collocare dentro al form di aggiornamento

if(isset($_POST['btnAggiorna']))
{*/
    // possibile redirect
    
    if( isset($_POST['quantita']) && isset($_POST['idRipiano']) && isset($_POST['idManuale']) && isset($_POST['idStrumentazione']) && isset($_POST['numeroInventario']))
    {
        $quantita = $_POST['quantita'];

        $idRip = $_POST['idRipiano'];
        $idMan = $_POST['idManuale'];
        $idStr = $_POST['idStrumentazione'];
        $numeroInventario = $_POST['numeroInventario'];

        modificaQuantitaManuale($quantita, $idRip, $idMan);
        header("location: /strumentazione.php?idStrumentazione=" . $idStr . "&numeroInventario=" . $numeroInventario);
    }
//}

/* Chiusura connessione al database */
require('dbclose.php');

?>