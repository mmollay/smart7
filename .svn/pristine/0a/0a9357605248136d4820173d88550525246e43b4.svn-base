<?php
/*
 * mm@ssi.at am 17.09.2012
 * Check SMTP-connect
 * @test_smtp_server.php
 */
session_start ();
$user_id = $_SESSION['user_id'];

// Wird mit ajax zum testen übergeben, bei Erfolg, dann durch ok bestätigt und zum speichern freigegeben
$MailConfig['smtp_host'] = $_POST['smtp_host'];
$MailConfig['smtp_user'] = $_POST['smtp_user'];
$MailConfig['smtp_password'] = $_POST['smtp_password'];
$MailConfig['smtp_secure'] = $_POST['smtp_secure'];
$MailConfig['smtp_port'] = $_POST['smtp_port'];

$MailConfig['from_email'] = 'newsletter@ssi.at'; // ABSENDER Email
$MailConfig['from_name'] = 'Office SSI'; // ABSENDER Name
$MailConfig['relay_email'] = 'newsletter@ssi.at'; // ZURÜCK AN Email (Kann leer bleiben)
$MailConfig['relay_name'] = 'newsletter@ssi.at'; // ZURÜCK AN Email (Kann leer bleiben)
$MailConfig['to_email'] = 'martin@ssi.at'; // AN Email
$MailConfig['to_name'] = 'Martin Mollay'; // AN Name
$MailConfig['subject'] = 'SMTP-Test'; // Betreff
$MailConfig['text'] = $text = 'Überprüfung eines SMTP-Servers von User:' . $user_id;

include_once ('../../ssi_smart/php_functions/function_sendmail.php');
echo smart_sendmail ( $MailConfig ); // ok oder error

?>