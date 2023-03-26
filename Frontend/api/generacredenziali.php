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

// -> ricevo categoria utente
// $categoriaUtente = ""; // assegnazione per eseguire test
if(isset($_POST['categoriaUtente'])) {
    $categoriaUtente = $_POST['categoriaUtente'];
} else {
    echo "Errore: non e' presente il dato in input";
    exit();
}

/* VARIABILI GLOBALI */
$utenti;

function getIdCategoria($categoriaUtente) {
    global $connection;

    $query = "SELECT * FROM categoria
                WHERE categoria.nomeCategoria = '$categoriaUtente';";

    if($result = mysqli_query($connection, $query)) {
        $row = mysqli_fetch_array($result);

        return $row['idCategoria'];
    } else {
        return 0;
    }
}

function setLettera() {
    global $categoriaUtente;

    // -> generazione letteraUtente e codiceCategoria
    $letteraUtente ="";
    if($categoriaUtente == "Studente") { // Studente
        $letteraUtente = 's';
    } else if($categoriaUtente == "ITP") { // ITP
        $letteraUtente = 't';
    } else if($categoriaUtente == "Docente") { // Docente
        $letteraUtente = 'd';
    } else {
        echo "Errore: la categoria dell'utente selezionata non esiste<br>";
        exit();
    }

    return $letteraUtente; 
}
    
// -> generatore di username
function genera_username($length) { // genera stringa numerica randomica
    $alfabeto = "1234567890";

    return substr(str_shuffle($alfabeto), 0, $length);
}

// -> generatore di password
function genera_password($length) { // genera stringa alfanumerica con 2 maiuscole, 2 numeri e 4 minuscole randomici
    $alfabeto_min = "qwertyuiopasdfghjklzxcvbnm";
    $alfabeto_maiu = "QWERTYUIOPASDFGHJKLZXCVBNM";
    $alfabeto_num = "1234567890";
    
    $min = substr(str_shuffle($alfabeto_min), 0, 4);
    $maiu = substr(str_shuffle($alfabeto_maiu), 0, 2);
    $num = substr(str_shuffle($alfabeto_num), 0, 2);
    
    $alfabeto = $min . $maiu . $num;
    
    return substr(str_shuffle($alfabeto), 0, $length);
}

function inserisciCredenziali($username, $password, $idCategoria)
{
    global $connection;
    // s85396; mh6e9BkA;
    // md5
    $password = md5($password);

    // inserimento dati nel db
    $table = 'utente';
    $insert = "INSERT INTO $table (username, password, idCategoria) 
                    VALUES ('$username','$password','$idCategoria');";
    
    if (mysqli_query($connection, $insert)) {
        // echo "<br>Nuovo record creato con successo!<br><br>";
    } else {
        echo "<br>Errore: " . $insert . "<br>" . mysqli_error($connection); // non dovrebbe accadere
    }
}

/* Istruzioni principali */
// -> creazione username
$username = setLettera() . genera_username(5);
// -> creazione password
$password = genera_password(8);
// -> get idCategoria
$idCategoria = getIdCategoria($categoriaUtente);
// -> inserimento credenziali nel database
if($idCategoria != 0) {
    inserisciCredenziali($username, $password, $idCategoria);

    /* TEST */
    /*echo "username generato: " . $username; // echo di prova
    echo "<br>";                            // echo di prova
    echo "password generata: " . $password; // echo di prova*/
}

/* Chiusura connessione al database */
require('dbclose.php');
    
?>