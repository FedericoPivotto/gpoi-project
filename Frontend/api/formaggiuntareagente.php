<?php  

/* Apertura connessione al database */
require('dbconnect.php');

// Elenco aspetto
function stampaElencoAspetto()
{
    global $connection;
    $query = "SELECT * FROM aspetto;";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // estrapolazione dati
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value=\"".$row['statoMateria']."\">".$row['statoMateria']."</option>";
    }
}

// Elenco ditte produttrici
function stampaElencoDittaProduttrice()
{
    global $connection;
    $query = "SELECT * FROM dittaproduttrice;";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // estrapolazione dati
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value=\"".$row['nomeDitta']."\">".$row['nomeDitta']."</option>";
    }
}

// Elenco pittogrammi
function stampaElencoPittogrammi()
{
    global $connection;
    $query = "SELECT * FROM pittogrammasicurezza;";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // estrapolazione dati
    while ($row = mysqli_fetch_array($result)) {
        echo "<input type=\"checkbox\" name=\"check_list[]\" id=\"".$row['idPittogramma']."\" value=\"".$row['idPittogramma']."\" class=\"form-check-input pittogramma\">";
        echo "<label for=\"".$row['idPittogramma']."\" class=\"form-check-label check\">";
        echo "<img title=\"".$row['fraseRischio']."\" alt=\"".$row['fraseRischio']."\" src=\"".$row['linkSimbolo']."\" width=\"50\" height=\"50\"/>";
        echo "</label>";
    }

    /* Chiusura connessione al database */
    require('dbclose.php');
}

/* Istruzioni principali */
/*stampaElencoAspetto();
stampaElencoDittaProduttrice();
stampaElencoPittogrammi();*/

?>