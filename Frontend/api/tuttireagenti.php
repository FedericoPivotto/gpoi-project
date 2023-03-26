<?php

/* Apertura connessione al database */
require('dbconnect.php');

function tuttiReagenti()
{
    global $connection;
    $query = "SELECT * FROM reagente;";
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
                echo "<td>" . $row['nomeReagente'] . "</td>";
                
                // Eliminazione
                    echo "<td><form method=\"POST\" action=\"api/eliminareagente.php\">";
                        echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$row['idReagente']."\">";
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

/* Istruzioni principali */
$result = tuttiReagenti();
stampaRisultatoReagenti($result);

/* Chiusura connessione database */
require('dbconnect.php');

?>