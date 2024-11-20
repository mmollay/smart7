<?
/*
 * mm@ssi.at am 25.02.2017
 * Check SMTP-connect
 * @test_smtp_server.php
 */
session_start ();
require_once ('../mysql.inc');
$user_id = $_SESSION ['user_id'];

$id = $GLOBALS['mysqli']->real_escape_string($_POST ['id']);

if (!$id) {
	echo "error";
}


$query = $GLOBALS['mysqli']->query ( "SELECT * from verification WHERE verify_id = '$id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$array = mysqli_fetch_array ( $query );

$verify_key = $array ['verify_key'];
$email = $array ['email'];

//Basis - Daten
include('../../login/config_mail.php');

$MailConfig['from_email'] = 'newsletter@ssi.at';
$MailConfig['from_name'] = 'SSI Newsletter';
//$MailConfig['replay_email'] = ''; 
//$MailConfig['replay_name'] = '';

//An den Codeempfänger
$MailConfig['to_email'] = $email;

$MailConfig['subject'] = 'Emailfreigabe für SSI-Newsletter';
$MailConfig['text'] = "Bitte Code <br><br><b>".$array ['verify_key']. "</b><br><br> kopieren und in das Verifizierungsfeld einfügen.";

include_once ('../../ssi_smart/php_functions/function_sendmail.php');
echo smart_sendmail ( $MailConfig );
?>