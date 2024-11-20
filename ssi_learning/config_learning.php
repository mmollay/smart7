<?php
include_once (__DIR__."/../login/config_main.inc.php");
// Max Anzahl der Fragen
$max_choices = '5';
// Anzahl möglicher Blöcke der Fragen
$max_block_nr = '20';

for($bl = 1; $bl <= $max_block_nr; $bl ++) {
	$array_block_nr[$bl] = "Block $bl";
}

//Aufistung - array - Themes
$query = $GLOBALS['mysqli']->query ( "SELECT * from ssi_learning.learn_theme WHERE user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$theme_id = $array['theme_id'];
	$title = $array['title'];
	$array_theme[$theme_id] = $title;
}

//Auflistung - array - Groups
$query = $GLOBALS['mysqli']->query ( "SELECT * from ssi_learning.learn_group WHERE theme_id = '{$_SESSION['theme_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$group_id = $array['group_id'];
	$title = $array['title'];
	$array_group[$group_id] = $title;
}

?>