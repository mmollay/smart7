<?php
include_once ('../config.inc.php');
require ("../function.php");

$home_address = $GLOBALS['mysqli']->real_escape_string ( $_POST ['home_address'] );
$car_nr = $GLOBALS['mysqli']->real_escape_string ( $_POST ['car_nr'] );
$car_id = $GLOBALS['mysqli']->real_escape_string ( $_POST ['car_id'] );
$car_color = $GLOBALS['mysqli']->real_escape_string ( $_POST ['car_color'] );
$vehicle_type = $GLOBALS['mysqli']->real_escape_string ( $_POST ['vehicle_type'] );

$GLOBALS['mysqli']->query ( "REPLACE INTO km_settings SET 
car_id        = '$car_id',
user_id       = '{$_SESSION[user_id]}',
home_address  = '$home_address',
car_nr        = '$car_nr',
car_color     = '$car_color',
vehicle_type  = '$vehicle_type'
" );
echo "ok";