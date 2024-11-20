<?
session_start ();
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

$id = $_POST ['id'];

// Check ob Wert in DB bereits existiert
$GLOBALS['mysqli']->query ( "DELETE From templates WHERE id = '$id' Limit 1" ) or die ( mysqli_error ($GLOBALS['mysqli']) );

$query_templates = $GLOBALS['mysqli']->query ( "SELECT id,matchcode FROM templates WHERE user_id = '{$_SESSION['user_id'] }' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
while ( $set_array_template = mysqli_fetch_array ( $query_templates ) ) {
	$template_id = $set_array_template ['id'];
	$template_name = $set_array_template ['matchcode'];
	$array_templates [$template_id] = $template_name;
}

if ($array_templates)
	echo json_encode ( $array_templates );
else
	echo "";