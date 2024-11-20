<?
// Zugangsdaten fuer die Datenbank
session_start ();
require_once ('../mysql.inc');

$session_id = $_POST ['id'];

if (! $session_id)
	exit ();
	
// Prüft ob die Emaildressen verifiziert worden sind
$query1 = $GLOBALS['mysqli']->query ( "SELECT checked FROM session INNER JOIN verification ON  email = from_email WHERE session_id = '$session_id' AND checked =1 " );

if (mysqli_num_rows ( $query1 )) {
	
	// SET Newsletter active for SEND
	$GLOBALS['mysqli']->query ( "UPDATE session SET `release`=1, status = '3', datetime_start = NOW() WHERE session_id = '$session_id' LIMIT 1" ) or die ( mysqli_error ($GLOBALS['mysqli']) );

	// newsletterversand starten
	//scheint nicht zu funktionieren - muss über die Shell gesztartet werden
	//exec ( "cd /http-public/ssi/center/ssi_newsletter/exec/ | php SendNewsletter.inc.php" );
}
?>