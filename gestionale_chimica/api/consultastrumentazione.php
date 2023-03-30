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
$inventario = "";
// raccolta nome
if(isset($_POST['nomeAttrezzatura'])) {
    $nome = $_POST['nomeAttrezzatura'];
}
// raccolta aspetto
if(isset($_POST['numeroInventario'])) {
    $inventario = $_POST['numeroInventario'];
}

function consultaStrumentazione($nome, $inventario)
{
    global $connection;
    $query = "SELECT * FROM strumentazione_apparecchiatura";
    $innerJoin = " INNER JOIN inventario ON inventario.idSA = strumentazione_apparecchiatura.idSA ";
    $query = $query . $innerJoin;

    $filtro = "";
    $condizione = array();
    if((!empty($nome)) && ($nome != "")) {
        $filtro = $filtro . "Nome Strumentazione: " . $nome . "<br>";
        $condizione[] = "nomeSA LIKE '$nome%'";
    }
    if($inventario != "") {
        $filtro = $filtro . "Numero d'inventario: " . $inventario . "<br>";
        $condizione[] = "numeroInventario='$inventario'";
    }

    if (count($condizione) > 0) {
        // echo "<b>Filtri:<br>" . $filtro . "</b><br>";
        $query .= " WHERE " . implode(' AND ', $condizione);
    }

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    return $result;
}

function stampaRisultatoStrumentazione($result)
{
    global $connection;
    
    if(($count = mysqli_affected_rows($connection)) != 0) {
        // estrapolazione dati
        while ($row = mysqli_fetch_array($result)) {
            // attributi: nomeReagente, formulaChimica, statoMateria
            echo "<tr>";
                echo "<td>" . $row['nomeSA'] . "</td>" . "<td>" . $row['numeroInventario'] . "</td>";
                    echo "<td><a href=\"strumentazione.php?idStrumentazione=" . $row['idSA'] . "&numeroInventario=" . $row['numeroInventario'] . "\"><button class=\"btn btn-warning\">Vai alla pagina dello strumento</button></a></td>";
            echo "</tr>";
        }
    } else {
        echo "<b>Nessun strumento &#232; stato trovato</b>";
    }

    // liberazione spazio occupato dal risultatos
    mysqli_free_result($result);

    /* Chiusura connessione al database */
    require('dbclose.php');

    return $count;
}

/* Istruzioni principali */
/*$result = consultaStrumentazione($nome, $inventario);
stampaRisultatoStrumentazione($result); */

?>