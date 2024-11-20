<?php
session_start ();

require_once ('../mysql.inc');


foreach ( $_POST as $key => $value ) {
	$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
}

$GLOBALS['mysqli']->query("REPLACE INTO ssi_paneon.`setting` SET 
user_id = '{$_SESSION['user_id']}',
default_page_id = '$default_page_id'
") or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

$_COOKIE["smart_page_id"] = $_SESSION['smart_page_id'] = $default_page_id;
setcookie("smart_page_id", $_COOKIE["smart_page_id"], time() + 60 * 60 * 24 * 365, '/', $_SERVER['HTTP_HOST']);

echo "$('#form_message').html(\"<div class='ui green message'><i class='close icon'></i><div id='form_message_info' class='header'>Daten wurden gespeichert</div>\");";