<?php
// Diese Seite trägt den Klick in die Datenbank ein und leitet direkt an die eingetragene Seite weiter
$key = $_GET['key'];
$c = $_GET['c'];
// connect to mysql
include ('../ssi_newsletter/mysql.inc');

if (! $key) {
	echo "kein Schlüssel definiert";
} else {
	// call data from mysql
	$query = $GLOBALS['mysqli']->query ( "SELECT link,landingpage_id FROM landingpage WHERE `key`= '$key' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$array = mysqli_fetch_array ( $query );
	$link = $array['link'];
	$landingpage_id = $array['landingpage_id'];
	
	// call data from mysql
	$query = $GLOBALS['mysqli']->query ( "SELECT id FROM contact WHERE `verify_key`= '$c' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$array = mysqli_fetch_array ( $query );
	$contact_id = $array['id'];
	
	// Save inner DB
	if ($landingpage_id and $contact_id)
		$query = $GLOBALS['mysqli']->query ( "INSERT INTO contact_id2landingpage_id SET landingpage_id = '$landingpage_id', contact_id = '$contact_id' " );
}

if ($link)
	header ( "Location: $link" );
exit ();