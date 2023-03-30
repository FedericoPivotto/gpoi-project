<?php
/* 
 * Progetto Gestionale Chimica - Lucchin Filippo, Pivotto Federico, Brunello Cesare, Guidolin Francesco
 * -> Script PHP per aggiungere nuove ditte produttrici al database
 * 
*/

/* Apertura connessione al database */
require('dbconnect.php');

/* Raccolta variabili */

// nome ditta
if(isset($_POST['nomeDitta'])) {
    $nomeDitta = $_POST['nomeDitta'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// indirizzo
if(isset($_POST['indirizzo'])) {
    $indirizzo = $_POST['indirizzo'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// telefono
if(isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// email
if(isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

// variabili di prova
/*
$nomeDitta = "nomeDitta_test2";
$indirizzo = "indirizzo_test";
$telefono = "telefono_test";
$email = "email_test";
*/

/* Funzioni */

// Aggiunta dati a tabella dittaproduttrice
function aggiungiDittaProduttrice()
{
    global $connection;
    global $nomeDitta;
    global $indirizzo;
    global $telefono;
    global $email;

    if(!checkDittaDoppia($nomeDitta, $indirizzo, $telefono, $email))
    {
        //query di inserimento
        $table = "dittaproduttrice";
        $insert = "INSERT INTO $table (nomeDitta, indirizzo, telefono, email) 
                        VALUES ('$nomeDitta', '$indirizzo', '$telefono', '$email');";
        
        if (mysqli_query($connection, $insert)) {
            // echo di prova
            //echo "<br>Nuovo record creato con successo!<br><br>";
        } else {
            echo "<br>Errore: " . $insert . "<br>" . mysqli_error($connection);
        }

        echo "<p style=\"color: green;\"><b>La nuova ditta produttrice &egrave; stata inserita con successo.</b></p><br>";
    }
    else
    {
        echo "<p style=\"color: red;\"><b>La ditta inserita risulta essere gi&agrave; esistente.</b></p><br>";
    }
}


// Controllo ditte duplicate (è sufficiente il nome)
function checkDittaDoppia($nomeDitta, $indirizzo, $telefono, $email)
{
    global $connection;

    $query = "SELECT * FROM dittaproduttrice 
                WHERE nomeDitta = '$nomeDitta' AND  indirizzo = '$indirizzo' AND telefono = '$telefono' AND  email = '$email';";

    $result = mysqli_query($connection, $query)
        or die ("18Errore nella query " . mysqli_error($connection) . "<br>");
    
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
aggiungiDittaProduttrice();
header("location: /aggiungi_dittaproduttrice.php");

/* Chiusura connessione al database */
require('dbclose.php');

?>