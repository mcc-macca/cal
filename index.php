<?php

/**
 * LETTERE VISUALIZZAZIONE
 * ?view=XX
 * S - Settimanale
 * M - Mensile
 * G - Giornaliero
 * -----------------------
 * 
 */
session_start();
require("db.php");
require "fun.php";

$session_token = "OdnudFIn4iofwni4int4Vndi.Sovj9ej03irndlq";

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("location: login.php");
    die;
}

if (isset($_POST['submit_giorno_top'])) {
    $giorno = $_POST['day'];
    $mese = $_POST['month'];
    $year = $_POST['year'];
    $link = "index.php?view=k";
}

if (isset($_POST['addeventsubmit'])) {

    $titoloevento = html_string($_POST['titoloevento']);
    $luogoevento = html_string($_POST['luogoevento']);
    $datainizio = html_string($_POST['datainizio']);
    $orainizio = isset($_POST['orainizio']) ? html_string($_POST['orainizio']) : '';
    $datafine = isset($_POST['datafine']) ? html_string($_POST['datafine']) : '';
    $orafine = isset($_POST['orafine']) ? html_string($_POST['orafine']) : '';
    $descrizioneEvento = html_string($_POST['descrizioneEvento']);
    $caricatoda = $_SESSION['uid'];

    $tuttoilgiorno = isset($_POST["tuttoilgiorno"]) && $_POST["tuttoilgiorno"] === "1" ? 1 : 0;


    $addeventquery = $conn->query("INSERT INTO `kal_eventi`(`datainizio`, `datafine`, `titolo`, `descrizione`, `caricatoda`, `orainizio`, `orafine`, `tuttoilgiorno`, `luogo`) VALUES 
    ('$datainizio','$datafine','$titoloevento','$descrizioneEvento','$caricatoda','$orainizio','$orafine','$tuttoilgiorno','$luogoevento')");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MCkalnedar</title>
    <link rel="stylesheet" href="style.css">
    <script src="jquery.js"></script>
</head>

<body>
    <div class="header">
        <a href="index.php">
            <h1 style="color: #ffffff">MCkalendar</h1>
        </a>
        <div class="selector">
            <form action="index.php" method="post">
                <p>
                    <select name="day">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            $optionday = $i == date("d") ? 'selected' : '';
                            echo "<option value='$i' $optionday>$i</option>";
                        }
                        ?>
                    </select>
                    /
                    <select name="month">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            $optionmonth = $i == date("m") ? 'selected' : '';
                            echo "<option value='$i' $optionmonth>$i</option>";
                        }
                        ?>
                    </select>
                    /
                    <select name="year">
                        <?php
                        for ($i = 1900; $i <= 3000; $i++) {
                            $optionyear = $i == date("Y") ? 'selected' : '';
                            echo "<option value='$i' $optionyear>$i</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="VAI AL GIORNO" name="submit_giorno_top">
                </p>
            </form>
        </div>
        <h1>Ciao <?= $_SESSION['uid'] ?> - <?= date("d/m/Y") ?> <a href='logout.php'><button>ESCI</button></a></h1>
    </div>
    <div class="header">
        <?php
        $viewmode = isset($_GET['viewmode']) ? $_GET['viewmode'] : ''; // Controlla la modalità corrente
        ?>
        <p>
            <a href="index.php?viewmode=day"><button <?= $viewmode === 'day' ? 'class="bold"' : '' ?>>VISUALIZZA GIORNO</button></a>
            <a href="index.php?viewmode=week"><button <?= $viewmode === 'week' ? 'class="bold"' : '' ?>>VISUALIZZA SETTIMANA</button></a>
            <a href="index.php?viewmode=month"><button <?= $viewmode === 'month' ? 'class="bold"' : '' ?>>VISUALIZZA MESE</button></a>
            <a href="index.php?viewmode=list"><button <?= $viewmode === 'list' ? 'class="bold"' : '' ?>>VISUALIZZA LISTA</button></a>
        </p>
    </div>
    <div class="content">
        <?php
        if (isset($_GET['viewmode'])) {
            // SOMETHING!
        } elseif (isset($_GET['action'])) {
            $getaction = $_GET['action'];
            if ($getaction == 'addevent') {
        ?>
                <h1>AGGIUNGI EVENTO AL DATABASE</h1>
                <form action="index.php" method="post">
                    <table class="modaltable">
                        <tr>
                            <td>Titolo:</td>
                            <td colspan="2"><input type="text" name="titoloevento" placeholder="Nuovo Evento"></td>
                        </tr>
                        <tr>
                            <td>Luogo:</td>
                            <td colspan="2"><input type="text" name="luogoevento"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><input type="checkbox" name="alldayevento" id="alldayevento" value="1"> Evento di tutto il giorno</td>
                        </tr>
                        <tr>
                            <td>Inizio:</td>
                            <td><input type="date" name="datainizio" id="datainizio"></td>
                            <td><input type="time" name="orainizio" id="orainizio"></td>
                        </tr>
                        <tr>
                            <td>Fine:</td>
                            <td><input type="date" name="datafine" id="datafine"></td>
                            <td><input type="time" name="orafine" id="orafine"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">Descrizione:</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <textarea name="descrizioneEvento" id="descrizioneEvento" cols="30" rows="5"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <center>
                                    <a href="index.php"><button>&times; CANCELLA</button></a>
                                    <input type="submit" value="&plus; AGGIUNGI" name="addeventsubmit">
                                </center>
                            </td>
                        </tr>
                    </table>
                </form>
            <?php
            }
        } else {
            ?>
            <table class="default">
                <tr>
                    <td rowspan="2" class="bordered">
                        <h1>Prossimi eventi in calendario <a href="index.php?action=addevent"><button>+ AGGIUNGI EVENTO</button></a></h1>
                        <?php
                        $dataOggi = date("Y-m-d");
                        $utenteAttuale = $_SESSION['uid'];
                        $prossimieventiq = $conn->query("SELECT * FROM kal_eventi WHERE caricatoda = '$utenteAttuale';");

                        if ($prossimieventiq->num_rows > 0) {
                            print "<table class='bordered inbordered'>
                            <tr>
                                <th>DATA</th>
                                <th>TITOLO</th>
                                <th>LUOGO</th>
                                <th></th>
                            </tr>";
                            while ($pedt = $prossimieventiq->fetch_assoc()) {
                                print "<tr>
                    <td>" . $pedt['datainizio'] . "</td>
                    <td>" . $pedt['titolo'] . "</td>
                    <td>" . $pedt['luogo'] . "</td>
                    <td><a href='index.php?visualizza=dettagli&id=" . $pedt['id'] . "'><button>DETTAGLI</button></a></td>
               </tr>
        ";
                            }
                            print "</table>";
                        } else {
                            print "<h2 style='color: #ff0000'>NO EVENTS PRESENT IN THE DATABASE!!</h2>";
                        }
                        ?>

                    </td>
                    <td class="bordered">
                        <h1>Questa settimana</h1>
                        <?php
                        // Ottenere la data corrente
                        $oggi = time();

                        $monndayy = date("D") === "Mon" ? "monday" : "last monday";

                        // Calcolare la data del lunedì della settimana corrente
                        $lunedi_settimana_corrente = strtotime($monndayy, $oggi);

                        // Generare la tabella
                        echo '<table border="1">
        <tr>
            <th>GIORNO</th>
            <th>EVENTI</th>
        </tr>';

                        // Ciclo per i giorni della settimana
                        for ($i = 0; $i < 7; $i++) {
                            // Calcolare la data del giorno corrente
                            $giorno_corrente = strtotime("+$i days", $lunedi_settimana_corrente);

                            // Formattare la data nel formato desiderato (es. "D d/m")
                            $data_formattata = date("D d/m", $giorno_corrente);

                            // Contenuto di esempio per gli eventi
                            $evento = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima accusamus iste laudantium impedit culpa laborum harum ex! Unde animi aliquam laborum rerum, perferendis sapiente quo iure ipsa aspernatur pariatur reprehenderit!";

                            // Stampa delle righe della tabella con giorno ed evento
                            echo "<tr>
            <td>$data_formattata</td>
            <td>$evento</td>
        </tr>";
                        }

                        echo '</table>';
                        ?>

                    </td>
                </tr>
                <tr>
                    <td class="bordered">
                        <h1>Ultimi aggiornamenti</h1>
                    </td>
                </tr>
            </table>
        <?php
        }
        ?>
    </div>
    <script>
        $(document).ready(function() {
            $("#alldayevento").click(function() {
                // Controlla se il checkbox è selezionato o deselezionato
                if ($(this).prop("checked")) {
                    // Se è selezionato, disabilita gli input di ora
                    $("#orainizio").prop("disabled", true);
                    $("#orafine").prop("disabled", true);
                    $("#datafine").prop("disabled", true)
                } else {
                    // Se è deselezionato, abilita gli input di ora
                    $("#orainizio").prop("disabled", false);
                    $("#orafine").prop("disabled", false);
                    $("#datafine").prop("disabled", false)
                }
            });
        });
    </script>
</body>

</html>