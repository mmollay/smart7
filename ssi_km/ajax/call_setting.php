<?php
include_once ('../config.inc.php');

$query = $GLOBALS['mysqli']->query ( "SELECT * FROM km_settings WHERE car_id = '{$_SESSION['car_id']}'" );
$array = mysqli_fetch_array ( $query );

echo json_encode ( $array );

/* JQUERY
 * data = $.parseJSON(data);
   console.log(data[0].response);
 */