<?php

require('parametri.php');

/* Apertura connessione al database */
$connection = mysqli_connect($server, $username, $password)
    or die("Connessione non riuscita: " . mysqli_error($connection) . ".<br>");

mysqli_select_db($connection, $database)
    or die ("Impossibile selezionare il database<br>");

?>