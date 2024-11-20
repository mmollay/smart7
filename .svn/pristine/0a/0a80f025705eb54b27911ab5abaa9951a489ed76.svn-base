<?php
include ('../../login/config_main.inc.php');
include ('../php_image_magician.php');

foreach ( $_POST as $key => $value ) {
	$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
}

$filename = "{$_SESSION ['HTTP_SERVER_FOLDER']}" . $name;
$size = getimagesize ( $filename );

if (! $direction)
	$direction = 'left';
	
$imageLibObj = new imageLib ( $filename );
$imageLibObj->rotate ( $direction, $color = 'transparent' );
$imageLibObj->saveImage ( $filename );

// THUMBNAIL
$image_thumb_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}thumbnail/$name";

$imageLibObj = new imageLib ( $filename );
$imageLibObj->resizeImage ( 200, 140, 'landscape' );
$imageLibObj->saveImage ( $image_thumb_path );

// Free the memory
include ('../inc/load_file.php');