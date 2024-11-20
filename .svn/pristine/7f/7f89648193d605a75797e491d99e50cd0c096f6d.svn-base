<?
// Rechnet die Differnzzeit der beiden Werte aus
$start = $_POST ['start'];
$end = $_POST ['end'];

include_once ('../config.inc.php');
$query = $GLOBALS['mysqli']->query ( "SELECT km from km_list WHERE start_point = '$start' AND end_point = '$end' AND user_id = '{$_SESSION['user_id']}' LIMIT 1 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$array = mysqli_fetch_array ( $query );
echo $array ['km'];
?>