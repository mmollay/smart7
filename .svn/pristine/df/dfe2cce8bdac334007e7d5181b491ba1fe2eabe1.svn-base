<?php
include_once ('../config.inc.php');

// Es wird das jeweilige Feld uebergeben und der Wert ausgegeben

if ($_POST ['field'] == 'km_from')
	$field = "DATE_FORMAT(km_from, '%m %d, %Y %H:%i:%s') km_from";
else
	$field = $_POST ['field'];
	
	// Es darf immer nur eine Session offen sein im SINGLE Mode
$query = $GLOBALS['mysqli']->query ( "SELECT $field from km_list WHERE user_id = '{$_SESSION['user_id']}' AND session_open = '1' AND car_id = '{$_SESSION['car_id']}'  " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$array = mysqli_fetch_array ( $query );
// Ausgabe 1 oder 0
echo $array [0];