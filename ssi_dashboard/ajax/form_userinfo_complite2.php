<?php
/*
 * Speichern der Userdaten zum vervollständigen
 * mm@ssi.at am 23.02.2017
 */
include ('../../login/config_main.inc.php');

foreach ( $_POST as $key => $value ) {
	$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
}

$GLOBALS['mysqli']->query ( "UPDATE ssi_company.user2company SET 
	firstname = '$firstname',
	secondname = '$secondname',
	zip = '$zip',
	gender = '$gender',
	street = '$street',
	city = '$city',
	country = '$country',
	confirm_agb = '$confirm_agb'
	WHERE user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );

echo "$('#form_register').replaceWith(\"<div class='ui attached segment'><br><br><br><div class='ui active inverted dimmer'><div class='ui text loader'>Seite wird neu geladen</div></div><br><br></div>\");";
echo "window.top.location.reload();";
?>