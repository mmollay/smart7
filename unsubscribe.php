<?php
/*
 * Abmelden vom Newslettersystem
 * Martin Mollay am 22.03.2017 mm@ssi.at
 */
include ('ssi_newsletter/config_newsletter.php');
include ('pages/include.php');
$sql_host = $cfg_mysql['host_nl'];
$sql_user = $cfg_mysql['user_nl'];
$sql_pass = $cfg_mysql['password_nl'];
$sql_db = $cfg_mysql['db_nl'];

$db = mysqli_connect ( $sql_host, $cfg_mysql['user_nl'], $sql_pass ) or die ( "Could not connect to server $sql_host" );
mysqli_select_db ( $db, $sql_db ) or die ( "Could not select database $sql_db" );

$cancel_id = mysqli_real_escape_string ( $db, $_GET['cancel_id'] );
$session_id = mysqli_real_escape_string ( $db, $_GET['session_id'] );

if (!$cancel_id or !$session_id) {
	echo call_page ( "Fehlerhafte Ausführung",'message error	' );
	exit;
}

if ($_GET['submit'] == 'yes') {
	
	if ($_GET['cancel_id']) {
		$check_query = mysqli_query ($db, "SELECT * FROM contact WHERE verify_key = '$cancel_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$check_array = mysqli_fetch_array ( $check_query );
		$contact_id = $check_array['contact_id'];
		$activate = $check_array['activate'];
		if (! $contact_id) {
			$msg = "Es scheint kein gültiger User zu existieren!";
			$log_msg = 'no user exist';
			$status_id = 1;
		} elseif ($activate == 0 and $contact_id) {
			$msg = "Die Emailadresse \"{$check_array['email']}\" wurde bereits im System deaktiviert!";
			$log_msg = "address already deactivated";
			$status_id = 2;
		} elseif ($contact_id and $activate = 1) {
			mysqli_query ($db,"UPDATE contact SET activate  = 0  WHERE verify_key = '$cancel_id' LIMIT 1" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
			$msg = "Ihre E-Mail-Adresse (" . $check_array['email'] . ") wurde von unserer Mailingliste entfernt.";
			$log_msg = "address deactvated";
			$status_id = 3;
		}
		
		// Eintrag in das Logfile
		mysqli_query ($db,"INSERT INTO user_logfile SET 
		contact_id='$contact_id', 
		session_id='$session_id' , 
		remote_ip ='{$_SERVER['REMOTE_ADDR']}', 
		msg = '$log_msg' , 
		status_id = '$status_id', 
		modul='$modul' 
		" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	}
	
	// Eintrage
	if ($status_id == 3) {
		mysqli_query ($db,"UPDATE logfile SET status = 'unsub' WHERE client_id = '$contact_id' AND session_id='$session_id'  LIMIT 1" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	}
} elseif ($_GET['submit'] == 'no') {
	$msg = "Ihr Newsletter wurde nicht abgemeldet!";
} else {
	
	// Prüft ob User existiert
	$check_query = mysqli_query ($db,"SELECT * FROM contact WHERE verify_key = '$cancel_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$check_array = mysqli_fetch_array ( $check_query );
	$contact_id = $check_array['contact_id'];
	if ($contact_id) {
		// First msg
		$msg = "
		Newsletter wirklich abmelden?
		<br><br>
		<a class='button ui' href = 'unsubscribe.php?submit=no'>Nicht abmelden</a>
		<a class='button ui' href = 'unsubscribe.php?submit=yes&cancel_id=$cancel_id&modul=$modul&session_id=$session_id'>Abmelden</a>";
	} else {
		$msg = "Es scheint kein Eintrag zu existieren";
	}
}
echo call_page ( $msg );
