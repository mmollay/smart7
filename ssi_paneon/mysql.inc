<?php 
include (__DIR__.'/../login/config_main.inc.php');


$cfg_mysql['user_nl'] = 'smart';
$cfg_mysql['password_nl'] = 'Eiddswwenph21;';
$cfg_mysql['host_nl'] = 'localhost';
$cfg_mysql['db_nl'] = 'ssi_newsletter2';

$sql_host = $cfg_mysql['host_nl'];
$sql_user = $cfg_mysql['user_nl'];
$sql_pass = $cfg_mysql['password_nl'];
$sql_db = $cfg_mysql['db_nl'];

$cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
mysqli_select_db ($cfg, $sql_db ) or die ( 'Could not select database ' . $gaSql['db'] );

$GLOBALS['mysqli'] = new mysqli ($sql_host, $sql_user, $sql_pass, $sql_db ) or die ( "Could not open connection to server {$cfg_mysql['server']}" );

if ($_SESSION['list_search'] and $_SESSION['filter_table'] == 'user') {
	$add_mysql .= " and MATCH(Vorname,Nachname,Email,client_id) AGAINST ('{$_SESSION['list_search']}*' IN BOOLEAN MODE)";
}

$array_user = array(
		'table_main'  => 'tbl_user_paneon',
		'table'       => 'tbl_user_paneon t1 INNER JOIN  tbl_user_details ON tbl_user_details.client_id = t1.client_id ',
		'indexColumn' => "t1.client_id",
		'indexFieldId'=> 'client_id',
		'where'       => '1 '.$add_mysql,
		'fields'      => "
		user_id,
		if (ActiveVorgID=0,'',ActiveVorgID) ActiveVorgID,
		(SELECT count(*) from tbl_user_paneon WHERE ActiveVorgID = t1.client_id) counter_ActiveVorg,
		(SELECT count(*) from tbl_user_paneon WHERE InitiatorID = t1.client_id) counter_Initiator,
		DATE_FORMAT(t1.update_time,'%Y-%m-%d') update_time, CONCAT(Anrede,' ',Vorname,' ',Nachname) name,
		Rabatt+DifProv+BalProv+InProv Auszahlg, tbl_user_details.EiUmsatz EiUmsatz,
		InitiatorID,Email,
		t1.IpUmsatz, t1.KuUmsatz
		"
);

?>