<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per generare le credenziali utente e password
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Settaggio header */
/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");*/
// header('Content-Type: application/text');

include("dbconnect.php");

/* VARIABILI GLOBALI */
$utenti;

function getUtentiCategorie()
{
    global $connection;
    $query = "SELECT * FROM utente
                INNER JOIN categoria
                    ON categoria.idCategoria = utente.idCategoria
                ORDER BY categoria.nomeCategoria, utente.username;";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $ret = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ret[$i]['username']  = $row['username'];
        $ret[$i]['categoria'] = $row['nomeCategoria'];
        $ret[$i]['idUtente']  = $row['idUtente'];

        $i++;
    }

    return $ret;
}

function stampaUtentiCategorie()
{
    global $utenti;

    for($i = 0; $i < count($utenti); $i++)
    {
        echo "<tr>";
            echo "<td>".$utenti[$i]['username']."</td>";
            echo "<td>".$utenti[$i]['categoria']."</td>";
            echo "<td><input type=\"checkbox\" name=\"check_list[]\" id=\"".$utenti[$i]['idUtente']."\" value=\"".$utenti[$i]['idUtente']."\" class=\"form-check-input\"></td>";
        echo "</tr>";
    }
}

$utenti = getUtentiCategorie();

/* Chiusura connessione al database */
require('dbclose.php');
    
?>