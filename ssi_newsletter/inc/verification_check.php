<?

// falls die Funktion von verify_check_open.php geladen wird
// Auslesen der Optionen aus der Datenbank
session_start ();
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

$email = $_POST ['email'];
$user_id = $_SESSION ['user_id'];
$verify_key = md5 ( uniqid ( rand (), TRUE ) );

if (! $email)
	return;
	
	// Contact2group auslesen
	// Auslesen der Werte mit Anzeige der Anzahl der Kontakte pro Label (Gruppe)
$verification_query = $GLOBALS['mysqli']->query ( "SELECT * FROM verification where email = '$email' and user_id = '$user_id' Limit 1 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$verification_array = mysqli_fetch_array ( $verification_query );
$count = mysqli_num_rows ( $verification_query );

$checked = $verification_array ['checked'];

// erzeugt Key
if (! $count) {
	$GLOBALS['mysqli']->query ( "INSERT INTO verification SET
	user_id = '$user_id',
	email   = '$email',
	verify_key = '$verify_key',
	ip      = '{$_SERVER['REMOTE_ADDR']}'
	" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
}

if (! $count or ! $checked)
	echo "<a href=# style='float:right' class='ui-icon ui-icon-alert red' title='$email muss noch verifiziert werden!' ></a>";

?>