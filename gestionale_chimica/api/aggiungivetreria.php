<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per aggiungere vetreria al database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */
if(isset($_POST['nomeVetreria'])) {
    $nomeVetreria = $_POST['nomeVetreria'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// variabile di prova
//$nomeVetreria = "nomeVA_test";

/* Funzioni */
function aggiungiVetreria()
{
	global $connection;
    global $nomeVetreria;
    
    //query di inserimento
    $table = "vetreria_attrezzatura";
    $insert = "INSERT INTO $table (nomeVA) 
                    VALUES ('$nomeVetreria');";
    if(!checkVetreria($nomeVetreria)) {
	    if (mysqli_query($connection, $insert)) {
	    	// echo di prova
	        //echo "<br>Nuovo record creato con successo!<br><br>Inserito $nomeVetreria<br><br>";
	    } else {
	        echo "<br>Errore: " . $insert . "<br>" . mysqli_error($connection);
	    }
        echo "<p style=\"color: green;\"><b>Il nuovo tipo di vetreria &egrave; stato inserito con successo.</b></p><br>";
    }
    else {
    	echo "<p style=\"color: red;\"><b>Il tipo di vetreria inserito &egrave; gi&agrave; presente.</b></p><br>";
    }
    require('dbclose.php');
}

function checkVetreria($nomeVetreria)
{
    global $connection;

    $query = "SELECT * FROM vetreria_attrezzatura 
                WHERE nomeVA = '$nomeVetreria';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}


/* Istruzioni principali */
//aggiungiVetreria();

/* Chiusura connessione al database */
//require('dbclose.php');

?>