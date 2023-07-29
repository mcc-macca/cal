<?php 
session_start();
require "db.php";
require "fun.php";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header("location: index.php");
    die;
}

if (isset($_POST['submit'])) {
    $uid = html_string($_POST['uid']);
    $checkuser = $conn->query("SELECT * FROM kal_utenti WHERE uid='$uid'");
    if ($checkuser->num_rows > 0) {
        $data = $checkuser->fetch_assoc();
        $psw = html_string($_POST['psw']);
        if (password_verify($psw, $data['psw'])) {
            $_SESSION['uid'] = $data['uid'];
            $_SESSION['logged_in'] = true;
            header("location: index.php");
        } else {
            $message = "PASSWORD ERROR!!";
        }
    } else {
        $message = "USER NOT FOUND!!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <h1>Accesso a MCkalendar</h1>
        <br><br>
        <h2>Prego, inserire credenziali</h2>
        <?php 
        if (isset($message)) {
            echo "<h2 class='error'>" . $message . "</h2>";
        }
        ?>
        <form action="login.php" method="post">
            <input type="text" name="uid" placeholder="UTENTE">
            <input type="password" name="psw" placeholder="PASSWORD">
            <input type="submit" value="ACCESSO" name="submit">
        </form>
    </center>
</body>
</html>