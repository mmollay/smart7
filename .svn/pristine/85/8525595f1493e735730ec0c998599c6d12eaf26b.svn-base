<?php
/* 
 * Testest die Zuweisung und Entnahme der Tags in der Followup-Sequenz
 */

require_once (__DIR__ . '/../mysql.inc');
include ('../functions.inc.php');

if (! $_SESSION['develop_mode'])
	return;

$followup_id = '1';
$contact_id = '98';

// An welche Kontakte gesendet werden sollen
$array_contact_id[] = $contact_id;

echo "Erzeugen einer Mail mit followup_id<br>";

echo generate_followup_mail($followup_id,$array_contact_id, $cfg);
