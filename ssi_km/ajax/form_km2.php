<?php
include_once ('../config.inc.php');
require ("../function.php");

if ($_SESSION['car_id'] && $_SESSION['user_id']) {
	$return_point = $GLOBALS['mysqli']->real_escape_string ( $_POST['return_point'] );
	$km_id = $GLOBALS['mysqli']->real_escape_string ( $_POST['km_id'] );
	$km_from = date_german2mysql ( $GLOBALS['mysqli']->real_escape_string ( $_POST['km_from'] ) ) . " " . $_POST['km_from_time'];
	// echo $km_from;
	$km_to = date_german2mysql ( $GLOBALS['mysqli']->real_escape_string ( $_POST['km_to'] ) ) . " " . $_POST['km_to_time'];
	$text = $GLOBALS['mysqli']->real_escape_string ( $_POST['text'] );
	$km = $GLOBALS['mysqli']->real_escape_string ( $_POST['km'] );
	$start_point = $GLOBALS['mysqli']->real_escape_string ( $_POST['start_point'] );
	$end_point = $GLOBALS['mysqli']->real_escape_string ( $_POST['end_point'] );
	$country = $GLOBALS['mysqli']->real_escape_string ( $_POST['country'] );
	$commend = $GLOBALS['mysqli']->real_escape_string ( $_POST['commend'] );
	
	$GLOBALS['mysqli']->query ( "REPLACE INTO km_list SET
	km_id     = '$km_id',
	car_id  = '{$_SESSION['car_id']}',
	user_id = '{$_SESSION['user_id']}',
	km_from  = '$km_from',
	km_to = '$km_to',
	text = '$text',
	km = '$km',
	country = '$country',
	`return_point` = '$return_point',
	start_point = '$start_point',
	end_point = '$end_point',
	commend = '$commend'
	" );
	
	if ($km_id)
		echo "update";
	elseif ($_POST['new_data'])
		echo "new_after";
	else
		echo "ok";
} else
	echo "error";
