<?php
session_start ();
require_once '../../login/config_main.inc.php';
require_once '../getorgchart/function_getorgchart.php';

$sql = "SELECT 
		user_id id,
		parent_id parent_id, 
		CONCAT(firstname,' ',secondname) name,
		user_name email,
		zip zip,
		CONCAT ('ID:',user_id) title
		FROM ssi_company.user2company";

//Zusatzprameter fur jquery

echo call_date($_SESSION['user_id'],$sql,$jquery_parameter);