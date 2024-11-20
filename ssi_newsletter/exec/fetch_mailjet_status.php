	<?php
// Wird nur aufgerufen wenn alle Paramete von einer Aussendung abgerufen werden sollen
include ('../../ssi_smart/php_functions/mailjet_api.php');
include ('../functions.inc.php');

include_once ('../config_newsletter.php');
/* Einstellungen */
$sql_host = $cfg_mysql['host_nl'];
$sql_user = $cfg_mysql['user_nl'];
$sql_pass = $cfg_mysql['password_nl'];
$sql_db = $cfg_mysql['db_nl'];

$GLOBALS['mysqli'] = new mysqli ($cfg_mysql['host_nl'], $cfg_mysql['user_nl'], $cfg_mysql['password_nl'], $cfg_mysql['db_nl'] ) or die ( "Could not open connection to server {$cfg_mysql['server']}" );


// Ruft aktueulle Werte von Mailjet auf und weißt diese dem System zu
if ($_GET['session_id']) {
	// reset_error ( 60);
	call_status ( $_GET['session_id'] );
	echo "ok";
	exit ();
}

exit ();

// Ruft in regelmässigen Abständen die Statistiken von Mailjet auf
$sql_query = $GLOBALS['mysqli']->query ( "SELECT session_id FROM session order by datetime_end desc LIMIT 5" );
while ( $array = mysqli_fetch_array ( $sql_query ) ) {
	$session_id = $array['session_id'];
	call_status ( $session_id );
}
echo "fertig";

// MeessageID - Status abrufen
function call_status($session_id) {
	// Abrufen der aktuellen Infos
	$mail = new MailJetMailer ();
	$mail->Username = '452e5eca1f98da426a9a3542d1726c96'; // MailJet Public key
	$mail->Password = '55b277cd54eaa3f1d8188fdc76e06535'; // MailJet Private key
	
	$query = $GLOBALS['mysqli']->query ( "SELECT MessageID FROM logfile WHERE session_id  = '$session_id' AND MessageID AND status != 'unsub' AND status != 'clicked'  " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$MessageID = $array[MessageID];
		echo $MessageID;
		echo "<br>";
		flush();
		ob_flush();
		$status = $mail->getMailInfo ( $MessageID );
		$email = $status[0]->Email;
		
		// in der Db muss der Wert open gespeichert werden, da bei WebHook "open" und nicht "opened" übergeben wird
		
		// echo (json_encode ( $status ) . "\n");
		// print_r ( $status );
		$event = $status[0]->Status;
		if ($event == 'opened')
			$event = 'open';
		elseif ($event == 'clicked')
			$event = 'click';
		
		if ($event) {
			// Neuer Eintrag in Logfile
			$GLOBALS['mysqli']->query ( "INSERT INTO status_log SET event='$event', timestamp=NOW(), message_id='$MessageID', email = '$email'" ) or die(mysqli_error());
			//echo "INSERT INTO status_log SET event='$event', timestamp=NOW(), message_id='$MessageID', email = '$email'";
			//echo "<br>";
			// Geöffntet
			if ($event == 'open') {
				$add_mysql_event = "AND status !='click' ";
			}
			
			$GLOBALS['mysqli']->query ( "UPDATE logfile SET status='$event', timestamp=NOW() WHERE MessageID='$MessageID' AND status != 'unsub' $add_mysql_event" );
			$GLOBALS['mysqli']->query ( "UPDATE followup_mail_logfile SET status='$event', timestamp=NOW() WHERE MessageID='$MessageID' AND status != 'unsub' $add_mysql_event" );
			
			//$GLOBALS['mysqli']->query ( "UPDATE logfile SET status='$event' WHERE MessageID = '$MessageID' AND session_id  = '$session_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
			
			// User über mailjet abgemeldet
			if ($event == 'unsub') {
				$query = $GLOBALS['mysqli']->query ( "SELECT client_id,session_id FROM logfile WHERE MessageID='$MessageID'" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
				$array = mysqli_fetch_array ( $query );
				$session_id = $array['session_id'];
				$client_id = $array['client_id'];
				$GLOBALS['mysqli']->query ( "UPDATE contact SET activate  = 0  WHERE contact_id = '$client_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
				
				// Eintrag in das Logfile
				$GLOBALS['mysqli']->query ( "INSERT INTO user_logfile SET
				contact_id='$client_id',
				session_id='$session_id' ,
				remote_ip ='{$_SERVER['REMOTE_ADDR']}',
				msg = 'unsub by mailjet' ,
				status_id = '3',
				modul='$modul',
				system='mailjet'
				" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
			}
		}
	}
}
