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

$idStrumentazione = "";
// raccolta idStrumentazione
if(isset($_GET['idStrumentazione'])) {
    $idStrumentazione = $_GET['idStrumentazione'];
} else {
    echo "<b>Lo strumento non è stato selezionato correttamente</b>";
    exit();
}

$numeroInventario = "";
// raccolta numeroInventario
if(isset($_GET['numeroInventario'])) {
    $numeroInventario = $_GET['numeroInventario'];
} else {
    echo "<b>Lo strumento non è stato selezionato correttamente</b>";
    exit();
}

// VARIABILI GLOBALI
// DATI STRUMENTAZIONE
    $nomeSA;
    $caratteristicaTecnica;
    $numeroInventario;
    
    // MANUALE DELLE ISTRUZIONI - QUANTITA - COLLOCAZIONE
    $idManuale;
    $nomeManuale;
    $dataRilascio;
    $linkManuale;
    $manuale_C_Q;

    // REAGENTE - QUANTITA e DATE - COLLOCAZIONE
    // se esistono
    $strumento_C_Q_attuale;
    $strumento_C_Q;

    // STORICI E RIPARAZIONI
    $storicoManutenzioneOrdinaria;
    $storicoManutenzioneStraordinaria;
    $riparazioni;


// STAMPA
function stampaDatiGeneraliStrumento()
{
    global $nomeSA, $caratteristicaTecnica, $numeroInventario;

    // DATI GENERALI
    echo $nomeSA . "<br>";
    echo $caratteristicaTecnica . "<br>";
    echo $numeroInventario . "<br>";
}

function stampaManualeIstruzioni()
{
    global $nomeManuale, $dataRilascio, $linkManuale, $manuale_C_Q;

    for($i = 0; $i < count($manuale_C_Q); $i++)
    {
        echo "<tr>";
            echo "<td>".$nomeManuale."</td>";
            echo "<td>".$dataRilascio."</td>";
            if($linkManuale != "NULL") {
                echo "<td><a href=\"".$linkManuale."\">Link</a></td>";
            }
            else {
                echo "<td>Non presente</td>";
            }
            echo "<td>".$manuale_C_Q[$i]['siglaStanza']."</td>";
            echo "<td>".$manuale_C_Q[$i]['siglaPunto']."</td>";
            echo "<td>".$manuale_C_Q[$i]['siglaRipiano']."</td>";
            echo "<td>".$manuale_C_Q[$i]['quantita']."</td>";

            echo "<td>";
                if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) {
                    // Modifica
                        echo "<a href=\"modifica_quantitamanuale.php?idStrumentazione=".$manuale_C_Q[$i]['idStrumentazione']."&idRipiano=".$manuale_C_Q[$i]['idRipiano']."&idManuale=".$manuale_C_Q[$i]['idManuale']."&numeroInventario=".$manuale_C_Q[$i]['numeroInventario']."\"><button type=\"submit\" class=\"btnAzioni btnModifica\"><img title=\"Modifica\" alt=\"Modifica\" src=\"media/bottoni/draw.svg\"/></button></a>";
                        //echo "<a href=\"modifica_quantitamanuale.php?idStrumentazione=".$manuale_C_Q[$i]['idStrumentazione']."&idRipiano=".$manuale_C_Q[$i]['idRipiano']."&idManuale=".$manuale_C_Q[$i]['idManuale']."&numeroInventario=".$manuale_C_Q[$i]['numeroInventario']."\"><input type=\"submit\" class=\"btn btn-warning\" value=\"Modifica\" name=\"btnAggiornaQuantita\"></a>";
                    // Eliminazione
                        echo "<form method=\"POST\" action=\"api/eliminacollocazionemanualestrumento.php\">";
                            echo "<input type=\"hidden\" name=\"numeroInventario\" value=\"".$manuale_C_Q[$i]['numeroInventario']."\">";
                            echo "<input type=\"hidden\" name=\"idRipiano\" value=\"".$manuale_C_Q[$i]['idRipiano']."\">";
                            echo "<input type=\"hidden\" name=\"idManuale\" value=\"".$manuale_C_Q[$i]['idManuale']."\">";
                            echo "<button type=\"submit\" class=\"btnAzioni btnElimina\"><img title=\"Elimina\" alt=\"Elimina\" src=\"media/bottoni/can.svg\"/></button>";
                            //echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Elimina\">";
                        echo "</form>";
                }
            echo "</td>";

        echo "</tr>";
    }
}

function stampaCollocazioneAttuale()
{
    global $strumento_C_Q_attuale, $numeroInventario;

    echo "<tr>";
        echo "<td>".$strumento_C_Q_attuale['siglaStanza']."</td>";
        echo "<td>".$strumento_C_Q_attuale['siglaPunto']."</td>";
        echo "<td>".$strumento_C_Q_attuale['siglaRipiano']."</td>";
        echo "<td>".$strumento_C_Q_attuale['quantita']."</td>";

        echo "<td>";
            if ( in_array($_SESSION['nomeCategoria'], array('Amministratore', 'Docente', 'ITP')) ) {
                // Modifica
                    echo "<a href=\"modifica_collocazionestrumento.php?idStrumentazione=".$strumento_C_Q_attuale['idStrumentazione']."&numeroInventario=".$numeroInventario."\"><button type=\"submit\" class=\"btnAzioni btnModifica\"><img title=\"Modifica\" alt=\"Modifica\" src=\"media/bottoni/draw.svg\"/></button></a>";
                    //echo "<a href=\"modifica_collocazionestrumento.php?idStrumentazione=".$strumento_C_Q_attuale['idStrumentazione']."&numeroInventario=".$numeroInventario."\"><input type=\"submit\" class=\"btn btn-warning\" value=\"Modifica\" name=\"btnAggiornaQuantita\"></a>";
            }
        echo "</td>";

    echo "</tr>";
}

function stampaCollocazioneQuantitaStrumentazione()
{
    global $strumento_C_Q;

    for($i = 0; $i < count($strumento_C_Q); $i++)
    {
        echo "<tr>";
            echo "<td>".$strumento_C_Q[$i]['siglaStanza']."</td>";
            echo "<td>".$strumento_C_Q[$i]['siglaPunto']."</td>";
            echo "<td>".$strumento_C_Q[$i]['siglaRipiano']."</td>";
            echo "<td>".$strumento_C_Q[$i]['quantita']."</td>";
            echo "<td>".$strumento_C_Q[$i]['dataVerifica']."</td>";
            echo "<td>".$strumento_C_Q[$i]['dataScadenza']."</td>";
        echo "</tr>";
    }
}

function stampaStoricoManutenzioneOrdinaria()
{
    global $storicoManutenzioneOrdinaria;

    for($i = 0; $i < count($storicoManutenzioneOrdinaria); $i++)
    {
        echo "<tr>";
            echo "<td><b>".$storicoManutenzioneOrdinaria[$i]['dataManutenzione']."</b></td>";
            echo "<td>".$storicoManutenzioneOrdinaria[$i]['azione']."</td>";
        echo "</tr>";
    }
}

function stampaStoricoManutenzioneStraordinaria()
{
    global $storicoManutenzioneStraordinaria;

    for($i = 0; $i < count($storicoManutenzioneStraordinaria); $i++)
    {
        echo "<tr>";
            echo "<td><b>".$storicoManutenzioneStraordinaria[$i]['dataManutenzione']."</b></td>";
            echo "<td>".$storicoManutenzioneStraordinaria[$i]['azione']."</td>";
        echo "</tr>";
    }
}

function stampaRiparazioni()
{
    global $riparazioni;

    for($i = 0; $i < count($riparazioni); $i++)
    {
        echo "<tr>";
            echo "<td><b>".$riparazioni[$i]['dataRiparazione']."</b></td>";
            echo "<td>".$riparazioni[$i]['motivazione']."</td>";
        echo "</tr>";
    }
}


// ESTRAZIONE
function getCollocazioneQuantitaManuale($idManuale, $idStrumentazione) 
{
    global $connection;
    global $numeroInventario;

    $query = "SELECT * FROM situato_m_r
                INNER JOIN ripiano
                    ON ripiano.idRipiano = situato_m_r.idRipiano
                INNER JOIN punto
                    ON punto.idPunto = ripiano.idPunto
                INNER JOIN collocazionefisica
                    ON collocazionefisica.idCollocazione = punto.idCollocazione
                WHERE situato_m_r.idManuale = '$idManuale';";

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

        $ret[$i]['idRipiano']    = $row['idRipiano'];
        $ret[$i]['idManuale']    = $idManuale;
        $ret[$i]['numeroInventario'] = $numeroInventario;
        $ret[$i]['idStrumentazione'] = $idStrumentazione;        

        $i++;
    }
    
    return $ret;
}

function getCollocazioneQuantitaStrumento($idStrumentazione)
{
    global $connection;
    $query = "SELECT * FROM quantitasa
                INNER JOIN ripiano
                    ON ripiano.idRipiano = quantitasa.idRipiano
                INNER JOIN punto
                    ON punto.idPunto = ripiano.idPunto
                INNER JOIN collocazionefisica
                    ON collocazionefisica.idCollocazione = punto.idCollocazione
                WHERE quantitasa.idSA = '$idStrumentazione';";

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
        $i++;
    }

    return $ret;
}

function getCollocazioneAttuale($idInventario)
{
    global $connection;

    $query = "SELECT * FROM inventario
                INNER JOIN ripiano
                    ON ripiano.idRipiano = inventario.idRipiano
                INNER JOIN punto
                    ON punto.idPunto = ripiano.idPunto
                INNER JOIN collocazionefisica
                    ON collocazionefisica.idCollocazione = punto.idCollocazione
                WHERE inventario.idInventario = '$idInventario';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    // estrapolazione dati
    $row = mysqli_fetch_array($result);
    $ret['quantita']     = "1"; // $row['quantita'];

    $ret['siglaRipiano'] = $row['siglaRipiano'];
    $ret['siglaPunto']   = $row['siglaPunto'];
    $ret['siglaStanza']  = $row['siglaStanza'];

    $ret['idStrumentazione']  = $row['idSA'];    

    return $ret;
}

function getStoricoManutenzioneOrdinaria($idInventario)
{
    global $connection;
    $query = "SELECT * FROM storicomanutenzione_ordinaria
                INNER JOIN inventario
                    ON inventario.idInventario = storicomanutenzione_ordinaria.idInventario
                WHERE inventario.idInventario = '$idInventario';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $ret = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ret[$i]['azione'] = $row['azione'];
        $ret[$i]['dataManutenzione'] = $row['dataManutenzione'];
        $i++;
    }

    return $ret;
}

function getStoricoManutenzioneStraordinaria($idInventario)
{
    global $connection;
    $query = "SELECT * FROM storicomanutenzione_straordinaria
            INNER JOIN inventario
                ON inventario.idInventario = storicomanutenzione_straordinaria.idInventario
            WHERE inventario.idInventario = '$idInventario';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $ret = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ret[$i]['azione'] = $row['azione'];
        $ret[$i]['dataManutenzione'] = $row['dataManutenzione'];
        $i++;
    }

    return $ret;
}

function getRiparazioni($idInventario)
{
    global $connection;
    $query = "SELECT * FROM riparazione
                INNER JOIN inventario
                    ON inventario.idInventario = riparazione.idInventario
                WHERE inventario.idInventario = '$idInventario';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $ret = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ret[$i]['motivazione'] = $row['motivazione'];
        $ret[$i]['dataRiparazione'] = $row['dataRiparazione'];
        $i++;
    }

    return $ret;
}

function getIdInventario($numeroInventario)
{
    global $connection;
    $query = "SELECT * FROM inventario
                WHERE inventario.numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");
    
    // estrapolazione dati
    $row = mysqli_fetch_array($result);

    return $row['idInventario'];
}

function estraiSchedaStrumento($idStrumentazione, $numeroInventario)
{
    global $connection;
    
    // DATI SCHEDA REAGENTE
    global $nomeSA, $caratteristicaTecnica, $numeroInventario;
    global $nomeManuale, $dataRilascio, $linkManuale, $manuale_C_Q;
    global $strumento_C_Q_attuale, $strumento_C_Q;
    global $storicoManutenzioneOrdinaria, $storicoManutenzioneStraordinaria, $riparazioni;
    global $idManuale;

    $query = "SELECT * FROM strumentazione_apparecchiatura
                INNER JOIN manualeistruzioni
                    ON strumentazione_apparecchiatura.idManuale = manualeistruzioni.idManuale
                INNER JOIN inventario
                    ON strumentazione_apparecchiatura.idSA = inventario.idSA
                WHERE strumentazione_apparecchiatura.idSA = '$idStrumentazione'
                    AND inventario.numeroInventario = '$numeroInventario';";

    $result = mysqli_query($connection, $query)
        or die ("Errore nella query " . mysqli_error($connection) . "<br>");

    $row = mysqli_fetch_array($result);

    if(mysqli_affected_rows($connection) == 0)
    {
        echo "<b>Lo strumento non è stato selezionato correttamente</b>";
        exit();
    }

    // DATI REAGENTE
    $nomeSA = $row['nomeSA'];
    $caratteristicaTecnica = $row['caratteristicaTecnica'];
    
    // MANUALE DELLE ISTRUZIONI - QUANTITA - COLLOCAZIONE
    $idManuale    = $row['idManuale'];
    $nomeManuale  = $row['nomeManuale'];
    $dataRilascio = $row['dataRilascio'];
    $linkManuale  = $row['linkManuale']; // se esiste (come rilevare il null del db?)
    $manuale_C_Q = getCollocazioneQuantitaManuale($row['idManuale'], $row['idSA']); // MATRICE
        /* $manuale_C_Q[$i]['quantita']
           $manuale_C_Q[$i]['siglaRipiano']
           $manuale_C_Q[$i]['siglaPunto']
           $manuale_C_Q[$i]['siglaStanza'] */

    $idInventario = getIdInventario($numeroInventario);

    // STRUMENTO - QUANTITA e DATE - COLLOCAZIONE
    // se esistono
    $strumento_C_Q_attuale = getCollocazioneAttuale($idInventario);
    $strumento_C_Q = getCollocazioneQuantitaStrumento($idStrumentazione);
        /* $strumento_C_Q[$i]['dataVerifica']
           $strumento_C_Q[$i]['dataScadenza']
           $strumento_C_Q[$i]['quantita']

           $strumento_C_Q[$i]['siglaRipiano']
           $strumento_C_Q[$i]['siglaPunto']
           $strumento_C_Q[$i]['siglaStanza'] */

    $storicoManutenzioneOrdinaria = getStoricoManutenzioneOrdinaria($idInventario);
    $storicoManutenzioneStraordinaria = getStoricoManutenzioneStraordinaria($idInventario);
    $riparazioni = getRiparazioni($idInventario);
}

/* Istruzioni principali */

/* Estrazione dati */
estraiSchedaStrumento($idStrumentazione, $numeroInventario);

/* Stampa dati */
/*stampaDatiGeneraliStrumento();
stampaManualeIstruzioni();
stampaCollocazioneAttuale();
stampaCollocazioneQuantitaStrumentazione();
stampaStoricoManutenzioneOrdinaria();
stampaStoricoManutenzioneStraordinaria();
stampaRiparazioni();*/

?>