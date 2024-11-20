<?php
session_start ();

require_once ('../mysql.inc');
require_once ('../functions.inc.php');

foreach ( $_POST as $key => $value ) {
	$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
}

$GLOBALS['mysqli']->query("REPLACE INTO `setting` SET 
user_id = '{$_SESSION['user_id']}',
default_from_id = '$default_from_id',
delivery_system = '$delivery_system',
mws_merchant_id_eu = '$mws_merchant_id_eu',
mws_auth_token_eu = '$mws_auth_token_eu'
") or die (mysqli_error());

echo "$('#form_message').html(\"<div class='ui green message'><i class='close icon'></i><div id='form_message_info' class='header'>Daten wurden gespeichert</div>\");";