<?php
include (__DIR__.'/../login/config_main.inc.php');

$sql_host = 'localhost';
$sql_user = 'root';
$sql_pass = 'Jgewl21;';
$sql_db = 'panoen';

$cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
mysqli_select_db ($cfg, $sql_db ) or die ( 'Could not select database "' . $sql_db.'"' );

