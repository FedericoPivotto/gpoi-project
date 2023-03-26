<?php  

/* Apertura connessione al database */
require('dbconnect.php');

function stampaElencoStrumenti()
{
    global $connection;
    $query = "SELECT * FROM strumentazione_apparecchiatura;";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // estrapolazione dati
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value=\"".$row['nomeSA']."\">".$row['nomeSA']."</option>";
    }
    require('dbclose.php');
}

?>