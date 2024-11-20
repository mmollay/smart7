<?php
/*
 * löscht folder
 */
session_start ();
$dir = $_POST['name'];
if ($_SESSION['user_id'] and $_SESSION['smart_page_id'] and $dir) {
	include ("../function.inc.php");
	
	$folder = $_SESSION['HTTP_SERVER_FOLDER'];
	
	$new_folder = preg_replace ( "/\/\//", "/", "$folder/$dir" );
	
	// Remove Dir
	exec ( "rm -rf $new_folder" );
	echo ChangeTemplate ( "Der Ordner <b>{dir}</b> wurde entfernt!");
} else {
	echo ChangeTemplate ( "Der Ordner <b>{dir}</b> konnte nicht gelöscht werden!");
}

?>