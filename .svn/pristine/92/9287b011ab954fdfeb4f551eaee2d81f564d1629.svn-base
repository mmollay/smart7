<?php
// Auslesen der Optionen aus der Datenbank
session_start ();

$session_id = $_POST['id'];

// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

// Error zuruecksetzen
if ($session_id) {
	$GLOBALS['mysqli']->query ( "UPDATE session SET status = 3, `release` = 1 WHERE session_id = '$session_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$GLOBALS['mysqli']->query ( "UPDATE logfile SET `error` = 0, error_counter = 0, sendet = 0 WHERE session_id = '$session_id' and `error`=1" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$GLOBALS['mysqli']->query ( "DELETE FROM session_logfile WHERE session_id = '$session_id' " );
	echo 'ok';
}

?>