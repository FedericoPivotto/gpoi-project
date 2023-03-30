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

$idReagente = "";
// raccolta idReagente
if(isset($_GET['idReagente'])) {
    $idReagente = $_GET['idReagente'];
} else {
    echo "<b>Il reagente non è stato selezionato correttamente</b>";
}

// VARIABILI GLOBALI
// DATI REAGENTE
    $nomeReagente;
    $formulaChimica;
    $statoMateria;
    
    // DITTA PRODUTTRICE
    $nomeDitta;
    $indirizzo;
    $telefono;
    $email;
    
    // MODALITA DI CONSERVAZIONE
    $modalita;
    $temperatura;

    // PITTOGRAMMI
    $pittogrammiFrase;
    /* $pittogrammiFrase[$i]['linkSimbolo']
       $pittogrammiFrase[$i]['fraseRischio'] */

    // SCHEDA DI SICUREZZA - QUANTITA - COLLOCAZIONE
    $idScheda;
    $nomeScheda;
    $dataRilascio;
    $linkScheda;
    $scheda_C_Q; // MATRICE
    /* $scheda_C_Q[$i]['quantita']
       $scheda_C_Q[$i]['siglaRipiano']
       $scheda_C_Q[$i]['siglaPunto']
       $scheda_C_Q[$i]['siglaStanza'] */

    // REAGENTE - QUANTITA e DATE - COLLOCAZIONE
    // se esistono
    $reagente_C_Q; // MATRICE
    /* $reagente_C_Q[$i]['dataVerifica']
       $reagente_C_Q[$i]['dataScadenza']
       $reagente_C_Q[$i]['quantita']

       $reagente_C_Q[$i]['siglaRipiano']
       $reagente_C_Q[$i]['siglaPunto']
       $reagente_C_Q[$i]['siglaStanza'] */

    // ESPERIENZE DIDATTICHE
    $esperienze; // MATRICE
    /* $ret[$i]['linkEsperienza']
       $ret[$i]['nomeEsperienza'] */


// STAMPA
function stampaDatiGeneraliReagente()
{
    global $nomeReagente, $formulaChimica, $statoMateria,$nomeDitta, $indirizzo, $telefono, $email, $modalita, $temperatura;

    // DATI GENERALI
    echo $nomeReagente . "<br>";
    echo $formulaChimica . "<br>";
    echo $statoMateria . "<br>";

    // DITTA PRODUTTRICE
    echo $nomeDitta . "<br>";
    echo $indirizzo . "<br>";
    echo $telefono . "<br>";
    echo $email . "<br>";

    // MODALITA DI CONSERVAZIONE
    echo $modalita . "<br>";
    echo $temperatura . "<br>";
}

function stampaPittogrammi()
{
    global $pittogrammiFrase;

    for($i = 0; $i < count($pittogrammiFrase); $i++)
    {
        echo "<img title=\"".$pittogrammiFrase[$i]['fraseRischio']."\" alt=\"".$pittogrammiFrase[$i]['fraseRischio']."\" src=\"".$pittogrammiFrase[$i]['linkSimbolo']."\" width=\"50\" height=\"50\"/>";
    }
}

function stampaFrasi()
{
    global $pittogrammiFrase;

    for($i = 0; $i < count($pittogrammiFrase); $i++)
    {
        echo "<li>".$pittogrammiFrase[$i]['fraseRischio']."</li>";
    }
}

// AGGIUNGERE COLONNA QUANTITA
function stampaSchedaSicurezza()
{
    global $nomeScheda, $dataRilascio, $linkScheda, $scheda_C_Q;

    for($i = 0; $i < count($scheda_C_Q); $i++)
    {
        echo "<tr>";
            echo "<td>".$nomeScheda."</td>";
            echo "<td>".$dataRilascio."</td>";
            if($linkScheda != "NULL") {
                echo "<td><a href=\"".$linkScheda."\">Link</a></td>";
            }
            else {
                echo "<td>Non presente</td>";
            }
            echo "<td>".$scheda_C_Q[$i]['siglaStanza']."</td>";
            echo "<td>".$scheda_C_Q[$i]['siglaPunto']."</td>";
            echo "<td>".$scheda_C_Q[$i]['siglaRipiano']."</td>";
            echo "<td>".$scheda_C_Q[$i]['quantita']."</td>";

            echo "<td>";
                if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) {
                    // Modifica
                        echo "<a href=\"modifica_quantitascheda.php?idReagente=".$scheda_C_Q[$i]['idReagente']."&idRipiano=".$scheda_C_Q[$i]['idRipiano']."&idScheda=".$scheda_C_Q[$i]['idScheda']."\"><button type=\"submit\" class=\"btnAzioni btnModifica\"><img title=\"Modifica\" alt=\"Modifica\" src=\"media/bottoni/draw.svg\"/></button></a>";
                        //echo "<a href=\"modifica_quantitascheda.php?idReagente=".$scheda_C_Q[$i]['idReagente']."&idRipiano=".$scheda_C_Q[$i]['idRipiano']."&idScheda=".$scheda_C_Q[$i]['idScheda']."\"><input type=\"submit\" class=\"btn btn-warning\" value=\"Modifica\" name=\"btnAggiornaQuantita\"></a>";
                    // Eliminazione
                        echo "<form method=\"POST\" action=\"api/eliminacollocazioneschedareagente.php\">";
                            echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$scheda_C_Q[$i]['idReagente']."\">";
                            echo "<input type=\"hidden\" name=\"idRipiano\" value=\"".$scheda_C_Q[$i]['idRipiano']."\">";
                            echo "<input type=\"hidden\" name=\"idScheda\" value=\"".$scheda_C_Q[$i]['idScheda']."\">";
                            echo "<button type=\"submit\" class=\"btnAzioni btnElimina\"><img title=\"Elimina\" alt=\"Elimina\" src=\"media/bottoni/can.svg\"/></button>";
                            //echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Elimina\">";
                        echo "</form>";
                }
            echo "</td>";

        echo "</tr>";
    }
}

function stampaCollocazioneQuantitaReagente()
{
    global $reagente_C_Q;

    for($i = 0; $i < count($reagente_C_Q); $i++)
    {
        echo "<tr>";
            echo "<td>".$reagente_C_Q[$i]['siglaStanza']."</td>";
            echo "<td>".$reagente_C_Q[$i]['siglaPunto']."</td>";
            echo "<td>".$reagente_C_Q[$i]['siglaRipiano']."</td>";
            echo "<td>".$reagente_C_Q[$i]['quantita']."</td>";
            echo "<td>".$reagente_C_Q[$i]['dataVerifica']."</td>";
            echo "<td>".$reagente_C_Q[$i]['dataScadenza']."</td>";

            echo "<td>";
                if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) {
                    // Modifica
                        echo "<a href=\"modifica_quantitareagente.php?idReagente=".$reagente_C_Q[$i]['idReagente']."&idRipiano=".$reagente_C_Q[$i]['idRipiano']."\"><button type=\"submit\" class=\"btnAzioni btnModifica\"><img title=\"Modifica\" alt=\"Modifica\" src=\"media/bottoni/draw.svg\"/></button></a>";
                        //echo "<a href=\"modifica_quantitareagente.php?idReagente=".$reagente_C_Q[$i]['idReagente']."&idRipiano=".$reagente_C_Q[$i]['idRipiano']."\"><input type=\"submit\" class=\"btn btn-warning\" value=\"Modifica\" name=\"btnAggiornaQuantita\"></a>"; // fare if per redirect
                    // Eliminazione
                        echo "<form method=\"POST\" action=\"api/eliminacollocazionereagente.php\">";
                            echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$reagente_C_Q[$i]['idReagente']."\">";
                            echo "<input type=\"hidden\" name=\"idRipiano\" value=\"".$reagente_C_Q[$i]['idRipiano']."\">";
                            echo "<button type=\"submit\" class=\"btnAzioni btnElimina\"><img title=\"Elimina\" alt=\"Elimina\" src=\"media/bottoni/can.svg\"/></button>";
                            //echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Elimina\">";
                        echo "</form>";
                }
            echo "</td>";

        echo "</tr>";
    }
}

// SU HTML CAMBIARE ID CON LINK E INVERTIRE ORDINE CAMPI
function stampaEsperienzeDidattiche()
{
    global $esperienze;

    for($i = 0; $i < count($esperienze); $i++)
    {
        echo "<tr>";
            echo "<td>".$esperienze[$i]['nomeEsperienza']."</td>";
            echo "<td><a href=\"".$esperienze[$i]['linkEsperienza']."\">Link</a></td>";
            echo "<td>";
                if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) {
                    // Eliminazione
                        echo "<form method=\"POST\" action=\"api/eliminaesperienzareagente.php\">";
                            echo "<input type=\"hidden\" name=\"idReagente\" value=\"".$esperienze[$i]['idReagente']."\">";
                            echo "<input type=\"hidden\" name=\"idEsperienza\" value=\"".$esperienze[$i]['idEsperienza']."\">";
                            echo "<button type=\"submit\" class=\"btnAzioni btnElimina\"><img title=\"Elimina\" alt=\"Elimina\" src=\"media/bottoni/can.svg\"/></button>";
                            //echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Elimina\">";
                        echo "</form>";
                }
            echo "</td>";
        echo "</tr>";
    }
}


// ESTRAZIONE
function getCollocazioneQuantitaScheda($idScheda, $idReagente) 
{
    global $connection;
    $query = "SELECT * FROM situato_s_r
                INNER JOIN ripiano
                    ON ripiano.idRipiano = situato_s_r.idRipiano
                INNER JOIN punto
                    ON punto.idPunto = ripiano.idPunto
                INNER JOIN collocazionefisica
                    ON collocazionefisica.idCollocazione = punto.idCollocazione
                WHERE situato_s_r.idScheda = '$idScheda';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $ret = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ret[$i]['quantita']     = $row['quantita'];

        $ret[$i]['siglaRipiano'] = $row['siglaRipiano'];
        $ret[$i]['siglaPunto']   = $row['siglaPunto'];
        $ret[$i]['siglaStanza']  = $row['siglaStanza'];

        $ret[$i]['idScheda']     = $row['idScheda'];
        $ret[$i]['idRipiano']    = $row['idRipiano'];
        $ret[$i]['idReagente']   = $idReagente;

        $i++;

        // plus: $ret[$i]['codiceQr'] = row['codiceQr'];
        // plus: $ret['descrizione'] = row['descrizione']; // stanza
    }

    return $ret;
}

function getCollocazioneQuantitaReagente($idReagente)
{
    global $connection;
    $query = "SELECT * FROM quantitar
                INNER JOIN ripiano
                    ON ripiano.idRipiano = quantitar.idRipiano
                INNER JOIN punto
                    ON punto.idPunto = ripiano.idPunto
                INNER JOIN collocazionefisica
                    ON collocazionefisica.idCollocazione = punto.idCollocazione
                WHERE quantitar.idReagente = '$idReagente';";

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

        // new
        $ret[$i]['idRipiano']   = $row['idRipiano'];
        $ret[$i]['idReagente']  = $idReagente;

        $i++;
    }

    return $ret;
}
    
function getLinkFrasePittogramma($idReagente)
{
    global $connection;
    $query = "SELECT * FROM possiede_r_p
                INNER JOIN pittogrammasicurezza
                    ON pittogrammasicurezza.idPittogramma = possiede_r_p.idPittogramma
                WHERE possiede_r_p.idReagente = '$idReagente';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $ret = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ret[$i]['linkSimbolo']  = $row['linkSimbolo'];
        $ret[$i]['fraseRischio'] = $row['fraseRischio'];
        $i++;
    }

    return $ret;
}

function getNomeLinkEsperienza($idReagente)
{
    global $connection;
    $query = "SELECT * FROM prevede_r_e
                INNER JOIN esperienzadidattica
                    ON esperienzadidattica.idEsperienza = prevede_r_e.idEsperienza
                WHERE prevede_r_e.idReagente = '$idReagente';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $ret = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ret[$i]['linkEsperienza'] = $row['linkEsperienza'];
        $ret[$i]['nomeEsperienza'] = $row['nomeEsperienza'];

        $ret[$i]['idEsperienza']   = $row['idEsperienza'];
        $ret[$i]['idReagente']     = $idReagente;
        $i++;
    }

    return $ret;
}

function getIdReagente()
{
    global $idReagente;
    
    return $idReagente;
}

function estraiSchedaReagente($idReagente)
{
    global $connection;
    
    // DATI SCHEDA REAGENTE
    global $nomeReagente, $formulaChimica, $statoMateria;
    global $nomeDitta, $indirizzo, $telefono, $email;
    global $modalita, $temperatura;
    global $pittogrammiFrase;
    global $nomeScheda, $dataRilascio, $linkScheda, $scheda_C_Q;
    global $reagente_C_Q;
    global $esperienze;
    global $idScheda;

    $query = "SELECT * FROM reagente
                INNER JOIN aspetto
                    ON reagente.idAspetto = aspetto.idAspetto
                INNER JOIN dittaproduttrice
                    ON reagente.idDitta = dittaproduttrice.idDitta
                INNER JOIN modalitaconservazione
                    ON reagente.idModalita = modalitaconservazione.idModalita
                INNER JOIN schedasicurezza
                    ON reagente.idScheda = schedasicurezza.idScheda
                WHERE reagente.idReagente = '$idReagente';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    $row = mysqli_fetch_array($result);

    // DATI REAGENTE
    $nomeReagente   = $row['nomeReagente'];
    $formulaChimica = $row['formulaChimica'];
    $statoMateria   = $row['statoMateria'];
    
    // DITTA PRODUTTRICE
    $nomeDitta = $row['nomeDitta'];
    $indirizzo = $row['indirizzo'];
    $telefono  = $row['telefono'];
    $email     = $row['email'];
    
    // MODALITA DI CONSERVAZIONE
    $modalita    = $row['modalita'];
    $temperatura = $row['temperatura'];

    // PITTOGRAMMI
    // se esistono
    $pittogrammiFrase = getLinkFrasePittogramma($idReagente);
        /* $pittogrammiFrase[$i]['linkSimbolo']
           $pittogrammiFrase[$i]['fraseRischio'] */

    // SCHEDA DI SICUREZZA - QUANTITA - COLLOCAZIONE
    $nomeScheda   = $row['nomeScheda'];
    $dataRilascio = $row['dataRilascio'];
    $linkScheda   = $row['linkScheda']; // se esiste (come rilevare il null del db?)
    $idScheda     = $row['idScheda'];
    $scheda_C_Q = getCollocazioneQuantitaScheda($row['idScheda'], $row['idReagente']); // MATRICE
        /* $scheda_C_Q[$i]['quantita']
           $scheda_C_Q[$i]['siglaRipiano']
           $scheda_C_Q[$i]['siglaPunto']
           $scheda_C_Q[$i]['siglaStanza'] */

    // REAGENTE - QUANTITA e DATE - COLLOCAZIONE
    // se esistono
    $reagente_C_Q = getCollocazioneQuantitaReagente($idReagente);
        /* $reagente_C_Q[$i]['dataVerifica']
           $reagente_C_Q[$i]['dataScadenza']
           $reagente_C_Q[$i]['quantita']

           $reagente_C_Q[$i]['siglaRipiano']
           $reagente_C_Q[$i]['siglaPunto']
           $reagente_C_Q[$i]['siglaStanza'] */

    // ESPERIENZE DIDATTICHE
    // se esistono
    $esperienze = getNomeLinkEsperienza($idReagente);
        /* $ret[$i]['linkEsperienza']
           $ret[$i]['nomeEsperienza'] */
}

/* Istruzioni principali */

/* Estrazione dati */
estraiSchedaReagente($idReagente);

/* Stampa dati */
/*stampaDatiGeneraliReagente();
stampaFrasi();
stampaPittogrammi();
stampaCollocazioneQuantitaReagente();
stampaSchedaSicurezza();
stampaEsperienzeDidattiche();*/

?>