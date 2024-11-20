<?php
session_start();
$name = $_POST['name'];

$pathinfo = pathinfo ( $_POST['name'] );
$extension = $pathinfo['extension'];
$image_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}$name";
$image_thumb_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}thumbnail/$name";

if (exif_imagetype ( $image_path )) { 
	//$extension ='img';
	if(!file_exists($image_thumb_path) ) {
		include ('../php_image_magician.php');
		$imageLibObj = new imageLib ( $image_path );
		//$imageLibObj -> resizeImage(200, 200, array('crop', 'm'));
		$imageLibObj->resizeImage ( 200, 140, 'landscape' );
		$imageLibObj->saveImage ( $image_thumb_path );
		$extension = 'img';
	}
};

switch ($extension) {
	
	case 'img':
		$class= "image gray";
		break;
	case 'pdf' :
		$class = "file pdf red outline";
		break;
	case 'zip' :
		$class = "file archive yellow outline";
		break;
	default :
		$class= "file gray";
}

echo "<i class='icon big $class'></i><br><br>";
echo "<div style='overflow:hidden'>$name</div>";