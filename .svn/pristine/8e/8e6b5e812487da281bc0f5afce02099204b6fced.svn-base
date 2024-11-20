<?php
include_once ('../config.inc.php');
$km_id = $GLOBALS ['mysqli']->real_escape_string ( $_POST ['km_id'] );

$sql = "SELECT km_id,start_point,end_point, km, 
	DATE_FORMAT(km_from, '%d.%m.%Y') km_from,
	DATE_FORMAT(km_from, '%H:%i') km_from_time,
	DATE_FORMAT(km_to, '%d.%m.%Y') km_to,
	DATE_FORMAT(km_to, '%H:%i') km_to_time

 FROM km_list WHERE km_id = '$km_id' ";

$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
$array = mysqli_fetch_array ( $query );

echo "$('#start_point').val('{$array['start_point']}');";
echo "$('#end_point').val('{$array['end_point']}');";
echo "$('#km_from_time').val('{$array['km_from_time']}');";
echo "$('#km_to_time').val('{$array['km_to_time']}');";
echo "$('#km').val('{$array['km']}');";
echo "$('#km_from').focus();";
