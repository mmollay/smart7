<?php
// MAIL CONFIG DATEN ZUM VERSENDEN VON Mails

// Bei Localhost(zum testen werden diese Daten verwendet - da die Mailjet API am Localhost nicht funktionert)
if ($_SERVER['HTTP_HOST'] == 'localhost') {
	$MailConfig['delivery_system'] = 'phpmailer';
	$MailConfig['smtp_host'] = 'in-v3.mailjet.com';
	$MailConfig['smtp_user'] = '452e5eca1f98da426a9a3542d1726c96';
	$MailConfig['smtp_password'] = '55b277cd54eaa3f1d8188fdc76e06535';
	$MailConfig['smtp_secure'] = 'ssl';
	$MailConfig['smtp_port'] = '465';
	
} else {
	// Serverseitg wird immer über Mailjet API versendet
	$MailConfig['delivery_system'] = 'mailjet';
	$MailConfig['smtp_host'] = 'in-v3.mailjet.com';
	$MailConfig['smtp_user'] = '452e5eca1f98da426a9a3542d1726c96';
	$MailConfig['smtp_password'] = '55b277cd54eaa3f1d8188fdc76e06535';
	$MailConfig['smtp_secure'] = 'ssl';

	// Server 5 Relay
	// $MailConfig['smtp_host'] = 'h2480496.stratoserver.net';
	// $MailConfig['smtp_user'] = '';
	// $MailConfig['smtp_password'] = '';
	// $MailConfig['smtp_secure'] =  'tls';
	// $MailConfig['smtp_port'] = '25';
}