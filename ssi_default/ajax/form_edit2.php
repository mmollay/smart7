<?php
include ('../config.inc.php');

// Zugangsdaten fuer die Datenbank
foreach ( $_POST as $key => $value ) {
	$GLOBALS [$key] = $GLOBALS ['mysqli']->real_escape_string ( $value );
}

switch ($_POST ['list_id']) {

	case 'client_list' :
		$GLOBALS ['mysqli']->query ( "REPLACE INTO ssi_company.test SET
		id = '$update_id',
		title = '$title',
		text = '$text'
		" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		echo "ok";
		break;
}
