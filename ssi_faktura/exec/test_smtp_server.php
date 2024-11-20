<?
/*
 * mm@ssi.at am 17.09.2012
 * Check SMTP-connect
 * @test_smtp_server.php
 */
session_start ();
$user_id = $_SESSION ['user_id'];
date_default_timezone_set ( 'Europe/Berlin' );
// Default -SMTP-Config

//  $MailConfig['smtp_host'] = 'in-v3.mailjet.comf';
//  $MailConfig['smtp_user'] = '452e5eca1f98da426a9a3542d1726c96';
//  $MailConfig['smtp_password'] = '55b277cd54eaa3f1d8188fdc76e06535';

$MailConfig ['smtp_host'] = $_POST ['smtp_host'];
$MailConfig ['smtp_user'] = $_POST ['smtp_user'];
$MailConfig ['smtp_password'] = $_POST ['smtp_password'];
$MailConfig ['smtp_secure'] = $_POST ['smtp_secure'];
$MailConfig ['Port'] = $_POST ['smtp_port'];

$error_email = 'office@ssi.at';
$from_email = 'office@ssi.at';
$from_name = 'From Office SSI';
$to_email = 'office@ssi.at';
$to_name = 'To Office SSI';
$subject = 'Testmail von Newsletter';
$text = 'Überprüfung eines SMTP-Servers von User:' . $user_id;

include_once (__DIR__ . '/../../ssi_smart/php_functions/phpmailer/PHPMailerAutoload.php');

// $pop = new POP3();
// $pop->Authorise($MailConfig['smtp_host'], 995, 30, $MailConfig['smtp_user'], $MailConfig['smtp_password'], 1);

$mail = new PHPMailer ();
$mail->IsSMTP (); // telling the class to use SMTP
$mail->SMTPAuth = true;
// enable SMTP authentication
$mail->CharSet = "UTF-8";
$mail->Host = $MailConfig ['smtp_host']; // SMTP server
$mail->Username = $MailConfig ['smtp_user']; // Username
$mail->Password = $MailConfig ['smtp_password']; // Password
$mail->SMTPSecure = $MailConfig ['SMTPSecure']; // sets the prefix to the servier
$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
$mail->Port = $MailConfig ['Port']; // set the SMTP port for the GMAIL server
                                         
// ReturnPath
$mail->Sender = $error_email;

$mail->SetFrom ( $from_email, $from_name );
$mail->AddReplyTo ( $error_email, $error_email );
$mail->AddAddress ( $to_email, $to_name );

$mail->Subject = $subject;
$mail->Body = $text;
// $mail->AltBody = "Hier kommt noch mehr text Möllay"; // optional, comment out and test

if (! $mail->Send ()) {
	$mail_info = "Verbindung fehl geschlagen<br>" . $mail->ErrorInfo;
} else {
	echo "ok";
}

// echo $mail_info;
?>