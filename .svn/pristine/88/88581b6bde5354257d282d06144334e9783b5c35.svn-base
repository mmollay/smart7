<?php
/*
 * Automatische Zuweisung der AMS.AT Kunden von JAW-KÄRTEN
 */

session_start ();
include_once ('../config_newsletter.php');
/* Einstellungen */
$sql_host = $cfg_mysql ['host_nl'];
$sql_user = $cfg_mysql ['user_nl'];
$sql_pass = $cfg_mysql ['password_nl'];
$sql_db = $cfg_mysql ['db_nl'];

$cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
mysqli_select_db ( $cfg, $sql_db ) or die ( 'Could not select database ' . $gaSql ['db'] );

$GLOBALS ['mysqli'] = new mysqli ( $sql_host, $sql_user, $sql_pass, $sql_db ) or die ( "Could not open connection to server {$cfg_mysql['server']}" );

include ('../functions.inc.php');

$contact_old_tag_id = "517";
$contact_new_tag_id = "653";
$search_user_id = '81';

$sql = "SELECT * FROM `contact` LEFT JOIN contact2tag 
	ON contact.contact_id = contact2tag.contact_id
		WHERE `email` LIKE '%ams.at' AND user_id = '$search_user_id' AND tag_id = '$contact_old_tag_id' ";

$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

while ( $array = mysqli_fetch_array ( $query ) ) {
	$email = $array ['email'];
	$contact_id = $array ['contact_id'];

	//remove existing contact2tag inserts
	$GLOBALS ['mysqli']->query ( "DELETE FROM contact2tag WHERE tag_id = '$contact_new_tag_id' AND contact_id = '$contact_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

	$sql_new_tag = "UPDATE contact2tag 
		SET 
			tag_id = '$contact_new_tag_id'
 				WHERE tag_id = '$contact_old_tag_id' 
				AND contact_id = '$contact_id'
		";

	$GLOBALS ['mysqli']->query ( $sql_new_tag ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

	echo ++ $i . ": Verschieben ->  ($contact_id) $email <br>";
}

if (! $i) {
	echo "Keine Verschiebungen vorhanden";
} else {
	echo "$i Verschiebungen durchgeführt";
}
