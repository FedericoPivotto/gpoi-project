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


/* Funzioni */

/* Reagente */
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

    // <option value="solido">Solido</option>
}

function stampaElencoConservazioni()
{
    global $connection;
    $query = "SELECT * FROM modalitaconservazione;";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value=\"".$row['modalita']."\">".$row['modalita']."</option>";
    }

    // <option value="contenitore_chiuso">Contenitore chiuso</option>
}

/* Vetreria */
function stampaElencoVetreria()
{
    global $connection;
    $query = "SELECT * FROM vetreria_attrezzatura;";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value=\"".$row['idVA']."\">".$row['nomeVA']."</option>";
    }

    // <option value="cilindro">Cilindri</option>
}

/* Strumentazione */
/* nulla */


/* Istruzioni principali */
/*stampaElencoAspetto();
stampaElencoConservazioni();
stampaElencoVetreria();*/

/* Chiusura connessione al database */
/* require('dbclose.php'); */

?>