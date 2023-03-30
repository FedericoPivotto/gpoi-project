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

$idVetreria = "";
// raccolta idVetreria
if(isset($_GET['idVetreria'])) {
    $idVetreria = $_GET['idVetreria'];
} else {
    echo "<b>La vetreria non è stata selezionato correttamente</b>";
}

// VARIABILI GLOBALI
// DATI REAGENTE
    $nomeVA;

    // VETRERIA - QUANTITA e DATE - COLLOCAZIONE
    // se esistono
    $vetreria_C_Q; // MATRICE
    /* $vetreria_C_Q[$i]['dataVerifica']
       $vetreria_C_Q[$i]['dataScadenza']
       $vetreria_C_Q[$i]['quantita']

       $vetreria_C_Q[$i]['siglaRipiano']
       $vetreria_C_Q[$i]['siglaPunto']
       $vetreria_C_Q[$i]['siglaStanza'] */


// STAMPA
function stampaDatiGeneraliVetreria()
{
    global $nomeVA;

    // DATI GENERALI
    echo $nomeVA . "<br>";
}

function stampaCollocazioneQuantitaVetreria()
{
    global $vetreria_C_Q;

    for($i = 0; $i < count($vetreria_C_Q); $i++)
    {
        echo "<tr>";
            echo "<td>".$vetreria_C_Q[$i]['siglaStanza']."</td>";
            echo "<td>".$vetreria_C_Q[$i]['siglaPunto']."</td>";
            echo "<td>".$vetreria_C_Q[$i]['siglaRipiano']."</td>";
            echo "<td>".$vetreria_C_Q[$i]['quantita']."</td>";
            echo "<td>".$vetreria_C_Q[$i]['dataVerifica']."</td>";
            echo "<td>".$vetreria_C_Q[$i]['dataScadenza']."</td>";

            echo "<td>";
                if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) {
                    // Modifica
                        echo "<a href=\"modifica_quantitavetreria.php?idVetreria=".$vetreria_C_Q[$i]['idVetreria']."&idRipiano=".$vetreria_C_Q[$i]['idRipiano']."\"><button type=\"submit\" class=\"btnAzioni btnModifica\"><img title=\"Modifica\" alt=\"Modifica\" src=\"media/bottoni/draw.svg\"/></button></a>";
                        //echo "<a href=\"modifica_quantitavetreria.php?idVetreria=".$vetreria_C_Q[$i]['idVetreria']."&idRipiano=".$vetreria_C_Q[$i]['idRipiano']."\"><input type=\"submit\" class=\"btn btn-warning\" value=\"Modifica\" name=\"btnAggiornaQuantita\"></a>"; // fare if per redirect
                    // Eliminazione
                        echo "<form method=\"POST\" action=\"api/eliminacollocazionevetreria.php\">";
                            echo "<input type=\"hidden\" name=\"idVetreria\" value=\"".$vetreria_C_Q[$i]['idVetreria']."\">";
                            echo "<input type=\"hidden\" name=\"idRipiano\" value=\"".$vetreria_C_Q[$i]['idRipiano']."\">";
                            echo "<button type=\"submit\" class=\"btnAzioni btnElimina\"><img title=\"Elimina\" alt=\"Elimina\" src=\"media/bottoni/can.svg\"/></button>";
                            //echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Elimina\">";
                        echo "</form>";
                }
            echo "</td>";

        echo "</tr>";
    }
}

function getCollocazioneQuantitaVetreria($idVetreria)
{
    global $connection;
    $query = "SELECT * FROM quantitava
                INNER JOIN ripiano
                    ON ripiano.idRipiano = quantitava.idRipiano
                INNER JOIN punto
                    ON punto.idPunto = ripiano.idPunto
                INNER JOIN collocazionefisica
                    ON collocazionefisica.idCollocazione = punto.idCollocazione
                WHERE quantitava.idVA = '$idVetreria';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $ret = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ret[$i]['dataVerifica'] = $row['dataVerifica'];
        $ret[$i]['dataScadenza'] = $row['dataScadenza'];
        $ret[$i]['quantita']     = $row['quantita'];

        $ret[$i]['siglaRipiano'] = $row['siglaRipiano'];
        $ret[$i]['siglaPunto']   = $row['siglaPunto'];
        $ret[$i]['siglaStanza']  = $row['siglaStanza'];

        $ret[$i]['idRipiano']   = $row['idRipiano'];
        $ret[$i]['idVetreria']  = $idVetreria;

        $i++;
    }

    return $ret;
}

function estraiSchedaVetreria($idVetreria)
{
    global $connection;
    
    // DATI SCHEDA REAGENTE
    global $nomeVA;
    global $vetreria_C_Q;

    $query = "SELECT * FROM vetreria_attrezzatura
                WHERE vetreria_attrezzatura.idVA = '$idVetreria';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    $row = mysqli_fetch_array($result);

    // DATI REAGENTE
    $nomeVA   = $row['nomeVA'];

    // VETRERIA - QUANTITA e DATE - COLLOCAZIONE
    // se esistono
    $vetreria_C_Q = getCollocazioneQuantitaVetreria($idVetreria);
        /* $vetreria_C_Q[$i]['dataVerifica']
           $vetreria_C_Q[$i]['dataScadenza']
           $vetreria_C_Q[$i]['quantita']

           $vetreria_C_Q[$i]['siglaRipiano']
           $vetreria_C_Q[$i]['siglaPunto']
           $vetreria_C_Q[$i]['siglaStanza'] */
}

/* Istruzioni principali */

/* Estrazione dati */
estraiSchedaVetreria($idVetreria);

/* Stampa dati */
/*stampaDatiGeneraliVetreria();
stampaCollocazioneQuantitaVetreria();*/

?>