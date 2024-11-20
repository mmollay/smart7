<?php
// Call details for list KM

// Aufruf nur bei Neuladen nach Eintrag
if ($_POST['ajax']) {
	include_once ('../config.inc.php');
}

$sql = $GLOBALS['mysqli']->query ( "SELECT
		km_to last_date,
		DATE_FORMAT(km_from, '%d.%m.%Y') km_from,
		DATE_FORMAT(km_from, '%H:%i') km_from_time,
		DATE_FORMAT(km_to, '%d.%m.%Y') km_to,
		DATE_FORMAT(km_to, '%H:%i') km_to_time,
		DATE_FORMAT(km_to+ INTERVAL 3 HOUR, '%H:%i') km_to_time_new,
		(CASE
		WHEN HOUR(TIMEDIFF(km_to,km_from)) >= 3 AND HOUR(TIMEDIFF(km_to,km_from)) < 12 then CONCAT('',HOUR(TIMEDIFF(km_to,km_from)),' Stunden')
		WHEN HOUR(TIMEDIFF(km_to,km_from)) >= 12 then CONCAT('',DATEDIFF(km_to,km_from)+1,' Tag, ', DATEDIFF(km_to,km_from),' Nacht')
		WHEN HOUR(TIMEDIFF(km_to,km_from)) < 3 then CONCAT('unter ',HOUR(TIMEDIFF(km_to,km_from)),' Stunden')
		END) as km_time_text,
		text, `return_point`, start_point, end_point
		FROM km_list WHERE user_id = '{$_SESSION['user_id']}' AND session_open = 0 ORDER by km_id desc Limit 1" );
$array = mysqli_fetch_array ( $sql );
if (! $array[0])
	$array[0] = date ( 'd.m.Y' );
if ($array[0] == '00.00.0000')
	$km_from = $km_to = date ( 'd.m.Y' );
else {
	$km_from = $array['km_to'];
	$km_to = $array['km_to'];
}

if ($array['km_to_time'])
	$km_from_time = $array['km_to_time'];
else
	$km_from_time = "08:00";
if ($array['km_to_time_new'])
	$km_to_time = $array['km_to_time_new'];
else
	$km_to_time = "12:00";
if (! $array['km_to'])
	$km_to = $km_from = date ( 'd.m.Y' );

if ($array['return_point'])
	$add_km_from = "-> {$array['start_point']}";

if ($array['km_from']) {
	$last_km_insert = "
	<div class='ui message'>
	Letzer Eintrag:<br> <b>{$array['text']}</b> {$array['km_time_text']} ({$array['km_from']} <i>{$array['km_from_time']}</i> - {$array['km_to']} <i>{$array['km_to_time']}</i>)<br>
	{$array['start_point']} -> {$array['end_point']} $add_km_from
	</div>
	";
}

if ($_POST['array']) {
	$array2['km_from_time'] = $km_from_time;
	$array2['km_to_time'] = $km_to_time;
	$array2['km_from'] = $km_from;
	$array2['km_to'] = $km_to;
	echo json_encode ( $array2 );
} elseif ($_POST['ajax'])
	echo $last_km_insert;

?>