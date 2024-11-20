<?php
session_start ();
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

$matchode = $_POST ['matchcode'];
$title = $_POST ['title'];
$text = $_POST ['text'];
$update_id = $_POST ['update_id'];
$format = $_POST ['format'];

// Check ob Wert in DB bereits existiert
$query = $GLOBALS['mysqli']->query ( "SELECT * FROM templates WHERE user_id = {$_SESSION['user_id']} AND matchcode = '$matchode' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$check = mysqli_num_rows ( $query );
if ($check && ! $update_id) {
	echo "duplicate";
} else {
	
	// Update des Templates
	if ($update_id) {
		$GLOBALS['mysqli']->query ( "UPDATE templates SET title='$title',format='$format',text='$text', label_id = '{$_SESSION['label_id']}' WHERE id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		echo 'update';
	} 	// Insert new Template
	else {
		// Textbaustein speichern
		$GLOBALS['mysqli']->query ( "INSERT INTO templates SET matchcode='$matchode',format='$format',title='$title',text='$text', label_id = '{$_SESSION['label_id']}',user_id='{$_SESSION['user_id']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$id = mysqli_insert_id ($GLOBALS['mysqli']);
		echo $id;
	}
}
?>