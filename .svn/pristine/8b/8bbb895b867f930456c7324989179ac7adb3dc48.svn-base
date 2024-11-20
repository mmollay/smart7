<?php
/*
 * Testest die Zuweisung und Entnahme der Tags in der Followup-Sequenz
 */
require_once (__DIR__ . '/../mysql.inc');
include ('../functions.inc.php');

if (! $_SESSION['develop_mode'])
	return;

$GLOBALS['mysqli']->query ( "DELETE FROM $db_nl.session" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
$GLOBALS['mysqli']->query ( "DELETE FROM $db_nl.logfile" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );

echo "<a href='index.php'>Zur&uuml;ck</a><hr>";
echo "Alle Sessions gel&ouml;scht";