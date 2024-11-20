<?php
/*
 * Ruft alle Parks auf 
 */
include ("../config.inc.php");

$zip = $_POST['zip']; 

$query = $GLOBALS['mysqli']->query ("SELECT name,place_id FROM tree_places WHERE zip = '$zip' ") or die (mysqli_error());
while ($array = mysqli_fetch_array ($query)) {
	$key  = $array['place_id'];
	//$value = utf8_encode ($array['name']);
	$value = $array['name'];
	$option[] = ['text'=>$value,'value'=>$key];
}

// $array = array ( "1" => 'Esperantoä-Park' , "2" => 'two' , "3" => 'three' );

// foreach ( $array as $key => $value ) {
// 	$option[] = ['text'=>$value,'value'=>$key];
// }

echo json_encode ( $option );