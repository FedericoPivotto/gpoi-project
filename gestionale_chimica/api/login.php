<?php

/* Apertura connessione al database */
require('dbconnect.php');

/* Settaggio header */
/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");*/
// header('Content-Type: application/text');

/* Raccolta variabili */
$usernameUtente = "";
$passwordUtente = "";
// raccolta username
if(isset($_POST['username'])) {
    $usernameUtente = $_POST['username'];
}
// raccolta password
if(isset($_POST['password'])) {
    $passwordUtente = md5($_POST['password']); // password_hash($_POST['password'], PASSWORD_BCRYPT);
}

/* Funzioni */
function getCategoria($idCategoria)
{
    global $connection;
    $query = "SELECT * FROM categoria WHERE categoria.idCategoria = '$idCategoria';";
    $result = mysqli_query($connection, $query) 
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    $row = mysqli_fetch_array($result);
    $nomeCategoria = $row['nomeCategoria'];

    // liberazione spazio occupato dal risultato
    mysqli_free_result($result);

    return $nomeCategoria;
}

function controlloCredenziali($usernameUtente, $passwordUtente)
{
    global $connection;

    // codifica caratteri speciali
    $username = mysqli_real_escape_string($connection, $usernameUtente);

    // preparazione del template della query
    $stmt = $connection->prepare("SELECT * FROM utente WHERE utente.username = ? AND utente.password = ?;");
    // associazione delle variabili nel template ('s': tipo dato stringa)
    $stmt->bind_param('ss', $usernameUtente, $passwordUtente); // 'ss' perchè i parametri sono due stringhe

    // esecuzione della query
    $stmt->execute();

    // ottenimento risultati
    $result = $stmt->get_result();

    // estrazione del risultato
    $row = $result->fetch_assoc();

    /* $query = "SELECT * FROM utente WHERE utente.username = '$usernameUtente' AND utente.password = '$passwordUtente';";
    $result = mysqli_query($connection, $query) 
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    $row = mysqli_fetch_array($result);
    
    // session_start(); */
    
    // estrazione numero righe
    $count = $result->num_rows; // mysqli_affected_rows($connection);

    if($count == 1)
    {
        // login avvenuto
        $_SESSION['nomeCategoria'] = getCategoria($row['idCategoria']);
        $_SESSION['username']      = $usernameUtente;
        $_SESSION['isLogged']      = "yes";
        // header("location: /../home.html");
    }
    else
    {
        // login fallito
        http_response_code(401);
        $_SESSION['isLogged'] = "no";
        // header("location: /../login.php");*/
    }

    // liberazione spazio occupato dal risultato
    // mysqli_free_result($result);
    
    // chiusura esecuzione query
    $stmt->close();

    /* Chiusura connessione al database */
    require('api/dbclose.php');

    // return $count;
}

    // funzione per il controllo delle credenziali di login
    function login($username, $password) {
        global $connection;
        
        // codifica caratteri speciali
        $username = mysqli_real_escape_string($connection, $username);

        // preparazione del template della query
        $stmt = $connection->prepare("SELECT * FROM utente WHERE utente.username = ? AND utente.password = ?;");

        // associazione delle variabili nel template ('s': tipo dato stringa)
        $stmt->bind_param('ss', $username, $password); // 'ss' perchè i parametri sono due stringhe

        // esecuzione della query
        $stmt->execute();

        // ottenimento risultati
        $result = $stmt->get_result();

        // estrazione del risultato
        while ($row = $result->fetch_assoc()) {
            // login effettuato
            echo "<h2>Login effettuato come " . $row['username'] . "<h2>";
        }

        // login fallito
        if($result->num_rows == 0) {
            echo "<h2>Login fallito<h2>";
        }

        // chiusura esecuzione query
        $stmt->close();
    }

/* Istruzioni principali */
/* $count = controlloCredenziali($usernameUtente, $passwordUtente); */

/* Chiusura connessione al database */
/* require('dbclose.php'); */
