<?php
include_once ('../config.inc.php');

$query = $GLOBALS['mysqli']->query ( "SELECT home_address FROM km_settings WHERE user_id = '{$_SESSION['user_id']}'" );
$array = mysqli_fetch_array ( $query );

echo $array[0];