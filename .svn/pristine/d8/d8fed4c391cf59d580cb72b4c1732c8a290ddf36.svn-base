<?php
$REAL_MODE = true;
date_default_timezone_set ( 'Europe/Vienna' );

// SESSION - Parameter
$session_id = $send_session ['session_id'];
$user_id = $send_session ['user_id'];
$traffic = $send_session ['traffic'];
$subject = $send_session ['title'];
$text = $send_session ['text'];
$followup_id = $send_session ['followup_id'];

$without_footline = $send_session ['without_footline'];
$from_email = $send_session ['from_email'];
$from_name = $send_session ['from_name'];
$replay_email = $send_session ['replay_email'];
$replay_name = $send_session ['replay_name'];
$smtp_server = $send_session ['smtp_server'];
$smtp_user = $send_session ['smtp_user'];
$smtp_password = $send_session ['smtp_password'];
$smtp_port = $send_session ['smtp_port'];
$smtp_secure = $send_session ['smtp_secure'];
$modus = $send_session ['modus'];

$upload_dir = $document_root . "/smart_users/$comp_matchcode/user{$user_id}/newsletter"; // Bei Upload muss der absolute Serverpfad verwendet werden

if (! $test_email) {
	$template ['firstname'] = $send_array ['firstname'];
	$template ['secondname'] = $send_array ['secondname'];
	$template ['intro_personal'] = $TEMPLATES_INTRO2 [$send_array ['sex']];
	$template ['intro_formal'] = $TEMPLATES_INTRO3 [$send_array ['sex']];

	// Wenn kein Geschlecht gewählt ist
	// Wenn kein Vorname vorhanden ist
	if (! $template ['intro_formal'] or ! $template ['firstname'] or ! $template ['intro_personal']) {
		$template ['intro_formal'] = $template ['intro_personal'] = 'Hallo';
	}

	if (! $template ['secondname']) {
		$template ['intro_formal'] = 'Sehr geehrte Damen und Herren';
	}

	$template ['title'] = $send_array ['title'];
	$template ['company1'] = $send_array ['company_1'];
	$template ['company2'] = $send_array ['company_2'];
	$template ['street'] = $send_array ['street'];
	$template ['city'] = $send_array ['city'];
	$template ['zip'] = $send_array ['zip'];
	$template ['county'] = $send_array ['country'];
	$template ['verify_key'] = $send_array ['verify_key'];
	$template ['birth'] = $send_array ['birth'];
	$template ['client_number'] = $send_array ['client_number'];
	$template ['placeholder1'] = $send_array ['placeholder1'];
	$template ['placeholder2'] = $send_array ['placeholder2'];
	$template ['placeholder3'] = $send_array ['placeholder3'];
	$error_email = $send_array ['error_email'];
	$to_email = $send_array ['email'];
	$to_name = $send_array ['email'];
}

// USER-Mail - Parameters
$logfile_id = $send_array ['logfile_id'];
$client_id = $send_array ['client_id'];
$modul = $send_array ['modul'];
$no_unsubscribe = $send_array ['no_unsubscribe'];
// $without_footline = $send_array['without_footline'];

// Use SMTP (optional)
if ($smtp_server or ($smtp_server && $smtp_user && $smtp_password)) {
	$MailConfig ['smtp_host'] = $smtp_server;
	$MailConfig ['smtp_user'] = $smtp_user;
	$MailConfig ['smtp_password'] = $smtp_password;
	$MailConfig ['smtp_secure'] = $smtp_secure;
	$MailConfig ['smtp_port'] = $smtp_port;
} else {
	// Default - SMTP - Server
	// $MailConfig['smtp_auth'] = 'true';
	$MailConfig ['smtp_host'] = $default_smtp_server;
	$MailConfig ['smtp_user'] = $default_smtp_user;
	$MailConfig ['smtp_password'] = $default_smtp_password;
	$MailConfig ['smtp_secure'] = $default_smtp_secure;
	$MailConfig ['smtp_port'] = $default_smtp_port;
}

// Check the verify_key
if (! $template ['verify_key']) {
	$template ['verify_key'] = md5 ( uniqid ( rand (), TRUE ) );
	// verify_key in Datenbank eintragen
	mysqli_query ( $cfg, "UPDATE contact SET verify_key = '{$template['verify_key']}' where contact_id = '$client_id'" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	// mysql_query("UPDATE contact2group SET verify_key = '{$template['verify_key']}' where contact_id = '$client_id' and ") or die (mysql_error());
	mysqli_query ( $cfg, "UPDATE logfile SET verify_key = '{$template['verify_key']}' where id = '$logfile_id'" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$set_modul = 'default';
}

// Emails by "manual-modus" 03.10.2011
if (! $no_unsubscribe) {
	// Text after Message
	$set_TEXT_AFTER_EMAIL_HTML = $TEXT_AFTER_EMAIL_HTML;
	$set_TEXT_AFTER_EMAIL_TEXT = $TEXT_AFTER_EMAIL_TEXT;
}

// Ohne "Newsletter abbestellen
if ($without_footline) {
	$set_TEXT_AFTER_EMAIL_HTML = '';
	$set_TEXT_AFTER_EMAIL_TEXT = '';
}

// <style type='text/css'> a { color:#222222; text-decoration:none; font-weight:normal; }</style>
// HTML - FORMAT

//topmargin='0' rightmargin='10' leftmargin='0'

$text = "
	<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
	<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
		<title>$subject</title>
	</head>
	<body>
	$text
	$set_TEXT_AFTER_EMAIL_HTML
	</body></html>
	";

// für die Weiterleitung zum Aufrufen personalisierter Seiten
$template ['token'] = $template ['verify_key'];

// Preg
// $subject = preg_replace ( '!{%(.*?)%}!e', '$template[ \1 ]', $subject );
$subject = preg_replace_callback ( '!{%(.*?)%}!', function ($matches) {
	global $template;
	return $template [$matches [1]];
}, $subject );

// $text = preg_replace ( '!{%(.*?)%}!e', '$template[ \1 ]', $text );
$text = preg_replace_callback ( '!{%(.*?)%}!', function ($matches) {
	global $template;
	return $template [$matches [1]];
}, $text );

// Bildpfad umwandeln (da EMail versendet wird und einen absoluten Pfad braucht
$text = preg_replace ( "[/smart_users/]", "https://center.ssi.at/smart_users/", $text );

// Ausführen von PHP
// WARNING !!! - Sollte nur unter gewissen Umständen für den User ausführbar sein!!!

/*
 ob_start ();
 eval ( "?>$text" );
 $text = ob_get_clean ();
*/

// Remove Backspaces
$subject = stripslashes ( $subject );
$text = stripslashes ( $text );
if ($REAL_MODE == true) {
	$MailConfig ['from_email'] = $from_email; // ABSENDER Email
	$MailConfig ['from_name'] = $from_name; // ABSENDER Name
	$MailConfig ['relay_email'] = $relay_email; // ZURÜCK AN Email (Kann leer bleiben)
	$MailConfig ['relay_name'] = $relay_name; // ZURÜCK AN Email (Kann leer bleiben)
	$MailConfig ['to_email'] = $to_email; // AN Email
	$MailConfig ['to_name'] = $to_name; // AN Name
	$MailConfig ['subject'] = $subject; // Betreff
	$MailConfig ['text'] = $text; // Text
	
	if ($followup_id) {
		$MailConfig ['path'] = "/var/www/ssi/smart_users/ssi/user$user_id/newsletter/followup/$followup_id";
	}
	else {
		$MailConfig ['path'] = "$upload_dir/$session_id";
	}
	
	/**
	 * Function - Aufruf -VERSENDEN einer Email über Mailjet oder PHPmailer
	 */
	include_once ('../../ssi_smart/php_functions/function_sendmail.php');
	$mail_result = smart_sendmail ( $MailConfig, true );

	// Wenn MessageID für Mailjet mit uebergeben wird
	if (is_array ( $mail_result )) {
		$mail_info = $mail_result ['mail_info'];
		$MessageID = $mail_result ['MessageID'];
	} else
		$mail_info = $mail_result;

	if ($mail_info != 'ok')
		$error = 1;
	else
		$error = 0;

	// Sendung bestätigen
	if (! $test_email) {
		mysqli_query ( $cfg, "UPDATE logfile SET
		traffic   = '$traffic',
		sendtime  = NOW(),
		sendet    = 1,
		`error`   = $error,
		mail_info = '$mail_info',
		MessageID = '$MessageID'
		WHERE id = '$logfile_id'
		" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	}
} else
	$mail_info = "Testmodus - Nicht versendet";
?>