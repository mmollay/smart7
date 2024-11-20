<?
include_once ('../../ssi_smart/php_functions/functions.php');

//Verhindert den Aufruf wenn user_id nicht Superuser ist
check_mysql_insert("SELECT COUNT(*) FROM ssi_company.comp_options WHERE option_name='superuser_id' AND option_value = '{$_SESSION['user_id']}' AND company_id = '{$_SESSION['smart_company_id']}'", "" );

//Auslesen der Werte und in das Form übergeben;
$array['value'] = call_company_option($_SESSION['smart_company_id']);
?>