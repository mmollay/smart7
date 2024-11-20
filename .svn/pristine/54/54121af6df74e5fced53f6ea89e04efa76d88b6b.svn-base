<?php
session_start ();
include ('../../login/config_main.inc.php');
require_once '../../login/function.inc.php';

$sql = "SELECT
		user_id id,
		parent_id parent_id,
		CONCAT(firstname,'',secondname) name,
		user_name email,
		zip zip,
		CONCAT ('ID:',user_id) title
		FROM ssi_company.user2company";


$sql = "SELECT
		client_id id,
		InitiatorID parent_id,
		CONCAT(Vorname,'',Nachname) name,
		Email email,
		CONCAT (Plz,' ',Ort) zip,
		CONCAT ('ID:',client_id) title
		FROM tbl_user_paneon";

//Zusatzprameter fur jquery
$jquery_parameter = array(
		"color" => "'blue'",
		gridView => true,
		orientation => "OrgChart.RO_LEFT",
);

echo call_date('124302126',$sql,$jquery_parameter);