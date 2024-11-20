<?php
require ("../config.inc.php");

$sql = $GLOBALS['mysqli']->query ( "SELECT bill_id from bills" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
while ( $array = mysqli_fetch_array ( $sql ) ) {
	$bill_id = $array [0];
	$GLOBALS['mysqli']->query ( "UPDATE bills SET brutto = ROUND(brutto, 2)" );
}
