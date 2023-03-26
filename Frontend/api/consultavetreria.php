<?php

/* Apertura connessione al database */
require('dbconnect.php');

/* Settaggio header */
/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");*/
// header('Content-Type: application/text');

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
// raccolta nome
if(isset($_POST['nomeVetreria'])) {
    $nome = $_POST['nomeVetreria'];
}

function consultaVetreria($nome)
{
    global $connection;
    $query = "SELECT * FROM vetreria_attrezzatura";

    $filtro = "";
    $condizione = array();
    if((!empty($nome)) && ($nome != "")) {
        $filtro = $filtro . "Nome vetreria: " . $nome . "<br>";
        $condizione[] = "nomeVA='$nome'";
    }

    if (count($condizione) > 0) {
        // echo "<b>Filtri:<br>" . $filtro . "</b><br>";
        $query .= " WHERE " . implode(' AND ', $condizione);
    }

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    return $result;
}

function stampaRisultatoVetreria($result)
{
    global $connection;
    
    if(($count = mysqli_affected_rows($connection)) != 0) {
        // estrapolazione dati
        while ($row = mysqli_fetch_array($result)) {
            // attributi: nomeVA
            echo "<tr>";
                echo "<td>" . $row['nomeVA'] . "</td>";
                echo "<td><a href=\"vetreria.php?idVetreria=" . $row['idVA'] . "\"><button class=\"btn btn-warning\">Vai alla pagina della vetreria</button></a></td>";
            echo "</tr>";
        }
    } else {
        echo "<b>Nessuna vetreria &#232; stata trovata</b>";
    }

    // liberazione spazio occupato dal risultatos
    mysqli_free_result($result);

    /* Chiusura connessione al database */
    require('dbclose.php');

    return $count;
}

/* Istruzioni principali */
/* $result = consultaVetreria($nome);
stampaRisultatoVetreria($result); */

?>