<?php
include_once ('../../login/config_main.inc.php');
include_once ('../include.php');

$element = $_POST['element'];

$array_option_fields = array ( $element . '_title' => $_POST[$element . '_title'] , $element . '_text' => $_POST[$element . '_text'] );
save_company_option ( $array_option_fields, $company_id );

echo "$('#form_message_$element').html(\"<div class='ui green message'><i class='close icon'></i><div id='form_message_info' class='header'>Daten wurden gespeichert</div>\");";
?>