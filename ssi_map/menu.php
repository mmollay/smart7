<?php
include_once ('config.inc.php');

$array_menu['start.php'] = array ( 'Home' , 'home' , 'active' , 'id' =>'home' );
$array_menu['map.php'] = array ( 'Map' , 'map' , '' , 'id' =>'map' );
$array_menu['list_tree.php'] = array ( 'Bäume' , 'list' , '' , 'id' =>'list_tree' );
$array_menu['list_client.php'] = array ( 'User' , 'users' , '' , 'id' =>'list_client' );
$array_menu['import.php'] = array ( 'Import' , 'upload' , '' , 'id' =>'import' );
$array_menu[] = 'hr';
$array_menu['list_species.php'] = array ( 'Sorten' , 'lemon' , '' , 'id' =>'list_species' );
$array_menu['list_speciesgroup.php'] = array ( 'Gattung/Art' , 'pagelines' , '' , 'id' =>'list_speciesgroup' );
$array_menu['list_family.php'] = array ( 'Planzen-Familien' , 'tree' , '' , 'id' =>'list_family' );
$array_menu['list_taste.php'] = array ( 'Geschmack' , 'arrow right' , '' , 'id' =>'list_taste' );

$array_menu[] = 'hr';
//$array_menu['list_tree.php'] = array ( 'Bäume' , 'lemon' , '' , 'id' =>'list_tree' );
$array_menu['list_loctation.php'] = array ( 'Orte' , 'location arrow' , '' , 'id' =>'list_location' );

$array_menu_structure = call_menu_structure ( $array_menu );
$setContent = $array_menu_structure['content'];
$setMenu = $array_menu_structure['menu'];