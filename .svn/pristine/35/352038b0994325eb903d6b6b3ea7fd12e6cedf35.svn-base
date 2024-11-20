<?php
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

// Überprueft einzelne Emails des Profiles
if ($_POST ['ID']) {
	$_POST ['ID'] = $GLOBALS['mysqli']->real_escape_string ( $_POST ['ID'] );
	$query = $GLOBALS['mysqli']->query ( "SELECT * from sender WHERE id = '{$_POST['ID']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$array = mysqli_fetch_array ( $query );
	$array2 [] = $array ['from_email'];
	$array2 [] = $array ['error_email'];
	$array2 [] = $array ['test_email'];
	
	// Check ob
	foreach ( $array2 as $value ) {
		
		$query = $GLOBALS['mysqli']->query ( "SELECT * from verification WHERE email = '$value' and user_id = '{$_SESSION['user_id']}'" );
		$array = mysqli_fetch_array ( $query );
		// Wenn Eintrag vorhanden ist und checked gesetzt ist
		if ($array ['checked'] == 1) {
			$count ++;
		}		// Wenn der Eintrag nicht existiert wird einer erzeugt
		elseif ($value) {
			$value;
			$_POST ['email'] = $value;
			$no_load = true;
			include ('../inc/verification_check.php');
			echo "error";
		}
	}
	echo "ok";
} 

// Aufruf für das Warnzeichen bei dem Link "Verifikation"
else {
	$profil_query = $GLOBALS['mysqli']->query ( "SELECT * from verification WHERE user_id = '{$_SESSION['user_id']}' and checked = 0" );
	echo mysqli_num_rows ( $profil_query );
}
?>