<?php
include ('../mysql.inc');
$session_id = $_POST['session_id'];

// call status
$query = $GLOBALS['mysqli']->query ("SELECT * FROM logfile WHERE email > '' AND  session_id = '$session_id' AND sendet = '1 ' " ) or die (mysqli_error());
$count = mysqli_num_rows ($query); //noch zu versenden

$query = $GLOBALS['mysqli']->query ("SELECT counter FROM session WHERE session_id = '$session_id' ");
$array  = mysqli_fetch_array ($query);
$count_total = $array['counter']; //Gesamt
$count_rest = $count_total - $count; //noch offen

//echo "$('#$session_id".".newsletter-running-rest').html('$count_rest');";
//echo "$('#$session_id".".newsletter-running-send').html('$count');";
echo "$('#$session_id".".progress-status').progress({ total: $count_total, value:$count, text : { active: '{value} von {total}'} });";
if ($count == $count_total) {
	echo "table_reload();";
	//echo "$('.newsletter-running#$session_id').removeClass('orange');";
	//echo "$('.newsletter-running#$session_id').addClass('green');";
}