<?php 
$cfg_mysql['user_nl'] = 'smart';
$cfg_mysql['password_nl'] = 'Eiddswwenph21;';
$cfg_mysql['host_nl'] = 'localhost';
$cfg_mysql['db_nl'] = 'ssi_paneon';

$sql_host = $cfg_mysql['host_nl'];
$sql_user = $cfg_mysql['user_nl'];
$sql_pass = $cfg_mysql['password_nl'];
$sql_db = $cfg_mysql['db_nl'];

$cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
mysqli_select_db ($cfg, $sql_db ) or die ( 'Could not select database ' . $gaSql['db'] );

$GLOBALS['mysqli'] = new mysqli ($sql_host, $sql_user, $sql_pass, $sql_db ) or die ( "Could not open connection to server {$cfg_mysql['server']}" );
//include_once (__DIR__."/../functions.inc");
?>