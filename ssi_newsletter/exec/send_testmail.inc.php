<?php
/**
 * SendNewsletter.inc - versenden eines Testnewletters
 *
 * @author Martin Mollay
 * @last-changed 2014-01-20 (MM)
 *
 */
$session_id = $_POST['id'];

// Connect to db
include_once ('../mysql.inc');
include_once ('SendNewsletter_values.php');
include_once ('../functions.inc.php');

// Abruf welches Mailsystem verwendet wird
$query_system = mysqli_query ( $cfg, "SELECT * from setting WHERE user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
$array_system = mysqli_fetch_array ( $query_system );
$delivery_system = $array_system['delivery_system'];

/**
 * ******************************************************************
 * TESTMAIL
 * *******************************************************************
 */

$sql_session = mysqli_query ( $cfg, "
		SELECT session.session_id session_id, session.user_id user_id,modus, without_footline,
		session.smtp_server,session.smtp_user,session.smtp_password,session.smtp_port,session.smtp_secure,
		session.title subject,text, session.from_email, session.from_name, session.replay_email, session.replay_name, session.error_email, sender.test_email
		FROM session INNER JOIN sender ON sender.id = sender_id WHERE session_id = '$session_id'
		" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
$send_session = mysqli_fetch_array ( $sql_session );

$to_email = $test_email = $error_email = $send_session['test_email'];

$query = mysqli_query ( $cfg, "SELECT count(checked) from verification WHERE email = '$test_email' and checked = 1 and user_id = '{$_SESSION['user_id']}'" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
$array = mysqli_fetch_array ( $query );
if ($array[0] == 0) {
	echo "$('#modal_testmail>.content').html('<div class=\'ui icon message error\'><i class=\'icon warning\'></i><div class=\'content\'><br>Zum versenden muss die Testemail <b>{$send_session['test_email']}</b> muss noch verifiziert<br><br></div></div>');";
	exit ();
}

// $to_email = $send_array['test_email'];
$send_session ['title'] = "Testmail: {$send_session['subject']}";

// Testmail - Daten
$template['firstname'] = 'Max';
$template['secondname'] = 'Muster';
$template['intro_personal'] = $TEMPLATES_INTRO2['m'];
$template['intro_formal'] = $TEMPLATES_INTRO3['m'];
// $template ['title'] = 'Mag.';
$template['company1'] = 'Firma1';
$template['company2'] = 'Firma2';
$template['street'] = 'Straße';
$template['city'] = 'Wiener Neustadt';
$template['zip'] = '2700';
$template['county'] = 'Österreich';
$template['client_number'] = '1234567';
$template['placeholder1'] = 'placeholder1';
$template['placeholder2'] = 'placeholder2';
$template['placeholder3'] = 'placeholder3';
$template['verify_key'] = $template['token'] = 'xxxxxxxxxxxxxxxxxxxxxx';
$template['birth'] = '21.08.1975';

// Auslesen des Company - Matchcodes für Attachment -pfad
$comp_matchcode = call_company_matchcode ( $_SESSION['user_id'], $cfg );

include ('SendNewsletter_temp.php');

if ($mail_info == 'ok') {
	$datum = date("d.m.Y");
	$uhrzeit = date("H:i");
	$sendtime =  $datum." - ".$uhrzeit." Uhr";
	echo "$('#modal_testmail>.content').html('<div class=\'ui icon message success\'><i class=\'icon check\'></i><div class=\'content\'><br>Testmail wurde erfolgreich an <b>{$send_session['test_email']}</b> versendet!<br><i>($sendtime)</i><br><br></div></div>');";
} else
	echo "$('#modal_testmail>.content').html('<div class=\'ui icon message error\'><i class=\'icon warning\'></i><div class=\'content\'><br>Fehler beim versenden!<br><br></div></div>');";
?>