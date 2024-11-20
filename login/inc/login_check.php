<?php
session_start();

if ($_POST['modul']) {
    //setcookie("modul", $_POST['modul'], time() + 60 * 60 * 24 * 365, '/', $_SERVER['HTTP_HOST']);
}
// Prüft ob Session ID noch aktiv ist

// Ist User abegemeldet, loggt sich das system von selbst aus!
if (! $_SESSION['verify_key'] or ! $_SESSION['user_id']) {
    echo 'exit';
    exit();
} else {
    echo 'ok';
}