<?php
include_once ('../config.inc.php');
$text = $_POST['text'];
//$GLOBALS['mysqli']->query ( "SET NAMES 'utf8'" );
// $GLOBALS['mysqli']->query ( "SET CHARACTER SET 'utf8'" );
$query = $GLOBALS['mysqli']->query ( "SELECT end_point FROM km_list WHERE text LIKE '%$text%' AND user_id = '{$_SESSION['user_id']}' GROUP by end_point Limit 1" ) or die ( mysqli_error ($GLOBALS['mysqli']) ); 
$array = mysqli_fetch_array ( $query );
echo $array ['end_point'];
