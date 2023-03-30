<?php

/* Apertura connessione al database */
require('dbconnect.php');

/* Settaggio header */
/* header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
// header('Content-Type: application/text'); */

/* Raccolta variabili */
/* Reagente:
    * nome
    * aspetto
    * ditta produttrice
    * modalità di conservazione */

/* Vetreria/attrezzatura:
    * nome */

/* Strumentazione/apparecchiatura:
    * nome
    * numero d'inventario */

$nome = "";
$aspetto = "";
$dittaProduttrice = "";
$modalitaConservazione = "";
// raccolta nome
if(isset($_POST['nomeReagente'])) {
    $nome = $_POST['nomeReagente'];
}
// raccolta aspetto
if(isset($_POST['aspetto'])) {
    $aspetto = $_POST['aspetto'];
}
// raccolta ditta produttrice
if(isset($_POST['dittaProduttrice'])) {
    $dittaProduttrice = $_POST['dittaProduttrice'];
}
// raccolta modalita di conservazione
if(isset($_POST['modalitaConservazione'])) {
    $modalitaConservazione = $_POST['modalitaConservazione'];
}

function consultaReagenti($nome, $aspetto, $dittaProduttrice, $modalitaConservazione)
{
    global $connection;
    $query = "SELECT * FROM reagente
                INNER JOIN aspetto
                    ON reagente.idAspetto = aspetto.idAspetto
                INNER JOIN dittaproduttrice
                    ON reagente.idDitta = dittaproduttrice.idDitta
                INNER JOIN modalitaconservazione
                    ON reagente.idModalita = modalitaconservazione.idModalita";

    $filtro = "";
    $condizione = array();
    if((!empty($nome)) && ($nome != "")) {
        $filtro = $filtro . "Nome reagente: " . $nome . "<br>";
        $condizione[] = "nomeReagente LIKE '$nome%'";
    }
    if($aspetto != "") {
        $filtro = $filtro . "Stato: " . $aspetto . "<br>";
        $condizione[] = "statoMateria='$aspetto'";
    }
    if((!empty($dittaProduttrice)) && ($dittaProduttrice != "")) {
        $filtro = $filtro . "Ditta produttrice: " . $aspetto . "<br>";
        $condizione[] = "nomeDitta LIKE '$dittaProduttrice%'";
    }
    if((!empty($modalitaConservazione)) && ($modalitaConservazione != "")) {
        $filtro = $filtro . "Ditta produttrice: " . $aspetto . "<br>";
        $condizione[] = "modalita='$modalitaConservazione'";
    }

    if (count($condizione) > 0) {
        // echo "<b>Filtri:<br>" . $filtro . "</b><br>";
        $query .= " WHERE " . implode(' AND ', $condizione);
    }

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    return $result;
}

function stampaRisultatoReagenti($result)
{
    global $connection;
    
    if(($count = mysqli_affected_rows($connection)) != 0) {
        // estrapolazione dati
        while ($row = mysqli_fetch_array($result)) {
            // attributi: nomeReagente, formulaChimica, statoMateria
            echo "<tr>";
                echo "<td>" . $row['nomeReagente'] . "</td><td>" . $row['formulaChimica'] . "</td><td>" . $row['statoMateria'] . "</td><td>" . $row['nomeDitta'] . "</td>";
                echo "<td><a href=\"reagente.php?idReagente=" . $row['idReagente'] . "\"><button class=\"btn btn-warning\">Vai alla pagina del reagente</button></a></td>";
            echo "</tr>";
        }
    } else {
        echo "<b><br>Nessun reagente &#232; stato trovato</b>";
    }

    // liberazione spazio occupato dal risultatos
    mysqli_free_result($result);

    /* Chiusura connessione al database */
    require('dbclose.php');

    return $count;
}

/* Istruzioni principali */
/* $result = consultaReagenti($nome, $aspetto, $dittaProduttrice, $modalitaConservazione);
stampaRisultatoReagenti($result); */

?>