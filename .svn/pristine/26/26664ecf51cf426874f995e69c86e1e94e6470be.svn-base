<?php
include ('../../login/config_main.inc.php');
$user_id = $_SESSION['user_id'];
$page_id = $_SESSION['smart_page_id'];
foreach ( $_POST as $key => $value ) {
	$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
}
// $folder = $_SESSION['FOLDER_PATH_RELATIVE'];
// $folder = $_SESSION['HTTP_HOST_FOLDER'];
$folder = $_SESSION['FOLDER_PATH_RELATIVE'];
$folder_absolute = $_SESSION['HTTP_SERVER_FOLDER'];
$folder_absolute_thumb = $folder_absolute . "thumbnail/";
$image_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}$name";
$image_thumb_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}thumbnail/$name";

// Wenn Bild verkleinert werden muss
if (exif_imagetype ( $image_path )) {
	$size = getimagesize ( $image_path );
	
	include ('../php_image_magician.php');
	
	$imageLibObj = new imageLib ( $image_path );
	
	if ($img_width < $size[0]) { // portrait
		$imageLibObj->resizeImage ( $img_width, $img_height, 2 );
		$generate_thumb = true;
		$length_value = $img_width;
	} elseif ($img_height < $size[1]) { // landcape
		$imageLibObj->resizeImage ( $img_width, $img_height, 1 );
		$generate_thumb = true;
		$length_value = $img_height;
	}
	// Es wird ein neuer Name erzeugt
	if ($new_image and $generate_thumb) {
		$image_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}" . "$length_value" . "_$name";
		$image_thumb_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}thumbnail/" . "$length_value" . "_$name";
	}
	
	if ($generate_thumb)
		$imageLibObj->saveImage ( $image_path );
	
	if (! file_exists ( $image_thumb_path ) or $generate_thumb) {
		// $imageLibObj = new imageLib ( $image_path );
		$imageLibObj->resizeImage ( 140, 140,'landscape' );
		// $imageLibObj->resizeImage ( 120, 100, array ( 'crop' , 'm' ) );
		$imageLibObj->saveImage ( $image_thumb_path );
	}
}

$pathinfo = pathinfo ( $image_path );
$extension = $pathinfo['extension'];
$filename = $pathinfo['filename'];
$name_new = $name_new . "." . $extension;

if ($name != $name_new) {
	exec ( "mv $folder_absolute$name $folder_absolute$name_new" );
	exec ( "mv $folder_absolute_thumb$name $folder_absolute_thumb$name_new" );
}

// Speichern in der Datenbank
$GLOBALS['mysqli']->query ( "REPLACE INTO smart_explorer SET
finder_id = '$finder_id',
title = '$title',
text  = '$text',
link = '$link',
link_intern = '$link_intern',
name  = '$name_new',
folder  = '$folder',
style = '$style',
style_align = '$style_align',
style_width = '$style_width',
user_id = '$user_id',
page_id = '$page_id',
target = '$target'
" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );

echo "ajax_FolderPath(true,'$folder');";
echo "$('#edit_explorer').modal('hide');";

if ($_SESSION['gadget_id'])
	echo "window.parent.reload_element ('{$_SESSION['gadget_id']}');";
