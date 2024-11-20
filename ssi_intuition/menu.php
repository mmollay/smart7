<?php
include_once ('config.inc.php');

$array_menu['content_start.php'] = array ( 'Home' , 'home' , 'active' , 'id' =>'home' );
$array_menu['content_sessions.php'] = array ( 'Sessions' , 'list' , '' , 'id' =>'session' );
$array_menu['content_user.php'] = array ( 'User' , 'users' , '' , 'id' =>'user' );
$array_menu['content_user2session.php'] = array ( 'User2Session' , 'exchange alternate' , '' , 'id' =>'user2session' );
$array_menu['content_demouser.php'] = array ( 'DemoUser' , 'user' , '' , 'id' =>'demouser' );

$array_menu_structure = call_menu_structure ( $array_menu );
$setContent = $array_menu_structure['content'];
$setMenu = $array_menu_structure['menu'];
?>