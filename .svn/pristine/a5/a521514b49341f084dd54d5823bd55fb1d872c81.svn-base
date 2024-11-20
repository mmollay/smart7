<?php	
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

include_once ('config_newsletter.php');
include_once ('functions.inc.php');
/* Einstellungen */
$sql_host = $cfg_mysql['host_nl'];
$sql_user = $cfg_mysql['user_nl'];
$sql_pass = $cfg_mysql['password_nl'];
$sql_db = $cfg_mysql['db_nl'];

$cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
mysqli_select_db ($cfg, $sql_db ) or die ( 'Could not select database ' . $gaSql['db'] );

//$nlSql['link'] = mysql_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
//mysql_select_db ( $sql_db, $nlSql['link'] ) or die ( 'Could not select database ' . $sql_db );

$GLOBALS['mysqli'] = new mysqli ($sql_host, $sql_user, $sql_pass, $sql_db ) or die ( "Could not open connection to server {$cfg_mysql['server']}" );

if (!$_SESSION['user_id']) {
	$query = $GLOBALS['mysqli']->query ( "SELECT user_id FROM  ssi_company.user2company WHERE verify_key = '{$_COOKIE["verify_key"]}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );
	$_SESSION['user_id'] = $array['user_id'];
}

$user_id = $_SESSION['user_id'];

if (! isset ( $_SESSION['user_id'] )) {
	echo "<p>Dauer: " . session_cache_expire () . "</p>\n";
	echo "Session ist abgelaufen, bitte erneut anmelden";
	echo '<script language="javascript">window.top.location.href = "../ssi_dashboard/index.php?session_timeout=true";</script>';
	exit ();
}

// gibt exists zurück
function check_exists($sql) {
	$query = $GLOBALS['mysqli']->query ($sql );
	$count = mysqli_num_rows ( $query );
	if ($count) {
		echo "exists";
		exit ();
	}
}