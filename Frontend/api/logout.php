<?php

/* Settaggio header */
/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");*/
// header("Content-Type: application/text");

function logout()
{
	session_start();
    $_SESSION = array();
    session_destroy();
    header("location: /../login.php");
}

logout();

?>