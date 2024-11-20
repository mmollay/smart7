<?php
/*
 * Testest die Zuweisung und Entnahme der Tags in der Followup-Sequenz
 */
require_once (__DIR__ . '/../mysql.inc');

if (! $_SESSION ['develop_mode'])
	return;

$contact_id = '98';
$followup_id = '1';

echo "Contact_ID: $contact_id";
echo "<hr>";

call_tag_from_client ( $contact_id, $cfg );
echo "<hr>";
echo "Neue Tags ueber Followup_ID gesetzt.<br>Status:" . action_after_send ( $contact_id, $followup_id, $cfg );
echo "<hr>";
call_tag_from_client ( $contact_id, $cfg );

// Ruft aktuelle Tags auf
function call_tag_from_client($contact_id, $cfg) {
	echo "Tags von Client auslesen:<br>";
	$query = mysqli_query ($cfg, "SELECT * FROM tag a LEFT JOIN contact2tag b ON a.tag_id = b.tag_id WHERE b.contact_id = '$contact_id' ORDER by title " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$tag_id = $array ['tag_id'];
		$tag_name = $array ['title'];
		$tag_activate = $array ['activate'];
		echo $tag_name . "($tag_id)<br>";
	}
}