<?php
include_once ('../config.inc.php');

$query = $GLOBALS['mysqli']->query ( "SELECT car_color FROM km_settings WHERE car_id = '{$_SESSION['car_id']}'" );
$array = mysqli_fetch_array ( $query );

echo $array [0];