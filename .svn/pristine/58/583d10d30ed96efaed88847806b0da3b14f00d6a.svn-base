<?
session_start ();
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

$id = $_POST ['id'];

// Check ob Wert in DB bereits existiert
$query = $GLOBALS['mysqli']->query ( "SELECT * FROM templates WHERE user_id = {$_SESSION['user_id']} AND id = '$id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$array = mysqli_fetch_array ( $query );
echo $array ['text'];
?>