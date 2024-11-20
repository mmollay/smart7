<?php
/*
 * Einpflegen der Daten in die Datenbank
 * mm@ssi.at am 06.01.2011
 */
include_once ('../../login/config_main.inc.php');
include_once ('../include.php');

//Speichert option für Company
$array_option_fields = array ( 'register_allowed' => $_POST['register_allowed']  , 'facebook_login' => $_POST['facebook_login'] );
save_company_option($array_option_fields,$company_id);

echo "$('#form_message').html(\"<div class='ui green message'><i class='close icon'></i><div id='form_message_info' class='header'>Daten wurden gespeichert</div>\");";
echo "$(this).closest('.message').fadeOut();"
?>