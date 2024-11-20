<?php
//Setzt für die Bearbeitung ein Cookie
session_start ();
$_SESSION["map_filter"]['set_admin'] = $_POST['set_admin_cookie'];
setcookie ( "set_admin", $_SESSION["map_filter"]['set_admin'], time () + 3600 );