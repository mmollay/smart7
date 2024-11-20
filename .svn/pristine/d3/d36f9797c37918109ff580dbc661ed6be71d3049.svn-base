<?php 
//Functions for this module

//Erzeugt eine array für Dropdown
function call_sql_array($sql) {
	
	$query = $GLOBALS['mysqli']->query ( $sql ) or die(mysqli_error());
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$array2[$array[0]] = $array[1];
	}
	return $array2;
}
