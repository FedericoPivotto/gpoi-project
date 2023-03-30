<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per modificare quantita reagente database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// numeroInventario
// <input type="hidden" name="numeroInventario" value="12">
    if(isset($_POST['numeroInventario'])) {
        $numeroInventario = $_POST['numeroInventario'];
        // echo "numeroInventario: |" . $numeroInventario . "|";
    }

/* Funzioni */
function modificaCollocazioneStrumento($collocazione, $punto, $ripiano, $numeroInventario, $idSA)
{
    global $connection;
    
    // global $numeroInventario;

    // diminuzione quantita
    diminuisciQuantitaCollocazione(getVecchioIdRipiano($numeroInventario), $idSA);

    $idRipiano = inserisciNuovaCollocazione($collocazione, $punto, $ripiano);

    $query = "UPDATE inventario
                SET idRipiano = '$idRipiano'
                        WHERE numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // aumento quantita
    if(checkQuantitaSA($idRipiano, $idSA))
    {
        aumentaQuantitaCollocazione($idRipiano, $idSA);
    }
    else
    {
        inserisciQuantitaSA($idRipiano, $idSA);
    }
}

function inserisciQuantitaSA($idRipiano, $idSA)
{
    global $connection;

    $today = date("Y/m/d");
    $query = "INSERT INTO quantitasa (idSA, idRipiano, quantita, dataVerifica, dataScadenza) 
                VALUES ('$idSA', '$idRipiano', 1, '$today', '$today');";
    $result = mysqli_query($connection, $query)
        or die ("2Errore nella query " . mysqli_error($connection) . "<br>");
}

function checkQuantitaSA($idRipiano, $idSA)
{
    global $connection;

    $query = "SELECT * FROM quantitasa 
                WHERE idRipiano = '$idRipiano' AND idSA = '$idSA';";

    $result = mysqli_query($connection, $query)
        or die ("14Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function aumentaQuantitaCollocazione($idRipiano, $idSA)
{
    global $connection;
    // global $idRipiano, $idSA;

    $quantita = getQuantitaStrumento($idRipiano, $idSA) + 1;
    $today = date("Y/m/d");
    $query = "UPDATE quantitasa
                SET quantita = '$quantita', 
                    dataVerifica = '$today', 
                    dataScadenza = '$today'
                        WHERE idRipiano = '$idRipiano' AND idSA = '$idSA';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

function diminuisciQuantitaCollocazione($idRipiano, $idSA)
{
    global $connection;
    // global $idRipiano, $idSA;

    $quantita = getQuantitaStrumento($idRipiano, $idSA) - 1;

    if($quantita < 1)
    {
        eliminaCollocazioneStrumento($idRipiano, $idSA);
    }
    else
    {
        $today = date("Y/m/d");
        $query = "UPDATE quantitasa
                    SET quantita = '$quantita', 
                        dataVerifica = '$today', 
                        dataScadenza = '$today'
                            WHERE idRipiano = '$idRipiano' AND idSA = '$idSA';";

        $result = mysqli_query($connection, $query)
            or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    }
}

function getQuantitaStrumento($idRipiano, $idSA)
{
    global $connection;

    $query = "SELECT * FROM quantitasa 
                WHERE idRipiano = '$idRipiano' AND idSA = '$idSA';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['quantita'];
}

function getVecchioIdRipiano($numeroInventario)
{
    global $connection;

    $query = "SELECT * FROM inventario 
                WHERE numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idRipiano'];
}

function eliminaCollocazioneStrumento($idRipiano, $idSA)
{
    global $connection;

    $query = "DELETE FROM quantitasa 
                WHERE idSA = '$idSA' AND idRipiano = '$idRipiano';";
    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

function printHiddenInput()
{
    global $numeroInventario;

    echo "<input type=\"hidden\" name=\"numeroInventario\" value=\"".$numeroInventario."\">";
}

function inserisciNuovaCollocazione($collocazione, $punto, $ripiano)
{
    global $connection;

    // aggiunto controllo esistenza
    if(!checkCollocazione($collocazione))
    {
        $queryCollocazione = "INSERT INTO collocazionefisica (siglaStanza) VALUES ('$collocazione')";
        $resultC = mysqli_query($connection, $queryCollocazione)
            or die ("8Errore nella query " . mysqli_error($connection) . "<br>");
    }

    $idC = getIdCollocazione($collocazione);
    // aggiunto controllo esistenza
    if(!checkPunto($punto, $idC))
    {
        $queryPunto        = "INSERT INTO punto (siglaPunto, idCollocazione) VALUES ('$punto', '$idC')";
        $resultP = mysqli_query($connection, $queryPunto)
            or die ("9Errore nella query " . mysqli_error($connection) . "<br>");
    }

    $idP = getIdPunto($punto, $idC);
    // aggiunto controllo esistenza
    if(!checkRipiano($ripiano, $idP))
    {
        $queryRipiano      = "INSERT INTO ripiano (siglaRipiano, idPunto) VALUES ('$ripiano', '$idP')";
        $resultR = mysqli_query($connection, $queryRipiano)
            or die ("10Errore nella query " . mysqli_error($connection) . "<br>");
    }

    $idR = getIdRipiano($ripiano, $idP);

    return $idR;
}

function checkCollocazione($collocazione)
{
    global $connection;

    $query = "SELECT * FROM collocazionefisica 
                WHERE siglaStanza = '$collocazione';";

    $result = mysqli_query($connection, $query)
        or die ("13Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function checkPunto($punto, $idC)
{
    global $connection;

    $query = "SELECT * FROM punto 
                WHERE siglaPunto = '$punto' AND idCollocazione = '$idC';";

    $result = mysqli_query($connection, $query)
        or die ("14Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function checkRipiano($ripiano, $idP)
{
    global $connection;

    $query = "SELECT * FROM ripiano 
                WHERE siglaRipiano = '$ripiano' AND idPunto = '$idP';";

    $result = mysqli_query($connection, $query)
        or die ("15Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function getIdCollocazione($collocazione)
{
    global $connection;

    $query = "SELECT * FROM collocazionefisica 
                WHERE siglaStanza = '$collocazione';";

    $result = mysqli_query($connection, $query)
        or die ("11Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idCollocazione'];
}

function getIdPunto($punto, $idC)
{
    global $connection;

    $query = "SELECT * FROM punto 
                WHERE siglaPunto = '$punto' AND idCollocazione = '$idC';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idPunto'];
}

function getIdRipiano($ripiano, $idP)
{
    global $connection;

    $query = "SELECT * FROM ripiano 
                WHERE siglaRipiano = '$ripiano' AND idPunto = '$idP';";

    $result = mysqli_query($connection, $query)
        or die ("12Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idRipiano'];
}

/* Istruzioni principali */
/*printHiddenInput(); // da collocare dentro al form di aggiornamento

if(isset($_POST['btnAggiorna']))
{*/
    // possibile redirect
    
    if( isset($_POST['stanza']) && isset($_POST['armadio']) && isset($_POST['ripiano']) && isset($_POST['numeroInventario']) && isset($_POST['idStrumentazione']) )
    {
        $stanza  = $_POST['stanza'];
        $armadio = $_POST['armadio'];
        $ripiano = $_POST['ripiano'];

        $numeroInventario = $_POST['numeroInventario'];
        $idStrumentazione = $_POST['idStrumentazione'];

        modificaCollocazioneStrumento($stanza, $armadio, $ripiano, $numeroInventario, $idStrumentazione);
        header("location: /strumentazione.php?idStrumentazione=" . $idStrumentazione . "&numeroInventario=" . $numeroInventario);
    }
//}

/* Chiusura connessione al database */
require('dbclose.php');

?>