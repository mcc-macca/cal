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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCkalnedar</title>
    <link rel="stylesheet" href="style.css">
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

            } else {
                ?>
                <table>
                    <tr>
                        <td rowspan="2" class="bordered">

                        </td>
                        <td class="bordered">

                        </td>
                    </tr>
                    <tr>
                        <td class="bordered">
                            
                        </td>
                    </tr>
                </table>
                <?php
            }
        ?>
    </div>
</body>

</html>