<?php

// Set Remoteadresse
if ($_SERVER['REMOTE_ADDR'] == '85.214.125.223')
	$remote_addr = 'uninewsletter.ssi.at';
else
	$remote_addr = 'newsletter.ssi.at';

$TEXT_AFTER_EMAIL_HTML = "
<br><br>
--<br>Wenn Sie in Zukunft keine E-Mails mehr erhalten möchten klicken Sie bitte
<a href= http://$remote_addr/unsubscribe.php?cancel_id={%verify_key%}&session_id=$session_id>hier</a>";

// Wenn Sie in Zukunft keine E-Mails mehr erhalten möchten oder wenn sich Ihre E-Mail-Adresse geändert hat, klicken Sie bitte
$TEMPLATES_INTRO2 = array ( 'm' => 'Lieber' , 'f' => 'Liebe' , 'c' => 'Liebe Firma','e'=>'Hallo' );
$TEMPLATES_INTRO3 = array ( 'm' => 'Sehr geehrter Herr' , 'f' => 'Sehr geehrte Frau' , 'c' => 'Sehr geehrte Firma', 'e' => 'Sehr geehrte Damen und Herren');

require_once ('../../login/config_mail.php');
$default_smtp_server = $MailConfig['smtp_host'];
$default_smtp_user = $MailConfig['smtp_user'];
$default_smtp_password = $MailConfig['smtp_password']; // mysql -> "ENCRYPT"
$default_smtp_port = $MailConfig['smtp_port'];
$default_smtp_secure = $MailConfig['smtp_secure'];
?>