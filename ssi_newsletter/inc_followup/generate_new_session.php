<?php

// Datenbankverbindung herstellen
require_once (__DIR__ . '/../mysql.inc');

$info_array = generate_new_session ( $contact_id, $cfg, true );

// Zum testen
if (is_array ( $info_array )) {
	foreach ( $info_array as $info ) {
		$test_output .= $info;
		$test_output .= "<br>";
	}
	echo $test_output;
}