<?php
// Connect to db
include ("../config.inc.php");
include_once (__DIR__ . '/../../ssi_smart/php_functions/phpmailer/PHPMailerAutoload.php');
include ("../../login/config_mail.php");
include ('../inc/call_remind_list.php');

// Wenn alle gemahnt wurden, dann wird keine Email ausgesendet
if (! $counter_sum)
	exit ();

$text = '<h2>Übersicht der zu mahnenden Rechnungen</h2>';
$text .= $info_list_table;
$text .= "<br><br><b><a href =https://center.ssi.at><b>ZUR WEBSEITE</b></a><br><br>";

$from_email = $error_email = 'office@ssi.at';
$from_name = $error_name = 'SSI-Faktura';
$to_email = 'martin@ssi.at';
$to_name = 'Martin Mollay';
$subject = 'Es ist wieder Zeit zum mahnen ;)';

$email_list ['1'] ['email'] = 'office@ssi.at';
$email_list ['1'] ['name'] = 'Martin Mollay';

error_reporting ( E_STRICT );
date_default_timezone_set ( 'Europe/Belgrade' );

$mail = new PHPMailer ();
$mail->IsSMTP (); // telling the class to use SMTP
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->CharSet = "UTF-8";
$mail->Host = $MailConfig ['smtp_host']; // SMTP server
$mail->Username = $MailConfig ['smtp_user']; // Username
$mail->Password = $MailConfig ['smtp_password']; // Password
$mail->SMTPSecure = $MailConfig ['SMTPSecure']; // sets the prefix to the servier
$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
$mail->Port = $MailConfig ['Port']; // set the SMTP port for the GMAIL server

foreach ( $email_list as $array ) {
	
	$to_email = $array ['email'];
	$to_name = $array ['name'];
	
	$mail->Sender = $error_email;
	$mail->SetFrom ( $from_email, $from_name );
	$mail->AddReplyTo ( $error_email, $error_name );
	$mail->AddAddress ( $to_email, $to_name );
	$mail->Subject = $subject;
	$mail->MsgHTML ( $text );
	if (! $mail->Send ()) {
		$mail_info = $mail->ErrorInfo;
		$error = 1;
	} else {
		$mail_info = "ok";
		$error = 0;
	}
}
?>