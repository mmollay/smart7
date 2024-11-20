<?php
include_once ('../../login/config_main.inc.php');
include_once ('../include.php');

// Speichert option für Company
$array_option_fields = array ( 'smtp_email' => $_POST['smtp_email'] ,
		'smtp_title' => $_POST['smtp_title'] ,
		'smtp_host' => $_POST['smtp_host'] ,
		'smtp_user' => $_POST['smtp_user'] ,
		'smtp_password' => $_POST['smtp_password'] ,
		'smtp_port' => $_POST['smtp_port'] ,
		'smtp_secure' => $_POST['smtp_secure'] );
save_company_option ( $array_option_fields, $company_id );

echo "$('#form_message').html(\"<div class='ui green message'><i class='close icon'></i><div id='form_message_info' class='header'>Daten wurden gespeichert</div>\");";
?>