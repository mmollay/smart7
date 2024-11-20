<?php
include_once ('../config.inc.php');

// Es darf immer nur eine Session offen sein im SINGLE Mode
$query = $GLOBALS['mysqli']->query ( "SELECT COUNT(session_open) from km_list 
		WHERE user_id = '{$_SESSION['user_id']}' 
		AND session_open = '1'  
		AND car_id = '{$_SESSION['car_id']}'
" );
$array = mysqli_fetch_array ( $query );

if ($array ['0'] == 0) {
	$GLOBALS['mysqli']->query ( "INSERT INTO km_list SET
			user_id = '{$_SESSION['user_id']}',
			car_id = '{$_SESSION['car_id']}',
			km_from = NOW(),
			return_point = 1,
			session_open = 1,
			country = '$default_country',
			start_point = '$home_address'
			" );
}

// Es darf immer nur eine Session offen sein im SINGLE Mode
$query = $GLOBALS['mysqli']->query ( "SELECT DATE_FORMAT(km_from, '%m %d, %Y %H:%i:%s') km_from from km_list
		WHERE user_id = '{$_SESSION['user_id']}'
AND car_id = '{$_SESSION['car_id']}'
AND session_open = '1'

" );
$array = mysqli_fetch_array ( $query );
// Ausgabe 1 oder 0
echo $array [0];