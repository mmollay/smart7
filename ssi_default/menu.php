<?php
include_once ('config.inc.php');

$array_menu['content_start.php'] = array ( 'Home' , 'home' , 'active' , 'id' =>'home' );
$array_menu['content_list.php'] = array ( 'Liste' , 'list' , '' , 'id' =>'list' );

$array_menu_structure = call_menu_structure ( $array_menu );
$setContent = $array_menu_structure['content'];
$setMenu = $array_menu_structure['menu'];
?>