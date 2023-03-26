<?php

/* Apertura connessione al database */
require('dbconnect.php');

function tuttiStrumentazione()
{
    global $connection;
    $query = "SELECT * FROM strumentazione_apparecchiatura;";
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
                echo "<td>" . $row['nomeSA'] . "</td>";

                // Eliminazione
                    echo "<td><form method=\"POST\" action=\"api/eliminatipostrumento.php\">";
                        echo "<input type=\"hidden\" name=\"idStrumento\" value=\"".$row['idSA']."\">";
                        echo "<button type=\"submit\" class=\"btnAzioni btnElimina\"><img title=\"Elimina\" alt=\"Elimina\" src=\"media/bottoni/can.svg\"/></button>";
                        //echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Elimina\">";
                    echo "</form></td>";

            echo "</tr>";
        }
    } else {
        echo "<b>Nessun reagente &#232; stato trovato</b>";
    }

    // liberazione spazio occupato dal risultatos
    mysqli_free_result($result);

    return $count;
}

function tuttiInventario()
{
    global $connection;
    $query = "SELECT * FROM inventario;";
    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    return $result;
}

function getNomeStrumento($numeroInventario)
{
    global $connection;

    $query = "SELECT * FROM inventario
                INNER JOIN strumentazione_apparecchiatura
                    ON inventario.idSA = strumentazione_apparecchiatura.idSA 
                WHERE numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("11Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['nomeSA'];
}

function stampaRisultatoInventario($result)
{
    global $connection;
    
    if(($count = mysqli_affected_rows($connection)) != 0) {
        // estrapolazione dati
        while ($row = mysqli_fetch_array($result)) {
            // attributi: nomeReagente, formulaChimica, statoMateria
            echo "<tr>";
                echo "<td>" . getNomeStrumento($row['numeroInventario']) . "</td>";
                echo "<td>" . $row['numeroInventario'] . "</td>";
                
                // Eliminazione
                    echo "<td><form method=\"POST\" action=\"api/eliminastrumento.php\">";
                        echo "<input type=\"hidden\" name=\"numeroInventario\" value=\"".$row['numeroInventario']."\">";
                        echo "<button type=\"submit\" class=\"btnAzioni btnElimina\"><img title=\"Elimina\" alt=\"Elimina\" src=\"media/bottoni/can.svg\"/></button>";
                        //echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Elimina\">";
                    echo "</form></td>";

            echo "</tr>";
        }
    } else {
        echo "<b>Nessun reagente &#232; stato trovato</b>";
    }

    // liberazione spazio occupato dal risultatos
    mysqli_free_result($result);

    /* Chiusura connessione al database */
    require('dbclose.php');

    return $count;
}

function stampaStrumenti()
{
    stampaRisultatoStrumentazione(tuttiStrumentazione());
}

function stampaInventario()
{
    stampaRisultatoInventario(tuttiInventario());
}


/* Istruzioni principali */

/* Chiusura connessione database */
require('dbclose.php');

?>