<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per eliminare esperienza reagente dal database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// idUtente
    /* if(isset($_POST['idUtente'])) {
        $idUtente = $_POST['idUtente'];
        // echo "idUtente: |" . $idUtente . "|";
    } */

// id utenti
    if(!empty($_POST['check_list'])) {
        $utenti = $_POST['check_list'];
        // $pittogrammi_count = count($_POST['check_list']);
        // loop
        /*foreach($pittogrammi as $selected)
        {
            echo "<p>".$selected ."</p>";
        }*/
    }

/* Funzioni */

function eliminaUtenti()
{
    global $utenti;

    foreach($utenti as $idUtente)
    {
        // echo "<p>".$selected ."</p>";
        eliminaUtente($idUtente);
    }
}

function eliminaUtente($idUtente)
{
    global $connection;

    $query = "DELETE FROM utente 
                WHERE idUtente = '$idUtente';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
}

/* Istruzioni principali */
eliminaUtenti();
header("location: /admin.php");

/* Chiusura connessione al database */
require('dbclose.php');

?>