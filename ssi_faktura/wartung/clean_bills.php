<?php
require ("../config.inc.php");

$sql = $GLOBALS['mysqli']->query ( "SELECT bill_id from bills" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
while ( $array = mysqli_fetch_array ( $sql ) ) {
	$bill_id = $array [0];
	$GLOBALS['mysqli']->query ( "UPDATE bill_details SET marker =1 WHERE bill_id = $bill_id" );
}

$query = $GLOBALS['mysqli']->query ( "SELECT COUNT(marker) FROM bill_details WHERE marker = 0 " );
$array = mysqli_fetch_array ( $query );

echo $array [0];
