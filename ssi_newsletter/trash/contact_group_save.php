<?php
// Auslesen der Optionen aus der Datenbank
session_start ();
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

// pruefen ob Name bereits existiert
$check_query = $GLOBALS['mysqli']->query ( "SELECT * FROM `group` WHERE title = '{$_POST['group_name']}' AND user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$exists = mysqli_num_rows ( $check_query );

if (! $exists) {
	$GLOBALS['mysqli']->query ( "INSERT INTO `group` SET user_id = '{$_SESSION['user_id']}', title = '{$_POST['group_name']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	echo mysqli_insert_id ($GLOBALS['mysqli']);
} else {
	echo "exists";
}
?>