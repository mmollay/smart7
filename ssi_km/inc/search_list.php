<?php
include_once ('../config.inc.php');
$search_text = $GLOBALS ['mysqli']->real_escape_string ( $_GET ['q'] );

$return_arr = array ();
$limit = 10;

if ($_GET ['term'] == 'start')
	$sql = "SELECT km_id,start_point text FROM km_list WHERE start_point LIKE '%$search_text%' AND user_id = '{$_SESSION['user_id']}' ORDER BY km_id desc Limit $limit  ";

else if ($_GET ['term'] == 'end')
	$sql = "SELECT km_id,end_point text FROM km_list WHERE end_point LIKE '%$search_text%' AND user_id = '{$_SESSION['user_id']}' ORDER BY km_id desc  Limit $limit  ";

else if ($_GET ['term'] == 'text')
	$sql = "SELECT km_id,text FROM km_list WHERE text LIKE '%$search_text%' AND user_id = '{$_SESSION['user_id']}' ORDER BY km_id desc Limit $limit  ";

if ($search_text) {
	$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$row_array ['km_id'] = $array ['km_id'];
		// $row_array['title'] = $array['description'];
		$row_array ['description'] = $array ['text'];
		array_push ( $return_arr, $row_array );
	}
}

$arr = array (
	'success' => true,'results' => $return_arr );

echo json_encode ( $arr );